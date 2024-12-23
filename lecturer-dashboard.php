<?php
session_start();
include_once 'database.php';
$lec_id = $_SESSION['lecturer_id'];
if (!$lec_id) {
    header("Location: login-register.php");
    exit();
}

$lecturer = Database::getLecturer($lec_id);
$total_quizzes = Database::getTotalQuizzesByLecturer($lec_id);
$total_students = Database::getTotalStudentsByLecturer($lec_id);
$average_score = Database::calculateAverageScoresByLecturer($lec_id);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard</title>
    <style>
    #quiz-management button:hover {
      transform: scale(1.1); /* Slightly enlarge the button */
      background-color: #45a049; /* Slight change in background color */
    }
    #quiz-management button:nth-child(2):hover {
      background-color: #1976D2; /* Slight change for the second button */
    }
    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0f5f0;
      color: #2d2d2d;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }


    .container {
      width: 90%;
      max-width: 1200px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }


    .sidebar {
      width: 250px;
      background-color: #2d6a4f;
      color: white;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      padding: 30px;
      box-shadow: 2px 0 15px rgba(0, 0, 0, 0.15);
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 50px;
      font-size: 2.2rem;
      font-weight: bold;
      letter-spacing: 1px;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 20px;
      margin: 15px 0;
      border-radius: 8px;
      display: block;
      font-size: 1.2rem;
      transition: background-color 0.3s;
    }
    .sidebar a:hover {
      background-color: #40916c;
    }

    /* Main Content Area */
    .content {
      margin-left: 270px;
      padding: 50px;
    }
    .content h2 {
      font-size: 2.5rem;
      margin-bottom: 30px;
      color: #1b4332;
    }

    /* Cards Styles */
    .card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      padding: 40px;
      margin-bottom: 30px;
      display: inline-block;
      width: calc(33.333% - 30px);
      margin-right: 15px;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:nth-child(3n) {
      margin-right: 0;
    }
    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .card h3 {
      margin-top: 0;
      font-size: 2rem;
      color: #1b4332;
    }
    .card p {
      font-size: 1.5rem;
      color: #40916c;
    }


    .table-container {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      overflow-x: auto;
      margin-bottom: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 1.2rem;
    }
    table, th, td {
      border: 1px solid #dee2e6;
    }
    th, td {
      padding: 20px;
      text-align: left;
    }
    th {
      background-color: #2d6a4f;
      color: white;
    }


    .quiz-form {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }
    .quiz-form input, .quiz-form button {
      width: 98%;
      padding: 6px;
      margin-bottom: 15px;
      font-size: 1.2rem;
      border-radius: 8px;
      border: 1px solid #ccc;
    }
    .quiz-form button {
      width: 100%;
      background-color: #2d6a4f;
      color: white;
      border: none;
      cursor: pointer;
    }
    .quiz-form button:hover {
      background-color: #40916c;
    }


    @media (max-width: 800px) {
      .card {
        width: calc(50% - 30px);
      }
    }

    @media (max-width: 500px) {
      .card {
        width: 100%;
      }
    }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="sidebar">
        <h2>LearnLeap</h2>
        <a href="#overview" onclick="navigateTo('overview')">Lecturer Dashboard</a>
        <a href="#quizzes" onclick="navigateTo('quiz-management')">Quiz Management</a>
        <a href="#students" onclick="navigateTo('student-management')">Student Management</a>

      </div>

      <div class="content" id="main-content">
        <div id="overview">
          <h2>Welcome, <?php echo htmlspecialchars($lecturer['lecturer_name']); ?>!</h2>

          <div class="card">
            <h3>Total Quizzes</h3>
            <p id="total-quizzes"><?php echo $total_quizzes; ?></p>
          </div>
          <div class="card">
            <h3>Total Students</h3>
            <p id="total-students"><?php echo $total_students; ?></p>
          </div>
          <div class="card">
            <h3>Average Score</h3>
            <p id="average-score"><?php echo round($average_score, 2); ?>%</p>
          </div>
        </div>
      </div>
      <div id="quiz-management" style="display: none; text-align: center; padding: 40px;">
        <h2 style="font-size: 36px; margin-bottom: 30px;">Quiz Management</h2>
        <div>
          <button onclick="window.location.href='create-quiz.php'" 
            style="padding: 40px 80px; margin: 30px 0; font-size: 30px; cursor: pointer; background-color: #2d6a4f; color: white; border: none; border-radius: 12px; 
            transition: transform 0.3s ease, background-color 0.3s ease; width: 100%;">
            Create Quiz
          </button>
          <button onclick="window.location.href='lecturer-view-quiz.php'" 
            style="padding: 40px 80px; margin: 30px 0; font-size: 30px; cursor: pointer; background-color: #2d6a4f; color: white; border: none; border-radius: 12px; 
            transition: transform 0.3s ease, background-color 0.3s ease; width: 100%;">
            View Quizzes
          </button>
        </div>
      </div>

      <div id="student-management" style="display: none;">
        <h2>Student Management</h2>
        <div class="table-container">
          <table id="student-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Siew Weng Tim</td>
                <td>wt@gmail.com</td>
              </tr>
              <tr>
                <td>Juin Khai</td>
                <td>juinkhai@gmail.com</td>
              </tr>
              <tr>
                <td>Yao Ren</td>
                <td>yr@gmail.com</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
    <script>
    const sections = ['overview', 'quiz-management', 'student-management'];

    function navigateTo(section) {
      sections.forEach(s => {
        document.getElementById(s).style.display = s === section ? 'block' : 'none';
      });
    }
    function saveQuiz() {
      const title = document.getElementById('quiz-title').value;
      const date = document.getElementById('quiz-date').value;
      const questions = document.getElementById('quiz-questions').value.split('\n').filter(q => q.trim() !== '');

      if (!title || !date || questions.length === 0) {
        alert('Please fill in all fields.');
        return;
      }


      window.location.href = 'create-quiz.php'; 
    }
    </script>
  </body>
</html>
