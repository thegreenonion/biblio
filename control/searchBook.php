<?php
include("conn.php");

if(!isset($_SESSION["uid"])) {
    echo "<p style='color: red;'>Bitte zuerst anmelden!</p>";
    exit();
}

if(isset($_POST["search"])) {
    $sql = "SELECT * FROM books WHERE title LIKE '%?%'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST["search"]]);
    echo "<table class='table table-bordered>'";
    echo "<tr><th>Titel</th><th>Autor</th><th>Seiten</th><th>Sprache</th></tr>";
    foreach($stmt as $row)
    {
        echo "<tr><td>" . $row["title"] . "</td><td>" . $row["author"] . "</td><td>" . $row["pages"] . "</td><td>" .
        $row["lang"] . "</tr>";
    }
}