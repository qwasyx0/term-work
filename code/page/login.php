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
                $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("SELECT idciselpod, email, role FROM uzivatele WHERE email= :email and password = :password");
                $stmt->bindParam(':email', $_POST["loginMail"]);
                $stmt->bindParam(':password', $_POST["loginPassword"]);
                $stmt->execute();
                $user = $stmt->fetch();
                if (!$user) {
                    echo "Uživatel nenalezen";
                } else {
                    // echo "you are logged in. Your EMAIL is: " . $user["email"];
                    $_SESSION["email"] = $user["email"];
                    header("Location:" . BASE_URL);
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

