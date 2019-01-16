<?php if ($authService->hasIdentity()) :
    include './page/editace.php';
    if (isset($_GET['id_smazat'])) {
        try {
            $idsmazat = $_GET['id_smazat'];
            $sql2 = "delete from vodomery where vodomery.ID = :id";
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
            $sql2 = "select v.ID_ODBERMISTO, v.IDCISELPOD, v.CISLO_VODOMERU, v.ROK_PRISTI_REVIZE, v.DATUM_MONTAZ, v.DRUH_VODOMERU from vodomery v
                            left join odbernamista o on v.ID_ODBERMISTO = o.ID
                            where v.ID = :id";
            $q2 = $pdo->prepare($sql2);
            $q2->bindValue(":id", $upravit);
            $q2->execute();
            while ($radek = $q2->fetch(PDO::FETCH_ASSOC)) {
                $idciselpod = $radek['IDCISELPOD'];
                $cislo_vodomeru = $radek['CISLO_VODOMERU'];
                $id_odbermisto = $radek['ID_ODBERMISTO'];
                $druh_vodomeru = $radek['DRUH_VODOMERU'];
                $rok_pristi_revize = $radek['ROK_PRISTI_REVIZE'];
                $datum_montaz = $radek['DATUM_MONTAZ'];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo '<br> <div style="text-align: center;"><a style="color:blue;" href="index.php?page=edit_vodomery">Zpět</a><br></div>>';
    } ?>


    <main>
        <div class="formular1">
            <form action="#" method="post">
            <?php if (!isset($_GET['id_upravit'])) { ?>


                <h2>Přidat vodoměr</h2>
                <table>
                    <tr>
                        <td><label for="cislo_vodomeru">Číslo vodoměru</label>
                        <td><input required type="number" name="cislo_vodomeru"></td>
                    </tr>
                    <tr>
                        <td><label for="druh_vodomeru">Druh vodoměru</label>
                        <td><input required type="text" name="druh_vodomeru"></td>
                    </tr>
                    <tr>
                        <td><label for="rok_pristi_revize">Rok příští revize</label>
                        <td><input required type="text" name="rok_pristi_revize"></td>
                    </tr>
                    <tr>
                        <td><label for="datum_montaz">Namontován</label>
                        <td><input required type="date" name="datum_montaz" value='<?php echo date('Y-m-d'); ?>'>
                    </tr>
                    <?php
                    } else { ?>
                    <h2>Upravit vodoměr</h2>
                    <table>
                        <tr>
                            <td><label for="cislo_vodomeru">Číslo vodoměru</label>
                            <td><input required type="number" name="cislo_vodomeru"value="<?php echo $cislo_vodomeru; ?>"</td>
                        </tr>
                        <tr>
                            <td><label for="druh_vodomeru">Druh vodoměru</label>
                            <td><input required type="text" name="druh_vodomeru"value="<?php echo $druh_vodomeru; ?>"</td>
                        </tr>
                        <tr>
                            <td><label for="rok_pristi_revize">Rok příští revize</label>
                            <td><input required type="text" name="rok_pristi_revize"value="<?php echo $rok_pristi_revize; ?>"</td>
                        </tr>
                        <tr>
                            <td><label for="datum_montaz">Namontován</label>
                            <td><input required type="date" name="datum_montaz" value='<?php echo date($datum_montaz); ?>'>
                        </tr>
                        <?php }
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
                    $sql = "INSERT INTO vodomery (CISLO_VODOMERU, ROK_PRISTI_REVIZE, DATUM_MONTAZ, DRUH_VODOMERU) 
                                          values (:cislo_vodomeru, :rok_pristi_revize, :datum_montaz, :druh_vodomeru);";
                    $pdo->query('set names utf-8');
                    $q2 = $pdo->prepare($sql);
                    $q2->bindValue(":cislo_vodomeru", $_POST['cislo_vodomeru']);
                    $q2->bindValue(":rok_pristi_revize", $_POST['rok_pristi_revize']);
                    $q2->bindValue(":datum_montaz", $_POST['datum_montaz']);
                    $q2->bindValue(":druh_vodomeru", $_POST['druh_vodomeru']);
                    $q2->execute();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                echo 'Přidání proběhlo úspěšně.';
            } else {
                try {
                    $sql = "UPDATE vodomery SET CISLO_VODOMERU=:cislo_vodomeru, ROK_PRISTI_REVIZE=:rok_pristi_revize, DATUM_MONTAZ=:datum_montaz, DRUH_VODOMERU=:druh_vodomeru where ID =:id";
                    $pdo->query('set names utf-8');
                    $q2 = $pdo->prepare($sql);
                    $q2->bindValue(":cislo_vodomeru", $_POST['cislo_vodomeru']);
                    $q2->bindValue(":rok_pristi_revize", $_POST['rok_pristi_revize']);
                    $q2->bindValue(":datum_montaz", $_POST['datum_montaz']);
                    $q2->bindValue(":druh_vodomeru", $_POST['druh_vodomeru']);
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

            <h2>Seznam vodoměrů</h2>
            <div id="divpohyby">

                <table id="tablecol" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Číslo vodoměru</th>
                        <th>Druh vodoměru</th>
                        <th>Datum montáže</th>
                        <th>Rok příští revize</th>
                        <th>Přiřazen</th>
                        <th>Upravit</th>
                        <th>Smazat</th>
                    </tr>
                    <?php
                    try {
                        $sql = "select v.ID, v.ID_ODBERMISTO, v.IDCISELPOD, v.CISLO_VODOMERU, v.ROK_PRISTI_REVIZE, v.DATUM_MONTAZ, v.DRUH_VODOMERU from vodomery v order by v.CISLO_VODOMERU desc";
                        $q = $pdo->prepare($sql);
                        $q->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                        if (($radek["IDCISELPOD"] || $radek["ID_ODBERMISTO"]) == NULL) {
                            $prirazen = "Ne";
                        } else {
                            $prirazen = "Ano";
                        }
                        echo '
                <tr>
                    <td>' . $radek["CISLO_VODOMERU"] . '</td>
                    <td>' . $radek['DRUH_VODOMERU'] . '</td>
                    <td>' . date("d.m.Y", strtotime($radek["DATUM_MONTAZ"])) . '</td>      
                    <td>' . $radek["ROK_PRISTI_REVIZE"] . '</td>  
                    <td>' . $prirazen . '</td>                   
                    <td><a style="color:blue;" href="index.php?page=edit_vodomery&id_upravit=' . $radek["ID"] . '">Upravit</a></td>                                                     
                     <td><a style="color:blue;" href="index.php?page=edit_vodomery&id_smazat=' . $radek["ID"] . '">Smazat</a></td>                                                  
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