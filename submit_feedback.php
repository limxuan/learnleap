<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('database.php'); // Assuming db_connect.php has Database::getConnection() for PDO connection

$quiz_id = isset($_POST['quiz_id']) ? (int)$_POST['quiz_id'] : 0;
$difficulty_rating = isset($_POST['difficulty_rating']) ? (int)$_POST['difficulty_rating'] : 0;

if ($quiz_id > 0 && $difficulty_rating > 0) {
    $conn = Database::getConnection(); // Get PDO connection

    // Step 1: Fetch the quizattemptid of the row to update
    $selectSql = "SELECT attempt_id FROM QuizAttempt WHERE quiz_id = ? AND difficulty_rating = 0 LIMIT 1";
    $selectStmt = $conn->prepare($selectSql);

    if ($selectStmt) {
        $selectStmt->bindValue(1, $quiz_id, PDO::PARAM_INT);

        if ($selectStmt->execute()) {
            $row = $selectStmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $quizattemptid = $row['attempt_id'];

                // Step 2: Perform the update
                $updateSql = "UPDATE QuizAttempt SET difficulty_rating = ? WHERE attempt_id = ?";
                $updateStmt = $conn->prepare($updateSql);

                if ($updateStmt) {
                    $updateStmt->bindValue(1, $difficulty_rating, PDO::PARAM_INT);
                    $updateStmt->bindValue(2, $quizattemptid, PDO::PARAM_INT);

                    if ($updateStmt->execute()) {
                        echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f9f9f9;'>
                                <div style='padding: 20px; border: 1px solid #28a745; background-color: #d4edda; color: #155724; max-width: 400px; text-align: center; border-radius: 5px;'>
                                    <h2>Thank you for your feedback!</h2>
                                    <p>Your rating has been recorded successfully.</p>
                                    <p>Showing you your results in 5 seconds...</p>
                                </div>
                              </div>";

                        // Add a meta refresh tag to redirect after 5 seconds
                        echo "<meta http-equiv='refresh' content='5;url=studentPerformance.php?quizAttemptId={$quizattemptid}'>";
                        exit;
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
                                <p>Failed to prepare the update statement.</p>
                            </div>
                          </div>";
                }
            } else {
                echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f9f9f9;'>
                        <div style='padding: 20px; border: 1px solid #dc3545; background-color: #f8d7da; color: #721c24; max-width: 400px; text-align: center; border-radius: 5px;'>
                            <h2>No Rows Found!</h2>
                            <p>No matching row to update was found.</p>
                        </div>
                      </div>";
            }
        } else {
            echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f9f9f9;'>
                    <div style='padding: 20px; border: 1px solid #dc3545; background-color: #f8d7da; color: #721c24; max-width: 400px; text-align: center; border-radius: 5px;'>
                        <h2>Error!</h2>
                        <p>Failed to execute the select statement.</p>
                    </div>
                  </div>";
        }
    } else {
        echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f9f9f9;'>
                <div style='padding: 20px; border: 1px solid #dc3545; background-color: #f8d7da; color: #721c24; max-width: 400px; text-align: center; border-radius: 5px;'>
                    <h2>Error!</h2>
                    <p>Failed to prepare the select statement.</p>
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
