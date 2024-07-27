<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "freshersday";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$questionId = $_GET['questionId'];
$userIp = $_SERVER['REMOTE_ADDR'];

$checkLike = $conn->prepare("SELECT * FROM likes WHERE question_id = ? AND user_ip = ?");
$checkLike->bind_param("is", $questionId, $userIp);
$checkLike->execute();
$checkLike->store_result();

$response = [];
$response['liked'] = $checkLike->num_rows > 0;

echo json_encode($response);

$checkLike->close();
$conn->close();
?>
