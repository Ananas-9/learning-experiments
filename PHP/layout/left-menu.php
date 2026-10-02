<aside class="sidebar">
    <?php if (isset($_SESSION["user_id"])): ?>
    <div class="user-profile-block">
            <div class="user-avatar"><i class="fa-solid fa-user"></i></div>
            <div class="user-info">
                <span class="user-greet">Привіт,</span>
                <span class="user-name"><?php echo $_SESSION["name"]; ?>!</span>
            </div>
        </div>
    <?php endif; ?>

    <nav class="side-nav">
        <ul>
            <li><a href="?action=index" <?php if (basename($page) == "index") {
                echo 'class="active"';
            } ?>>Головна</a></li>
            <li><a href="?action=about" <?php if (basename($page) == "about") {
                echo 'class="active"';
            } ?>>Про cайт</a></li>
            <li><a href="?action=list" <?php if (basename($page) == "list") {
                echo 'class="active"';
            } ?>>Список рецептів</a></li>
            <?php if (!isset($_SESSION["user_id"])): ?>
            <li><a href="?action=registration" <?php if (
                basename($page) == "registration"
            ) {
                echo 'class="active"';
            } ?>>Реєстрація</a></li>
            <li><a href="?action=login" <?php if (basename($page) == "login") {
                echo 'class="active"';
            } ?>>Вхід</a></li>
            <?php else: ?>
            <li><a href="?action=create" <?php if (
                basename($page) == "create"
            ) {
                echo 'class="active"';
            } ?>>Створити рецепт</a></li>
            <li><a href="?action=logout" <?php if (
                basename($page) == "logout"
            ) {
                echo 'class="active"';
            } ?>>Вихід</a></li>
            <?php endif; ?>

        </ul>
    </nav>
</aside>
