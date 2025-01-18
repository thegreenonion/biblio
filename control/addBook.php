<?php
if(!isset($_SESSION["uid"])) {
    echo "<p style='color: red;'>Bitte zuerst anmelden!</p>";
    exit();
}
if(!($_SESSION["power"] <= 1)) {
    echo "<p style='color: red;'>Vorgang nicht gestattet!</p>";
    exit();
}
?>
<form method="post">
    <input type="text" name="title" placeholder="Titel" required>
    <input type="text" name="author" placeholder="Autor" required>
    <input type="number" name="pages" placeholder="Seiten" required>
    <button class="btn btn-success" type="submit">Buch hinzufügen</button>
</form>
<?php
include("conn.php");
if(isset($_POST["title"]) && isset($_POST["author"]) && isset($_POST["pages"])) {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $pages = $_POST["pages"];
    $sql = "INSERT INTO books (title, author, pages) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$title, $author, $pages]);
}
?>