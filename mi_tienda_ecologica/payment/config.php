<?php
require_once '../includes/config.php';
require_once '../vendor/autoload.php'; // Asegúrate de instalar Stripe vía Composer

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
