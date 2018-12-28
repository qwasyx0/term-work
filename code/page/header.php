<header>
    <!-- <div id="header-web-title">Odečty vodoměrů</div>
     <img id="header-logo" src="images/logo.jpg"/> -->
    <nav id="nav">
        <a href="<?= BASE_URL ?>">Úvodní stránka</a>
        <?php if (!empty($_SESSION["email"])) { ?>
            <a href="<?= BASE_URL . "?page=odecty" ?>">Prohlížení odečtů</a>
            <a href="<?= BASE_URL . "?page=import" ?>">Import odečtu</a>
            <a href="<?= BASE_URL . "?page=users" ?>">Nastavení</a>
            <a href="<?= BASE_URL . "?page=logout" ?>">Odhlásit</a>
        <?php } else { ?>
            <a href="<?= BASE_URL . "?page=login" ?>">Přihlásit</a>
        <?php } ?>
    </nav>

</header>