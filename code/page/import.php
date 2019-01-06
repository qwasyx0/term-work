<script language='javascript' type='text/javascript'>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<?php

if ($authService->hasIdentity()) :

    if (isset($_GET['id_smazat'])) {
        try {

            $id = $_GET['id_smazat'];
            $sql2 = "delete from importodectu where id = :id";
            $q2 = $pdo->prepare($sql2);
            $q2->bindValue(":id", $id);
            $q2->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    if (isset($_GET['id_upravit'])) {
        $_SESSION["idupravit"] = $_GET['id_upravit'];
        try {
            $sql2 = "select ID, DATUM_ODECTU, STAV, FOTKA, KOMENTAR from uzivatele where id = :id";
            $q2 = $pdo->prepare($sql2);
            $q2->bindValue(":id", $_SESSION["idupravit"]);
            $q2->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo '<br> <div style="text-align: center;"><a style="color:blue; margin:auto;" href="index.php?page=import" >Zpět</a></div><br>'
            . '<h2 style="text-align: center;">Upravit zadaný odečet</h2> ';

    } else {
        echo '<div id="noprint">';
        echo '<h2 style="text-align: center;">Zadejte údaje z vodoměru</h2>';
        echo '</div>';
    }
    ?>

    <div class="formular1">
        <?php
        if (isset($_POST['pridani']) || isset($_POST['upravit'])) {
            if (!isset($_POST['upravit'])) {
                if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                    {
                        $tmpName = $_FILES['image']['tmp_name'];
                        $fp = fopen($tmpName, 'rb');
                        fclose($fp);
                    }
                    try {
                        $sql = "INSERT INTO importodectu (idciselpod, datum_odectu, stav, komentar,fotka) values (:idciselpod, :datum, :stav, :komentar, :fotka);";
                        $pdo->query('set names utf-8');
                        $q2 = $pdo->prepare($sql);
                        $q2->bindValue(":idciselpod", $_SESSION['idciselpod']);
                        $q2->bindValue(":datum", $_POST['datum_odectu']);
                        $q2->bindValue(":stav", $_POST['stav']);
                        $q2->bindValue(":komentar", htmlspecialchars($_POST['komentar']));
                        $q2->bindValue(":fotka", $fp);
                        $q2->execute();
                        echo 'Přidání proběhlo úspěšně.';
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                } else {
                    try {
                        $sql = "INSERT INTO importodectu (idciselpod, datum_odectu, stav, komentar) values (:idciselpod, :datum, :stav, :komentar);";
                        $pdo->query('set names utf-8');
                        $q2 = $pdo->prepare($sql);
                        $q2->bindValue(":idciselpod", $_SESSION['idciselpod']);
                        $q2->bindValue(":datum", $_POST['datum_odectu']);
                        $q2->bindValue(":stav", $_POST['stav']);
                        $q2->bindValue(":komentar", $_POST['komentar']);
                        $q2->execute();
                        echo 'Přidání proběhlo úspěšně.';
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
            } else {

                try {
                    $id = $_GET['id_upravit'];
                    $sql2 = "update importodectu set  datum_odectu= :datum_odectu , stav=:stav ,komentar = :komentar where id=:id ";
                    $q2 = $pdo->prepare($sql2);
                    $q2->bindValue(":id", $_SESSION["idupravit"]);
                    $q2->bindValue(":stav", $_POST['stav']);
                    $q2->bindValue(":komentar", $_POST['komentar']);
                    $q2->bindValue(":datum_odectu", $_POST['datum_odectu']);
                    $q2->execute();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                echo 'Úprava proběhla úspěšně.';
            }

        }
        ?>
<main>
            <div id="noprint">
                <form action="#" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td><label for="datum_odectu">Datum odečtu: </label></td>
                            <td><input required type="date" name="datum_odectu" value='<?php echo date('Y-m-d'); ?>'>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="stav">Stav odečtu ke dni: </label></td>
                            <td><input required type="number" name="stav" min="0"></td>
                        </tr>
                    </table>
                    <textarea id="zprava" name="komentar" maxlength="200"></textarea>
                    <br/>
                    <label for="image" style="position: ;">Připojit fotku (nepovinné): </label>
                    <input id="image" name="image" type="file">
                    <br/>
                    <img id="miniatura" src="">
                    <br/>
                    <?php
                    if (isset($_GET['id_upravit'])) {
                        echo '<input type="submit" value="Upravit" name="upravit" style="width:160px;">';
                    } else if ($_SESSION['role'] == 1) {
                        echo '<input type="submit" value="Zapsat odečet" name="pridani" style="width:160px; margin-top:10px;">';
                    }
                    ?>
                </form>
            </div>
    </div>
    <br/>
    <br/>
    <br/>
    <br/>


    <script>
        document.getElementById("image").onchange = function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("miniatura").src = e.target.result;
                document.getElementById("miniatura").style.height = '100px';
                document.getElementById("miniatura").style.width = '200px';
            };
            reader.readAsDataURL(this.files[0]);
        };
    </script>
    <div class="formular">
        <?php if ($_SESSION['role'] == 0) { ?>
            <h2 style="text-align: center;">Vaše importované odečty</h2>
        <?php } else { ?>
            <h2 style="text-align: center;">Všechny importované odečty</h2>
        <?php } ?>
        <div id="divpohyby">
            <table id="tablecol" cellspacing="0" cellpadding="0">
                <tr>
                    <th>Stav</th>
                    <th>Datum odečtu</th>
                    <th>Fotka</th>
                    <th>Komentář</th>
                    <th>Upravit</th>
                    <th>Smazat</th>
                </tr>

                <?php

                if ($_SESSION['role'] == 1) {
                    $sql = "select * from importodectu";
                } else {
                    $sql = "select * from importodectu where idciselpod= :idciselpod";
                }
                try {
                    $q = $pdo->prepare($sql);
                    $q->bindValue(":idciselpod", $_SESSION['idciselpod']);
                    $q->execute();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                    if ($radek["FOTKA"] != NULL) {
                        $foto = "Ano";
                    } else {
                        $foto = "Ne";
                    }
                    echo '
                                <tr>
                                    <td>' . $radek["STAV"] . '</td>   
                                    <td>' . date("d.m.Y", strtotime($radek["DATUM_ODECTU"])) . '</td>
                                    <td>' . $foto . '</td>  
                                    <td>' . $radek["KOMENTAR"] . '</td>                                            
                                    <td><a style="color:blue;" href="index.php?page=import&id_upravit=' . $radek["ID"] . '&STAV=' . $radek["STAV"] . '&DATUM_ODECTU=' . $radek["DATUM_ODECTU"] . '&FOTKA=' . $radek["FOTKA"] . '&KOMENTAR=' . $radek["KOMENTAR"] . '">Upravit</a></td>                                                        
                                    <td><a style="color:blue;" href="index.php?page=import&id_smazat=' . $radek["ID"] . '&STAV=' . $radek["STAV"] . '&DATUM_ODECTU=' . $radek["DATUM_ODECTU"] . '&FOTKA=' . $radek["FOTKA"] . '&KOMENTAR=' . $radek["KOMENTAR"] . '">Smazat</a></td>       
                                </tr> ';
                } ?>
            </table>
        </div>
    </div>
    </main>
<?php

else  : ?>
    <section id="hero">
        <h2>Pro import odečtu musíte být přihlášeni.</h2>
    </section>
<?php endif; ?>