<?php
echo '<main>';
if ($authService->hasIdentity()) :
    ?>
    <div id="noprint">
        <div class="formular1">
            <form method="post" action="#">
                <label for="select_odecty">Vyberte:</label>
                <select name="select_odecty" id="select_odecty">
                    <option value="odecty">Odečty vodoměru</option>
                    <option value="vodomer">Vodoměr</option>
                    <option value="pohyby">Pohyby vodoměru</option>
                    <option value="odbernamista">Odběrná místa</option>
                </select>
                <script type="text/javascript">
                    document.getElementById('select_odecty').value = "<?php echo $_POST['select_odecty'];?>";
                </script>
                <br/>
                <input type="Submit" name="submit" value="Potvrdit" style="margin-top:20px">
            </form>
            <br>
            <br>
            </form>
        </div>
    </div>
    <div class="formular">
    <?php if (isset($_POST['select_odecty'])) {
    switch ($_POST['select_odecty']) {
        case "odbernamista": ?>
            <h2>Odběrná místa</h2>
            <div style="overflow-x:auto;">
                <table id="tablecol" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Odběrné místo:</th>
                        <th>Obec:</th>
                        <th>Ulice:</th>
                        <th>Číslo popisné / evidenční:</th>
                        <th>Číslo domu:</th>
                        <th>Parcela:</th>
                        <th>Firma:</th>
                        <th>Ulice sídlo:</th>
                        <th>PSČ:</th>
                        <th>Město:</th>
                        <th>Číslo vodoměru:</th>
                        <th>Datum montáže vodoměru:</th>
                        <th>Druh vodoměru:</th>
                    </tr>
                    <?php
                    if ($_SESSION['role'] == 1) {
                        $sql = "select * from VIEWODBERNAMISTA";
                    } else {
                        $sql = "select * from VIEWODBERNAMISTA where IDCISELPOD= :idciselpod";
                    }
                    try {
                        $q = $pdo->prepare($sql);
                        $q->bindValue(":idciselpod", $_SESSION['idciselpod']);
                        $q->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                                <tr>
                                    <td>' . $radek["ODBERMISTO"] . '</td>
                                    <td>' . $radek["OBEC"] . '</td>
                                    <td>' . $radek["ULICE_ODBERNAMISTA"] . '</td>
                                    <td>' . $radek["CP_CE"] . '</td>
                                    <td>' . $radek["CISLODOMU"] . '</td>                                 
                                    <td>' . $radek["PARCELA"] . '</td>                                    
                                    <td>' . $radek["FIRMA"] . '</td>
                                    <td>' . $radek["ULICE_CISELPOD"] . '</td>
                                    <td>' . $radek["PSC"] . '</td>                                    
                                    <td>' . $radek["MESTO"] . '</td>
                                    <td>' . $radek["CISLO_VODOMERU"] . '</td>
                                    <td>' . date("d.m.Y", strtotime($radek["DATUM_MONTAZ"])) . '</td>
                                    <td>' . $radek["DRUH_VODOMERU"] . '</td>
                                </tr> ';
                    } ?>
                </table>
            </div>
            <?php
            break;
        case "odecty": ?>
            <h2>Odečty vodoměru</h2>
            <div style="overflow-x:auto;">
                <table id="tablecol" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Období od:</th>
                        <th>Období do:</th>
                        <th>Nový stav:</th>
                        <th>Předochozí stav:</th>
                        <th>Částka bez DPH:</th>
                        <th>Částka včetně DPH:</th>
                        <th>Číslo vodoměru:</th>
                        <th>Rok příští revize:</th>
                        <th>Druh vodoměru:</th>
                        <th>Firma:</th>
                        <th>Ulice sídlo:</th>
                        <th>PSČ:</th>
                        <th>Město:</th>
                        <th>Odběrné místo:</th>
                        <th>Typ sazby:</th>
                        <th>Obec:</th>
                        <th>Ulice odběrné místo:</th>
                        <th>Číslo popisné / evidenční:</th>
                        <th>Číslo domu:</th>
                        <th>Parcela:</th>
                    </tr>
                    <?php
                    if ($_SESSION['role'] == 1) {
                        $sql = "select * from VIEWODECTY order by NOVY_STAV asc";
                    } else {
                        $sql = "select * from VIEWODECTY where idciselpod= :idciselpod order by NOVY_STAV asc";
                    }
                    try {
                        $q = $pdo->prepare($sql);
                        $q->bindValue(":idciselpod", $_SESSION['idciselpod']);
                        $q->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                                <tr >
                                    <td>' . date("d.m.Y", strtotime($radek["OBDOBI_OD"])) . '</td>
                                    <td>' . date("d.m.Y", strtotime($radek["OBDOBI_DO"])) . '</td>
                                    <td>' . $radek["NOVY_STAV"] . '</td>
                                    <td>' . $radek["PREDCHOZI_STAV"] . '</td>
                                    <td>' . $radek["CASTKA_BEZ_DPH"] . '</td>                                 
                                    <td>' . $radek["CASTKA_VCETNE_DPH"] . '</td>                                    
                                    <td>' . $radek["CISLO_VODOMERU"] . '</td>
                                    <td>' . $radek["ROK_PRISTI_REVIZE"] . '</td>
                                    <td>' . $radek["DRUH_VODOMERU"] . '</td>                                    
                                    <td>' . $radek["FIRMA"] . '</td>
                                    <td>' . $radek["ULICE_CISELPOD"] . '</td>
                                    <td>' . $radek["PSC"] . '</td>
                                    <td>' . $radek["MESTO"] . '</td>
                                    <td>' . $radek["ODBERMISTO"] . '</td>
                                    <td>' . $radek["TYP_SAZBY"] . '</td>
                                    <td>' . $radek["OBEC"] . '</td>
                                    <td>' . $radek["ULICE_ODBERNAMISTA"] . '</td>
                                    <td>' . $radek["CP_CE"] . '</td>
                                    <td>' . $radek["CISLODOMU"] . '</td>
                                    <td>' . $radek["PARCELA"] . '</td>
                                </tr> ';
                    } ?>
                </table>
            </div>
            <a href="<?= BASE_URL . "?page=xml" ?>" style="color:blue;font-size:18px;">Export odečtů do xml</a>
            <?php break;
        case "pohyby": ?>
            <h2>Pohyby vodoměru</h2>
            <div id="divpohyby">
                <table id="tablecol" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Datum pohybu:</th>
                        <th>Druh pohybu:</th>
                        <th>Popis pohybu:</th>
                        <th>Číslo vodoměru:</th>
                        <th>Druh vodoměru:</th>
                    </tr>

                    <?php
                    if ($_SESSION['role'] == 1) {
                        $sql = "select * from VIEWPOHYBY";
                    } else {
                        $sql = "select * from VIEWPOHYBY where idciselpod= :idciselpod";
                    }
                    try {
                        $q = $pdo->prepare($sql);
                        $q->bindValue(":idciselpod", $_SESSION['idciselpod']);
                        $q->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                                <tr>
                                    <td>' . date("d.m.Y", strtotime($radek["DATUM_POHYBU"])) . '</td>
                                    <td>' . $radek["DRUH_POHYBU"] . '</td>
                                    <td>' . $radek["POPIS_POHYBU"] . '</td>
                                    <td>' . $radek["CISLO_VODOMERU"] . '</td>
                                    <td>' . $radek["DRUH_VODOMERU"] . '</td>                                 
                                </tr> ';
                    } ?>
                </table>
            </div>
            <?php break;
        case "vodomer":
            ?>
            <h2>Údaje vodoměru</h2>
            <div style="overflow-x:auto;">
                <table id="tablecol" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Číslo vodoměru:</th>
                        <th>Rok příští revize:</th>
                        <th>Datum montáže vodoměru:</th>
                        <th>Druh vodoměru:</th>
                        <th>Obec:</th>
                        <th>Ulice odběrné místo:</th>
                        <th>Číslo popisné / evidenční:</th>
                        <th>Číslo domu:</th>
                        <th>Parcela:</th>
                        <th>Firma:</th>
                        <th>Ulice sídlo:</th>
                        <th>PSČ:</th>
                        <th>Město:</th>
                    </tr>
                    <?php

                    if ($_SESSION['role'] == 1) {
                        $sql = "select * from VIEWVODOMERY";
                    } else {
                        $sql = "select * from VIEWVODOMERY where idciselpod= :idciselpod";
                    }
                    try {
                        $q = $pdo->prepare($sql);
                        $q->bindValue(":idciselpod", $_SESSION['idciselpod']);
                        $q->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                                <tr>
                                    <td>' . $radek["CISLO_VODOMERU"] . '</td>
                                    <td>' . $radek["ROK_PRISTI_REVIZE"] . '</td>
                                    <td>' . date("d.m.Y", strtotime($radek["DATUM_MONTAZ"])) . '</td>
                                    <td>' . $radek["DRUH_VODOMERU"] . '</td>  
                                    <td>' . $radek["OBEC"] . '</td>
                                    <td>' . $radek["ULICE_ODBERNAMISTA"] . '</td>
                                    <td>' . $radek["CP_CE"] . '</td>
                                    <td>' . $radek["CISLODOMU"] . '</td>
                                    <td>' . $radek["PARCELA"] . '</td> 
                                    <td>' . $radek["FIRMA"] . '</td>
                                    <td>' . $radek["ULICE_CISELPOD"] . '</td>
                                    <td>' . $radek["PSC"] . '</td>  
                                    <td>' . $radek["MESTO"] . '</td>   
                                </tr> ';
                    } ?>
                </table>
            </div>
            <?php break;
    } ?>
    </div>
    <?php
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
