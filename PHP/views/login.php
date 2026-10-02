<?php
if (isset($_SESSION["user_id"])) {
    header("Location: /");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $errors = [];
    if (!$login) {
        $errors[] = "Логін не може бути порожнім";
    }
    if (!$password) {
        $errors[] = "Пароль не може бути порожнім";
    }
    if (empty($errors)) {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO(DSN, DB_USER, DB_PASSWORD, $options);
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->execute(["login" => $login]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["login"] = $login;
            $_SESSION["name"] = $user["name"];
            $_SESSION["is_admin"] = $user["is_admin"];
            header("Location: /");
            exit();
        } else {
            $errors[] = "Неправильний логін або пароль";
        }
    }
    ob_end_flush();
}
?>

<main class="content">
    <div class="auth-container">
        <div class="auth-card">
            <h2>Вхід до акаунту</h2>
            <p class="auth-subtitle">Увійдіть, щоб переглядати та додавати улюблені рецепти</p>

            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post" class="auth-form">
                <div class="form-group">
                    <label for="login">Логін</label>
                    <input type="text" id="login" name="login" placeholder="Введіть ваш логін" required>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>

                <button type="submit" class="btn-submit">Увійти</button>

                <p class="auth-footer">Ще немає акаунту? <a href="?action=registration">Зареєструватися</a></p>
            </form>
        </div>
    </div>
</main>
