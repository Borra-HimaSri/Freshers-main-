document.addEventListener('DOMContentLoaded', () => {
    // Function to load the best question
    function loadBestQuestion() {
        fetch('get_best_question.php')
            .then(response => response.json())
            .then(data => {
                const bestQuestionContent = document.getElementById('best-question-content');
                bestQuestionContent.innerHTML = '';

                if (data) {
                    bestQuestionContent.innerHTML = `
                        <div class="qa-item">
                            <p><strong>Q1: </strong>${data.question}</p>
                            <p><strong>Asked by:</strong> ${data.name}</p>
                            <p><strong>Likes:</strong> ${data.likes}</p>
                        </div>
                    `;
                }
            });
    }

    // Function to load questions and answers
    function loadQA() {
        fetch('get_qa.php')
            .then(response => response.json())
            .then(data => {
                const qaList = document.getElementById('qa-list');
                qaList.innerHTML = '';

                data.forEach((item) => {
                    qaList.innerHTML += `
                        <div class="qa-item">
                            <p><strong>Q${item.number}: </strong>${item.question}</p>
                            <p><strong>Asked by:</strong> ${item.name}</p>
                            <p><strong>Answer:</strong> ${item.answer || 'No answer yet'}</p>
                            <p>
                                <strong>Likes:</strong> <span id="likes-${item.id}">${item.likes}</span>
                                <button class="like-button ${item.liked ? 'liked' : ''}" data-id="${item.id}">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </p>
                        </div>
                    `;
                });

                // Add event listeners to like buttons
                document.querySelectorAll('.like-button').forEach(button => {
                    button.addEventListener('click', () => {
                        const questionId = button.getAttribute('data-id');
                        fetch('like_question.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: new URLSearchParams({ questionId: questionId })
                        }).then(response => response.text())
                          .then(() => {
                              const likesSpan = document.getElementById(`likes-${questionId}`);
                              likesSpan.textContent = parseInt(likesSpan.textContent) + 1;
                              button.classList.add('liked');
                              button.disabled = true; // Disable the button after liking
                          });
                    });
                });

                // Disable like buttons for already liked questions
                document.querySelectorAll('.like-button').forEach(button => {
                    const questionId = button.getAttribute('data-id');
                    fetch(`check_like.php?questionId=${questionId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.liked) {
                                button.classList.add('liked');
                                button.disabled = true; // Disable if already liked
                            }
                        });
                });
            });
    }

    loadBestQuestion(); // Load the best question first
    loadQA(); // Load the rest of the questions

    // Handle question submission
    const questionForm = document.getElementById('questionForm');
    if (questionForm) {
        questionForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = document.getElementById('name').value;
            const question = document.getElementById('question').value;
            fetch('submit_question.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ name: name, question: question })
            }).then(() => {
                loadQA();
                loadBestQuestion();
                questionForm.reset();
            });
        });
    }
});
