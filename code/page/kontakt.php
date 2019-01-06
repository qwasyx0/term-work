<?php
echo'<main>';
if ($authService->hasIdentity()) : ?>
    <div class="full-width-wrapper">
        <?php
        $hlaska = '';
        if (isset($_GET['uspech']))
            $hlaska = 'Email byl úspěšně odeslán.';
        if ($_POST) // V poli _POST něco je, odeslal se formulář
        {
            if (isset($_POST['jmeno']) && $_POST['jmeno'] &&
                isset($_POST['email']) && $_POST['email'] &&
                isset($_POST['zprava']) && $_POST['zprava'] &&
                isset($_POST['rok']) && $_POST['rok'] == date('Y')) {
                $hlavicka = 'From:' . $_POST['email'];
                $hlavicka .= "\nMIME-Version: 1.0\n";
                $hlavicka .= "Content-Type: text/html; charset=\"utf-8\"\n";
                $adresa = 'vas@email.cz';
                $predmet = 'Nová zpráva z mailformu';
                $uspech = mb_send_mail($adresa, $predmet, $_POST['zprava'], $hlavicka);
                if ($uspech) {
                    $hlaska = 'Email byl úspěšně odeslán.';
                    header('Location: footer.php?uspech=ano');
                    exit;
                } else
                    $hlaska = 'Email se nepodařilo odeslat. Zkontrolujte adresu.';
            } else
                $hlaska = 'Formulář není správně vyplněný!';
        }
        ?>
        <section id="kontaktujte">
            <?php
            if ($hlaska)
                echo('<p>' . htmlspecialchars($hlaska) . '</p>');
            $jmeno = (isset($_POST['jmeno'])) ? $_POST['jmeno'] : '';
            $email = (isset($_POST['email'])) ? $_POST['email'] : '';
            $zprava = (isset($_POST['zprava'])) ? $_POST['zprava'] : '';
            ?>

            <form method="POST">
                <div class="formular1">
                    <h2>Kontaktujte nás</h2>
                <table>
                    <tr>
                        <td><label for="jmeno">Vaše jméno: </label></td>
                        <td><input name="jmeno" type="text" value="<?= htmlspecialchars($jmeno) ?>"/></td>
                    </tr>
                    <tr>
                        <td><label for="email">Váš email: </label></td>
                        <td><input name="email" type="email" value="<?= htmlspecialchars($email) ?>"/></td>
                    </tr>
                    <tr>
                        <td><label for="rok">Aktuální rok (antispam): </label></td>
                        <td><input name="rok" type="number"/></td>
                    </tr>
                </table>
                    <td><label for="rok">Zpráva: </label></td>
                    <br/>
                <textarea id="zprava" name="zprava"><?= htmlspecialchars($zprava) ?></textarea>
                <br/>
                <input type="submit" value="Odeslat"/>
                </div>
            </form>
        </section>
    </div>
    <?php    echo '</main>';
else  : ?>
    <section id="hero">
        <h2>Pro zobrazení kontaktní stránky musíte být přihlášeni.</h2>
    </section>
<?php endif; ?>