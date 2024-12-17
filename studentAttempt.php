 <?php
ini_set('display_errors', 1); // Display errors
ini_set('display_startup_errors', 1); // Display errors during PHP startup
error_reporting(E_ALL); // Report all PHP errors (notices, warnings, etc.)
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Student Performance</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <style>

            /* navigation bar */
            nav{
                background: rgb(37, 133, 72);
                height: 80px; 
                width: 100%;
                display: flex; /* Flexbox for layout */
                align-items: center; /* Vertically align items */
                justify-content: space-between; /* Space out content */
                padding: 0 20px; /* Adjust side padding as needed */
            }

            label.logo{
                color: white;
                font-size: 35px;
                line-height: 80px;
                padding: 0 100 px;
                font-weight: bold;
            }

            nav ul{
                display: flex; /* Use Flexbox for the list */
                list-style: none; /* Remove bullet points */
                margin: 0; /* Remove default margin */
                padding: 0; /* Remove default padding */

            }

            nav ul li{
                margin: 0 15px; /* Add spacing between items */                
            }

            nav ul li a {
                color: white;
                font-size: 17px;
                padding: 7px 13px;
                border-radius: 3px;
                text-transform: uppercase;
            }

            a.active,a:hover{
                background: #16ffc5;
                transition: .3s;
            }

            /* content */
            #profile{
                box-sizing: border-box;
                width: 20vw;
                height: 7vh;
                border: 1px solid, #082d2d;
                padding: 15px 20px;
                border-radius: 20px;
                margin-top: 36px; /* Space from the top */
                margin-left: 42px; /* Fixed position */
                text-align: center;
                background-color: #f3f5e8; /* Background for TotalQuestion */
                color: #646462;

            }

            #profilepic{
                text-align: left;
                transform: translateY(-60%); /* Adjust for centering */
            }

            #TotalQuestion {
            position: relative; /* Parent container for alignment */
            box-sizing: border-box;
            width: 40vw; /* Fixed width */
            height: 5vh; /* Fixed height */
            border: 1px solid;
            border-radius: 20px;
            margin-top: -45px ; 
            margin-left: 400px; 
            background-color: #395550; /* Background for TotalQuestion */
            z-index: 1; /* Ensure it's below CorrectQuestion */
        }

        #CorrectQuestion {
            position: absolute; /* Allow overlap with TotalQuestion */
            box-sizing: border-box;
            height: 4.5vh; /* Match height with TotalQuestion */
            border-radius: 20px;
            margin-top: -33.4px ; 
            margin-left: 401.8px; 
            padding-left: 8px;
            background-color: #c4cdc7; /* Green background for progress */
            z-index: 2; /* Ensure it displays above TotalQuestion */
            text-align: center;

        }

        #CorrectQuestionoutsidetext {
        position: absolute; /* Position text independently */
        top: -50.5px; /* Move text above the box */
        left: 50%; /* Center the text horizontally */
        transform: translateX(-48%); /* Adjust for centering */
        font-size: 16px; /* Adjust font size as needed */
        white-space: nowrap; /* Prevent text wrapping */
        line-height: 2.7;
        color: black; /* Set text color */
}

        #totalAttemptNumbers{
            position: relative;
            box-sizing: border-box;
            width: 3vw;
            height: 5vh;
            border: 2px solid;
            padding: 7px 0px;
            border-radius: 20px;
            margin-top: -34.5px ; 
            margin-left: 875px; 
            left: 80px;
            text-align: center;
            font-weight: bold;
            background-color: #c4cdc7; /* Green background for progress */
            color: #395550;
        }
        

            #totalAttempt{
            transform: translate(932px, -10px); /* Move text left by -5px */
            margin: 50; /* Ensure no margin shifts the text */
            font-weight: bold;
            color: #395550;

            }

            #difficulty {
            position: relative; 
            box-sizing: border-box;
            width: 17vw;
            height: 10vh;
            padding: 0px 0px;
            border: 1.5px solid;
            border-radius: 20px;
            top: -95px; 
            transform: translateX(-10%); /* Adjust for centering */ 
            margin-left: auto; /* Align to the right */
        }

            #icon-container {
                position: relative;
                top: -25px; /* Adjust this value to control the icon's vertical position */ 

            }

            #icon {
                float: left; /* Or use position: absolute; with appropriate values */
                font-size: 5vh; 
            }

            #statistic {
                float: left; /* Or use position: absolute; with appropriate values */
                margin-left: 15px; /* Add spacing between icon and text */
                transform: translateX(-8px); /* Move it up by 40px */
                margin-top: 43px;
                line-height: 0.5;
                text-align: center;
            }
            
            #topic {
                position: relative;
                box-sizing: border-box;
                width: 100%;  /* Use full width available */
                height: 5vh;
                padding: 0px 0px;
                transform: translateY(-89px); /* Move it up by 40px */
                margin-left: 50px; /* Adjust margin-left as needed */
                font-family: Montserrat;
                font-size: 28px;
                clear: both; /* Clears float */

            }

            #Allquestion_container {
                position: relative;
                box-sizing: border-box;
                width: 95vw;
                height: 80vh;
                margin: -35px 20px 80px 33px; /* Top, right, bottom, left margins */
                transform: translateY(-33px); /* Move it up by 40px */
                padding: 15px;
                border-radius: 10px;
                background-color: #dee2d8;
                border: 1px solid #4b6464;
                width: 92%;  /* Adjust width */
                font-family: Arial, sans-serif;
                text-align: right;
                overflow: auto; /* Enable scrolling when content overflows */
            }

            #SingleQuestion_container {
                margin-top: 35px;
                padding: 10px;
                border: 1.8px solid #082d2d;
                border-radius: 8px;
                background-color: #e7e8e0;
                color: #082d2d;
                display: flex;
                justify-content: space-between; /* Align left and right items */
                align-items: center;
            }

            #SingleQuestion_container h3 {
                font-size: 18px;
                margin-top: 10px;

            }

            #SingleQuestion_container p {
                font-size: 16px;
                margin: 5px 0;
            }

            #QuestionData-left {
                display: inline-block;
                line-height: 1.5;
                width: 50%; /* Ensures correct left-alignment for question and answers */
                text-align: left;

            }

            #CorrectAndMistake-right {
                display: inline-block;
                width: 50%; /* Ensures correct right-alignment for Total Correct and Total Mistake */
                text-align: right;
            }

        </style>
    </head>

    <body>

        <?php
            $con = mysqli_connect("localhost", "root", "", "testdb");
if (!$con) {
    die("Connection failed".$con->mysqli_connect_error);
}
?>


    <?php include('navbar.php'); ?>
        <div id="profile">
            <?php
        $sql = "SELECT student_name FROM Student WHERE student_id = 8"; //TODO: where student = 1 need to change to variable meets with login account
$result = mysqli_query($con, $sql);

if ($result->num_rows > 0) {
    // Output data of the row
    while ($row = $result->fetch_assoc()) {
        echo $row["student_name"];
    }
}
?>

            <div id="profilepic">
                <img src='User Icon.png' alt='User Image' width='50' height='50'>
            </div>
        </div>

        <div id="TotalQuestion">
            <p> 
                <?php
        $quiz_id = 22; // TODO: Dynamically set quiz_id
$sql_total_questions = "SELECT COUNT(*) AS total_questions FROM Questions WHERE quiz_id = $quiz_id";
$result_total_questions = mysqli_query($con, $sql_total_questions);
$total_questions = 0;

if ($result_total_questions && $row_total_questions = mysqli_fetch_assoc($result_total_questions)) {
    $total_questions = $row_total_questions['total_questions'];
}
?>
            </p>
        </div>

        <div id="CorrectQuestion" style="
            <?php
$attempt_id = 13; // TODO: Dynamically set attempt_id
$correct_answers = 0;

// Fetch chosen answers for the attempt
$sql_attempt = "SELECT chosen_answer FROM QUIZATTEMPT WHERE attempt_id = $attempt_id";
$result_attempt = mysqli_query($con, $sql_attempt);

if ($result_attempt && $row_attempt = mysqli_fetch_assoc($result_attempt)) {
    $chosen_answers = explode(';', $row_attempt['chosen_answer']);

    // Fetch correct answers for the quiz, ensure questions are ordered by ID
    $sql_questions = "SELECT correct_answer FROM Questions WHERE quiz_id = $quiz_id ORDER BY question_id ASC";
    $result_questions = mysqli_query($con, $sql_questions);

    if ($result_questions && mysqli_num_rows($result_questions) > 0) {
        $index = 0; // Track question index for chosen answers
        while ($question = mysqli_fetch_assoc($result_questions)) {
            $correct_answer = trim(strtolower($question['correct_answer']));
            $chosen_answer = trim(strtolower($chosen_answers[$index] ?? '')); // Handle potential missing answers

            // Check if chosen answer matches correct answer
            if ($chosen_answer === $correct_answer) {
                $correct_answers++;
            }

            $index++;
        }
    }
}

// Calculate dynamic width for CorrectQuestion within 40vw
$correct_percentage = ($total_questions > 0) ? ($correct_answers / $total_questions) * 100 : 0;
$correct_bar_width = ($correct_percentage / 100) * 40; // Calculate width in vw
echo "width: " . $correct_bar_width . "vw;";
?>
        ">
            <div id="CorrectQuestionoutsidetext">
                <p>Correct Answers: <?php echo $correct_answers; ?></p> 
                <span>Total Questions: <?php echo $total_questions; ?></span> 
            </div>
        </div>



        <div id="totalAttemptNumbers">
            <?php
      $student_id = 2;

// Query to count the number of attempts by student_id for quiz_id
$sql = "SELECT COUNT(*) AS attempt_count FROM QuizAttempt WHERE student_id = $student_id AND quiz_id = $quiz_id";
$result = mysqli_query($con, $sql);

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row['attempt_count'];
} else {
    echo "Error: " . mysqli_error($con);
}
?>
        </div>

        <div id="totalAttempt">
            <p>Total Attempt</p>
        </div>
</div>



        <div id="difficulty">
            <div id="icon-container"> 
                <div id="icon">
                    <p>🏅</p>
                </div>
                <span id="statistic">
                    <?php
            $quiz_id = 1; // need change to variable that match the selected quiz

$sql = "SELECT average_percentage FROM Quiz WHERE quiz_id = $quiz_id";
$result = mysqli_query($con, $sql);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $quiz_percentage = $row['average_percentage'];

    // Count the number of quizzes harder than the given quiz
    $sql_harder = "SELECT COUNT(*) AS harder_count FROM Quiz WHERE average_percentage > $quiz_percentage";
    $result_harder = mysqli_query($con, $sql_harder);
    $row_harder = mysqli_fetch_assoc($result_harder);
    $harder_count = $row_harder['harder_count'];

    // Count the total number of quizzes
    $sql_total = "SELECT COUNT(*) AS total_quizzes FROM Quiz";
    $result_total = mysqli_query($con, $sql_total);
    $row_total = mysqli_fetch_assoc($result_total);
    $total_quizzes = $row_total['total_quizzes'];

    // Calculate the difficulty percentage
    if ($total_quizzes > 0) {
        $quiz_difficulty = ($harder_count / $total_quizzes) * 100;
        echo round($quiz_difficulty, 2) . "% harder than others";
    }
}

?>
                    <p>similar quiz</p>
                </span>
            </div>
        </div>


        <div id="topic">
            <?php
        $sql = "SELECT quiz_name FROM Quiz WHERE quiz_id = $quiz_id"; //where quiz_id = 1 need to change to variable according student select which quiz_id
$result = mysqli_query($con, $sql);

if ($result->num_rows > 0) {
    // Output data of the row
    while ($row = $result->fetch_assoc()) {
        echo "Quiz Name: " . $row["quiz_name"];
    }
}
?>
        </div>


        <div id="Allquestion_container">
            <p>Total Correct&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Mistake&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <?php
        $quiz_id = 1; // Dynamically set quiz_id
$attempt_data = []; // To hold all attempts for this quiz

// Fetch all attempts for the given quiz_id
$sql_attempts = "SELECT attempt_id, chosen_answer FROM QuizAttempt WHERE quiz_id = $quiz_id";
$result_attempts = mysqli_query($con, $sql_attempts);

if ($result_attempts && mysqli_num_rows($result_attempts) > 0) {
    while ($row_attempt = mysqli_fetch_assoc($result_attempts)) {
        $attempt_data[$row_attempt['attempt_id']] = explode(';', $row_attempt['chosen_answer']);
    }

    // Fetch questions for the quiz
    $sql_questions = "SELECT * FROM Question WHERE quiz_id = $quiz_id";
    $result_questions = mysqli_query($con, $sql_questions);

    if ($result_questions && mysqli_num_rows($result_questions) > 0) {
        $question_index = 0;
        while ($question = mysqli_fetch_assoc($result_questions)) {
            $question_text = $question['question_text'];
            $correct_answer = $question['correct_answer'];
            $question_type = $question['question_type'];

            $total_correct = 0;
            $total_mistake = 0;

            // Check answers for this question across all attempts
            foreach ($attempt_data as $attempt_id => $answers) {
                $chosen_answer = $answers[$question_index] ?? 'N/A';

                if ($question_type === 'short-text') {
                    // For short-text, compare directly with correct answer
                    if (trim(strtolower($chosen_answer)) === trim(strtolower($correct_answer))) {
                        $total_correct++;
                    } else {
                        $total_mistake++;
                    }
                } else {
                    // For MCQ and True/False
                    if (trim(strtolower($chosen_answer)) === trim(strtolower($correct_answer))) {
                        $total_correct++;
                    } else {
                        $total_mistake++;
                    }
                }
            }

            // Display question and its answer summary
            echo '<div id="SingleQuestion_container">';
            echo '<div id="QuestionData-left">';
            echo '<h3>Question: ' . htmlspecialchars($question_text) . '</h3>';
            echo '<p>Chosen Answer: ' . htmlspecialchars($chosen_answer) . '</p>';
            echo '<p>Correct Answer: ' . htmlspecialchars($correct_answer) . '</p>';
            echo '</div>';
            echo '<div id="CorrectAndMistake-right">';
            echo $total_correct . "&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $total_mistake . "&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            //echo $total_mistake;
            echo '</div>';
            echo '</div>';

            $question_index++; // Increment question index for chosen_answer mapping
        }
    } else {
        echo '<p>No questions found for this quiz.</p>';
    }
} else {
    echo '<p>No attempts found for this quiz.</p>';
}
?>
        </div>

    </body>
</html>
