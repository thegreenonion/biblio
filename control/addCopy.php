<?php
include("conn.php");
if(!isset($_SESSION["uid"])) {
    echo "<p style='color: red;'>Bitte zuerst anmelden!</p>";
    exit();
}
if(!($_SESSION["power"] <= 1)) {
    echo "<p style='color: red;'>Vorgang nicht gestattet!</p>";
    exit();
}
echo "<form method='post'>";
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
echo "<select name='bid' required>";
foreach($result as $row) {
    echo "<option value='" . $row["bid"] . "'>" . $row["title"] . "</option>";
}
echo "</select>";
echo "<input type='date' name='date' required>";
echo "<button class='btn btn-success' type='submit'>Exemplar hinzufügen</button>";
echo "</form>";

if(isset($_POST["bid"]) && isset($_POST["date"])) {
    $bid = htmlspecialchars($_POST["bid"]);
    $date = htmlspecialchars($_POST["date"]);
    $sql = "INSERT INTO copy (bid, buydate, avail) VALUES (?,?,1)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$bid, $date]);
    echo "<p style='color: green;'>Exemplar hinzugefügt!</p>";
}