<label for="password">Contraseña:</label>
<div class="password-container">
    <input type="password" name="password" id="password" required>
    <img id="icono-ojo" class="toggle-password-img"
         src="<?php echo BASE_URL; ?>/assets/images/eye-closed.png"
         alt="Mostrar contraseña"
         onmousedown="mostrarPassword()"
         onmouseup="ocultarPassword()"
         onmouseleave="ocultarPassword()">
</div>
