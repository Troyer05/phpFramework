# gbDB PHP Framework

Dieses Framework ist zur Vereinfachung, einiger PHP Funktionen.<br>
Der Zweck sit es, dass dieses Framework einnfach ein zu binden sein soll.<br>
Allgemein werden Alltägliche Funktionen vereinfacht, um sich manch Zeile Code zu sparen.<br>
Für das nächste Update sind Datenbanktechnische Verwendungen von JSON vorgesehen.<br>
Wenn Sie weitere Ideen oder Ergänzungen haben, dann machen Sie dazu gerne ein ISSUE auf.<br>
<br><u><b>Warung:</b> Dieses Framework wurde in PHP 8.1 geschrieben. Es wurde nicht auf höhere PHP Versionen getestet. Wenn Sie dieses Framework in einer anderen PHP Version verwenden, geben Sie gerne Rückmeldung.</u>
<br>

<strong>

Der Ordner ```gbdb_framework``` kann ignoriert werden. In diesem befindet sich der unvollständige Code für die nächste Version
</strong>

<br>

# Einbinden in PHP
1. Laden Sie sich den aktuellen Versionsordner <b>vx.x</b> herunter
2. Legen Sie den Ordner in die Struktur Ihres PHP Projektes
3. Binden Sie das Framework in den .php Dateien über ```<?php include 'path/to/gbdb.inc.php'; ?>``` ein
4. Passen Sie in der Datei ```gbdb.inc.php``` die Variablen an. Es ist alles ausreichend Kommentiert

# Verwendung

## Klasse ```Vars```
In diser Klasse sind alle Variablen, die Sie selber anpassen können.<br>
```__DEV__``` Hier können Sie angeben, ob das Projekt in einer Entwicklungsumgebung oder in der Produktionsumgebung ist. Ist ```true``` angegeben, so werden die Entwicklungsvariablen in den Funktionen verwendet.
<br>

```greenbucket_api_key``` Dort können Sie Ihren API Key der greenbucket API Hinterlegen
<br>

```greenbucket_api_version``` Hier geben Sie die Version der greenbucket API an, welche Sie verwenden wollen.
<br>

```greenbucket_api_url``` Sollte sich die URL der greenbucket API ändern, können Sie diese hier anpassen bzw. ändern.
<br>

```json_path``` Wenn Sie ein bestimmtes Verzeichnis für .json Dateien verwenden wollen, dann können Sie dieses hier hinterlegen. <b><u>WICHTIG:</u></b> Bitte setzen Sie am Ende des paths ein / (Beispiel: "assets/files/json/")
<br>

```sql_server``` Hier können Sie den SQL Server für die produktive Umgebung angeben als IP oder Domain.
<br>

```sql_database``` Hier können Sie die SQL Datenbank angeben, die Sie in der produktiven Umgebung nutzen wollen.
<br>

```sql_user``` Hier geben Sie den SQL Benutzer für die produktive Umgebung an.
<br>

```sql_password``` Hier können Sie das Passwort für den SQL Benutzer der Produktivumgebung angeben.
<br>

```sql_dev_server``` Hier können Sie den SQL Server für die Entwicklungsumgebung angeben als IP oder Domain.
<br>

```sql_dev_database``` Hier können Sie die SQL Datenbank angeben, die Sie in der Entwicklungsumgebung nutzen wollen.
<br>

```sql_dev_user``` Hier geben Sie den SQL Benutzer für die Entwicklungsumgebung an.
<br>

```sql_dev_password``` Hier können Sie das Passwort für den SQL Benutzer der Entwicklungsumgebung angeben.
<br>

```init_cookies``` Hier können Initiale Cookies gesetzt werden. Diese werden gesetzt sobald ein benutzer die Seite zum ersten mal Aufruft. Hierbei wird ein 0-Array Objekt verwendet.<br>
<u>Beispiel:</u><br>
```
array(
    [
        "cookie_name" => "TestCookie", // Cookie Name
        "cookie_value" => "Test1" // Cookie Value
    ],
    [
        "cookie_name" => "Cookie2",
        "cookie_value" => "Test2"
    ], // ...
);
```
<br>

```init_session``` Hier dasselbe wie bei Cookies, nur mit Session Variablen.<br>
<u>Beispiel:</u><br>

```
array(
    [
        "session_name" => "Test Session Variable", // Session Variable Name
        "session_value" => "Test1" // Session variable Value
    ],
    [
        "session_name" => "Test Session Variable 2",
        "session_value" => "Test 2"
    ], // ...
);
```
<br>

```this_file()``` Gibt als String die aktuelle Datei zurück. Beispiel: index.php
<br>

```client_ip()``` gibt die IP Des Seitenbesuchers als String zurück
<br>

## Klasse ```FS```
Diese Klasse dient zur Dateiverwaltung. Sie beinhaltet Funktionen zum Schreiben und Lesen von Dateien.
<br>

## Methoden

### `write_json`

Schreibt JSON-Daten in eine .json-Datei.

```php
public static function write_json(string $file, mixed $data, bool $add = true, bool $pretty = false): bool
```

- `$file`: Pfad zur .json-Datei.
- `$data`: Die JSON-Daten als PHP-Array, die in die Datei geschrieben werden sollen.
- `$add` (optional, Standard: `true`): Gibt an, ob die Daten an die Datei angefügt werden sollen. Bei `false` werden die Daten überschrieben.
- `$pretty` (optional, Standard: `false`): Gibt an, ob die JSON-Daten schön formatiert werden sollen.

### `read_json`

Liest JSON-Daten aus einer .json-Datei heraus und stellt sie PHP-formatiert bereit.

```php
public static function read_json(string $file): mixed
```

- `$file`: Pfad zur .json-Datei.

### `write`

Schreibt normale Dateien.

```php
public static function write(string $file, mixed $data, bool $stream = false, bool $overwrite = false): bool
```

- `$file`: Pfad zur Datei.
- `$data`: Die Daten, die in die Datei geschrieben werden sollen.
- `$stream` (optional, Standard: `false`): Gibt an, ob es sich um einen Filestream handeln soll.
- `$overwrite` (optional, Standard: `false`): Gibt an, ob Daten überschrieben werden sollen oder angehängt werden sollen.

### `read`

Liest Daten aus einer Datei heraus.

```php
public function read(string $file): mixed
```

- `$file`: Pfad zur Datei.

### `deleteDirectory`

Löscht ein Verzeichnis.

```php
public static function deleteDirectory(string $dir): bool
```

- `$dir`: Pfad zum Verzeichnis.

### `getFolderSize`

Gibt die Größe eines Verzeichnisses wieder.

```php
public static function getFolderSize(string $path): string
```

- `$path`: Pfad zum Verzeichnis.

---

Verwenden Sie diese Methoden, um Dateien und Verzeichnisse in PHP zu erstellen, zu lesen, zu schreiben und zu löschen.

<br>

# Klasse ```Ref```

Die `Ref`-Klasse bietet Methoden zum Weiterleiten auf andere Dateien oder Seiten.

## Methoden

### `to`

Leitet auf eine andere Datei/Seite weiter.

```php
public static function to(string $url): void
```

- `$url`: Die URL der Seite oder den Pfad der Datei.

### `this_file`

Lädt die aktuelle Seite neu.

```php
public static function this_file(): void
```

## Beispiel

```php
// Weiterleitung auf eine andere Seite
Ref::to("https://example.com");

// Aktuelle Seite neu laden
Ref::this_file();
```

---

# Klasse ```GetForm```

Die `GetForm`-Klasse bietet Methoden zum Umgang mit Formularen und Datei-Uploads.

## Methoden

### `getDropdown`

Liest ein Dropdown aus und gibt die explizite Auswahl wieder.

```php
public static function getDropdown(mixed $dropdown): mixed
```

- `$dropdown`: Die POST-Variable des Dropdowns (z. B. `$_POST["drop1"]`).

### `upload`

Funktion zum Hochladen von Dateien (Max. 2 MB zugelassen).

```php
public static function upload($file, string $path): bool
```

- `$file`: Die Datei(en) der POST-Methode zum Hochladen.
- `$path`: Der Pfad, wohin die Datei(en) hochgeladen werden sollen.

## Beispiel

```php
// Hochladen einer Datei
if (GetForm::upload($_FILES["fileUpload"], "/path/to/upload")) {
    echo "Datei erfolgreich hochgeladen.";
} else {
    echo "Fehler beim Hochladen der Datei.";
}
```

---

Verwenden Sie diese Klassen und Methoden, um Formulare zu verarbeiten, Dateien hochzuladen und auf andere Seiten weiterzuleiten.

<br>

# Klasse ```Format```

Die `Format`-Klasse bietet Methoden zum Formatieren von Daten und Strings.

## Methoden

### `dateForInput`

Formatiert ein Datum korrekt für ein HTML Input Feld des Typen date.

```php
public static function dateForInput(mixed $date): mixed
```

- `$date`: Das zu formatierende Datum.

### `timeForInput`

Formatiert eine Uhrzeit korrekt für ein HTML Input Feld des Typen time.

```php
public static function timeForInput(mixed $time): mixed
```

- `$time`: Die zu formatierende Zeit.

### `shotString`

Schneidet einen String ab.

```php
public static function shotString(string $string, int $width = 14, int $shortBy = 14): string
```

- `$string`: Der abzuschneidende String.
- `$width` (optional, Standard: 14): Die maximale Länge des Strings.
- `$shortBy` (optional, Standard: 14): Ab welchem Zeichen der String abgeschnitten werden soll.

### `cleanString`

Entfernt alle Charackter aus einem String, die kein Buchstabe und keine Zahl sind

```php
public static function cleanString(string $string): string
```

- `$string`: Der zu modifizierende String

## Beispiel

```php
// Formatierung eines Datums für ein Input-Feld
$inputDate = Format::dateForInput("2024-04-12");
echo $inputDate; // Ausgabe: 2024-04-12

// Formatierung einer Uhrzeit für ein Input-Feld
$inputTime = Format::timeForInput("14:30:00");
echo $inputTime; // Ausgabe: 14:30:00

// Abschneiden eines Strings
$shortString = Format::shotString("Dies ist ein langer Text, der abgeschnitten werden soll.", 20, 15);
echo $shortString; // Ausgabe: Dies ist ein la....

$cleanedString = Format::cleanString("Hallo 123 Welt!#");
echo $cleanedString; // Ausgabe: Hallo123Welt
```

---

# Klasse ```GBAPI```

Die `GBAPI`-Klasse bietet Methoden zum Abrufen von Daten über die GreenBucket API.

## Methoden

### `fetch`

GreenBucket API Fetchen.

```php
public static function fetch(mixed $params): mixed
```

- `$params`: Parameter für den API-Fetch (z. B. `["use" => "id", "id" => 4]`).

## Beispiel

```php
// API-Abruf
$response = GBAPI::fetch(["use" => "id", "id" => 4]);
print_r($response); // Ausgabe: API-Antwort als Array
```

---

Verwenden Sie diese Klassen und Methoden, um Daten zu formatieren und API-Aufrufe durchzuführen.

<br>

# Klasse ```Api```

Die `Api`-Klasse bietet Methoden zum Abrufen von Daten von einer API.

## Methoden

### `fetch`

Ruft Daten von einer API ab.

```php
public static function fetch(string $url, array $headers = [], mixed $body = null): mixed
```

- `$url`: Die URL der API.
- `$headers` (optional): Ein assoziatives Array von Headerinformationen.
- `$body` (optional): Die Daten, die im Request-Body gesendet werden sollen.

## Beispiel

```php
// API-Abruf ohne Header und Body
$response = Api::fetch("https://api.example.com/data");
print_r($response); // Ausgabe: API-Daten als Array oder Objekt

// API-Abruf mit Header und Body
$headers = ["Authorization: Bearer token123", "Content-Type: application/json"];
$body = ["key" => "value"];
$response = Api::fetch("https://api.example.com/data", $headers, $body);
print_r($response); // Ausgabe: API-Daten als Array oder Objekt
```

---

# Klasse ```Hash```

Die `Hash`-Klasse bietet Methoden zum Hashen von Passwörtern und Strings.

## Methoden

### `hashpassword`

Hasht ein Passwort gemäß den Regeln.

```php
public static function hashpassword(string $password): string
```

- `$password`: Das zu hashende Passwort.

### `sha256`

Erstellt einen SHA256-Hash aus einem String.

```php
public static function sha256(string $string): string
```

- `$string`: Der zu hashende String.

### `sha512`

Erstellt einen SHA512-Hash aus einem String.

```php
public static function sha512(string $string): string
```

- `$string`: Der zu hashende String.

### `adler32`

Erstellt einen Adler32-Hash aus einem String.

```php
public static function adler32(string $string): string
```

- `$string`: Der zu hashende String.

### `md5`

Erstellt einen MD5-Hash aus einem String.

```php
public static function md5(string $string): string
```

- `$string`: Der zu hashende String.

### `multiHash`

Erstellt einen verwurzelten Hash aus einem String.

```php
public static function multiHash(string $string): string
```

- `$string`: Der zu hashende String.

## Hinweis

Die Verwendung von `md5` wird nicht empfohlen.

---

Verwenden Sie diese Klassen und Methoden, um Daten von APIs abzurufen und Passwörter sowie Strings zu hashen.

<br>

# Klasse 'SQL'

Die 'SQL'-Klasse bietet Methoden zur Verbindungsherstellung mit einem SQL-Server und zum Senden von SQL-Abfragen.

## Methoden

### 'connect'

Stellt eine Verbindung zum SQL-Server her.

```php
public static function connect(): bool
```

- **Rückgabewert**: `bool` - `true`, wenn die Verbindung erfolgreich hergestellt wurde, andernfalls `false`.

### 'sendSQL'

Sendet eine SQL-Abfrage an den SQL-Server.

```php
public static function sendSQL(string $query): mixed
```

- `$query` (`string`): Die zu sendende SQL-Abfrage.
- **Rückgabewert**: Gemischter Datentyp - Die Antwort des SQL-Servers oder das Ergebnis der SQL-Abfrage.

### 'insert'

Fügt neue Datensätze in eine Tabelle ein.

```php
public static function insert(string $table, array $data): mixed
```

- `$table` (`string`): Name der Tabelle.
- `$data` (`array`): Assoziatives Array mit den Daten zum Einfügen.
- **Rückgabewert**: Gemischter Datentyp - Das Ergebnis des Insert-Befehls.

### 'update'

Aktualisiert vorhandene Datensätze in einer Tabelle.

```php
public static function update(string $table, array $data, string $where, mixed $is): mixed
```

- `$table` (`string`): Name der Tabelle.
- `$data` (`array`): Assoziatives Array mit den neuen Daten.
- `$where` (`string`): Spalte für die Bedingung.
- `$is` (`mixed`): Wert für die Bedingung.
- **Rückgabewert**: Gemischter Datentyp - Das Ergebnis des Update-Befehls.

### 'delete'

Löscht Datensätze aus einer Tabelle.

```php
public static function delete(string $table, string $where, mixed $is): mixed
```

- `$table` (`string`): Name der Tabelle.
- `$where` (`string`): Spalte für die Bedingung.
- `$is` (`mixed`): Wert für die Bedingung.
- **Rückgabewert**: Gemischter Datentyp - Das Ergebnis des Delete-Befehls.

### 'select'

Ruft Datensätze aus einer Tabelle ab.

```php
public static function select(string $table, $select = "*", string $where = "", string $is = ""): mixed
```

- `$table` (`string`): Name der Tabelle.
- `$select` (`string`, optional, Standard Wert: *): Welche Spalten selektiert werden sollen
- `$where` (`string`, optional): Spalte für die Bedingung.
- `$is` (`string`, optional): Wert für die Bedingung.
- **Rückgabewert**: Gemischter Datentyp - Die abgerufenen Daten.

## Eigenschaften

### '$pdo'

PDO SQL-Verbindung.

- **Typ**: `any`
- **Sichtbarkeit**: Öffentlich (public)

---

# Klasse 'Converter'

Die 'Converter'-Klasse bietet Methoden zur Umrechnung von Zahlen und zur Konvertierung von Kommazahlen in Ganzzahlen.

## Methoden

### 'getSumme'

Addiert zwei Kommazahlen.

```php
public static function getSumme(int|float $p, int|float $a): int|float
```

- `$p` (`int|float`): Kommazahl.
- `$a` (`int|float`): Multiplikator.
- **Rückgabewert**: `int|float` - Das Ergebnis der Berechnung.

### 'convertToNumber'

Konvertiert eine Kommazahl in eine Ganzzahl (ohne Aufrundung).

```php
public static function convertToNumber(int|float $x): int
```

- `$x` (`int|float`): Die zu konvertierende Kommazahl.
- **Rückgabewert**: `int` - Die Ganzzahl.

---

Diese Markdown-Dokumentation folgt dem Stil der 'Hash'-Klasse und bietet eine übersichtliche Darstellung der Methoden und Eigenschaften der 'SQL' und 'Converter' Klassen.

<br>

# Klasse 'Time'

Die 'Time'-Klasse bietet Methoden zur Berechnung der vergangenen Zeit seit einem gegebenen Zeitstempel.

## Methoden

### 'timeAgo'

Gibt wieder, wie lange ein Datum mit oder ohne Uhrzeit her ist.

```php
public static function timeAgo(mixed $timestamp): string
```

- `$timestamp` (`mixed`): Der Zeitstempel.
- **Rückgabewert**: `string` - Die Ausgabe, wie lange es her ist.

<br>

# Klasse 'Cookie'

Die 'Cookie'-Klasse bietet Methoden zum Setzen, Hinzufügen, Abrufen, Löschen, Bearbeiten, Vergleichen und Aktualisieren von Cookies im Browser.

## Eigenschaften

### `TIME`

- **Typ**: `int`
- **Beschreibung**: Die Standardhaltbarkeit eines Cookies in Sekunden (24 Stunden).

## Konstanten

### `DUR`

- **Typ**: `int`
- **Beschreibung**: Die Haltbarkeit eines Cookies in Sekunden für die Standarddauer (1 Jahr).

### `THR`

- **Typ**: `int`
- **Beschreibung**: Die Haltbarkeit eines Cookies in Sekunden für einen Monat.

## Methoden

### 'set'

Setzt ein Cookie.

```php
public static function set(string $name, string $value, int $expiration = Cookie::DUR): void
```

- `$name` (`string`): Name des Cookies.
- `$value` (`string`): Inhalt des Cookies.
- `$expiration` (`int`) (Optional, Standard: `Cookie::DUR`): Haltbarkeit des Cookies in Sekunden.

### 'add'

Fügt einen neuen Cookie hinzu, wenn er noch nicht existiert.

```php
public static function add(string $name, string $data): void
```

- `$name` (`string`): Name des Cookies.
- `$data` (`string`): Inhalt des Cookies.

### 'get'

Ruft den Inhalt eines Cookies ab.

```php
public static function get(string $name): mixed
```

- `$name` (`string`): Name des Cookies.
- **Rückgabewert**: Gemischter Datentyp - Der Inhalt des Cookies oder `null`, wenn der Cookie nicht existiert.

### 'delete'

Löscht ein Cookie.

```php
public static function delete(string $name): void
```

- `$name` (`string`): Name des zu löschenden Cookies.

### 'edit'

Bearbeitet ein Cookie.

```php
public static function edit(string $name, string $value): void
```

- `$name` (`string`): Name des zu bearbeitenden Cookies.
- `$value` (`string`): Neuer Inhalt des Cookies.

### 'compare'

Vergleicht den Inhalt eines Cookies mit einem Wert.

```php
public static function compare(string $name, string $value): bool
```

- `$name` (`string`): Name des Cookies.
- `$value` (`string`): Wert, mit dem der Cookie verglichen werden soll.
- **Rückgabewert**: `bool` - `true`, wenn der Cookie den Wert enthält, andernfalls `false`.

### 'refresh'

Aktualisiert die Cookies im Browser.

```php
public static function refresh(): void
```

### 'init'

Initialisiert die Initialcookies.

```php
public static function init(): void
```

---

Dieser Markdown-Code bietet eine übersichtliche Dokumentation der 'Cookie'-Klasse und ihrer Methoden, Eigenschaften und Konstanten.

<br>

# Klasse 'Session'

Die 'Session'-Klasse bietet Methoden zum Arbeiten mit Sessions in PHP.

## Methoden

### 'renew_session'

Erneuert die Session.

```php
public static function renew_session(): void
```

- **Beschreibung**: Erneuert die Session und aktualisiert die Lebensdauer des Cookies.

### 'handler'

Behandelt die Session.

```php
public static function handler(): void
```

- **Beschreibung**: Überprüft und erneuert die Session, falls erforderlich.

### 'init'

Initialisiert die initialen Sessionvariablen.

```php
public static function init(): void
```

- **Beschreibung**: Initialisiert die initialen Sessionvariablen basierend auf den Werten in `Vars::init_session()`.

### 'get'

Gibt den Inhalt einer Sessionvariablen zurück.

```php
public static function get(string $name): mixed
```

- `$name` (`string`): Name der Sessionvariable.
- **Rückgabewert**: Gemischter Datentyp - Inhalt der Sessionvariable oder `null`, falls die Variable nicht existiert.

### 'add_or_edit'

Erstellt oder bearbeitet eine Sessionvariable.

```php
public static function add_or_edit(string $name, mixed $value): void
```

- `$name` (`string`): Name der Sessionvariable.
- `$value` (`mixed`): Inhalt der Sessionvariable.

### 'delete'

Löscht eine Sessionvariable.

```php
public static function delete(string $name): void
```

- `$name` (`string`): Name der zu löschenden Sessionvariable.

---

# Klasse 'Json'

Die 'Json'-Klasse bietet Methoden zum Dekodieren, Kodieren und Verarbeiten von JSON-Daten.

## Methoden

### 'decode'

Dekodiert einen JSON-String in ein PHP-Array oder Objekt.

```php
public static function decode($json, $assoc = false)
```

### 'encode'

Kodiert ein PHP-Array oder Objekt in einen JSON-String.

```php
public static function encode($data)
```

### 'isJson'

Überprüft, ob eine Zeichenkette ein gültiges JSON ist.

```php
public static function isJson($json)
```

### 'loop'

Iteriert über jedes Element eines Arrays oder Objekts und wendet eine Callback-Funktion darauf an.

```php
public static function loop($data, $callback)
```

### 'elementExists'

Überprüft, ob ein bestimmtes Element in einem JSON-Array oder -Objekt existiert.

```php
public static function elementExists($data, $key)
```

### 'getElement'

Ruft die Daten eines bestimmten Elements aus einem JSON-Array oder -Objekt ab, falls es existiert.

```php
public static function getElement($data, $key)
```

---

Diese Markdown-Dokumentation bietet eine übersichtliche Darstellung der 'Session'- und 'Json'-Klassen sowie ihrer Methoden.

<br>

# Klasse ```GBDB```

Die GBDB-Klasse bietet eine einfache Möglichkeit, mit Datenbanken und Tabellen in Form von JSON-Dateien zu interagieren. Sie ermöglicht das Erstellen, Löschen, Bearbeiten und Abrufen von Datenbanken und Tabellen sowie das Einfügen, Löschen und Abrufen von Daten aus Tabellen.

## Konstanten

- `DB_PATH`: Der Pfad zum Verzeichnis, in dem die JSON-Dateien für die Datenbanken gespeichert werden. Diese Konstante wird durch die Methode `Vars::json_path()` und das Unterverzeichnis `'GBDB/'` definiert.

## Methoden

```php
public static function makePath(string $database, string $table): string
```

Diese private statische Methode erstellt den Dateipfad für eine bestimmte Tabelle in einer bestimmten Datenbank. Sie nimmt den Namen der Datenbank und den Namen der Tabelle als Parameter und gibt den entsprechenden Dateipfad zurück.

```php
public static function genID(string $file): int
```

Diese private statische Methode generiert eine neue eindeutige ID für einen Datensatz in einer Tabelle. Sie nimmt den Dateipfad der Tabelle als Parameter und gibt die generierte ID zurück.

```php
public static function ini(string $file): mixed
```

Diese private statische Methode liest die Daten aus einer JSON-Datei und gibt sie als assoziatives Array zurück. Sie nimmt den Dateipfad der JSON-Datei als Parameter.

```php
public static function createDatabase(string $name): bool
```

Diese öffentliche statische Methode erstellt eine neue Datenbank mit dem angegebenen Namen. Sie nimmt den Namen der Datenbank als Parameter und gibt `true` zurück, wenn die Datenbank erfolgreich erstellt wurde, oder `false`, wenn sie bereits existiert.

```php
public static function deleteDatabase(string $name): bool
```

Diese öffentliche statische Methode löscht eine Datenbank mit dem angegebenen Namen. Sie nimmt den Namen der Datenbank als Parameter und gibt `true` zurück, wenn die Datenbank erfolgreich gelöscht wurde, oder `false`, wenn sie nicht existiert.

```php
public static function createTable(string $database, string $table, array $cols): bool
```

Diese öffentliche statische Methode erstellt eine neue Tabelle mit den angegebenen Spalten für die angegebene Datenbank. Sie nimmt den Namen der Datenbank, den Namen der Tabelle und ein Array von Spaltennamen als Parameter und gibt `true` zurück, wenn die Tabelle erfolgreich erstellt wurde, oder `false`, wenn sie bereits existiert.

```php
public static function deleteTable(string $database, string $table): bool
```

Diese öffentliche statische Methode löscht eine Tabelle mit dem angegebenen Namen aus der angegebenen Datenbank. Sie nimmt den Namen der Datenbank und den Namen der Tabelle als Parameter und gibt `true` zurück, wenn die Tabelle erfolgreich gelöscht wurde, oder `false`, wenn sie nicht existiert.

```php
public static function insertData(string $database, string $table, array $data): bool
```

Diese öffentliche statische Methode fügt neue Daten in eine Tabelle ein. Sie nimmt den Namen der Datenbank, den Namen der Tabelle und ein Array von Daten als Parameter und gibt `true` zurück, wenn die Daten erfolgreich eingefügt wurden, oder `false`, wenn ein Fehler aufgetreten ist.

```php
public static function deleteData(string $database, string $table, mixed $where, mixed $is): bool
```

Diese öffentliche statische Methode löscht Daten aus einer Tabelle basierend auf einem bestimmten Kriterium. Sie nimmt den Namen der Datenbank, den Namen der Tabelle, das zu suchende Kriterium und den Wert des Kriteriums als Parameter und gibt `true` zurück, wenn die Daten erfolgreich gelöscht wurden, oder `false`, wenn ein Fehler aufgetreten ist.

```php
public static function editData(string $database, string $table, mixed $where, mixed $is, mixed $newData): bool
```

Diese öffentliche statische Methode bearbeitet vorhandene Daten in einer Tabelle basierend auf einem bestimmten Kriterium. Sie nimmt den Namen der Datenbank, den Namen der Tabelle, das zu suchende Kriterium, den Wert des Kriteriums und die neuen Daten als Parameter und gibt `true` zurück, wenn die Daten erfolgreich bearbeitet wurden, oder `false`, wenn ein Fehler aufgetreten ist.

```php
public static function getData(string $database, string $table, bool $filter = false, mixed $where = "", mixed $is = ""): mixed
```

Diese öffentliche statische Methode ruft Daten aus einer Tabelle ab, optional basierend auf einem bestimmten Kriterium. Sie nimmt den Namen der Datenbank, den Namen der Tabelle und optional ein Kriterium und dessen Wert als Parameter und gibt die abgerufenen Daten als Array zurück.

```php
public static function elementExists(string $database, string $table, mixed $where, mixed $is): bool
```

Diese öffentliche statische Methode überprüft, ob ein Element mit einem bestimmten Kriterium in einer Tabelle existiert. Sie nimmt den Namen der Datenbank, den Namen der Tabelle, das zu suchende Kriterium und den Wert des Kriteriums als Parameter und gibt `true` zurück, wenn das Element existiert, oder `false`, wenn es nicht existiert.

```php
public static function listDBs(): array
```

Diese öffentliche statische Methode gibt alle vorhandene Datenbanken als ein Array von Strings aus ```["DB1", "DB2"]```

```php
public static function listTables(string $database): array
```

Diese öffentliche statische Methode gibt alle vorhandene Tabellen innerhalb einer Datenbank als ein Array von Strings aus ```["Tabelle1", "Tabelle2"]``` Hierbei wird ```$database``` als ```String``` Parameter erwartet.