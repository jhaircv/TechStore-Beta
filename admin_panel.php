<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit();
}
require_once __DIR__ . "/config/db.php";

// --- Lógica PHP: CRUD productos, usuarios, pedidos ---

$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nuevo_producto'])) {
  $nombre = trim($_POST['nombre']);
  $categoria = trim($_POST['categoria']);
  $descripcion = trim($_POST['descripcion']);
  $marca = trim($_POST['marca']);
  $precio = floatval($_POST['precio']);
  $imagen = trim($_POST['imagen']);
  $imagen2 = isset($_POST['imagen2']) ? trim($_POST['imagen2']) : '';
  $imagen3 = isset($_POST['imagen3']) ? trim($_POST['imagen3']) : '';
  if ($nombre && $categoria && $precio > 0 && $marca && $imagen) {
    $stmt = $conexion->prepare("INSERT INTO productos (nombre, categoria, descripcion, marca, precio, imagen, imagen2, imagen3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdsss", $nombre, $categoria, $descripcion, $marca, $precio, $imagen, $imagen2, $imagen3);
    if ($stmt->execute()) {
      $mensaje = "Producto añadido correctamente.";
    } else {
      $mensaje = "Error al añadir producto.";
    }
    $stmt->close();
  } else {
    $mensaje = "Todos los campos son obligatorios y el precio debe ser mayor a 0.";
  }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['actualizar_stock'])) {
    $id = intval($_POST['producto_id']);
    $nuevo_stock = intval($_POST['nuevo_stock']);
    $conexion->query("UPDATE productos SET stock = $nuevo_stock WHERE id = $id");
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['actualizar_campo'])) {
    $id = intval($_POST['producto_id']);
    $campo = $_POST['campo'];
    $nuevo_valor = $_POST['nuevo_valor'];
    $campos_validos = ['nombre', 'categoria', 'descripcion', 'marca', 'precio'];
    if (in_array($campo, $campos_validos)) {
        if ($campo === 'precio') {
            $nuevo_valor = floatval($nuevo_valor);
            $stmt = $conexion->prepare("UPDATE productos SET precio = ? WHERE id = ?");
            $stmt->bind_param("di", $nuevo_valor, $id);
        } else {
            $stmt = $conexion->prepare("UPDATE productos SET $campo = ? WHERE id = ?");
            $stmt->bind_param("si", $nuevo_valor, $id);
        }
        $stmt->execute();
        $stmt->close();
        exit;
    }
}

// Eliminar producto
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
  $idEliminar = intval($_GET['eliminar']);
  $stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
  $stmt->bind_param("i", $idEliminar);
  if ($stmt->execute()) {
    $mensaje = "Producto eliminado correctamente.";
  } else {
    $mensaje = "Error al eliminar producto.";
  }
  $stmt->close();
}

// Eliminar usuario (excepto admin)
if (isset($_POST['eliminar_usuario']) && is_numeric($_POST['eliminar_usuario'])) {
  $idEliminarUsuario = intval($_POST['eliminar_usuario']);
  $res = $conexion->query("SELECT role FROM usuarios WHERE id = $idEliminarUsuario");
  $row = $res ? $res->fetch_assoc() : null;
  if ($row && $row['role'] !== 'admin') {
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $idEliminarUsuario);
    if ($stmt->execute()) {
      $mensaje = "Cuenta eliminada correctamente.";
    } else {
      $mensaje = "Error al eliminar la cuenta.";
    }
    $stmt->close();
  }
}

// Obtener productos, usuarios, pedidos, categorías y marcas
$result = $conexion->query("SELECT id, nombre, categoria, descripcion, marca, precio, stock, imagen, imagen2, imagen3 FROM productos ORDER BY id DESC");
if (!$result) {
    die("Error en la consulta de productos: " . $conexion->error);
}
$productos = $result->fetch_all(MYSQLI_ASSOC);
$usuarios = $conexion->query("SELECT id, username, role FROM usuarios ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
$pedidos = [];
if ($conexion->query("SHOW TABLES LIKE 'pedidos'")->num_rows > 0) {
  $pedidos = $conexion->query("SELECT * FROM pedidos ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
}
$categorias = [];
$marcas = [];
$resCat = $conexion->query("SELECT DISTINCT categoria FROM productos");
while ($row = $resCat->fetch_assoc()) {
  if ($row['categoria']) $categorias[] = $row['categoria'];
}
$resMar = $conexion->query("SELECT DISTINCT marca FROM productos");
while ($row = $resMar->fetch_assoc()) {
  if ($row['marca']) $marcas[] = $row['marca'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Administrador - TechStore+</title>
  <link rel="stylesheet" href="css/style.css">
<style>
/* -- Estilos Generales y Colores Base -- */
/* Paleta de colores:
   Base Oscura: #0F2027, #182730, #203A43, #223040, #2C5364
   Azul Cían Principal: #00e6ff
   Azul Secundario/Claro: #2e86de
   Texto Claro: #e0f7fa
   Rojo para acciones negativas: #ff4d4d, #cc0000
*/

body {
    background: linear-gradient(135deg, #0F2027 0%, #203A43 50%, #2C5364 100%);
    color: #e0f7fa;
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 0;
    min-height: 100vh;
    display: flex;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* -- Sidebar (Barra Lateral de Navegación) -- */
.sidebar {
    width: 230px;
    background: #182730;
    border-right: 1px solid #00e6ff33;
    box-shadow: 2px 0 15px rgba(0, 230, 255, 0.1);
    min-height: 100vh;
    padding: 0 0 24px 0;
    display: flex;
    flex-direction: column;
    align-items: stretch;
    transition: width 0.3s ease;
}

.sidebar h2 {
    color: #00e6ff;
    text-align: center;
    margin: 24px 0 18px 0;
    font-size: 1.4rem;
    letter-spacing: 1.5px;
    font-weight: 600;
    cursor: pointer;
    text-transform: uppercase;
    text-shadow: 0 0 8px rgba(0, 230, 255, 0.4);
}

.sidebar nav {
    display: flex;
    flex-direction: column;
    gap: 5px; /* Espacio más ajustado entre elementos del menú principal */
    margin: 0 18px;
}

.sidebar nav .menu-group {
    position: relative;
    margin-bottom: 0; /* No hay margen inferior extra en el grupo */
}

.sidebar nav .menu-main {
    color: #e0f7fa;
    background: #223040;
    border-radius: 8px;
    padding: 12px 18px;
    text-decoration: none;
    font-weight: 500;
    display: flex; /* Usamos flex para alinear contenido (texto e ícono si lo añades) */
    align-items: center;
    justify-content: space-between; /* Espacio entre texto y posible ícono de flecha */
    border: 1.5px solid #00e6ff22;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease, transform 0.1s ease;
}

.sidebar nav .menu-main.active,
.sidebar nav .menu-main:hover {
    background: #00e6ff;
    color: #182730;
    border-color: #00e6ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 230, 255, 0.3);
}

.sidebar nav .logout-btn {
    margin: 30px 18px 0 18px;
    background: linear-gradient(90deg, #ff4d4d 0%, #cc0000 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px 0;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    transition: background 0.3s ease, transform 0.1s ease;
    font-size: 1.05rem;
    display: block;
    box-shadow: 0 4px 10px rgba(255, 77, 77, 0.3);
}

.sidebar nav .logout-btn:hover {
    background: linear-gradient(90deg, #cc0000 0%, #ff4d4d 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(255, 77, 77, 0.4);
}

/* --- NUEVO ESTILO: Menús Desplegables de la Sidebar (Submenus) --- */
.sidebar nav .submenu {
    display: none; /* Oculto por defecto */
    flex-direction: column;
    /* Posicionamiento relativo para que aparezca JUSTO DEBAJO del elemento padre del menú */
    position: relative;
    width: 100%; /* Ocupa el ancho del padre */
    margin-top: -5px; /* Superponer ligeramente con el elemento padre */
    background: #20303f; /* Un tono ligeramente diferente para el submenú */
    border-radius: 0 0 8px 8px; /* Solo redondeado en la parte inferior */
    box-shadow: 0 8px 20px rgba(0, 230, 255, 0.1);
    z-index: 9; /* Ligeramente por debajo del menú principal */
    overflow: hidden; /* Para el border-radius */
    max-height: 0; /* Para el efecto de despliegue */
    opacity: 0; /* Para el efecto de fade */
    transition: max-height 0.4s ease-out, opacity 0.4s ease-out; /* Transición para despliegue */
}

/* Mostrar submenu al pasar el cursor sobre el menu-group */
.sidebar nav .menu-group:hover .submenu,
.sidebar nav .menu-group:focus-within .submenu {
    display: flex; /* O 'block' si no usas flexbox interno */
    max-height: 200px; /* Suficientemente grande para contener los ítems */
    opacity: 1;
}

.sidebar nav .submenu a {
    color: #a0eaff; /* Un azul cian más claro para los ítems del submenú */
    padding: 10px 25px; /* Más padding para indentar un poco */
    text-decoration: none;
    font-weight: 400; /* Texto más ligero */
    display: block;
    border-bottom: 1px solid #00e6ff10; /* Borde más sutil */
    transition: background 0.2s ease, color 0.2s ease;
    font-size: 0.95rem;
    box-sizing: border-box;
}

.sidebar nav .submenu a:last-child {
    border-bottom: none;
}

.sidebar nav .submenu a:hover,
.sidebar nav .submenu a.active {
    background: #00e6ff18; /* Tono de fondo al hover */
    color: #fff;
    font-weight: 500;
}

/* --- Dropdowns Generales (si los usas fuera de la sidebar) --- */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none; /* Oculto por defecto */
    position: absolute;
    background-color: #1f303d;
    min-width: 190px;
    box-shadow: 0px 8px 20px 0px rgba(0,0,0,0.4);
    z-index: 100;
    border-radius: 8px;
    overflow: hidden;
    left: 0; /* Posicionar justo debajo del botón/elemento padre */
    top: 100%; /* Justo debajo */
    margin-top: 5px; /* Pequeño espacio */
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px); /* Desplazamiento hacia abajo al aparecer */
    transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
}

.dropdown:hover .dropdown-content {
    display: block;
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-content a {
    color: #e0f7fa;
    padding: 12px 18px;
    text-decoration: none;
    display: block;
    font-size: 0.95rem;
    border-bottom: 1px solid rgba(0, 230, 255, 0.08);
    transition: background-color 0.2s ease, color 0.2s ease;
    box-sizing: border-box;
}

.dropdown-content a:last-child {
    border-bottom: none;
}

.dropdown-content a:hover {
    background-color: #00e6ff;
    color: #182730;
    font-weight: bold;
}


/* -- Contenido Principal (Main Content) -- */
.main-content {
    flex: 1;
    max-width: 1100px;
    margin: 20px auto;
    background: rgba(34, 48, 64, 0.96);
    border-radius: 18px;
    box-shadow: 0 6px 30px rgba(0, 230, 255, 0.15);
    padding: 32px 32px 24px 32px;
    min-height: calc(100vh - 40px);
    display: flex;
    flex-direction: column;
}

h2, h3 {
    color: #00e6ff;
    margin-bottom: 20px;
    letter-spacing: 1.2px;
    text-shadow: 0 0 5px rgba(0, 230, 255, 0.2);
    font-weight: 600;
}

.mensaje {
    background: #223040;
    color: #00e6ff;
    border-left: 5px solid #00e6ff;
    padding: 12px 18px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: bold;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(0, 230, 255, 0.1);
}

.hidden-section {
    display: none;
}

/* -- Formularios y Campos de Entrada -- */
.form-container input[type="text"],
.form-container input[type="number"],
.form-container input[type="email"],
.form-container input[type="password"],
.form-container textarea,
.form-container select {
    width: 100%;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1.5px solid #00e6ff44;
    margin-bottom: 16px;
    font-size: 1rem;
    background: #223040;
    color: #e0f7fa;
    transition: border 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
    box-sizing: border-box;
}

.form-container input[type="text"]:focus,
.form-container input[type="number"]:focus,
.form-container input[type="email"]:focus,
.form-container input[type="password"]:focus,
.form-container textarea:focus,
.form-container select:focus {
    border: 1.5px solid #00e6ff;
    background: #182730;
    box-shadow: 0 0 10px rgba(0, 230, 255, 0.6);
    outline: none;
}

.form-container button {
    background: linear-gradient(90deg, #00e6ff 20%, #2e86de 100%);
    color: #232b38;
    border: none;
    border-radius: 8px;
    padding: 12px 25px;
    font-weight: bold;
    font-size: 1.05rem;
    cursor: pointer;
    margin-top: 10px;
    transition: background 0.3s ease, color 0.3s ease, transform 0.1s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 230, 255, 0.4);
}

.form-container button:hover {
    background: linear-gradient(90deg, #2e86de 0%, #00e6ff 80%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 230, 255, 0.6);
}

/* -- Tablas -- */
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    margin-top: 15px;
    background: #223040;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0, 230, 255, 0.1);
}

thead tr {
    background: #00e6ff;
    color: #182730;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 0.9rem;
}

th, td {
    padding: 12px 10px;
    text-align: left;
}

tbody tr {
    background: #243444;
    color: #e0f7fa;
    border-bottom: none;
    transition: background 0.25s ease, transform 0.1s ease, box-shadow 0.25s ease;
    border-radius: 8px;
}

tbody tr:hover {
    background: #2e86de33;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 230, 255, 0.15);
}

td img {
    max-width: 70px;
    max-height: 50px;
    border-radius: 8px;
    border: 2px solid #00e6ff66;
    background: #fff;
    object-fit: cover;
}

/* -- Botones de Acción (Editar/Eliminar) -- */
.action-btns {
    display: flex;
    gap: 10px;
}

.action-btns a,
.action-btns button {
    padding: 6px 14px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 0.95rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background 0.25s ease, color 0.25s ease, transform 0.1s ease, box-shadow 0.25s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.action-btns .edit-btn {
    background: linear-gradient(90deg, #00e6ff 0%, #2e86de 100%);
    color: #232b38;
    box-shadow: 0 2px 8px rgba(0, 230, 255, 0.2);
}

.action-btns .edit-btn:hover {
    background: linear-gradient(90deg, #2e86de 0%, #00e6ff 100%);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(0, 230, 255, 0.3);
}

.action-btns .delete-btn {
    background: linear-gradient(90deg, #ff4d4d 0%, #cc0000 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(255, 77, 77, 0.2);
}

.action-btns .delete-btn:hover {
    background: linear-gradient(90deg, #cc0000 0%, #ff4d4d 100%);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(255, 77, 77, 0.3);
}

/* -- Media Queries para Responsividad -- */

@media (max-width: 1100px) {
    .main-content {
        max-width: 95vw;
        margin: 15px auto;
        padding: 25px 25px 18px 25px;
        min-height: calc(100vh - 30px);
    }
}

@media (max-width: 900px) {
    .main-content {
        padding: 15px 3vw;
        margin: 10px auto;
        min-height: calc(100vh - 20px);
    }
    table, thead, tbody, th, td, tr {
        font-size: 0.9rem;
    }
    .form-container {
        max-width: 98vw !important;
    }
    .sidebar {
        width: 80px;
    }
    .sidebar h2 {
        font-size: 1rem;
        letter-spacing: 0.5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sidebar nav .menu-main {
        font-size: 0.9rem;
        padding: 10px 12px;
    }
    .sidebar nav .logout-btn {
        font-size: 0.9rem;
        padding: 10px 0;
    }
    /* En pantallas medianas, los submenús se quedan debajo del elemento principal */
    .dropdown-content, .submenu {
        position: relative;
        left: unset;
        top: unset;
        transform: none; /* Resetear transformaciones */
        margin-top: 5px; /* Espacio debajo del elemento padre */
    }
}

@media (max-width: 700px) {
    body {
        flex-direction: column;
    }
    .sidebar {
        width: 100%;
        min-height: auto;
        border-right: none;
        border-bottom: 1px solid #00e6ff33;
        box-shadow: 0 2px 15px rgba(0, 230, 255, 0.1);
        padding-bottom: 10px;
    }
    .sidebar h2 {
        margin: 15px 0 10px 0;
        font-size: 1.2rem;
    }
    .sidebar nav {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        margin: 0 10px;
    }
    .sidebar nav .menu-group {
        margin-bottom: 0;
    }
    .sidebar nav .menu-main {
        padding: 8px 12px;
        font-size: 0.85rem;
    }
    .sidebar nav .logout-btn {
        margin: 15px 10px 0 10px;
        width: auto;
        display: inline-block;
    }
    /* Comportamiento de menús desplegables en móvil (ahora usan max-height y opacity para la transición) */
    .dropdown-content, .submenu {
        position: static; /* Crucial: asegura que en móviles se posicionen dentro del flujo normal */
        min-width: unset;
        width: 90%;
        margin: 10px auto;
        border-radius: 8px;
        box-shadow: none;
        border: 1px solid #00e6ff33;
        transform: none;
        /* En móvil, se controlan por max-height y opacity junto con JavaScript (o :focus-within) */
        max-height: 0;
        opacity: 0;
        visibility: hidden;
        overflow: hidden;
        transition: max-height 0.4s ease-out, opacity 0.4s ease-out, visibility 0.4s;
    }

    /* Regla para mostrar submenú/dropdown en móvil (se activa con JavaScript o con :focus-within en el padre) */
    /* Necesitarás una clase como 'is-open' o 'active' en el 'menu-group' o 'dropdown' padre */
    .sidebar nav .menu-group.is-open .submenu,
    .dropdown.is-open .dropdown-content {
        max-height: 200px; /* Suficiente para mostrar todo el contenido */
        opacity: 1;
        visibility: visible;
        display: flex; /* O 'block' según tu contenido */
    }

    /* Eliminar el efecto de hover/focus para el display en móvil si tu menú se activa por clic (JS) */
    .sidebar nav .menu-group:hover .submenu,
    .sidebar nav .menu-group:focus-within .submenu,
    .dropdown:hover .dropdown-content,
    .dropdown:focus-within .dropdown-content {
        /* No se usa aquí en móvil para evitar conflictos con el comportamiento basado en clics */
    }
}

@media (max-width: 600px) {
    table {
        display: block; width: 100%; overflow-x: auto; border-radius: 0; box-shadow: none; background: transparent;
    }
    thead, tbody, th, td, tr {
        display: block; width: 100%;
    }
    thead tr { display: none; }
    tbody tr { margin-bottom: 18px; border-radius: 10px; background: #223040; box-shadow: 0 2px 8px #00e6ff22; padding: 10px 0; }
    td { padding: 8px 12px; text-align: left; position: relative; width: 100%; border-bottom: none; display: flex; align-items: center; gap: 8px; }
    td:before { content: attr(data-label); font-weight: bold; color: #00e6ff; min-width: 90px; display: inline-block; }
}

@media (max-width: 400px) {
    .main-content { padding: 10px; }
    .form-container input, .form-container button {
        font-size: 0.9rem;
        padding: 10px;
    }
    .sidebar h2 { font-size: 1rem; }
    .sidebar nav .menu-main { font-size: 0.8rem; padding: 7px 10px; }
    .sidebar nav .logout-btn { font-size: 0.85rem; padding: 8px 0; }
    td:before { min-width: 70px; }
}
</style>
</head>
<body>
  <aside class="sidebar">
    <div class="dropdown">
      <h2>AdminPanel</h2>
    </div>
    <nav>
      <div class="menu-group">
        <div class="menu-main">Productos ▼</div>
        <div class="submenu">
          <a href="#agregar-producto" class="sidebar-link">Agregar producto</a>
          <a href="#ver-productos" class="sidebar-link">Ver productos</a>
        </div>
      </div>
      <div class="menu-group">
        <div class="menu-main">Pedidos ▼</div>
        <div class="submenu">
          <a href="#ver-pedidos" class="sidebar-link">Ver pedidos</a>
          <a href="#ver-ventas" class="sidebar-link">Ver ventas</a>
        </div>
      </div>
      <div class="menu-group">
        <div class="menu-main">Cuentas ▼</div>
        <div class="submenu">
          <a href="#cuentas-admin" class="sidebar-link">Gestionar cuentas admin</a>
          <a href="#cuentas-cliente" class="sidebar-link">Gestionar cuentas cliente</a>
        </div>
      </div>
      <a class="logout-btn" href="logout.php" title="Cerrar sesión">Cerrar sesión ⎋</a>
    </nav>
  </aside>
  <main class="main-content">
    <h1>Panel de Administración - TechStore+</h1>
    <p>Bienvenido, Administrador de <strong>TechStore+</strong>. Aquí puedes gestionar productos, pedidos y cuentas de usuario.</p>
    <!-- Agregar producto -->
    <section id="agregar-producto">
      <h2>Agregar producto</h2>
      <?php if (!empty($mensaje)): ?>
        <div class="mensaje">
          <?php echo $mensaje; ?>
        </div>
      <?php endif; ?>
      <form method="POST" class="form-container" style="max-width: 400px;">
        <input type="hidden" name="nuevo_producto" value="1">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <label>Categoría:
          <select name="categoria" required>
            <option value="">Selecciona una categoría</option>
            <?php foreach ($categorias as $cat): ?>
              <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <label>Marca:
          <select name="marca" required>
            <option value="">Selecciona una marca</option>
            <?php foreach ($marcas as $marca): ?>
              <option value="<?php echo htmlspecialchars($marca); ?>"><?php echo htmlspecialchars($marca); ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <input type="number" name="precio" placeholder="Precio" step="0.01" min="0" required>
        <input type="text" name="imagen" placeholder="URL de la imagen" required>
        <input type="text" name="imagen2" placeholder="URL de la imagen 2 (opcional)">
        <input type="text" name="imagen3" placeholder="URL de la imagen 3 (opcional)">
        <button type="submit">Añadir producto</button>
      </form>
    </section>
    <!-- Ver productos -->
    <section id="ver-productos" class="hidden-section">
      <h2>Lista de productos</h2>
      <input type="text" id="busquedaProductos" placeholder="Buscar producto por nombre, categoría o marca..." style="width:100%;max-width:350px;padding:8px 12px;margin-bottom:14px;border-radius:8px;border:1.5px solid #00e6ff44;background:#223040;color:#e0f7fa;">
      <table id="tablaProductos">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Imagen</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($productos as $p): ?>
          <tr>
            <td data-label="Nombre">
              <span class="editable" data-id="<?php echo $p['id']; ?>" data-campo="nombre" style="cursor:pointer; color:#00e6ff; font-weight:bold;">
                <?php echo htmlspecialchars($p['nombre']); ?>
              </span>
            </td>
            <td data-label="Categoría">
              <span class="editable" data-id="<?php echo $p['id']; ?>" data-campo="categoria" style="cursor:pointer; color:#00e6ff; font-weight:bold;">
                <?php echo htmlspecialchars($p['categoria']); ?>
              </span>
            </td>
            <td data-label="Descripción">
              <span class="editable" data-id="<?php echo $p['id']; ?>" data-campo="descripcion" style="cursor:pointer; color:#00e6ff; font-weight:bold;">
                <?php echo htmlspecialchars($p['descripcion']); ?>
              </span>
            </td>
            <td data-label="Marca">
              <span class="editable" data-id="<?php echo $p['id']; ?>" data-campo="marca" style="cursor:pointer; color:#00e6ff; font-weight:bold;">
                <?php echo htmlspecialchars($p['marca']); ?>
              </span>
            </td>
            <td data-label="Precio">
              <span class="editable" data-id="<?php echo $p['id']; ?>" data-campo="precio" style="cursor:pointer; color:#00e6ff; font-weight:bold;">
                S/<?php echo number_format($p['precio'],2); ?>
              </span>
            </td>
            <td data-label="Stock">
              <span class="stock-value" 
                    style="margin-right:8px; color:#00e6ff; font-weight:bold; cursor:pointer;"
                    onclick="editarStock(this, <?php echo $p['id']; ?>, <?php echo isset($p['stock']) ? intval($p['stock']) : 0; ?>)">
                <?php echo isset($p['stock']) ? intval($p['stock']) : 0; ?>
              </span>
            </td>
            <td data-label="Imagen">
              <?php if ($p['imagen']): ?>
                <a href="editar_producto.php?id=<?php echo $p['id']; ?>">
                  <img src="<?php echo htmlspecialchars($p['imagen']); ?>" alt="img" style="cursor:pointer;">
                </a>
              <?php endif; ?>
            </td>
            <td data-label="Acciones">
              <div class="action-btns">
                <a href="admin_panel.php?eliminar=<?php echo $p['id']; ?>" class="delete-btn" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
    <!-- Ver pedidos -->
    <section id="ver-pedidos" class="hidden-section" style="margin-top:40px;">
      <h2>Registro de pedidos</h2>
      <?php if (empty($pedidos)): ?>
        <p>No hay pedidos registrados.</p>
      <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Cliente</th>
            <th>Productos solicitados</th>
            <th>Fecha de pedido</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pedidos as $pedido): ?>
          <tr>
            <td><?php echo htmlspecialchars($pedido['username']); ?></td>
            <td>
              <ul style="margin:0; padding-left:18px;">
                <?php 
                  $productosPedido = json_decode($pedido['productos'], true);
                  if (is_array($productosPedido)) {
                    foreach ($productosPedido as $prod) {
                      echo '<li>' . htmlspecialchars($prod['nombre']) . ' (x' . intval($prod['cantidad']) . ')</li>';
                    }
                  }
                ?>
              </ul>
            </td>
            <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
            <td>S/<?php echo number_format($pedido['total'],2); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </section>
    <!-- Ver ventas (puedes personalizar esta sección) -->
    <section id="ver-ventas" class="hidden-section" style="margin-top:40px;">
      <h2>Ver ventas</h2>
      <p>Funcionalidad de ventas aquí...</p>
    </section>
    <!-- Gestionar cuentas admin -->
    <section id="cuentas-admin" class="hidden-section" style="margin-top:40px;">
      <h2>Gestionar cuentas admin</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($usuarios as $u): ?>
            <?php if ($u['role'] !== 'admin') continue; ?>
            <tr>
              <td><?php echo $u['id']; ?></td>
              <td><?php echo htmlspecialchars($u['username']); ?></td>
              <td><?php echo htmlspecialchars($u['role']); ?></td>
              <td>
                <!-- No eliminar admins desde aquí -->
                <span style="color:#888;">No editable</span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
    <!-- Gestionar cuentas cliente -->
    <section id="cuentas-cliente" class="hidden-section" style="margin-top:40px;">
      <h2>Gestionar cuentas cliente</h2>
      <?php if (empty($usuarios)): ?>
        <p>No hay cuentas registradas.</p>
      <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($usuarios as $u): ?>
            <?php if ($u['role'] === 'admin') continue; ?>
            <tr>
              <td><?php echo $u['id']; ?></td>
              <td><?php echo htmlspecialchars($u['username']); ?></td>
              <td><?php echo htmlspecialchars($u['role']); ?></td>
              <td>
                <form method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar esta cuenta?');">
                  <input type="hidden" name="eliminar_usuario" value="<?php echo $u['id']; ?>">
                  <button type="submit" style="background:#ff4d4d; color:#fff; border:none; border-radius:6px; padding:6px 14px; font-weight:bold; cursor:pointer;">Eliminar</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </section>
  </main>

  <!-- JS: Buscador productos -->
  <script>
  document.getElementById('busquedaProductos').addEventListener('input', function() {
    const filtro = this.value.toLowerCase();
    const filas = document.querySelectorAll('#tablaProductos tbody tr');
    filas.forEach(fila => {
      const texto = fila.textContent.toLowerCase();
      fila.style.display = texto.includes(filtro) ? '' : 'none';
    });
  });
  </script>

  <!-- JS: Edición en línea productos -->
  <script>
  const categorias = <?php echo json_encode($categorias); ?>;
  const marcas = <?php echo json_encode($marcas); ?>;

  document.querySelectorAll('.editable').forEach(function(span) {
    span.addEventListener('click', function() {
      if (span.querySelector('input') || span.querySelector('select')) return;
      const campo = span.getAttribute('data-campo');
      const id = span.getAttribute('data-id');
      let valorActual = span.textContent.trim();
      if (campo === 'precio') valorActual = valorActual.replace('S/', '').replace(',', '').trim();

      let input;
      if (campo === 'categoria' || campo === 'marca') {
        input = document.createElement('select');
        const opciones = campo === 'categoria' ? categorias : marcas;
        opciones.forEach(function(op) {
          const option = document.createElement('option');
          option.value = op;
          option.textContent = op;
          if (op === valorActual) option.selected = true;
          input.appendChild(option);
        });
      } else {
        input = document.createElement('input');
        input.type = (campo === 'precio') ? 'number' : 'text';
        if (campo === 'precio') input.step = '0.01';
        input.value = valorActual;
        input.style.width = (campo === 'descripcion') ? '140px' : '90px';
        input.style.fontWeight = 'bold';
      }

      span.textContent = '';
      span.appendChild(input);
      input.focus();

      input.addEventListener('blur', guardar);
      input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') guardar();
      });

      function guardar() {
        let nuevoValor = (campo === 'categoria' || campo === 'marca') ? input.value : input.value.trim();
        if (campo === 'precio') nuevoValor = parseFloat(nuevoValor);
        if (!nuevoValor || (campo === 'precio' && (isNaN(nuevoValor) || nuevoValor < 0))) {
          span.textContent = valorActual;
          return;
        }
        fetch('', {
          method: 'POST',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          body: `producto_id=${id}&campo=${campo}&nuevo_valor=${encodeURIComponent(nuevoValor)}&actualizar_campo=1`
        })
        .then(res => res.ok ? Promise.resolve() : Promise.reject())
        .then(() => {
          span.textContent = (campo === 'precio') ? 'S/' + parseFloat(nuevoValor).toFixed(2) : nuevoValor;
        })
        .catch(() => {
          span.textContent = valorActual;
          alert('Error al actualizar el campo');
        });
      }
    });
  });
  </script>

  <!-- JS: Edición rápida stock -->
  <script>
  function editarStock(span, productoId, stockActual) {
    if (span.querySelector('input')) return;
    const input = document.createElement('input');
    input.type = 'number';
    input.value = stockActual;
    input.min = 0;
    input.style.width = '60px';
    input.style.fontWeight = 'bold';
    span.textContent = '';
    span.appendChild(input);
    input.focus();
    input.addEventListener('blur', guardarStock);
    input.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') guardarStock();
    });
    function guardarStock() {
      const nuevoStock = parseInt(input.value, 10);
      if (isNaN(nuevoStock) || nuevoStock < 0) {
        span.textContent = stockActual;
        return;
      }
      fetch('', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `producto_id=${productoId}&nuevo_stock=${nuevoStock}&actualizar_stock=1`
      })
      .then(res => res.ok ? Promise.resolve() : Promise.reject())
      .then(() => {
        span.textContent = nuevoStock;
        span.onclick = function() { editarStock(span, productoId, nuevoStock); };
      })
      .catch(() => {
        span.textContent = stockActual;
        span.onclick = function() { editarStock(span, productoId, stockActual); };
        alert('Error al actualizar el stock');
      });
    }
  }
  </script>

  <!-- JS: Menú lateral, mostrar secciones -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar secciones
    const sections = {
      'agregar-producto': document.getElementById('agregar-producto'),
      'ver-productos': document.getElementById('ver-productos'),
      'ver-pedidos': document.getElementById('ver-pedidos'),
      'ver-ventas': document.getElementById('ver-ventas'),
      'cuentas-admin': document.getElementById('cuentas-admin'),
      'cuentas-cliente': document.getElementById('cuentas-cliente')
    };
    function showSection(id) {
      for (const key in sections) {
        if (sections[key]) sections[key].classList.add('hidden-section');
      }
      if (sections[id]) sections[id].classList.remove('hidden-section');
      document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
      const activeLink = document.querySelector('.sidebar-link[href="#' + id + '"]');
      if (activeLink) activeLink.classList.add('active');
    }
    document.querySelectorAll('.sidebar-link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const id = this.getAttribute('href').replace('#', '');
        showSection(id);
      });
    });
    // Mostrar agregar producto por defecto
    showSection('agregar-producto');
  });
  </script>
</body>
</html>