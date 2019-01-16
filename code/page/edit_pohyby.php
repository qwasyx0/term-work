<?php if ($authService->hasIdentity()) :
    include './page/editace.php';
    if (isset($_GET['id_smazat'])) {
        try {
            $idsmazat = $_GET['id_smazat'];
            $sql2 = "delete from vodomerypohyby where vodomerypohyby.ID = :id";
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
            $sql2 = "select p.ID_VODOMERY,v.CISLO_VODOMERU, p.ID_ODBERMISTO, m.ODBERMISTO, p.DATUM_POHYBU, p.DRUH_POHYBU, p.POPIS_POHYBU from vodomerypohyby p 
                      left join vodomery v on p.ID_VODOMERY = v.ID 
                      left join odbernamista m on p.ID_ODBERMISTO = m.ID 
                      where p.ID=:id";
            $q2 = $pdo->prepare($sql2);
            $q2->bindValue(":id", $upravit);
            $q2->execute();
            while ($radek = $q2->fetch(PDO::FETCH_ASSOC)) {
                $cislo_vodomeru = $radek['CISLO_VODOMERU'];
                $odbermisto = $radek['ODBERMISTO'];
                $datum_pohybu = $radek['DATUM_POHYBU'];
                $druh_pohybu = $radek['DRUH_POHYBU'];
                $popis_pohybu = $radek['POPIS_POHYBU'];
                $id_vodomer = $radek['ID_VODOMERY'];
                $id_odbermista = $radek['ID_ODBERMISTO'];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo '<br> <div style="text-align: center;"><a style="color:blue;" href="index.php?page=edit_pohyby">Zpět</a><br></div>';
    } ?>
    <main>
        <div class="formular1">
            <form action="#" method="post">
            <?php if (!isset($_GET['id_upravit'])) { ?>


                <h2>Zapsat nový pohyb vodoměru</h2>
                <table>
                    <tr>
                        <td><label for="datum_pohybu">Datum pohybu</label></td>
                        <td><input required type="date" name="datum_pohybu" value='<?php echo date('Y-m-d'); ?>'>
                    </tr>
                    <tr>
                        <td><label for="druh_pohybu">Druh pohybu</label>
                        <td><input required type="text" name="druh_pohybu"></td>
                    </tr>
                    <tr>
                        <td><label for="popis_pohybu">Popis pohybu</label>
                        <td><input required type="text" name="popis_pohybu"></td>
                    </tr>


                    <?php
                    } else { ?>
                    <h2>Upravit pohyb vodoměru</h2>

                    <table>
                        <tr>
                            <td><label for="datum_pohybu">Datum pohybu</label></td>
                            <td><input required type="date" name="datum_pohybu" value='<?php echo date($datum_pohybu); ?>'>
                        </tr>
                        <tr>
                            <td><label for="druh_pohybu">Druh pohybu</label>
                            <td><input required type="text" name="druh_pohybu" value="<?php echo $druh_pohybu; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="popis_pohybu">Popis pohybu</label>
                            <td><input required type="text" name="popis_pohybu" value="<?php echo $popis_pohybu; ?>"></td>
                        </tr>
                        <?php }
                        if (!isset($_GET['id_upravit'])) {
                            try {
                                $sql = 'select v.ID, v.CISLO_VODOMERU, c.IDCISELPOD, c.FIRMA from vodomery v left join ciselpod c on v.IDCISELPOD = c.IDCISELPOD where v.IDCISELPOD is not NULL';

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
                        <td><label for="select_mista">Odběrné místo</label></td>';
                            echo '<td><select required name="select_mista">';
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                echo '            
               <option  value="' . $radek["ID"] . '">' . $radek["ODBERMISTO"] . " (" . $radek["FIRMA"] . ")" . '</option>';
                            }

                        } else {


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
                        <td><label for="select_mista">Odběrné místo</label></td>';
                            echo '<td><select required name="select_mista">';
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                                echo '            
               <option  value="' . $radek["ID"] . '" ' . (($radek["ID"] == $id_odbermista) ? 'selected="selected"' : "") . '>' . $radek["ODBERMISTO"] . '</option>';
                            }
                            echo '</select></td></tr>';
                        }


                        echo'<tr>
                        <td colspan="2" style="text-align: center">';
                        if (isset($_GET['id_upravit'])) {
                            echo '<input type="submit" value="Upravit" name="submit_upravit" style="width: 150px">';
                        } else {
                            echo '<input type="submit" value="Přidat" name="submit_pohyby" style="width: 150px">';
                        }
                        echo '</td></tr>';
                        ?>
                    </table>

                    <br/>        <?php
                    if (isset($_POST['submit_pohyby']) || isset($_POST['submit_upravit'])) {
                        if (!isset($_POST['submit_upravit'])) {
                            try {
                                $sql = "INSERT INTO vodomerypohyby (DATUM_POHYBU, DRUH_POHYBU, POPIS_POHYBU, ID_VODOMERY, ID_ODBERMISTO) values (:datum_pohybu, :druh_pohybu, :popis_pohybu, :id_vodomer, :id_odbermisto);";
                                $pdo->query('set names utf-8');
                                $q2 = $pdo->prepare($sql);
                                $q2->bindValue(":datum_pohybu", $_POST['datum_pohybu']);
                                $q2->bindValue(":druh_pohybu", $_POST['druh_pohybu']);
                                $q2->bindValue(":popis_pohybu", $_POST['popis_pohybu']);


                                $q2->bindValue(":id_vodomer", $_POST['select_vodomer']);
                                $q2->bindValue(":id_odbermisto", $_POST['select_mista']);
                                $q2->execute();
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            echo 'Přidání proběhlo úspěšně.';


                        } else {


                            try {
                                $sql = "UPDATE vodomerypohyby SET DATUM_POHYBU=:datum_pohybu, DRUH_POHYBU=:druh_pohybu, POPIS_POHYBU=:popis_pohybu, ID_VODOMERY=:id_vodomer, ID_ODBERMISTO=:id_odbermisto where ID =:id";
                                $pdo->query('set names utf-8');
                                $q2 = $pdo->prepare($sql);
                                $q2->bindValue(":datum_pohybu", $_POST['datum_pohybu']);
                                $q2->bindValue(":druh_pohybu", $_POST['druh_pohybu']);
                                $q2->bindValue(":popis_pohybu", $_POST['popis_pohybu']);
                                $q2->bindValue(":id", $upravit);


                                $q2->bindValue(":id_vodomer", $_POST['select_vodomer']);
                                $q2->bindValue(":id_odbermisto", $_POST['select_mista']);
                                $q2->execute();
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            echo 'Úprava proběhla úspěšně.';
                        }
                    }
                    ?><br/><br/><br/>
            </form>
        </div>


        <div class="formular">

            <h2>Odběrná místa</h2>
            <div id="divpohyby">

                <table id="tablecol" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Vodoměr</th>
                        <th>Odběrné místo</th>
                        <th>Datum pohybu</th>
                        <th>Druh pohybu</th>
                        <th>Popis pohybu</th>
                        <th>Upravit</th>
                        <th>Smazat</th>
                    </tr>
                    <?php
                    try {
                        $sql = "select p.ID, p.ID_VODOMERY, v.CISLO_VODOMERU, p.ID_ODBERMISTO, m.ODBERMISTO, p.DATUM_POHYBU, p.DRUH_POHYBU, p.POPIS_POHYBU from vodomerypohyby p 
                              left join vodomery v on p.ID_VODOMERY = v.ID
                              left join odbernamista m on p.ID_ODBERMISTO = m.ID
                              order by p.DATUM_POHYBU desc, p.ID_VODOMERY desc";
                        $q = $pdo->prepare($sql);
                        $q->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                <tr>
                    <td>' . $radek["CISLO_VODOMERU"] . '</td>
                    <td>' . $radek["ODBERMISTO"] . '</td>      
                    <td>' . $radek["DATUM_POHYBU"] . '</td>       
                    <td>' . $radek["DRUH_POHYBU"] . '</td>      
                    <td>' . $radek["POPIS_POHYBU"] . '</td>           
                    <td><a style="color:blue;" href="index.php?page=edit_pohyby&id_upravit=' . $radek["ID"] . '">Upravit</a></td>                                                     
                     <td><a style="color:blue;" href="index.php?page=edit_pohyby&id_smazat=' . $radek["ID"] . '">Smazat</a></td>                                                  
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