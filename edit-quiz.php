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
    header("Location: login.php");
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
                            <span class="tooltip-text">Add a<br>question</span>
                            <img class="add-question-icon tooltip-trigger" src="assets/add-question-icon.svg" alt="Add Question">
                        </div>
                    </div>
                </div
                
            </div>
        </div>
        <script>
            const addQuestionIcon = document.querySelector('.add-question-icon');
            addQuestionIcon.addEventListener('click', () => {
                window.location.href = 'create-question.php?quiz_id=' + <?php echo $quizId; ?>;
            });
        </script>
    </body>
</html>
