<?php
require_once '../includes/config.php';

\Stripe\Stripe::setApiKey('sk_live_TU_SECRET_KEY');

session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id']) || empty($_SESSION['cart'])) {
    header('Location: ../login.php');
    exit;
}

// Procesa los productos del carrito
require_once '../includes/db_connect.php';
require_once '../vendor/autoload.php';

$line_items = [];
$total = 0;

foreach ($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $pdo->prepare("SELECT nombre, precio FROM productos WHERE id = :id");
    $stmt->execute([':id' => $product_id]);
    $prod = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($prod) {
        $line_items[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $prod['nombre'],
                ],
                'unit_amount' => $prod['precio'] * 100,
            ],
            'quantity' => $qty,
        ];
        $total += $prod['precio'] * $qty;
    }
}

// Crear sesión de pago
$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $line_items,
    'mode' => 'payment',
    'success_url' => BASE_URL . '/stripe/success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => BASE_URL . '/stripe/cancel.php',
]);

header("Location: " . $session->url);
exit;
