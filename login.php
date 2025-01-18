<br>
<br>
<form method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button class="btn btn-success" type="submit">Login</button>
</form>

<?php
if(isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if($username == "admin" && $password == "admin") {
        echo "Login successful!";
    } else {
        echo "Login failed!";
    }
}
?>