<?php
// Conexión a la base de datos
require_once '../config/Conection.php';
$connection = new Connection();
$pdo = $connection->connect();

// Inicialización de mensajes
$message = "";

// Agregar al inventario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $empresa = htmlspecialchars(trim($_POST['empresa']));
    $tipo_caja = htmlspecialchars(trim($_POST['tipo_caja']));
    $descripcion = htmlspecialchars(trim($_POST['descripcion']));
    $categoria = (int) $_POST['categoria_id'];
    $ubicacion = htmlspecialchars(trim($_POST['ubicacion']));

    $sql = "INSERT INTO inventario (empresa, tipo_caja, descripcion, categoria_id, ubicacion) 
            VALUES (:empresa, :tipo_caja, :descripcion, :categoria_id, :ubicacion)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([
        'empresa' => $empresa,
        'tipo_caja' => $tipo_caja,
        'descripcion' => $descripcion,
        'categoria_id' => $categoria,
        'ubicacion' => $ubicacion
    ])) {
        $message = "Elemento agregado exitosamente.";
    } else {
        $message = "Error al agregar el elemento.";
    }
}

// Eliminar del inventario
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    $sql = "DELETE FROM inventario WHERE id_caja = :id";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute(['id' => $delete_id])) {
        $message = "Elemento eliminado exitosamente.";
    } else {
        $message = "Error al eliminar el elemento.";
    }
}

// Obtener todos los registros del inventario
$sql = "SELECT 
            i.id_caja, 
            i.empresa, 
            i.tipo_caja, 
            i.descripcion, 
            c.nombre_categoria AS categoria, 
            i.ubicacion 
        FROM inventario i
        JOIN categorias c ON i.categoria_id = c.id";
$stmt = $pdo->query($sql);
$inventarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener categorías para el formulario
$sql = "SELECT * FROM categorias";
$stmt = $pdo->query($sql);
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once "dependencias.php" ?>

</head>

<body>

    <?php require_once "../Vistas/menu.php" ?>

    <div class="container">
        <h1>Gestión de Inventario</h1>

        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <!-- Formulario para agregar elementos -->
        <form method="POST">
            <h2>Agregar Elemento al Inventario</h2>
            <input type="text" name="empresa" placeholder="Empresa" required>
            <input type="text" name="tipo_caja" placeholder="Tipo de Caja" required>
            <textarea name="descripcion" placeholder="Descripción" required></textarea>
            <select name="categoria_id" required>
                <option value="">Selecciona una Categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria['id']; ?>">
                        <?php echo htmlspecialchars($categoria['nombre_categoria']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="ubicacion" placeholder="Ubicación" required>
            <button type="submit" name="add_item">Agregar</button>
        </form>

        <!-- Tabla de inventario -->
        <table>
            <thead>
                <tr>
                    <th>ID Caja</th>
                    <th>Empresa</th>
                    <th>Tipo de Caja</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Ubicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventarios as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['id_caja']); ?></td>
                        <td><?php echo htmlspecialchars($item['empresa']); ?></td>
                        <td><?php echo htmlspecialchars($item['tipo_caja']); ?></td>
                        <td><?php echo htmlspecialchars($item['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($item['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($item['ubicacion']); ?></td>
                        <td>
                            <a href="?delete_id=<?php echo $item['id_caja']; ?>" class="delete-button">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>