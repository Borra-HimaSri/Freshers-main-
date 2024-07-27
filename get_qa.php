<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "freshersday";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT q.id, q.name, q.question, a.answer, q.likes
        FROM questions q
        LEFT JOIN answers a ON q.id = a.question_id
        ORDER BY a.id IS NOT NULL DESC, q.created_at DESC";

$result = $conn->query($sql);

$qa = [];
$count = 1;
while($row = $result->fetch_assoc()) {
    $row['number'] = $count++;
    $qa[] = $row;
}

echo json_encode($qa);

$conn->close();
?>
