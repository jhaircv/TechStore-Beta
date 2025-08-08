<?php
session_start();
require_once __DIR__ . "/config/db.php";

$error_message = '';

if (isset($_SESSION['admin'])) {
  header("Location: admin_panel.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $usuario = $_POST["usuario"];
  $contrasena = $_POST["contrasena"];
  
  $stmt = $conexion->prepare("SELECT password FROM usuarios WHERE username = ? AND role = 'admin'");
  $stmt->bind_param("s", $usuario);
  $stmt->execute();
  $stmt->store_result();
  
  if ($stmt->num_rows === 1) {
    $stmt->bind_result($hash);
    $stmt->fetch();
    // NOTA: Esta parte asume que las contraseñas de administrador están hasheadas.
    // Si no lo están, la verificación fallará.
    if (password_verify($contrasena, $hash)) {
      $_SESSION["admin"] = true;
      $_SESSION["usuario"] = $usuario; // Opcional: guardar nombre de admin en sesión
      header("Location: admin_panel.php");
      exit();
    }
  }
  $error_message = 'Usuario o contraseña incorrectos';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Acceso Administrador - TechStore+</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    #particles-js {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
    body {
      min-height: 100vh;
      margin: 0;
      font-family: 'Segoe UI', Arial, sans-serif;
      background: linear-gradient(-45deg, #14243d, #0f2027, #203a43, #2c5364);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    @keyframes gradientBG {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }
    .admin-container {
      width: 400px;
      max-width: 95vw;
      padding: 40px;
      background: rgba(10, 25, 41, 0.85);
      border-radius: 12px;
      box-shadow: 0 8px 40px rgba(0, 230, 255, 0.1);
      border: 1px solid rgba(0, 230, 255, 0.2);
      text-align: center;
      color: #e0f7fa;
      z-index: 1;
    }
    .admin-title {
      font-size: 2rem;
      font-weight: bold;
      color: #00e6ff;
      letter-spacing: 1px;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
    }
    .admin-title span {
      font-weight: 300;
      color: #b5eaff;
    }
    .form-container {
      margin-top: 25px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    .form-container input {
      width: 100%;
      padding: 14px;
      border-radius: 8px;
      border: 1.5px solid #00e6ff44;
      font-size: 1rem;
      background: #19314a;
      color: #e0f7fa;
      transition: border 0.2s, background 0.2s;
      box-sizing: border-box;
    }
    .form-container input:focus {
      border-color: #00e6ff;
      background: #176b87;
      outline: none;
    }
    .form-container button {
      background: linear-gradient(90deg, #00e6ff 60%, #2e86de 100%);
      color: #14243d;
      font-size: 1.1rem;
      font-weight: bold;
      padding: 14px 0;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      letter-spacing: 1px;
    }
    .form-container button:hover {
      background: linear-gradient(90deg, #2e86de 60%, #00e6ff 100%);
      color: #fff;
      box-shadow: 0 0 20px rgba(0, 230, 255, 0.4);
    }
    .error-message {
      background-color: rgba(255, 77, 77, 0.1);
      color: #ff4d4d;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid rgba(255, 77, 77, 0.3);
      margin-top: 20px;
    }
    .back-link {
      margin-top: 25px;
      font-size: 0.9rem;
    }
    .back-link a {
      color: #00e6ff;
      text-decoration: none;
      font-weight: 500;
    }
    .back-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div id="particles-js"></div>
  <div class="admin-container">
    <div class="admin-title">
      <span style="font-size: 2.5rem;">🛡️</span>
      <div>
        Panel de <span>Administrador</span>
      </div>
    </div>
    <form class="form-container" method="POST">
      <input type="text" name="usuario" placeholder="Usuario" required />
      <input type="password" name="contrasena" placeholder="Contraseña" required />
      <button type="submit">Ingresar</button>
    </form>
    <?php if (!empty($error_message)): ?>
      <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <div class="back-link">
      <a href="login.php">← Volver al inicio de sesión</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script>
    particlesJS.load('particles-js', 'particles.json', function() {
      console.log('callback - particles.js config loaded');
    });
  </script>
</body>
</html>