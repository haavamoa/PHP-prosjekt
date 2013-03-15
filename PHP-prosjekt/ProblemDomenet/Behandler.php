<?php
/*
 * Behandler.php:
 * Hele poenget med å ha en prosesseringsfil er for å slippe å pushe sessions,
 * hver gang du klikker deg rundt på siden. Merk: Hvis du har slike if settninger direkte på en side,
 * vil du bli spurt om å pushe objekter på nytt for hver gang du navigerer deg frem og tilbake ved
 * hjelp av forward og backward browser funksjoner.
 * Denne klassen sjekker da hvilke former du bruker, og utfører funksjoner fra databasen ut i fra hva du
 * ønsker å utføre.
 */

//Interessert i å bruke session for å håndtere feilmeldinger.
session_start();
/*
 * Denne klassen brukes av alle forms, og den sjekker hvilken form du har sendt videre og dermed kjører riktig.
 * psudo:
 * if(isset(knapp))
 *      funksjon
 *  
 * author: havard, marius
 *  */

/* Må inkluder database skriptet og lage objekt av klassen
 * Variabelen $_SESSION['LoggInn'] er viktig fordi vi bruker samme sider, men endrer ut i om denne variabelen er true eller false.
 * $_SESSION['LoggInn'] = true betyr at du er logget inn som lærer.
 * $_SESSION['LoggInn'] = false betyr at du er logget ut og er elev/bruker.
 */

include_once'Database.php';
$db = new Database();

/* Dette forteller hvilken side du kommer fra, dette er registrert på serveren.
 * Du exploder på "/" og teller opp lengden, du kan da bruke $n og $sideFra til å finne
 * riktig side brukeren kommer fra.
 * Feks : http://gooogle.com/foo/bar blir da bar
 */
$sideFraServer = $_SERVER['HTTP_REFERER'];
$sideFraTabell = explode("/", $sideFraServer);
$n = count($sideFraTabell) - 1;
if($sideFra[$n] != ""){
    $sideFra = $sideFraTabell[$n].'.php';
}else{
    $sideFra = $sideFraTabell[$n];
}


//Hvis du har klikket på Logg inn
if (isset($_POST['LoggInn'])) {
    if ($epost = $db->sjekkLogginn()) {
        $_SESSION['LoggInn'] = true;
        $_SESSION['epost'] = $epost;
        header("location:../$sidefra");
    } else {
        $_SESSION['LoggInn'] = false;
        header("location:../$sidefra");
    }
}

//Hvis du har klikket på Logg ut
if (isset($_POST['LoggUt'])) {
    $_SESSION['LoggInn'] = false;
    header("location:../$sidefra");
}
/* Feilsjekk er en variabel som blir endret i endrePassord(),
 * forklaring ligger i den funksjonen.
 */
if (isset($_POST['EndrePassord'])) {
    $feilSjekk = $db->endrePassord();
    if ($feilSjekk === 1) {
        $_SESSION['feilSjekk'] = "PassordOk";
        header("location:../$sidefra");
    } else if ($feilSjekk === 0) {
        $_SESSION['feilSjekk'] = "PassordIkkeLike";
        header("location:../$sidefra");
    } else if ($feilSjekk === -1) {
        $_SESSION['feilSjekk'] = "PassordeneTom";
        header("location:../$sidefra");
    }
}

/*
 * Feilsjekk er en variabel som endret i nyttFag(),
 * forkarling ligger i den funksjonen.
 */
if(isset($_POST['NyttFag'])){
    $feilsjekk = $db->nyttFag();
    if($feilsjekk != 0){
        $_SESSION['fagnavn'] = $_POST['Fagnavn'];
        header("location:../$sideFra");
        $_SESSION['feilSjekk'] = "NyttFagOK";
    }else{
        header("location:../$sideFra");
        $_SESSION['feilSjekk'] = "NyttFagIkkeOK";
    }
}

/*
 * Hvis du har klikket på et fag fra listen, blir dette kjørt
 */
if(isset($_POST['fag'])){
    $_SESSION['fagnavn'] = $_POST['fag'];
    header("location:../$sideFra");
}

if(isset($_POST['EndreFag'])){
    $db->endreFag();
    $_SESSION['fagnavn'] = $_POST['Fagnavn'];
    header("location:../$sideFra");
}
?>