<head>
  <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #28a745; /* Green color */
            color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .navbar .nav-links {
            display: flex;
            gap: 15px;
        }

        .navbar .nav-links a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            background-color: #218838; /* Darker green on hover */
        }
    </style>
</head>
<div class="navbar">
  <div class="logo">LearnLeap</div>
        <div class="nav-links">
            <a href="lecturer-view-quiz.php">View Quizzes</a>
            <a href="lecturer-dashboard.php">Dashboard</a>
        </div>
</div>
