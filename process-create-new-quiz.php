<?php

session_start();

require_once 'database.php';
require_once 'utils.php';

if (isset($_POST['quiz-name']) && isset($_POST['quiz-description']) && isset($_POST['quiz-visibility'])) {
    $quizName = $_POST['quiz-name'];
    $quizDescription = $_POST['quiz-description'];
    $visibility = ($_POST['quiz-visibility'] === 'public') ? 1 : 0;
    $joinCode = generateJoinCode();
    $lecturerId = $_SESSION['lecturer_id'];
    $quizCreatedAt = getCurrentTimestamp();

    echo "LecID: $lecturerId, Quiz Name: $quizName, Quiz Description: $quizDescription, Visibility: $visibility, Created At: $quizCreatedAt";
    $newQuizId = Database::addQuiz($lecturerId, $quizName, $quizDescription, $visibility, $joinCode, $quizCreatedAt);
    echo "New quiz added successfully!" . $newQuizId;

    header("Location: /learnleap/edit-quiz.php?quiz_id=" . $newQuizId);
    exit();

} else {
    echo "Form data is not set properly!";
}
