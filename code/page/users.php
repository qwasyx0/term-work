 <script language='javascript' type='text/javascript'>
     function check(input) {
         if (input.value != document.getElementById('password').value) {
             input.setCustomValidity('Hesla se musejí shodovat.');
         } else {
             // input is valid -- reset the error message
             input.setCustomValidity('');
         }
     }

 </script>

 <?php
 $host = 'localhost';
 $user= 'root';
 $pass ='';
 $name='iwww';
 $pdo = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
 ?>
 <main>
     <?php

     if(isset($_GET['id_smazat'])){
         $id = $_GET['id_smazat'];

         $sql2 = "delete from uzivatele where email = :id";
         $q2 = $pdo->prepare($sql2);
         $q2->bindValue(":id", $id);

         $q2->execute();

     }

     if(isset($_GET['id_upravit'])){
         echo   '<h2>Upravit uživatele</h2>'
             . '<br> <a style="color:blue;" href="index.php?page=users">Zpět na přidání uživatele.</a><br><br>';

     }else{
         echo   '<h2>Přidat nového uživatele</h2>';
     }
     ?>



     <div class="formular">

         <?php

         if(isset($_POST['pridani'])||isset($_POST['upravit'])){
            //join z jine tabulky
       /*      $role = 1;
             $sql = 'select role from uzivatele where nazev = :nazev';
             $q = $pdo->prepare($sql);
             $q->bindValue(":role", $_POST['role']);
             $q->execute();
             while ($radek = $q->fetch(PDO::FETCH_ASSOC)){
                 $role =  $radek["role"];
             }
*/
             $sha_password = hash('sha512', $_POST['password']);
             if(isset($_POST['upravit'])){
                                                        //upravím email takze updatuju novy - neni nalezen a nemam podminku asi?
                 $sql2 = "update uzivatele set email= :email, password= :password, role= :role where email = :email";
                 $q2 = $pdo->prepare($sql2);
                 $q2->bindValue(":email", $_POST['loginMail']);
                 $q2->bindValue(":password", $sha_password);
                 $q2->bindValue(":role", $_POST['role']);
                 $q2->execute();
                 echo 'Úprava proběhla úspěšně.';
             }else{
                 $sql = "INSERT INTO uzivatele (email, password, role) values (:email, :password, :role);";
                 $q2 = $pdo->prepare($sql);
                 $q2->bindValue(":email", $_POST['loginMail']);
                 $q2->bindValue(":password", $sha_password);
                $q2->bindValue(":role", $_POST['role']);
                 $q2->execute();
                 echo 'Přidání proběhlo úspěšně.';
             }
         }else{

             ?>

             <form  action="#" method="post">
                 <?php

                 ?>
                 <table>
                     <tr>
                         <td><label for="loginMail">Email: </label></td><td><input value="<?php if(isset($_GET["email"])){echo $_GET["email"];} ?>" required type="text" name="loginMail" id="loginMail" ></td>
                     </tr>
                     <tr>
                         <td><label for="password">Heslo: </label></td><td><input  required type="password" name="password" id="password"></td>
                     </tr>
                     <tr>
                         <td><label for="passwordZnova">Heslo znova: </label></td><td><input required type="password"  id="passwordZnova" name="passwordRepeat"  oninput="check(this)"/></td>
                     </tr>
                     <tr>
                         <td><label for="role">Role: </label></td><td><input required type="text"  id="role" name="role"/></td>
                     </tr>
                     <tr>
                         <td></td><td>
                             <?php
                             if(isset($_GET['id_upravit'])){
                                 echo'<input type="submit" value="Upravit" name="upravit" style="width:160px;">';
                             }else{
                                 echo'<input type="submit" value="Přidat" name="pridani" style="width:160px;">';

                             }
                             ?>
                         </td>
                     </tr>
                 </table>

             </form>
             <?php
         }
         echo"<br><br><br><br>";
         ?>

     </div>


     <h2>Uživatelské účty</h2>
     <div class="formular">
         <table><tr>
                 <th>Email</th><th>Role</th><th>Upravit</th><th>Smazat</th>
             </tr>
             <?php
             $sql = 'select email, role from uzivatele;';
             $q = $pdo->prepare($sql);
             $q->execute();
             while ($radek = $q->fetch(PDO::FETCH_ASSOC)){
                 echo'
                <tr>
                    <td>'.$radek["email"].'</td>
                    <td>'.$radek["role"].'</td>                       
                    <td><a style="color:blue;" href="index.php?page=users&id_upravit='.$radek["email"].'&role='.$radek["role"].'">Upravit</a></td>
                                                      
                     <td><a style="color:blue;" href="index.php?page=users&id_smazat='.$radek["email"].'">Smazat</a></td>
                                                   
                </tr> ' ;

             }
             echo '</table>';
             ?>
     </div>

 </main>
