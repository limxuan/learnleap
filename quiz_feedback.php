<?php
include('db_connect.php');

$quiz_id = isset($_GET['quiz_id']) ? (int)$_GET['quiz_id'] : 0;

if ($quiz_id > 0) {
    echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";
        echo "<div style='padding: 20px; border: 1px solid #28a745; background-color: #d4edda; color: #155724; text-align: center; width: 90%; max-width: 600px;'>";

    echo '<h2 style="text-align: center; color: #343a40; margin-bottom: 20px;">Thank you for completing the quiz!<br>Please rate the difficulty of the quiz:</h2>';

    echo '<form action="submit_feedback.php" method="POST" style="display: flex; flex-direction: column; align-items: center;">';
    echo '<input type="hidden" name="quiz_id" value="' . $quiz_id . '">';
    echo '<label for="difficulty_rating" style="margin-bottom: 10px; font-weight: bold; color: #495057;">Difficulty Rating (1-5):</label>';
    echo '<select name="difficulty_rating" id="difficulty_rating" required style="padding: 8px; border: 1px solid #ced4da; border-radius: 5px; width: 100%; max-width: 300px; margin-bottom: 20px;">';
    echo '  <option value="1">1 (Easy)</option>';
    echo '  <option value="2">2</option>';
    echo '  <option value="3">3</option>';
    echo '  <option value="4">4</option>';
    echo '  <option value="5">5 (Difficult)</option>';
    echo '</select>';

    echo '<input type="submit" value="Submit Feedback" style="background-color: #4CAF50; color: #ffffff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px;">';
    echo '</form>';

    echo '</div>';
    echo '</div>';
} else {
    echo '<div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f8d7da;">';
    echo '<div style="padding: 20px; border: 1px solid #f5c6cb; border-radius: 10px; background-color: #f8d7da; color: #721c24; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 500px; width: 100%; text-align: center;">';
    echo '<h2>Invalid Quiz ID</h2>';
    echo '</div>';
    echo '</div>';
}

$conn->close();
?>
