<?php
session_start();
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Almacenar datos de sesión
        $_SESSION['usuario_id']    = $user['id'];
        $_SESSION['usuario_email'] = $user['email'];
        $_SESSION['usuario_rol']   = $user['rol'];

        // Redirigir según el rol del usuario
        if ($user['rol'] === 'admin') {
            header('Location: ' . BASE_URL . '/admin/index.php');
        } else {
            header('Location: ' . BASE_URL . '/index.php');
        }
        exit();
    } else {
        echo "<p>Credenciales incorrectas.</p>";
    }
}
?>

<h1>Iniciar Sesión</h1>
<form method="POST" action="">
    <label>Email: <input type="email" name="email" required></label>
    <label>Contraseña: <input type="password" name="password" required></label>
    <button type="submit" class="btn">Entrar</button>
</form>

<?php
require_once 'includes/footer.php';
?>
