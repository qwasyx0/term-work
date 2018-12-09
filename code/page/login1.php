<?php
if (!empty($_POST) && !empty($_POST["loginMail"]) && !empty($_POST["loginPassword"])) {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //get user by email and password
    $stmt = $conn->prepare("SELECT EMAIL FROM VV_UZIVATELE
                                      WHERE EMAIL= :EMAIL and PASSWORD = :PASSWORD");
    $stmt->bindParam(':EMAIL', $_POST["loginMail"]);
    $stmt->bindParam(':PASSWORD', $_POST["loginPassword"]);
    $stmt->execute();
    $user = $stmt->fetch();
    if (!$user) {
        echo "user not found";
    } else {
        echo "you are logged in. Your EMAIL is: " . $user["EMAIL"];
        $_SESSION["email"] = $user["EMAIL"];
        header("Location:" . BASE_URL);
    }

} else if (!empty($_POST)) {
    echo "Email and password are required";
}
?>
<section id="hero">

<form method="post" >
    <input type="email" name="loginMail" placeholder="Insert your email">
    <input type="password" name="loginPassword" placeholder="Password">
    <input type="submit" value="log in">
</form>
</section>
<main>
    <a>TOTO JE LOGIN</a>
</main>