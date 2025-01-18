<?php
include("conn.php");

if(!isset($_SESSION["uid"])) {
    echo "<p style='color: red;'>Bitte zuerst anmelden!</p>";
    exit();
}
?>
<form method="post">
    <input type="text" name="search" placeholder="Titel" required>
    <button class="btn btn-success" type="submit">Suchen</button>
</form>
<?php
if(isset($_POST["search"])) {
    $sql = "SELECT * FROM books WHERE title LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['%' . $_POST["search"] . '%']);
    $result = $stmt->fetchAll();
    echo "<table class='table table-bordered>'";
    echo "<tr><th>Titel</th><th>Autor</th><th>Seiten</th><th>Sprache</th></tr>";
    foreach($result as $row)
    {
        echo "<tr><td>" . $row["title"] . "</td><td>" . $row["author"] . "</td><td>" . $row["pages"] . "</td><td>" .
        $row["lang"] . "</tr>";
    }
    echo "</table>";
}