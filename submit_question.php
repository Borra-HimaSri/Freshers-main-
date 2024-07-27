<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "freshersday";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$question = $_POST['question'];

$stmt = $conn->prepare("INSERT INTO questions (name, question) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $question);
$stmt->execute();

$stmt->close();
$conn->close();
?>
