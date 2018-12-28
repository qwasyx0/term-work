<?php
ob_start();
session_start();
include 'config.php';

function __autoload($className)
{
    if (file_exists('./class/' . $className . '.php')) {
        require_once './class/' . $className . '.php';
        return true;
    }
    return false;
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
<?php
    include_once("./page/header.php");
?>
</header>
<?php
if (isset($_GET['page'])) {
    $file = "./page/" . $_GET["page"] . ".php";
    if (file_exists($file)) {
        include $file;
    } else {
        include "./page/404.php";
    }
} else {
    if (!empty($_SESSION["email"])) { ?>
        <section id="hero">
            <div>
                <h1>Po prihaseni</h1>
                <h2>Semestrální práce</h2>
                <a href="#">
                    Dozvědět se více
                </a>
            </div>
        </section>
        <main>
            <a>TOTO JE INDEX PO PRIHLASENI</a>
        </main>
    <?php } else { ?>
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
    <?php }
}
include_once("./page/footer.php");
?>


</body>
</html>






