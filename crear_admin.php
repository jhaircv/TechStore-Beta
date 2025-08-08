<?php
include 'config/db.php';

// Verificar si ya existe un admin
$sql = "SELECT COUNT(*) as total FROM usuarios WHERE role = 'admin'";
$result = $conexion->query($sql);

if (!$result) {
    die('Error en la consulta: ' . $conexion->error);
}

$row = $result->fetch_assoc();

if ($row['total'] > 0) {
    echo '<h2>El usuario administrador ya ha sido creado.</h2>';
    exit;
}

// Crear admin automáticamente con usuario y password fijos
$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$sql = "INSERT INTO usuarios (username, password, role) VALUES ('$username', '$password', 'admin')";
if ($conexion->query($sql) === TRUE) {
    echo '<h2>Administrador creado exitosamente.</h2>';
    exit;
} else {
    echo '<h2>Error al crear el administrador: ' . $conexion->error . '</h2>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Administrador</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Crear usuario administrador</h2>
    <form method="POST">
        <label>Usuario:</label>
        <input type="text" name="username" required><br>
        <label>Contraseña:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Crear Admin</button>
    </form>
</body>
</html>
