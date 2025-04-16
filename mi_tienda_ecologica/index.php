<?php
require_once 'includes/header.php';
?>

<section class="hero-banner">
    <h1>Frutas y verduras ecológicas</h1>
    <p>Disfruta de los mejores productos orgánicos directamente en tu puerta.</p>
    <a href="<?php echo BASE_URL; ?>/catalog.php" class="btn">Ver productos</a>
</section>

<section class="featured-products">
    <h2>Productos Destacados</h2>
    <div class="product-grid">
        <?php
        // Ejemplo de consulta para sacar algunos productos
        $stmt = $pdo->query("SELECT * FROM productos LIMIT 4");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='product-item'>";
            echo "<img src='" . BASE_URL . "/assets/images/productos/" . $row['imagen'] . "' alt='" . $row['nombre'] . "' />";
            echo "<h3>" . $row['nombre'] . "</h3>";
            echo "<p>€" . $row['precio'] . "</p>";
            echo "<a href='" . BASE_URL . "/cart.php?add=" . $row['id'] . "' class='btn'>Añadir al carrito</a>";
            echo "</div>";
        }
        ?>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>
