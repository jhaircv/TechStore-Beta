<?php
require_once 'config/db.php';
$id = $_GET['id'];
// Obtener datos actuales
$stmt = $conexion->prepare("SELECT imagen, imagen2, imagen3, nombre FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$producto = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagen = trim($_POST['imagen']);
    $imagen2 = trim($_POST['imagen2']);
    $imagen3 = trim($_POST['imagen3']);
    $stmt = $conexion->prepare("UPDATE productos SET imagen=?, imagen2=?, imagen3=? WHERE id=?");
    $stmt->bind_param("sssi", $imagen, $imagen2, $imagen3, $id);
    $stmt->execute();
    header("Location: admin_panel.php?edit=ok");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar imágenes del producto</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background: linear-gradient(135deg, #39abb8 0%, #232b38 100%);
      min-height: 100vh;
      margin: 0;
      font-family: 'Segoe UI', Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .edit-container {
      background: rgba(49, 83, 97, 0.97);
      border-radius: 16px;
      box-shadow: 0 4px 24px #00e6ff22;
      padding: 36px 32px 28px 32px;
      max-width: 440px;
      width: 100%;
      margin: 40px auto;
      text-align: center;
      animation: fadeIn 0.8s;
    }
    .edit-container h2 {
      color: #00e6ff;
      margin-bottom: 18px;
      font-size: 1.4rem;
      letter-spacing: 1px;
    }
    .img-preview-main {
      width: 220px;
      height: 220px;
      object-fit: contain;
      border-radius: 12px;
      border: 2px solid #00e6ff44;
      background: #f7fbfd;
      margin-bottom: 18px;
      box-shadow: 0 2px 8px #00e6ff22;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    .img-preview-thumbs {
      display: flex;
      gap: 12px;
      justify-content: center;
      margin-bottom: 18px;
    }
    .img-preview-thumbs img {
      width: 60px;
      height: 60px;
      object-fit: contain;
      border-radius: 8px;
      border: 1.5px solid #00e6ff44;
      background: #f7fbfd;
    }
    .edit-form label {
      display: block;
      text-align: left;
      margin-bottom: 8px;
      color: #00e6ff;
      font-weight: 500;
    }
    .edit-form input[type="text"] {
      width: 100%;
      padding: 10px 12px;
      border-radius: 8px;
      border: 1.5px solid #00e6ff44;
      margin-bottom: 18px;
      font-size: 1rem;
      background:rgb(41, 79, 90);
      color: #e0f7fa;
      transition: border 0.2s;
    }
    .edit-form input[type="text"]:focus {
      border: 1.5px solid #00e6ff;
      background:rgb(38, 66, 70);
    }
    .edit-form button, .edit-form a {
      display: inline-block;
      margin-top: 8px;
      padding: 10px 22px;
      border-radius: 8px;
      border: none;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.2s, color 0.2s;
    }
    .edit-form button {
      background: linear-gradient(90deg, #00e6ff 60%, #2e86de 100%);
      color: #232b38;
      margin-right: 10px;
      box-shadow: 0 2px 8px #00e6ff33;
    }
    .edit-form button:hover {
      background: linear-gradient(90deg, #2e86de 60%, #00e6ff 100%);
      color: #fff;
    }
    .edit-form a {
      background: #eee;
      color: #223040;
      border: 1.5px solid #00e6ff44;
    }
    .edit-form a:hover {
      background: #00e6ff;
      color: #fff;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(40px);}
      to { opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>
  <div class="edit-container">
    <h2>Editar imágenes<br><span style="color:#223040;"><?php echo htmlspecialchars($producto['nombre']); ?></span></h2>
    <form method="POST" class="edit-form" autocomplete="off">
      <img id="img-main" class="img-preview-main" src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen principal">
      <div class="img-preview-thumbs">
        <img id="img-thumb2" src="<?php echo htmlspecialchars($producto['imagen2']); ?>" alt="Imagen 2">
        <img id="img-thumb3" src="<?php echo htmlspecialchars($producto['imagen3']); ?>" alt="Imagen 3">
      </div>
      <label>Imagen principal URL:
        <input type="text" name="imagen" id="input-img-main" value="<?php echo htmlspecialchars($producto['imagen']); ?>" required>
      </label>
      <label>Imagen 2 URL:
        <input type="text" name="imagen2" id="input-img-thumb2" value="<?php echo htmlspecialchars($producto['imagen2']); ?>">
      </label>
      <label>Imagen 3 URL:
        <input type="text" name="imagen3" id="input-img-thumb3" value="<?php echo htmlspecialchars($producto['imagen3']); ?>">
      </label>
      <button type="submit">Guardar cambios</button>
      <a href="admin_panel.php">Cancelar</a>
    </form>
  </div>
  <script>
    // Vista previa en tiempo real
    document.getElementById('input-img-main').addEventListener('input', function() {
      document.getElementById('img-main').src = this.value;
    });
    document.getElementById('input-img-thumb2').addEventListener('input', function() {
      document.getElementById('img-thumb2').src = this.value;
    });
    document.getElementById('input-img-thumb3').addEventListener('input', function() {
      document.getElementById('img-thumb3').src = this.value;
    });
  </script>
</body>
</html>