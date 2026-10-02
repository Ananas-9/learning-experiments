<?php
if (!isset($_SESSION["user_id"])) {
    header("Location: ?action=login");
    exit();
}
$errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"] ?? "";
    $description = $_POST["description"] ?? "";
    if (empty($title)) {
        $errors[] = "Заголовок не має бути пустим.";
    }
    $cleaned_description = trim(strip_tags($description));
    $cleaned_description = htmlspecialchars(
        $cleaned_description,
        ENT_QUOTES,
        "UTF-8",
    );
    if (empty($cleaned_description)) {
        $errors[] = "Опис не має бути пустим.";
    }
    if (empty($errors)) {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO(DSN, DB_USER, DB_PASSWORD, $options);
        $stmt = $pdo->prepare(
            "INSERT INTO recipes (title, description, visible, user_id) VALUES (:title, :description, :visible, :user_id)",
        );
        $stmt->execute([
            ":title" => $title,
            ":description" => $cleaned_description,
            ":visible" => $_SESSION["is_admin"],
            ":user_id" => $_SESSION["user_id"],
        ]);

        header("Location: ?action=list");
        exit();
    }
}
ob_end_flush();
?>

<main class="content">
    <div class="recipe-container">
        <div class="recipe-card">
            <h2>Додати новий рецепт</h2>
            <p class="recipe-subtitle">Поділіться своїм кулінарним шедевром з іншими</p>

            <form method="post" class="recipe-form">

                <div class="form-group">
                    <label for="recipe-title">Назва страви</label>
                    <input type="text" id="recipe-title" name="title" placeholder="Наприклад: Український борщ з пампушками" required>
                </div>

                <div class="form-group">
                    <label for="recipe-desc">Опис та спосіб приготування</label>
                    <textarea id="recipe-desc" name="description" placeholder="1. Наріжте м'ясо та поставте варитися бульйон...&#10;2. Додайте буряк, картоплю та засмажку...&#10;3. Варіть на слабкому вогні до готовності." required></textarea>
                </div>

                <button type="submit" class="btn-submit">Опублікувати рецепт</button>
            </form>
        </div>
    </div>
</main>
