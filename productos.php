<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}
require_once __DIR__ . "/config/db.php";

$productos_por_categoria = [];
$all_products = [];
$result = $conexion->query("SELECT * FROM productos ORDER BY categoria, nombre");
while ($producto = $result->fetch_assoc()) {
    $productos_por_categoria[$producto['categoria']][] = $producto;
    $all_products[] = $producto;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TechStore+ - Productos</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    :root {
  --color-fondo: rgb(3, 13, 31); /* Este será el color inicial/base del body */
  --color-tarjeta: rgb(2, 7, 27);
  --color-texto: #f0f0f0;
  --color-acento-principal: #00e6ff;
  --color-acento-secundario: #ffffff;
  --color-borde: #444;

  /* Colores para la transición de fondo del body (usados en JavaScript) */
  --color-inicio-scroll: rgba(0, 230, 255, 0.4); /* Celeste claro (valor de referencia, JS usará RGB) */
  --color-fin-scroll: rgba(0, 255, 179, 0.4); /* Verde agua (valor de referencia, JS usará RGB) */
}

body {
  color: var(--color-texto);
  font-family: 'Segoe UI', Arial, sans-serif;
  margin: 0;
  /* El background-color del body será controlado por JS */
  background-color: var(--color-fondo); /* Color inicial, JS lo cambiará */
  transition: background-color 1s ease-out; /* Transición suave para el color de fondo del body */
}

/* --- ESTILOS CON BLUR Y TRANSPARENCIA --- */

/* Contenedores principales (Main content y Footer) */
.main-container {
  /* Fondo ligeramente transparente para dejar ver el fondo y aplicar blur */
  background-color: rgba(3, 13, 31, 0.7); /* Opacidad ajustada para mayor visibilidad del fondo */
  backdrop-filter: blur(10px); /* Nivel de desenfoque del fondo detrás del elemento */
  -webkit-backdrop-filter: blur(10px); /* Compatibilidad con Safari */
}

.site-footer {
  background-color: rgba(2, 7, 27, 0.8); /* Esta es la que queremos cambiar */
  color: #ccc;
  padding: 40px 20px;
  margin-top: 40px;
  border-top: 1px solid var(--color-borde);
  backdrop-filter: blur(10px); /* Eliminar también el blur de aquí */
  -webkit-backdrop-filter: blur(10px);
}

/* Header principal */
.header-principal {
  background-color: rgba(2, 7, 27, 0.85); /* Ligeramente más opaco para el header */
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  padding: 10px 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid var(--color-borde);
  position: sticky;
  top: 0;
  z-index: 1000;
  flex-wrap: wrap;
}

/* Menús desplegables (Header y otros dropdowns) */
.dropdown-content {
  background-color: rgba(2, 7, 27, 0.95); /* Casi opaco para mejor legibilidad */
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  display: none;
  position: absolute;
  min-width: 220px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.5);
  z-index: 1001;
  border-radius: 5px;
  border: 1px solid var(--color-borde);
}

/* Tarjetas de producto */
.product-card {
  background-color: rgba(2, 7, 27, 0.42); /* Ajusta esta opacidad a tu gusto (entre 0 y 1) */
  backdrop-filter: blur(8px); /* Nivel de desenfoque. Puedes probar con 5px, 10px, etc. */
  -webkit-backdrop-filter: blur(8px); /* Para compatibilidad con navegadores Webkit (Chrome, Safari, Edge) */
  border: 1px solid var(--color-borde);
  border-radius: 8px;
  padding: 15px;
  display: flex;
  flex-direction: column;
  justify-content: space-between; 
  transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s ease-in-out; /* Añade border-color */
  width: 250px;
}

/* Modales (pop-ups) */
.modal-contenido {
  background-color: rgba(2, 9, 32, 0.36); /* Un poco más opaco para el contenido del modal */
  backdrop-filter: blur(12px); /* Un blur más intenso para el modal */
  -webkit-backdrop-filter: blur(12px);
  margin: 5% auto;
  padding: 20px;
  border: 1px solid #444;
  width: 90%;
  max-width: 1200px;
  border-radius: 8px;
  position: relative;
}

/* --- SCROLLBARS PERSONALIZADAS: Modal Contenido --- */

/* Estilos para navegadores basados en Webkit (Chrome, Safari, Edge, Opera) */
.modal-contenido::-webkit-scrollbar {
  width: 10px; /* Ancho de la scrollbar vertical */
  background-color: rgba(0, 0, 0, 0.2); /* Fondo de la pista de la scrollbar */
  border-radius: 5px; /* Bordes redondeados para la pista */
}

.modal-contenido::-webkit-scrollbar-thumb {
  background-color: var(--color-acento-principal); /* Color del "pulgar" (la barra arrastrable) */
  border-radius: 5px; /* Bordes redondeados para el pulgar */
  border: 2px solid rgba(0, 0, 0, 0.3); /* Un borde sutil para que resalte más */
}

.modal-contenido::-webkit-scrollbar-thumb:hover {
  background-color: #00b3cc; /* Color del pulgar al pasar el mouse por encima */
}

/* Estilos para Firefox (método estándar) */
.modal-contenido {
  scrollbar-width: thin; /* 'auto' | 'thin' | 'none' */
  scrollbar-color: var(--color-acento-principal) rgba(0, 0, 0, 0.2); /* pulgar pista */
}

/* --- FIN SCROLLBARS PERSONALIZADAS: Modal Contenido --- */

/* Modal del carrito */
.modal-carrito {
  background-color: rgba(4, 13, 37, 0.9); /* Más opaco para el carrito */
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  display: none;
  position: fixed;
  top: 0;
  right: 0;
  width: 380px;
  height: 100%;
  z-index: 1030;
  padding: 20px;
  box-shadow: -5px 0 15px rgba(0, 0, 0, 0.5);
  flex-direction: column;
}

/* --- FIN DE ESTILOS CON BLUR Y TRANSPARENCIA --- */

/* Resto de tu CSS (sin cambios en esta entrega) */

.header-principal .logo { font-size: 1.5rem; font-weight: bold; color: var(--color-acento-principal); }
.logo-container { display: flex; align-items: center; gap: 20px; min-width: 220px;}
.dropdown { position: relative; display: inline-block; }
.dropbtn { background-color: transparent; color: var(--color-texto); padding: 10px; font-size: 1rem; font-weight: bold; border: none; cursor: pointer; }
.dropbtn:hover, .dropbtn:focus { color: var(--color-acento-principal); }
.dropdown-content a { color: var(--color-texto); padding: 12px 16px; text-decoration: none; display: block; font-size: 0.9rem; }
.dropdown-content a:hover { background-color: var(--color-acento-principal); color: #14243d; }
.dropdown:hover .dropdown-content { display: block; }
.search-bar { flex-grow: 1; margin: 0 20px; max-width: 500px;min-width: 200px; }
.search-bar input { width: 100%; padding: 10px 15px;box-sizing: border-box ; border-radius: 20px; border: 1px solid var(--color-borde); background-color: var(--color-fondo); color: var(--color-texto); font-size: 1rem; }
.header-controls { display: flex; align-items: center; gap: 25px; min-width: 220px; justify-content: flex-end; flex-shrink: 0; }
.header-controls a { color: var(--color-texto); text-decoration: none; font-weight: bold; }
.header-controls a:hover { color: var(--color-acento-principal); }
.header-cart-icon { position: relative; cursor: pointer; }
.header-cart-icon .fa-shopping-cart { font-size: 1.5rem; color: var(--color-texto); }
.header-cart-icon .cart-counter { position: absolute; top: -8px; right: -12px; background-color: var(--color-acento-principal); color: #000; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold; }

.banner-container { width: 100%; max-width: 1600px; margin: 20px auto; position: relative; overflow: hidden; border-radius: 10px; }
.banner-carousel { display: flex; transition: transform 0.5s ease-in-out; }
.banner-slide { min-width: 100%; position: relative; }
.banner-slide img { width: 100%; height: 400px; object-fit: cover; display: block; }
.carousel-nav { position: absolute; top: 50%; transform: translateY(-50%); background-color: rgba(0,0,0,0.5); color: white; border: none; font-size: 2rem; cursor: pointer; padding: 10px; z-index: 10; }
.prev-btn { left: 10px; }
.next-btn { right: 10px; }

.main-container { padding: 20px; max-width: 1600px; margin: 0 auto; }
.categoria-seccion { margin-bottom: 40px; }
.categoria-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--color-acento-principal); padding-bottom: 10px; margin-bottom: 20px; }
.categoria-header h2 { color: var(--color-acento-principal); font-size: 1.8rem; margin: 0; }
.ver-mas-btn { color: var(--color-texto); text-decoration: none; font-weight: bold; cursor: pointer; }

.product-scroll-container { overflow-x: auto; padding-bottom: 15px; }

/* --- SCROLLBARS PERSONALIZADAS --- */

/* Estilos para navegadores basados en Webkit (Chrome, Safari, Edge, Opera) */
.product-scroll-container::-webkit-scrollbar {
  height: 10px; /* Ancho de la scrollbar horizontal */
  background-color: rgba(0, 0, 0, 0.2); /* Fondo de la pista de la scrollbar */
  border-radius: 5px; /* Bordes redondeados para la pista */
}

.product-scroll-container::-webkit-scrollbar-thumb {
  background-color: var(--color-acento-principal); /* Color del "pulgar" (la barra arrastrable) */
  border-radius: 5px; /* Bordes redondeados para el pulgar */
  border: 2px solid rgba(0, 0, 0, 0.3); /* Un borde sutil para que resalte más */
}

.product-scroll-container::-webkit-scrollbar-thumb:hover {
  background-color: #00b3cc; /* Color del pulgar al pasar el mouse por encima */
}

/* Estilos para Firefox (método estándar) */
.product-scroll-container {
  scrollbar-width: thin; /* 'auto' | 'thin' | 'none' */
  scrollbar-color: var(--color-acento-principal) rgba(0, 0, 0, 0.2); /* pulgar pista */
}

/* --- FIN SCROLLBARS PERSONALIZADAS --- */

.product-list { display: flex; gap: 20px; width: max-content; }
.product-card:hover {
  transform: translateY(6.5px); /* Mantener el ligero elevamiento si te gusta */
  /* Nuevo: Sombra brillante para un efecto de resplandor */
  box-shadow: 0 0 25px rgba(0, 230, 255, 0.6), /* Resplandor azulado/celeste */
              0 0 10px rgba(0, 230, 255, 0.4); /* Resplandor más suave */
  /* Nuevo: Borde que se ilumina con el color de acento */
  border-color: var(--color-acento-principal);
}
.product-card img { width: 100%; height: 200px; object-fit: contain; margin-bottom: 15px; cursor: pointer; }
.product-card .marca { font-weight: bold; font-size: 1.1rem; margin-bottom: 5px; }
.product-card .nombre { font-size: 0.9rem; color: #ccc; margin-bottom: 10px; flex-grow: 1; }
.product-card .precio { font-size: 1.5rem; font-weight: bold; color: var(--color-acento-secundario); margin-bottom: 10px; }
.add-to-cart-btn { background-color: var(--color-acento-principal); color: #14243d; border: none; border-radius: 5px; padding: 10px; font-size: 1.2rem; cursor: pointer; width: 100%; font-weight: bold; }

#btnScrollTop { position: fixed; bottom: 20px; right: 20px; background-color: var(--color-acento-principal); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 24px; cursor: pointer; display: none; z-index: 1000; }

.modal { display: none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.7); }
#categoria-modal { z-index: 1010; }
#modalProducto { z-index: 1020; }
#modal-pago { z-index: 1040; }
.modal-cerrar { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }

#categoria-modal-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; max-height: 70vh; overflow-y: auto; }

.modal-carrito h2 { color: var(--color-acento-principal); }
#modal-cart-list { list-style: none; padding: 0; flex-grow: 1; overflow-y: auto; }
.cart-item { display: flex; align-items: center; margin-bottom: 15px; }
.cart-item-img { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; margin-right: 15px; }
.cart-item-details { flex-grow: 1; }
.cart-item-name { font-weight: bold; }
.cart-item-price { font-size: 0.9rem; color: #ccc; }
#modal-cart-total { font-size: 1.2rem; font-weight: bold; margin-top: 20px; }
.cart-buttons { display: flex; flex-direction: column; gap: 10px; margin-top: 10px; }
.cart-buttons button { padding: 12px; border-radius: 5px; border: none; cursor: pointer; font-weight: bold; }
.cart-buttons .vaciar-btn { background-color: #555; color: #fff; }
.cart-buttons .comprar-btn { background-color: var(--color-acento-principal); color: #14243d; }

/* Estilos para el formulario de pago */
.form-pago-estilizado {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.form-pago-estilizado label {
    font-weight: bold;
    color: var(--color-texto);
}
.form-pago-estilizado input {
    width: 100%;
    padding: 12px 15px;
    box-sizing: border-box;
    border-radius: 5px;
    border: 1px solid var(--color-borde);
    background-color: var(--color-fondo);
    color: var(--color-texto);
    font-size: 1rem;
}
.form-pago-estilizado button {
    background-color: var(--color-acento-principal);
    color: #14243d;
    border: none;
    border-radius: 5px;
    padding: 15px;
    font-size: 1.2rem;
    cursor: pointer;
    font-weight: bold;
    margin-top: 10px;
}

/* Estilos para el nuevo layout del modal de pago */
.pago-layout {
    display: flex;
    gap: 30px;
}
.pago-formulario {
    flex: 2; /* Ocupa 2/3 del espacio */
}
.pago-resumen {
    flex: 1; /* Ocupa 1/3 del espacio */
    background-color: var(--color-tarjeta);
    padding: 20px;
    border-radius: 8px;
    border: 1px solid var(--color-borde);
}
.pago-resumen h3 {
    color: var(--color-acento-principal);
    margin-top: 0;
    border-bottom: 1px solid var(--color-borde);
    padding-bottom: 10px;
}
.resumen-linea {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}
.resumen-total {
    font-weight: bold;
    font-size: 1.3rem;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid var(--color-borde);
}
.metodos-pago {
    margin-top: 20px;
}
.metodos-pago h4 {
    color: var(--color-texto);
    margin-bottom: 10px;
}
.metodos-pago-iconos {
    display: flex;
    gap: 10px;
    font-size: 2rem; /* Tamaño de los iconos */
}

#toast { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: var(--color-acento-principal); color: #14243d; padding: 15px; border-radius: 8px; display: none; z-index: 1040; font-weight: bold; }

.footer-container { max-width: 1600px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; }
.footer-column h4 { color: var(--color-acento-principal); margin-bottom: 15px; }
.footer-column ul { list-style: none; padding: 0; }
.footer-column ul li { margin-bottom: 10px; }
.footer-column ul li a { color: #ccc; text-decoration: none; transition: color 0.2s; }
.footer-column ul li a:hover { color: var(--color-acento-principal); }
.footer-socials a { color: #ccc; margin-right: 15px; font-size: 1.5rem; }
.footer-bottom { text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--color-borde); font-size: 0.9rem; }
/* Responsive: en pantallas pequeñas, los elementos se apilan */
@media (max-width: 900px) {
  .header-principal {
    flex-direction: column;
    align-items: stretch;
    padding: 10px 10px;
  }
  .logo-container, .header-controls {
    justify-content: center;
    min-width: 0;
  }
  .search-bar {
    margin: 10px 0;
    max-width: 100%;
  }
}
/* ========== CHATBOT - MODO OSCURO ========== */
#techstore-chatbot-fab {
    position: fixed;
    bottom: 80px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg,rgb(15, 106, 224) 0%,rgb(0, 229, 236) 100%);
    color: #f8fafc;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    cursor: pointer;
    z-index: 9999;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    border: none;
}

#techstore-chatbot-fab:hover {
    transform: scale(1.1) rotate(10deg);
    background: linear-gradient(135deg,rgb(37, 82, 165) 0%,rgb(28, 75, 105) 100%);
}

#techstore-chatbot-container {
    position: fixed;
    bottom: 145px;
    right: 30px;
    width: 350px;
    border color:rgb(2, 210, 238);
    max-height: 60vh;
    background: #2d3748;
    border-radius: 12px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.25);
    z-index: 9998;
    display: none;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid #4a5568;
    height: 70vh; /* Ajusta la altura según tus necesidades */
    max-height: 600px; /* Evita que el chatbot ocupe toda la pantalla */
}

#techstore-chatbot-container .chatbot-header {
    background: linear-gradient(135deg,rgb(28, 148, 228) 0%,rgb(35, 126, 187) 100%);
    color: #f8fafc;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #4a5568;
    height: 60px;
    padding: 0 20px;
}

#techstore-chatbot-container .chatbot-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}

#techstore-chatbot-container .chatbot-close {
    background: none;
    border: none;
    color: #f8fafc;
    font-size: 24px;
    cursor: pointer;
    transition: transform 0.2s;
}

#techstore-chatbot-container .chatbot-close:hover {
    transform: rotate(90deg);
    color: #e2e8f0;
}

#techstore-chatbot-container .chatbot-body {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.chatbot-main {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 350px;
    height: 70vh;
    max-height: 600px;
    background: #2d3748;
    border-radius: 12px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.25);
    z-index: 9998;
    display: none;
    flex-direction: column;
    overflow: hidden;
}

/* CONTENEDOR PRINCIPAL (NUEVO) */
.chatbot-content-wrapper {
    display: flex;
    flex-direction: column;
    height: calc(100% - 60px); /* Resta la altura del header */
    position: relative;
}

/* ESTE ES EL BODY QUE FALTABA */
.chatbot-body {
    flex: 1;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}


/* AREA DE MENSAJES CON SCROLL */
#chatbot-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    overscroll-behavior: contain;
    scrollbar-width: thin;
    scrollbar-color: #4a5568 #2d3748;
}


.chatbot-message {
    max-width: 85%;
    padding: 12px 16px;
    border-radius: 18px;
    line-height: 1.4;
    font-size: 14px;
    animation: fadeIn 0.3s ease;
}

.chatbot-message.bot {
    align-self: flex-start;
    background: #2d3748;
    color: #e2e8f0;
    border: 1px solid #4a5568;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border-radius: 18px 18px 18px 4px;
}

.chatbot-message.user {
    align-self: flex-end;
    background:rgb(32, 111, 185);
    color: #f8fafc;
    border-radius: 18px 18px 4px 18px;
}

/* CONTENEDOR DE OPCIONES (FIJO EN EL FONDO) */
#chatbot-options {
    padding: 12px;
    background: #2d3748;
    border-top: 1px solid #4a5568;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    position: sticky;
    bottom: 0;
    z-index: 2;
}

.chatbot-option-btn {
    background: #4a5568;
    color: #f8fafc;
    border: none;
    border-radius: 20px;
    padding: 8px 16px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
    flex-grow: 1;
}

.chatbot-option-btn:hover {
    background:rgb(110, 166, 240);
    transform: translateY(-2px);
}

.chatbot-option-btn.back {
    background: #4a5568;
    color: #e2e8f0;
    border: 1px solid #718096;
}

/* Animación de entrada */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Barra de scroll personalizada */
#chatbot-messages::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

#chatbot-messages::-webkit-scrollbar-track {
    background: #2d3748;
    border-radius: 4px;
}

#chatbot-messages::-webkit-scrollbar-thumb {
    background-color: #4a5568;
    border-radius: 4px;
    border: 2px solid #2d3748;
}

#chatbot-messages::-webkit-scrollbar-thumb:hover {
    background-color: #5a67d8;
}

.chatbot-option-btn.product-option {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    text-align: left;
    padding: 10px 15px;
    margin-bottom: 5px;
}

.product-name {
    font-weight: 600;
    margin-bottom: 3px;
}

.product-price {
    color: #4a6bff;
    font-size: 0.9em;
}

.chatbot-option-btn.view-all {
    background: #4a5568;
    margin-top: 10px;
}

/* Animación para destacar productos */
@keyframes highlightProduct {
    0% { box-shadow: 0 0 0 0 rgba(74, 107, 255, 0); }
    50% { box-shadow: 0 0 0 10px rgba(74, 107, 255, 0.3); }
    100% { box-shadow: 0 0 0 0 rgba(74, 107, 255, 0); }
}

#metodo-pago {
  padding: 10px;
  border: none;
  border-radius: 5px;
  background-color:rgba(20, 61, 95, 0.75);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  font-size: 18px;
}

#metodo-pago option {
  padding: 10px;
  font-size: 18px;
  border-bottom: 1px solid #ccc;
}

#metodo-pago option:last-child {
  border-bottom: none;
}

#metodo-pago option[data-icon] {
  background-image: url('iconos.png');
  background-position: 10px 50%;
  background-repeat: no-repeat;
  padding-left: 40px;
}

/* Mejoras de rendimiento */
.chatbot-messages {
    will-change: transform;
    backface-visibility: hidden;
    transform: translateZ(0);
}

  </style>
</head>
<body>
<header class="header-principal">
  <div class="logo-container">
    <div class="logo">TechStore+</div>
    <div class="dropdown">
      <button class="dropbtn">Categorías <i class="fas fa-caret-down"></i></button>
      <div class="dropdown-content">
        <?php
          $categorias = array_keys($productos_por_categoria);
          foreach ($categorias as $categoria_item) {
            $ancla = strtolower(str_replace(' ', '-', $categoria_item));
            echo '<a href="#' . htmlspecialchars($ancla) . '">' . htmlspecialchars($categoria_item) . '</a>';
          }
        ?>
      </div>
    </div>
  </div>
  <div class="search-bar">
    <input id="searchInput" type="text" placeholder="Buscar productos..." autocomplete="off" onkeyup="searchProduct()" />
  </div>
  <div class="header-controls">
    <a href="index.php">Mi Cuenta</a>
    <div class="header-cart-icon" onclick="abrirModalCarrito()">
      <i class="fas fa-shopping-cart"></i>
      <span class="cart-counter" id="cart-icon-counter">0</span>
    </div>
    <a href="logout.php" title="Cerrar sesión">Cerrar Sesión</a>
  </div>
</header>

<!-- Modal para rellenar los datos y pagar el pedido -->
<div id="modal-pago" class="modal">
  <div class="modal-contenido" style="max-width: 900px;">
    <span class="modal-cerrar" onclick="document.getElementById('modal-pago').style.display='none'">&times;</span>
    <h2>Finalizar Compra</h2>
    <div class="pago-layout">
      <div class="pago-formulario">
        <form id="form-pago" class="form-pago-estilizado">
          <h4>Información de Contacto y Envío</h4>
          <label for="metodo-pago">Método de Pago:</label>
          <select id="metodo-pago" name="metodo-pago" class="form-pago-estilizado input" required>
            <option value="yape">Yape</option>
            <option value="plin">Plin</option>
            <option value="tarjeta">Tarjeta de crédito o débito</option>
          </select>

          <div id="datos-tarjeta" style="display: none;">
            <label for="numero-tarjeta">Número de Tarjeta:</label>
            <input type="text" id="numero-tarjeta" name="numero-tarjeta">
            <label for="fecha-vencimiento">Fecha de Vencimiento (MM/AA):</label>
            <input type="text" id="fecha-vencimiento" name="fecha-vencimiento">
            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv">
          </div>
          <button type="submit" id="pagar-pedido">Pagar Ahora</button>
        </form>
      </div>
      <div class="pago-resumen">
        <h3>Resumen</h3>
        <div class="resumen-linea">
          <span>Subtotal:</span>
          <span id="resumen-subtotal">S/ 0.00</span>
        </div>
        <div class="resumen-linea">
          <span>Envío:</span>
          <span id="resumen-envio">S/ 10.00</span>
        </div>
        <div class="resumen-linea resumen-total">
          <span>Total:</span>
          <span id="resumen-total">S/ 0.00</span>
        </div>
        <div class="metodos-pago">
          <h4>Paga con</h4>
          <div class="metodos-pago-iconos">
            <i class="fab fa-cc-visa"></i>
            <i class="fab fa-cc-mastercard"></i>
            <i class="fab fa-cc-amex"></i>
            <i class="fab fa-cc-paypal"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="banner-container">
  <div class="banner-carousel">
    <?php
    $imagenes = array(
      'https://hca.pe/storage/media/adZVDOOSWGi95ubjmRBYmnNJsxdoJr4i9TN5u1rP.png',
      'https://promart.vteximg.com.br/arquivos/ids/8826076-1000-1000/imageUrl_1.jpg?v=638825420000800000',
      'https://m.media-amazon.com/images/I/71AlcYfuONL._AC_SL1200_.jpg',
      'https://mac-center.com.pe/cdn/shop/files/iPhone_14_Midnight_PDP_Image_Spring23_Position-6_COES.jpg?v=1700293686&width=823',
      'https://img.kwcdn.com/product/fancy/a190b57e-bd2a-4788-87d1-c70145b81053.jpg?imageView2/2/w/800/q/70/format/webp'
    );
    shuffle($imagenes);
    foreach ($imagenes as $imagen) {
      echo '<div class="banner-slide"><img src="' . $imagen . '" alt="Imagen"></div>';
    }
    ?>
  </div>
  <button class="carousel-nav prev-btn">&#10094;</button>
  <button class="carousel-nav next-btn">&#10095;</button>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('.banner-carousel');
    if (!carousel) return;
    const slides = document.querySelectorAll('.banner-slide');
    if (slides.length === 0) return;
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentIndex = 0;
    function goToSlide(index) {
      if (slides.length === 0) return;
      if (index < 0) index = slides.length - 1;
      if (index >= slides.length) index = 0;
      carousel.style.transform = `translateX(-${index * 100}%)`;
      currentIndex = index;
    }
    prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
    nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));
    setInterval(() => goToSlide(currentIndex + 1), 5000);
  });
</script>

<main class="main-container">
  <?php foreach ($productos_por_categoria as $categoria => $productos): ?>
    <?php $ancla_categoria = strtolower(str_replace(' ', '-', $categoria)); ?>
    <section id="<?php echo htmlspecialchars($ancla_categoria); ?>" class="categoria-seccion">
      <div class="categoria-header">
        <h2><?php echo htmlspecialchars($categoria); ?></h2>
        <a class="ver-mas-btn" onclick="mostrarModalCategoria('<?php echo htmlspecialchars($categoria, ENT_QUOTES); ?>')">Ver más ></a>
      </div>
      <div class="product-scroll-container">
        <div class="product-list">
          <?php foreach (array_slice($productos, 0, 10) as $p): ?>
            <div class="product-card" data-nombre="<?php echo htmlspecialchars($p['nombre']); ?>" data-categoria="<?php echo htmlspecialchars($p['categoria']); ?>">
              <img src="<?php echo htmlspecialchars($p['imagen']); ?>" alt="<?php echo htmlspecialchars($p['nombre']); ?>" onclick='mostrarModalProducto(<?php echo json_encode($p); ?>)'>
              <div>
                <div class="marca"><?php echo htmlspecialchars($p['marca']); ?></div>
                <div class="nombre"><?php echo htmlspecialchars($p['nombre']); ?></div>
                <div class="precio">S/ <?php echo number_format($p['precio'], 2); ?></div>
                <button class="add-to-cart-btn" onclick='agregarAlCarrito(<?php echo json_encode($p); ?>)'>Añadir al Carrito</button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endforeach; ?>
</main>

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-column"><h4>ATENCIÓN AL CLIENTE</h4><ul><li><a href="#">Ventas: +51 9 02108400</a></li><li><a href="#">Atención Clientes: +51 1 7161666</a></li></ul></div>
        <div class="footer-column"><h4>SERVICIO AL CLIENTE</h4><ul><li><a href="#">Términos y Condiciones</a></li><li><a href="#">Libro de Reclamaciones</a></li><li><a href="#">Bases y Promociones</a></li></ul></div>
        <div class="footer-column"><h4>TECHSTORE+</h4><ul><li><a href="#">Nuestra Empresa</a></li><li><a href="#">Servicio Postventa</a></li><li><a href="#">Mapa de Productos</a></li></ul></div>
        <div class="footer-column"><h4>SÍGUENOS</h4><div class="footer-socials"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-tiktok"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div>
    </div>
    <div class="footer-bottom"><p>&copy; <?php echo date("Y"); ?> TechStore+ PERÚ SOCIEDAD ANÓNIMA CERRADA. RUC 20609893534</p></div>
</footer>

<button id="btnScrollTop" title="Ir arriba">&#8679;</button>

<div id="modalProducto" class="modal">
  <div class="modal-contenido">
    <span class="modal-cerrar" onclick="cerrarModalProducto()">&times;</span>
    <div id="modalImgGrandeContainer"></div><div id="modalGaleria" class="modal-galeria"></div><h2 id="modalNombre"></h2><p id="modalCategoria"></p><div id="modalDescripcion"></div>
  </div>
</div>

<div id="categoria-modal" class="modal">
    <div class="modal-contenido">
        <span class="modal-cerrar" onclick="cerrarModalCategoria()">&times;</span>
        <h2 id="categoria-modal-titulo"></h2>
        <div id="categoria-modal-grid"></div>
    </div>
</div>

<div id="carritoModal" class="modal-carrito">
  <h2>Carrito de Compras</h2>
  <ul id="modal-cart-list"></ul>
  <div>
    <p id="modal-cart-total"></p>
    <div class="cart-buttons">
      <button class="comprar-btn" onclick="solicitarCompra()">Solicitar compra</button>
      <button class="vaciar-btn" onclick="vaciarCarrito()">Vaciar carrito</button>
    </div>
  </div>
  <button onclick="cerrarCarrito()" style="background: none; border: none; color: #777; cursor: pointer; margin-top: 20px; align-self: center;">Cerrar</button>
</div>

<div id="toast"></div>

<script>
  const allProducts = <?php echo json_encode($all_products); ?>;
  let carrito = [];

  function solicitarCompra() {
    if (carrito.length === 0) {
      alert("El carrito está vacío.");
      return;
    }
    const datosPedido = carrito.map(p => ({ id: p.id, cantidad: p.cantidad }));
    fetch('registrar_pedido.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ carrito: datosPedido })
    })
    .then(res => res.text()) // Obtenemos siempre el texto de la respuesta
    .then(data => {
      // Usamos un toast para notificar en lugar de un alert
      mostrarToast(data);
      // Comprobamos si la respuesta es la de éxito para continuar
      if (data === "Pedido registrado exitosamente.") {
        // Si el pedido se registró, actualizamos el resumen y abrimos el modal
        actualizarResumenPago();
        cerrarCarrito();
        document.getElementById('modal-pago').style.display = 'block';
      }
    })
    .catch(errorPromise => errorPromise.then(error => alert('Error: ' + error)));
  }
  
  function abrirModalCarrito() { document.getElementById('carritoModal').style.display = 'flex'; }
  function cerrarCarrito() { document.getElementById('carritoModal').style.display = 'none'; }
  function vaciarCarrito() { carrito = []; actualizarCarrito(); }
  
  function actualizarCarrito() {
    const listaCarrito = document.getElementById('modal-cart-list');
    const totalCarrito = document.getElementById('modal-cart-total');
    const contadorIcono = document.getElementById('cart-icon-counter');
    listaCarrito.innerHTML = '';
    let total = 0;
    let cantidadTotal = 0;
    carrito.forEach(p => {
      const item = document.createElement('li');
      item.className = 'cart-item';
      item.innerHTML = `<img src="${p.imagen}" class="cart-item-img" alt=""><div class="cart-item-details"><div class="cart-item-name">${p.nombre}</div><div class="cart-item-price">x${p.cantidad} - S/ ${(p.precio * p.cantidad).toFixed(2)}</div></div>`;
      listaCarrito.appendChild(item);
      total += p.precio * p.cantidad;
      cantidadTotal += p.cantidad;
    });
    totalCarrito.innerText = `Total: S/ ${total.toFixed(2)}`;
    contadorIcono.innerText = cantidadTotal;
  }

  function actualizarResumenPago() {
    const subtotal = carrito.reduce((acc, p) => acc + p.precio * p.cantidad, 0);
    const envio = 10.00; // Costo de envío fijo como ejemplo
    const total = subtotal + envio;

    document.getElementById('resumen-subtotal').innerText = `S/ ${subtotal.toFixed(2)}`;
    document.getElementById('resumen-envio').innerText = `S/ ${envio.toFixed(2)}`;
    document.getElementById('resumen-total').innerText = `S/ ${total.toFixed(2)}`;
  }

  function agregarAlCarrito(producto) {
    const productoExistente = carrito.find(p => p.id === producto.id);
    if (productoExistente) { productoExistente.cantidad++; } else { carrito.push({ ...producto, cantidad: 1 }); }
    actualizarCarrito();
    mostrarToast(`'${producto.nombre}' agregado al carrito.`);
  }
  
  function mostrarModalProducto(producto) {
    document.getElementById('modalNombre').innerText = producto.nombre;
    document.getElementById('modalCategoria').innerText = producto.categoria;
    document.getElementById('modalDescripcion').innerHTML = `<p>${producto.descripcion}</p><strong>Precio: S/ ${parseFloat(producto.precio).toFixed(2)}</strong>`;
    
    const galeria = document.getElementById('modalGaleria');
    const imgGrande = document.getElementById('modalImgGrandeContainer');
    galeria.innerHTML = '';
    imgGrande.innerHTML = `<img src="${producto.imagen}" style="width:100%; max-height: 300px; object-fit: contain;">`;

    [producto.imagen, producto.imagen2, producto.imagen3].forEach(imgUrl => {
      if (imgUrl) {
        const imgThumb = document.createElement('img');
        imgThumb.src = imgUrl;
        imgThumb.style.width = '80px'; imgThumb.style.height = '80px'; imgThumb.style.objectFit = 'cover'; imgThumb.style.cursor = 'pointer';
        imgThumb.onclick = () => {
          imgGrande.innerHTML = `<img src="${imgUrl}" style="width:100%; max-height: 300px; object-fit: contain;">`;
        };
        galeria.appendChild(imgThumb);
      }
    });
    
    document.getElementById('modalProducto').style.display = 'block';
  }
  function cerrarModalProducto() { document.getElementById('modalProducto').style.display = 'none'; }

  function mostrarModalCategoria(categoria) {
    const modal = document.getElementById('categoria-modal');
    const titulo = document.getElementById('categoria-modal-titulo');
    const grid = document.getElementById('categoria-modal-grid');
    
    titulo.innerText = categoria;
    grid.innerHTML = '';

    const productosFiltrados = allProducts.filter(p => p.categoria === categoria);
    
    productosFiltrados.forEach(p => {
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <img src="${p.imagen}" alt="${p.nombre}" onclick='mostrarModalProducto(${JSON.stringify(p)})'>
            <div>
                <div class="marca">${p.marca}</div>
                <div class="nombre">${p.nombre}</div>
                <div class="precio">S/ ${parseFloat(p.precio).toFixed(2)}</div>
                <button class="add-to-cart-btn" onclick='agregarAlCarrito(${JSON.stringify(p)})'>Añadir al Carrito</button>
            </div>
        `;
        grid.appendChild(card);
    });

    modal.style.display = 'block';
  }
  function cerrarModalCategoria() { document.getElementById('categoria-modal').style.display = 'none'; }

  const btnScrollTop = document.getElementById('btnScrollTop');
  window.onscroll = () => { btnScrollTop.style.display = (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) ? "block" : "none"; };
  btnScrollTop.onclick = () => window.scrollTo({top: 0, behavior: 'smooth'});
  
  function searchProduct() {
    const filtro = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.product-card').forEach(card => {
      const nombre = card.dataset.nombre.toLowerCase();
      const categoria = card.dataset.categoria.toLowerCase();
      card.style.display = (nombre.includes(filtro) || categoria.includes(filtro)) ? 'flex' : 'none';
    });
  }
  function mostrarToast(mensaje) {
    const toast = document.getElementById('toast');
    toast.innerText = mensaje;
    toast.style.display = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 2000);
  }
  
  window.addEventListener('click', function(event) {
    // No cerrar si se hace clic en un botón que abre un modal
    if (event.target.closest('.product-card img, .ver-mas-btn, .header-cart-icon')) {
        return;
    }

    const modalProducto = document.getElementById('modalProducto');
    if (modalProducto && event.target == modalProducto) {
        cerrarModalProducto();
    }

    const categoriaModal = document.getElementById('categoria-modal');
    if (categoriaModal && event.target == categoriaModal) {
        cerrarModalCategoria();
    }

    const modalPago = document.getElementById('modal-pago');
    if (modalPago && event.target == modalPago) {
        modalPago.style.display = 'none';
    }
    
    const carritoModal = document.getElementById('carritoModal');
    if (carritoModal.style.display === 'flex' && !carritoModal.contains(event.target)) {
      cerrarCarrito();
    }
  });

  // Mostrar/ocultar campos de tarjeta según el método de pago
  document.getElementById('metodo-pago').addEventListener('change', function() {
    const datosTarjeta = document.getElementById('datos-tarjeta');
    if (this.value === 'tarjeta') {
      datosTarjeta.style.display = 'block';
      // Hacemos los campos de tarjeta requeridos
      document.getElementById('numero-tarjeta').required = true;
      document.getElementById('fecha-vencimiento').required = true;
      document.getElementById('cvv').required = true;
    } else {
      datosTarjeta.style.display = 'none';
      // Quitamos el requerimiento si no se usa tarjeta
      document.getElementById('numero-tarjeta').required = false;
      document.getElementById('fecha-vencimiento').required = false;
      document.getElementById('cvv').required = false;
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('.banner-carousel');
    if (!carousel) return;
    const slides = document.querySelectorAll('.banner-slide');
    if (slides.length === 0) return;
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentIndex = 0;
    function goToSlide(index) {
        if (slides.length === 0) return;
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;
        carousel.style.transform = `translateX(-${index * 100}%)`;
        currentIndex = index;
    }
    prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
    nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));
    setInterval(() => goToSlide(currentIndex + 1), 5000);

    document.querySelectorAll('.dropdown-content a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        if(targetElement) {
          const headerOffset = document.querySelector('.header-principal').offsetHeight;
          const elementPosition = targetElement.getBoundingClientRect().top;
          const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
    
          window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
          });
        }
      });
    });
  });

  // Manejo del formulario de pago
  document.getElementById('form-pago').addEventListener('submit', function(e) {
  e.preventDefault();

  // Solo simula si el método es tarjeta
  if (document.getElementById('metodo-pago').value === 'tarjeta') {
    const numero = document.getElementById('numero-tarjeta').value;
    const fecha = document.getElementById('fecha-vencimiento').value;
    const cvv = document.getElementById('cvv').value;

    fetch('simular_pago.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ numero, fecha, cvv })
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      if (data.status === 'success') {
        document.getElementById('modal-pago').style.display = 'none';
        vaciarCarrito();
      }
    })
    .catch(() => alert('Error al procesar el pago.'));
  } else {
    alert('¡Pago procesado exitosamente! Gracias por su compra.');
    document.getElementById('modal-pago').style.display = 'none';
    vaciarCarrito();
  }
});
</script>

<script>
  // Función para convertir colores hexadecimales a RGB (si los usaras)
  function hexToRgb(hex) {
    var r = parseInt(hex.substring(0, 2), 16);
    var g = parseInt(hex.substring(2, 4), 16);
    var b = parseInt(hex.substring(4, 6), 16);
    return [r, g, b];
  }

  function interpolateColor(color1, color2, factor) {
    var result = color1.slice();
    for (var i = 0; i < 3; i++) {
      result[i] = Math.round(result[i] + factor * (color2[i] - color1[i]));
    }
    return 'rgb(' + result.join(',') + ')';
  }

  // Colores oscuros para el fondo animado
  const backgroundColors = [
    [10, 15, 30],    // Azul muy oscuro
    [18, 24, 40],    // Azul grisáceo oscuro
    [28, 36, 56],    // Azul profundo
    [36, 44, 66],    // Azul gris oscuro
    [44, 54, 80],    // Azul oscuro con toque gris
    [30, 35, 50],    // Gris azulado oscuro
    [20, 25, 38]     // Azul casi negro
  ];

  const bodyElement = document.body;

  function handleScrollColorChange() {
    const scrollPosition = window.scrollY;
    const maxScroll = document.documentElement.scrollHeight - window.innerHeight;

    let scrollFactor = maxScroll > 0 ? scrollPosition / maxScroll : 0;
    scrollFactor = Math.max(0, Math.min(1, scrollFactor));

    const numColors = backgroundColors.length;
    if (numColors <= 1) {
      bodyElement.style.backgroundColor = numColors === 1 ? 'rgb(' + backgroundColors[0].join(',') + ')' : 'transparent';
      return;
    }

    const segmentLength = 1 / (numColors - 1);
    const currentSegmentIndex = Math.min(
      Math.floor(scrollFactor / segmentLength),
      numColors - 2
    );

    const segmentStartFactor = currentSegmentIndex * segmentLength;
    const factorInSegment = (scrollFactor - segmentStartFactor) / segmentLength;

    const color1 = backgroundColors[currentSegmentIndex];
    const color2 = backgroundColors[currentSegmentIndex + 1];

    const newColor = interpolateColor(color1, color2, factorInSegment);

    bodyElement.style.backgroundColor = newColor;
  }

  document.addEventListener('DOMContentLoaded', handleScrollColorChange);
  window.addEventListener('scroll', handleScrollColorChange);
  window.addEventListener('resize', handleScrollColorChange);
</script>

<div id="chatbot-root"></div>

<script>
  window.chatbotData = {
    categorias: <?php echo json_encode(array_keys($productos_por_categoria ?? [])); ?>,
    productos: <?php echo json_encode($productos_por_categoria ?? []); ?>
  };
</script>
<script src="js/script.js" defer></script> <!-- Ruta correcta a tu JS -->

</body>
</html>
