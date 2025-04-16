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
