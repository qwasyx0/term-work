<script language='javascript' type='text/javascript'>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<script>
    function zobrazNaNovemPanelu(element) {
        var newTab = window.open();
        var data = document.getElementById("choicedPhoto").getAttribute("src");
        setTimeout(function () {
            newTab.document.body.innerHTML = "<img src='" + data + "'>";
        }, 500);
        return false;
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
        $upravit = $_GET['id_upravit'];
        try {
            $sql2 = "select  DATUM_ODECTU, STAV,  KOMENTAR from importodectu where ID = :id";
            $q2 = $pdo->prepare($sql2);
            $q2->bindValue(":id", $upravit);
            $q2->execute();
            while ($radek = $q2->fetch(PDO::FETCH_ASSOC)) {
                $datum_odectu = $radek['DATUM_ODECTU'];
                $stav = $radek['STAV'];
                $komentar = $radek['KOMENTAR'];
            }

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
    <main>
        <div class="formular1">
            <?php
            if (isset($_POST['pridani']) || isset($_POST['upravit'])) {
                if (!isset($_POST['upravit'])) {
                    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                        {
                            $tmpName = $_FILES['image']['tmp_name'];
                            $fp = fopen($tmpName, 'rb');
                            $fotka_content = file_get_contents($tmpName);

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
                            $q2->bindValue(":fotka", $fotka_content);
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
                        $q2->bindValue(":id", $upravit);
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
            <div id="noprint">
                <form action="#" method="post" enctype="multipart/form-data">
                    <?php if (!isset($_GET['id_upravit'])) { ?>


                        <table>
                            <tr>
                                <td><label for="datum_odectu">Datum odečtu: </label></td>
                                <td><input required type="date" name="datum_odectu"
                                           value='<?php echo date('Y-m-d'); ?>'>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="stav">Stav odečtu ke dni: </label></td>
                                <td><input required type="number" name="stav" min="0"></td>
                            </tr>
                        </table>
                        <textarea id="zprava" name="komentar" maxlength="200"></textarea>
                        <br/>
                        <table>
                            <tr>
                                <td><label for="image" style="position: ;">Připojit fotku (nepovinné): </label></td>
                                <td><input id="image" name="image" type="file"></td>
                            </tr>
                        </table>
                        <br/>
                        <img id="miniatura" src="">
                        <br/>
                        <?php
                    } else { ?>

                        <table>
                            <tr>
                                <td><label for="datum_odectu">Datum odečtu: </label></td>
                                <td><input required type="date" name="datum_odectu"
                                           value='<?php echo date($datum_odectu); ?>'>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="stav">Stav odečtu ke dni: </label></td>
                                <td><input required type="number" name="stav" min="0" value="<?php echo $stav; ?>"></td>
                            </tr>
                        </table>
                        <textarea id="zprava" name="komentar" maxlength="200"
                                  value="<?php echo $komentar; ?>"></textarea>
                        <br/>
                        <table>
                            <tr>
                                <td><label for="image" style="position: ;">Připojit fotku (nepovinné): </label></td>
                                <td><input id="image" name="image" type="file"></td>
                            </tr>
                        </table>
                        <br/>
                        <img id="miniatura" src="">
                        <br/>
                    <?php } ?>

                    <?php
                    if (isset($_GET['id_upravit'])) {
                        echo '<input type="submit" value="Upravit" name="upravit" style="width:160px;">';
                    } else {
                        echo '<input type="submit" value="Zapsat odečet" name="pridani" style="width:160px; margin-top:10px;">';
                    }
                    ?>
                </form>
            </div>
        </div>
        <br/>
        <br/>
        <?php
        if (isset($_GET['id_upravit'])) {
            try {
                $id = $_GET['id_upravit'];
                $sql2 = "select fotka from importodectu where id=:id ";
                $q2 = $pdo->prepare($sql2);
                $q2->bindValue(":id", $upravit);
                $q2->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($adek['fotka']) . '"/>';
            }
        } ?>
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
                        <th>Firma</th>
                        <th>Stav</th>
                        <th>Datum odečtu</th>
                        <th>Fotka</th>
                        <th>Komentář</th>
                        <th>Zapsat</th>
                        <th>Upravit</th>
                        <th>Smazat</th>
                    </tr>

                    <?php
                    try {
                        if ($_SESSION['role'] == 1) {
                            $sql = "select i.ID, i.IDCISELPOD,c.FIRMA, i.STAV, i.FOTKA, i.DATUM_ODECTU, i.KOMENTAR from importodectu i 
                              left join ciselpod c on i.IDCISELPOD = c.IDCISELPOD order by FIRMA ASC, STAV DESC";
                        } else {
                            $sql = "select i.ID, i.IDCISELPOD,c.FIRMA, i.STAV, i.FOTKA, i.DATUM_ODECTU, i.KOMENTAR from importodectu i 
                              left join ciselpod c on i.IDCISELPOD = c.IDCISELPOD where i.IDCISELPOD= :idciselpod order by i.DATUM_ODECTU desc";
                        }

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
                                    <td>' . $radek["FIRMA"] . '</td>
                                    <td>' . $radek["STAV"] . '</td>   
                                    <td>' . date("d.m.Y", strtotime($radek["DATUM_ODECTU"])) . '</td>';
                            if ($foto=="Ano") {

                                ?>


<td><a href="#" target="_blank" onClick='zobrazNaNovemPanelu(this)'> <?php echo'<img id="choicedPhoto" width="100" height="100" src="data:image/jpg;base64,'.base64_encode($radek['FOTKA']).'"></a></td> ';
                            }
                            else {
                                echo '<td >' . $foto . '</td>'; ?>
                                <?php }
                        echo '
                                    <td>' . $radek["KOMENTAR"] . '</td>   
                                    <td><a style="color:blue;" href="index.php?page=edit_odecty&id_zapsat=' . $radek["ID"] . '">Zapsat</a></td>                                          
                                    <td><a style="color:blue;" href="index.php?page=import&id_upravit=' . $radek["ID"]. '">Upravit</a></td>                                                        
                                    <td><a style="color:blue;" href="index.php?page=import&id_smazat=' . $radek["ID"] . '">Smazat</a></td>       
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