<?php
$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$authService = Authentication::getInstance();
?>
<header>
    <!-- <div id="header-web-title">Odečty vodoměrů</div>
     <img id="header-logo" src="images/logo.jpg"/> -->
    <nav id="nav">
        <?php if ($authService->hasIdentity()) : ?>
            <a href="<?= BASE_URL . "?page=import" ?>">Import odečtu</a>
            <a href="<?= BASE_URL . "?page=odecty" ?>">Prohlížení odečtů</a>
            <a href="<?= BASE_URL . "?page=users" ?>">Nastavení</a>
            <a href="<?= BASE_URL . "?page=kontakt" ?>">Kontakt</a>
            <a href="<?= BASE_URL . "?page=logout" ?>">Odhlásit</a>
        <?php else : ?>
            <a href="<?= BASE_URL ?>">Úvodní stránka</a>
            <a href="<?= BASE_URL . "?page=login" ?>">Přihlásit</a>
        <?php endif; ?>
    </nav>

</header>