<?php ob_start(); session_start(); include 'config.php';
#process of a message
$message = "";
if (isset($_POST['newsletter'])) {
    if (!empty($_POST['email'])) {
        if ((preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $_POST['email']))) {
            try {
                $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // prepare sql and bind parameters
                $stmt = $conn->prepare("INSERT INTO newsletter (email, created) VALUES (:email, NOW())");
                $stmt->bindParam(':email', $_POST["email"]);
                $stmt->execute();

                $message = "You are subscribed!";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                $message = "Unable to save to the database!";
            }
        } else {
            $message = "Bad formatted email address!";
        }
    } else {
        $message = "Email address is needed!";
    }
}
?>


<html lang="cs">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css"
          href="css/css.css">
    <title>Semestralni prace</title>
</head>

<body>

<header>
    <!-- <div id="header-web-title">Odečty vodoměrů</div>
     <img id="header-logo" src="images/logo.jpg"/> -->
    <nav id="nav">
        <a href="<?= BASE_URL ?>">Úvodní stránka</a>
        <?php if (!empty($_SESSION["user_id"])) { ?>
            <a href="<?= BASE_URL  . "?page=users" ?>">Nastavení</a>
            <a href="<?= BASE_URL  . "?page=logout" ?>">Odhlásit</a>
        <?php } else { ?>

            <a href="<?= BASE_URL  . "?page=login" ?>">Přihlásit</a>
        <?php } ?>
    </nav>

    <?php
    #feedback message
    if (!empty($message)) {
        echo $message;
        $message = "";
    }
    ?>


</header>
<?php
if (isset($_GET["page"])) {
    $file = "./page/" . $_GET["page"] . ".php";
    if (file_exists($file)) {
        include $file;
    } }else { ?>

<?php if (!empty($_SESSION["user_id"])) { ?>
    <section id="hero">
        <div>
            <h1>Po prihaseni</h1>
            <h2>Semestrální práce</h2>
            <a href="#">
                Dozvědět se více
            </a>
        </div>
    </section>
<?php }else { ?>
<section id="hero">
    <div>
        <h1>Odečty vodoměrů</h1>
        <h2>Semestrální práce</h2>
        <a href="#">
            Dozvědět se více
        </a>
    </div>
</section>

<main>
<a>TOTO JE INDEX</a>
</main>

<footer>
    <div class="full-width-wrapper">
        <div class="flex-wrap">
            <section>
                <h4>Kontakt</h4>
                <address>Softbit software s.r.o.<br>
                    Nad Dubinkou 1634<br>
                    516 01 Rychnov nad Kněžnou<br><br>
                    Tel: +420 777 666 555<br>
                    Email: <a href="mailto:softbit@softbit.cz">
                        sotfbit@softbit.cz</a><br>
                </address>
            </section>
        </div>
        <section>
            <p>
                ©
                <a href="https://www.softbit.cz/">SOFTbit software s.r.o.</a>
                <?=2017?>
                -
                <?php echo date("Y"); ?>

            </p>
        </section>
    </div>
</footer>
<?php  }}  ?>
</body>
</html>






