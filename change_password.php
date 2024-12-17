<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];
    $conn = Database::getConnection();

    if ($new_password === $confirm_password) {
        $student_id = 22345678; // Replace with actual logged-in student's ID

        // Check the current password in the student table
        $stmt = $conn->prepare("SELECT password FROM student WHERE student_id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();

        if ($student && password_verify($current_password, $student['password'])) {
            // Hash the new password and update the student table
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_stmt = $conn->prepare("UPDATE student SET password = ? WHERE student_id = ?");
            $update_stmt->bind_param("si", $hashed_password, $student_id);
            $update_stmt->execute();

            echo "Password updated successfully!";
        } else {
            echo "Current password is incorrect.";
        }
    } else {
        echo "New passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/jun.css"> <!-- Ensure this path is correct -->
</head>
<body>
    <div class="hamburger" onclick="toggleSidebar()">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="sidebar" id="sidebar">
        <h2>LearnLeap</h2>
        <ul>
            <li><a href="student_dashboard.php">Home</a></li>
            <li><a href="completed_quiz.php">Completed Quizzes</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
    </div>

    <div class="dashboard-container">
        <div class="change-password-container">
            <h1>Change Password</h1>
            <form action="change_password.php" method="POST">
                <div class="form-group">
                    <label for="current-password">Current Password</label>
                    <input type="password" id="current-password" name="current-password" placeholder="Enter current password" required>
                </div>
                <div class="form-group">
                    <label for="new-password">New Password</label>
                    <input type="password" id="new-password" name="new-password" placeholder="Enter new password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm New Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password" required>
                </div>
                <button type="submit" class="submit-button">Update Password</button>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>
</html>
