<?php
$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$authService = Authentication::getInstance();
    $sql = "select role, idciselpod from uzivatele where email=:email;";
    $q = $pdo->prepare($sql);
    $identity = $authService->getIdentity();
    $q->bindValue(":email", $_SESSION['email']);
    $q->execute();
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $_SESSION['role'] = $row["role"];
    $_SESSION['idciselpod'] = $row['idciselpod'];
    $roleslovne = "";
    if ($_SESSION['role'] == 1) {
        $roleslovne = " administrátor";
    } else {
        $roleslovne = " běžný uživatel";
    }

?>
    <nav id="nav">
        <?php if ($authService->hasIdentity()) : ?>
            <a href="<?= BASE_URL . "?page=import" ?>">Import odečtu</a>
            <a href="<?= BASE_URL . "?page=odecty" ?>">Prohlížení odečtů</a>
            <a href="<?= BASE_URL . "?page=edit_mista" ?>">Editace</a>
            <a href="<?= BASE_URL . "?page=users" ?>">Nastavení</a>
            <a href="<?= BASE_URL . "?page=kontakt" ?>">Kontakt</a>
            <a href="<?= BASE_URL . "?page=logout" ?>">Odhlásit</a>
            <span>Jste přihlášen jako:<br/><?php echo $_SESSION["email"]; ?><br/>Role:<?php echo $roleslovne; ?></span>
        <?php else : ?>
            <a href="<?= BASE_URL ?>">Úvodní stránka</a>
            <a href="<?= BASE_URL . "?page=login" ?>">Přihlásit</a>
        <?php endif; ?>
    </nav>