<?php
if ($authService->hasIdentity()) : ?>
    <div class="flex-wrap">
        <section>
            <h4>Kontakt</h4>
            <address>Softbit software s.r.o.<br>
                Nad Dubinkou 1634<br>
                516 01 Rychnov nad Kněžnou<br><br>
                Tel: +420 777 666 555<br>
                Email: <a href="mailto:softbit@softbit.cz">
                    sotfbit@softbit.cz</a><br>
            </address>
        </section>
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
        <section>
            <h4>Kontaktujte nás</h4>

            <?php
            if ($hlaska)
                echo('<p>' . htmlspecialchars($hlaska) . '</p>');
            $jmeno = (isset($_POST['jmeno'])) ? $_POST['jmeno'] : '';
            $email = (isset($_POST['email'])) ? $_POST['email'] : '';
            $zprava = (isset($_POST['zprava'])) ? $_POST['zprava'] : '';
            ?>

            <form method="POST">
                <table>
                    <tr>
                        <td>Vaše jméno</td>
                        <td><input name="jmeno" type="text" value="<?= htmlspecialchars($jmeno) ?>"/></td>
                    </tr>
                    <tr>
                        <td>Váš email</td>
                        <td><input name="email" type="email" value="<?= htmlspecialchars($email) ?>"/></td>
                    </tr>
                    <tr>
                        <td>Aktuální rok (antispam)</td>
                        <td><input name="rok" type="number"/></td>
                    </tr>
                </table>
                <textarea id="zprava" name="zprava"><?= htmlspecialchars($zprava) ?></textarea>
                <br/>

                <input type="submit" value="Odeslat"/>
            </form>
        </section>
    </div>

<?php else  : ?>
    <section id="asdf">
        <h2>Pro zobrazení kontaktní stránky musíte být přihlášeni.</h2>
        <a href="<?= BASE_URL ?>">Návrat na úvodní stránku</a>
    </section>
<?php endif; ?>