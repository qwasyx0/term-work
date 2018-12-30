<?php

$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$authService = Authentication::getInstance();
?>
<header>
    <!-- <div id="header-web-title">Odečty vodoměrů</div>
     <img id="header-logo" src="images/logo.jpg"/> -->
    <nav id="nav">
        <a href="<?= BASE_URL ?>">Úvodní stránka</a>
        <?php if ($authService->hasIdentity()) : ?>
            <a href="<?= BASE_URL . "?page=odecty" ?>">Prohlížení odečtů</a>
            <a href="<?= BASE_URL . "?page=import" ?>">Import odečtu</a>
            <a href="<?= BASE_URL . "?page=users" ?>">Nastavení</a>
            <a href="<?= BASE_URL . "?page=logout" ?>">Odhlásit</a>
        <?php  else : ?>
            <a href="<?= BASE_URL . "?page=login" ?>">Přihlásit</a>
        <?php endif; ?>
    </nav>

</header>