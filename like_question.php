<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "freshersday";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$questionId = $_POST['questionId'];
$userIp = $_SERVER['REMOTE_ADDR'];

// Check if the user has already liked this question
$checkLike = $conn->prepare("SELECT * FROM likes WHERE question_id = ? AND user_ip = ?");
$checkLike->bind_param("is", $questionId, $userIp);
$checkLike->execute();
$checkLike->store_result();

if ($checkLike->num_rows == 0) {
    // User hasn't liked this question yet, so we can add a like
    $conn->query("UPDATE questions SET likes = likes + 1 WHERE id = $questionId");

    $addLike = $conn->prepare("INSERT INTO likes (question_id, user_ip) VALUES (?, ?)");
    $addLike->bind_param("is", $questionId, $userIp);
    $addLike->execute();
    $addLike->close();
}

$checkLike->close();
$conn->close();
?>
