<?php
$recipe = $_GET["id"] ?? "";
if (!$recipe) {
    header("Location: /?action=list");
    exit();
}
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO(DSN, DB_USER, DB_PASSWORD, $options);
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
$stmt->execute(["id" => $recipe]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);
if (!isset($recipe)) {
    header("Location: /?action=list");
    exit();
}
$isAuthor =
    isset($_SESSION["user_id"]) && $recipe["user_id"] == $_SESSION["user_id"];
$isAdmin = $_SESSION["is_admin"] ?? false;
if ($recipe["visible"] != 1 && !$isAdmin) {
    header("Location: /?action=list");
    exit();
}
?>
<main class="content">
    <div class="back-link-box">
        <a href="?action=list" class="btn-back">&larr; Назад до усіх рецептів</a>
        <?php if ($isAdmin || $isAuthor) { ?>
        <a href="?action=edit&id=<?= $recipe[
            "id"
        ] ?>" class="btn-edit">Редагувати</a>
        <a href="?action=delete&id=<?= $recipe[
            "id"
        ] ?>" class="btn-delete">Видалити</a>
        <?php } ?>
    </div>
    <article class="single-recipe">
        <div class="recipe-main-header">
            <h2><?= htmlspecialchars($recipe["title"]) ?></h2>
        </div>

        <hr class="divider">

        <div class="recipe-description-text">
            <?= htmlspecialchars($recipe["description"]) ?>
        </div>
    </article>
</main>
