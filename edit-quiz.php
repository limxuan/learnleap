<?php
include_once 'db_config.php';
session_start();
if (isset($_GET['quiz_id'])) {
    $quizId = $_GET['quiz_id'];  // Access the 'id' query parameter
    $lecturerId = $_SESSION['lecturer_id'];
    $conn = Database::getConnection();
    try {
        $sql = "SELECT quiz_name FROM `Quiz` WHERE quiz_id = :quiz_id and lecturer_id = :lecturer_id";


        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
        $stmt->bindParam(':lecturer_id', $lecturerId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "yessir";
            $quizName = $result['quiz_name'];
            echo "Editing: $quizName";
        } else {
            echo "Quiz not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Web Page</title>
    <!-- External CSS file link (optional) -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include "navbar.php" ?>
    <div class="content">
            <div class="container">
                
        <h1>Skibidi is Editing: <?php echo $quizName ?></h1>
            </div>
    </div>
</body>
</html>
