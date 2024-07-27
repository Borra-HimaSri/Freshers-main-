<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "freshersday";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT q.id, q.name, q.question, q.likes
        FROM questions q
        ORDER BY q.likes DESC
        LIMIT 1";

$result = $conn->query($sql);

$bestQuestion = $result->fetch_assoc();

echo json_encode($bestQuestion);

$conn->close();
?>
