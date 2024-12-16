<?php
include "database.php";

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 3;

$quizzes = Database::getQuizData();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Explore</title>

   <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css">
   <style>
      @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');
      @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

      .fade-out {
         opacity: 0;
         transition: opacity 0.5s ease;
      }

      body {
         transition: opacity 0.5s ease;
      }

      * {
         padding: 0;
         margin: 0;
         box-sizing: border-box;
         list-style: none;
         text-decoration: none;
         border: none;
         outline: none;
         gap: 10px;
         font-family: 'Montserrat', sans-serif;
      }

      :root {
         --text-color: #fff;
         --bg-color: #fff;
         --main-color: #ffa343;
         --black-color: #000;
         --nav-color: #80EF80;

         --font-1: 'Montserrat', sans-serif;
         --h1-font: 6rem;
         --h2-font: 3rem;
         --p-font: 1rem;
      }

      body {
         color: var(--text-color);
         background: var(--bg-color);
         padding-top: 110px;
         transition: opacity 0.5s ease;
      }

      .fade-out {
         opacity: 0;
         transition: opacity 0.5s ease;
      }

      header {
         position: fixed;
         top: 0;
         right: 0;
         z-index: 1000;
         width: 100%;
         background: var(--nav-color);
         padding: 23px 12%;
         display: flex;
         align-items: center;
         justify-content: space-between;
         transition: .50s ease;
         border-bottom: 2px solid #000;
      }

      span {
         color: #0F5132;
      }

      .logo {
         font-size: 33px;
         color: var(--black-color);
         font-weight: 700;
         letter-spacing: 2px;
      }

      .navbar {
         display: flex;
      }

      .navbar a {
         color: var(--black-color);
         font-size: var(--p-font);
         font-weight: 500;
         margin: 15px 22px;
         transition: all .40s ease;
      }

      .navbar a:hover {
         color: var(--text-color);
      }

      .h-right {
         display: flex;
         align-items: center;
         justify-content: center;
         background: var(--nav-color);
         height: 40px;
         padding: 10px;
      }

      .h-right input[type="text"] {
         padding: 8px;
         border: 2px solid #000;
         border-radius: 6px;
         font-size: 16px;
         background-color: #72BF6A;
         width: 200px;
         transition: width 0.3s ease;
      }

      .h-right input[type="text"]:focus {
         width: 250px;
         border-color: var(--main-color);
      }

      .explore-content {
         text-align: center;
         padding: 40px 20px;
      }

      .explore-content h1 {
         font-size: 42px;
         font-weight: 700;
         margin-bottom: 20px;
         color: #000;
      }

      .explore-cards {
         display: flex;
         flex-direction: column;
         gap: 50px;
         justify-content: center;
         align-items: center;
         margin-top: 20px;
      }

      .mostPlayed {
         display: grid;
         grid-template-columns: repeat(3, 1fr);
         justify-content: center;
         align-items: center;
         gap: 70px;
         margin: 20px 0;
      }

      @media only screen and (max-width: 768px) {
         .mostPlayed {
            grid-template-columns: repeat(2, 1fr);
         }
      }

      @media only screen and (max-width: 480px) {
         .mostPlayed {
            grid-template-columns: 1fr;
         }
      }

      .button {
         width: 220px;
         height: 220px;
         font-size: 16px;
         background-color: #60a1b3;
         color: #000;
         border: 2px solid transparent;
         border-radius: 5px;
         cursor: pointer;
         transition: all .50s ease;
         display: flex;
         justify-content: center;
         align-items: center;
      }

      .button:hover {
         transform: translateX(10px);
         border: 2px solid #000;
         background: #90e0d2;
         color: #3c3d3c;
      }
   </style>
</head>

<body>
   <header>
      <a href="" class="logo">Learn<span>leap</a>
      <ul class="navbar">
         <li><a href="">Home</a></li>
         <li><a href="explore.php">Explore</a></li>
         <li><a href="join-code.php">Join Code</a></li>
         <li><a href="student-dashboard.php">Dashboard</a></li>
      </ul>

      <div class="h-right">
         <input type="text" placeholder="Search">
      </div>
   </header>
   <div class="explore-content">
      <h1>Quizies</h1>
      <div class="explore-cards">
         <div class="mostPlayed">
            <?php
            if (!empty($quizzes)) {
                foreach ($quizzes as $quiz) {
                    echo '<a href="join-quiz.php?quiz_id=' . $quiz['quiz_id'] . '" class="button">' . $quiz['quiz_name'] . '</a>';
                }
            } else {
                echo '<p>No quizzes found.</p>';
            }
?>
         </div>
      </div>
   </div>

   <script>
      document.querySelectorAll('a').forEach(link => {
         link.addEventListener('click', (e) => {
            e.preventDefault();
            const href = link.getAttribute('href');

            document.body.classList.add('fade-out');

            setTimeout(() => {
               window.location.href = href;
            }, 500);
         });
      });
   </script>
</body>

</html>
