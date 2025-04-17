# 🌿 Proyecto "Tienda Ecológica" - PHP + MySQL

Este es un sitio web funcional y completo de e-commerce para frutas y verduras ecológicas, desarrollado en PHP puro con MySQL (LAMP stack).

## 🧱 Tecnologías Usadas

- PHP 8+
- MySQL (con PDO)
- HTML5 + CSS3
- Stripe Checkout
- Apache2 (.htaccess activado)
- XAMPP / VPS compatible

---

## 🎯 Funcionalidades

- Registro y Login de usuarios
- Recuperación de contraseña por token
- Catálogo de productos con filtro por categoría
- Búsqueda avanzada con precio, nombre y categoría
- Carrito de compras persistente (sesión)
- Checkout y pago con Stripe (modo test / prod)
- Confirmación de compra + registro en la base de datos
- Panel de administración (solo admins):
  - Gestión de productos (CRUD con imagen)
  - Gestión de pedidos (ver, cambiar estado)
  - Gestión de usuarios (roles y eliminación)
  - Gestión de mensajes de contacto

---

## ⚙️ Instalación en XAMPP

1. Clona o copia la carpeta en `htdocs/`
2. Importa `database/create_tables.sql` en phpMyAdmin
3. Abre `includes/config.php` y configura:

```php
define('BASE_URL', 'http://localhost/mi_tienda_ecologica');
define('DB_USER', 'root');
define('DB_PASS', '');

---

# Proyecto C - Tienda Ecológica

Este proyecto es un sitio web de una tienda online de frutas y verduras ecológicas desarrollado con PHP y MySQL.

## Funcionalidades

- 🛍️ Catálogo de productos
- 🔍 Búsqueda avanzada
- 👤 Registro y Login
- 🛒 Carrito de compras
- 💳 Pago con Stripe
- 🔐 Panel de administrador
- 📬 Contacto con PHPMailer

## Instalación

1. Clona este repositorio
2. Importa `database/create_tables.sql` en tu base de datos local
3. Configura `includes/config.php` con tu entorno local
4. Instala dependencias:
   ```bash
   composer install```

# Proyecto Tienda Ecológica 🍎

Tienda online en PHP puro con:

- Registro e inicio de sesión de usuarios
- Carrito de compras persistente (con sesión)
- Gestión de productos, pedidos y usuarios (solo admin)
- Búsqueda avanzada de productos
- Contacto vía formulario
- Pagos seguros con Stripe Checkout
- Estilo simple y responsive

## Requisitos

- PHP + MySQL (XAMPP o VPS)
- Composer (Stripe y PHPMailer)

## Instalación

1. Clona o descarga este repo
2. Ejecuta `composer install`
3. Importa `database/create_tables.sql` en tu servidor MySQL
4. Abre el proyecto en tu navegador:  
   http://localhost/Proyecto-General-DAW-24-25-/mi_tienda_ecologica/

## Créditos

Desarrollado como parte del módulo DAW 24/25. Contacto de pruebas:  
📩 ecotiendatest@gmail.com  
📩 ecotiendapro@gmail.com  
🔑 Pass: 1234,Abcd

# Proyecto Web: Tienda Ecológica 🌱

Proyecto web completo desarrollado en PHP (stack LAMP) para gestionar una tienda online de frutas y verduras ecológicas.

## 🔧 Tecnologías
- PHP 7+
- MySQL (con script preinstalado `create_tables.sql`)
- HTML5 + CSS3
- PHPMailer (Mailtrap integrado)
- Stripe Checkout (modo test)
- Composer

## 📁 Estructura

mi_tienda_ecologica/ │ ├── admin/ ← Panel para gestionar productos, pedidos, usuarios, mensajes ├── auth/ ← Login, registro, recuperar contraseña ├── assets/ ← Estilos e imágenes ├── components/ ← Mensajes flash reutilizables ├── database/ ← Script SQL con 100 productos y datos de prueba ├── includes/ ← Conexión, envío de correos, headers, etc. ├── pages/ ← Catálogo, carrito, contacto, perfil ├── stripe/ ← Integración de Stripe ├── uploads/ ← (Vacía, no utilizada gracias a imágenes por URL) ├── .env (opcional) ├── .htaccess ├── composer.json ├── index.php └── README.md

## ✅ Funcionalidades

- Registro y login de usuarios y administradores
- Recuperación de contraseña con token y Mailtrap
- Catálogo y búsqueda avanzada
- Añadir al carrito y pagar con Stripe
- Gestión de productos, pedidos y usuarios
- Formularios de contacto integrados

## 🛠 Instalación

1. Clona o copia el proyecto en `htdocs` si usas XAMPP
2. Crea la base de datos `tienda_ecologica` y ejecuta `database/create_tables.sql`
3. Ejecuta:

```bash
composer install

