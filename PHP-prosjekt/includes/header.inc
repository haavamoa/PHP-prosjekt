<header>
    <?php
    //Hvis du er Lærer skal du kan legge til fag
    if ($_SESSION['LoggInn']) {
        include_once 'includes/nyttFag.inc';
    }
    ?>
    <img src="img/logo_hist.png"/>
    <form method="post" name="fag_liste" action="ProblemDomenet/Behandler.php">
        <select name="fag" onChange="document.fag_liste.submit()">
            <?php
            /*
             * Dette er en for-løkke som skriver ut alle fag som er registrert.
             * Den sørger også for at hvis du har trykket på et fag, så blir dette faget "selected". Altså vist i listen som øverst.
             * Hvis du ikke har trykket kommer det første registrerte faget øverst.
             */
            for ($index = 0; $index < count($array); $index++) {
                if (isset($_SESSION['fagnavn'])) {
                    if ($array[$index] === $_SESSION['fagnavn']) {
                        echo "<option selected=\"selected\" value=\"$array[$index]\" onClick=\"this.form.submit()\">$array[$index]</option>";
                    } else {
                        echo "<option value=\"$array[$index]\" onClick=\"this.form.submit()\">$array[$index]</option>";
                    }
                } else {
                    echo "<option value=\"$array[$index]\" onClick=\"this.form.submit()\">$array[$index]</option>";
                }
            }
            ?>
        </select>
    </form>
    <div id="navigasjon">
        <span>
            <a href="index.php">Hjem</a>
            <a href="#">Registrer ny blogg</a>
        </span>
    </div>
    <?php
    /* True: lærer
      false:elev/bruker */
    if ($_SESSION['LoggInn']) {
        include_once'includes/innloggingLaerer.inc';
    } else {
        include_once'includes/innloggingBruker.inc';
    }
    ?>

    <div id="fag">
        <form method="post" action="ProblemDomenet/Behandler.php">
            <table> 
                <th>Fagnavn</th>
                <th>Fagkode</th>
                <th>Semester</th>
                <?php
                /* Hvis du er logget inn
                 */
                if ($_SESSION['LoggInn']) {
                    if (isset($_SESSION['fagnavn'])) {
                        $fag = $_SESSION['fagnavn'];
                        $rad = $db->getFagPaNavn($fag);
                        echo "<tr>
                            <td><input type=\"text\" value=\"$rad[0]\" name=\"Fagnavn\"/></td>
                            <td><input type=\"text\" value=\"$rad[1]\" name=\"Fagkode\"/></td>
                            <td><input type=\"text\" value=\"$rad[2]\" name=\"Semester\"/></td>
                            <td><input type=\"submit\" value=\"Endre fag\" name=\"submit\"/></td>
                            </tr>";
                    }
                } else { //Hvis du ikke er logget inn
                    if (isset($_SESSION['fagnavn'])) {
                        $fag = $_SESSION['fagnavn'];
                        $rad = $db->getFagPaNavn($fag);
                        echo "<tr>
                            <td>$rad[0]</td>
                            <td>$rad[1]</td>
                            <td>$rad[2]</td>
                            </tr>";
                    }
                }
                ?> 
            </table>
        </form>
    </div>
</header>
