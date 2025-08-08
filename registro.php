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
  <title>Registro - TechStore+</title>
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
      background: #172132;
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
      background: #1e293b;
      border-radius: 18px;
      box-shadow: 0 6px 32px #0ea5e922;
      overflow: hidden;
      border: 1.5px solid #334155;
      z-index: 1;
    }
    .info-section {
      flex: 1.2;
      background: #1a2233;
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
    .info-section a {
      color: #38bdf8;
      text-decoration: underline;
      font-weight: 500;
      transition: color 0.2s;
      cursor: pointer;
    }
    .info-section a:hover {
      color: #0ea5e9;
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
    .form-container input[type="password"],
    .form-container input[type="email"],
    .form-container select {
      width: 100%;
      padding: 12px 14px;
      border-radius: 8px;
      border: 1.5px solid #334155;
      font-size: 1rem;
      background: #1e293b;
      color: #e0f7fa;
      transition: border 0.2s, background 0.2s;
    }
    .form-container input[type="text"]:focus,
    .form-container input[type="password"]:focus,
    .form-container input[type="email"]:focus,
    .form-container select:focus {
      border: 1.5px solid #38bdf8;
      background: #172132;
      color: #fff;
    }
    .form-container .checkbox-row {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.98rem;
      color: #b5eaff;
    }
    .form-container .checkbox-row a {
      color: #38bdf8;
      text-decoration: underline;
      font-weight: 500;
      transition: color 0.2s;
      cursor: pointer;
    }
    .form-container .checkbox-row a:hover {
      color: #0ea5e9;
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
    /* Modal (si usas términos y condiciones) */
    .modal {
      display: none; 
      position: fixed; 
      z-index: 1000; 
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto; 
      background-color: rgba(0,0,0,0.6);
    }
    .modal-content {
      background-color: #1e3556;
      margin: 15% auto;
      padding: 25px;
      border: 1.5px solid #38bdf855;
      width: 80%;
      max-width: 600px;
      border-radius: 12px;
      color: #e0f7fa;
      position: relative;
      animation: slideIn 0.4s;
    }
    @keyframes slideIn {
      from {top: -100px; opacity: 0;}
      to {top: 0; opacity: 1;}
    }
    .close-btn {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    .close-btn:hover,
    .close-btn:focus {
      color: #38bdf8;
      text-decoration: none;
    }
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
<body>
  <div id="particles-js"></div>
  <div class="main-wrapper">
    <div class="info-section">
      <h2>¡Bienvenido a TechStore+!</h2>
      <p>
        Tu destino número uno para los últimos gadgets y componentes tecnológicos.<br>
        Regístrate para recibir ofertas exclusivas, seguir tus pedidos y mucho más.<br><br>
        <a id="learn-more-link">Aprende más ></a>
      </p>
    </div>
    <div class="form-section">
      <h3>Crear Cuenta</h3>
      <form class="form-container" action="procesar_registro.php" method="POST">
        <input type="text" name="usuario" placeholder="Nombre de usuario" required />
        <input type="text" name="nombre" placeholder="Nombre completo" required />
        <input type="email" name="email" placeholder="Correo electrónico" required />
        <input type="password" name="contrasena" placeholder="Contraseña" required />
        <input type="text" name="fecha_nacimiento" placeholder="Fecha de Nacimiento" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}" required />
        <select name="genero" required>
            <option value="" disabled selected>Selecciona tu género</option>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
            <option value="otro">Otro</option>
        </select>
        <div class="checkbox-row">
          <input type="checkbox" id="terms" required>
          <label for="terms">Acepto los <a id="terms-link">términos y condiciones</a></label>
        </div>
        <button type="submit">Registrarse</button>
        <div class="bottom-link">
          ¿Ya tienes cuenta?
          <a href="login.php">Iniciar sesión</a>
        </div>
      </form>
    </div>
  </div>

  <div id="learn-more-modal" class="modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <h2>Sobre TechStore+</h2>
      <p>TechStore+ es tu tienda de confianza para todo lo relacionado con la tecnología. Ofrecemos una amplia gama de productos, desde los últimos teléfonos inteligentes y portátiles hasta componentes de PC de alto rendimiento y accesorios innovadores. Nuestro compromiso es ofrecer productos de calidad con un servicio al cliente excepcional.</p>
    </div>
  </div>

  <div id="terms-modal" class="modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <h2>Términos y Condiciones</h2>
      <p>1. Aceptación de los términos: Al registrarte, aceptas estar sujeto a estos términos y condiciones.</p>
      <p>2. Uso de la cuenta: Eres responsable de mantener la confidencialidad de tu cuenta y contraseña.</p>
      <p>3. Privacidad: Nuestra política de privacidad describe cómo manejamos la información que nos proporcionas.</p>
      <p>4. Contenido: Todo el contenido de este sitio es propiedad de TechStore+.</p>
      <p>5. Modificaciones: Nos reservamos el derecho de modificar estos términos en cualquier momento.</p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script>
    particlesJS.load('particles-js', 'particles.json', function() {
      console.log('callback - particles.js config loaded');
    });

    // Modal functionality
    const learnMoreModal = document.getElementById('learn-more-modal');
    const termsModal = document.getElementById('terms-modal');
    
    const learnMoreLink = document.getElementById('learn-more-link');
    const termsLink = document.getElementById('terms-link');

    const closeBtns = document.querySelectorAll('.close-btn');

    learnMoreLink.onclick = (e) => {
      e.preventDefault();
      learnMoreModal.style.display = "block";
    }

    termsLink.onclick = (e) => {
      e.preventDefault();
      termsModal.style.display = "block";
    }

    closeBtns.forEach(btn => {
      btn.onclick = () => {
        learnMoreModal.style.display = "none";
        termsModal.style.display = "none";
      }
    });

    window.onclick = (event) => {
      if (event.target == learnMoreModal || event.target == termsModal) {
        learnMoreModal.style.display = "none";
        termsModal.style.display = "none";
      }
    }
  </script>
</body>
</html>
