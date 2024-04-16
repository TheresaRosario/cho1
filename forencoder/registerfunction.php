<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "choinventory";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$username = $_POST['username'];

$password = $_POST['password'];


$sql = "INSERT INTO account (username, password) VALUES ('$username',  '$password')";

if ($conn->query($sql) === TRUE) {
 
    header("Location: register.php?message=success");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>
