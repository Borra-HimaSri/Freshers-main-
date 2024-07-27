<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "freshersday";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $questionId = $conn->real_escape_string($_POST['questionId']);
    $answer = $conn->real_escape_string($_POST['answer']);
    
    // Check if the question already has an answer
    $result = $conn->query("SELECT * FROM answers WHERE question_id = $questionId");
    if ($result->num_rows > 0) {
        $sql = "UPDATE answers SET answer = '$answer' WHERE question_id = $questionId";
    } else {
        $sql = "INSERT INTO answers (question_id, answer) VALUES ($questionId, '$answer')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Answer submitted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
