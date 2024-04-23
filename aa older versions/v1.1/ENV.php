<?php
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

    // Sollen alle JSON Daten in Dateien formatiert werden?
    public static function json_pretty() {
        return true; // true für Formatieren
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

    public static function DB_PATH() {
        return Vars::json_path() . 'GBDB/';
    }

    public static function jpretty() {
        if (Vars::json_pretty()) {
            return 128;
        }
        
        return 0;
    }
}
?>