<?php
include("vars/creds.php");
$conn = new PDO("mysql:host=localhost;dbname=$dbname", $dbuser, $dbpass);
