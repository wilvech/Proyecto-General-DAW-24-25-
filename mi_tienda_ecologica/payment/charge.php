<?php
require 'config.php';

header('Content-Type: application/json');

$POST = json_decode(file_get_contents('php://input'), true);
$token = $POST['token'];
$amount = $POST['amount'];

try {
  $charge = \Stripe\Charge::create([
    'amount' => $amount,
    'currency' => 'eur',
    'description' => 'Compra en Tienda Ecológica',
    'source' => $token,
  ]);

  echo json_encode(['success' => true]);
} catch (\Stripe\Exception\CardException $e) {
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
