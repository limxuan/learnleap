<?php
include_once 'database.php';
session_start();
if (isset($_GET['quiz_id'])) {
    $quizId = $_GET['quiz_id'];  // Access the 'id' query parameter
    $lecturerId = $_SESSION['lecturer_id'];
    $quiz = Database::getQuizById($quizId, $lecturerId);
    if (!$quiz) {
        echo "Quiz not found.";
        exit();
    }
    $questions = Database::getQuestionsForQuiz($quizId);
} else {
    header("Location: login-register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>My Web Page</title>
        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/components.css">
        <link rel="stylesheet" href="css/edit-quiz.css">
    </head>

    <body>
        <?php include "navbar.php" ?>
        <div class="content">
            <div class="quiz-info-container">
                <p class="quiz-title"><?php echo $quiz['quiz_name'] ?></p>
                <p class="quiz-sub-title"><?php echo count($questions) ?> questions created</p>
            </div>
            <div class="questions-container">
                <div class="questions-header">
                    <p class="question-text">Questions</p>
                    <div class="questions-actions">
                        <div class="action-container">
                            <span class="tooltip-text">Toggle view answers</span>
                            <img style="cursor: pointer;" class="tooltip-trigger" id="reveal-icon" src="assets/reveal-icon.svg" alt="Toggle Answers">
                        </div>
                        <div class="action-container">
                            <span class="tooltip-text">Add a<br>question</span>
                            <img class="add-question-icon tooltip-trigger" src="assets/add-question-icon.svg" alt="Add Question">
                        </div>
                    </div>
                </div>
                <div class="questions-list-container">
                    <?php
                    foreach ($questions as $question) {
                        echo '<div class="question-section">
                            <div class="answer-section">
                                <p style="display: none;" class="answer-section-question-text">Question:</p>
                                <p>' . htmlspecialchars($question['question_text']) . '</p>
                            </div>
                            <hr class="form-divider" style="display: none;"/>
                            
                            <div class="answer-section answer-container" style="display: none;">
                                <p style="color: green">Correct answer: </p>
                                <p style="color: black">' . htmlspecialchars($question['correct_answers']) . '</p>
                            </div>';

                        // If there are wrong answers, display them
                        if (!empty($question['wrong_answers'])) {
                            echo '<hr class="form-divider" style="display: none;"/>';

                            $wrongAnswers = explode(';', $question['wrong_answers']);
                            echo '<div class="answer-section answer-container" style="display: none;">
                                    <p style="color: red">Wrong answers: </p>';
                            foreach ($wrongAnswers as $wrongAnswer) {
                                echo '<p style="color: black">' . htmlspecialchars(trim($wrongAnswer)) . '</p>';
                            }
                            echo '</div>';
                        }

                        echo '</div>';
                    }
?>
                </div>
            </div>
        </div>

        <script>
        // Add event listener for the reveal icon
        const revealIcon = document.getElementById('reveal-icon');
        const answerContainers = document.querySelectorAll('.answer-container');
        const hrDividers = document.querySelectorAll('.form-divider');
        const questionTexts = document.querySelectorAll('.answer-section-question-text');

        revealIcon.addEventListener('click', () => {
            // Toggle visibility of all answer containers
            answerContainers.forEach(container => {
                if (container.style.display === 'none' || container.style.display === '') {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            });

            hrDividers.forEach(divider => {
                if (divider.style.display === 'none' || divider.style.display === '') {
                    divider.style.display = 'block';
                } else {
                    divider.style.display = 'none';
                }
            })

            questionTexts.forEach(text => {
                if (text.style.display === 'none' || text.style.display === '') {
                    text.style.display = 'block'
                } else {
                    text.style.display = 'none'                    
                } 
            })
        });

        const addQuestionIcon = document.querySelector('.add-question-icon');
        addQuestionIcon.addEventListener('click', () => {
            window.location.href = 'create-question.php?quiz_id=' + <?php echo $quizId; ?>;
        });
        </script>
    </body>
</html>
