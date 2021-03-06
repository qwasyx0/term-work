<?php
ob_start();
session_start();
require("../class/Database.php");
require("../page/Serializer.php");
include("../config.php");
$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$sql = "select role, idciselpod from uzivatele where email=:email;";
$q = $pdo->prepare($sql);
$q->bindValue(":email", $_SESSION['email']);
$q->execute();
$row = $q->fetch(PDO::FETCH_ASSOC);
$_SESSION['role'] = $row["role"];
$_SESSION['idciselpod'] = $row['idciselpod'];
if ($_SESSION["role"] == 1) {
    $sql = "select * from VIEWODECTY";
} else {
    $sql = "select * from VIEWODECTY where IDCISELPOD= :idciselpod";
}
$q = $pdo->prepare($sql);
$q->bindValue(":idciselpod", $_SESSION['idciselpod']);
$q->execute();

while ($radek = $q->fetch(PDO::FETCH_ASSOC)) {
    $xml[] = array("cislo_vodomeru" => $radek["CISLO_VODOMERU"], "druh_vodomeru" => $radek["DRUH_VODOMERU"], "predchozi_stav" => $radek["PREDCHOZI_STAV"],
        "novy_stav" => $radek["NOVY_STAV"], "obdobi_od" => $radek["OBDOBI_OD"], "obdobi_do" => $radek["OBDOBI_DO"], "castka_bez_dph" => $radek["CASTKA_BEZ_DPH"],
        "castka_vcetne_dph" => $radek["CASTKA_VCETNE_DPH"], "rok_pristi_revize" => $radek["ROK_PRISTI_REVIZE"], "idciselpod" => $radek["IDCISELPOD"], "firma" => $radek["FIRMA"],
        "ulice_ciselpod" => $radek["ULICE_CISELPOD"], "psc" => $radek["PSC"], "mesto" => $radek["MESTO"], "odbermisto" => $radek["ODBERMISTO"],
        "typ_sazby" => $radek["TYP_SAZBY"], "obec" => $radek["OBEC"], "ulice_odbernamista" => $radek["ULICE_ODBERNAMISTA"], "cp_ce" => $radek["CP_CE"],
        "cislodomu" => $radek["CISLODOMU"], "parcela" => $radek["PARCELA"]);
}
$options = array("addDecl" => true, "defaultTagName" => "odecet", "linebreak" => "", "encoding" => "UTF-8", "rootName" => "odecty");
$serializer = new XML_Serializer($options);
$serializer->serialize($xml);

$name = 'odecty_' . date('Y-m-d') . '_' . $_SESSION['idciselpod'] . '.xml';
$file = $name;

$myfile = fopen($name, "w") or die("Unable to open file!");
$txt = $serializer->getSerializedData();
fwrite($myfile, $txt);
fclose($myfile);

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>
