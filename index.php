<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
require_once __DIR__ . "/config/db.php";

// Procesar formulario de edición
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nuevo_username = trim($_POST['username'] ?? '');
    $nuevo_nombre = trim($_POST['nombre'] ?? '');
    $nuevo_email = trim($_POST['email'] ?? '');
    $nuevo_password = $_POST['password'] ?? '';
    $nuevo_fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';

    if ($nuevo_username === '' || $nuevo_email === '' || $nuevo_nombre === '') {
        header("Location: index.php?error=1");
        exit();
    }

    // Verificar si el username ya existe y no es el actual
    if ($nuevo_username !== $_SESSION['usuario']) {
        $stmt_check = $conexion->prepare("SELECT id FROM usuarios WHERE username = ?");
        $stmt_check->bind_param("s", $nuevo_username);
        $stmt_check->execute();
        $stmt_check->store_result();
        if ($stmt_check->num_rows > 0) {
            $stmt_check->close();
            header("Location: index.php?error=2");
            exit();
        }
        $stmt_check->close();
    }

    // Solo actualiza la contraseña si se ingresó una nueva
    if (!empty($nuevo_password)) {
        $password_hash = password_hash($nuevo_password, PASSWORD_DEFAULT);
        $stmt = $conexion->prepare("UPDATE usuarios SET username=?, nombre=?, email=?, password=?, fecha_nacimiento=? WHERE username=?");
        $stmt->bind_param("ssssss", $nuevo_username, $nuevo_nombre, $nuevo_email, $password_hash, $nuevo_fecha_nacimiento, $_SESSION['usuario']);
    } else {
        $stmt = $conexion->prepare("UPDATE usuarios SET username=?, nombre=?, email=?, fecha_nacimiento=? WHERE username=?");
        $stmt->bind_param("sssss", $nuevo_username, $nuevo_nombre, $nuevo_email, $nuevo_fecha_nacimiento, $_SESSION['usuario']);
    }

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $_SESSION['usuario'] = $nuevo_username;
        header("Location: index.php?success=1");
        exit();
    } else {
        header("Location: index.php?error=1");
        exit();
    }
}

// Obtener datos actualizados del usuario
$usuario = $_SESSION['usuario'];
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE username = ?");
if (!$stmt) {
    die('Error en la preparación de la consulta: ' . $conexion->error);
}
$stmt->bind_param("s", $usuario);
$stmt->execute();
$datos_usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conexion->prepare("SELECT * FROM pedidos WHERE username = ? ORDER BY fecha DESC");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$compras = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>TechStore+ - Inicio</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --color-fondo-principal: #121828;
      --color-fondo-secundario: #1a2238;
      --color-tarjeta: #222c45;
      --color-borde: #3a476a;
      --color-texto-principal: #f0f0f0;
      --color-texto-secundario: #a0aec0;
      --color-acento: #00e6ff;
      --color-acento-hover: #00c4dd;
      --sombra-tarjeta: 0 10px 30px -15px rgba(0, 230, 255, 0.2);
    }
    body {
      color: var(--color-texto-principal);
      font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background: linear-gradient(-45deg, #0f2027, #203a43, #2c5364, #1a2a33);
      background-size: 400% 400%;
      animation: gradient 15s ease infinite;
      position: relative;
      z-index: 1;
    }
    @keyframes gradient {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    #particles-js {
      position: fixed;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: -1;
    }
    .dashboard-container {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 300px 1fr;
      gap: 20px;
      position: relative;
      z-index: 2;
    }
    .profile-sidebar {
      background-color: rgba(26, 34, 56, 0.7);
      backdrop-filter: blur(10px);
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      border: 1px solid rgba(58, 71, 106, 0.5);
    }
    .profile-avatar {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid var(--color-acento);
      margin-bottom: 20px;
      object-fit: cover;
    }
    .profile-sidebar h2 {
      margin: 0;
      color: var(--color-acento);
      font-size: 1.8rem;
    }
    .profile-sidebar p {
      color: var(--color-texto-secundario);
      margin-bottom: 30px;
    }
    .profile-actions a {
      display: block;
      background-color: var(--color-tarjeta);
      color: var(--color-texto-principal);
      text-decoration: none;
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 10px;
      transition: background-color 0.3s, transform 0.2s;
      font-weight: bold;
      border-left: 4px solid transparent;
    }
    .profile-actions a:hover {
      background-color: var(--color-borde);
      transform: translateX(5px);
      border-left: 4px solid var(--color-acento);
    }
    .profile-actions a.logout-btn {
      color: #ff7b7b;
    }
    .main-content {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    .card {
      background-color: rgba(26, 34, 56, 0.7);
      backdrop-filter: blur(10px);
      padding: 25px;
      border-radius: 15px;
      border: 1px solid rgba(58, 71, 106, 0.5);
      box-shadow: var(--sombra-tarjeta);
    }
    .card-header {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 20px;
      border-bottom: 1px solid var(--color-borde);
      padding-bottom: 15px;
    }
    .card-header i {
      font-size: 1.5rem;
      color: var(--color-acento);
    }
    .card-header h3 {
      margin: 0;
      font-size: 1.5rem;
      color: var(--color-texto-principal);
    }
    .datos-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
    }
    .dato-item {
      background-color: rgba(34, 44, 69, 0.7);
      padding: 15px;
      border-radius: 10px;
      border: 1px solid rgba(58, 71, 106, 0.4);
    }
    .dato-item span {
      display: block;
      color: var(--color-texto-secundario);
      font-size: 0.9rem;
      margin-bottom: 5px;
    }
    /* Agrega esto en tu <style> o en style.css */
.form-edit {
  max-width: 400px;
  margin: 0 auto;
  background: rgba(34, 44, 69, 0.8);
  padding: 30px 25px;
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0,230,255,0.08);
  display: flex;
  flex-direction: column;
  gap: 18px;
}
.form-edit label {
  font-weight: 500;
  color: var(--color-acento);
  margin-bottom: 6px;
}
.form-edit input[type="text"],
.form-edit input[type="email"],
.form-edit input[type="password"],
.form-edit input[type="date"] {
  padding: 10px 12px;
  border-radius: 7px;
  border: 1px solid var(--color-borde);
  background: #222c45;
  color: var(--color-texto-principal);
  font-size: 1rem;
  margin-bottom: 10px;
}
.form-edit input[type="submit"] {
  background: linear-gradient(45deg, var(--color-acento), var(--color-acento-hover));
  color: #121828;
  font-weight: bold;
  border: none;
  border-radius: 7px;
  padding: 12px 0;
  cursor: pointer;
  font-size: 1.1rem;
  transition: background 0.2s;
}
.form-edit input[type="submit"]:hover {
  background: linear-gradient(45deg, var(--color-acento-hover), var(--color-acento));
}
    .tabla-compras {
      width: 100%;
      border-collapse: collapse;
    }
    .tabla-compras th, .tabla-compras td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid var(--color-borde);
    }
    .tabla-compras th {
      color: var(--color-acento);
      font-size: 1rem;
    }
    .tabla-compras tr:last-child td {
      border-bottom: none;
    }
    .tabla-compras ul {
      margin: 0;
      padding-left: 20px;
      color: var(--color-texto-secundario);
    }
    .no-compras {
      text-align: center;
      padding: 40px;
      color: var(--color-texto-secundario);
    }
    .main-btn {
      display: inline-block;
      background: linear-gradient(45deg, var(--color-acento), var(--color-acento-hover));
      color: var(--color-fondo-principal);
      font-weight: bold;
      padding: 15px 30px;
      border: none;
      border-radius: 10px;
      font-size: 1.1rem;
      text-decoration: none;
      text-align: center;
      transition: transform 0.2s, box-shadow 0.2s;
      margin-top: 20px;
    }
    .main-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0, 230, 255, 0.3);
    }
    @media (max-width: 992px) {
      .dashboard-container {
        grid-template-columns: 1fr;
      }
      .profile-sidebar {
        padding: 20px;
      }
    }
    @media (max-width: 576px) {
      body {
        padding: 10px;
      }
      .card {
        padding: 15px;
      }
      .tabla-compras th, .tabla-compras td {
        padding: 10px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
<div id="particles-js"></div>
  <div class="dashboard-container">
    <aside class="profile-sidebar">
      <?php if ($datos_usuario): ?>
        <img src="https://i.pravatar.cc/150?u=<?php echo htmlspecialchars($datos_usuario['username']); ?>" alt="Avatar de usuario" class="profile-avatar">
        <h2><?php echo htmlspecialchars($datos_usuario['username']); ?></h2>
      <?php else: ?>
        <img src="https://i.pravatar.cc/150?u=usuario" alt="Avatar de usuario" class="profile-avatar">
        <h2>Usuario</h2>
      <?php endif; ?>
      <p>Cliente de TechStore+</p>
      <nav class="profile-actions">
        <a href="productos.php"><i class="fas fa-store"></i> Ir a la Tienda</a>
        <a href="#" id="historial-compras-sidebar"><i class="fas fa-history"></i> Historial de Compras</a>
        <a href="#" id="edit-client-info-sidebar"><i class="fas fa-cog"></i> Ajustes de Cuenta</a>
        <a href="#" id="soporte-btn"><i class="fas fa-headset"></i> Soporte</a>
        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
      </nav>
    </aside>

    <main class="main-content1">
      <div class="card">
        <div class="card-header">
          <i class="fas fa-user-circle"></i>
          <h3>Información de la Cuenta</h3>
        </div>
        <div class="datos-grid">
          <div class="dato-item">
            <span>Usuario</span>
            <strong><?php echo isset($datos_usuario['username']) ? htmlspecialchars($datos_usuario['username']) : 'No especificado'; ?></strong>
          </div>
          <div class="dato-item">
            <span>Nombre</span>
            <strong><?php echo isset($datos_usuario['nombre']) ? htmlspecialchars($datos_usuario['nombre']) : 'No especificado'; ?></strong>
          </div>
          <div class="dato-item">
            <span>Email</span>
            <strong><?php echo isset($datos_usuario['email']) ? htmlspecialchars($datos_usuario['email']) : 'No especificado'; ?></strong>
          </div>
        </div>
      </div>

        <div class="card">
  <div class="card-header" id="historial-compras-button">
  </div>
  <div class="datos-grid" style="margin-bottom:20px;">
  <div class="dato-item">
    <span>Ubicación</span>
    <strong><?php echo isset($datos_usuario['direccion']) ? htmlspecialchars($datos_usuario['direccion']) : 'No especificado'; ?></strong>
  </div>
  <div class="dato-item">
    <span>Cumpleaños</span>
    <strong>
      <?php
        if (!empty($datos_usuario['fecha_nacimiento'])) {
          echo date("d/m/Y", strtotime($datos_usuario['fecha_nacimiento']));
        } else {
          echo 'No especificado';
        }
      ?>
    </strong>
  </div>
  <div class="dato-item">
    <span>Género</span>
    <strong><?php echo isset($datos_usuario['genero']) ? htmlspecialchars($datos_usuario['genero']) : 'No especificado'; ?></strong>
  </div>
</div>
  <div id="historial-compras-content" style="display:none;">
        <h3 id="historial-compras-titulo">Historial de Compras</h3>
        <?php if (empty($compras)): ?>
          <div class="no-compras">
            <p>Aún no has realizado ninguna compra. ¡Explora nuestros productos!</p>
            <a href="productos.php" class="main-btn">Ver Productos</a>
          </div>
        <?php else: ?>
          <table class="tabla-compras">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Productos</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($compras as $compra): ?>
              <tr>
                <td><?php echo date("d/m/Y", strtotime($compra['fecha'])); ?></td>
                <td>
                  <ul>
                    <?php
                      $productos = json_decode($compra['productos'], true);
                      if (is_array($productos)) {
                        foreach ($productos as $prod) {
                          echo '<li>' . htmlspecialchars($prod['nombre']) . ' (x' . intval($prod['cantidad']) . ')</li>';
                        }
                      }
                    ?>
                  </ul>
                </td>
                <td>S/ <?php echo number_format($compra['total'], 2); ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>

      <div id="edit-client-info" style="display:none;">
        <div class="card-header">
          <i class="fas fa-cog"></i>
          <h3>Ajustes de Cuenta</h3>
        </div>
        <p>Actualiza tu información personal y preferencias de cuenta.</p>
        <?php if (isset($_GET['success'])): ?>
          <div class="alert alert-success">
            Información actualizada correctamente.
          </div>
        <?php elseif (isset($_GET['error'])): ?>
          <div class="alert alert-danger">
            Error al actualizar la información. Por favor, inténtalo de nuevo.
          </div>
        <?php endif; ?>
        <br>
        <p>Completa el siguiente formulario para actualizar tu información:</p>
        <br>
<form id="edit-client-info-form" class="form-edit" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
  <label for="username">Username:</label>
  <input type="text" id="username" name="username" value="<?php echo isset($datos_usuario['username']) ? htmlspecialchars($datos_usuario['username']) : ''; ?>">
  <label for="nombre">Nombre:</label>
  <input type="text" id="nombre" name="nombre" value="<?php echo isset($datos_usuario['nombre']) ? htmlspecialchars($datos_usuario['nombre']) : ''; ?>">
  <label for="password">Contraseña:</label>
  <input type="password" id="password" name="password" placeholder="Ingrese su nueva contraseña">
  <label for="email">Correo electrónico:</label>
  <input type="email" id="email" name="email" value="<?php echo isset($datos_usuario['email']) ? htmlspecialchars($datos_usuario['email']) : ''; ?>">
  <label for="fecha_nacimiento">Fecha de nacimiento:</label>
  <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo isset($datos_usuario['fecha_nacimiento']) ? htmlspecialchars($datos_usuario['fecha_nacimiento']) : ''; ?>">
  <input type="submit" value="Guardar cambios">
</form>
    </div>
  </div>
  <!-- Modal de soporte -->
<div id="modal-soporte" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(18,24,40,0.7); z-index:9999; align-items:center; justify-content:center;">
  <div style="background:#222c45; padding:32px 24px; border-radius:14px; max-width:350px; margin:auto; box-shadow:0 8px 32px rgba(0,230,255,0.18); color:#f0f0f0; position:relative;">
    <h2 style="color:#00e6ff; margin-top:0;">Soporte TechStore+</h2>
    <p>¿Necesitas ayuda? <br> Contacta a nuestro equipo:</p>
    <ul style="margin:12px 0 18px 0; padding-left:18px;">
      <li>Email: soporte@techstore.com</li>
      <li>WhatsApp: +51 999 888 777</li>
      <li>Horario: Lun-Vie 9am-6pm</li>
    </ul>
    <button onclick="document.getElementById('modal-soporte').style.display='none'" style="background:#00e6ff; color:#121828; border:none; border-radius:7px; padding:8px 18px; font-weight:bold; cursor:pointer;">Cerrar</button>
  </div>
</div>
    </main>
  </div>
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script>
    particlesJS.load('particles-js', 'particles.json', function() {
      console.log('callback - particles.js config loaded');
    });
  </script>
  <script>
  // Seleccionamos los botones de la sidebar
  const historialSidebarBtn = document.getElementById('historial-compras-sidebar');
  const ajustesSidebarBtn = document.getElementById('edit-client-info-sidebar');

  // Seleccionamos las secciones
  const historialComprasContainer = document.getElementById('historial-compras-content');
  const ajustesContainer = document.getElementById('edit-client-info');
  const infoAdicionalContainer = document.querySelector('.card-header#historial-compras-button + .datos-grid'); // Selecciona la info adicional

  // Mostrar historial de compras
  historialSidebarBtn.addEventListener("click", function(event) {
    event.preventDefault();
    ajustesContainer.style.display = "none";
    historialComprasContainer.style.display = "block";
    if (infoAdicionalContainer) infoAdicionalContainer.style.display = "none";
  });

  // Mostrar ajustes de cuenta
  ajustesSidebarBtn.addEventListener("click", function(event) {
    event.preventDefault();
    historialComprasContainer.style.display = "none";
    ajustesContainer.style.display = "block";
    if (infoAdicionalContainer) infoAdicionalContainer.style.display = "none";
  });

  // Mostrar información adicional por defecto al cargar la página
  window.addEventListener('DOMContentLoaded', function() {
    if (infoAdicionalContainer) infoAdicionalContainer.style.display = "block";
    historialComprasContainer.style.display = "none";
    ajustesContainer.style.display = "none";
  });

  // Modal de soporte
  document.getElementById('soporte-btn').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('modal-soporte').style.display = 'flex';
  });
</script>
<script>
document.getElementById('soporte-btn').addEventListener('click', function(e) {
  e.preventDefault();
  document.getElementById('modal-soporte').style.display = 'flex';
});
</script>
</body>
</html>