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
 <td><a style="color:blue;" href="index.php?page=pridatUzivatele&id_smazat='.$radek["id_uzivatele"].'">Smazat</a></td>
<?php

if ($user["role"] == '0') { ?>
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
if ($user["role"]  == '1') { ?>
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
