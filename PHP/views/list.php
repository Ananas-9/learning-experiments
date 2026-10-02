<?php
ob_end_flush();
$recipes = [];

if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO(DSN, DB_USER, DB_PASSWORD, $options);
    $stmt = $pdo->prepare("SELECT * FROM recipes");
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO(DSN, DB_USER, DB_PASSWORD, $options);
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE visible = 1");
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<main class="content">
    <div class="recipes-header">
        <h2>Кулінарна книга</h2>
        <p>Збірка твоїх найкращих та найсмачніших рецептів</p>
    </div>

    <div class="recipes-grid">
        <?php foreach ($recipes as $recipe): ?>
            <div class="recipe-item-card">
                <div class="recipe-card-content">
                    <h3><?php echo $recipe["title"]; ?></h3>
                    <a href="?action=view-recipe&id=<?php echo $recipe[
                        "id"
                    ]; ?>" class="btn-read">Читати рецепт &rarr;</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
