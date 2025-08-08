<?php
include "config/db.php";

$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$precio = $_POST['precio'];
$descripcion = $_POST['descripcion'];

$sql = "INSERT INTO productos (nombre, categoria, precio, descripcion)
        VALUES ('$nombre', '$categoria', '$precio', '$descripcion')";

if ($conn->query($sql) === TRUE) {
  echo "ok";
} else {
  echo "error";
}
?>
