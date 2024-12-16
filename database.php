<?php

include_once('utils.php');

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
    public static function getLecturerQuizById($quizId, $lecturerId): array | false
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

    /*
    * Retrieves quizzes created by a specific lecturer.
    *
    * @param int $lecturerId The ID of the lecturer.
    * @return array An array of quiz data.
    * @throws Exception If the query fails to execute.
    * */
    public static function getLecturerQuizzes($lecturerId): array
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT * FROM `Quiz` WHERE lecturer_id = :lecturerId";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':lecturerId', $lecturerId, PDO::PARAM_INT);
            $stmt->execute();
            $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $quizzes;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public static function getStudentByEmail($email): array
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT * FROM STUDENT WHERE student_email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$user) {
                return [];
            }
            return $user;
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch student. Please try again later.");
        } catch (Exception $e) {
            echo "General Error: " . $e->getMessage(); // Catch general errors
            return 0;
        }
    }

    public static function getLecturerByEmail($email): array
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT * FROM LECTURER WHERE lecturer_email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$user) {
                return [];
            }

            return $user;
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch lecturer. Please try again later.");
        } catch (Exception $e) {
            echo "General Error: " . $e->getMessage(); // Catch general errors
            return 0;
        }
    }

    public static function createStudent($email, $password, $name): int
    {
        try {
            $conn = self::getConnection();

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $createdAt = getCurrentTimestamp();
            $sql = "INSERT INTO STUDENT (student_name, student_email, student_password, student_created_at) 
                VALUES (:name, :email, :password, :created_at)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':created_at', $createdAt, PDO::PARAM_STR);


            if ($stmt->execute()) {
                return $conn->lastInsertId();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "General Error: " . $e->getMessage();
            return false;
        }
    }

    public static function createLecturer($email, $password, $name): int
    {
        try {
            $conn = self::getConnection();
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $createdAt = getCurrentTimestamp();
            $sql = "INSERT INTO LECTURER (lecturer_name, lecturer_email, lecturer_password, lecturer_created_at) 
                VALUES (:name, :email, :password, :created_at)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':created_at', $createdAt, PDO::PARAM_STR);


            if ($stmt->execute()) {
                return $conn->lastInsertId();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "General Error: " . $e->getMessage();
            return false;
        }
    }

    public static function getLecturer($lec_id)
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT * FROM LECTURER WHERE lecturer_id = :lec_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':lec_id', $lec_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error in getLecturer: " . $e->getMessage());
            return false;
        }
    }

    public static function getTotalQuizzesByLecturer($lec_id)
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT COUNT(*) AS total_quizzes FROM QUIZ WHERE lecturer_id = :lec_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':lec_id', $lec_id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_quizzes'];
        } catch (PDOException $e) {
            error_log("Database Error in getTotalQuizzesByLecturer: " . $e->getMessage());
            return 0;
        }
    }

    public static function getTotalStudentsByLecturer($lec_id)
    {
        try {
            $conn = self::getConnection();
            $sql = "
                SELECT COUNT(DISTINCT QUIZATTEMPT.student_id) AS total_students
                FROM QUIZATTEMPT
                INNER JOIN QUIZ ON QUIZATTEMPT.quiz_id = QUIZ.quiz_id
                WHERE QUIZ.lecturer_id = :lec_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':lec_id', $lec_id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total_students'];
        } catch (PDOException $e) {
            error_log("Database Error in getTotalStudentsByLecturer: " . $e->getMessage());
            return 0;
        }
    }

    public static function calculateAverageScoresByLecturer($lec_id)
    {
        try {
            $conn = self::getConnection();
            $sql = "
                SELECT AVG(QUIZATTEMPT.score) AS avg_score
                FROM QUIZATTEMPT
                INNER JOIN QUIZ ON QUIZATTEMPT.quiz_id = QUIZ.quiz_id
                WHERE QUIZ.lecturer_id = :lec_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':lec_id', $lec_id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['avg_score'];
        } catch (PDOException $e) {
            error_log("Database Error in calculateAverageScoresByLecturer: " . $e->getMessage());
            return 0;
        }
    }
    /**
    * Retrieves all quizzes from the database.
    *
    * @return array An array of quiz data.
    * @throws Exception If the query fails to execute.
    */
    public static function getQuizData(): array
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT quiz_id, lecturer_id, quiz_name, description FROM `Quiz`";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $quizzes;
        } catch (PDOException $e) {
            echo "Database Error in getQuizData: " . $e->getMessage();
            throw new Exception("Failed to fetch quizzes. Please try again later.");
        }
    }

    /**
    * Retrieves quiz details by quiz ID.
    *
    * @param int $quizId The ID of the quiz to retrieve.
    * @return array|false The quiz details as an associative array, or false if no quiz is found.
    * @throws Exception If the query fails to execute.
    */
    public static function getQuizById($quizId): array | false
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT quiz_id, lecturer_id, quiz_name, description FROM `Quiz` WHERE quiz_id = :quiz_id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC); // Returns false if no quiz is found
        } catch (PDOException $e) {
            echo "Database Error in getQuizById: " . $e->getMessage();
            throw new Exception("Failed to fetch quiz by ID. Please try again later.");
        }
    }
    /**
 * Retrieves all banned emails with user types (student or lecturer).
 *
 * @return array The list of banned emails and their user types as an associative array.
 * @throws Exception If the query fails to execute.
 */
    public static function getAllBannedEmails(): array
    {
        try {
            $conn = self::getConnection();

            // Modified SQL query to fetch banned emails and user types
            $sql = "
            SELECT 
                CASE 
                    WHEN b.user_type = 'student' THEN s.student_email
                    WHEN b.user_type = 'lecturer' THEN l.lecturer_email
                END AS email,
                b.user_type
            FROM BannedUsers b
            LEFT JOIN Student s ON b.student_id = s.student_id
            LEFT JOIN Lecturer l ON b.lecturer_id = l.lecturer_id
            WHERE b.user_type IN ('student', 'lecturer');
        ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as associative arrays
        } catch (PDOException $e) {
            echo "Database Error in getAllBannedEmails: " . $e->getMessage();
            throw new Exception("Failed to fetch banned emails. Please try again later.");
        }
    }

    /**
 * Bans a user by inserting a record into the BannedUsers table.
 *
 * @param int $userId The ID of the user to ban.
 * @param string $type The type of the user ('student' or 'lecturer').
 * @param string $reason The reason for banning the user.
 * @return bool True if the user was successfully banned, false otherwise.
 * @throws Exception If the query fails to execute.
 */
    public static function banUser(int $userId, string $type, string $reason): bool
    {
        try {
            $conn = self::getConnection();

            // Determine user type and the corresponding ID
            if ($type === 'student') {
                $userColumn = 'student_id';
                $userTable = 'Student';
            } elseif ($type === 'lecturer') {
                $userColumn = 'lecturer_id';
                $userTable = 'Lecturer';
            } else {
                throw new Exception("Invalid user type. Must be 'student' or 'lecturer'.");
            }

            // Prepare SQL query to insert a ban record
            $sql = "
            INSERT INTO BannedUsers (admin_id, {$userColumn}, user_type, ban_reason)
            VALUES (:admin_id, :user_id, :user_type, :ban_reason);
        ";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':admin_id', $_SESSION['admin_id'], PDO::PARAM_INT); // Assuming admin_id is stored in session
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':user_type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':ban_reason', $reason, PDO::PARAM_STR);

            // Execute the query and check if it was successful
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Database Error in banUser: " . $e->getMessage();
            throw new Exception("Failed to ban user. Please try again later.");
        }
    }

    public static function getStudentsNotBanned(): array
    {
        try {
            $conn = self::getConnection();

            // SQL query to fetch students who are not banned
            $sql = "
            SELECT student_id, student_name, student_email
            FROM Student
            WHERE student_id NOT IN (SELECT student_id FROM BannedUsers WHERE user_type = 'student')
        ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all non-banned students
        } catch (PDOException $e) {
            echo "Database Error in getAllStudents: " . $e->getMessage();
            throw new Exception("Failed to fetch students. Please try again later.");
        }
    }

    public static function getLecturersWithoutAdmin(): array
    {
        try {
            $conn = self::getConnection();

            // SQL query to fetch lecturers where admin_id is NULL
            $sql = "
        SELECT lecturer_id, lecturer_name, lecturer_email, lecturer_created_at
        FROM Lecturer
        WHERE admin_id IS NULL
        ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all lecturers without an admin
        } catch (PDOException $e) {
            echo "Database Error in getLecturersWithoutAdmin: " . $e->getMessage();
            throw new Exception("Failed to fetch lecturers. Please try again later.");
        }
    }

    public static function approveLecturer($lecturerId, $adminId)
    {
        try {
            $conn = self::getConnection();

            $sql = "UPDATE Lecturer SET admin_id = :admin_id WHERE lecturer_id = :lecturer_id AND admin_id IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
            $stmt->bindParam(':lecturer_id', $lecturerId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error approving lecturer: " . $e->getMessage();
            throw new Exception("Failed to approve lecturer.");
        }
    }

    public static function rejectLecturer($lecturerId, $adminId)
    {
        try {
            $conn = self::getConnection();

            $sql = "UPDATE Lecturers SET status = 'rejected' WHERE id = :lecturer_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':lecturer_id', $lecturerId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error rejecting lecturer: " . $e->getMessage();
            throw new Exception("Failed to reject lecturer.");
        }
    }
    public static function getQuizJoinCode($quiz_id)
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT join_code FROM Quiz WHERE quiz_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $quiz_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to get all questions for a quiz
    public static function getQuizQuestions($quiz_id)
    {
        try {
            $conn = self::getConnection();
            $sql = "SELECT * FROM Questions WHERE quiz_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $quiz_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
