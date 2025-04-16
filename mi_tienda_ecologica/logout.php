<?php
session_start();
require_once 'includes/config.php'; // Incluimos el archivo que define BASE_URL
session_unset();
session_destroy();

// Redirige a la página de inicio
header('Location: ' . BASE_URL . '/index.php');
exit;
?>
