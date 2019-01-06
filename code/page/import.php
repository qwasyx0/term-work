<?php
echo '<main>';
if ($authService->hasIdentity()) :
    ?>
    <h2>Zadejte údaje z vodoměru</h2>
    <div class="formular1">
        <?php
        if (isset($_POST['pridani'])) {
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
        }
        ?>
        <form action="#" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><label for="datum_odectu">Datum odečtu: </label></td>
                    <td><input required type="date" name="datum_odectu" value='<?php echo date('Y-m-d'); ?>'></td>
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
            <img id="miniatura">
            <br/>
            <input type="submit" value="Zapsat odečet" name="pridani" style="width:160px; margin-top:10px;">
        </form>

    </div>
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
    <?php
    echo '</main>';
else  : ?>
    <section id="hero">
        <h2>Pro import odečtu musíte být přihlášeni.</h2>
    </section>
<?php endif; ?>