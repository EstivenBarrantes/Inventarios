<?php
require_once '../config/Conection.php';
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

try {
    $connection = new Connection();
    $pdo = $connection->connect();

    // Consulta para obtener los datos de la tabla inventario con la categoría
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
} catch (PDOException $e) {
    die("Error al conectarse a la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once "dependencias.php" ?>
    <script>
        // Función para filtrar la tabla de cajas
        function buscarCajas() {
            const input = document.getElementById("buscar");
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll("#tabla-inventario tbody tr");

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        }

        // Función para manejar la selección de cajas y redirigir
        function recolectarCajas() {
            const checkboxes = document.querySelectorAll("input[name='seleccionar_caja']:checked");
            const seleccionadas = Array.from(checkboxes).map(checkbox => checkbox.value);

            if (seleccionadas.length === 0) {
                alert("Por favor, selecciona al menos una caja.");
                return;
            }

            // Redirige a la página de recolección de cajas con las IDs seleccionadas
            window.location.href = `recoleccion_cajas.cliente.php?ids=${seleccionadas.join(",")}`;
        }
    </script>
</head>

<body>
    <?php require_once "../Vistas/menucliente.php" ?>

    <!-- Contenido principal -->
    <div class="main-content">
        <div class="container">
            <h1>Inventario</h1>

            <!-- Buscador -->
            <div>
                <input type="text" id="buscar" placeholder="Buscar cajas..." onkeyup="buscarCajas()" style="width: 100%; padding: 10px; margin-bottom: 20px;">
            </div>

            <!-- Botón para recolectar 
            <button onclick="recolectarCajas()" style="margin-bottom: 20px; padding: 10px 20px; background-color: #007BFF; color: white; border: none; cursor: pointer;">
                Recolectar cajas seleccionadas
            </button> -->


            <button onclick="recolectarCajas()" style="margin-bottom: 20px; padding: 10px 20px; background-color: #007BFF; color: white; border: none; cursor: pointer;">
                Recolectar cajas seleccionadas
            </button>

            <script>
                function recolectarCajas() {
                    const checkboxes = document.querySelectorAll("input[name='seleccionar_caja']:checked");
                    const seleccionadas = Array.from(checkboxes).map(checkbox => checkbox.value);

                    if (seleccionadas.length === 0) {
                        alert("Por favor, selecciona al menos una caja.");
                        return;
                    }

                    // Redirige a la página de recolección de cajas con las IDs seleccionadas
                    window.location.href = `recoleccion_cajas.cliente.php?ids=${seleccionadas.join(",")}`;
                }
            </script>


            <table id="tabla-inventario">
                <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>ID Caja</th>
                        <th>Empresa</th>
                        <th>Tipo de Caja</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Ubicación</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se generan dinámicamente las filas -->
                    <?php foreach ($inventarios as $item): ?>
                        <tr>
                            <td><input type="checkbox" name="seleccionar_caja" value="<?php echo $item['id_caja']; ?>"></td>
                            <td><?php echo htmlspecialchars($item['id_caja']); ?></td>
                            <td><?php echo htmlspecialchars($item['empresa']); ?></td>
                            <td><?php echo htmlspecialchars($item['tipo_caja']); ?></td>
                            <td><?php echo htmlspecialchars($item['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($item['categoria']); ?></td>
                            <td><?php echo htmlspecialchars($item['ubicacion']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="footer">
                &copy; 2024 Sistema de Inventarios
            </div>
        </div>
    </div>
</body>

</html>