<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

// Verifica el rol del usuario
if ($_SESSION['role_id'] !== 3) {
    echo "Acceso denegado. Solo los administradores pueden acceder a esta página.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once "../Vistas/dependencias.php"; ?>
</head>

<body>

    <?php require_once "../Vistas/menucliente.php"; ?>

    <div class="main">
        <h1>Bienvenido Cliente</h1>
        <div class="card">
            <h3>Resumen de Actividades</h3>
            <p>Aquí puedes buscar las cajas.</p>
        </div>

        <div class="card">
            <h3>Recolecion de cajas </h3>
            <p>Consulta las cajas que necesita de vuelta.</p>
        </div>
    </div>


</body>

</html>