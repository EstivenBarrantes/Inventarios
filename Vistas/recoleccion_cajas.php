<?php
require_once '../config/Conection.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

// Obtén las IDs seleccionadas desde la URL
$ids = isset($_GET['ids']) ? explode(',', $_GET['ids']) : [];

if (empty($ids)) {
    die("No se seleccionaron cajas.");
}

try {
    $connection = new Connection();
    $pdo = $connection->connect();

    // Prepara la consulta para obtener los datos de las cajas seleccionadas
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "SELECT 
            i.id_caja, 
            i.empresa, 
            i.tipo_caja, 
            i.descripcion, 
            c.nombre_categoria AS categoria, 
            i.ubicacion 
        FROM inventario i
        JOIN categorias c ON i.categoria_id = c.id
        WHERE i.id_caja IN ($placeholders)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($ids);
    $cajas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al conectarse a la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once "dependencias.php"; ?>
</head>

<body>
    <?php require_once "../Vistas/menu.php"; ?>

    <div class="main-content">
        <div class="container">
            <h1>Recolección de Cajas</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID Caja</th>
                        <th>Empresa</th>
                        <th>Tipo de Caja</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Ubicación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cajas as $caja): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($caja['id_caja']); ?></td>
                            <td><?php echo htmlspecialchars($caja['empresa']); ?></td>
                            <td><?php echo htmlspecialchars($caja['tipo_caja']); ?></td>
                            <td><?php echo htmlspecialchars($caja['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($caja['categoria']); ?></td>
                            <td><?php echo htmlspecialchars($caja['ubicacion']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Botón para generar PDF -->
            <form action="generar_pdf.php" method="POST">
                <input type="hidden" name="ids" value="<?php echo htmlspecialchars(implode(',', $ids)); ?>">
                <button type="submit" style="margin-top: 20px; padding: 10px 20px; background-color: #007BFF; color: white; border: none; cursor: pointer;">
                    Generar PDF
                </button>
            </form>
        </div>
    </div>
</body>

</html>