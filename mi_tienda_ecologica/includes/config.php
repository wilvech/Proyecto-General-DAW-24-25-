<?php
// Ruta base (ajustar si cambia el dominio o la carpeta en producción)
define('BASE_URL', 'http://localhost/Proyecto-General-DAW-24-25-/mi_tienda_ecologica');

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'tienda_ecologica');
define('DB_USER', 'root');
define('DB_PASS', '');

// Stripe (modo pruebas)
define('STRIPE_PUBLIC_KEY', 'pk_test_51RESaU06F7Q4HFlRI7ZOwq1MjghZPLv5Qay3ugEvh5b5yBRZ1NI8M7qR6NKWPfrqUeIAJpB89mHNRtJRakgGekIH00mYfPmFbi');
define('STRIPE_SECRET_KEY', 'sk_test_51RESaU06F7Q4HFlR3mupwIPmU2iZ2wLrPQf7JbqkWmAN9vRHbo2b1W0lfopcThUHJgMJEFYOs1PPtluskvxVIKh000rWWMXmEA');

// Mailtrap (modo pruebas)
define('MAILTRAP_HOST', 'sandbox.smtp.mailtrap.io');
define('MAILTRAP_PORT', 587);
define('MAILTRAP_USER', '64e957fdd3fdc4');
define('MAILTRAP_PASS', '1c12');
define('MAILTRAP_TO', 'ecotiendapro@gmail.com');
