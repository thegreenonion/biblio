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
    <h1>
        <span>
            <a href="main.php" style="color: black;">biblio Bibliothek-Verwaltungsprogramm</a>
        </span>
        <span style="text-align: right; float: right; margin-right: 10px;">
            <a href="help.php" style="color: black;">Hilfe</a>
        </span>
    </h1>
    <div style="margin-left: 10px;">
        <?php
        if(!isset($_SESSION["uid"])) {
            echo "<a href='main.php?action=login'>Anmelden</a><br>";
            echo "<a href='main.php?action=signup'>Registrieren als Nutzer</a>";
        }
        else {
            echo "<span style='color: green;'>Angemeldet als: " . $_SESSION["uname"] . "</span><br>";
            echo "<button class='btn btn-danger' onclick='logout()'>Abmelden</button><br><br>";
            echo "<button class='btn btn-primary' onclick=list()>Alle Bücher</button>";
            echo "<button style='margin-left: 20px' class='btn btn-primary' onclick=search()>Nach Buch suchen</button><br><br>";
            echo "<button class='btn btn-primary' onclick='window.location.href=\"main.php?action=listownl\"'>Meine Ausleihen</button> <br><br>";
            if($_SESSION["power"] <= 1) {
                echo "<button class='btn btn-primary' onclick=add()>Buch hinzufügen</button>";
                echo "<button style='margin-left: 20px' class='btn btn-primary' onclick=addc()>Exemplar hinzufügen</button><br><br>";
                echo "<button class='btn btn-primary' onclick='window.location.href=\"main.php?action=listl\"'>Alle Ausleihen</button>";
                echo "<button style='margin-left: 20px' class='btn btn-primary' onclick='window.location.href=\"main.php?action=listol\"'>Offene Ausleihen</button><br><br>";
            }

        }

        if(isset($_GET["action"])) {
            echo "<div style='border: 1px solid black; padding: 10px; margin-right: 10px;'>";
            switch($_GET["action"]) {
                case "":
                    break;
                case "login":
                    include("control/login.php");
                    break;
                case "logout":
                    include("control/logout.php");
                    break;
                case "signup":
                    include("control/signup.php");
                    break;
            }
            if(isset($_SESSION["uid"])) {
                switch($_GET["action"]) {
                    case "list":
                        echo "<h2>Alle Bücher</h2>";
                        include("control/listBooks.php");
                        break;
                    case "addb":
                        echo "<h2>Buch zu Bestand hinzufügen</h2>";
                        include("control/addBook.php");
                        break;
                    case "search":
                        echo "<h2>Buch suchen</h2>";
                        include("control/searchBook.php");
                        break;
                    case "addc":
                        echo "<h2>Exemplar hinzufügen</h2>";
                        include("control/addCopy.php");
                        break;
                    case "addl":
                        echo "<h2>Ausleihen</h2>";
                        $_SESSION["bid"] = $_GET["bid"];
                        include("control/addLoan.php");
                        break;
                    case "listl":
                        echo "<h2>Alle Ausleihen:</h2>";
                        $_SESSION["a"] = "all";
                        include("control/viewLoans.php");
                        break;
                    case "listol":
                        echo "<h2>Offene Ausleihen:</h2>";
                        $_SESSION["a"] = "open";
                        include("control/viewLoans.php");
                        break;
                    case "listownl":
                        echo "<h2>Meine Ausleihen:</h2>";
                        $_SESSION["a"] = "own";
                        include("control/viewLoans.php");
                        break;
                }
            }
            echo "</div>";
        }
        ?>
    </div>

    <script>
        function list() {
            window.location.href = "main.php?action=list";
        }
        function add() {
            window.location.href = "main.php?action=addb";
        }
        function logout() {
            window.location.href = "main.php?action=logout";
        }
        function search() {
            window.location.href = "main.php?action=search";
        }
        function addc() {
            window.location.href = "main.php?action=addc";
        }
    </script>

    <?php

    ?>
</body>
</html>