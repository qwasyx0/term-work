<section id="hero">
    <div>
        <form method="post">
            Email:<input type="email" name="loginMail" placeholder="Zadejte svůj email">
            Heslo:<input type="password" name="loginPassword" placeholder="Zadejte heslo">
            <input type="submit" value="log in">
        </form>
        <p>
            <?php
            if (!empty($_POST) && !empty($_POST["loginMail"]) && !empty($_POST["loginPassword"])) {
                $hash = hash('sha512', $_POST["loginPassword"]);
                $_SESSION['email'] = $_POST["loginMail"];
                if ($authService->login($_POST['loginMail'],$hash)){
                    header("Location:" . BASE_URL);
                } else {
                    echo "Uživatel nenalezen";
                }
            } else if (!empty($_POST)) {
                echo "Zadejte email a heslo";
            }

            ?>
        </p>
    </div>
</section>
<main>
    <a>TOTO JE LOGIN</a>
</main>



