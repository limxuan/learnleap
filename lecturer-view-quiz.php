<?php
session_start();
include_once "database.php";
$lecturerId = $_SESSION['lecturer_id'];

// Fetch quizzes for the current lecturer
$quizzes = Database::getLecturerQuizzes($lecturerId);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Quizzes</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/edit-quiz.css">
    <link rel="stylesheet" href="css/lecturer-view-quiz.css">
  </head>
  <body>
    <?php include "navbar.php"; ?>

    <div class="content">
      <div class="quiz-info-container">
        <p class="quiz-title">My Quizzes</p>
        <p class="quiz-sub-title"><?php echo count($quizzes); ?> quizzes created</p>
      </div>
      <div class="questions-container">
        <div class="questions-header">
          <p class="question-text">Quizzes</p>
          <div class="action-container">
            <span class="tooltip-text">Add a<br>quiz</span>
            <img class="add-question-icon tooltip-trigger" src="assets/add-question-icon.svg" alt="Add Question">
          </div>
          <span class="tooltip-text">Add a new quiz</span>
        </div>
        <div class="questions-list-container">
          <?php
          if (!empty($quizzes)) {
              foreach ($quizzes as $quiz) {
                  echo '<div class="quiz-section">
          <div class="answer-section title">
          <p><strong>' . htmlspecialchars($quiz['quiz_name']) . '</strong></p>
          <a href="edit-quiz.php?quiz_id=' . $quiz['quiz_id'] . '" class="edit-quiz-link"><img src="assets/edit-icon.svg" alt="Edit"></a>
          </div>
          <hr class="form-divider"/>

          <div class="answer-section answer-container">
          <p>Description: ' . htmlspecialchars($quiz['description']) . '</p>
          <p>Created at: ' . htmlspecialchars($quiz['quiz_created_at']) . '</p>
          </div>
          </div>';
              }
          } else {
              echo "<p>No quizzes found.</p>";
          }
?>
        </div>
      </div>
    </div>

    <script>
    const addQuestionIcon = document.querySelector('.add-question-icon');
    addQuestionIcon.addEventListener('click', () => {
      window.location.href = 'create-quiz.php';
    })
    </script>
  </body>
</html>
