<?php if ($authService->hasIdentity()) :
    if ($_SESSION['role'] == 1) {
    include './page/editace.php';
    if (isset($_GET['id_smazat'])) {
        try {

            $idsmazat = $_GET['id_smazat'];
            $sql2 = "delete from odbernamista where ID = :id";
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
            $sql2 = "select o.IDCISELPOD, o.ID_VODOMER, o.ODBERMISTO, o.OBEC, o.ULICE, o.CP_CE,o.CISLODOMU,o.PARCELA, c.FIRMA, v.CISLO_VODOMERU , o.TYP_SAZBY, s.CENA from odbernamista o 
                        join ciselpod c on o.IDCISELPOD = c.IDCISELPOD join vodomery v on o.ID_VODOMER = v.ID  join sazby s on o.TYP_SAZBY = s.TYP_SAZBY where o.ID = :id";
            $q2 = $pdo->prepare($sql2);
            $q2->bindValue(":id", $upravit);
            $q2->execute();
            while ($radek = $q2->fetch(PDO::FETCH_ASSOC)) {
                $idciselpod = $radek['IDCISELPOD'];
                $obec = $radek['OBEC'];
                $odbermisto = $radek['ODBERMISTO'];
                $ulice = $radek['ULICE'];
                $cp_ce = $radek['CP_CE'];
                $cislodomu = $radek['CISLODOMU'];
                $parcela = $radek['PARCELA'];
                $firma = $radek['FIRMA'];
                $vodomer = $radek['CISLO_VODOMERU'];
                $id_vodomer = $radek['ID_VODOMER'];
                $sazba = $radek['TYP_SAZBY'];
                $cena = $radek['CENA'];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo '<br> <div style="text-align: center;"><a style="color:blue;" href="index.php?page=edit_mista">Zpět</a><br></div>';
    } ?>
    <main>
        <div class="formular1">
            <form action="#" method="post">
            <?php
            if (isset($_POST['submit_mista']) || isset($_POST['submit_upravit'])) {
                if (isset($_POST['submit_mista'])) {
                    try {
                        $sql = "INSERT INTO odbernamista (IDCISELPOD, ID_VODOMER, ODBERMISTO, TYP_SAZBY,OBEC, ULICE, CP_CE,CISLODOMU,PARCELA) values (:idciselpod, :id_vodomer, :odbermisto, :typ_sazby, :obec, :ulice, :cp_ce, :cislodomu, :parcela);";
                        $pdo->query('set names utf-8');
                        $q2 = $pdo->prepare($sql);
                        $q2->bindValue(":idciselpod", $_POST['select_ciselpod']);
                        $q2->bindValue(":id_vodomer", $_POST['select_vodomer']);
                        $q2->bindValue(":odbermisto", $_POST['odbermisto']);
                        $q2->bindValue(":typ_sazby", $_POST['select_sazby']);
                        $q2->bindValue(":obec", $_POST['obec']);
                        $q2->bindValue(":ulice", $_POST['ulice']);
                        $q2->bindValue(":cp_ce", $_POST['cp_ce']);
                        $q2->bindValue(":cislodomu", $_POST['cislodomu']);
                        $q2->bindValue(":parcela", $_POST['parcela']);
                        $q2->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    echo 'Přidání proběhlo úspěšně.';


                } else {


                    try {
                        $sql = "UPDATE odbernamista SET IDCISELPOD =:idciselpod, ID_VODOMER = :id_vodomer,ODBERMISTO=:odbermisto, TYP_SAZBY =:typ_sazby, OBEC =:obec, ULICE = :ulice, CP_CE=:cp_ce, CISLODOMU =:cislodomu, PARCELA =:parcela where ID =:id";
                        $pdo->query('set names utf-8');
                        $q2 = $pdo->prepare($sql);
                        $q2->bindValue(":idciselpod", $_POST['select_ciselpod']);
                        $q2->bindValue(":id_vodomer", $_POST['select_vodomer']);
                        $q2->bindValue(":odbermisto", $_POST['odbermisto']);
                        $q2->bindValue(":typ_sazby", $_POST['select_sazby']);
                        $q2->bindValue(":obec", $_POST['obec']);
                        $q2->bindValue(":ulice", $_POST['ulice']);
                        $q2->bindValue(":cp_ce", $_POST['cp_ce']);
                        $q2->bindValue(":cislodomu", $_POST['cislodomu']);
                        $q2->bindValue(":parcela", $_POST['parcela']);
                        $q2->bindValue(":id", $upravit);
                        $q2->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    echo 'Úprava proběhla úspěšně.';
                }
            }
            ?>
            <?php if (!isset($_GET['id_upravit'])) { ?>


                <h2>Přidat odběrné místo</h2>
                <table>
                    <tr>
                        <td><label for="obec">Obec</label></td>
                        <td><input required type="number" name="obec"></td>
                    </tr>
                    <tr>
                        <td><label for="odbernmisto">Odběrné místo</label>
                        <td><input required type="number" name="odbermisto"></td>
                    </tr>
                    <tr>
                        <td><label for="ulice">Ulice</label>
                        <td><input required type="number" name="ulice"></td>
                    </tr>
                    <tr>
                        <td><label for="cp_ce">CP_CE</label>
                        <td><input required type="text" name="cp_ce"></td>
                    </tr>
                    <tr>
                        <td><label for="cislodomu">Číslo popisné</label>
                        <td><input required type="text" name="cislodomu"></td>
                    </tr>
                    <tr>
                        <td><label for="parcela">Parcela</label>
                        <td><input required type="text" name="parcela"></td>
                    </tr>


                    <?php
                    } else { ?>
                    <h2>Upravit odběrné místo</h2>
                    <table>
                        <tr>
                            <td><label for="obec">Obec</label></td>
                            <td><input required type="number" name="obec" value="<?php echo $obec; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="odbernmisto">Odběrné místo</label></td>
                            <td><input required type="number" name="odbermisto" value="<?php echo $odbermisto; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="ulice">Ulice</label></td>
                            <td><input required type="number" name="ulice" value="<?php echo $ulice; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="cp_ce">CP_CE</label></td>
                            <td><input required type="text" name="cp_ce" value="<?php echo $cp_ce; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="cislodomu">Číslo popisné</label></td>
                            <td><input required type="text" name="cislodomu" value="<?php echo $cislodomu; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="parcela">Parcela</label></td>
                            <td><input required type="text" name="parcela" value="<?php echo $parcela; ?>"></td>
                        </tr>
                        <?php }
                        if (!isset($_GET['id_upravit'])) {



                            try {
                                $sql = 'select IDCISELPOD, FIRMA from ciselpod';
                                $q = $pdo->prepare($sql);
                                $q->execute();
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            echo '<tr>
                        <td><label for="select_ciselpod">Plátce</label></td>';
                            echo '<td><select required name="select_ciselpod">';
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                echo '            
               <option  value="' . $radek["IDCISELPOD"] . '">' . $radek["FIRMA"] . '</option>';
                            }
                            echo '</select></td></tr><br/>';
                            try {
                                $sql = 'select ID, CISLO_VODOMERU from vodomery where IDCISELPOD IS NULL';
                                $q = $pdo->prepare($sql);
                                $q->execute();
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            echo '<tr>
                        <td><label for="select_vodomer">Vodoměr</label></td>';
                            echo '<td><select required name="select_vodomer">';
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                echo '            
               <option  value="' . $radek["ID"] . '">' . $radek["CISLO_VODOMERU"] . '</option>';
                            }
                            echo '</select></td></tr>';
                            try {
                                $sql = 'select TYP_SAZBY, CENA from sazby';
                                $q = $pdo->prepare($sql);
                                $q->execute();
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            echo '<tr>
                        <td><label for="select_sazby">Sazba</label></td>';
                            echo '<td><select required name="select_sazby">';
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                echo '            
               <option  value="' . $radek["TYP_SAZBY"] . '">' . $radek["TYP_SAZBY"] . " (cena: " . $radek["CENA"] . " Kč)" . '</option>';
                            }
                            echo '</select></td></tr>';



                        } else {




                            try {
                                $sql = 'select IDCISELPOD, FIRMA from ciselpod';
                                $q = $pdo->prepare($sql);
                                $q->execute();
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            echo '<tr>
                        <td><label for="select_ciselpod">Plátce</label></td>';
                            echo '<td><select required name="select_ciselpod" >';
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                echo '            
               <option  value="' . $radek["IDCISELPOD"] . '" ' . (($radek["IDCISELPOD"] == $idciselpod) ? 'selected="selected"' : "") . '>' . $radek["FIRMA"] . '</option>';
                            }
                            echo '</select></td></tr>';
                            try {
                                $sql = 'select ID, CISLO_VODOMERU from vodomery';
                                $q = $pdo->prepare($sql);
                                $q->execute();
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }


                            echo '<tr>
                        <td><label for="select_vodomer">Vodoměr</label></td>';
                            echo '<td><select required name="select_vodomer">';
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                echo '            
               <option  value="' . $radek["ID"] . '" ' . (($radek["ID"] == $id_vodomer) ? 'selected="selected"' : "") . '>' . $radek["CISLO_VODOMERU"] . '</option>';
                            }
                            echo '</select></td></tr>';
                            try {
                                $sql = 'select TYP_SAZBY, CENA from sazby';
                                $q = $pdo->prepare($sql);
                                $q->execute();
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            echo '<tr>
                        <td><label for="select_sazby">Sazba</label></td>';
                            echo '<td><select required name="select_sazby">';
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                echo '            
               <option  value="' . $radek["TYP_SAZBY"] . '" ' . (($radek["TYP_SAZBY"] == $sazba) ? 'selected="selected"' : "") . '>' . $radek["TYP_SAZBY"] . " (cena: " . $radek["CENA"] . " Kč)" . '</option>';
                            }
                            echo '</select></td></tr>';
                        }


                        echo'<tr>
                        <td colspan="2" style="text-align: center">';
                        if (isset($_GET['id_upravit'])) {
                            echo '<input type="submit" value="Upravit" name="submit_upravit" style="width: 150px">';
                        } else {
                            echo '<input type="submit" value="Přidat" name="submit_mista" style="width: 150px">';
                        }
                        echo '</td></tr>';
                        ?>
                    </table>
                    <br/><br/><br/><br/>
            </form>
        </div>
        <div class="formular">

            <h2>Odběrná místa</h2>
            <div id="divpohyby">

                <table id="tablecol" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Odběrné místo</th>
                        <th>Číslo vodoměru</th>
                        <th>Firma</th>
                        <th>Upravit</th>
                        <th>Smazat</th>
                    </tr>
                    <?php
                    try {
                        $sql = 'select o.ID, o.ID_VODOMER, o.IDCISELPOD, o.ODBERMISTO, c.FIRMA, v.CISLO_VODOMERU from odbernamista o
                            join ciselpod c on o.IDCISELPOD = c.IDCISELPOD
                             join vodomery v on o.ID_VODOMER = v.ID order by c.FIRMA';
                        $q = $pdo->prepare($sql);
                        $q->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                <tr>
                    <td>' . $radek["ODBERMISTO"] . '</td>
                    <td>' . $radek["CISLO_VODOMERU"] . '</td>      
                    <td>' . $radek["FIRMA"] . '</td>                
                    <td><a style="color:blue;" href="index.php?page=edit_mista&id_upravit=' . $radek["ID"] . '">Upravit</a></td>                                                     
                     <td><a style="color:blue;" href="index.php?page=edit_mista&id_smazat=' . $radek["ID"] . '">Smazat</a></td>                                                  
                </tr> ';
                    }
                    ?>
                </table>
            </div>
        </div>

    </main>

    <?php } else {
    echo '<h2>Dostupné pouze pro administrátora.</h2>';
} ?>
<?php else : ?>
    <section id="hero">
        <h2>Pro editaci tabulek musíte být přihlášeni.</h2>
    </section>
<?php endif; ?>