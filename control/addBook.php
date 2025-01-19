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
    <input type="text" name="lang" placeholder="Sprache (Code)" required>
    <button class="btn btn-success" type="submit">Buch hinzufügen</button>
</form>
<?php
include("conn.php");
if(isset($_POST["title"]) && isset($_POST["author"]) && isset($_POST["pages"])) {
    $title = htmlspecialchars($_POST["title"]);
    $author = htmlspecialchars($_POST["author"]);
    $pages = htmlspecialchars($_POST["pages"]);
    $lang = htmlspecialchars($_POST["lang"]);
    $sql = "INSERT INTO books (title, author, pages, lang) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$title, $author, $pages, $lang]);
}
?>