<?php

class Database
{
    private static $conn = null;

    private function __construct()
    {
    }

    public static function getConnection(): PDO
    {
        if (self::$conn === null) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "testdb";

            try {
                self::$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }

        return self::$conn;
    }

    /**
 * Retrieves quiz details by quiz ID and lecturer ID.
 *
 * @param int $quizId The ID of the quiz to retrieve.
 * @param int $lecturerId The ID of the lecturer who owns the quiz.
 *
 * @return array|false The quiz details as an associative array, or false if no quiz is found.
 * @throws PDOException If the query fails to execute.
 */
    public static function getQuizById($quizId, $lecturerId): array | false
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT * FROM `Quiz` WHERE quiz_id = :quiz_id AND lecturer_id = :lecturer_id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
            $stmt->bindParam(':lecturer_id', $lecturerId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC); // Returns false if no quiz is found
        } catch (PDOException $e) {
            error_log("Database Error in getQuizById: " . $e->getMessage());
            return false;
        }
    }

    /**
 * Adds a new quiz to the database.
 *
 * @param int $lecturerId The ID of the lecturer creating the quiz.
 * @param string $quizName The name of the quiz.
 * @param string $quizDescription A description of the quiz.
 * @param bool $visibility The public visibility status of the quiz.
 * @param string $joinCode The unique join code for the quiz.
 * @param string $quizCreatedAt The timestamp when the quiz is created (format: Y-m-d H:i:s).
 *
 * @return int The ID of the newly inserted quiz.
 * @throws PDOException If the query fails to execute.
 */
    public static function addQuiz($lecturerId, $quizName, $quizDescription, $visibility, $joinCode, $quizCreatedAt): int
    {
        try {
            $conn = self::getConnection();
            $sql = "INSERT INTO Quiz (lecturer_id, quiz_name, description, public_visibility, join_code, quiz_created_at) 
        VALUES (:lecturer_id, :quiz_name, :quiz_description, :visibility, :join_code, :quiz_created_at)";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':lecturer_id', $lecturerId, PDO::PARAM_INT);
            $stmt->bindParam(':quiz_name', $quizName, PDO::PARAM_STR);
            $stmt->bindParam(':quiz_description', $quizDescription, PDO::PARAM_STR);
            $stmt->bindParam(':visibility', $visibility, PDO::PARAM_BOOL);
            $stmt->bindParam(':join_code', $joinCode, PDO::PARAM_STR);
            $stmt->bindParam(':quiz_created_at', $quizCreatedAt, PDO::PARAM_STR);

            $stmt->execute();

            return $conn->lastInsertId(); // Returns the quiz ID
        } catch (PDOException $e) {
            echo "Database Error in addQuiz: " . $e->getMessage();
            throw new Exception("Failed to add quiz. Please try again later.");
        }
    }

    // TODO: finish getquestionsforquiz
    /**
    * Retrieves questions for a specific quiz.
    *
    * @param int $quizId The ID of the quiz.
    * @return array An array of question data.
    * @throws Exception If the query fails to execute.
    * */
    public static function getQuestionsForQuiz($quizId): array
    {
        return ['heh', "hojo"];
    }
}
