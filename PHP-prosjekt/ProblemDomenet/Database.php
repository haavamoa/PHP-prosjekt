<?php

//Denne er privat og ligger på en mappe utenfor domenet pga. sikkerhet
include_once'../private/MySQL.php';
//Denne includen er for Behandler
include_once'../../private/MySQL.php';

class Database {

//Privat variabel til klassen for å holde styr på database oppkobling
    private $con;

    public function __construct() {
        $MySQL = new databaseConnection();
        $this->con = $MySQL->openConnectionToDB();
        if ($this->con->connect_errno) { //Hvis connection ikke er bra, feilmelding til bruker.
            echo 'Feil i database oppkobling';
        }
    }

    /* Her må vi passe på SQL-injeksjon og at passordet er det samme som i databsen.
     * SQL-injeksjon: bruke preparestatement.
     * Kryptering av passord: Vi har valgt å hashe med sha256 algoritmen 
     * Return: true(epost) / false.
     */

    public function sjekkLogginn() {
//Brukernavn og passord fra form
//Brukernavn = epost
        $brukernavn = $_POST['brukernavn'];
        $passord = $_POST['passord'];

//Krypterer input
        $passordKrypt = hash('sha256', $passord);
//Spørring
        $sql = "select epost from BrukerePHP where epost=? and passord=?";

//Preparestatement
        if ($stmt = $this->con->prepare($sql)) {
            $stmt->bind_param('ss', $brukernavn, $passordKrypt);
            $stmt->execute();
            $stmt->bind_result($epost);
            if ($stmt->fetch()) {
                return $epost;
            } else {
                return false;
            }
        } else {
            die('feil i sjekkLoggInn()');
        }
    }

    /* Endrer passord til Lærer
     * Oppdater database med nyttt passord HVIS NyttPassord === GjentaPassord og NyttPassord != "" (kunne brukt required, men ble kluss med forms)
     * Brukernavn = $_SESSION['epost']
     * Nytt passord = $_POST['NyttPassord']
     * Gjenta passord = $_POST['GjentaPassord']
     * PS: Pass på SQL injection
     */

    public function endrePassord() {
        //Informasjon fra FORM og SESSION
        $NyttPassord = $_POST['NyttPassord'];
        $GjentaPassord = $_POST['GjentaPassord'];
        $epost = $_SESSION['epost'];
        $sql = "update BrukerePHP set passord=? where epost=?";

        if ($NyttPassord != "" || $GjentaPassord != "") {
            if ($NyttPassord === $GjentaPassord) {
                if ($stmt = $this->con->prepare($sql)) {
                    $Passord = hash("sha256", $NyttPassord);
                    $stmt->bind_param("ss", $Passord, $epost);
                    $stmt->execute();
                    return 1; //"Passordet er endret!
                } else {
                    echo "Feil i endrePassord()";
                }
            } else {
                return 0; //"Passordene er ikke like!"
            }
        }
        return -1; //"Du må fylle ut begge feltene!"
    }

    /* Funksjon for å legge til nytt fag
     * Først: select for å sjekke om faget finnes fra før, return 0
     * Andre: Legge til hvis ikke faget finnes fra før, return 1
     */

    public function nyttFag() {
        //Henter fra form og session
        $brukernavn = $_SESSION['epost'];
        $Fagnavn = $_POST['Fagnavn'];
        $Fagkode = $_POST['Fagkode'];
        $Semester = $_POST['Semester'];
        $sql1 = "select fagkode from FagPHP where fagkode=?";

        if ($stmt1 = $this->con->prepare($sql1)) {
            $stmt1->bind_param("s", $Fagkode);
            $stmt1->execute();
            $teller = 0;
            if ($stmt1->fetch()) {
                return 0; //Faget finnes fra før!
            }
            $sql2 = "insert into FagPHP(fagkode,fagnavn,semester,epost) values(?,?,?,?)";
            if ($stmt2 = $this->con->prepare($sql2)) {
                $stmt2->bind_param("ssss", $Fagkode, $Fagnavn, $Semester, $brukernavn);
                $stmt2->execute();
                return 1; //"Nytt fag registrert!
            } else {
                echo "Feil i nyttFag()";
            }
        }
    }

    public function getFag() {
        //Hvis du er logget inn
        if ($_SESSION['LoggInn']) {
            $brukernavn = $_SESSION['epost'];
            $sql = "select fagnavn from FagPHP where epost=? order by fagnavn";
            if ($stmt = $this->con->prepare($sql)) {
                $stmt->bind_param("s", $brukernavn);
                $stmt->execute();
                $stmt->bind_result($navn);
                $tabell = array();
                $teller = 0;
                while ($stmt->fetch()) {
                    $tabell[$teller] = $navn;
                    $teller++;
                }
                return $tabell;
            } else {
                echo "feil i getFag()";
            }
        } else { //Hvis du ikke er logget inn
            $sql = "select fagnavn from FagPHP order by fagnavn";
            if ($stmt = $this->con->prepare($sql)) {
                $stmt->execute();
                $stmt->bind_result($navn);
                $tabell = array();
                $teller = 0;
                while ($stmt->fetch()) {
                    $tabell[$teller] = $navn;
                    $teller++;
                }
                return $tabell;
            } else {
                echo "feil i getFag()";
            }
        }
    }

    public function getGamleFag() {
        //Hvis du er logget inn
        if ($_SESSION['LoggInn']) {
            $brukernavn = $_SESSION['epost'];
            $sql = "select fagnavn from GamleFagPHP where epost=? order by fagnavn";
            if ($stmt = $this->con->prepare($sql)) {
                $stmt->bind_param("s", $brukernavn);
                $stmt->execute();
                $stmt->bind_result($navn);
                $tabell = array();
                $teller = 0;
                while ($stmt->fetch()) {
                    $tabell[$teller] = $navn;
                    $teller++;
                }
                return $tabell;
            } else {
                echo "feil i getFag()";
            }
        } else { //Hvis du ikke er logget inn
            $sql = "select fagnavn from GamleFagPHP order by fagnavn";
            if ($stmt = $this->con->prepare($sql)) {
                $stmt->execute();
                $stmt->bind_result($navn);
                $tabell = array();
                $teller = 0;
                while ($stmt->fetch()) {
                    $tabell[$teller] = $navn;
                    $teller++;
                }
                return $tabell;
            } else {
                echo "feil i getFag()";
            }
        }
    }

    /* Hent ut fagnavn på fag
     * Sjekker om du er innlogget.
     * Returnerer array med resultatet gitt innlogget eller ikke.
     * Hvis innlogget, returnerer ditt fag du velger fra listen.
     */

    public function getFagPaNavn($fagnavn) {
        if ($_SESSION['LoggInn']) {
            $brukernavn = $_SESSION['epost'];
            $sql1 = "select fagkode,semester from FagPHP where epost=? and fagnavn=?";
            $stmt = mysqli_stmt_init($this->con);
            if ($stmt = $this->con->prepare($sql1)) {
                $stmt->bind_param("ss", $brukernavn, $fagnavn);
                $stmt->execute();
                $stmt->bind_result($fagkode, $semester);
                $array = array();
                $stmt->fetch();
                    $array[0] = $fagnavn;
                    $array[1] = $fagkode;
                    $array[2] = $semester;
                return $array;
            }
        } else {
            $sql2 = "select BrukerePHP.navn,fagkode,semester from BrukerePHP,FagPHP where fagnavn=? and BrukerePHP.epost=FagPHP.epost";
            if ($stmt = $this->con->prepare($sql2)) {
                $stmt->bind_param("s", $fagnavn);
                $stmt->execute();
                $stmt->bind_result($navn, $fagkode, $semester);
                $array = array();
                $stmt->fetch();
                $array[0] = $fagnavn;
                $array[1] = $fagkode;
                $array[2] = $semester;
                $array[3] = $navn;
                return $array;
            }
        }
    }

    public function getGammeltFagPaNavn($semester, $fagnavn) {
        if ($_SESSION['LoggInn']) {
            $brukernavn = $_SESSION['epost'];
            $sql1 = "select fagkode from GamleFagPHP where epost=? and fagnavn=? and semester=?";
            $stmt = mysqli_stmt_init($this->con);
            if ($stmt = $this->con->prepare($sql1)) {
                $stmt->bind_param("sss", $brukernavn, $fagnavn, $semester);
                $stmt->execute();
                $stmt->bind_result($fagkode);
                $array = array();
                $stmt->fetch();
                $array[0] = $fagnavn;
                $array[1] = $fagkode;
                $array[2] = $semester;
                return $array;
            } else {
                $sql2 = "select BrukerePHP.navn,fagkode from BrukerePHP,GamleFagPHP where fagnavn=? and semester=? and BrukerePHP.epost=FagPHP.epost ";
                if ($stmt = $this->con->prepare($sql2)) {
                    $stmt->bind_param("ss", $fagnavn, $semester);
                    $stmt->execute();
                    $stmt->bind_result($navn, $fagkode);
                    $array = array();
                    $stmt->fetch();
                    $array[0] = $fagnavn;
                    $array[1] = $fagkode;
                    $array[2] = $semester;
                    $array[3] = $navn;
                    return $array;
                }
            }
        }
    }

    public function endreFag() {
        $Brukernavn = $_SESSION['epost'];
        $Fagnavn = $_POST['Fagnavn'];
        $FagnavnPrimaer = $_SESSION['fagnavn'];
        $Fagkode = $_POST['Fagkode'];
        $Semester = $_POST['Semester'];
        $sql = "update FagPHP set fagnavn=?,fagkode=?,semester=? where fagnavn=?";
        if ($stmt = $this->con->prepare($sql)) {
            $stmt->bind_param("ssss", $Fagnavn, $Fagkode, $Semester, $FagnavnPrimaer);
            if (!$stmt->execute())
                die($this->con->error);
        }
        echo "feil i getFag()";
    }

    public function skrivUtLenke() {
        if ($_SESSION['LoggInn']) {
            $fag = $_SESSION['fagnavn'];
            $ServerLenke = $_SERVER['SERVER_NAME'];
            $_SESSION['link'] = "<a href=\"http://$ServerLenke/PHP-prosjekt/?fagnavn=$fag\">http://$ServerLenke/PHP-prosjekt/?fagnavn=$fag</a>";
            echo '</br>Lenke til faget:' . $_SESSION['link'];
        }
    }

}

?>
