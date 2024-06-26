<?php
/**
 * greenbucket® PHP 8.1 EasyFramework mit Datenbanksystem
 *
 * @author Markus Müller CIO -> greenbucket®
 * @version 1.4
 * @copyright greenbucket®
 * @internal use only
 * @since 2023
 * @uses PHP 8.1
 * @global gbdb.php
 * 
 * Wie verdent man dieses Framework?
 * Einfach diese Datei bei den PHP Dateien, in denen Sie das
 * Framework nutzen wollen ganz oben via include oder require einbinden
 * 
 * DOKUMENTATION
 * Die Vollständige Dokumentation ist erhältlich unter
 * @link https://github.com/Troyer05/greenbucketFrameWork
 * 
**/

// Hier sind alle Globale Variablen. Diese können nach 
// Bedarf geändert werden. 

class Vars {
    public static function __DEV__() {
        // Entwickler Modus für Entwicklung/Lokale Umgebung. Bei Produktiv Umgebung auf false setzen:
        return true;
    }

    // Alle Variablen für die greenbucket API:
    public static function greenbucket_api_key() {
        return ""; // greenbucket API Key
    }

    public static function greenbucket_api_version() {
        return "v1"; // greenbucket API Version
    }

    public static function greenbucket_api_url() {
        return "https://greenbucket.online/API/" . Vars::greenbucket_api_version() . "/api"; // greenbucket API URL
    }

    // Alle Variablen für JSON Behandlung(en):
    public static function json_path() {
        // Wenn Sie einen bestimmten Ordner verwenden um JSON Dateien ab zu legen,
        // dann können Sie den Path zu diesem Ordner hier einfügen:
        return ""; // WARNUNG: BITTE DENKEN SIE AN DAS ABSCHLIEßENDE /
    }

    // Alle SQL Variablen für Produktiv Umgebung:
    public static function sql_server() {
        return ""; // SQL Server
    }

    public static function sql_database() {
        return ""; // SQL Datenbank
    }

    public static function sql_user() {
        return ""; // SQL User
    }

    public static function sql_password() {
        return ""; // SQL User-Passwort
    }

    // Alle SQL Variablen für Entwicklungs/Lokale Umgebung:
    public static function sql_dev_server() {
        return ""; // SQL Dev Server
    }

    public static function sql_dev_database() {
        return ""; // SQL Dev Datenbank
    }

    public static function sql_dev_user() {
        return ""; // SQL Dev User
    }

    public static function sql_dev_password() {
        return ""; // SQL Dev User-Passwort
    }

    // Hier können Sie Cookies hinzufügen, die initial gesetzt werden sollen
    // WICHTIG: Es dürfen NUR Zahlen unnd Buchstaben verwendet werden für Cookies.
    // Nicht einmal Leerzeichen sind zulässig.
    public static function init_cookies() {
        return array(
            [
                "cookie_name" => "TestCookie", // Cookie Name
                "cookie_value" => "Test1" // Cookie Value
            ],
            [
                "cookie_name" => "Cookie2",
                "cookie_value" => "Test2"
            ], // ...
        );
    }

    //Hier können Sie Session Variablen hinzufügen, die initial gesetzt werden sollen
    public static function init_session() {
        return array(
            [
                "session_name" => "Test Session Variable", // Session Variable Name
                "session_value" => "Test1" // Session variable Value
            ],
            [
                "session_name" => "Test Session Variable 2",
                "session_value" => "Test 2"
            ], // ...
        );
    }

    // ========================================================================================================================================================================================
    // AB HIER BEGINNT DAS FRAMEWORK! Bearbeitung auf eigene Gefahr!
    // Sobald Sie den Code des FrameWorks bearbeiten, verfällt
    // unser Support für das greenbucket FrameWork.
    // ========================================================================================================================================================================================

    public static function this_file(): string {
        return basename($_SERVER['SCRIPT_FILENAME']);
    }

    public static function client_ip(): string {
        $ip = $_SERVER['REMOTE_ADDR'];
        $ip = str_replace(":", "-", $ip);

        return $ip;
    }
}

class FS {
    /**
     * Schreibt JSON Daten in eine .json Datei
     * @param string $file der path zur .json Datei
     * @param mixed $data die JSON Daten als PHP Array, der in die Datei geschrieben werden soll
     * @param bool $add (Optional, Standart true) sollen die Daten an die Datei angefügt werden (bei false wird überschrieben)
     * @param bool $pretty (Optional, Standard false) sollen die JSON Daten schön Formatiert werden (bei false = Einzeiler)
     * @return bool true wenn es keine Probleme gab
     */
    public static function write_json(string $file, mixed $data, bool $add = true, bool $pretty = false): bool {
        $data = array_values($data);

        if ($add) {
            $tmp = self::read_json($file);
            array_push($tmp, $data);
            $data = $tmp;
        }

        $file = Vars::json_path() . $file;

        $pretty
            ? file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT))
            : file_put_contents($file, json_encode($data));

        return true;
    }

    /**
     * Liest JSON Daten aus einer .json Datei heraus und stellt sie PHP Formatiert bereit
     * @param string $file der path zur .json Datei
     * @return mixed die JSON Daten 
     */
    public static function read_json(string $file): mixed {
        return json_decode(file_get_contents(Vars::json_path() . $file, true), true);
    }

    /**
     * Schreibt normale Dateien in eine Datei
     * @param string $file path zur Datei
     * @param mixed $data die Daten die in die Datei geschrieben werden sollen
     * @param bool $stream (Optional, Standart false) ob es ein Filestream sein soll oder als stack etwa später geschrieben werden kann
     * @param bool $overwrite (Optional, Standart false) ob Daten überschrieben werden sollen oder angehängt werden sollen
     * @return bool true wenn es keine Probleme gab
     */
    public static function write(string $file, mixed $data, bool $stream = false, bool $overwrite = false): bool {
        if ($stream) {
            $f = ($overwrite ? fopen($file, 'w') : fopen($file, 'a+'));
            fwrite($f, $data);
            fclose($f);

            return true;
        } else {
            file_put_contents($file, $data);
            return true;
        }
    }

    /**
     * Liest  Daten aus einer Datei heraus
     * @param string $file der path zur Datei
     * @return mixed die Daten
     */
    public function read(string $file): mixed {
        return file_get_contents($file);
    }

    /**
     * Löscht ein Verzeichnis
     * @param string $dir path zum Verzeichnis
     * @return bool true wenn es keine Probleme gab
     */
    public static function deleteDirectory(string $dir): bool {
        if (is_dir($dir)) {
            $files = scandir($dir);

            foreach ($files as $file) {
                if ($file != "." && $file != "..") {
                    $path = $dir . "/" . $file;

                    if (is_dir($path)) {
                        deleteDirectory($path);
                    } else {
                        unlink($path);
                    }
                }
            }

            rmdir($dir);
            return true;
        }

        return false;
    }

    /**
     * Gibt die Größe eines Verzeichnisses wieder
     * @param string $path path zum Verzeichnis
     * @return string die Größe des Verzeichnisses
     */
    public static function getFolderSize(string $path): string {
        $size = 0;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            $size += $file->getSize();
        }

        if ($size >= 1073741824) {
            return number_format($size / 1073741824, 2) . ' GB';
        } elseif ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return $size . ' B';
        }
    }
}

class Ref {
    /**
     * Leitet auf eine andere Datei/Seite weiter
     * @param string $url die URL der Seite oder den Path der Datei
     */
    public static function to(string $url): void {
        echo '<meta http-equiv="refresh" content="0; URL=' . $url . '">';
        exit;
    }

    /**
     * Ladet aktuelle Seite neu
     */
    public static function this_file(): void {
        echo '<meta http-equiv="refresh" content="0; URL=' . Vars::this_file() . '">';
        exit;
    }
}

class GetForm {
    /**
     * Liest ein Dropdown aus und gibt die explizite Auswahl wieder
     * @param mixed $dropdown die POST Variable des Dropdowns (@example $_POST["drop1"])
     * @return mixed Explizite Userauswahl
     */
    public static function getDropdown(mixed $dropdown): mixed {
        $e = "";

        foreach ($dropdown as $val) {
            $e = $val;
        }

        return $e;
    }

    /**
     * Funktion zum Hochladen von Dateien (Max. 2 MB Zugelassen)
     * @param mixed $file Datei(en) der POST Methode zum Hochladen
     * @param string $path Path Wohin die Datei(en) hochgeladen werden sollen
     * @return bool true wenn es keine Probleme gab
     */
    public static function upload($file, string $path): bool {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return false;
        }
        
        if ($file['size'] > 2097152) {
            return false;
        }

        $fileName = preg_replace('/[^a-zA-Z0-9\_\-\.]/', '', basename($file['name']));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'txt', 'docx', 'doc', 'xls', 'ppt', 'ppts'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            return false;
        }

        $fileName = uniqid() . '_' . $fileName;

        if (move_uploaded_file($file['tmp_name'], $path . '/' . $fileName)) {
            return true;
        } else {
            return false;
        }
    }
}

class Format {
    /**
     * Formatiert ein Datum korrekt für ein HTML Input Feld des Typen date
     * @param mixed $date das zu formatierende Datum
     * @return mixed das korrekt formatierte Datum
     */
    public static function dateForInput(mixed $date): mixed {
        return date('Y-m-d', strtotime($date));
    }

    /**
     * Formatiert eine Uhrzeit korrekt für ein HTML Input Feld des Typen time
     * @param mixed $time die zu formatierende Zeit
     * @return mixed die korrekt formatierte Zeit
     */
    public static function timeForInput(mixed $time): mixed {
        return date('H:i:s', strtotime($time));
    }

    /**
     * Schneidet einen String ab
     * @param string $string der ab zu schneidende String
     * @param int $width (Optional, standart 14) wie lang soll der String maximal sein
     * @param int $shortBy (Optional, standart 14) Ab welchem Charackter soll der String abgeschnitten werden
     * @return string der abgeschnittene String
     */
    public static function shotString(string $string, int $width = 14, int $shortBy = 14): string {
        if (strlen($string) <= $width) {
            return $string;
        } else {
            $shortString = substr($string, 0, $shortBy) . '....';
            return $shortString;
        }
    }
}

class GBAPI {
    /**
     * @internal only
     * @uses internal Framewok
     */
    private static function bro(): mixed {
        return [
            'http' => [
                'method' => 'GET',
                'header' => 'Content-Type: application/json'
            ],    
        ];
    }

    /**
     * greenbucket API Fetchen
     * @param mixed $params parameter für den API Fetch (@example ["use" => "id", "id" => 4])
     * @return mixed API Antwort
     */
    public static function fetch(mixed $params): mixed {
        $context = stream_context_create(self::bro());

        $url = Vars::greenbucket_api_url();
        $url .= '?key=' . Vars::greenbucket_api_key();
        $url .= '&' . http_build_query($params);
        
        $result = file_get_contents($url, false, $context);

        return json_decode($result, true);
    }
}

class Api {
    /**
     * Ruft Daten von einer API ab
     * @param string $url Die URL der API
     * @param array $headers Optional: Ein assoziatives Array von Headerinformationen
     * @param mixed $body Optional: Die Daten, die im Request-Body gesendet werden sollen
     * @return mixed Die Daten von der API als Array oder Objekt, oder false im Fehlerfall
     */
    public static function fetch($url, $headers = [], $body = null) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if (!is_null($body)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }

        $response = curl_exec($ch);
        $error = curl_error($ch);
        
        curl_close($ch);

        if ($error) {
            error_log("API Fetch Error: $error");
            return false;
        } else {
            return json_decode($response, true);
        }
    }
}

class Hash {
    /**
     * Hasht ein Passwort Regelkonform
     * @param string $password das zu hashende Passwort
     * @return string das gehashte Passwort
     */
    public static function hashpassword(string $paassword): string {
        return hash('sha256', hash('sha512', $paassword));
    }

    /**
     * Erstellt einen SHA256 hash aus einem String
     * @param string $string der zu hashende String
     * @return string der gehashte String
     */
    public static function sha256(string $string): string {
        return hash('sha256', $string);
    }

    /**
     * Erstellt einen SHA512 hash aus einem String
     * @param string $string der zu hashende String
     * @return string der gehashte String
     */
    public static function sha512(string $string): string {
        return hash('sha512', $string);
    }

    /**
     * Erstellt einen adler32 hash aus einem String
     * @param string $string der zu hashende String
     * @return string der gehashte String
     */
    public static function adler32(string $string): string {
        return hash('adler32', $strin1g);
    }

    /**
     * Erstellt einen md5 hash aus einem String
     * @uses not recommanded
     * @param string $string der zu hashende String
     * @return string der gehashte String
     */
    public static function md5(string $string): string {
        return hash('md5', $string);
    }

    /**
     * Erstellt einen verwurzelten Hash aus einem String
     * @param string $string der zu hashende String
     * @return string der gehashte String
     */
    public static function multiHash(string $string): string {
        $a = hash('sha256', $string);
        $b = hash('adler32', $a);
        $c = hash('md5', $b);
        $d = hash('sha512', $c);
        $e = hash('sha256', $d);

        return hash('sha512', $e);
    }
}

class SQL {
    /**
     * @var any $pdo PDO SQL Connection
     */
    public static $pdo;

    /**
     * Stellt die Verbindung zum SQL Server her
     * @return bool true wenn es keine Probleme gab
     */
    public static function connect(): bool {
        if (Vars::__DEV__()) {
            $dsn = "mysql:host=" . Vars::sql_dev_server();
            $dsn .= ";dbname=" . Vars::sql_dev_database();
            $u = Vars::sql_dev_user();
            $p = Vars::sql_dev_password();
        } else {
            $dsn = "mysql:host=" . Vars::sql_server();
            $dsn .= ";dbname=" . Vars::sql_database();
            $u = Vars::sql_user();
            $p = Vars::sql_password();
        }

        try {
            self::$pdo = new PDO($dsn, $u, $p);
            return true;
        } catch (PDOException $e) {
            echo "Error when connecting to SQL database: " . $e;
            return false;
        }
    }

    /**
     * Sendet eine SQL Abfrage an den SQL Server
     * @param string $query die zu sendene SQL Abfrage
     * @return mixed die Antwort des SQL Servers / Das Ergebnis der SQL Abfrage
     */
    public static function sendSQL(string $query): mixed {
        $ergebnis = $pdo->query($sql);
    
        if ($ergebnis) {
            return $ergebnis;
        }
    
        return false;
    }
}

class Converter {
    /**
     * Addiert zwei Kommazahlen
     * @param int|float $p Kommazahl
     * @param int|float $a Multiplikator (@example Summe = $a * $p)
     * @return int|float Die Summe $a * $p
     */
    public static function getSumme(int|float $p, int|float $a): int|float {
        $tmp1 = str_replace(',', '.', $p);
        $tmp2 = floatval($tmp1);
        $tmp3 = $a * $tmp2;
        $tmp4 = strval($tmp3);
    
        $e = str_replace('.', ',', $tmp4);
    
        if (!is_int($tmp3)) {
            $e = number_format($tmp3, 2, ',', '');
        }
    
        return $e;
    }

    /**
     * Konvertiert eine Kommazahl zu einer Ganzzahl (Keine Aufrundung)
     * @param int|float $x Die zu Konvertieredne Kommazahl
     * @return int die Ganzzahl
     */
    public static function convertToNumber(int|float $x): int {
        $x = str_replace(',', '.', $x);
        $x = floatval($x);
    
        return $x;
    }
}

class Time {
    /**
     * Gibt wieder, wie lange ein Datum mit/oder Uhrzeit her ist
     * @param mixed $timestamp der TimeStamp
     * @return string Ausgabe wielange es her ist
     */
    public static function timeAgo(mixed $timestamp): string {
        $currentTime = time();
        $uploadedTime = strtotime($timestamp);
    
        $timeDifference = $currentTime - $uploadedTime;
    
        $seconds = $timeDifference;
        $minutes = round($seconds / 60);
        $hours   = round($seconds / 3600);
        $days    = round($seconds / 86400);
        $weeks   = round($seconds / 604800);
        $months  = round($seconds / 2629440);
        $years   = round($seconds / 31553280);
    
        if ($seconds <= 60) {
            return "vor $seconds Sekunden";
        } elseif ($minutes <= 60) {
            if ($minutes == 1) {
                return "vor einer Minute";
            } else {
                return "vor $minutes Minuten";
            }
        } elseif ($hours <= 24) {
            if ($hours == 1) {
                return "vor einer Stunde";
            } else {
                return "vor $hours Stunden";
            }
        } elseif ($days <= 7) {
            if ($days == 1) {
                return "vor einem Tag";
            } else {
                return "vor $days Tagen";
            }
        } elseif ($weeks <= 4.3) {  // 4.3 == 30/7
            if ($weeks == 1) {
                return "vor einer Woche";
            } else {
                return "vor $weeks Wochen";
            }
        } elseif ($months <= 12) {
            if ($months == 1) {
                return "vor einem Monat";
            } else {
                return "vor $months Monaten";
            }
        } else {
            if ($years == 1) {
                return "vor einem Jahr";
            } else {
                return "vor $years Jahren";
            }
        }
    }
}

class Cookie {
    /**
     * @var TIME
     */
    private const TIME = 60 * 60 * 24;

    /**
     * @var DUR
     * @var THR
     */
    public const DUR = self::TIME * 360;
    public const THR = self::TIME * 30;

    /**
     * Setzt ein Cookie
     * @internal @uses by Framework 
     * @param string $name Name des Cookies
     * @param string $value Inhalt des Cookies
     * @param int $expiration (Optional, Standard @var DUR ) Haltbarkeit des Cookies
     */
    public static function set(string $name, string $value, int $expiration = COOKIE::DUR): void {
        setcookie($name, $value, time() + $expiration, "/", "", false);
    }

    /**
     * Fügt ein neuen Cookie hinzu
     * @param string $name Name des Cookies
     * @param string $data inhalt des Cookies
     */
    public static function add(string $name, string $data): void {
        if (!isset($_COOKIE[$name])) {
            self::set($name, $data);
        }
    }

    /**
     * Ruft den Inhalt eines Cookies ab
     * @param string $name Name des Cookies
     * @return mixed Inhalt des Cookies
     */
    public static function get(string $name): mixed {
        return $_COOKIE[$name] ?? null;
    }

    /**
     * Löscht ein Cookie
     * @param string $name Name des zu löschenden Cookies
     */
    public static function delete(string $name): void {
        self::set($name, "", (0-3600));
    }

    /**
     * Bearbeitet ein Cookie
     * @param string $name Name des zu bearbeitenden Cookies
     * @param string $value neuer Inhalt des Cookies
     */
    public static function edit(string $name, string $value): void {
        self::delete($name);
        self::set($name, $value);
    }

    /**
     * Vergleicht ein Cookie mit etwas
     * @param string $name Name des Cookies
     * @param string $value Mit was der Cookie verglichen werden soll
     * @return bool true wenn Gleich
     */
    public static function compare(string $name, string $value): bool {
        return self::get($name) === $value;
    }

    /**
     * Aktuallisiert die Cookies im Browser
     */
    public static function refresh(): void {
        if (!empty($_COOKIE)) {
            foreach ($_COOKIE as $name => $data) {
                self::edit($name, $data);
            }
        }
    }

    /**
     * initialisierung der initialcookies
     * @internal used by Framework
     */
    public static function init(): void {
        foreach (vars::init_cookies() as $i => $r) {
            self::add($r["cookie_name"], $r["cookie_value"]);
            self::refresh();
        }
    }
}

class Session {
    /**
     * Erneuert die Session
     * @internal used by Framework
     */
    public static function renew_session(): void {
        ini_set('session.gc_maxlifetime', 0);

        $days = 360;
        $lifetime = $days * 24 * 60 * 60;

        session_set_cookie_params($lifetime);
        session_cache_expire($days);
        session_start();

        if (isset($_SESSION['created'])) {
            $renewThreshold = 30 * 24 * 60 * 60;

            if (time() - $_SESSION['created'] > $lifetime - $renewThreshold) {
                $_SESSION['created'] = time();
                session_regenerate_id(true);
            }
        } else {
            $_SESSION['created'] = time();
        }
    }

    /**
     * Behandeln der Session
     * @internal used by Framework
     */
    public static function handler(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            self::renew_session();
        }

        if (session_status() === PHP_SESSION_NONE) {
            self::renew_session();
        }
    }

    /**
     * initialisierung der initialen Session Variablen
     * @internal used by Framework
     */
    public static function init(): void {
        foreach (Vars::init_session() as $i => $r) {
            $_SESSION[$r["session_name"]] = $r["session_value"];
        }
    }

    /**
     * Gibt den Inhalt einer Session Variable zurück
     * @param string $name Name der Session Variable
     * @return mixed INhalt der Session Variable
     */
    public static function get(string $name): mixed {
        return $_SESSION[$name];
    }

    /**
     * Erstellt oder bearbeitet eine Session Variable
     * @param string $name Name der Session Variable
     * @param mixed $value Inhalt der Session Variable
     */
    public static function add_or_edit(string $name, mixed $value): void {
        $_SESSION[$name] = $value;
    }

    /**
     * Löscht eine Session Variable
     * @param string $name Name der zu löschenden Session Variable
     */
    public static function delete(string $name): void {
        $_SESSION[$name] = null;
        
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }
}

class Json {
    /**
     * Dekodiert einen JSON-String in ein PHP-Array oder Objekt
     * @param string $json Der zu dekodierende JSON-String
     * @param bool $assoc Gibt an, ob das zurückgegebene Objekt ein assoziatives Array sein soll oder nicht
     * @return mixed Das dekodierte JSON als Array oder Objekt
     */
    public static function decode($json, $assoc = false) {
        return json_decode($json, $assoc);
    }

    /**
     * Kodiert ein PHP-Array oder Objekt in einen JSON-String
     * @param mixed $data Das zu kodierende Array oder Objekt
     * @return string Der JSON-String
     */
    public static function encode($data) {
        return json_encode($data);
    }

    /**
     * Überprüft, ob eine Zeichenkette ein gültiges JSON ist
     * @param string $json Die zu überprüfende Zeichenkette
     * @return bool Gibt zurück, ob die Zeichenkette ein gültiges JSON ist (true) oder nicht (false)
     */
    public static function isJson($json) {
        json_decode($json);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Iteriert über jedes Element eines Arrays oder Objekts und wendet eine Callback-Funktion darauf an
     * @param mixed $data Das Array oder Objekt, über das iteriert werden soll
     * @param callable $callback Die Callback-Funktion, die auf jedes Element angewendet werden soll
     * @return mixed Das modifizierte Array oder Objekt
     */
    public static function loop($data, $callback) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = call_user_func($callback, $value, $key);
            }
        } elseif (is_object($data)) {
            foreach ($data as $key => $value) {
                $data->$key = call_user_func($callback, $value, $key);
            }
        }
        
        return $data;
    }

    /**
     * Überprüft, ob ein bestimmtes Element in einem JSON-Array oder Objekt existiert
     * @param mixed $data Das JSON-Array oder -Objekt
     * @param string $key Der Schlüssel des zu überprüfenden Elements
     * @return bool Gibt zurück, ob das Element existiert (true) oder nicht (false)
     */
    public static function elementExists($data, $key) {
        if (is_array($data)) {
            return array_key_exists($key, $data);
        } elseif (is_object($data)) {
            return property_exists($data, $key);
        }

        return false;
    }

    /**
     * Ruft die Daten eines bestimmten Elements aus einem JSON-Array oder -Objekt ab, falls es existiert
     * @param mixed $data Das JSON-Array oder -Objekt
     * @param string $key Der Schlüssel des Elements
     * @return mixed Die Daten des Elements, falls vorhanden, ansonsten null
     */
    public static function getElement($data, $key) {
        if (self::elementExists($data, $key)) {
            if (is_array($data)) {
                return $data[$key];
            } elseif (is_object($data)) {
                return $data->$key;
            }
        }

        return null;
    }
}

/**
 * Bitte Chekcen Sie das FrameWork regelmäßig auf Updates
 * 
 * Es sind weitere Funktionen für zukünfige
 * Versionen in Arbeit.
 * 
 */

Session::handler();
Cookie::init();
?>
