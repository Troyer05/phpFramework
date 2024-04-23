<?php include '../../gbdb.php'; ?>
<html>
    <head>
        <title>GBDB UI</title>
        <style>
            * {
                font-family: Arial;
            }

            textarea {
                font-family: Courier;
                color: #0000ff;
            }
        </style>
    </head>
    <body>
        <center>
            <h1>
                <u>Eine Simple Weboberfl&auml;che zur Verwendung der GBDB - Query Version</u>
                <br>
                <u>GreenQL v1.0</u>
            </h1>
        </center>
        <br>
        <form method="post" action="execute.php">
            <textarea name="query" cols="160" rows="30"># macht dasselbe wie GBDB::createDatabase("Test");
create database "Test";

# Macht dasselbe wie GBDB::createTable("Test", "tabelle01", ["name", "notiz", "datum"]);
create table "tabelle01" in "Test" ("name", "notiz", "datum");

# Eine Select Abfrage wie bei GBDB::getData("Test", "tabelle01");
select all from "tabelle01" in "Test"

# Bald kommt noch INSERT und anderweitige Querys dazu
</textarea>
            <br>
            <input type="checkbox" name="debug" checked> Debug Mode
            <button type="submit">Ausführen</button>
        </form>
    </body>
</html>
