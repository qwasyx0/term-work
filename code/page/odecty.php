    <?php
    echo '<main>';
    if ($authService->hasIdentity()) :
    $sql = "select role, idciselpod from uzivatele where email=:email;";
    $q = $pdo->prepare($sql);
    $identity = $authService->getIdentity();
    $q->bindValue(":email", $_SESSION['email']);
    $q->execute();
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $_SESSION['role'] = $row["role"];
    $_SESSION['idciselpod'] = $row['idciselpod'];
    ?>
    <form method="post" action="#">
        <label for="select_odecty">Vyberte:</label>
        <select name="select_odecty" id="select_odecty">
            <option value="odbernamista">Odběrná místa</option>
            <option value="odecty">Odečty vodoměru</option>
            <option value="vodomer">Vodoměr</option>
            <option value="pohyby">Pohyby vodoměru</option>
        </select>
        <script type="text/javascript">
            document.getElementById('select_odecty').value = "<?php echo $_POST['select_odecty'];?>";
        </script>

        <input type="Submit" name="submit" value="Potvrdit">
        <br>
        <br>
    </form>
    <?php if (isset($_POST['select_odecty'])) { ?>
    <div class="formular">
<!--        <script src=https://www.daniweb.com/programming/web-development/threads/127658/collapse-expand-table-row"></script> > -->
        <!-- ZKUSIT TOTO: http://www.jeasyui.com/tutorial/datagrid/datagrid21.php -->
        <script type="text/javascript">
            window.onload = function() {
                var table = document.getElementById('expandable_table');
                if (table) {
                    var trs = table.getElementsByTagName('tr');
                    for(var i = 0; i < trs.length; i++) {
                        var a = trs[i].getElementsByTagName('td')[0].getElementsByTagName('a')[0];
                        a.onclick = function() {
                            var expand = this.parentNode.getElementsByClassName("intro")[0];
                            expand.style.display = expand.style.display == 'none' ? 'block' : 'none';
                            this.childNodes.nodeValue = expand.style.display == 'none' ? 'Více' : 'Méně';
                        };
                    }
                }
            };
        </script>
                <?php
                switch ($_POST['select_odecty']) {
                    case "odbernamista":
                        ?>

                        <?php
                        $sql = "select * from VIEWODBERNAMISTA where IDCISELPOD= :idciselpod";
                        $q = $pdo->prepare($sql);
                        $q->bindValue(":idciselpod", $_SESSION['idciselpod']);
                        $q->execute();
                        while ($radek = $q->fetch(PDO::FETCH_ASSOC)) { ?>
                            <table>
                            <div>
                            <?php
                            echo '
                    <tr>
                        <td><label for="ODBERMISTO">Odběrné místo: </label></td><td>' . $radek["ODBERMISTO"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="OBEC">Obec: </label></td><td>' . $radek["OBEC"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="ULICE_ODBERNAMISTA">Ulice: </label></td><td>' . $radek["ULICE_ODBERNAMISTA"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="CP_CE">Číslo popisné / evidenční: </label></td><td>' . $radek["CP_CE"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="CISLODOMU">Číslo domu: </label></td><td>' . $radek["CISLODOMU"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="PARCELA">Parcela: </label></td><td>' . $radek["PARCELA"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="FIRMA">Firma: </label></td><td>' . $radek["FIRMA"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="ULICE_CISELPOD">Ulice: </label></td><td>' . $radek["ULICE_CISELPOD"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="PSC">PSČ: </label></td><td>' . $radek["PSC"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="MESTO">Město: </label></td><td>' . $radek["MESTO"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="CISLO_VODOMERU">Číslo vodoměru: </label></td><td>' . $radek["CISLO_VODOMERU"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="DATUM_MONTAZ">Datum montáže vodoměru: </label></td><td>' . $radek["DATUM_MONTAZ"] . '</td>
                    </tr>
                    <tr>
                        <td><label for="DRUH_VODOMERU">Druh vodoměru: </label></td><td>' . $radek["DRUH_VODOMERU"] . '</td>
                    </tr>
                        
                     <?php
                     echo ';
                            } ?>
                            </div>
                            </table>
                            <?php
                            break;
                        case "odecty":
                            $sql = "select * from VIEWODECTY where idciselpod= :idciselpod";
                            $q = $pdo->prepare($sql);
                            $q->bindValue(":idciselpod", $_SESSION['idciselpod']);
                            $q->execute();
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) { ?>
                                <table>
                                <div>
                                <?php
                                echo '
        
                    <table id="expandable_table">
                    <tr><td><label for="CASTKA_VCETNE_DPH">Částka včetně DPH: </label>' . $radek["CASTKA_VCETNE_DPH"] . '<label for="NOVY_STAV">Nový stav: </label>' . $radek["NOVY_STAV"] . '
                    <a href="#">Více</a>
                    <span class="intro" style="display:none;">
                    <label for="ODBERMISTO">Odběrné místo: </label>' . $radek["ODBERMISTO"] . '<br/>
                    <label for="OBEC">Obec: </label>' . $radek["OBEC"] . '<br/>
                    <label for="ULICE_ODBERNAMISTA">Ulice: </label>' .  $radek["ULICE_ODBERNAMISTA"] . '</br/>
                    <label for="CP_CE">Číslo popisné / evidenční: </label>' . $radek["CP_CE"] . '</br/>
                    
                    </span>           
                    </p></tr>
                </table>
                        <tr>
                            <td><label for="OBDOBI_OD">Období od: </label></td><td>' . $radek["OBDOBI_OD"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="OBDOBI_DO">Období do: </label></td><td>' . $radek["OBDOBI_DO"] . '</td>
                        </tr>
                        <tr>
                                <td><label for="NOVY_STAV">Nový stav: </label></td><td>' . $radek["NOVY_STAV"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="PREDCHOZI_STAV">Předochozí stav: </label></td><td>' . $radek["PREDCHOZI_STAV"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="CASTKA_BEZ_DPH">Částka bez DPH: </label></td><td>' . $radek["CASTKA_BEZ_DPH"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="CASTKA_VCETNE_DPH">Částka včetně DPH: </label></td><td>' . $radek["CASTKA_VCETNE_DPH"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="CISLO_VODOMERU">Číslo vodoěru: </label></td><td>' . $radek["CISLO_VODOMERU"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="ROK_PRISTI_REVIZE">Rok příští revize: </label></td><td>' . $radek["ROK_PRISTI_REVIZE"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="DRUH_VODOMERU">Druh vodoměru: </label></td><td>' . $radek["DRUH_VODOMERU"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="FIRMA">Firma: </label></td><td>' . $radek["FIRMA"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="ULICE_CISELPOD">Ulice sídlo: </label></td><td>' . $radek["ULICE_CISELPOD"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="PSC">PSČ: </label></td><td>' . $radek["PSC"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="MESTO">Město: </label></td><td>' . $radek["MESTO"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="ODBERMISTO">Odběrné místo: </label></td><td>' . $radek["ODBERMISTO"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="TYP_SAZBY">Typ sazby: </label></td><td>' . $radek["TYP_SAZBY"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="OBEC">Obec: </label></td><td>' . $radek["OBEC"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="ULICE_ODBERNAMISTA">Ulice odběrné místo: </label></td><td>' . $radek["ULICE_ODBERNAMISTA"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="CP_CE">Číslo popisné / evidenční: </label></td><td>' . $radek["CP_CE"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="CISLODOMU">Číslo domu: </label></td><td>' . $radek["CISLODOMU"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="PARCELA">Parcela: </label></td><td>' . $radek["PARCELA"] . '</td>
                        </tr>
                        
                     <?php
                     echo ';
                            } ?>
                            </div>
                            </table>
                            <?php
                            break;
                        case "pohyby":
                            $sql = "select * from VIEWPOHYBY where idciselpod= :idciselpod";
                            $q = $pdo->prepare($sql);
                            $q->bindValue(":idciselpod", $_SESSION['idciselpod']);
                            $q->execute();
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) { ?>

                                <table>
                                <div>
                                <?php

                                echo '
                        <tr>
                            <td><label for="DATUM_POHYBU">Datum pohybu: </label></td><td>' . $radek["DATUM_POHYBU"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="DRUH_POHYBU">Druh pohybu: </label></td><td>' . $radek["DRUH_POHYBU"] . '</td>
                        </tr>
                        <tr>
                                <td><label for="POPIS_POHYBU">Popis pohybu: </label></td><td>' . $radek["POPIS_POHYBU"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="CISLO_VODOMERU">Číslo vodoměru: </label></td><td>' . $radek["CISLO_VODOMERU"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="DRUH_VODOMERU">Druh vodoměru: </label></td><td>' . $radek["DRUH_VODOMERU"] . '</td>
                        </tr>
                       
                     <?php
                     echo ';
                            } ?>
                            </div>
                            </table>
                            <?php
                            break;
                        case "vodomer":
                            $sql = "select * from VIEWVODOMERY where idciselpod= :idciselpod";
                            $q = $pdo->prepare($sql);
                            $q->bindValue(":idciselpod", $_SESSION['idciselpod']);
                            $q->execute();
                            while ($radek = $q->fetch(PDO::FETCH_ASSOC)) { ?>

                                <table>
                                <div>
                                <?php

                                echo '
                        <tr>
                            <td><label for="CISLO_VODOMERU">Číslo vodoěru: </label></td><td>' . $radek["CISLO_VODOMERU"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="ROK_PRISTI_REVIZE">Rok příští revize: </label></td><td>' . $radek["ROK_PRISTI_REVIZE"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="DATUM_MONTAZ">Datum montáže vodoměru: </label></td><td>' . $radek["DATUM_MONTAZ"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="DRUH_VODOMERU">Druh vodoměru: </label></td><td>' . $radek["DRUH_VODOMERU"] . '</td>
                        </tr>
                        
                        <tr>
                            <td><label for="ODBERMISTO">Odběrné místo: </label></td><td>' . $radek["ODBERMISTO"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="OBEC">Obec: </label></td><td>' . $radek["OBEC"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="ULICE_ODBERNAMISTA">Ulice odběrné místo: </label></td><td>' . $radek["ULICE_ODBERNAMISTA"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="CP_CE">Číslo popisné / evidenční: </label></td><td>' . $radek["CP_CE"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="CISLODOMU">Číslo domu: </label></td><td>' . $radek["CISLODOMU"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="PARCELA">Parcela: </label></td><td>' . $radek["PARCELA"] . '</td>
                        </tr>
                       <tr>
                            <td><label for="FIRMA">Firma: </label></td><td>' . $radek["FIRMA"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="ULICE_CISELPOD">Ulice sídlo: </label></td><td>' . $radek["ULICE_CISELPOD"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="PSC">PSČ: </label></td><td>' . $radek["PSC"] . '</td>
                        </tr>
                        <tr>
                            <td><label for="MESTO">Město: </label></td><td>' . $radek["MESTO"] . '</td>
                        </tr>
                     <?php
                     echo ';
                            } ?>
                            </div>
                            </table>
                            <?php
                            break;
                    }
            }
            ?>

    </div>
</main>
<?php else  : ?>
    <section id="asdf">
        <h2>Pro zobrazení historie odečtů musíte být přihlášeni.</h2>
        <a href="<?= BASE_URL ?>">Návrat na úvodní stránku</a>
    </section>
<?php endif; ?>
