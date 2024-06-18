<?php
/**
 * CSS Template von https://all-free-download.com/free-website-templates/download/cms_admin_template_6890507.html
 * Warum ausgerechnet dieses? Ich fands halt cool ....
 * 
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

<?php include 'assets/php/inc/gbdb_framework/gbdb.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <title>GreenQL UI</title>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <link rel="stylesheet" href="assets/css/greenql_ui.css">
</head>

<body>
  <div id="main">
    <div id="header"> <a href="#" class="logo">
        <h1 style="color: #2a4;"><u>GreenQL UI</u></h1>
      </a>
      <ul id="top-navigation">
        <!-- <li class="active"><span><span>MAIN</span></span></li> -->
        <!-- <li><span><span><a href="#">Users</a></span></span></li>
      <li><span><span><a href="#">Orders</a></span></span></li>
      <li><span><span><a href="#">Settings</a></span></span></li>
      <li><span><span><a href="#">Statistics</a></span></span></li>
      <li><span><span><a href="#">Design</a></span></span></li>
      <li><span><span><a href="#">Contents</a></span></span></li> -->
      </ul>
    </div>
    <div id="middle">
      <div id="left-column">
        <h3 style="color: #555;">&Uuml;bersicht</h3>
        <!-- <ul class="nav">
          <li><a href="#">Lorem Ipsum dollar</a></li>
          <li><a href="#">Dollar</a></li>
          <li><a href="#">Lorem dollar</a></li>
          <li><a href="#">Ipsum dollar</a></li>
          <li><a href="#">Lorem Ipsum dollar</a></li>
          <li class="last"><a href="#">Dollar Lorem Ipsum</a></li>
        </ul> -->
      </div>
      <div id="center-column">
        <!-- <div class="top-bar">
          <h1>Baum Ansicht</h1>
        </div>
        <br /> -->
        <!-- <div class="select-bar">
          <label>
            <input type="text" name="textfield" />
          </label>
          <label>
            <input type="submit" name="Submit" value="Search" />
          </label>
        </div> -->
          <h2><strong>
            <?php include 'assets/php/inc/gbdb_framework/new.php'; ?>

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
                                echo '<li class="tabl" title="' . $tbs[$j] . '"><a href="?w=data&in=' . $dbs[$i] . '&tb=' . $tbs[$j] . '">' . Format::shortString($tbs[$j], 47, 48) . '</a> <a class="del" href="?del=tb&tb=' . $tbs[$j] . '&in=' . $dbs[$i] . '">[x]</a></li>';
                            }
                          
                            echo '</ul></li>';
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </strong></h2>
      </div>
      <div id="right-column"> <strong class="h">Daten</strong>
        <div class="box">
          <?php echo FS::getFolderSize(Vars::DB_PATH()); ?>
        </div>
      </div>
    </div>
    <div id="footer"></div>
  </div>
</body>

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

</html>