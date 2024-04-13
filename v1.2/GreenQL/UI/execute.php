<?php
include '../../gbdb.php';

$debug = false;

if (isset($_POST["debug"])) {
    $debug = true;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["query"])) {
        $query = $_POST["query"];
        echo "Empfangene Abfrage: $query<br>";
        $statements = explode("#", $query);

        foreach ($statements as $statement) {
            $statement = trim($statement);

            if (empty($statement)) {
                continue;
            }

            $queryType = strpos($statement, "create database") !== false ? "database" :
                (strpos($statement, "create table") !== false ? "table" :
                (strpos($statement, "select all from") !== false ? "select" : "unknown"));

            echo "Query-Typ: $queryType<br>";

            switch ($queryType) {
                case 'database':
                    $matches = [];

                    preg_match('/create database "(.*?)"/', $statement, $matches);

                    $dbName = isset($matches[1]) ? $matches[1] : "";

                    echo "Datenbankname: $dbName<br>";
                    
                    GBDB::createDatabase($dbName);
                    break;

                case 'table':
                    $matches = [];

                    preg_match('/create table "(.*?)" in "(.*?)" \((.*?)\)/', $statement, $matches);

                    $tableName = isset($matches[1]) ? $matches[1] : "";
                    $dbName = isset($matches[2]) ? $matches[2] : "";
                    $columnsStr = isset($matches[3]) ? $matches[3] : "";
                    $columns = explode(",", $columnsStr);
                    $columns = array_map('trim', $columns);
                    $columns = array_map('trim', $columns);

                    $columns = array_map(function($col) {
                        return trim($col, '"');
                    }, $columns);

                    echo "Datenbankname: $dbName<br>";
                    echo "Tabellenname: $tableName<br>";
                    echo "Spalten: ";
                    print_r($columns);
                    echo "<br>columns als json_encode: ";
                    echo json_encode($columns);

                    GBDB::createTable($dbName, $tableName, $columns);
                    break;

                case 'select':
                    $matches = [];

                    preg_match('/select all from "(.*?)" in "(.*?)"/', $statement, $matches);

                    $tableName = isset($matches[1]) ? $matches[1] : "";
                    $dbName = isset($matches[2]) ? $matches[2] : "";

                    echo "Datenbankname: $dbName<br>";
                    echo "Tabellenname: $tableName<br>";
                    echo '<br><br><br>RESULT:<br>';

                    foreach (GBDB::getData($dbName, $tableName) as $data) {
                        echo json_encode($data, JSON_PRETTY_PRINT);
                    }

                    echo '<br><br><br><br>';
                    break;

                default:
                    echo "Unknown query type: $queryType";
                    break;
            }
        }
    }
}

if ($debug) {
    echo '<br><br><br><br><a href="index.php">INDEX</a>';
} else {
    Ref::to("index.php");
}

exit();
?>
