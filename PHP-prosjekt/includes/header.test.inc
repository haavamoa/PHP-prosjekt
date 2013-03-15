<header>

    <img src="img/logo_hist.png"/>
    <div id="logginnognav">
        <div id="logginn">


            <?php
            /* True: lærer
              false:elev/bruker */
            if ($_SESSION['LoggInn']) {
                include_once'includes/innloggingLaerer.inc';
            } else {
                include_once'includes/innloggingBruker.inc';
            }
            ?>

        </div>
        <span id="fagselect">
            <span id="nyfag">
                <?php
                //Hvis du er Lærer skal du kan legge til fag
                if ($_SESSION['LoggInn']) {
                    include_once 'includes/nyttFag.inc';
                }
                ?>
            </span>
            <span id="fagliste">

                <select>

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
            </span>
        </span>

        <div id="nav">

            <ul>
                <li><a href="index.php">Hjem</a></li>
                <li><a href="#">Registrer ny blogg</a></li>
            </ul>
        </div>

        <span id="navnkodesemester">
            <table>
                <th>Fagnavn</th>
                <th>Fagkode</th>
                <th>Semester</th>

                <tr>
                    <td>Fagnavn</td>
                    <td>Fagkode</td>
                    <td>Semester</td>
                </tr>
            </table>
        </span>
    </div>

</header>
