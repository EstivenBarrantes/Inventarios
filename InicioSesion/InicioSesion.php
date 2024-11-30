<?php
require_once '../config/Conection.php';
session_start([
    'cookie_httponly' => true,
    'use_strict_mode' => true,
    'cookie_secure' => false,
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    try {
        $connection = new Connection();
        $pdo = $connection->connect();

        $sql = "SELECT * FROM usuarios WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role_id'];

            switch ($user['role_id']) {
                case 1: // Admin
                    header('Location: ../Home/dashboard.php');
                    break;
                case 3: // Usuario
                    header('Location: ../Home/dashboardCliente.php');
                    break;
                default:
                    echo 'Acceso Denegado';
            }
            exit();
        } else {
            $error_message = 'Credenciales incorrectas';
        }
    } catch (\PDOException $e) {
        $error_message = "Hubo un problema con la base de datos. Por favor, inténtalo más tarde.";
    }
}

if (isset($error_message)) {
    echo $error_message;
}
