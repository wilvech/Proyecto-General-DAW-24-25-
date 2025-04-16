<?php
require_once 'includes/header.php';
?>

<section class="hero-banner">
    <h1>Frutas y Verduras Ecológicas</h1>
    <p>Disfruta de los mejores productos orgánicos directamente en tu puerta.</p>
    <a href="pages/catalog.php" class="btn">Ver productos</a>
</section>

<section class="featured-products">
    <h2>Productos Destacados</h2>
    <div class="product-grid">
        <?php
        $stmt = $pdo->query("SELECT * FROM productos ORDER BY id DESC LIMIT 4");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='product-item'>";
            echo "<img src='uploads/productos/" . htmlspecialchars($row['imagen']) . "' alt='" . htmlspecialchars($row['nombre']) . "' />";
            echo "<h3>" . htmlspecialchars($row['nombre']) . "</h3>";
            echo "<p>€" . htmlspecialchars($row['precio']) . "</p>";
            echo "<a href='pages/cart.php?add=" . $row['id'] . "' class='btn'>Añadir al carrito</a>";
            echo "</div>";
        }
        ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
