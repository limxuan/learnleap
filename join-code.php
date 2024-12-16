<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "database.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Private Quiz</title>

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
         color: var(--text-color);
         background: var(--bg-color);
         padding-top: 110px;
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

      .input-container {
         display: flex;
         align-items: center;
         border: 2px solid #000;
         border-radius: 20px;
         padding: 8px 12px;
         max-width: 350px;
         box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
         margin: 0 auto;
         margin-top: 250px;
         transition: transform 0.3s ease;
      }

      .input-container input {
         border: none;
         outline: none;
         flex: 1;
         font-size: 1rem;
         color: #555;
      }

      .input-container button {
         background: none;
         border: 2px solid #000;
         border-radius: 8px;
         cursor: pointer;
         display: flex;
         align-items: center;
         justify-content: center;
         width: 32px;
         height: 32px;
         margin-left: 8px;
      }

      .input-container button:hover {
         transform: scale(1.2);
      }

      .input-container button::before {
         content: '\2713';
         font-size: 1rem;
         color: #555;
         transition: color 0.3s ease;
      }

      .input-container button:hover::before {
         color: #000;
      }
   </style>
</head>

<body>
   <header>
      <a href="" class="logo">Learn<span>leap</a>
      <ul class="navbar">
         <li><a href="explore.php">Home</a></li>
         <li><a href="explore.php">Explore</a></li>
         <li><a href="join-code.php">Join Code</a></li>
         <li><a href="student-dashboard">Dashboard</a></li>
      </ul>

      <div class="h-right">
         <input type="text" placeholder="Search">
      </div>
   </header>

   <form method="POST">
      <div class="input-container">
         <input type="text" name="join_code" placeholder="Enter join code">
         <button type="submit"></button>
      </div>
   </form>
   <?php
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       if (!empty($_POST['join_code'])) {
           $join_code = strtoupper($_POST['join_code']);

           echo "<p>Join code: $join_code</p>";

           if (strlen($join_code) == 8) {
               $sql = "SELECT * FROM Quiz WHERE join_code = ?";
               $conn = Database::getConnection();
               $stmt = $conn->prepare($sql);
               $stmt->bindParam(1, $join_code, PDO::PARAM_STR);
               $stmt->execute();

               // Fetch the result
               $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
               echo "hello world";
               echo "<script>console.log('im hjere')</script>";
               if (count($result) > 0) {
                   $quiz_id = $result[0]['quiz_id'];
                   header("Location: quiz_form.php?quiz_id=$quiz_id");
                   exit();
               } else {
                   echo "<script>alert('Invalid join code');</script>";
               }

               $stmt = null; // Close the statement
               $conn = null;
           } else {
               echo  "<script>alert('Join code should be 8 characters')</script>";
           }
       } else {
           echo  "<script>console.log('Please enter a join code')</script>";
       }
   }
?>

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
