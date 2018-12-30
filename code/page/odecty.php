<?php
if ($authService->hasIdentity()) :
?>

    <form method ="post" action="#">
    <section id="asdf">

        <select name="select_odecty" id="select_odecty">
            <option value="odbernamista">Odběrná místa</option>
            <option  value="odecty">Odečty vodoměru</option>
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
    <?php  if(isset($_POST['select_odecty'])) {?>
        <form  action="#" method="post">
            <fieldset disabled>
                <?php
                    switch ($_POST['select_odecty']) {
                    case "odbernamista":
                ?>
            <table>
                <tr>
                    <td><label for="password">Heslo: </label></td><td><input  required type="password" name="password" id="password"></td>
                </tr>
                <tr>
                    <td><label for="passwordZnova">Heslo znova: </label></td><td><input required type="password"  id="passwordZnova" name="passwordRepeat"  oninput="check(this)"/></td>
                </tr>

            </table>
                <?php
                     break;
                     case "odecty":
                ?>

               <table>

                   <tr>
                       <td><label for="password">Hesldsafadsfsadfo: </label></td><td><input  required type="password" name="password" id="password"></td>
                   </tr>
                   <tr>
                       <td><label for="passwordZnova">Heslo dsafdasfznova: </label></td><td><input required type="password"  id="passwordZnova" name="passwordRepeat"  oninput="check(this)"/></td>
                   </tr>

               </table>
                    <?php
                        break;
                        case "pohyby":
                    ?>

                   <table>

                       <tr>
                           <td><label for="password">Hesldsafadsfsadfo: </label></td><td><input  required type="password" name="password" id="password"></td>
                       </tr>
                       <tr>
                           <td><label for="passwordZnova">Heslo dsafdasfznova: </label></td><td><input required type="password"  id="passwordZnova" name="passwordRepeat"  oninput="check(this)"/></td>
                       </tr>

                   </table>
                   <?php
                         break;
                          case "vodomer":
                   ?>

                   <table>

                       <tr>
                           <td><label for="password">Hesldsafadsfsadfo: </label></td><td><input  required type="password" name="password" id="password"></td>
                       </tr>
                       <tr>
                           <td><label for="passwordZnova">Heslo dsafdasfznova: </label></td><td><input required type="password"  id="passwordZnova" name="passwordRepeat"  oninput="check(this)"/></td>
                       </tr>

                   </table>

                    <?php
                       break;
                        }}
                    ?>
            </fieldset>
        </form>
    </section>
<?php  else  :?>
    <section id="asdf">
        <h2>Pro zobrazení historie odečtů musíte být přihlášeni.</h2>
        <a href="./index.php">Návrat na úvodní stránku</a>
    </section>
<?php endif; ?>


