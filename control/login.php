<h1>Anmeldung: </h1>
<br>
<br>
<form method="post">
    <input type="text" name="username" placeholder="Benutzername" required>
    <input type="password" name="password" placeholder="Passwort" required>
    <button class="btn btn-success" type="submit">Login</button>
</form>

<?php
include("conn.php");
if(isset($_POST["username"]) && isset($_POST["password"])) {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $sql = "SELECT * FROM user WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $password]);
    if($stmt->rowCount() > 0) {
        $result = $stmt->fetch();
        $_SESSION["uid"] = $result["uid"];
        $_SESSION["uname"] = $username;
        $_SESSION["power"] = $result["power"];
        echo "<script>window.location.href='main.php';</script>";
    }
    else {
        echo "Benutzername oder Password falsch!";
    }
}
?>