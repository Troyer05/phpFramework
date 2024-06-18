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
 * 
 * Diese UI ist Grafisch minimalistisch gehalten
 * Wenn diese UI auf ein Produktivsystem mit genommen wird, empfiehlt es sich,
 * in ENV.php ein Passwort für diese UI fest zu legen
 */

if (!Vars::__DEV__()) {
    if (!isset($_SESSION["gqlpwd"])) {
        $_SESSION["gqlpwd"] = ".";
        Ref::to("index.php");
    }

    if (Vars::greenQL_UI_password() != "" && Vars::greenQL_UI_password() != $_SESSION["gqlpwd"]) { 
        Ref::to("index.php");
    }
}

if (isset($_GET["w"])) {
    if ($_GET["w"] == "db") {
        echo '
        <form method="post" action="?form=apply&t=db">
        Name der neuen Datenbank:
        <br>
        <input type="text" name="name" required />
        <br>
        <button type="submit">Datenbank anlegen</button>
        <a class="cancel" href="?null">Abbrechen</a>
        </form>
        <hr>
        ';
    } else if ($_GET["w"] == "tb") {
        echo '
        <form method="post" action="?form=apply&t=tb">
        <input type="hidden" name="db" value="' . $_GET["in"] . '" />
        Name der neuen Tabelle:
        <br>
        <input type="text" name="name" required />
        <br><br>
        Array der Spalten: (BeispieL ["name", "notiz", "datum"])
        <br>
        <textarea name="array" rows="20" cols="120" required></textarea>
        <br>
        <button type="submit">Tabelle anlegen</button>
        <a class="cancel" href="?null">Abbrechen</a>
        </form>
        <hr>
        ';
    } else if ($_GET["w"] == "data") {
        $table = $_GET["tb"] . '.json';
        $db = $_GET["in"];
        $path = Vars::DB_PATH() . $db . "/" . $table;
        $data = json_decode(file_get_contents($path, true), true);
        $saf = $data;
        $data = array_keys($data[0]);
        $fi = '';
        $tab = '';
        $tab2 = '';

        for ($i = 0; $i < count($data); $i++) {
            $tab .= '<th>' . $data[$i] . '</th>';

            if ($data[$i] != "id") {
                $fi .= '
                <tr>
                  <td class="first" width="172"><strong>Spalte: ' . $data[$i] . '</strong></td>
                  <td class="last"><input type="text" class="text" name="' . Format::cleanString($data[$i]) . '" /></td>
                </tr>
                ';
            }
        }

        $tab .= '<th>Löschen</th>';
        $firstRowSkipped = false;

        foreach ($saf as $row) {
            if (!$firstRowSkipped) {
                $firstRowSkipped = true;
                continue;
            }
        
            $tab2 .= '<tr>';
            $n = 0;
            $id = 0;
        
            foreach ($row as $value) {
                if ($n == 0) {
                    $id = $value;
                }

                $tab2 .= '<td>' . $value . '</td>';
                $n++;
            }
        
            $tab2 .= '<td><a href="?del=data&db=' . $_GET["in"] . '&tb=' . $_GET["tb"] . '&id=' . $id . '" class="del">[x]</a></td></tr>';
        }

        echo '
        <form method="post" action="?form=apply&t=data">
        <input type="hidden" name="db" value="' . $_GET["in"] . '" />
        <input type="hidden" name="tb" value="' . $_GET["tb"] . '" />
        <div class="table"> <img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" /> <img
          src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
        <table class="listing form" cellpadding="0" cellspacing="0">
          <tr>
            <th class="full" colspan="2">Tabelle: ' . $_GET["tb"] . ' in ' . $_GET["in"] . '</th>
          </tr>
        ' . $fi . '
                </table>
        </div>
        <button type="submit">Daten einfügen</button>
        <a class="cancel" href="?null">Abbrechen</a>
        </form>
        <hr>
        <div class="table"> <img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" /> <img
         src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
        <table class="listing" cellpadding="0" cellspacing="0">
         <tr>
         ' . $tab . ' 
         </tr>
         ' . $tab2 . '
         </table></div>
        <hr>
        ';
    }
}

if (isset($_GET["form"])) {
    if ($_GET["form"] == "apply") {
        if ($_GET["t"] == "db") {
            $name = $_POST["name"];

            if (GBDB::createDatabase($name)) {
                Ref::this_file();
            } else {
                die("Etwas lief schief!");
            }
        } else if ($_GET["t"] == "tb") {
            $name = $_POST["name"];
            $db = $_POST["db"];
            $cols = str_replace("\n", "", $_POST["array"]);
            $cols = str_replace("\r", "", $cols);
            $cols = json_decode($cols, true);

            if (GBDB::createTable($db, $name, $cols)) {
                Ref::this_file();
            } else {
                die("Etwas lief schief!");
            }
        } else if ($_GET["t"] == "data") {
            $db = $_POST["db"];
            $tb = $_POST["tb"];
            $path = Vars::DB_PATH() . $db . "/" . $tb . '.json';
            $data = json_decode(file_get_contents($path, true), true);
            $data = array_keys($data[0]);
            $tmp = [];

            for ($i = 0; $i < count($data); $i++) {
                $key = $data[$i];

                if ($key != "id") {
                    $cleanedKey = Format::cleanString($key);

                    if (isset($_POST[$cleanedKey])) {
                        $tmp[$key] = $_POST[$cleanedKey];
                    }
                }
            }

            if (GBDB::insertData($db, $tb, $tmp)) {
                Ref::to("?w=data&in=" . $db . '&tb=' . $tb);
            } else {
                die("Etwas lief schief!");
            }
        }
    }
}

if (isset($_GET["del"])) {
    if ($_GET["del"] == "db") {
        if (GBDB::deleteDatabase($_GET["db"])) {
            Ref::this_file();
        } else {
            die("Etwas lief schief!");
        }
    } else if ($_GET["del"] == "tb") {
        if (GBDB::deleteTable($_GET["in"], $_GET["tb"])) {
            Ref::this_file();
        } else {
            die("Etwas lief schief!");
        }
    } else if ($_GET["del"] == "data") {
        if (GBDB::deleteData($_GET["db"], $_GET["tb"], "id", $_GET["id"])) {
            Ref::to("?w=data&in=" . $_GET["db"] . '&tb=' . $_GET["tb"]);
        } else {
            die("Etwas lief schief!");
        }
    }
}

/**
 * Bearbeiten kommt in einer zukünftigen Version vielleicht
 */
?>