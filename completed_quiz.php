<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Completed Quizzes</title>
  <link rel="stylesheet" href="css/jun.css">
  <style>
    /* General reset */
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        display: flex;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: #28a745;
        color: white;
        height: 100vh;
        padding: 20px;
        position: fixed;
        top: 0;
        left: 0;
        box-sizing: border-box;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: #218838;
    }

    /* Dashboard Container */
    .dashboard-container {
        margin-left: 250px; /* Leave space for the sidebar */
        padding: 20px;
        box-sizing: border-box;
        flex-grow: 1; /* Allow this container to expand */
        width: calc(100% - 250px); /* Adjust for sidebar width */
    }

    /* Header */
    .header {
        margin-bottom: 20px;
    }

    /* Completed Quizzes Section */
    .quiz-result-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Responsive layout */
        gap: 20px; /* Space between cards */
    }

    .quiz-result {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .quiz-result h3 {
        margin: 0;
        color: #333;
    }

    .quiz-result p {
        margin: 5px 0;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
        }
        .dashboard-container {
            margin-left: 0;
            width: 100%;
        }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>LearnLeap</h2>
    <ul>
      <li><a href="student-dashboard.php">Home</a></li>
      <li><a href="completed-quiz.php" class="active">Completed Quizzes</a></li>
      <li><a href="profile.php">Profile</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="dashboard-container">
    <header class="header">
      <h1>Completed Quizzes</h1>
      <p>Review your performance on past quizzes.</p>
    </header>

    <div class="main-content">
      <section class="completed-quizzes">
        <h2>Quiz Results</h2>
        <div class="quiz-result-container">
          <!-- Dummy Data -->
          <div class="quiz-result">
            <h3>Java Quiz</h3>
            <p>Score: 90%</p>
            <p>Time Taken: 2 hours</p>
            <p>Date Taken: 2024-12-01</p>
          </div>
          <div class="quiz-result">
            <h3>PHP Basics Quiz</h3>
            <p>Score: 85%</p>
            <p>Time Taken: 1.5 hours</p>
            <p>Date Taken: 2024-12-10</p>
          </div>
          <div class="quiz-result">
            <h3>HTML & CSS Quiz</h3>
            <p>Score: 92.3%</p>
            <p>Time Taken: 1 hour</p>
            <p>Date Taken: 2024-12-15</p>
          </div>
        </div>
      </section>
    </div>
  </div>
</body>
</html>
