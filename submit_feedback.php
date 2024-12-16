<?php

include('database.php'); // Assuming db_connect.php has Database::getConnection() for PDO connection

$quiz_id = isset($_POST['quiz_id']) ? (int)$_POST['quiz_id'] : 0;
$difficulty_rating = isset($_POST['difficulty_rating']) ? (int)$_POST['difficulty_rating'] : 0;

if ($quiz_id > 0 && $difficulty_rating > 0) {

    // Prepare the SQL query
    $sql = "UPDATE QuizAttempt SET difficulty_rating = ? WHERE quiz_id = ? AND difficulty_rating = 0";
    $conn = Database::getConnection(); // Get PDO connection

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters and execute
        $stmt->bindValue(1, $difficulty_rating, PDO::PARAM_INT);
        $stmt->bindValue(2, $quiz_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f9f9f9;'>
                    <div style='padding: 20px; border: 1px solid #28a745; background-color: #d4edda; color: #155724; max-width: 400px; text-align: center; border-radius: 5px;'>
                        <h2>Thank you for your feedback!</h2>
                        <p>Your rating has been recorded successfully.</p>
                    </div>
                  </div>";
        } else {
            echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f9f9f9;'>
                    <div style='padding: 20px; border: 1px solid #dc3545; background-color: #f8d7da; color: #721c24; max-width: 400px; text-align: center; border-radius: 5px;'>
                        <h2>Error!</h2>
                        <p>There was an error updating your difficulty rating.</p>
                    </div>
                  </div>";
        }
    } else {
        echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f9f9f9;'>
                <div style='padding: 20px; border: 1px solid #dc3545; background-color: #f8d7da; color: #721c24; max-width: 400px; text-align: center; border-radius: 5px;'>
                    <h2>Error!</h2>
                    <p>Failed to prepare the database statement.</p>
                </div>
              </div>";
    }
} else {
    echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f9f9f9;'>
            <div style='padding: 20px; border: 1px solid #dc3545; background-color: #f8d7da; color: #721c24; max-width: 400px; text-align: center; border-radius: 5px;'>
                <h2>Invalid Data!</h2>
                <p>Please provide valid data to submit your feedback.</p>
            </div>
          </div>";
}
