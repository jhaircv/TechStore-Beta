<?php
session_start();
require_once __DIR__ . "/config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    // Buscar usuario por username
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos_usuario = $result->fetch_assoc();
    $stmt->close();

    if ($datos_usuario && password_verify($contrasena, $datos_usuario['password'])) {
        $_SESSION['usuario'] = $datos_usuario['username'];
        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}
?>
