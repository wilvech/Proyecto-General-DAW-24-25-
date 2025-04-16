<?php
require_once '../includes/header.php';
require_once '../components/flash_message.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_email'] = $user['email'];
        $_SESSION['usuario_rol'] = $user['rol'];
        $_SESSION['flash_success'] = 'Bienvenido, ' . htmlspecialchars($user['nombre']);
        header('Location: ../index.php');
        exit;
    } else {
        $_SESSION['flash_error'] = 'Credenciales incorrectas';
    }
}
?>

<h1>Iniciar Sesión</h1>

<form method="POST">
    <label>Email: <input type="email" name="email" required></label>
    <label>Contraseña: <input type="password" name="password" required></label>
    <button type="submit" class="btn">Entrar</button>
</form>

<p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
<p>¿Olvidaste tu contraseña? <a href="forgot_password.php">Recupérala aquí</a></p>

<?php require_once '../includes/footer.php'; ?>
