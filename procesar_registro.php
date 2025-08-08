<?php
include(__DIR__ . "/config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $usuario = trim(strtolower($_POST['usuario']));
    $email = trim(strtolower($_POST['email']));
    $contrasena = $_POST['contrasena'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $rol = 'cliente';

    // Verificar si ya existe el usuario o el email
    $verificar = $conexion->prepare("SELECT id FROM usuarios WHERE username = ? OR email = ?");
    $verificar->bind_param("ss", $usuario, $email);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        echo "<script>alert('El nombre de usuario o el correo electrónico ya están registrados.'); window.location='registro.php';</script>";
    } else {
        // Hashear la contraseña antes de guardar
        $password_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar nuevo usuario
        $stmt = $conexion->prepare("INSERT INTO usuarios (username, nombre, email, password, fecha_nacimiento, genero, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $usuario, $nombre, $email, $password_hash, $fecha_nacimiento, $genero, $rol);
        $stmt->execute();

        echo "<script>alert('Cuenta registrada correctamente'); window.location='login.php';</script>";
    }
}
?>