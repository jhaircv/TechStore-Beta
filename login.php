<?php
session_start();
if (isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión - TechStore+</title>
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
  background: #172132; /* Azul oscuro plano */
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}
.main-wrapper {
  display: flex;
  width: 900px;
  max-width: 98vw;
  min-height: 600px;
  background: #1e293b; /* Panel plano */
  border-radius: 18px;
  box-shadow: 0 6px 32px #0ea5e922;
  overflow: hidden;
  border: 1.5px solid #334155;
  z-index: 1;
}
.info-section {
  flex: 1.2;
  background-image: url('C:/xampp/htdocs/mi-tienda(beta1.1)/Logo_Techstore+.png');
  background-size: cover;
  background-position: center;
  padding: 20px;
  text-align: center;
  color: #e0f7fa;
  padding: 48px 36px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.info-section h2 {
  font-size: 2.1rem;
  font-weight: bold;
  margin-bottom: 16px;
  color: #38bdf8;
  letter-spacing: 1px;
}
.info-section p {
  font-size: 1.1rem;
  margin-bottom: 24px;
  color: #b5eaff;
}
.form-section {
  flex: 1;
  background: #222d3d;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 48px 36px;
}
.form-section h3 {
  color: #38bdf8;
  font-size: 2rem;
  margin-bottom: 24px;
  font-weight: bold;
  letter-spacing: 1px;
}
.form-container {
  width: 100%;
  max-width: 340px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.form-container input[type="text"],
.form-container input[type="password"] {
  width: 92%;
  padding: 12px 14px;
  border-radius: 8px;
  border: 1.5px solid #334155;
  font-size: 1rem;
  background: #1e293b;
  color: #e0f7fa;
  transition: border 0.2s, background 0.2s;
}
.form-container input[type="text"]:focus,
.form-container input[type="password"]:focus {
  border: 1.5px solid #38bdf8;
  background: #172132;
  color: #fff;
}
.form-container button {
  width: 100%;
  background: #38bdf8;
  color: #172132;
  border: none;
  border-radius: 8px;
  padding: 12px 0;
  font-weight: bold;
  font-size: 1.1rem;
  cursor: pointer;
  margin-bottom: 8px;
  transition: background 0.2s, color 0.2s;
  box-shadow: 0 2px 8px #38bdf822;
  letter-spacing: 0.5px;
}
.form-container button:hover {
  background: #0ea5e9;
  color: #fff;
}
.form-container .bottom-link {
  margin-top: 16px;
  font-size: 1rem;
  color: #b5eaff;
}
.form-container .bottom-link a {
  color: #38bdf8;
  text-decoration: underline;
  font-weight: 500;
  margin-left: 5px;
  transition: color 0.2s;
}
.form-container .bottom-link a:hover {
  color: #0ea5e9;
}
/* Responsive */
@media (max-width: 900px) {
  .main-wrapper {
    flex-direction: column;
    min-height: 0;
    width: 98vw;
  }
  .info-section, .form-section {
    padding: 28px 5vw;
  }
}
@media (max-width: 600px) {
  .main-wrapper {
    min-width: 0;
    width: 100vw;
  }
  .info-section, .form-section {
    padding: 18px 2vw;
  }
}
  </style>
</head>
<body class="animated-gradient">
  <div id="particles-js"></div>
  <div class="main-wrapper">
    <div class="info-section">
      <h2>¡Bienvenido de Nuevo!</h2>
      <p>
        Inicia sesión para acceder a tu cuenta, ver tus pedidos y disfrutar de una experiencia de compra personalizada.
      </p>
    </div>
    <div class="form-section">
      <h3>Iniciar Sesión</h3>
      <form class="form-container" action="procesar_login.php" method="POST">
        <input type="text" name="usuario" placeholder="Nombre de usuario" required />
        <input type="password" name="contrasena" placeholder="Contraseña" required />
        <button type="submit">Ingresar</button>
        <div class="bottom-link">
          ¿No tienes cuenta?
          <a href="registro.php">Crear una</a>
        </div>
      </form>
    </div>
  </div>

  <a href="admin_login.php" id="admin-float-btn" title="Acceso administrador"
   style="position: fixed; right: 32px; bottom: 32px; z-index: 1000; text-decoration: none;">
    <span style="font-size: 2rem; background: #2e86de; color: #fff; border-radius: 50%; padding: 12px 15px; box-shadow: 0 2px 12px rgba(0,0,0,0.18); display: flex; align-items: center; justify-content: center;">
      🛡️
    </span>
</a>

  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script>
    particlesJS.load('particles-js', 'particles.json', function() {
      console.log('callback - particles.js config loaded');
    });
  </script>
</body>
</html>
