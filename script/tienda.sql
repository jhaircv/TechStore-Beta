-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-08-2025 a las 21:11:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `productos` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `username`, `productos`, `total`, `fecha`) VALUES
(1, 'jhair', '[{\"id\":47,\"nombre\":\"Auriculares Apple EarPods\",\"cantidad\":1,\"precio_unitario\":\"200.00\"}]', 200.00, '2025-07-02 21:01:15'),
(2, 'jhair', '[{\"id\":49,\"nombre\":\"Auriculares Bose QuietComfort 35 II\",\"cantidad\":1,\"precio_unitario\":\"250.00\"},{\"id\":48,\"nombre\":\"Auriculares Bose QuietComfort 45\",\"cantidad\":1,\"precio_unitario\":\"300.00\"}]', 550.00, '2025-07-18 17:39:54'),
(3, 'rey', '[{\"id\":49,\"nombre\":\"Auriculares Bose QuietComfort 35 II\",\"cantidad\":1,\"precio_unitario\":\"250.00\"},{\"id\":48,\"nombre\":\"Auriculares Bose QuietComfort 45\",\"cantidad\":1,\"precio_unitario\":\"300.00\"}]', 550.00, '2025-07-18 17:52:32'),
(4, 'rey', '[{\"id\":47,\"nombre\":\"Auriculares Apple EarPods\",\"cantidad\":1,\"precio_unitario\":\"200.00\"},{\"id\":45,\"nombre\":\"Auriculares Apple AirPods Max\",\"cantidad\":1,\"precio_unitario\":\"250.00\"}]', 450.00, '2025-07-21 18:36:00'),
(5, 'rey', '[{\"id\":49,\"nombre\":\"Auriculares Bose QuietComfort 35 II\",\"cantidad\":1,\"precio_unitario\":\"250.00\"},{\"id\":47,\"nombre\":\"Auriculares Apple EarPods\",\"cantidad\":1,\"precio_unitario\":\"200.00\"}]', 450.00, '2025-07-22 17:33:13'),
(6, 'rey', '[{\"id\":47,\"nombre\":\"Auriculares Apple EarPods\",\"cantidad\":1,\"precio_unitario\":\"200.00\"},{\"id\":45,\"nombre\":\"Auriculares Apple AirPods Max\",\"cantidad\":1,\"precio_unitario\":\"250.00\"}]', 450.00, '2025-08-08 17:28:54'),
(7, 'rey', '[{\"id\":47,\"nombre\":\"Auriculares Apple EarPods\",\"cantidad\":1,\"precio_unitario\":\"200.00\"},{\"id\":45,\"nombre\":\"Auriculares Apple AirPods Max\",\"cantidad\":1,\"precio_unitario\":\"250.00\"}]', 450.00, '2025-08-08 17:30:46'),
(8, 'rey', '[{\"id\":47,\"nombre\":\"Auriculares Apple EarPods\",\"cantidad\":1,\"precio_unitario\":\"200.00\"},{\"id\":45,\"nombre\":\"Auriculares Apple AirPods Max\",\"cantidad\":1,\"precio_unitario\":\"250.00\"}]', 450.00, '2025-08-08 17:30:53'),
(9, 'rey', '[{\"id\":49,\"nombre\":\"Auriculares Bose QuietComfort 35 II\",\"cantidad\":1,\"precio_unitario\":\"250.00\"},{\"id\":47,\"nombre\":\"Auriculares Apple EarPods\",\"cantidad\":1,\"precio_unitario\":\"200.00\"}]', 450.00, '2025-08-08 17:32:26'),
(10, 'jhair', '[{\"id\":49,\"nombre\":\"Auriculares Bose QuietComfort 35 II\",\"cantidad\":1,\"precio_unitario\":\"250.00\"}]', 250.00, '2025-08-08 21:01:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `imagen2` varchar(255) DEFAULT NULL,
  `imagen3` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `categoria`, `precio`, `marca`, `imagen`, `imagen2`, `imagen3`, `descripcion`, `stock`) VALUES
(1, 'Laptop ASUS ROG', 'Laptop', 1500.00, 'Asus', 'https://tiendainfotech.com/wp-content/uploads/2024/07/1-121.jpg', NULL, NULL, 'La ASUS ROG es una laptop gamer de alto rendimiento, diseñada para los jugadores más exigentes. Cuenta con potentes gráficos, pantalla de alta tasa de refresco y un sistema de refrigeración avanzado para largas sesiones de juego.', 28),
(2, 'Laptop Lenovo IdeaPad 3', 'Laptop', 2049.00, 'Lenovo', 'https://promart.vteximg.com.br/arquivos/ids/8597956-1000-1000/imageUrl_1.jpg?v=638752843016670000', NULL, NULL, 'La Lenovo IdeaPad 3 es una laptop versátil y asequible, ideal para estudiantes y profesionales. Ofrece un buen rendimiento para tareas diarias como navegación web, procesamiento de textos y multimedia.', 0),
(3, 'Laptop Dell XPS 13', 'Laptop', 1800.00, 'Dell', 'https://promart.vteximg.com.br/arquivos/ids/8311207-1000-1000/image.jpg?v=638653579925500000', NULL, NULL, 'El Dell XPS 13 es una laptop premium con un diseño elegante y un rendimiento excepcional. Ideal para profesionales que buscan una máquina potente y portátil para trabajar en cualquier lugar.', 0),
(4, 'Laptop HP Pavilion', 'Laptop', 750.00, 'HP', 'https://rimage.ripley.com.pe/home.ripley/Attachment/WOP/1/2004335737608/full_image-2004335737608.WEBP', NULL, NULL, 'La HP Pavilion es una laptop confiable y asequible, ideal para estudiantes y profesionales que necesitan una máquina para tareas diarias como navegación web, procesamiento de textos y multimedia.', 0),
(5, 'Laptop HP 15 RTX 3050', 'Laptop', 800.00, 'HP', 'https://promart.vteximg.com.br/arquivos/ids/8084079-1000-1000/image-fa201e31fe67455ca7cefde342a5896b.jpg?v=638574430171730000', NULL, NULL, 'Una laptop confiable y eficiente con procesador AMD Ryzen 5, ideal para estudiantes y profesionales que buscan rendimiento sin comprometer el presupuesto.', 0),
(6, 'Laptop Asus TUF A15', 'Laptop', 1200.00, 'Asus', 'https://imagedelivery.net/4fYuQyy-r8_rpBpcY7lH_A/falabellaPE/144383113_01/w=1500,h=1500,fit=pad', NULL, NULL, 'La Lenovo Core i7 es una laptop potente y versátil, perfecta para tareas intensivas como edición de video, diseño gráfico y programación. Su pantalla de alta resolución y teclado ergonómico la hacen ideal para largas jornadas de trabajo.', 16),
(7, 'Laptop Dell Inspiron', 'Laptop', 2899.00, 'Dell', 'https://promart.vteximg.com.br/arquivos/ids/8021346-1000-1000/imageUrl_1.jpg?v=638543306850430000', NULL, NULL, 'La Dell Inspiron es una laptop equilibrada que combina rendimiento y portabilidad. Con un diseño elegante y características sólidas, es ideal para estudiantes y profesionales que necesitan una máquina confiable para el día a día.', 0),
(8, 'Laptop Apple MacBook Pro', 'Laptop', 2000.00, 'Apple', 'https://promart.vteximg.com.br/arquivos/ids/8826076-1000-1000/imageUrl_1.jpg?v=638825420000800000', NULL, NULL, 'El MacBook Pro es una laptop de alto rendimiento con el chip M1 Pro de Apple. Ofrece una pantalla Liquid Retina XDR, larga duración de batería y un rendimiento excepcional para profesionales creativos.', 0),
(9, 'Laptop Apple MacBook Air', 'Laptop', 1400.00, 'Apple', 'https://rymportatiles.com.pe/cdn/shop/files/MACBOOK-AIR-A2337-GOLD_a923a779-4d43-49af-918b-181bc4808cef.png?v=1728926477&width=1214', NULL, NULL, 'El MacBook Air es una laptop ultradelgada y ligera, con el potente chip M2 de Apple. Ofrece un rendimiento excepcional, larga duración de batería y una pantalla Retina impresionante, ideal para usuarios que buscan portabilidad y potencia.', 0),
(10, 'Laptop Acer Aspire 5', 'Laptop', 600.00, 'Acer', 'https://www.pcfactory.com.pe/public/foto/3163/1_1000.jpg?t=1748747209982', NULL, NULL, 'La Acer Aspire 5 es una laptop asequible con un buen equilibrio entre rendimiento y precio. Ideal para estudiantes y profesionales que necesitan una máquina confiable para tareas diarias como navegación web, procesamiento de textos y multimedia.', 0),
(11, 'Laptop Acer Nitro 5', 'Laptop', 900.00, 'Acer', 'https://promart.vteximg.com.br/arquivos/ids/8258364-1000-1000/image-0.jpg?v=638652308545700000', NULL, NULL, 'La Acer Nitro 5 es una laptop gamer con un diseño agresivo y un rendimiento potente. Ideal para jugadores que buscan una máquina asequible pero capaz de manejar los últimos juegos con gráficos intensivos.', 0),
(12, 'Teclado Mecánico Corsair', 'Teclado', 350.00, 'Corsair', 'https://img.kwcdn.com/product/fancy/a190b57e-bd2a-4788-87d1-c70145b81053.jpg?imageView2/2/w/800/q/70/format/webp', NULL, NULL, 'Un teclado mecánico de alto rendimiento con retroiluminación RGB, ideal para gamers y escritores que buscan precisión y durabilidad.', 0),
(13, 'Teclado Logitech G Pro', 'Teclado', 230.00, 'Logitech', 'https://img.kwcdn.com/product/fancy/e4b109d1-39d0-40ee-a9a9-c9391d8a7267.jpg?imageView2/2/w/800/q/70/format/webp', NULL, NULL, 'El Logitech G Pro es un teclado mecánico compacto diseñado para esports, con switches de alta calidad y retroiluminación personalizable.', 0),
(14, 'Teclado Razer BlackWidow', 'Teclado', 250.00, 'Razer', 'https://img.kwcdn.com/product/fancy/706c7a39-8efd-4779-b541-5cc9e4d2ce81.jpg?imageView2/2/w/800/q/70/format/webp', NULL, NULL, 'Un teclado mecánico con switches Razer, retroiluminación RGB y un diseño robusto, ideal para gamers que buscan una experiencia de juego superior.', 0),
(15, 'Teclado HyperX Alloy', 'Teclado', 200.00, 'HyperX', 'https://phantom.pe/media/catalog/product/cache/c58c05327f55128aefac5642661cf3d1/2/_/2_37_.jpg', 'https://phantom.pe/media/catalog/product/cache/c58c05327f55128aefac5642661cf3d1/2/_/2_36_.jpg', '', 'El HyperX Alloy es un teclado mecánico compacto con retroiluminación roja, diseñado para ofrecer durabilidad y rendimiento en juegos.', 0),
(16, 'Teclado Logitech K380', 'Teclado', 50.00, 'Logitech', 'https://media.falabella.com/falabellaPE/119931484_01/w=1500,h=1500,fit=pad', NULL, NULL, 'Un teclado inalámbrico compacto y portátil, ideal para uso diario y compatible con múltiples dispositivos, con teclas silenciosas y diseño ergonómico.', 0),
(17, 'Teclado Apple Magic Keyboard', 'Teclado', 120.00, 'Apple', 'https://oechsle.vteximg.com.br/arquivos/ids/15551532-1000-1000/image-0.jpg?v=638278958385570000', 'https://pe.tiendasishop.com/cdn/shop/files/MXCL3E-A-3.webp?v=1736444911&width=1000', '', 'El Apple Magic Keyboard es un teclado inalámbrico elegante y minimalista, con teclas de perfil bajo y una batería recargable de larga duración, ideal para usuarios de Mac.', 0),
(18, 'Teclado Redragon K552', 'Teclado', 70.00, 'Redragon', 'https://media.falabella.com/falabellaPE/126067425_01/w=1500,h=1500,fit=pad', NULL, NULL, 'Un teclado mecánico compacto y asequible, con retroiluminación LED y switches mecánicos, ideal para gamers que buscan calidad a un buen precio.', 0),
(19, 'Teclado Logitech G915', 'Teclado', 300.00, 'Logitech', 'https://www.logitech.com/assets/65520/images/gaming-keyboards/g915-tkl/g915-tkl-gallery-1.png', NULL, NULL, 'El Logitech G915 es un teclado mecánico inalámbrico de alto rendimiento, con switches mecánicos de perfil bajo, retroiluminación RGB y un diseño elegante y delgado, ideal para gamers y profesionales que buscan una experiencia de escritura premium.', 0),
(20, 'Teclado Corsair K95 RGB Platinum', 'Teclado', 400.00, 'Corsair', 'https://hca.pe/storage/media/large_HJx5wr7NyM2VVETY1SCfTgOrTKNuDDlK1YkI79hK.png', '', '', 'Un teclado mecánico premium con retroiluminación RGB, teclas macro programables y un diseño robusto, ideal para gamers que buscan personalización y rendimiento .', 0),
(21, 'Teclado Logitech G413', 'Teclado', 100.00, 'Logitech', 'https://www.logitech.com/assets/65520/images/gaming-keyboards/g413/g413-gallery-1.png', NULL, NULL, 'Un teclado mecánico con retroiluminación roja, diseño elegante y teclas de alta precisión, ideal para gamers que buscan un teclado asequible pero de calidad.', 0),
(22, 'Teclado Razer Huntsman Elite', 'Teclado', 280.00, 'Razer', 'https://www.razer.com/on/demandware.static/-/Sites-razersouthamerica-Library/default/dw8f0c1b2d/images/products/razer-huntsman-elite/razer-huntsman-elite-gallery-1.jpg', NULL, NULL, 'Un teclado mecánico con switches ópticos Razer, retroiluminación RGB y un reposamuñecas ergonómico, ideal para gamers que buscan una experiencia de juego superior.', 0),
(23, 'Teclado Logitech K120', 'Teclado', 30.00, 'Logitech', 'https://media.falabella.com/falabellaPE/126067425_01/w=1500,h=1500,fit=pad', NULL, NULL, 'Un teclado de membrana básico y asequible, ideal para uso diario en oficina o en casa, con un diseño resistente y teclas silenciosas.', 0),
(24, 'Teclado Corsair K55 RGB', 'Teclado', 80.00, 'Corsair', 'https://hca.pe/storage/media/large_0Z2X5OPHlJvm1TbDBhrGhLItxypwzWtDdo8WFInn.png', '', '', 'Un teclado de membrana con retroiluminación RGB, teclas multimedia y un diseño ergonómico, ideal para gamers que buscan un teclado asequible con estilo.', 0),
(25, 'Teclado Logitech G815', 'Teclado', 250.00, 'Logitech', 'https://www.logitech.com/assets/65520/images/gaming-keyboards/g815/g815-gallery-1.png', NULL, NULL, 'Un teclado mecánico de perfil bajo con retroiluminación RGB, switches mecánicos de alta calidad y un diseño elegante y delgado, ideal para gamers y profesionales que buscan una experiencia de escritura premium.', 0),
(26, 'Teclado HyperX Alloy Origins Core', 'Teclado', 150.00, 'HyperX', 'https://www.hyperxgaming.com/media/catalog/product/cache/1/image/800x800/9df78eab33525d08d6e5fb8d27136e95/h/y/hyperx-alloy-origins-core-mechanical-gaming-keyboard-1.jpg', NULL, NULL, 'Un teclado mecánico compacto con retroiluminación RGB, switches mecánicos HyperX y un diseño robusto, ideal para gamers que buscan calidad y portabilidad.', 0),
(27, 'Teclado Corsair K70 RGB MK.2', 'Teclado', 300.00, 'Corsair', 'https://oechsle.vteximg.com.br/arquivos/ids/18281160-1000-1000/image-690523f646df49ae8207e3e848afc0a2.jpg?v=638552971728630000', 'https://oechsle.vteximg.com.br/arquivos/ids/18281179-1000-1000/image-ed0e216c380d47d3b810cc2b1cff6abd.jpg?v=638552971712700000', '', 'Un teclado mecánico premium con retroiluminación RGB, teclas macro programables y un diseño robusto, ideal para gamers que buscan personalización y rendimiento.', 0),
(28, 'Teclado Logitech G915 TKL', 'Teclado', 350.00, 'Logitech', 'https://www.logitech.com/assets/65520/images/gaming-keyboards/g915-tkl/g915-tkl-gallery-1.png', NULL, NULL, 'Un teclado mecánico inalámbrico de alto rendimiento, con switches mecánicos de perfil bajo, retroiluminación RGB y un diseño elegante y delgado, ideal para gamers y profesionales que buscan una experiencia de escritura premium.', 0),
(29, 'Teclado Razer Cynosa V2', 'Teclado', 70.00, 'Razer', 'https://www.razer.com/on/demandware.static/-/Sites-razersouthamerica-Library/default/dw8f0c1b2d/images/products/razer-cynosa-v2/razer-cynosa-v2-gallery-1.jpg', NULL, NULL, 'Un teclado de membrana con retroiluminación RGB, teclas multimedia y un diseño ergonómico, ideal para gamers que buscan un teclado asequible con estilo.', 0),
(30, 'Teclado Logitech K400 Plus', 'Teclado', 60.00, 'Logitech', 'https://media.falabella.com/falabellaPE/126067425_01/w=1500,h=1500,fit=pad', NULL, NULL, 'Un teclado inalámbrico compacto con touchpad integrado, ideal para controlar dispositivos multimedia desde el sofá o la cama.', 0),
(31, 'Teclado Redragon K552 Kumara', 'Teclado', 70.00, 'Redragon', 'https://media.falabella.com/falabellaPE/126067425_01/w=1500,h=1500,fit=pad', NULL, NULL, 'Un teclado mecánico compacto y asequible, con retroiluminación LED y switches mecánicos, ideal para gamers que buscan calidad a un buen precio.', 0),
(32, 'Teclado Logitech G413 Carbon', 'Teclado', 100.00, 'Logitech', 'https://www.logitech.com/assets/65520/images/gaming-keyboards/g413/g413-gallery-1.png', NULL, NULL, 'Un teclado mecánico con retroiluminación roja, diseño elegante y teclas de alta precisión, ideal para gamers que buscan un teclado asequible pero de calidad.', 0),
(33, 'Teclado Razer Huntsman Mini', 'Teclado', 150.00, 'Razer', 'https://www.razer.com/on/demandware.static/-/Sites-razersouthamerica-Library/default/dw8f0c1b2d/images/products/razer-huntsman-mini/razer-huntsman-mini-gallery-1.jpg', NULL, NULL, 'Un teclado mecánico compacto con switches ópticos Razer, retroiluminación RGB y un diseño portátil, ideal para gamers que buscan una experiencia de juego superior en un formato pequeño.', 0),
(34, 'Teclado Logitech G815 TKL', 'Teclado', 250.00, 'Logitech', 'https://www.logitech.com/assets/65520/images/gaming-keyboards/g815-tkl/g815-tkl-gallery-1.png', NULL, NULL, 'Un teclado mecánico de perfil bajo con retroiluminación RGB, switches mecánicos de alta calidad y un diseño elegante y delgado, ideal para gamers y profesionales que buscan una experiencia de escritura premium.', 0),
(35, 'Teclado HyperX Alloy Elite 2', 'Teclado', 200.00, 'HyperX', 'https://hca.pe/storage/media/large_gEzUjHgWclXfL1RTPtw1HumReCUHlI8ZhloO8sri.png', 'https://hca.pe/storage/media/large_PUPysZzOKIct48XotJ0fscYKB3n29u6VvIF56rUN.png', 'https://hca.pe/storage/media/large_JrWVqFXcDStxaLSl8qQhgGweBdcM40mQD93MhUxH.png', 'Un teclado mecánico premium con retroiluminación RGB, teclas multimedia y un diseño robusto, ideal para gamers que buscan personalización y rendimiento.', 0),
(36, 'Teclado Logitech K120', 'Teclado', 30.00, 'Logitech', 'https://media.falabella.com/falabellaPE/126067425_01/w=1500,h=1500,fit=pad', NULL, NULL, 'Un teclado de membrana básico y asequible, ideal para uso diario en oficina o en casa, con un diseño resistente y teclas silenciosas.', 0),
(37, 'Auriculares Sony WH-1000XM4', 'Auriculares', 100.00, 'Sony', 'https://media.falabella.com/falabellaPE/126067425_01/w=1500,h=1500,fit=pad', NULL, NULL, 'Auriculares Sony con cancelación de ruido, sonido envolvente y diseño ergonómico, ideales para disfrutar de música y películas sin distracciones.', 0),
(38, 'Auricularres Sony WH-1000XM5', 'Auriculares', 150.00, 'Sony', 'https://oechsle.vteximg.com.br/arquivos/ids/20196434-1000-1000/2167852jpg.jpg?v=638699808991170000', NULL, NULL, 'Los Sony WH-1000XM5 son auriculares inalámbricos con cancelación de ruido líder en la industria, sonido de alta calidad y batería de larga duración, ideales para viajes y uso diario.', 0),
(39, 'Auriculares Sony WH-CH520', 'Auriculares', 70.00, 'Sony', 'https://media.falabella.com/falabellaPE/19818037_01/w=1500,h=1500,fit=pad', NULL, NULL, 'Los Sony WH-CH520 son auriculares inalámbricos con sonido claro y batería de larga duración, ideales para escuchar música y hacer llamadas con comodidad.', 0),
(40, 'Auriculares JBL Tune 520 BT', 'Auriculares', 80.00, 'JBL', 'https://media.falabella.com/falabellaPE/126985776_01/w=1500,h=1500,fit=pad', NULL, NULL, 'Los auriculares JBL ofrecen un sonido potente y claro, con conectividad Bluetooth y diseño plegable para mayor comodidad al transportarlos.', 0),
(41, 'Auriculares JBL Tune 760NC', 'Auriculares', 190.00, 'JBL', 'https://www.jbl.com.pe/dw/image/v2/AAUJ_PRD/on/demandware.static/-/Sites-masterCatalog_Harman/default/dw44b56b01/JBL_Tune760NC_Box_Image_Black_SKU_1605x1605px.png?sw=537&sfrm=png', NULL, NULL, 'Los JBL Tune 760NC son auriculares inalámbricos con cancelación de ruido activa, sonido potente y batería de larga duración, ideales para disfrutar de música sin distracciones.', 0),
(42, 'Auriculares JBL Live 660NC', 'Auriculares', 220.00, 'JBL', 'https://oechsle.vteximg.com.br/arquivos/ids/20658249-1000-1000/imageUrl_1.jpg?v=638769517924300000', NULL, NULL, 'Los JBL Live 660NC son auriculares inalámbricos con cancelación de ruido activa, sonido premium y batería de larga duración, ideales para disfrutar de música en cualquier lugar.', 0),
(43, 'Auriculares Logitech G Pro', 'Auriculares', 90.00, 'Logitech', 'https://oechsle.vteximg.com.br/arquivos/ids/3113354-1000-1000/image-e863269f2c9949018689466c6c7d5e24.jpg?v=637494627440730000', NULL, NULL, 'Auriculares Logitech con micrófono integrado, ideales para videollamadas y conferencias, con sonido nítido y diseño cómodo para largas horas de uso.', 0),
(44, 'Auriculares Logitech G733', 'Auriculares', 200.00, 'Logitech', 'https://hca.pe/storage/media/adZVDOOSWGi95ubjmRBYmnNJsxdoJr4i9TN5u1rP.png', NULL, NULL, 'Los Logitech G733 son auriculares inalámbricos con sonido envolvente, micrófono desmontable y diseño ligero, ideales para gamers que buscan comodidad y rendimiento.', 0),
(45, 'Auriculares Apple AirPods Max', 'Auriculares', 250.00, 'Apple', 'https://mac-center.com.pe/cdn/shop/files/AirPods_Max_2024_Purple_PDP_Image_Position_1__GENS_f774a272-3d1c-4fd2-a3c8-82c4e92f45e2.jpg?v=1726584425', NULL, NULL, 'Los AirPods Pro de Apple ofrecen cancelación activa de ruido, sonido de alta calidad y un ajuste cómodo, ideales para quienes buscan una experiencia auditiva premium.', 0),
(46, 'Auriculares Apple AirPods Gen 4', 'Auriculares', 150.00, 'Apple', 'https://casemotions.pe/wp-content/uploads/2024/10/AIRPODS4ANC_003.jpg', NULL, NULL, 'Los AirPods Gen 4 de Apple ofrecen cancelación activa de ruido, sonido de alta calidad y un ajuste cómodo, ideales para quienes buscan una experiencia auditiva premium.', 0),
(47, 'Auriculares Apple EarPods', 'Auriculares', 200.00, 'Apple', 'https://casemotions.pe/wp-content/uploads/2020/11/1c4de0e5-1f7f-49ee-9c1c-9f6824c13b7e_1.6e34f5916841ec457ea093899457883b.jpeg', 'https://casemotions.pe/wp-content/uploads/2022/09/AIRPODSPRO2_0.jpg', '', 'Los Apple EarPods son auriculares inalámbricos con sonido claro y batería de larga duración, ideales para escuchar música y hacer llamadas con comodidad.', 0),
(48, 'Auriculares Bose QuietComfort 45', 'Auriculares', 300.00, 'Bose', 'https://assets.bose.com/content/dam/cloudassets/Bose_DAM/Web/consumer_electronics/global/products/headphones/qc45/product_silo_images/QC45_PDP_Ecom-Gallery-B04.jpg/jcr:content/renditions/cq5dam.web.600.600.jpeg', NULL, NULL, 'Los auriculares Bose QuietComfort 45 ofrecen una cancelación de ruido líder en la industria, sonido premium y comodidad para largas sesiones de escucha.', 0),
(49, 'Auriculares Bose QuietComfort 35 II', 'Auriculares', 250.00, 'Bose', 'https://assets.bose.com/content/dam/cloudassets/Bose_DAM/Web/consumer_electronics/global/products/headphones/qc35_ii/product_silo_images/qc35_ii_rose_gold_EC_hero.PNG/jcr:content/renditions/cq5dam.web.1280.1280.png', NULL, NULL, 'Los Bose QuietComfort 35 II son auriculares inalámbricos con cancelación de ruido activa, sonido premium y batería de larga duración, ideales para disfrutar de música sin distracciones.', 0),
(50, 'Auriculares Bose SoundLink II', 'Auriculares', 180.00, 'Bose', 'https://assets.bose.com/content/dam/Bose_DAM/Web/consumer_electronics/global/products/headphones/soundlink_around-ear_wireless_headphones_II/product_silo_images/sl_ae_II_black_EC_hero.psd/jcr:content/renditions/cq5dam.web.600.600.png', NULL, NULL, 'Los auriculares Bose SoundLink II ofrecen un sonido claro y potente, con conectividad Bluetooth y diseño plegable para mayor comodidad al transportarlos.', 0),
(51, 'Auriculares Sennheiser Momentum 4', 'Auriculares', 300.00, 'Sennheiser', 'https://media.falabella.com/falabellaPE/122576918_01/w=1500,h=1500,fit=pad', NULL, NULL, 'Los Sennheiser Momentum 4 son auriculares inalámbricos con cancelación de ruido, sonido de alta fidelidad y batería de larga duración, ideales para audiófilos.', 0),
(52, 'Auriculares Sennheiser HD 280 Pro', 'Auriculares', 120.00, 'Sennheiser', 'https://oechsle.vteximg.com.br/arquivos/ids/15364806-1000-1000/image-0.jpg?v=638282667388170000', NULL, NULL, 'Los Sennheiser HD 280 Pro son auriculares cerrados de estudio, ideales para monitoreo y grabación, con excelente aislamiento de sonido y comodidad para largas sesiones.', 0),
(53, 'Auriculares Sennheiser HD 450BT', 'Auriculares', 170.00, 'Sennheiser', 'https://promart.vteximg.com.br/arquivos/ids/7328880-1000-1000/image-0.jpg?v=638249816629330000', NULL, NULL, 'Los Sennheiser HD 450BT son auriculares inalámbricos con cancelación de ruido, sonido de alta fidelidad y batería de larga duración, ideales para audiófilos.', 0),
(54, 'Iphone X', 'Smartphone', 999.00, 'Iphone', 'https://www.reuse.pe/cdn/shop/files/63dab5e7cb3cb_s23-5g-rosa-1jpg_1024x1024.jpg?v=1737395254', NULL, NULL, 'El iPhone X es un smartphone icónico de Apple con pantalla OLED, reconocimiento facial y cámara dual, ideal para quienes buscan un dispositivo premium.', 0),
(55, 'Iphone 11', 'Smartphone', 799.00, 'Iphone', 'https://http2.mlstatic.com/D_NQ_NP_656548-MLA46114829749_052021-O.webp', 'https://www.apple.com/newsroom/images/product/iphone/standard/Apple_iphone_11-rosette-family-lineup-091019_big.jpg.large.jpg', '', 'El iPhone 11 es un smartphone de Apple con pantalla Liquid Retina, cámara dual y rendimiento sólido gracias a su chip A13 Bionic. Ideal para quienes buscan un dispositivo equilibrado entre precio y características.', 0),
(56, 'Iphone 12 Pro Max', 'Smartphone', 1099.00, 'Iphone', 'https://i5.walmartimages.com/seo/Apple-iPhone-12-Pro-Max-128GB-256GB-512GB-Factory-Unlocked-Good-Condition-Refurbished_82c4fa2f-42bc-4937-9d5f-291efd8fafc5.9e1d02adb03184e993e911de95c43977.jpeg', 'https://www.apple.com/newsroom/images/product/availability/geo/Apple_iphone12mini-iphone12max-homepodmini-availability_iphone12promax-geo_110520_inline.jpg.large.jpg', '', 'El iPhone 12 Pro Max es un smartphone de alta gama con pantalla Super Retina XDR, cámara triple y rendimiento excepcional gracias a su chip A14 Bionic. Ideal para quienes buscan lo último en tecnología móvil.', 0),
(57, 'iPhone 14 Pro', 'Smartphone', 1999.00, 'Iphone', 'https://www.reuse.pe/cdn/shop/files/63dab5e7cb3cb_s23-5g-rosa-1jpg_1024x1024.jpg?v=1737395254', NULL, NULL, 'El iPhone 14 Pro es un smartphone de alta gama con cámara avanzada, pantalla Super Retina XDR y rendimiento excepcional gracias a su chip A16 Bionic.', 0),
(58, 'iPhone 15 Pro', 'Smartphone', 1999.00, 'Iphone', 'https://mac-center.com.pe/cdn/shop/files/iPhone_14_Midnight_PDP_Image_Spring23_Position-6_COES.jpg?v=1700293686&width=823', NULL, NULL, 'El iPhone 15 Pro es el último modelo de Apple, con un diseño elegante, cámara mejorada y rendimiento excepcional gracias a su chip A17 Pro. Ideal para quienes buscan lo último en tecnología móvil.', 0),
(59, 'Iphone 16 Pro Max', 'Smartphone', 2499.00, 'Iphone', 'https://mac-center.com.pe/cdn/shop/files/iPhone_14_Midnight_PDP_Image_Spring23_Position-6_COES.jpg?v=1700293686&width=823', NULL, NULL, 'El iPhone 16 Pro Max es el smartphone más avanzado de Apple, con una pantalla grande, cámara de alta resolución y rendimiento excepcional gracias a su chip A18 Pro.', 0),
(60, 'Samsung Galaxy Note 20 Ultra', 'Smartphone', 1200.00, 'Samsung', 'https://mac-center.com.pe/cdn/shop/files/iPhone_14_Midnight_PDP_Image_Spring23_Position-6_COES.jpg?v=1700293686&width=823', NULL, NULL, 'El Samsung Galaxy Note 20 Ultra es un smartphone premium con pantalla AMOLED, S Pen integrado y cámara de alta resolución, ideal para productividad y entretenimiento.', 0),
(61, 'Samsung Galaxy A55', 'Smartphone', 400.00, 'Samsung', 'https://mac-center.com.pe/cdn/shop/files/iPhone_14_Midnight_PDP_Image_Spring23_Position-6_COES.jpg?v=1700293686&width=823', NULL, NULL, 'El Samsung Galaxy A55 es un smartphone de gama media con buena relación calidad-precio, pantalla AMOLED y cámara versátil, ideal para usuarios que buscan un buen rendimiento sin gastar mucho.', 0),
(62, 'Samsung S21 Fe', 'Smartphone', 700.00, 'Samsung', 'https://mac-center.com.pe/cdn/shop/files/iPhone_14_Midnight_PDP_Image_Spring23_Position-6_COES.jpg?v=1700293686&width=823', NULL, NULL, 'El Samsung S21 FE es un smartphone de gama media-alta con pantalla AMOLED, cámara versátil y rendimiento sólido, ideal para quienes buscan un dispositivo equilibrado.', 0),
(63, 'Samsung Galaxy S23', 'Smartphone', 1899.00, 'Samsung', 'https://mac-center.com.pe/cdn/shop/files/iPhone_14_Midnight_PDP_Image_Spring23_Position-6_COES.jpg?v=1700293686&width=823', NULL, NULL, 'El Samsung Galaxy S23 es un smartphone insignia con pantalla AMOLED, cámara de alta resolución y rendimiento potente, ideal para usuarios exigentes.', 0),
(64, 'Samsung Galaxy S23 Ultra', 'Smartphone', 2299.00, 'Samsung', 'https://mac-center.com.pe/cdn/shop/files/iPhone_14_Midnight_PDP_Image_Spring23_Position-6_COES.jpg?v=1700293686&width=823', NULL, NULL, ' El Samsung Galaxy S23 Ultra es un smartphone insignia con pantalla AMOLED, cámara de alta resolución y rendimiento potente, ideal para usuarios exigentes.', 0),
(65, 'Samsung Galaxy S24', 'Smartphone', 900.00, 'Samsung', 'https://mac-center.com.pe/cdn/shop/files/iPhone_14_Midnight_PDP_Image_Spring23_Position-6_COES.jpg?v=1700293686&width=823', NULL, NULL, 'El Samsung Galaxy S24 es un smartphone insignia con pantalla AMOLED, cámara de alta resolución y rendimiento potente, ideal para usuarios exigentes.', 0),
(66, 'Samsung Galaxy S25 Plus', 'Smartphone', 1200.00, 'Samsung', 'https://mac-center.com.pe/cdn/shop/files/iPhone_14_Midnight_PDP_Image_Spring23_Position-6_COES.jpg?v=1700293686&width=823', NULL, NULL, 'El Samsung Galaxy S25 Plus es un smartphone de gama alta con pantalla AMOLED, cámara avanzada y rendimiento excepcional, ideal para quienes buscan lo último en tecnología móvil.', 0),
(67, 'Xiaomi Mi 11', 'Smartphone', 700.00, 'Xiaomi', 'https://m.media-amazon.com/images/I/61CB-MZkbYL.jpg', NULL, NULL, 'El Xiaomi Mi 11 es un smartphone de gama alta con pantalla AMOLED, cámara triple y rendimiento potente gracias a su procesador Snapdragon 888. Ideal para quienes buscan un dispositivo premium a un precio más accesible.', 0),
(68, 'Xiaomi Redmi Note 11', 'Smartphone', 250.00, 'Xiaomi', 'https://m.media-amazon.com/images/I/61CB-MZkbYL.jpg', NULL, NULL, 'El Xiaomi Redmi Note 11 es un smartphone de gama media con pantalla AMOLED, cámara cuádruple y batería de larga duración, ideal para usuarios que buscan un buen rendimiento sin gastar mucho.', 0),
(69, 'Xiaomi Redmi Note 12', 'Smartphone', 300.00, 'Xiaomi', 'https://m.media-amazon.com/images/I/61CB-MZkbYL.jpg', NULL, NULL, 'El Xiaomi Redmi Note 12 ofrece una excelente relación calidad-precio, con pantalla AMOLED, cámara cuádruple y batería de larga duración, perfecto para quienes buscan un buen rendimiento sin gastar mucho.', 0),
(70, 'Xiaomi Poco X4 Pro', 'Smartphone', 350.00, 'Xiaomi', 'https://m.media-amazon.com/images/I/61CB-MZkbYL.jpg', NULL, NULL, 'El Xiaomi Poco X4 Pro es un smartphone de gama media con pantalla AMOLED, cámara cuádruple y rendimiento sólido, ideal para usuarios que buscan un buen equilibrio entre precio y características.', 0),
(71, 'Xiaomi Poco F6 GT', 'Smartphone', 600.00, 'Xiaomi', 'https://m.media-amazon.com/images/I/61CB-MZkbYL.jpg', NULL, NULL, 'El Xiaomi Poco F6 GT es un smartphone de gama alta con pantalla AMOLED, cámara triple y rendimiento potente gracias a su procesador Snapdragon 888. Ideal para quienes buscan un dispositivo premium a un precio más accesible.', 0),
(72, 'Motorola Moto G Power', 'Smartphone', 200.00, 'Motorola', 'https://m.media-amazon.com/images/I/61CB-MZkbYL.jpg', NULL, NULL, 'El Motorola Moto G Power es un smartphone de gama media con batería de larga duración, pantalla grande y rendimiento sólido, ideal para usuarios que buscan un dispositivo asequible y confiable.', 0),
(73, 'Motorola Moto G Stylus', 'Smartphone', 300.00, 'Motorola', 'https://media-amazon.com/images/I/61CB-MZkbYL.jpg', NULL, NULL, 'El Motorola Moto G Stylus es un smartphone de gama media con pantalla grande, S Pen integrado y rendimiento sólido, ideal para usuarios que buscan un dispositivo versátil para productividad y entretenimiento.', 0),
(74, 'Motorola Edge 30 Neo', 'Smartphone', 400.00, 'Motorola', 'https://pe.celulares.com/fotos/motorola-edge-30-neo-96760-g-alt.jpg', NULL, NULL, 'El Motorola Edge 30 Neo es un smartphone de gama media con pantalla AMOLED, cámara versátil y rendimiento sólido, ideal para usuarios que buscan un buen equilibrio entre precio y características.', 0),
(75, 'Motorola Edge 30 Fusion', 'Smartphone', 800.00, 'Motorola', 'https://pe.celulares.com/fotos/motorola-edge-30-fusion-96761-g-alt.jpg', NULL, NULL, 'El Motorola Edge 30 Fusion es un smartphone de gama alta con pantalla AMOLED, cámara avanzada y rendimiento potente gracias a su procesador Snapdragon 888. Ideal para quienes buscan un dispositivo premium a un precio más accesible.', 0),
(76, 'Motorola Edge 40', 'Smartphone', 600.00, 'Motorola', 'https://pe.celulares.com/fotos/oneplus-11-96759-g-alt.jpg', NULL, NULL, 'El Motorola Edge 40 es un smartphone con pantalla curva, rendimiento fluido y cámara de alta calidad, ideal para quienes buscan un dispositivo elegante y potente.', 0),
(77, 'Motorola Razr 40 Ultra', 'Smartphone', 1200.00, 'Motorola', 'https://pe.celulares.com/fotos/motorola-razr-40-ultra-96762-g-alt.jpg', NULL, NULL, 'El Motorola Razr 40 Ultra es un smartphone plegable con pantalla AMOLED, diseño icónico y rendimiento sólido, ideal para quienes buscan un dispositivo innovador y elegante.', 0),
(78, 'Google Pixel 6a', 'Smartphone', 500.00, 'Google', 'https://images-cdn.ubuy.pe/65f03ffecbe68c003878cf9d-new-google-pixel-6a-5g-128gb-sage.jpg', '', '', 'El Google Pixel 6a es un smartphone de gama media con cámara excepcional, software optimizado y actualizaciones rápidas, ideal para quienes valoran la fotografía y la experiencia Android pura.', 0),
(79, 'Google Pixel 7 Pro', 'Smartphone', 900.00, 'Google', 'https://m.media-amazon.com/images/I/6177Cl7-hyL.jpg', '', '', 'El Google Pixel 7 Pro es un smartphone de gama alta con pantalla grande, cámara avanzada y rendimiento excepcional gracias a su procesador Google Tensor. Ideal para quienes buscan lo último en tecnología móvil.', 0),
(80, 'Google Pixel 7a', 'Smartphone', 700.00, 'Google', 'https://pe.celulares.com/fotos/google-pixel-7a-97363-g-alt.jpg', '', '', 'El Google Pixel 7a es un smartphone con cámara excepcional, software optimizado y actualizaciones rápidas, ideal para quienes valoran la fotografía y la experiencia Android pura.', 0),
(81, 'Google Pixel 8 Pro', 'Smartphone', 999.00, 'Google', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSDMRhxAyzHle5rVvGwr4RCERYCpiRXKefKmg&s', '', '', 'El Google Pixel 8 Pro es el último smartphone de Google, con cámara avanzada, pantalla AMOLED y rendimiento excepcional gracias a su procesador Google Tensor. Ideal para quienes buscan lo último en tecnología móvil.', 0),
(82, 'OnePlus 11', 'Smartphone', 800.00, 'OnePlus', 'https://pe.celulares.com/fotos/oneplus-11-96759-g-alt.jpg', NULL, NULL, 'El OnePlus 11 es un smartphone de gama alta con pantalla AMOLED, cámara avanzada y rendimiento potente gracias a su procesador Snapdragon 8 Gen 2. Ideal para quienes buscan un dispositivo premium a un precio más accesible.', 0),
(83, 'OnePlus 11R', 'Smartphone', 600.00, 'OnePlus', 'https://pe.celulares.com/fotos/oneplus-11r-96758-g-alt.jpg', NULL, NULL, 'El OnePlus 11R es un smartphone de gama media-alta con pantalla AMOLED, cámara versátil y rendimiento sólido, ideal para usuarios que buscan un buen equilibrio entre precio y características.', 0),
(84, 'OnePlus 10 Pro', 'Smartphone', 700.00, 'OnePlus', 'https://pe.celulares.com/fotos/oneplus-10-pro-96757-g-alt.jpg', NULL, NULL, 'El OnePlus 10 Pro es un smartphone de gama alta con pantalla AMOLED, cámara avanzada y rendimiento potente gracias a su procesador Snapdragon 8 Gen 1. Ideal para quienes buscan un dispositivo premium a un precio más accesible.', 0),
(85, 'OnePlus Nord CE 3', 'Smartphone', 400.00, 'OnePlus', 'https://pe.celulares.com/fotos/oneplus-nord-ce-3-96756-g-alt.jpg', NULL, NULL, 'El OnePlus Nord CE 3 es un smartphone de gama media con pantalla AMOLED, cámara versátil y rendimiento sólido, ideal para usuarios que buscan un buen equilibrio entre precio y características.', 0),
(86, 'OnePlus Nord CE 3 Lite', 'Smartphone', 300.00, 'OnePlus', 'https://pe.celulares.com/fotos/oneplus-nord-ce-3-lite-96755-g-alt.jpg', NULL, NULL, 'El OnePlus Nord CE 3 Lite es un smartphone de gama media con pantalla AMOLED, cámara versátil y rendimiento sólido, ideal para usuarios que buscan un buen equilibrio entre precio y características.', 0),
(87, 'OnePlus Nord CE 2', 'Smartphone', 350.00, 'OnePlus', 'https://pe.celulares.com/fotos/oneplus-nord-ce-2-96754-g-alt.jpg', NULL, NULL, 'El OnePlus Nord CE 2 es un smartphone de gama media con pantalla AMOLED, cámara versátil y rendimiento sólido, ideal para usuarios que buscan un buen equilibrio entre precio y características.', 0),
(88, 'OnePlus Nord CE 2 Lite', 'Smartphone', 250.00, 'OnePlus', 'https://pe.celulares.com/fotos/oneplus-nord-ce-2-lite-96753-g-alt.jpg', NULL, NULL, 'El OnePlus Nord CE 2 Lite es un smartphone de gama media con pantalla AMOLED, cámara versátil y rendimiento sólido, ideal para usuarios que buscan un buen equilibrio entre precio y características.', 0),
(89, 'OnePlus Nord 2T', 'Smartphone', 500.00, 'OnePlus', 'https://pe.celulares.com/fotos/oneplus-nord-2t-94171-g-alt.jpg', NULL, NULL, 'El OnePlus Nord 2T es un smartphone de gama media con rendimiento sólido, carga rápida y cámara versátil, ideal para usuarios que buscan un buen equilibrio entre precio y características.', 0),
(90, 'OnePlus Nord N20', 'Smartphone', 300.00, 'OnePlus', 'https://pe.celulares.com/fotos/oneplus-nord-n20-94170-g-alt.jpg', NULL, NULL, 'El OnePlus Nord N20 es un smartphone de gama media con pantalla AMOLED, cámara versátil y rendimiento sólido, ideal para usuarios que buscan un buen equilibrio entre precio y características.', 0),
(91, 'OnePlus Nord N200', 'Smartphone', 250.00, 'OnePlus', 'https://pe.celulares.com/fotos/oneplus-nord-n200-94169-g-alt.jpg', NULL, NULL, 'El OnePlus Nord N200 es un smartphone de gama media con pantalla AMOLED, cámara versátil y rendimiento sólido, ideal para usuarios que buscan un buen equilibrio entre precio y características.', 0),
(92, 'Monitor LG 24”', 'Monitores', 150.00, 'LG', 'https://compumarket.pe/fotos/producto_13899_lg.jpg', NULL, NULL, 'Un monitor de 24 pulgadas con resolución Full HD, ideal para trabajo y entretenimiento, con tecnología IPS para colores más vivos y ángulos de visión amplios.', 0),
(93, 'Monitor LG UltraGear', 'Monitores', 250.00, 'LG', 'https://m.media-amazon.com/images/I/71b1d2e4J6L._AC_SL1500_.jpg', NULL, NULL, 'El monitor LG UltraGear es perfecto para gamers, con alta tasa de refresco, tiempo de respuesta rápido y tecnología FreeSync para una experiencia de juego fluida.', 0),
(94, 'Monitor LG 27”', 'Monitores', 400.00, 'LG', 'https://m.media-amazon.com/images/I/71b1d2e4J6L._AC_SL1500_.jpg', NULL, NULL, 'Un monitor de 27 pulgadas con resolución 4K, ideal para edición de fotos y videos, con tecnología HDR para colores más vivos y contraste mejorado.', 0),
(95, 'Monitor Samsung 24”', 'Monitores', 180.00, 'Samsung', 'https://m.media-amazon.com/images/I/71AlcYfuONL._AC_SL1200_.jpg', NULL, NULL, 'Un monitor de 24 pulgadas con resolución Full HD, ideal para uso diario, con tecnología de pantalla curva para una experiencia más inmersiva y ángulos de visión mejorados.', 0),
(96, 'Monitor Samsung 27”', 'Monitores', 250.00, 'Samsung', 'https://m.media-amazon.com/images/I/71AlcYfuONL._AC_SL1200_.jpg', NULL, NULL, 'Un monitor de 27 pulgadas con resolución QHD, ideal para juegos y películas, ofreciendo una experiencia inmersiva con colores vibrantes y contraste mejorado.', 0),
(97, 'Monitor Samsung Odyssey', 'Monitores', 350.00, 'Samsung', 'https://m.media-amazon.com/images/I/71AlcYfuONL._AC_SL1200_.jpg', NULL, NULL, 'El monitor Samsung Odyssey es un monitor gamer con pantalla curva, alta tasa de refresco y tecnología FreeSync, ideal para una experiencia de juego envolvente y fluida.', 0),
(98, 'Monitor Samsung Curvo', 'Monitores', 300.00, 'Samsung', 'https://m.media-amazon.com/images/I/71AlcYfuONL._AC_SL1200_.jpg', NULL, NULL, 'Monitor curvo de 27 pulgadas con resolución QHD, ideal para juegos y películas, ofreciendo una experiencia inmersiva con colores vibrantes y contraste mejorado.', 0),
(99, 'Monitor ASUS VG249Q3A', 'Monitores', 350.00, 'ASUS', 'https://www.impacto.com.pe/storage/products/md/173842851861363.webp', 'https://www.impacto.com.pe/storage/products/md/173842859218753.webp', 'https://www.impacto.com.pe/storage/products/md/173842870765839.webp', 'Un monitor de 24 pulgadas con resolución Full HD, ideal para trabajo y entretenimiento, con tecnología IPS para colores más vivos y ángulos de visión amplios.', 23),
(100, 'Monitor ASUS TUF Gaming', 'Monitores', 300.00, 'ASUS', 'https://pcya.pe/wp-content/uploads/2024/03/PA248QV-1.png', NULL, NULL, 'El monitor ASUS TUF Gaming es perfecto para gamers, con alta tasa de refresco, tiempo de respuesta rápido y tecnología FreeSync para una experiencia de juego fluida.', 7),
(101, 'Monitor ASUS VY279HGR', 'Monitores', 450.00, 'ASUS', 'https://www.impacto.com.pe/storage/products/md/174896638119597.webp', 'https://www.impacto.com.pe/storage/products/md/174896638428655.webp', '', 'Un monitor de 27 pulgadas con resolución 4K, ideal para edición de fotos y videos, con tecnología HDR para colores más vivos y contraste mejorado.', 16),
(102, 'Monitor ASUS ProArt', 'Monitores', 400.00, 'ASUS', 'https://pcya.pe/wp-content/uploads/2024/03/PA248QV-1.png', NULL, NULL, 'El monitor ASUS ProArt es perfecto para diseñadores y creadores de contenido, con una excelente reproducción del color, resolución 4K y conectividad versátil.', 13),
(103, 'Monitor HP 24”', 'Monitores', 180.00, 'HP', 'https://pe-media.hptiendaenlinea.com/catalog/product/2/V/2V6B2AA-1_T1679063020.png', NULL, NULL, 'Un monitor de 24 pulgadas con resolución Full HD, ideal para uso diario, con tecnología antirreflejo y conectividad HDMI.', 0),
(104, 'Monitor HP Pavilion', 'Monitores', 250.00, 'HP', 'https://pe-media.hptiendaenlinea.com/catalog/product/2/V/2V6B2AA-1_T1679063020.png', NULL, NULL, 'El monitor HP Pavilion es un monitor de alta calidad con pantalla IPS, ideal para entretenimiento y trabajo, ofreciendo colores vibrantes y ángulos de visión amplios.', 0),
(105, 'Monitor HP EliteDisplay', 'Monitores', 400.00, 'HP', 'https://pe-media.hptiendaenlinea.com/catalog/product/2/V/2V6B2AA-1_T1679063020.png', NULL, NULL, 'Un monitor de 27 pulgadas con resolución QHD, ideal para profesionales que requieren precisión en el color y detalles nítidos en sus trabajos.', 0),
(106, 'Monitor HP 27”', 'Monitores', 200.00, 'HP', 'https://pe-media.hptiendaenlinea.com/catalog/product/2/V/2V6B2AA-1_T1679063020.png', NULL, NULL, 'Un monitor de 27 pulgadas con diseño elegante y pantalla Full HD, ideal para uso diario, con tecnología antirreflejo y conectividad HDMI.', 0),
(107, 'Monitor Dell 27”', 'Monitores', 300.00, 'Dell', 'https://caltechstore.pe/image/cache/catalog/DELL%20P2722H/81fCUAajF9L._AC_SL1500-1200x1200.jpg', NULL, NULL, 'Un monitor de 27 pulgadas con resolución QHD, ideal para edición de fotos y videos, con tecnología HDR para colores más vivos y contraste mejorado.', 0),
(108, 'Monitor Dell P222H', 'Monitores', 250.00, 'Dell', 'https://caltechstore.pe/image/cache/catalog/DELL%20P2422H/81fCUAajF9L._AC_SL1500-1200x1200.jpg', NULL, NULL, 'El monitor Dell P2422H es perfecto para uso profesional, con pantalla IPS, resolución Full HD y conectividad versátil, ideal para tareas de oficina y diseño gráfico.', 0),
(109, 'Monitor Dell P2722H', 'Monitores', 300.00, 'Dell', 'https://caltechstore.pe/image/cache/catalog/DELL%20P2722H/81fCUAajF9L._AC_SL1500-1200x1200.jpg', NULL, NULL, 'Un monitor de 27 pulgadas con resolución Full HD, ideal para uso diario, con tecnología antirreflejo y conectividad HDMI.', 0),
(110, 'Monitor Dell UltraSharp', 'Monitores', 500.00, 'Dell', 'https://caltechstore.pe/image/cache/catalog/DELL%20U2724DE/81fCUAajF9L._AC_SL1500-1200x1200.jpg', NULL, NULL, 'El Dell UltraSharp es un monitor de alta gama con resolución 4K, ideal para profesionales que requieren precisión en el color y detalles nítidos en sus trabajos.', 0),
(111, 'Monitor Acer EI242QR', 'Monitores', 480.00, 'Acer', 'https://www.magitech.pe/media/catalog/product/cache/1/image/600x/040ec09b1e35df139433887a97daa66f/m/o/monitor-1_8.jpg', 'https://www.magitech.pe/media/catalog/product/cache/1/image/600x/040ec09b1e35df139433887a97daa66f/m/o/monitor-7_2.jpg', '', 'Un monitor de 24 pulgadas con resolución Full HD, ideal para uso diario, con tecnología antirreflejo y conectividad HDMI.', 0),
(112, 'Monitor Acer Predator', 'Monitores', 400.00, 'Acer', 'https://www.magitech.pe/media/catalog/product/cache/1/image/600x/040ec09b1e35df139433887a97daa66f/p/r/predator-1_1.jpg', 'https://www.magitech.pe/media/catalog/product/cache/1/image/600x/040ec09b1e35df139433887a97daa66f/p/r/predator-2_1.jpg', '', 'El monitor Acer Predator es perfecto para gamers y creadores de contenido, con una excelente reproducción del color, resolución 4K y conectividad versátil.', 0),
(113, 'Monitor Acer XZ270', 'Monitores', 300.00, 'Acer', 'https://cyccomputer.pe/52357-medium_default/monitor-led-27-acer-nitro-xz270-curvo-1920x1080-hdmi-dp-5ms240hzadaptive-sync-pnumhx0aax01.jpg', 'https://cyccomputer.pe/52359-small_default/monitor-led-27-acer-nitro-xz270-curvo-1920x1080-hdmi-dp-5ms240hzadaptive-sync-pnumhx0aax01.jpg', '', 'Un monitor de 27 pulgadas con resolución QHD, ideal para edición de fotos y videos, con tecnología HDR para colores más vivos y contraste mejorado.', 10),
(114, 'Monitor Acer Nitro', 'Monitores', 350.00, 'Acer', 'https://m.media-amazon.com/images/I/71lKsFn1SHL.jpg', '', '', 'Un monitor gamer de 27 pulgadas con tasa de refresco alta y tecnología FreeSync, ideal para juegos competitivos y experiencias visuales fluidas.', 9),
(115, 'Mouse Logitech G203', 'Mouse', 100.00, 'Logitech', 'https://cyccomputer.pe/44457-large_default/mouse-logitech-mx-master-3s-graphite-wireless-pn910-006561.jpg', NULL, NULL, 'Un mouse gaming con sensor de alta precisión, retroiluminación RGB y diseño ergonómico, ideal para largas sesiones de juego.', 0),
(116, 'Mouse Redragon Cobra', 'Mouse', 50.00, 'Redragon', 'https://ezpc.pe/wp-content/uploads/2022/10/RZ01-03350100-R3U1.jpg', NULL, NULL, 'El Redragon Cobra es un mouse ergonómico con múltiples botones programables, ideal para gamers que buscan personalización y comodidad.', 0),
(117, 'Mouse Razer Viper', 'Mouse', 120.00, 'Razer', 'https://hca.pe/storage/media/large_ob6gvnlesx4SAQ6WPwSVBAqjRtFLPrR3Y5GmeEc0.png', NULL, NULL, 'Un mouse ultraligero con tecnología de sensor óptico de alta precisión, diseñado para ofrecer velocidad y precisión en juegos competitivos.', 0),
(118, 'Mouse HyperX Pulsefire', 'Mouse', 80.00, 'HyperX', 'https://m.media-amazon.com/images/I/61IUHE0j07L._AC_UF350,350_QL80_.jpg', NULL, NULL, 'El HyperX Pulsefire es un mouse gaming con diseño ergonómico, sensor Pixart 3389 y retroiluminación RGB, ideal para gamers que buscan rendimiento y estilo.', 0),
(119, 'Mouse Corsair Harpoon', 'Mouse', 139.99, 'Corsair', 'https://assets.corsair.com/image/upload/c_pad,q_85,h_1100,w_1100,f_auto/products/Gaming-Mice/CH-9301011-NA/Gallery/HARPOON_RGB_08.webp', 'https://assets.corsair.com/image/upload/c_pad,q_85,h_1100,w_1100,f_auto/products/Gaming-Mice/CH-9301011-NA/Gallery/HARPOON_RGB_02.webp', '', 'Un mouse compacto y ligero con sensor óptico de alta precisión, ideal para gamers que buscan un dispositivo portátil y eficiente.', 0),
(120, 'Mouse Apple Magic Mouse', 'Mouse', 399.99, 'Apple', 'https://rimage.ripley.com.pe/home.ripley/Attachment/MKP/2216/PMP20000225978/full_image-1.jpeg', 'https://mac-center.com.pe/cdn/shop/files/magic-mouse-black-multi-touch-surface_MXK63.jpg?v=1730310578&width=823', '', 'El Apple Magic Mouse es un mouse inalámbrico con diseño minimalista, superficie táctil y batería recargable, ideal para usuarios de Mac que buscan elegancia y funcionalidad.', 0),
(121, 'Mouse Logitech MX Master 3', 'Mouse', 150.00, 'Logitech', 'https://cyccomputer.pe/44457-large_default/mouse-logitech-mx-master-3s-graphite-wireless-pn910-006561.jpg', NULL, NULL, 'El Logitech MX Master 3 es un mouse ergonómico con múltiples botones programables, rueda de desplazamiento electromagnética y conectividad Bluetooth, ideal para profesionales que buscan productividad y comodidad.', 0),
(122, 'Mouse Razer DeathAdder V2', 'Mouse', 130.00, 'Razer', 'https://hca.pe/storage/media/large_ob6gvnlesx4SAQ6WPwSVBAqjRtFLPrR3Y5GmeEc0.png', NULL, NULL, 'Un mouse gaming con diseño ergonómico, sensor óptico de alta precisión y retroiluminación RGB, ideal para largas sesiones de juego.', 0),
(123, 'Mouse Logitech G Pro X Superlight', 'Mouse', 200.00, 'Logitech', 'https://cyccomputer.pe/44457-large_default/mouse-logitech-mx-master-3s-graphite-wireless-pn910-006561.jpg', NULL, NULL, 'Un mouse ultraligero diseñado para gamers profesionales, con sensor HERO 25K y conectividad inalámbrica de baja latencia, ideal para competiciones de alto nivel.', 0),
(124, 'mouse Redragon M601', 'Mouse', 60.00, 'Redragon', 'https://ezpc.pe/wp-content/uploads/2022/10/RZ01-03350100-R3U1.jpg', NULL, NULL, 'Un mouse ergonómico con múltiples botones programables, ideal para gamers que buscan personalización y comodidad.', 0),
(125, 'Mouse Logitech Pebble', 'Mouse', 50.00, 'Logitech', 'https://m.media-amazon.com/images/I/61IUHE0j07L._AC_UF350,350_QL80_.jpg', NULL, NULL, 'Un mouse compacto y silencioso, ideal para uso diario y viajes, con conectividad Bluetooth y USB, ofreciendo comodidad y portabilidad.', 0),
(126, 'Mouse Corsair Katar Pro', 'Mouse', 149.99, 'Corsair', 'https://www.infotec.com.pe/97135-thickbox_default/mouse-corsair-katar-pro-wireless-ch-931c011-na-gaming.jpg', 'https://www.infotec.com.pe/57912-large_default/mouse-corsair-katar-pro-wireless-ch-931c011-na-gaming.jpg', '', 'Un mouse compacto y ligero con sensor óptico de alta precisión, ideal para gamers que buscan un dispositivo portátil y eficiente.', 0),
(127, 'Mouse Corsair Scimitar Elite', 'Mouse', 490.00, 'Corsair', 'https://compumarket.pe/fotos/producto_7962_lg.jpg', 'https://compumarket.pe/fotos/producto_7962_3858_lg.jpg', '', 'Un mouse gamer con múltiples botones programables, ideal para juegos MMO y MOBA, ofreciendo personalización y comodidad.', 0),
(128, 'Mouse HyperX Pulsefire Haste', 'Mouse', 110.00, 'HyperX', 'https://m.media-amazon.com/images/I/61IUHE0j07L._AC_UF350,350_QL80_.jpg', NULL, NULL, 'Un mouse ultraligero con diseño perforado, sensor Pixart 3335 y retroiluminación RGB, ideal para gamers que buscan velocidad y precisión.', 0),
(129, 'Mouse Apple Magic Mouse 2', 'Mouse', 479.99, 'Apple', 'https://casemotions.pe/wp-content/uploads/2021/08/MAGIC_0.jpg', 'https://casemotions.pe/wp-content/uploads/2021/08/MAGIC_2.jpg', '', 'El Apple Magic Mouse 2 es un mouse inalámbrico con diseño minimalista, superficie táctil y batería recargable, ideal para usuarios de Mac que buscan elegancia y funcionalidad.', 0),
(130, 'Mouse Logitech MX Anywhere 3', 'Mouse', 130.00, 'Logitech', 'https://cyccomputer.pe/44457-large_default/mouse-logitech-mx-master-3s-graphite-wireless-pn910-006561.jpg', NULL, NULL, 'Un mouse compacto y versátil con conectividad Bluetooth y USB, ideal para profesionales que necesitan un dispositivo portátil y eficiente.', 0),
(131, 'Mouse Razer Basilisk V3', 'Mouse', 140.00, 'Razer', 'https://hca.pe/storage/media/large_ob6gvnlesx4SAQ6WPwSVBAqjRtFLPrR3Y5GmeEc0.png', NULL, NULL, 'Un mouse gamer con diseño ergonómico, sensor óptico de alta precisión y retroiluminación RGB, ideal para largas sesiones de juego.', 0),
(132, 'Mouse Logitech G502 Hero', 'Mouse', 150.00, 'Logitech', 'https://cyccomputer.pe/44457-large_default/mouse-logitech-mx-master-3s-graphite-wireless-pn910-006561.jpg', NULL, NULL, 'Un mouse gamer con múltiples botones programables, sensor HERO 25K y retroiluminación RGB, ideal para gamers que buscan personalización y rendimiento.', 0),
(134, 'Mouse Logitech G Pro Wireless', 'Mouse', 180.00, 'Logitech', 'https://cyccomputer.pe/44457-large_default/mouse-logitech-mx-master-3s-graphite-wireless-pn910-006561.jpg', NULL, NULL, 'Un mouse ultraligero diseñado para gamers profesionales, con sensor HERO 25K y conectividad inalámbrica de baja latencia, ideal para competiciones de alto nivel.', 0),
(135, 'mouse HyperX Pulsefire Raid', 'Mouse', 90.00, 'HyperX', 'https://m.media-amazon.com/images/I/61IUHE0j07L._AC_UF350,350_QL80_.jpg', NULL, NULL, 'Un mouse gaming con diseño ergonómico, sensor Pixart 3389 y retroiluminación RGB, ideal para gamers que buscan rendimiento y estilo.', 0),
(136, 'Mouse Razer Naga X', 'Mouse', 110.00, 'Razer', 'https://hca.pe/storage/media/large_ob6gvnlesx4SAQ6WPwSVBAqjRtFLPrR3Y5GmeEc0.png', NULL, NULL, 'Un mouse gamer con múltiples botones programables, ideal para juegos MMO y MOBA, ofreciendo personalización y comodidad.', 0),
(137, 'Mouse Logitech MX Vertical', 'Mouse', 160.00, 'Logitech', 'https://cyccomputer.pe/44457-large_default/mouse-logitech-mx-master-3s-graphite-wireless-pn910-006561.jpg', NULL, NULL, 'Un mouse vertical ergonómico diseñado para reducir la tensión en la muñeca, con conectividad Bluetooth y USB, ideal para profesionales que buscan comodidad y salud en el uso diario.', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('cliente','admin') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` varchar(10) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `role`, `email`, `nombre`, `fecha_nacimiento`, `genero`, `direccion`) VALUES
(1, 'jhair', '$2y$10$kAq.ZlZpThNwVCjmaU59Le3FjDliXgf2HJZW9PKih0Ft3Jbv9D6nq', 'cliente', 'jhaircasas34@gmail.com', 'Jhair Casas', '2005-04-26', 'masculino', NULL),
(2, 'admin', '$2y$10$QuJYcrY9giWHebqbj2iB9upF97dwK4VWIwdEXtYbVxO.JxmS50/bW', 'admin', NULL, '', '0000-00-00', '', NULL),
(3, 'jhair123', '', 'cliente', 'aj@gmail.com', '123', '0000-00-00', 'masculino', 'Arequipa'),
(4, 'leo', '123', 'cliente', 'leo@gmail.com', 'Leo Casas', '2001-10-11', 'masculino', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
