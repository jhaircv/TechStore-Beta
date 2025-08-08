<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo "No autenticado";
    exit;
}
require_once __DIR__ . "/config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['carrito']) || !is_array($data['carrito'])) {
    http_response_code(400);
    echo "Datos de carrito inválidos";
    exit;
}

$username = $_SESSION['usuario'];
$carrito = $data['carrito'];
$total = 0;
$productos_pedido = [];

foreach ($carrito as $item) {
    if (isset($item['id']) && isset($item['cantidad'])) {
        $id = intval($item['id']);
        $cantidad = intval($item['cantidad']);
        
        // Obtener precio desde la BD para seguridad
        $res = $conexion->query("SELECT precio, nombre FROM productos WHERE id = $id");
        if ($prod_db = $res->fetch_assoc()) {
            $total += $prod_db['precio'] * $cantidad;
            $productos_pedido[] = [
                'id' => $id,
                'nombre' => $prod_db['nombre'],
                'cantidad' => $cantidad,
                'precio_unitario' => $prod_db['precio']
            ];
        }
    }
}

if ($total <= 0) {
    http_response_code(400);
    echo "El carrito está vacío o los productos no son válidos.";
    exit;
}

$fecha = date('Y-m-d H:i:s');
$productos_json = json_encode($productos_pedido);

$stmt = $conexion->prepare("INSERT INTO pedidos (username, productos, total, fecha) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssds", $username, $productos_json, $total, $fecha);

if ($stmt->execute()) {
    echo "Pedido registrado exitosamente.";
} else {
    http_response_code(500);
    echo "Error al registrar el pedido: " . $conexion->error;
}
$stmt->close();
?>