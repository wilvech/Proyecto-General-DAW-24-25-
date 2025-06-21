<?php
require_once '../includes/config.php';
require_once '../includes/db_connect.php';
require_once '../vendor/autoload.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

session_start();

if (!isset($_SESSION['usuario_id']) || empty($_SESSION['cart'])) {
    header('Location: ../auth/login.php');
    exit;
}

$line_items = [];

foreach ($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $pdo->prepare("SELECT nombre, precio FROM productos WHERE id = :id");
    $stmt->execute([':id' => $product_id]);
    $prod = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($prod) {
        $line_items[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => ['name' => $prod['nombre']],
                'unit_amount' => $prod['precio'] * 100,
            ],
            'quantity' => $qty,
        ];
    }
}

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $line_items,
    'mode' => 'payment',
    'success_url' => BASE_URL . '/stripe/success.php',
    'cancel_url' => BASE_URL . '/stripe/cancel.php',
]);

header("Location: " . $session->url);
exit;
