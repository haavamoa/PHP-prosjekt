<header>
  <?php
  //Hvis du er Lærer skal du kan legge til fag
  if($_SESSION['LoggInn']){
      include_once 'includes/nyttFag.inc';
  }
  ?>
    <img src="img/logo_hist.png"/>
    <select>
        <?php
          for ($index = 0; $index < count($array); $index++) {
              echo "<option>$array[$index]</option>";
          }
        ?>
    </select>
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
