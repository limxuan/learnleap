<?php
session_start();
include "database.php";

$name = "Siew Weng Tim";
$student_id = "22345678";
$email = "siewwengtim@example.com";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel="stylesheet" href="css/jun.css"> 
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>LearnLeap</h2>
    <ul>
      <li><a href="student-dashboard.php">Home</a></li>
      <li><a href="completed_quiz.php">Completed Quizzes</a></li>
      <li><a href="profile.php" class="active">Profile</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="dashboard-container">
    <header class="header">
      <h1>Profile</h1>
      <p>View and update your personal details.</p>
    </header>

    <div class="main-content">
      <section class="profile-container">
        <div class="profile-card">
          <p><strong>Name:</strong></p>
          <p><?php echo $name; ?></p>
        </div>
        <div class="profile-card">
          <p><strong>Student ID:</strong></p>
          <p><?php echo $student_id; ?></p>
        </div>
        <div class="profile-card">
          <p><strong>Email:</strong></p>
          <p><?php echo $email; ?></p>
        </div>
        <div class="profile-card">
          <p><strong>Password:</strong></p>
          <p>********</p>
          <div class="change-password">
            <a href="change_password.php">Change Password</a>
          </div>
        </div>
      </section>
    </div>
  </div>
</body>
</html>
