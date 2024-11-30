<?php
require_once '../config/Conection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role_id = intval($_POST['role_id']);

    try {
        $connection = new Connection();
        $pdo = $connection->connect();

        // Verificar si el usuario ya existe
        $sqlCheck = "SELECT COUNT(*) FROM usuarios WHERE username = :username";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute(['username' => $username]);
        $userExists = $stmtCheck->fetchColumn();

        if ($userExists > 0) {
            echo "<script>
                alert('El nombre de usuario ya existe.');
                window.history.back();
            </script>";
            exit();
        }

        // Encriptar la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insertar el nuevo usuario
        $sqlInsert = "INSERT INTO usuarios (username, password, role_id) VALUES (:username, :password, :role_id)";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([
            'username' => $username,
            'password' => $hashedPassword,
            'role_id' => $role_id
        ]);

        // Redirigir a index.php
        header('Location: ../index.php');
        exit();
    } catch (\PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
