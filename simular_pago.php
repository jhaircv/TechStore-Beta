<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $numero = preg_replace('/\s+/', '', $data['numero'] ?? ''); // Elimina espacios
    $cvv = trim($data['cvv'] ?? '');

    // Tarjeta de prueba Stripe: 4242 4242 4242 4242, CVV: 123
    if ($numero === '4242424242424242' && $cvv === '123') {
        echo json_encode(['status' => 'success', 'message' => 'Pago simulado exitosamente.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tarjeta inválida para pruebas. Usa 4242 4242 4242 4242 y CVV 123.']);
    }
    exit;
}
?>