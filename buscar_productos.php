<?php
require_once 'config/db.php'; // Ajusta la ruta si es necesario

$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';
$resultados = [];

if ($busqueda !== '') {
    $stmt = $conexion->prepare("SELECT id, nombre, marca, categoria, precio, descripcion, imagen, imagen2, imagen3 FROM productos WHERE nombre LIKE CONCAT('%', ?, '%') OR marca LIKE CONCAT('%', ?, '%') OR categoria LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("sss", $busqueda, $busqueda, $busqueda);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
    $resultados[] = [
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'categoria' => $row['categoria'],
        'descripcion' => $row['descripcion'],
        'marca' => $row['marca'],
        'precio' => $row['precio'],
        'imagen' => $row['imagen'],
        'imagen2' => $row['imagen2'],
        'imagen3' => $row['imagen3'],
    ];
}
}

header('Content-Type: application/json');
echo json_encode($resultados);