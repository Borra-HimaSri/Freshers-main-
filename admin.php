<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Answer Questions</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Admin - Answer Questions</h1>
        <form id="answerForm">
            <label for="questionId">Select Question:</label>
            <select id="questionId" name="questionId" required>
                <option value="">Select a question</option>
                <?php
                $conn = new mysqli("localhost", "root", "", "freshersday");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $result = $conn->query("SELECT q.id, q.question, a.id AS answer_id 
                                        FROM questions q
                                        LEFT JOIN answers a ON q.id = a.question_id
                                        ORDER BY a.id IS NULL DESC, q.created_at DESC");
                $count = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $answered = $row['answer_id'] ? "✓" : "";
                        echo "<option value='{$row['id']}'>Q{$count}: {$row['question']} $answered</option>";
                        $count++;
                    }
                } else {
                    echo "<option value=''>No questions available</option>";
                }

                $conn->close();
                ?>
            </select>
            <textarea id="answer" name="answer" placeholder="Provide your answer here..." required></textarea>
            <button type="submit">Submit Answer</button>
        </form>
    </div>

    <script>
        document.getElementById('answerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const questionId = document.getElementById('questionId').value;
            const answer = document.getElementById('answer').value;

            fetch('submit_answer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    questionId: questionId,
                    answer: answer
                })
            }).then(response => response.text())
              .then(data => {
                  alert(data);
                  document.getElementById('answerForm').reset();
                  location.reload();
              });
        });
    </script>
</body>
</html>
