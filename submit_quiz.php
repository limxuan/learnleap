<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
include('database.php');

$quiz_start_timestamp = isset($_POST['quiz_start_timestamp']) ? (int) $_POST['quiz_start_timestamp'] : 0;
$student_id = 2; // Note: change this to real student id
$quiz_end_timestamp = time();

$duration_seconds = $quiz_end_timestamp - $quiz_start_timestamp;
$duration_minutes = floor($duration_seconds / 60);
$duration_seconds = $duration_seconds % 60;
$duration = $duration_minutes . " minutes " . $duration_seconds . " seconds";

$quiz_id = isset($_POST['quiz_id']) ? (int) $_POST['quiz_id'] : 0;
$attempted_at = date('Y-m-d');
$attempted_duration = $duration;
$difficulty_rating = isset($_POST['difficulty_rating']) ? (int) $_POST['difficulty_rating'] : 0;

$chosen_answers = '';

$score = 0;
if (isset($_POST['answer']) && !empty($_POST['answer'])) {
    $answers = $_POST['answer'];
    foreach ($answers as $question_id => $answer) {
        $chosen_answers .= $answer . ';';

        // Fetch correct answer and question type using PDO
        $conn = Database::getConnection(); // Get PDO connection
        $sql_check_answer = "SELECT correct_answers, question_type FROM Questions WHERE question_id = ?";
        $stmt_check_answer = $conn->prepare($sql_check_answer);
        $stmt_check_answer->bindValue(1, $question_id, PDO::PARAM_INT);
        $stmt_check_answer->execute();
        $question_details = $stmt_check_answer->fetch(PDO::FETCH_ASSOC);

        if ($question_details) {
            $correct_answers = $question_details['correct_answers'];
            $question_type = $question_details['question_type'];

            // Calculate score based on question type
            if ($question_type === 'truefalse' && $answer === $correct_answers) {
                $score++;
            } elseif ($question_type === 'mcq' && in_array($answer, explode(';', $correct_answers))) {
                $score++;
            } elseif ($question_type === 'fillintheblank' && strtolower(trim($answer)) === strtolower(trim($correct_answers))) {
                $score++;
            }
        }
    }
    $chosen_answers = rtrim($chosen_answers, ';');
}

// Insert quiz attempt using PDO
$conn = Database::getConnection(); // Get PDO connection
$sql = "INSERT INTO QuizAttempt (quiz_id, student_id, attempted_at, attempted_duration, chosen_answer, score, difficulty_rating)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $quiz_id, PDO::PARAM_INT);
$stmt->bindValue(2, $student_id, PDO::PARAM_INT);
$stmt->bindValue(3, $attempted_at, PDO::PARAM_STR);
$stmt->bindValue(4, $duration_seconds, PDO::PARAM_INT);
$stmt->bindValue(5, $chosen_answers, PDO::PARAM_STR);
$stmt->bindValue(6, $score, PDO::PARAM_INT);
$stmt->bindValue(7, $difficulty_rating, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";
    echo "<div style='padding: 20px; border: 1px solid #28a745; background-color: #d4edda; color: #155724; text-align: center; width: 90%; max-width: 600px;'>";
    echo "<h3>Quiz submitted successfully!</h3>";
    echo "<p>Your answers have been recorded. Thank you for your participation!</p>";
    echo "<p>Time spent: $duration_seconds seconds</p>";  // Show the time spent
    echo '<a href="quiz_feedback.php?quiz_id=' . $quiz_id . '" style="color: #007bff; text-decoration: none;">Rate Difficulty</a>';
    echo "</div>";
    echo "</div>";
} else {
    echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";
    echo "<div style='padding: 20px; border: 1px solid #dc3545; background-color: #f8d7da; color: #721c24; text-align: center; width: 90%; max-width: 600px;'>";
    echo "<h3>Error!</h3>";
    echo "<p>There was an error inserting your quiz attempt. Please try again later.</p>";
    echo "</div>";
    echo "</div>";
}
