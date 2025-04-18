# 🌿 Tienda Ecológica 🌱 - Stack LAMP

Este es un sitio web funcional y completo de e-commerce para frutas y verduras ecológicas, desarrollado en PHP puro con MySQL (LAMP stack).

---

## 🧱 Tecnologías - Requisitos 🔧

- PHP 8+
- MySQL (con PDO)
- HTML5 + CSS3
- Composer:
  - PHPMailer (Mailtrap integrado)
  - Stripe Checkout (modo test)
- XAMPP / VPS compatible
- Apache2 (.htaccess activado)

---

## 🎯 Funcionalidades

Tienda online en PHP puro con:

  - 👤 Registro y Login de usuarios
  - 📬 Recuperación de contraseña con token, Mailtrap, Gmail-SMTP
  - 🛍️ Catálogo de productos con filtro por categoría
  - 🔍 Búsqueda avanzada con precio, nombre y categoría
  - 🛒 Carrito de compras persistente (sesión)
  - 💳 Checkout y pago con Stripe (modo test / prod)
  - ⚙️ Confirmación de compra + registro en la base de datos
  - 🔐 Panel de administración (solo admins):
    - Gestión de productos (CRUD con imagen)
    - Gestión de pedidos (ver, cambiar estado)
    - Gestión de usuarios (roles y eliminación)
    - Gestión de mensajes de contacto

---

## 🛠 Instalación en XAMPP

1. Clona este repositorio o copia la carpeta en `htdocs/`
2. Importa `database/create_tables.sql` en phpMyAdmin o en tu base de datos local
3. Abre `includes/config.php` y configura con tu entorno local:
4. Instala dependencias:
   
```bash
composer install
```

```php
define('BASE_URL', 'http://localhost/Proyecto-General-DAW-24-25-/mi_tienda_ecologica');
define('DB_USER', 'root');
define('DB_PASS', '');
```
---

## Créditos

Desarrollado como parte del módulo DAW 24/25. Contacto de pruebas:  
📩 ecotiendatest@gmail.com  
📩 ecotiendapro@gmail.com  
🔑 Pass: 1234,Abcd











