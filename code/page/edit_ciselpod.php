<?php if ($authService->hasIdentity()) :
    include './page/editace.php';
    if (isset($_GET['id_smazat'])) {
        try {
            $idsmazat = $_GET['id_smazat'];
            $sql2 = "delete from ciselpod where ciselpod.IDCISELPOD = :id";
            $q2 = $pdo->prepare($sql2);
            $q2->bindValue(":id", $idsmazat);
            $q2->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    if (isset($_GET['id_upravit'])) {
        $upravit = $_GET['id_upravit'];
        try {
            $sql2 = "select IDCISELPOD, FIRMA, ULICE, PSC, MESTO from ciselpod where IDCISELPOD=:id";
            $q2 = $pdo->prepare($sql2);
            $q2->bindValue(":id", $upravit);
            $q2->execute();
            while ($radek = $q2->fetch(PDO::FETCH_ASSOC)) {
                $firma = $radek['FIRMA'];
                $ulice = $radek['ULICE'];
                $psc = $radek['PSC'];
                $mesto = $radek['MESTO'];
                $_SESSION['upraveny_mail_id'] = $radek['IDCISELPOD'];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo '<br> <div style="text-align: center;"><a style="color:blue;" href="index.php?page=edit_ciselpod">Zpět</a><br></div>';
        try {
            $sql2 = "select IDCISELPOD, EMAIL from uzivatele where IDCISELPOD=:id";
            $q2 = $pdo->prepare($sql2);
            $q2->bindValue(":id", $_SESSION['upraveny_mail_id']);
            $q2->execute();
            while ($radek = $q2->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION['stary_mail'] = $radek['EMAIL'];
            }
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } ?>

    <main>
        <div class="formular1">
            <?php if (!isset($_GET['id_upravit'])) { ?>

            <form action="#" method="post" enctype="multipart/form-data">
                <h2>Přidat novou firmu</h2>
                <table>
                    <tr>
                        <td><label for="firma">Firma</label>
                        <td><input type="text" name="firma"></td>
                    </tr>
                    <tr>
                        <td><label for="ulice">Ulice</label>
                        <td><input type="text" name="ulice"></td>
                    </tr>
                    <tr>
                        <td><label for="psc">PSČ</label>
                        <td><input type="number" name="psc"></td>
                    </tr>
                    <tr>
                        <td><label for="mesto">Město</label>
                        <td><input type="text" name="mesto"></td>
                    </tr>
                    <?php
                    } else { ?>
                    <h2>Upravit firmu</h2>
                    <table>
                        <tr>
                            <td><label for="firma">Firma</label>
                            <td><input type="text" name="firma" value="<?php echo $firma; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="ulice">Ulice</label>
                            <td><input type="text" name="ulice" value="<?php echo $ulice; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="psc">PSČ</label>
                            <td><input type="number" name="psc" value="<?php echo $psc; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="mesto">Město</label>
                            <td><input type="text" name="mesto" value="<?php echo $mesto; ?>"> </td>
                        </tr>
                        <?php }


                        if (!isset($_GET['id_upravit'])) {
                            try {
                                $sql = 'select EMAIL, IDCISELPOD from uzivatele where IDCISELPOD IS NULL';
                                $q = $pdo->prepare($sql);

                                $q->execute();
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            echo '<tr>
                        <td><label for="select_uzivatele">Přiřadit email</label></td>';
                            echo '<td><select name="select_uzivatele">';
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                echo '            
               <option  value="' . $radek["EMAIL"] . '">' . $radek["EMAIL"] . '</option>';
                            }
                            echo '</select></td></tr>';
                            if(isset($_POST['submit_pridat'])) {
                                try {
                                    $sql = "select MAX(IDCISELPOD) as max from ciselpod";
                                    $q = $pdo->prepare($sql);
                                    $q->execute();
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                    while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                    $nejvyssi_id = $radek['max'] +1;

                                        }
                                try {
                                    $sql = "update uzivatele set IDCISELPOD=:idciselpod where EMAIL=:email";
                                    $q = $pdo->prepare($sql);
                                    $q->bindValue(":idciselpod", $nejvyssi_id);
                                    $q->bindValue(":email", $_POST['select_uzivatele']);

                                    //neupdatuje to i kdyz to vypada ze je spravne
                                    echo $nejvyssi_id;
                                    echo $_POST['select_uzivatele'];
                                    $q->execute();
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                            }
                        } else {


                            try {
                                $sql = 'select EMAIL, IDCISELPOD from uzivatele where IDCISELPOD IS NULL';
                                $q = $pdo->prepare($sql);
                                $q->execute();
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            echo '<tr>
                        <td><label for="select_uzivatele">Upravit email</label></td>';
                            echo '<td><select name="select_uzivatele">';
                           echo' <option selected="selected" value="' . $radek["IDCISELPOD"] . '">' .  $_SESSION['stary_mail'] . '</option>';
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                echo '            
               <option  value="' . $radek["IDCISELPOD"] . '">' .  $radek['EMAIL'] . '</option>';
                            }
                            echo '</select></td></tr>';

                                try {
                                    $sql = "update uzivatele set IDCISELPOD=NULL where IDCISELPOD=:idciselpod";
                                    $q = $pdo->prepare($sql);
                                    $q->bindValue(":idciselpod", $_SESSION['upraveny_mail_id']);
                                    $q->execute();
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                            if(isset($_POST['submit_upravitt'])) {
                                try {
                                    $sql = "update uzivatele set IDCISELPOD=:idciselpod where EMAIL=:email";
                                    $q = $pdo->prepare($sql);
                                    $q->bindValue(":idciselpod", $_SESSION['upraveny_mail_id']);
                                    $q->bindValue(":email", $_POST['select_uzivatele']);
                                    $q->execute();
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }

                            }
                        }

                        echo '<tr>
                        <td colspan="2" style="text-align: center">';
                        if (isset($_GET['id_upravit'])) {
                            echo '<input type="submit" value="Upravit" name="submit_upravit" style="width: 150px">';
                        } else {
                            echo '<input type="submit" value="Přidat" name="submit_pridat" style="width: 150px">';
                        }
                        echo '</td></tr>';
                        ?>
                    </table>
                    <br/><br/><br/><br/>
            </form>
        </div>


        <?php
        if (isset($_POST['submit_pridat']) || isset($_POST['submit_upravit'])) {
            if (isset($_POST['submit_pridat'])) {
                try {
                    $sql = "INSERT INTO ciselpod (FIRMA, ULICE, PSC, MESTO) 
                                          values (:firma, :ulice,:psc,:mesto);";
                    $pdo->query('set names utf-8');
                    $q2 = $pdo->prepare($sql);
                    $q2->bindValue(":mesto", $_POST['mesto']);
                    $q2->bindValue(":firma", $_POST['firma']);
                    $q2->bindValue(":ulice", $_POST['ulice']);
                    $q2->bindValue(":psc", $_POST['psc']);
                    $q2->execute();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                echo 'Přidání proběhlo úspěšně.';
            } else {
                try {
                    $sql = "UPDATE ciselpod SET FIRMA=:firma, ULICE=:ulice, PSC=:psc, MESTO=:mesto where IDCISELPOD =:id";
                    $pdo->query('set names utf-8');
                    $q2 = $pdo->prepare($sql);
                    $q2->bindValue(":mesto", $_POST['mesto']);
                    $q2->bindValue(":firma", $_POST['firma']);
                    $q2->bindValue(":ulice", $_POST['ulice']);
                    $q2->bindValue(":psc", $_POST['psc']);
                    $q2->bindValue(":id", $upravit);
                    $q2->execute();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                echo 'Úprava proběhla úspěšně.';
            }
        }
        ?>


        <div class="formular">

            <h2>Číselník firem</h2>
            <div id="divpohyby">

                <table id="tablecol" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Email</th>
                        <th>Firma</th>
                        <th>Ulice</th>
                        <th>PSČ</th>
                        <th>Město</th>
                        <th>Upravit</th>
                        <th>Smazat</th>
                    </tr>
                    <?php
                    try {
                        $sql = "select c.IDCISELPOD, c.FIRMA, c.ULICE, c.PSC, c.MESTO, u.EMAIL from ciselpod c 
                                left join uzivatele u on c.IDCISELPOD = u.IDCISELPOD order by FIRMA asc";
                        $q = $pdo->prepare($sql);
                        $q->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                <tr>
                    <td>' . $radek["EMAIL"] . '</td>
                    <td>' . $radek["FIRMA"] . '</td>
                    <td>' . $radek['ULICE'] . '</td>
                    <td>' . $radek["PSC"] . '</td>
                    <td>' . $radek['MESTO'] . '</td>                 
                    <td><a style="color:blue;" href="index.php?page=edit_ciselpod&id_upravit=' . $radek["IDCISELPOD"] . '">Upravit</a></td>                                                     
                     <td><a style="color:blue;" href="index.php?page=edit_ciselpod&id_smazat=' . $radek["IDCISELPOD"] . '">Smazat</a></td>                                                  
                </tr> ';
                    }
                    ?>
                </table>
            </div>
        </div>

    </main>
<?php else : ?>
    <section id="hero">
        <h2>Pro editaci tabulek musíte být přihlášeni.</h2>
    </section>
<?php endif; ?>