<?php
require_once '../config/Conection.php';

$conn = new Connection();
$pdo = $conn->connect();

echo "Conexión exitosa";
