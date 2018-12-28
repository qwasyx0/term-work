<style>
    /* h1 {
         margin-top: 30px;

     }*/
</style>
<?php
if (!empty($_SESSION["email"])) { ?>
    <section id="hero">
        <h1>TOTO JE ODECTY</h1>
    </section>
<?php } else { ?>
    <section id="asdf">
        <h2>Pro zobrazení historie odečtů musíte být přihlášeni.</h2>
        <a href="./index.php">Návrat na úvodní stránku</a>
    </section>
<?php } ?>


