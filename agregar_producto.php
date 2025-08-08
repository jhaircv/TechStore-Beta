<?php
include 'conexion.php';

$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$imagen = $_POST['imagen'];

$sql = "INSERT INTO productos (nombre, categoria, descripcion, precio, imagen)
        VALUES ('$nombre', '$categoria', '$descripcion', '$precio', '$imagen')";

if ($conexion->query($sql)) {
  echo "ok";
} else {
  echo "error";
}
?>
