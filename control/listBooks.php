<?php
include("conn.php");
if(!isset($_SESSION["uid"])) {
    echo "<p style='color: red;'>Bitte zuerst anmelden!</p>";
    exit();
}

$sql = "SELECT * FROM books";
$result = $conn->query($sql);
$sql = "SELECT COUNT(*) as anzahl FROM copy WHERE bid = ? AND avail = 1";
echo "<table class='table table-bordered>'";
echo "<tr><th>Titel</th><th>Autor</th><th>Seiten</th><th>Sprache</th><th>Verfügbare Exemplare</th></tr>";
foreach($result as $row)
{
    $stmt = $conn->prepare($sql);
    $stmt->execute([$row["bid"]]);
    echo "<tr><td>" . $row["title"] . "</td><td>" . $row["author"] . "</td><td>" . $row["pages"] . "</td><td>" .
    $row["lang"] . "</td><td>" . $stmt->fetch()["anzahl"] . "</td></tr>";
}
echo "</table>";