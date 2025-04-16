<?php
require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_email'] = $user['email'];
        $_SESSION['usuario_rol'] = $user['rol'];
        header('Location: ' . BASE_URL . '/pages/dashboard.php');
        exit;
    } else {
        echo "<p style='color:red;'>Credenciales incorrectas.</p>";
    }
}
?>

<h1>Iniciar Sesión</h1>
<form method="POST">
    <label>Email: <input type="email" name="email" required></label><br><br>
    <label>Contraseña: <input type="password" name="password" required></label><br><br>
    <button type="submit" class="btn">Entrar</button>
</form>
<p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
<p><a href="forgot_password.php">¿Olvidaste tu contraseña?</a></p>

<?php require_once '../includes/footer.php'; ?>
