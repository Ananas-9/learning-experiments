<?php
ob_start();
session_start();
define("DB_HOST", "db");
define("DB_USER", "recepts");
define("DB_PASSWORD", "recepts");
define("DB_NAME", "recepts");
define(
    "DSN",
    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
);

$pages = [
    "about" => "views/about.php",
    "index" => "views/index.php",
    "registration" => "views/registration.php",
    "registration-successful" => "views/registration-successful.php",
    "login" => "views/login.php",
    "logout" => "views/logout.php",
    "create" => "views/create.php",
    "list" => "views/list.php",
    "view-recipe" => "views/view-recept.php",
    "edit" => "views/edit.php",
    "delete" => "views/delete.php",
];

$page = $_GET["action"] ?? "index";
include "layout/header.php";
include "layout/left-menu.php";

include $pages[$page];
include "layout/footer.php";
?>
