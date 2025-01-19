<?php
include("conn.php");
if(!isset($_SESSION["uid"])) {
    echo "<p style='color: red;'>Bitte zuerst anmelden!</p>";
    exit();
}
$sql = "SELECT * FROM copy WHERE bid = ? AND avail = 1";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION["bid"]]);
if($stmt->rowCount() == 0) {
    echo "<p style='color: red;'>Alle Bücher bereits verliehen!</p>";
    exit();
}

$sql = "SELECT * FROM books WHERE bid = ?";
$stmt2 = $conn->prepare($sql);
$stmt2->execute([$_SESSION["bid"]]);
$row = $stmt2->fetch();

echo "<h2>Titel: " . $row["title"] . "</h2>";
echo "<h2>Aktuell Verfügbar: " . $stmt->rowCount() . "</h2>";
echo "<h3>Ausleihen bis: " . date("d.m.Y", strtotime("+14 days")) . "</h3>";
echo "<form method='post'>";
echo "<input type='hidden' name='cid' value='" . $stmt->fetchAll()[0]["cid"] . "'>";
echo "<button class='btn btn-success' type='submit'>Ausleihen</button>";
echo "</form>";

if(isset($_POST["cid"])) {
    $sql = "INSERT INTO loans (luid, lcid, start, stop) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_SESSION["uid"], $_POST["cid"], date("Y-m-d"), date("Y-m-d", strtotime("+14 days"))]);
    $sql = "UPDATE copy SET avail = 0 WHERE cid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST["cid"]]);
    echo "<p style='color: green;'>Buch ausgeliehen!</p>";
    $_SESSION["bid"] = null;
    echo "<script>alert('Buch ausgeliehen!');window.location.href='main.php?action=list';</script>";
}