<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hauptseite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            margin-left: 10px;
        }
        h1 {
            margin-top: 5px;
        }
        ml {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <a href="main.php" style="color: black;">
        <h1>biblio Bibliothek-Verwaltungsprogramm</h1>
    </a>
    <div style="margin-left: 10px;">
        <?php
        if(!isset($_SESSION["uid"])) {
            echo "<a href='main.php?action=login'>Anmelden</a><br>";
        }
        else {
            echo "<span style='color: green;'>Angemeldet als: " . $_SESSION["uname"] . "</span><br>";
            echo "<a href='main.php?action=logout'>Logout</a><br><br>";
        }

        if(isset($_GET["action"])) {
            switch($_GET["action"]) {
                case "":
                    break;
                case "login":
                    include("control/login.php");
                    break;
                case "logout":
                    include("control/logout.php");
                    break;
                case "list":
                    echo "<h2>Alle Bücher</h2>";
                    include("control/listBooks.php");
                    break;
            }
        }
        ?>
    </div>
</body>
</html>