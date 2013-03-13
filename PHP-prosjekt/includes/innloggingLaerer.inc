<div id="innlogging">
        <form method="post" action="ProblemDomenet/Behandler.php">
            <table>
                <tr><td>Du er logget inn som:</td><td> <?php echo $_SESSION['epost'] ?></td></tr>
                <tr> <td>Nytt passord:</td><td><input type="secret" name="NyttPassord"/></td></tr>
                 <tr><td>Gjenta nytt passord:</td><td><input type="secret" name="GjentaPassord"/></td></tr>
                 <tr><td><input type="submit" name="LoggUt" value="Logg ut"/></td><td><input type="submit" name="EndrePassord" value="Endre passord"/></td></tr>
            </table>
        </form>
    </div>
