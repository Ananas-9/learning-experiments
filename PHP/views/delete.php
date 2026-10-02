<?php
if (!isset($_SESSION["user_id"])) {
    header("Location: /?action=list");
    exit();
}
if (!isset($_GET["id"])) {
    header("Location: /?action=list");
    exit();
}

$recipeId = $_GET["id"];

$pdo = new PDO(DSN, DB_USER, DB_PASSWORD, $options);
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
$stmt->execute(["id" => $recipeId]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);
if (!isset($recipe)) {
    header("Location: /?action=list");
    exit();
}
$isAuthor =
    isset($_SESSION["user_id"]) && $recipe["user_id"] == $_SESSION["user_id"];
$isAdmin = $_SESSION["is_admin"] ?? false;
if (!$isAuthor && !$isAdmin) {
    header("Location: /?action=list");
    exit();
}
$stmt = $pdo->prepare("DELETE FROM recipes WHERE id = :id");
$stmt->execute(["id" => $recipeId]);
header("Location: /?action=list");
exit();
