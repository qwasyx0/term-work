<?php
if ($authService->hasIdentity()) : ?>
    <script language='javascript' type='text/javascript'>
        function check(input) {
            if (input.value != document.getElementById('password').value) {
                input.setCustomValidity('Hesla se musejí shodovat.');
            } else {
                // input is valid -- reset the error message
                input.setCustomValidity('');
            }
        }
    </script>
    <main>
        <?php

        if (isset($_GET['id_smazat'])) {
            try {

                $id = $_GET['id_smazat'];
                $sql2 = "delete from uzivatele where email = :id";
                $q2 = $pdo->prepare($sql2);
                $q2->bindValue(":id", $id);
                $q2->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        if (isset($_GET['id_upravit'])) {
            $idemail = $_GET['id_upravit'];
            try {
                $sql2 = "select email from uzivatele where email = :id";
                $q2 = $pdo->prepare($sql2);
                $q2->bindValue(":id", $idemail);

                $q2->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            echo '<h2>Upravit uživatele <u>' . $idemail . '</u>   </h2> '
                . '<br> <a style="color:blue;" href="index.php?page=users">Zpět</a><br><br>';

        } else {
            if ($_SESSION['role'] == 1) {
                echo '<div id="noprint">';
                echo '<h2>Přidat nového uživatele</h2>';
                echo '</div>';
            }
        }
        ?>
        <div class="formular1">
            <?php
            if (isset($_POST['pridani']) || isset($_POST['upravit'])) {
                $hash = hash('sha512', $_POST['password']);
                if (isset($_POST['upravit'])) {
                    if ($_SESSION['role'] == 1) {
                        try {
                            $sql2 = "update uzivatele set  password= :password, role= :role where email = :email ";
                            $q2 = $pdo->prepare($sql2);
                            $q2->bindValue(":email", htmlspecialchars($idemail));
                            $q2->bindValue(":password", $hash);
                            $q2->bindValue(":role", $_POST['role']);
                            $q2->execute();
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        echo 'Úprava proběhla úspěšně.';
                    } else {
                        try {
                            $sql2 = "update uzivatele set  password= :password where email = :email ";
                            $q2 = $pdo->prepare($sql2);
                            $q2->bindValue(":email", $idemail);
                            $q2->bindValue(":password", $hash);
                            $q2->execute();
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        echo 'Úprava proběhla úspěšně.';
                    }
                } else {
                    try {
                        $sql = "INSERT INTO uzivatele (email, password, role) values (:email, :password, :role);";
                        $q2 = $pdo->prepare($sql);
                        $q2->bindValue(":email", htmlspecialchars($_POST['loginMail']));
                        $q2->bindValue(":password", $hash);
                        $q2->bindValue(":role", $_POST['role']);
                        $q2->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    echo 'Přidání proběhlo úspěšně.';

                }
            } else {
                ?>
                <form action="#" method="post">

                    <?php
                    if (($_SESSION['role'] == 1) or (($_SESSION['role'] == 0) and isset($_GET['id_upravit']))) { ?>
                    <div id="noprint">
                        <table>
                            <?php if (!isset($_GET['id_upravit'])) { ?>

                                <tr>
                                    <td><label for="loginMail">Email: </label></td>
                                    <td><input required type="text" name="loginMail" id="loginMail"></td>
                                </tr>

                            <?php } ?>
                            <tr>
                                <td><label for="password">Heslo: </label></td>
                                <td><input required type="password" name="password" id="password"></td>
                            </tr>
                            <tr>
                                <td><label for="passwordZnova">Heslo znova: </label></td>
                                <td><input required type="password" id="passwordZnova" name="passwordRepeat"
                                           oninput="check(this)"/></td>
                            </tr>
                            <?php if ($_SESSION['role'] == 1) { ?>
                                <td>
                                    <label for="role">Role: </label></td>
                                <td>
                                    <select name="role">
                                        <?php
                                        try {
                                            $sql = 'select distinct role from uzivatele order by role asc';
                                            $q = $pdo->prepare($sql);
                                            $q->execute();
                                        } catch (PDOException $e) {
                                            echo "Error: " . $e->getMessage();
                                        }
                                        while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                            $role = $radek['role'];
                                            echo ' <option value="' . $role . '">' . $role . '</option> ';
                                        }
                                        ?>
                                    </select>
                                </td>
                            <?php }
                            } ?>
                            <tr>
                                <td></td>
                                <td>
                                    <?php
                                    if (isset($_GET['id_upravit'])) {
                                        echo '<input type="submit" value="Upravit" name="upravit" style="width:160px;">';
                                    } else if ($_SESSION['role'] == 1) {
                                        echo '<input type="submit" value="Přidat" name="pridani" style="width:160px;">';
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
                <?php
            }
            echo "<br><br><br><br>";
            ?>

        </div>
        <?php
        try {
            $sql = "select role from uzivatele where email=:email;";
            $q = $pdo->prepare($sql);
            $identity = $authService->getIdentity();
            $q->bindValue(":email", $_SESSION['email']);
            $q->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $row = $q->fetch(PDO::FETCH_ASSOC);
        // nefunguje role
        if ($row["role"] == 1) {
        ?>
        <h2>Uživatelské účty</h2>

        <div class="formular2" style="overflow-x:auto;">
            <table id="tablecol" cellspacing="0" cellpadding="0">
                <tr>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Firma</th>
                    <th>Ulice</th>
                    <th>Město</th>
                    <th>Upravit</th>
                    <th>Smazat</th>
                </tr>
                <?php
                try {
                    $sql = 'select email, role, firma, ulice, mesto from uzivatele, ciselpod where uzivatele.idciselpod = ciselpod.IDCISELPOD;';
                    $q = $pdo->prepare($sql);
                    $q->execute();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                <tr>
                    <td>' . $radek["email"] . '</td>
                    <td>' . $radek["role"] . '</td>      
                    <td>' . $radek["firma"] . '</td>
                    <td>' . $radek["ulice"] . '</td>  
                    <td>' . $radek["mesto"] . '</td>                 
                    <td><a style="color:blue;" href="index.php?page=users&id_upravit=' . $radek["email"] . '&role=' . $radek["role"] . '&firma=' . $radek["firma"] . '&ulice=' . $radek["ulice"] . '&mesto=' . $radek["mesto"] . '">Upravit</a></td>                                                     
                     <td><a style="color:blue;" href="index.php?page=users&id_smazat=' . $radek["email"] . '">Smazat</a></td>                                                  
                </tr> ';
                }
                } else {
                ?>

                <h2>Údaje uživatele</h2>
                <div class="formular1">
                    <table>
                        <tr>
                            <th>Email</th>
                            <th>Upravit</th>
                        </tr>
                        <?php
                        try {
                            $sql = 'select email from uzivatele where idciselpod=:idciselpod;';
                            $q = $pdo->prepare($sql);
                            $q->bindValue(":idciselpod", $_SESSION['idciselpod']);
                            $q->execute();
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                            echo '
                <tr id="uzivatele">
                    <td>' . $radek['email'] . '</td>                     
                    <td><a style="color:blue;" href="index.php?page=users&id_upravit=' . $radek["email"] . '">Upravit</a></td>                                                
                </tr> ';
                        }
                        }
                        echo '</table>'; ?>


    </main>
<?php else  : ?>
    <section id="hero">
        <h2>Pro zobrazení správy uživatelů musíte být přihlášeni.</h2>
    </section>
<?php endif; ?>