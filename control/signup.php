<form method="post">
    <input type="text" name="username" placeholder="Benutzername" required><br>
    <input style="margin-top: 5px;" type="password" name="password" placeholder="Passwort" required><br>
    <input style="margin-top: 5px;" type="password" name="password2" placeholder="Passwort wiederholen" required><br>
    <button class="btn btn-success" type="submit">Registrieren</button>
</form>

<?php
include "conn.php";
if(isset($_POST["username"]) && isset($_POST["password"]))
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    if($password != $password2)
    {
        echo "<p style='color: red;'>Passwörter stimmen nicht überein!</p>";
        exit();
    }
    $sql = "SELECT username FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    if($stmt->rowCount() > 0)
    {
        echo "<p style='color: red;'>Benutzername bereits vergeben!</p>";
    }
    else
    {
        $sql = "INSERT INTO user (username, password, power) VALUES (?,?,2)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $password]);
        echo "<script>alert('Registrierung erfolgreich!');window.location.href='main.php?action=login';</script>";
    }
}