<header>
    <?php
    //Hvis du er Lærer skal du kan legge til fag
    if ($_SESSION['LoggInn']) {
        include_once 'includes/nyttFag.inc';
    }
    ?>
    <img src="img/logo_hist.png"/>
    <form method="post" action="ProblemDomenet/Behandler.php">
        <select name="fag">
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
        <table>
            <th>Fagnavn</th>
            <th>Fagkode</th>
            <th>Semester</th>
            <tr><td>Fagnavn</td>
                <td>Fagkode</td>
                <td>Semester<td> </tr>
        </table>
    </div>
</header>
