<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

// Verifica el rol del usuario
if ($_SESSION['role_id'] !== 1) {
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

    <?php require_once "../Vistas/menu.php"; ?>

    <div class="main">
        <h1>Bienvenido Administrador</h1>
        <div class="card">
            <h3>Resumen de Actividades</h3>
            <p>Aquí puedes ver un resumen de tus actividades recientes.</p>
        </div>
        <div class="card">
            <h3>Estadísticas Recientes</h3>
            <p>Visualiza las estadísticas más recientes aquí.</p>
        </div>
        <div class="card">
            <h3>Informes Generales</h3>
            <p>Consulta los informes generales de tu sistema.</p>
        </div>
    </div>
</body>

</html>