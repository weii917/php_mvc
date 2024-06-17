<h1>Products</h1>
<?php foreach ($products as $product) : ?>
    <h2>
        <a href="/products/<?= $product["id"]; ?>/show">
            <?= htmlspecialchars($product['name']) ?>
        </a>
    </h2>
    <p><?= htmlspecialchars($product['description']) ?></p>

<?php
endforeach;
?>
</body>

</html>