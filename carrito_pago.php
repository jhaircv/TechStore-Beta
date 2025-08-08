<?php
$carrito = json_decode($_POST['carrito'], true);

if (isset($_POST['pago'])) {
    // Simular pago exitoso
    echo "Pago realizado con éxito!";
    // Enviar correo electrónico de confirmación
    // ...
} else {
    // Mostrar formulario de pago
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Pago de Carrito</title>
        <link rel="stylesheet" href="estilos.css">
        <style>
            /* Estilos para la página de pago */
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
            }

            .container {
                max-width: 800px;
                margin: 40px auto;
                padding: 20px;
                background-color: #fff;
                border: 1px solid #ddd;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h2 {
                font-size: 24px;
                margin-bottom: 10px;
            }

            ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            li {
                padding: 10px;
                border-bottom: 1px solid #ccc;
            }

            li:last-child {
                border-bottom: none;
            }

            .product-name {
                font-weight: bold;
            }

            .product-price {
                font-size: 18px;
                color: #666;
            }

            .total {
                font-size: 24px;
                font-weight: bold;
                margin-top: 20px;
            }

            .form-pago {
                margin-top: 20px;
            }

            .form-pago button[type="submit"] {
                background-color: #4CAF50;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .form-pago button[type="submit"]:hover {
                background-color: #3e8e41;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Detalles del pedido</h2>
            <ul>
                <?php foreach ($carrito as $producto) { ?>
                    <li>
                        <span class="product-name"><?php echo $producto['nombre']; ?></span> x <?php echo $producto['cantidad']; ?>
                        - S/ <?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?>
                    </li>
                <?php } ?>
            </ul>
            <p class="total">Total: S/ <?php echo number_format(array_sum(array_column($carrito, 'precio')) * array_sum(array_column($carrito, 'cantidad')), 2); ?></p>
            <form class="form-pago" action="" method="post">
                <input type="hidden" name="pago" value="true">
                <button type="submit">Realizar pago</button>
            </form>
        </div>
    </body>
    </html>
    <?php
}