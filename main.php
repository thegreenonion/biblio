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
    </style>
</head>
<body>
    <a href="main.php" style="color: black;">
        <h1>biblio Bibliothek-Verwaltungsprogramm</h1>
    </a>
    <a href="main.php?action=login">Anmelden</a>
    <?php
    if(isset($_GET["action"])) {
        switch($_GET["action"]) {
            case "login":
                include("login.php");
                break;
            case "":
                break;
        }
    }
    ?>
</body>
</html>