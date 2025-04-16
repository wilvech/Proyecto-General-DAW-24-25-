<?php
session_start();
require_once '../includes/header.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Acceso denegado. <a href='../auth/login.php'>Iniciar sesión</a></p>";
    require_once '../includes/footer.php';
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->execute([':id' => $_SESSION['usuario_id']]);
$user = $stmt->fetch();
?>

<h1>Mi Perfil</h1>
<p><strong>Nombre:</strong> <?= htmlspecialchars($user['nombre']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
<p><strong>Teléfono:</strong> <?= htmlspecialchars($user['telefono']) ?></p>
<p><strong>Dirección:</strong> <?= htmlspecialchars($user['direccion']) ?></p>

<?php require_once '../includes/footer.php'; ?>
