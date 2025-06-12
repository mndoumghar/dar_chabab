<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "dar_chabab";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Error Connexion " . $conn->connect_error);
}
?>
