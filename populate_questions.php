<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "freshersday";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, question FROM questions";
$result = $conn->query($sql);

$options = '';
while($row = $result->fetch_assoc()) {
    $options .= "<option value='{$row['id']}'>{$row['question']}</option>";
}

echo $options;

$conn->close();
?>
