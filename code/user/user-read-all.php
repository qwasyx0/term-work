<a href="<?= BASE_URL . "?page=users&action=create" ?>">Přidat uživatele</a>

<?php
$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$data = $conn->query("SELECT * FROM users")->fetchAll();
echo '<table style="width:100%" border="1">';

echo '  
  <tr>
    <th>Uživatelské jméno</th>
    <th>Email</th> 
    <th>Heslo</th> 
    <th>Poznámka</th>
    <th>Role</th>
    <th>Akce</th>
  </tr>';

foreach ($data as $row) {

    echo '   
   <tr >
   <td >' . $row["username"] . '</td > 
    <td >' . $row["email"] . '</td >
    <td >' . $row["password"] . '</td > 
    <td >' . $row["description"] . '</td >
    <td> ' . $row["role"]. '</td>
    <td>
        <a href="?page=users&action=update&id='.$row["id"].'">U</a>
        <a href="?page=users&action=delete&id='.$row["id"].'">D</a>
    </td>
  </tr >';

}

echo '</table>';