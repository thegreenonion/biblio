<?php
include("conn.php");
if(!isset($_SESSION["uid"])) {
    echo "<p style='color: red;'>Bitte zuerst anmelden!</p>";
    exit();
}

$sql = "SELECT * FROM books";
$result = $conn->query($sql);
echo "<table class='table table-bordered>'";
echo "<tr><th>Titel</th><th>Autor</th><th>Seiten</th></tr>";
foreach($result as $row)
{
    echo "<tr><td>" . $row["title"] . "</td><td>" . $row["author"] . "</td><td>" . $row["pages"] . "</td></tr>";
}
echo "</table>";