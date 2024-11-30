<?php
require_once '../config/Conection.php';
require_once '../fpdf/fpdf.php';

if (!isset($_POST['ids'])) {
    die("No se seleccionaron cajas.");
}

$ids = explode(',', $_POST['ids']);

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

// Generar PDF con FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Logo
$pdf->Image('../imagenes/1.png', 10, 10, 30);
$pdf->Ln(20);

// Título
$pdf->Cell(0, 10, 'Cajas Recolectadas', 0, 1, 'C');
$pdf->Ln(10);

// Tabla
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(20, 10, 'ID', 1);
$pdf->Cell(50, 10, 'Empresa', 1);
$pdf->Cell(40, 10, 'Tipo', 1);
$pdf->Cell(50, 10, 'Descripcion', 1);
$pdf->Cell(30, 10, 'Categoria', 1);
$pdf->Ln();

foreach ($cajas as $caja) {
    $pdf->Cell(20, 10, $caja['id_caja'], 1);
    $pdf->Cell(50, 10, $caja['empresa'], 1);
    $pdf->Cell(40, 10, $caja['tipo_caja'], 1);
    $pdf->Cell(50, 10, $caja['descripcion'], 1);
    $pdf->Cell(30, 10, $caja['categoria'], 1);
    $pdf->Ln();
}

// Descargar PDF
$pdf->Output('D', 'Cajas_Recolectadas.pdf');
