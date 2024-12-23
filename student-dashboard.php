<?php
include 'database.php';

// Fetch stats for total time spent and quizzes taken
$conn = Database::getConnection();
$stmt = $conn->prepare("SELECT SUM(attempted_duration) AS total_time, COUNT(*) AS total_quizzes FROM quizattempt");
$stmt->execute();

// Fetch the results
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

// Use null coalescing operator to handle null values
$total_time = $stats['total_time'] ?? 0;
$total_quizzes = $stats['total_quizzes'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="css/jun.css">
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>LearnLeap</h2>
    <ul>
      <li><a href="student-dashboard.php">Home</a></li>
      <li><a href="completed_quiz.php">Completed Quizzes</a></li>
      <li><a href="profile.php">Profile</a></li>
    </ul>
  </div>

  <!-- Dashboard Container -->
  <div class="dashboard-container">
    <!-- Header Section -->
    <header class="header">
      <div class="profile">
        <img class="avatar" src="swt.png" alt="Profile Picture">
        <div class="welcome">
          <h1>Hi Siew Weng Tim!</h1>
          <p>ID: 12345678</p>
        </div>
      </div>
    </header>

    <!-- Main Content Section -->
    <div class="main-content">
      <!-- Performance Analytics -->
      <section id="performance-analytics" class="performance-analytics">
        <h2>Performance Analytics</h2>
        <div class="analytics-container">
          <div class="chart"></div>
          <ul class="subject-list">
            <li>Variables</li>
            <li>Conditional</li>
            <li>Functions</li>
            <li>Loops</li>
            <li>Syntax</li>
            <li>Flowchart</li>
          </ul>
        </div>
      </section>

      <!-- Quizzes Section -->
      <div class="quiz-sections">
        <!-- Total Time and Quizzes Taken (Replaced Ongoing Quizzes) -->
        <section id="overview-stats" class="ongoing-quizzes">
          <h2>Overview Stats</h2>
          <div class="stat-card">
            <p>Total time spent</p>
            <h2><?php echo $total_time; ?> hours</h2>
          </div>
          <div class="stat-card">
            <p>Total quizzes taken</p>
            <h2><?php echo $total_quizzes; ?> quizzes</h2>
          </div>
        </section>

        <!-- Completed Quizzes -->
        <section id="completed-quizzes" class="completed-quizzes">
          <h2>Completed Quizzes</h2>
          <div class="quiz-list">
            <div class="quiz-card">
              <p>Syntax</p>
              <p>90%</p>
            </div>
            <div class="quiz-card">
              <p>Loops</p>
              <p>92%</p>
            </div>
            <div class="quiz-card">
              <p>Functions</p>
              <p>78%</p>
            </div>
            <div class="quiz-card">
              <p>Variables</p>
              <p>85.5%</p>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</body>
</html>
