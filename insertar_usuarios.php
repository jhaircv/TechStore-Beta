<?php
include 'conexion.php';

// Usuarios a insertar
$usuarios = [
    ['username' => 'cliente1', 'password' => '123', 'role' => 'cliente'],
    ['username' => 'admin1', 'password' => 'admin1234', 'role' => 'admin']
];

foreach ($usuarios as $u) {
    // Hashear la contraseña
    $hashedPassword = password_hash($u['password'], PASSWORD_DEFAULT);

    // Preparar consulta
    $stmt = $conexion->prepare("INSERT INTO usuarios (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $u['username'], $hashedPassword, $u['role']);

    if ($stmt->execute()) {
        echo "Usuario '{$u['username']}' insertado correctamente.<br>";
    } else {
        echo "Error al insertar '{$u['username']}': " . $stmt->error . "<br>";
    }
}
?>
