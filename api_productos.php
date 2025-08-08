<?php
include(__DIR__ . "/config/db.php");

$result = $conexion->query("SELECT id, nombre, categoria, descripcion, marca, precio, imagen, imagen2, imagen3 FROM productos ORDER BY id DESC");
$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}
header('Content-Type: application/json');
echo json_encode($productos);
?>