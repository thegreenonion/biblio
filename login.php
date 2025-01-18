<br>
<br>
<form method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button class="btn btn-success" type="submit">Login</button>
</form>

<?php
include("conn.php");
if(isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM user WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $password]);
    if($stmt->rowCount() > 0) {
        $_SESSION["uid"] = $stmt->fetch()["uid"];
        $_SESSION["uname"] = $username;
        echo "<script>window.location.href='main.php';</script>";
    }
    else {
        echo "Benutzername oder Password falsch!";
    }
}
?>