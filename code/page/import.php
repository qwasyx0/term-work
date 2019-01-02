    <?php
    echo'<main>';
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
    <h2>Zadejte údaje z vodoměru</h2>
    <div class="formular">
        <?php
        if (isset($_POST['pridani'])) {
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
        ?>
        <form action="#" method="post">
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
            <textarea id="zprava" name="komentar"></textarea>
            <br/>
            <input type="submit" value="Zapsat odečet" name="pridani" style="width:160px;">
        </form>

        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file_img" />
            <input type="submit" name="btn_upload" value="Upload">
        </form>
        <?php
        if(isset($_POST['btn_upload'])) {
            //toto pujde nahoru
            //              https://www.youtube.com/watch?v=aDWgEOhxbOo
            //              https://www.youtube.com/watch?v=gE8FWPcigKQ
            $filetmp = $_FILES["file_img"]["tmp_name"];
            $filename = $_FILES["file_img"]["name"];
            $filetype = $_FILES["file_img"]["name"];
            $filepath = "photo/".filename;

            move_uploaded_file($filetmp,$filepath);
            $sql = "INSERT INTO upload_img (img_name,img_path,img_type) VALUES ('$filename','$filepath','$filetype')";
            $result = mysql_query($sql);
        }
        ?>
    </div>

<?php
    echo '</main>';
    else  : ?>
    <section id="asdf">
        <h2>Pro import odečtu musíte být přihlášeni.</h2>
        <a href="<?= BASE_URL ?>">Návrat na úvodní stránku</a>
    </section>
<?php endif; ?>