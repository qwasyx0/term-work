<?php if ($authService->hasIdentity()) :
    include './page/editace.php';
    if (isset($_GET['id_smazat'])) {
        try {
            $idsmazat = $_GET['id_smazat'];
            $sql2 = "delete from sazby where sazby.TYP_SAZBY = :id";
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
            $sql2 = "select TYP_SAZBY, CENA, OBDOBI_OD, OBDOBI_DO from sazby where TYP_SAZBY=:id";
            $q2 = $pdo->prepare($sql2);
            $q2->bindValue(":id", $upravit);
            $q2->execute();
            while ($radek = $q2->fetch(PDO::FETCH_ASSOC)) {
                $typ_sazby = $radek['TYP_SAZBY'];
                $cena = $radek['CENA'];
                $obdobi_od = $radek['OBDOBI_OD'];
                $obdobi_do = $radek['OBDOBI_DO'];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo '<br> <div style="text-align: center;"><a style="color:blue;" href="index.php?page=edit_sazby">Zpět</a><br></div>>';
    } ?>

    <main>
        <div class="formular1">
            <?php if (!isset($_GET['id_upravit'])) { ?>

            <form action="#" method="post" enctype="multipart/form-data">
                <h2>Definovat novou sazbu</h2>
                <table>
                    <tr>
                        <td><label for="typ_sazby">Typ sazby</label>
                        <td><input type="number" name="typ_sazby"></td>
                    </tr>
                    <tr>
                        <td><label for="cena">Cena</label>
                        <td><input type="number" name="cena"></td>
                    </tr>
                    <tr>
                        <td><label for="obdobi_od">Období od</label>
                        <td><input required type="date" name="obdobi_od" value='<?php echo date('Y-m-d'); ?>'>
                    </tr>
                    <tr>
                        <td><label for="obdobi_do">Období do</label>
                        <td><input required type="date" name="obdobi_do" value='<?php echo date('Y-m-d'); ?>'>
                    </tr>
                    <?php
                    } else { ?>
                    <h2>Upravit sazbu</h2>
                    <table>
                        <tr>
                            <td><label for="typ_sazby">Typ sazby</label>
                            <td><input type="number" name="typ_sazby" value="<?php echo $typ_sazby; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="cena">Cena</label>
                            <td><input type="number" name="cena" value="<?php echo $cena; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="obdobi_od">Období od</label>
                            <td><input required type="date" name="obdobi_od" value='<?php echo date($obdobi_od); ?>'>
                        </tr>
                        <tr>
                            <td><label for="obdobi_do">Období do</label>
                            <td><input required type="date" name="obdobi_do" value='<?php echo date($obdobi_do); ?>'>
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
                    $sql = "INSERT INTO sazby (TYP_SAZBY, CENA, OBDOBI_OD, OBDOBI_DO) 
                                          values (:typ_sazby, :cena, :obdobi_od, :obdobi_do);";
                    $pdo->query('set names utf-8');
                    $q2 = $pdo->prepare($sql);
                    $q2->bindValue(":typ_sazby", $_POST['typ_sazby']);
                    $q2->bindValue(":cena", $_POST['cena']);
                    $q2->bindValue(":obdobi_od", $_POST['obdobi_od']);
                    $q2->bindValue(":obdobi_do", $_POST['obdobi_do']);
                    $q2->execute();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                echo 'Přidání proběhlo úspěšně.';
            } else {
                try {
                    $sql = "UPDATE sazby SET TYP_SAZBY=:typ_sazby, CENA=:cena, OBDOBI_OD=:obdobi_od, OBDOBI_DO=:obdobi_do where TYP_SAZBY =:id";
                    $pdo->query('set names utf-8');
                    $q2 = $pdo->prepare($sql);
                    $q2->bindValue(":typ_sazby", $_POST['typ_sazby']);
                    $q2->bindValue(":cena", $_POST['cena']);
                    $q2->bindValue(":obdobi_od", $_POST['obdobi_od']);
                    $q2->bindValue(":obdobi_do", $_POST['obdobi_do']);
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

            <h2>Definované sazby</h2>
            <div id="divpohyby">

                <table id="tablecol" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Typ sazby</th>
                        <th>Cena</th>
                        <th>Období od</th>
                        <th>Období do</th>
                        <th>Upravit</th>
                        <th>Smazat</th>
                    </tr>
                    <?php
                    try {
                        $sql = "select TYP_SAZBY, CENA, OBDOBI_OD, OBDOBI_DO from sazby order by TYP_SAZBY asc";
                        $q = $pdo->prepare($sql);
                        $q->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                <tr>
                    <td>' . $radek["TYP_SAZBY"] . '</td>
                    <td>' . $radek['CENA'] . '</td>
                    <td>' . date("d.m.Y", strtotime($radek["OBDOBI_OD"])) . '</td>    
                    <td>' . date("d.m.Y", strtotime($radek["OBDOBI_DO"])) . '</td>                    
                    <td><a style="color:blue;" href="index.php?page=edit_sazby&id_upravit=' . $radek["TYP_SAZBY"] . '">Upravit</a></td>                                                     
                     <td><a style="color:blue;" href="index.php?page=edit_sazby&id_smazat=' . $radek["TYP_SAZBY"] . '">Smazat</a></td>                                                  
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