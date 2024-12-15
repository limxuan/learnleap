<?php

include "utils.php";
include "database.php";

echo "<pre>";
print_r($_POST);
echo "</pre>";

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quizId = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;
    echo "<script>alert('Quiz ID: " . htmlspecialchars($quizId) . "');</script>";
    if (!$quizId) {
        header("Location: login.php");
        exit();
    }
    $questionType = isset($_POST['question-type']) ? $_POST['question-type'] : null;
    $question = $_POST['question'];
    $correctAnswers = "";
    $wrongAnswer = "";
    $questionCreatedAt = getCurrentTimestamp();

    switch ($questionType) {
        case 'true-false':
            $correctAnswers = $_POST['tf-answer'];
            break;
        case 'short-text':
            $correctAnswers = $_POST['answer'];
            break;

        case 'mcq':
            $wrongAnswers = [];
            for ($i = 1; $i <= 3; $i++) {
                $wrongAnswers[] = $_POST["wrong-answer-$i"];
            }
            $wrongAnswer = implode(";", $wrongAnswers);
            $correctAnswers =  $_POST['correct-answer'];
            break;


        default:
            echo "Invalid question type.";
            exit;
    }

    echo "function call starting";
    $questionId = Database::saveQuestion($quizId, $question, $questionType, $correctAnswers, $wrongAnswer, $questionCreatedAt);
    echo "Created new " . $questionId;
} else {
    echo "Invalid request. (not submitted by POST)";
}
