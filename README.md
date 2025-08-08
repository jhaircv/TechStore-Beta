# TechStore+

Tienda virtual ficticia desarrollada en PHP y MySQL. Permite gestionar productos, usuarios, historial de compras, simulación de pagos y cuenta con panel de administración.

## Características

- Catálogo de productos con imágenes (URLs públicas)
- Registro e inicio de sesión de usuarios y administrador
- Edición de perfil y datos personales
- Historial de compras
- Simulación de pago con tarjeta
- Panel de administración
- Base de datos con productos y usuarios ficticios

## Instalación

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/tu-usuario/tu-repo.git
   ```

2. **Configura la base de datos:**
   - Abre [phpMyAdmin](http://localhost/phpmyadmin).
   - Crea una base de datos llamada `tienda`.
   - Importa el archivo `script/tienda.sql` para cargar la estructura y los datos de ejemplo.

3. **Configura la conexión a la base de datos:**
   - Edita el archivo `config/db.php` con tus datos de conexión (usuario, contraseña, host).

4. **Inicia el servidor local:**
   - Si usas XAMPP, coloca la carpeta del proyecto en `htdocs` y accede desde `http://localhost/mi-tienda(beta1.5)/`.

## Usuarios de prueba

- **Cliente:**  
  Usuario: `jhair`  
  Contraseña: `123456` (o la que corresponda al hash en la base de datos)

- **Administrador:**  
  Usuario: `admin`  
  Contraseña: `admin123` (o la que corresponda al hash en la base de datos)

## Imágenes de productos

Las imágenes de los productos están en URLs públicas, por lo que no necesitas descargar archivos adicionales.

## Simulación de pago

Para simular un pago con tarjeta, usa estos datos en el formulario de pago:
- Número de tarjeta: `4242 4242 4242 4242`
- CVV: `123`
- Fecha: cualquier válida (ejemplo: `12/34`)

## Estructura del proyecto

```
mi-tienda(beta1.5)/
├── config/
│   └── db.php
├── script/
│   └── tienda.sql
├── productos.php
├── index.php
├── login.php
├── admin_login.php
├── procesar_login.php
├── procesar_registro.php
├── ...otros archivos
```

## Recomendaciones

- **No subas datos sensibles** (contraseñas reales, datos personales) a repositorios públicos.
- Puedes modificar el archivo SQL para agregar más productos o usuarios ficticios.

## Licencia

Este proyecto es solo para fines educativos y demostrativos.

---

¿Listo para subirlo?  
1. Guarda este contenido en un archivo llamado `README.md` en la raíz de tu proyecto.
2. Haz commit y push a tu repositorio de GitHub.

¿Quieres que te ayude con el `.gitignore` también?# TechStore+

Tienda virtual ficticia desarrollada en PHP y MySQL. Permite gestionar productos, usuarios, historial de compras, simulación de pagos y cuenta con panel de administración.

## Características

- Catálogo de productos con imágenes (URLs públicas)
- Registro e inicio de sesión de usuarios y administrador
- Edición de perfil y datos personales
- Historial de compras
- Simulación de pago con tarjeta
- Panel de administración
- Base de datos con productos y usuarios ficticios

## Instalación

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/tu-usuario/tu-repo.git
   ```

2. **Configura la base de datos:**
   - Abre [phpMyAdmin](http://localhost/phpmyadmin).
   - Crea una base de datos llamada `tienda`.
   - Importa el archivo `script/tienda.sql` para cargar la estructura y los datos de ejemplo.

3. **Configura la conexión a la base de datos:**
   - Edita el archivo `config/db.php` con tus datos de conexión (usuario, contraseña, host).

4. **Inicia el servidor local:**
   - Si usas XAMPP, coloca la carpeta del proyecto en `htdocs` y accede desde `http://localhost/mi-tienda(beta1.5)/`.

## Usuarios de prueba

- **Cliente:**  
  Usuario:jhair`  
  Contraseña: `123456` (o la que corresponda al hash en la base de datos)

- **Administrador:**  
  Usuario: `admin`  
  Contraseña: `admin123` (o la que corresponda al hash en la base de datos)

## Imágenes de productos

Las imágenes de los productos están en URLs públicas, por lo que no necesitas descargar archivos adicionales.

## Simulación de pago

Para simular un pago con tarjeta, usa estos datos en el formulario de pago:
- Número de tarjeta: `4242 4242 4242 4242`
- CVV: `123`
- Fecha: cualquier válida (ejemplo: `12/34`)

## Estructura del proyecto

```
mi-tienda(beta1.5)/
├── config/
│   └── db.php
├── script/
│   └── tienda.sql
├── productos.php
├── index.php
├── login.php
├── admin_login.php
├── procesar_login.php
├── procesar_registro.php
├── ...otros archivos
```

## Recomendaciones

- **No subas datos sensibles** (contraseñas reales, datos personales) a repositorios públicos.
- Puedes modificar el archivo SQL para agregar más productos o usuarios ficticios.

## Licencia

Este proyecto es solo para fines educativos y demostrativos.

---