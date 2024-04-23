<?php
/**
 * Diese Datei ist nicht für das Betrachten von Code geeignet
 * .... ich habe sie nur schlampig geschrieben. Sie funktioniert,
 * keine Frage aber die Lesbarkeit ist nicht wirklich gegeben.
 * 
 * Bearbeiten dieser Datei auf eigene Verantwortung.
 * Hier gelten dieselben Dinge wie in der Hauptdatei
 * bvereits angemerkt.
 * 
 * Vielleicht wird diese Datei lesbarer in zukünfitgen Versionen ....
 */
 ?>

<?php include '../../gbdb.php'; ?>

<?php 
if (!Vars::__DEV__()) {
    if (!isset($_SESSION["gqlpwd"])) {
        $_SESSION["gqlpwd"] = "";
        Ref::this_file();
    }
    
    if (isset($_POST["pass"])) {
        $_SESSION["gqlpwd"] = $_POST["pass"];
        Ref::this_file();
    }
}

if (Vars::__DEV__() || Vars::greenQL_UI_password() == "" || Vars::greenQL_UI_password() == $_SESSION["gqlpwd"]) { 
?>
<style>
* {
    font-family: courier;
}

ul,
#myUL {
    list-style-type: none;
}

#myUL {
    margin: 0;
    padding: 0;
}

.caret {
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    text-decoration: underline;
}

.caret::before {
    content: "\25B6";
    color: black;
    display: inline-block;
    margin-right: 6px;
}

.caret-down::before {
    -ms-transform: rotate(90deg);
    -webkit-transform: rotate(90deg);
    transform: rotate(90deg);
}

.nested {
    display: none;
}

.active {
    display: block;
}

.tabl a {
    color: #089c4e !important;
    text-decoration: none;
}

.add a {
    color: #b67807 !important;
    text-decoration: none;
}

.del {
    color: #ff0000 !important;
    text-decoration: none;
}

.tabl .del {
    color: #ff0000 !important;
    text-decoration: none;
}

li {
    color: #0000ff;
    cursor: pointer;
}

table, td, tr {
    border: 1px solid #000;
}
</style>

<h2><strong>
    <?php include 'new.php'; ?>

    <ul id="myUL">
        <li><span class="add"><a href="?w=db">[Neue Datenbank]</a></span></li><br>
        <li><span class="caret" style="color: #000;">GBDB - ROOT (<?php echo Vars::DB_PATH(); ?>)</span>
            <ul class="nested">
                <?php
                $dbs = GBDB::listDBs();

                for ($i = 0; $i < count($dbs); $i++) {
                    $tbs = GBDB::listTables($dbs[$i]);
                
                    echo '<li><span class="caret">' . $dbs[$i] . '</span> <a class="del" href="?del=db&db=' . $dbs[$i] . '">[x]</a><ul class="nested">';
                    echo '<li class="add"><a href="?w=tb&in=' . $dbs[$i] . '">[Neue Tabelle]</a></li>';
                
                    for ($j = 0; $j < count($tbs); $j++) {
                        echo '<li class="tabl"><a href="?w=data&in=' . $dbs[$i] . '&tb=' . $tbs[$j] . '">' . $tbs[$j] . '</a> <a class="del" href="?del=tb&tb=' . $tbs[$j] . '&in=' . $dbs[$i] . '">[x]</a></li>';
                    }
                
                    echo '</ul></li>';
                }
                ?>
            </ul>
        </li>
    </ul>
</strong></h2>

<script>
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
    toggler[i].addEventListener("click", function() {
        this.parentElement.querySelector(".nested").classList.toggle("active");
        this.classList.toggle("caret-down");
    });
}
</script>
<?php } else { ?>
    <form method="post" action="index.php">
        Passwort: <input type="password" name="pass" required />
        <button type="submit">Login</button>
    </form>
<?php } ?>