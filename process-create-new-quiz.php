<?php
// Include the database connection class
require_once 'db_config.php';
require_once 'utils.php';

if (isset($_POST['quiz-name']) && isset($_POST['quiz-description']) && isset($_POST['quiz-visibility'])) {
    // Get the form values
    $quizName = $_POST['quiz-name'];
    $quizDescription = $_POST['quiz-description'];
    $visibility = ($_POST['quiz-visibility'] === 'public') ? 1 : 0;
    $quizCreatedAt = getCurrentTimestamp();

    // Output received data for debugging
    echo "Quiz Name: $quizName, Quiz Description: $quizDescription, Visibility: $visibility, Created At: $quizCreatedAt";

    // Establish the connection using the Database class
    $conn = Database::getConnection();

    // Prepare the SQL query to insert the quiz data
    try {
        $sql = "INSERT INTO Quiz (lecturer_id, quiz_name, description, public_visibility, join_code, quiz_created_at) 
                VALUES (:lecturer_id, :quiz_name, :quiz_description, :visibility, :join_code, :quiz_created_at)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $lecturerId = 1; // You can set this dynamically based on the logged-in user
        $joinCode = generateJoinCode(); // Generate a unique join code, or set it as needed

        // Bind parameters to the prepared statement
        $stmt->bindParam(':lecturer_id', $lecturerId, PDO::PARAM_INT);
        $stmt->bindParam(':quiz_name', $quizName, PDO::PARAM_STR);
        $stmt->bindParam(':quiz_description', $quizDescription, PDO::PARAM_STR);
        $stmt->bindParam(':visibility', $visibility, PDO::PARAM_BOOL);
        $stmt->bindParam(':join_code', $joinCode, PDO::PARAM_STR);
        $stmt->bindParam(':quiz_created_at', $quizCreatedAt, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        echo "New quiz added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "Form data is not set properly!";
}
?>
