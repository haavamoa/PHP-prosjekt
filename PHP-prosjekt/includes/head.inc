<?php
//Bruker session på alle sider for feilhåndteringer
session_start();
include_once('ProblemDomenet/Database.php');
$db = new Database();
$array = $db->getFag(); //Tabell over alle fag, enten om du er inne som lærer eller elev/bruker
?>

<head>
    <link rel="stylesheet" href="css/style.css"/>
    <meta charset="UTF-8">
    <!-- IMPORTERE JQUERY og tilhørende script fra /js -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="js/fagForm.js"></script>
</head>

<?php
/* Dette er en feilhåndtering fra endre passord, beskrivelsene står i funksjonen i Database.php.
 * Det blir brukt GET for å håndtere feilmeldinger
 */
//Hvis du har endret passordet
if ($_SESSION['feilSjekk'] === "PassordOk") {
    echo "<script>alert(\"Passordet er endret!\")</script>";
     unset($_SESSION['feilSjekk']);
    
}
//Hvis passordene ikke er like
if ($_SESSION['feilSjekk'] === "PassordIkkeLike") {
    echo "<script>alert(\"Passordene er ikke like!\")</script>";
    unset($_SESSION['feilSjekk']);
}
if ($_SESSION['feilSjekk'] === "PassordeneTom") {
    echo "<script>alert(\"Du må fylle ut begge feltene!\")</script>";
    unset($_SESSION['feilSjekk']);
}
if ($_SESSION['feilSjekk'] === "NyttFagOK") {
    echo "<script>alert(\"Nytt fag er registrert!\")</script>";
    unset($_SESSION['feilSjekk']);
}
if ($_SESSION['feilSjekk'] === "NyttFagIkkeOK") {
    echo "<script>alert(\"Dette faget finnes fra før!\")</script>";
    unset($_SESSION['feilSjekk']);
}
?>
