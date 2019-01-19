<?php if ($authService->hasIdentity()) :
        if ($_SESSION['role'] == 1) {
            include './page/editace.php';
            if (isset($_GET['id_smazat'])) {
                try {
                    $idsmazat = $_GET['id_smazat'];
                    $sql2 = "delete from odectyvodomeru where odectyvodomeru.CODECET = :id";
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
                    $sql2 = "select o.ID_VODOMER, v.CISLO_VODOMERU, o.IDCISELPOD, c.FIRMA, o.ID_ODBERMISTO, m.ODBERMISTO, o.ID_VODOMERYPOHYBY,
                            p.ID,  o.OBDOBI_OD, o.OBDOBI_DO, o.NOVY_STAV, o.PREDCHOZI_STAV, o.CASTKA_BEZ_DPH, o.CASTKA_VCETNE_DPH, 
                            o.TYP_SAZBY, s.CENA from odectyvodomeru o 
                            left join sazby s on o.TYP_SAZBY= s.TYP_SAZBY
                            left join vodomery v on o.ID_VODOMER = v.ID 
                            left join ciselpod c on o.IDCISELPOD = c.IDCISELPOD
                            left join odbernamista m on o.ID_ODBERMISTO = m.ID
                            left join vodomerypohyby p on o.ID_VODOMER = p.ID_VODOMERY where o.CODECET = :id";
                    $q2 = $pdo->prepare($sql2);
                    $q2->bindValue(":id", $upravit);
                    $q2->execute();
                    while ($radek = $q2->fetch(PDO::FETCH_ASSOC)) {
                        $idciselpod = $radek['IDCISELPOD'];
                        $firma = $radek['FIRMA'];
                        $id_vodomer = $radek['ID_VODOMER'];
                        $vodomer = $radek['CISLO_VODOMERU'];
                        $id_odbermisto = $radek['ID_ODBERMISTO'];
                        $odbermisto = $radek['ODBERMISTO'];
                        $id_pohyby = $radek['ID'];
                        $obdobi_od = $radek['OBDOBI_OD'];
                        $obdobi_do = $radek['OBDOBI_DO'];
                        $novy_stav = $radek['NOVY_STAV'];
                        $predchozi_stav = $radek['PREDCHOZI_STAV'];
                        $castka_bez_dph = $radek['CASTKA_BEZ_DPH'];
                        $castka_vcetne_dph = $radek['CASTKA_VCETNE_DPH'];
                        $sazba = $radek['TYP_SAZBY'];
                        $cena = $radek['CENA'];
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                echo '<br> <div style="text-align: center;"><a style="color:blue;" href="index.php?page=edit_odecty">Zpět</a><br></div>>';
            }

            if (isset($_GET['id_zapsat'])) {

                $idzapsat = $_GET['id_zapsat'];
                try {
                    $sql2 = "select i.ID, i.IDCISELPOD, c.FIRMA,v.ID AS V_ID, v.CISLO_VODOMERU, o.ID AS O_ID, o.ODBERMISTO, i.DATUM_ODECTU, i.STAV from importodectu i
left join ciselpod c on i.IDCISELPOD = c.IDCISELPOD
left join vodomery v on i.IDCISELPOD = v.IDCISELPOD
left join odbernamista o on i.IDCISELPOD = o.IDCISELPOD
where i.ID = :id";
                    $q2 = $pdo->prepare($sql2);
                    $q2->bindValue(":id", $idzapsat);
                    $q2->execute();
                    while ($radek = $q2->fetch(PDO::FETCH_ASSOC)) {
                        $idciselpodz = $radek['IDCISELPOD'];
                        $firmaz = $radek['FIRMA'];
                        $id_vodomerz = $radek['V_ID'];
                        $vodomerz = $radek['CISLO_VODOMERU'];
                        $id_odbermistoz = $radek['O_ID'];
                        $odbermistoz = $radek['ODBERMISTO'];
                        $stavz = $radek['STAV'];
                        $datumz = $radek['DATUM_ODECTU'];
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }?>


            <main>
                <div class="formular1">
                    <form action="#" method="post">
                        <?php    if (isset($_GET['id_zapsat'])) { ?>

                        <h2>Zapsat importovaný odečet</h2
                        <table>
                            <tr>
                                <td><label for="novy_stav">Importovaný stav</label>
                                <td><input required type="number" name="novy_stav" value="<?php echo $stavz; ?>"></td>
                            </tr>
                            <tr>
                                <td><label for="obdobi_do">Datum odečtu</label>
                                <td><input required type="date" name="obdobi_do" value='<?php echo date($datumz); ?>'>
                            </tr>
                            <?php } else {?>

                        <?php if (!isset($_GET['id_upravit'])) { ?>

                        <h2>Zapsat nový odečet</h2>
                        <table>
                            <tr>
                                <td><label for="novy_stav">Nový stav</label>
                                <td><input required type="number" name="novy_stav" value="<?php echo $novy_stav; ?>"></td>
                            </tr>
                            <tr>
                                <td><label for="obdobi_do">Datum odečtu</label>
                                <td><input required type="date" name="obdobi_do" value='<?php echo date('Y-m-d'); ?>'>
                            </tr>
                            <?php
                            } else { ?>
                            <h2>Upravit odečet</h2>
                            <table>

                                <tr>
                                    <td><label for="novy_stav">Nový stav</label>
                                    <td><input required type="number" name="novy_stav"
                                               value="<?php echo $novy_stav; ?>"></td>
                                </tr>
                                <tr>
                                    <td><label for="obdobi_do">Datum odečtu</label>
                                    <td><input required type="date" name="obdobi_do"
                                               value='<?php echo date($obdobi_do); ?>'>
                                </tr>

                                <?php } }
                                   if (isset($_GET['id_zapsat'])) { ?>
                                       <tr>
                                           <td><label for="select_ciselpod">Firma</label>
                                           <td><input required type="text" name="select_ciselpod"
                                                      value="<?php echo $idciselpodz; ?>"></td>
                                       </tr>
                                       <tr>
                                           <td><label for="select_vodomer">Vodoměr</label>
                                           <td><input required type="text" name="select_vodomer"
                                                      value='<?php echo date($id_vodomerz); ?>'>
                                       </tr>
                                       <tr>
                                           <td><label for="select_odbermisto">Odběrné místo</label>
                                           <td><input required type="text" name="select_odbermisto"
                                                      value='<?php echo date($id_odbermistoz); ?>'>
                                       </tr>



                                 <?php  } else if (!isset($_GET['id_upravit'])) {


                                           try {
                                               $sql = 'select IDCISELPOD, FIRMA from ciselpod';
                                               $q = $pdo->prepare($sql);
                                               $q->execute();
                                           } catch (PDOException $e) {
                                               echo "Error: " . $e->getMessage();
                                           }
                                           echo '<tr>
                        <td><label for="select_ciselpod">Vlastník</label></td>';
                                           echo '<td><select required name="select_ciselpod" >';
                                           while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                               echo '            
               <option  value="' . $radek["IDCISELPOD"] . '">' . $radek["FIRMA"] . '</option>';
                                           }
                                           echo '</select></td></tr>';

                                           try {
                                               $sql = 'select v.ID, v.CISLO_VODOMERU, c.IDCISELPOD, c.FIRMA from vodomery v 
                                        left join ciselpod c on v.IDCISELPOD = c.IDCISELPOD 
                                        where v.IDCISELPOD is not NULL';
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
               <option  value="' . $radek["ID"] . '">' . $radek["CISLO_VODOMERU"] . " (" . $radek["FIRMA"] . ")" . '</option>';
                                           }
                                           echo '</select></td></tr>';
                                           try {
                                               $sql = 'select o.ID, o.ODBERMISTO, c.IDCISELPOD,c.FIRMA from odbernamista o left join ciselpod c on o.IDCISELPOD = c.IDCISELPOD';
                                               $q = $pdo->prepare($sql);
                                               $q->execute();
                                           } catch (PDOException $e) {
                                               echo "Error: " . $e->getMessage();
                                           }
                                           echo '<tr>
                        <td><label for="select_odbermisto">Odběrné místo</label></td>';
                                           echo '<td><select required name="select_odbermisto">';
                                           while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                               echo '            
               <option  value="' . $radek["ID"] . '">' . $radek["ODBERMISTO"] . " (" . $radek["FIRMA"] . ")" . '</option>';
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
                        <td><label for="select_ciselpod">Vlastník</label></td>';
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
                                               $sql = 'select ID, ODBERMISTO from odbernamista';
                                               $q = $pdo->prepare($sql);
                                               $q->execute();
                                           } catch (PDOException $e) {
                                               echo "Error: " . $e->getMessage();
                                           }
                                           echo '<tr>
                        <td><label for="select_odbermisto">Odběrné místo</label></td>';
                                           echo '<td><select required name="select_odbermisto">';
                                           while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                               echo '            
               <option  value="' . $radek["ID"] . '" ' . (($radek["ID"] == $id_odbermisto) ? 'selected="selected"' : "") . '>' . $radek["ODBERMISTO"] . '</option>';
                                           }
                                           echo '</select></td></tr>';
                                       }


                                echo '<tr>
                        <td colspan="2" style="text-align: center">';
                                if (isset($_GET['id_upravit'])) {
                                    echo '<input type="submit" value="Upravit" name="submit_upravit" style="width: 150px">';
                                } else {
                                    echo '<input type="submit" value="Přidat" name="submit_odecty" style="width: 150px">';
                                }
                                echo '</td></tr>';
                                ?>
                            </table>

                    </form>
                </div>
                <br/><br/><br/><br/>

                <?php
                if (isset($_POST['submit_odecty']) || isset($_POST['submit_upravit'])) {

                    try {
                        $sql2 = "select ID from vodomerypohyby where ID_VODOMERY=:id_vodomer";
                        $q = $pdo->prepare($sql2);
                        $q->bindValue(":id_vodomer", $_POST['select_vodomer']);
                        $q->execute();
                        while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                            $id_pohyby_submit = $radek['ID'];

                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }


                    try {
                        $sql = "select o.TYP_SAZBY, s.CENA, v.NOVY_STAV from odbernamista o 
                      left join sazby s on o.TYP_SAZBY = s.TYP_SAZBY
                      left join odectyvodomeru v on o.ID_VODOMER = v.ID_VODOMER where ID=:id";
                        $q = $pdo->prepare($sql);
                        $q->bindValue(":id", $_POST['select_odbermisto']);
                        $q->execute();
                        while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                            $typ_sazby_submit = $radek['TYP_SAZBY'];
                            $kubiku = $_POST['novy_stav'] - $radek['NOVY_STAV'];
                            //cena se vypocitava spatne jak odecitat decimal od sebe?
                            $cena_bez_dph_submit = $kubiku * $radek['CENA'];
                            $dph = 1.15;
                            $cena_vcetne_dph_submit = $cena_bez_dph_submit * $dph;
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }

                    try {
                        $sql = "select NOVY_STAV, OBDOBI_DO from odectyvodomeru where IDCISELPOD =:idciselpod and ID_ODBERMISTO =:id_odbermisto and ID_VODOMER = :id_vodomer  order by OBDOBI_DO desc LIMIT 1";
                        $q = $pdo->prepare($sql);
                        $q->bindValue(":id_odbermisto", $_POST['select_odbermisto']);
                        $q->bindValue(":id_vodomer", $_POST['select_vodomer']);
                        $q->bindValue(":idciselpod", $_POST['select_ciselpod']);
                        $q->execute();
                        while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                            $novy_stary_stav = $radek['NOVY_STAV'];
                            $obdobi = $radek['OBDOBI_DO'];

                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }

                    if (isset($_POST['submit_odecty'])) {
                        try {
                            $sql = "INSERT INTO odectyvodomeru (IDCISELPOD, ID_VODOMER, ID_ODBERMISTO, ID_VODOMERYPOHYBY, TYP_SAZBY, OBDOBI_DO, OBDOBI_OD, NOVY_STAV, PREDCHOZI_STAV ,CASTKA_BEZ_DPH, CASTKA_VCETNE_DPH) 
                                          values (:idciselpod, :id_vodomer, :id_odbermisto, :id_vodomerypohyby, :typ_sazby, :obdobi_do, :obdobi_od, :novy_stav , :predchozi_stav, :castka_bez_dph, :castka_vcetne_dph);";
                            $pdo->query('set names utf-8');
                            $q2 = $pdo->prepare($sql);
                            $q2->bindValue(":idciselpod", $_POST['select_ciselpod']);
                            $q2->bindValue(":id_vodomer", $_POST['select_vodomer']);
                            $q2->bindValue(":id_odbermisto", $_POST['select_odbermisto']);

                                $q2->bindValue(":id_vodomerypohyby", $id_pohyby_submit);



                            $q2->bindValue(":typ_sazby", $typ_sazby_submit);
                            $q2->bindValue(":obdobi_do", $_POST['obdobi_do']);
                            $q2->bindValue(":obdobi_od", $obdobi);
                            $q2->bindValue(":novy_stav", $_POST['novy_stav']);
                            $q2->bindValue(":predchozi_stav", $novy_stary_stav);
                            $q2->bindValue(":castka_bez_dph", $cena_bez_dph_submit);
                            $q2->bindValue(":castka_vcetne_dph", $cena_vcetne_dph_submit);
                            $q2->execute();
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        echo 'Přidání proběhlo úspěšně.';
                    } else {
                        try {
                            $sql = "UPDATE odectyvodomeru SET IDCISELPOD =:idciselpod, ID_VODOMER = :id_vodomer,ID_ODBERMISTO =:id_odbermisto, ID_VODOMERYPOHYBY =:id_vodomerypohyby,
                                                  TYP_SAZBY = :typ_sazby, OBDOBI_DO =:obdobi_do, NOVY_STAV =:novy_stav, CASTKA_BEZ_DPH =:castka_bez_dph, CASTKA_VCETNE_DPH=:castka_vcetne_dph where CODECET =:id";
                            $pdo->query('set names utf-8');
                            $q2 = $pdo->prepare($sql);
                            $q2->bindValue(":idciselpod", $_POST['select_ciselpod']);
                            $q2->bindValue(":id_vodomer", $_POST['select_vodomer']);
                            $q2->bindValue(":id_odbermisto", $_POST['select_odbermisto']);
                            $q2->bindValue(":novy_stav", $_POST['novy_stav']);
                            $q2->bindValue(":obdobi_do", $_POST['obdobi_do']);
                            $q2->bindValue(":id_vodomerypohyby", $id_pohyby_submit);
                            $q2->bindValue(":typ_sazby", $typ_sazby_submit);
                            $q2->bindValue(":castka_bez_dph", $cena_bez_dph_submit);
                            $q2->bindValue(":castka_vcetne_dph", $cena_vcetne_dph_submit);
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

                    <h2>Odečty vodoměru</h2>
                    <div id="divpohyby">

                        <table id="tablecol" cellspacing="0" cellpadding="0">
                            <tr>
                                <th>Odběrné místo</th>
                                <th>Typ sazby</th>
                                <th>Číslo vodoměru</th>
                                <th>Firma</th>
                                <th>Předchozí stav</th>
                                <th>Nový stav</th>
                                <th>Upravit</th>
                                <th>Smazat</th>
                            </tr>
                            <?php
                            try {
                                $sql = "select o.CODECET, o.ID_VODOMER, o.IDCISELPOD, m.ODBERMISTO, c.FIRMA, v.CISLO_VODOMERU, o.NOVY_STAV, o.PREDCHOZI_STAV, m.TYP_SAZBY from odectyvodomeru o 
                            join ciselpod c on o.IDCISELPOD = c.IDCISELPOD
                            JOIN vodomery v on o.ID_VODOMER = v.ID
                            join odbernamista m on o.ID_ODBERMISTO = m.ID order by c.FIRMA asc, o.NOVY_STAV desc";
                                $q = $pdo->prepare($sql);
                                $q->execute();
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                echo '
                <tr>
                    <td>' . $radek["ODBERMISTO"] . '</td>
                    <td>' . $radek['TYP_SAZBY'] . '</td>
                    <td>' . $radek["CISLO_VODOMERU"] . '</td>      
                    <td>' . $radek["FIRMA"] . '</td>  
                    <td>' . $radek["PREDCHOZI_STAV"] . '</td>   
                    <td>' . $radek["NOVY_STAV"] . '</td>                 
                    <td><a style="color:blue;" href="index.php?page=edit_odecty&id_upravit=' . $radek["CODECET"] . '">Upravit</a></td>                                                     
                     <td><a style="color:blue;" href="index.php?page=edit_odecty&id_smazat=' . $radek["CODECET"] . '">Smazat</a></td>                                                  
                </tr> ';
                            }
                            ?>
                        </table>
                    </div>
                </div>

            </main>

        <?php } else {
            echo '<h2>Dostupné pouze pro administrátora.</h2>';
        }
    ?>
<?php else : ?>
    <section id="hero">
        <h2>Pro editaci tabulek musíte být přihlášeni.</h2>
    </section>
<?php endif; ?>