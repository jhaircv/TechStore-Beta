<?php
include(__DIR__ . "/config/db.php");

// Lee el archivo JSON
$json = file_get_contents(__DIR__ . '/products.json');
$productos = json_decode($json, true);

if ($productos && is_array($productos)) {
    foreach ($productos as $p) {
        $nombre = $p['nombre'];
        $categoria = $p['categoria'];
        $precio = $p['precio'];
        $marca = isset($p['marca']) ? $p['marca'] : null;
        $imagen = isset($p['imagen']) ? $p['imagen'] : null;
        $descripcion = isset($p['descripcion']) ? $p['descripcion'] : null;
        $sql = "INSERT INTO productos (nombre, categoria, precio, marca, imagen, descripcion) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare: " . $conexion->error . " | SQL: " . $sql);
        }
        $stmt->bind_param("ssdsss", $nombre, $categoria, $precio, $marca, $imagen, $descripcion);
        $stmt->execute();
        $stmt->close();
    }
    echo "Productos migrados correctamente.";
} else {
    echo "No se pudo leer el archivo products.json o está vacío.";
}
?>