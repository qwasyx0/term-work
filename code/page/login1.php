<section id="hero">
    <div>
        <form method="post" >
            Email:<input type="email" name="loginMail" placeholder="Insert your email">
            Heslo:<input type="password" name="loginPassword" placeholder="Password">
            <input type="submit" value="log in">
        </form>
        <p>


            <?php

            if (!empty($_POST) && !empty($_POST["loginMail"]) && !empty($_POST["loginPassword"])) {
                $authService = Authentication::getInstance();
                if ($authService->login($_POST["loginMail"], $_POST["loginPassword"])) {
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
