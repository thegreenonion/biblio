<?php
if(!isset($_SESSION["uid"])) {
    echo "<p style='color: red;'>Bitte zuerst anmelden!</p>";
    exit();
}

function allLoans() {
    if(!($_SESSION["power"] <= 1)) {
        echo "<p style='color: red;'>Vorgang nicht gestattet!</p>";
        exit();
    }
    include("conn.php");

    $sql = "SELECT * FROM loans INNER JOIN copy ON copy.cid = loans.lcid
    INNER JOIN books ON books.bid = copy.bid 
    INNER JOIN user ON user.uid = loans.luid ORDER BY user.uid";
    $result = $conn->query($sql);
    echo "<table class='table table-striped'>";
    echo "<tr><th>Benutzer</th><th>Buch</th><th>Ausleihdatum</th><th>Rückgabedatum</th><th>Zurückgegeben</th></tr>";
    foreach($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["start"] . "</td>";
        echo "<td>" . $row["stop"] . "</td>";
        echo "<td>" . ($row["returned"] == 1 ? "Ja" : "Nein") . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
function openLoans() {
    if(!($_SESSION["power"] <= 1)) {
        echo "<p style='color: red;'>Vorgang nicht gestattet!</p>";
        exit();
    }
    include("conn.php");

    $sql = "SELECT * FROM loans INNER JOIN copy ON copy.cid = loans.lcid
    INNER JOIN books ON books.bid = copy.bid 
    INNER JOIN user ON user.uid = loans.luid WHERE returned = 0 ORDER BY stop DESC";
    $result = $conn->query($sql);
    echo "<table class='table table-striped'>";
    echo "<tr><th>Benutzer</th><th>Buch</th><th>Ausleihdatum</th><th>Rückgabedatum</th><th>Zurückgegeben</th>
    <th>Aktion</th></tr>";
    foreach($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["start"] . "</td>";
        echo "<td>" . $row["stop"] . "</td>";
        echo "<td>" . ($row["returned"] == 1 ? "Ja" : "Nein") . "</td>";
        echo "<td><form method='post'><input type='hidden' name='lid' value='" . $row["lid"] . "'>
        <input type='submit' class='btn btn-success' value='Rücknahme bestätigen'></form></td>";
        echo "</tr>";
    }
    echo "</table>";
}

function ownLoans() {
    include("conn.php");

    $sql = "SELECT * FROM loans INNER JOIN copy ON copy.cid = loans.lcid
    INNER JOIN books ON books.bid = copy.bid 
    INNER JOIN user ON user.uid = loans.luid WHERE returned = 0
    AND user.uid = ?
    ORDER BY stop DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_SESSION["uid"]]);
    $result = $stmt->fetchAll();
    if($stmt->rowCount() == 0) {
        echo "<p>Sie haben keine offenen Ausleihen.</p>";
        return;
    }
    echo "<table class='table table-striped'>";
    echo "<tr><th>Benutzer</th><th>Buch</th><th>Ausleihdatum</th><th>Rückgabedatum</th><th>Zurückgegeben</th></tr>";
    foreach($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["start"] . "</td>";
        echo "<td>" . $row["stop"] . "</td>";
        echo "<td>" . ($row["returned"] == 1 ? "Ja" : "Nein") . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>
    <p>
        <span style='color: red;'>Hinweis: </span>
        Um ein Buch zurückzugeben, sprechen Sie bitte mit einem Mitarbeiter vor Ort!
    </p>";
}

if($_SESSION["a"] == "all") {
    allLoans();
    $_SESSION["a"] = null;
}
else if($_SESSION["a"] == "open") {
    openLoans();
    $_SESSION["a"] = null;
}
else if($_SESSION["a"] == "own") {
    ownLoans();
    $_SESSION["a"] = null;
}

if(isset($_POST["lid"])) {
    include("conn.php");
    if($_SESSION["power"] > 1) {
        echo "<p style='color: red;'>Vorgang nicht gestattet!</p>";
        exit();
    }
    $sql = "UPDATE loans SET returned = 1 WHERE lid = ?;
    UPDATE copy SET avail = 1 WHERE cid = (SELECT lcid FROM loans WHERE lid = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST["lid"], $_POST["lid"]]);
    $_SESSION["a"] = "open";
    echo "<script>window.location.href='main.php?action=listol';</script>";
    echo "<p style='color: green;'>Rücknahme bestätigt!</p>";
}