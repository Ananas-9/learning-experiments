<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"] ?? "";
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $repeatPassword = $_POST["password_confirm"] ?? "";
    $about_me = $_POST["about_me"] ?? "";

    $login_pattern = '/^[a-zA-Z]{4,}$/u';
    $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z0-9]{7,}$/u';
    $email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    if (!preg_match($login_pattern, $login)) {
        $errors[] = "Некоректний логін (мінімум 4 латинські літери).";
    }

    if (empty($name)) {
        $errors[] = "Будь ласка, введіть ваше ім'я.";
    }

    if (!preg_match($password_pattern, $password)) {
        $errors[] =
            "Некоректний пароль (мінімум 7 символів, обов'язково одна велика, одна мала літера та цифра).";
    }

    if (!preg_match($email_pattern, $email)) {
        $errors[] = "Некоректна електронна пошта.";
    }

    if ($password !== $repeatPassword) {
        $errors[] = "Паролі не збігаються.";
    }
    if (!empty(trim($about_me))) {
        $cleaned_about_me = strip_tags($about_me);
        $cleaned_about_me = htmlspecialchars(
            $cleaned_about_me,
            ENT_QUOTES,
            "UTF-8",
        );
    } else {
        $cleaned_about_me = "";
    }
    if (empty($errors)) {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO(DSN, DB_USER, DB_PASSWORD, $options);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, login, email, password, about_me)
                    VALUES (:name, :login, :email, :password, :about_me)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":name" => $name,
            ":login" => $login,
            ":email" => $email,
            ":password" => $hashed_password,
            ":about_me" => $cleaned_about_me,
        ]);
        header("Location: /?action=registration-successful");
        exit();
    }
    ob_end_flush();
}
?>

<main class="content">
    <div class="auth-container">
        <div class="auth-card">
            <h2>Реєстрація</h2>
            <p class="auth-subtitle">Створіть власний кабінет, щоб зберігати улюблені рецепти</p>

            <?php if (!empty($errors)): ?>
                <div class="error-messages" style="color: red; background: #ffe6e6; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" class="auth-form">
                <div class="form-group">
                    <label for="login">Логін</label>
                    <input type="text" id="login" name="login" placeholder="Введіть ваш логін" value="<?= htmlspecialchars(
                        $login ?? "",
                    ) ?>" required>
                </div>

                <div class="form-group">
                    <label for="name">Ім'я</label>
                    <input type="text" id="name" name="name" placeholder="Введіть ваше ім'я" value="<?= htmlspecialchars(
                        $name ?? "",
                    ) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Електронна пошта</label>
                    <input type="email" id="email" name="email" placeholder="example@mail.com" value="<?= htmlspecialchars(
                        $email ?? "",
                    ) ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>

                <div class="form-group">
                    <label for="password_confirm">Повторіть пароль</label>
                    <input type="password" id="repeatPassword" name="password_confirm" placeholder="********" required>
                </div>
                <div class="form-group">
                    <label for="about_me">Про себе</label>
                    <textarea id="about_me" name="about_me" placeholder="Введіть інформацію про себе" required><?= htmlspecialchars(
                        $about_me ?? "",
                    ) ?></textarea>
                </div>
                <button type="submit" class="btn-submit">Зареєструватися</button>
            </form>
        </div>
    </div>
</main>
