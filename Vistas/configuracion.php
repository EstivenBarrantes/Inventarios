<?php
session_start();
require_once '../config/Conection.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

// Obtener la información del usuario
try {
    $connection = new Connection();
    $pdo = $connection->connect();

    $stmt = $pdo->prepare("SELECT username FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al conectarse a la base de datos: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['change_password'])) {
        // Cambio de contraseña
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password === $confirm_password) {
            // Verificar la contraseña actual
            $stmt = $pdo->prepare("SELECT password FROM usuarios WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($old_password, $user['password'])) {
                // Actualizar la contraseña
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
                $stmt->execute([$new_password_hash, $_SESSION['user_id']]);

                echo "Contraseña actualizada correctamente.";
            } else {
                echo "La contraseña actual no es correcta.";
            }
        } else {
            echo "Las contraseñas no coinciden.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Usuario</title>
    <?php require_once "dependencias.php" ?>
</head>

<body>
    <?php require_once "../Vistas/menu.php" ?>

    <div class="main-content">
        <div class="container">
            <h1>Configuración de Usuario</h1>

            <!-- Cambiar contraseña -->
            <form method="POST">
                <h2>Cambiar Contraseña</h2>
                <label for="old_password">Contraseña Actual:</label>
                <input type="password" name="old_password" id="old_password" required>

                <label for="new_password">Nueva Contraseña:</label>
                <input type="password" name="new_password" id="new_password" required>

                <label for="confirm_password">Confirmar Contraseña:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>

                <button type="submit" name="change_password">Actualizar Contraseña</button>
            </form>

        </div>
    </div>

</body>

</html>