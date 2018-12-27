 <?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare("SELECT * FROM users WHERE email= :email");
$stmt->bindParam(':email', $_SESSION["email"]);
$stmt->execute();
$user = $stmt->fetch();
?>
    <style>
        div {
            margin-top: 30px;
            margin-left: 20px;
            margin-bottom: 20px;
        }
    </style>
<?php
if ($_SESSION["role"] == '0') { ?>
    <?php
    if ($_GET["action"] == "update") {
        include "./user/user-update.php";
    } else {
        include "./user/user-read-self.php";
    }
} else {?>    <div>Nastavení uživatele</div>
    <a href="<?= BASE_URL . "?page=users&action=update" ?>">Upravit mé osobní údaje</a>
    <?php include "./user/user-read-self.php";
}
if ($_SESSION["role"]  == '1') { ?>
    <?php if ($_GET["action"] == "delete") {
        include "./user/user-delete.php";
    } else if ($_GET["action"] == "update") {
        include "./user/user-update.php";
    } else if ($_GET["action"] == "create") {
        include "./user/user-add.php";
    } else {?>    <div>Nastavení administrátora</div>
        <?php   include "./user/user-read-all.php";
    }
}
?>


<?php
/*if ($_GET["action"] == "read-all") {
    echo "<h2>All users</h2>";
    $userDao = new UserRepository(Connection::getPdoInstance());
    $allUsersResult = $userDao->getAllUsers();

    $datatable = new DataTable($allUsersResult);
    $datatable->addColumn("id", "ID");
    $datatable->addColumn("email", "Email");
    $datatable->addColumn("created", "Created");
    $datatable->render();


} else if ($_GET["action"] == "by-email") {
    echo "<h2>By email</h2>";
//toto nahore
    ?>
    <?php

    if (!empty($_POST["mail"])) {
        $userDao = new UserRepository(Connection::getPdoInstance());
        $usersByEmail = $userDao->getByEmail($_POST["mail"]);
        $datatable = new DataTable($usersByEmail);
        $datatable->addColumn("id", "ID");
        $datatable->addColumn("email", "Email");
        $datatable->addColumn("created", "Created");
        $datatable->render();
    }
}
?>