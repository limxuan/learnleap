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
        try {
            $conn = self::getConnection();
            $sql = "SELECT * FROM `Questions` WHERE quiz_id = :quiz_id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch all questions for the given quiz_id
            $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $questions;
        } catch (PDOException $e) {
            echo "Database Error in getQuestionsForQuiz: " . $e->getMessage();
            throw new Exception("Failed to fetch questions. Please try again later.");
        } catch (Exception $e) {
            echo "General Error: " . $e->getMessage(); // Catch general errors
            return [];
        }
    }

    /*
    * Saves a new question to the database.
    *
    * @param int $quizId The ID of the quiz to which the question belongs.
    * @param string $question The text of the question.
    * @param string $questionType The type of the question (short-text, mcq, true-false).
    * @param string $correctAnswers The correct answers for the question.
    * @param string $wrongAnswers The wrong answers for the question.
    * @param string $questionCreatedAt The timestamp when the question is created (format: Y-m-d H:i:s).
    * @return int The ID of the newly inserted question.
    * @throws Exception If the query fails to execute.
    * */
    public static function saveQuestion($quizId, $question, $questionType, $correctAnswers, $wrongAnswers, $questionCreatedAt): int
    {
        try {
            $conn = self::getConnection();
            $sql = "INSERT INTO `Questions` 
                (`quiz_id`, `question_text`, `question_type`, `correct_answers`, `wrong_answers`, `answer_percentage`, `question_created_at`, `last_updated_at`) 
                VALUES 
                (:quiz_id, :question_text, :question_type, :correct_answers, :wrong_answers, :answer_percentage, :question_created_at, :last_updated_at)";

            $stmt = $conn->prepare($sql);
            $nullValue = null;

            $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
            $stmt->bindParam(':question_text', $question, PDO::PARAM_STR);
            $stmt->bindParam(':question_type', $questionType, PDO::PARAM_STR);
            $stmt->bindParam(':correct_answers', $correctAnswers, PDO::PARAM_STR);
            $stmt->bindParam(':wrong_answers', $wrongAnswers, PDO::PARAM_STR);
            $stmt->bindParam(':answer_percentage', $nullValue, PDO::PARAM_NULL);
            $stmt->bindParam(':question_created_at', $questionCreatedAt, PDO::PARAM_STR);
            $stmt->bindParam(':last_updated_at', $nullValue, PDO::PARAM_NULL);
            $stmt->execute();

            return $conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Database Error in addQuiz: " . $e->getMessage();
            throw new Exception("Failed to add quiz. Please try again later.");
        } catch (Exception $e) {
            echo "General Error: " . $e->getMessage(); // Catch general errors
            return 0;
        }
    }
}
