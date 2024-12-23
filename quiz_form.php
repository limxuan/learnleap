<?php
include('database.php');

$quiz_id = isset($_GET['quiz_id']) ? (int) $_GET['quiz_id'] : 0;

// Get the join code for the quiz
$quiz_data = Database::getQuizJoinCode($quiz_id);
$join_code = $quiz_data ? $quiz_data['join_code'] : '';

// Get the questions for the quiz
$questions_result = Database::getQuizQuestions($quiz_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Form</title>
</head>
<style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .banner {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            position: relative;
        }

        .backbtn {
            padding: 10px 20px;
            background-color: #fff;
            color: #45a049;
            font-size: 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            position: absolute; 
            left: 20px; 
            top: 50%; 
            transform: translateY(-50%); 
        }

        .backbtn:hover {
            background-color: #e0e0e0;
        }

        .backbtn:active {
            background-color: #ccc;
        }

        .settingsbtn {
            padding: 10px 20px;
            background-color: #fff;
            color: #45a049;
            font-size: 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .settingsbtn:hover {
            background-color: #e0e0e0;
        }

        .modal {
            display: none; 
            position: fixed;
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); 
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        .modal-header {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .volume-slider {
            width: 100%;
        }

        .mute-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .mute-btn:hover {
            background-color: #45a049;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            font-size: 32px;
            margin-bottom: 40px;
        }

        .question-container {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .question-text {
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .answers {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .answers label {
            background-color: #e0e0e0;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .answers input[type="radio"] {
            margin-right: 10px;
        }

        .answers label:hover {
            background-color: #4CAF50;
            color: white;
        }

        .answers label.selected {
            background-color: #4CAF50;
            color: white;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .quiz-progress {
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }
    </style>

<body>

<div class="banner">
    LearnLeap
    <button type="backbutton" onclick="window.location.href='quiz_selection.php'" class="backbtn">&#8592</button>
    <button type="button" onclick="openSettings()" class="settingsbtn">&#9881;</button>
    <div id="timer" style="font-size: 20px; color: white; margin-top: 10px;"></div> 
</div>

<?php
if (!empty($questions_result)) {
    echo '<div class="container">';
    echo '<h1>Quiz ID: ' . $quiz_id . '</h1>';
    echo '<h1>Code: ' . htmlspecialchars($join_code) . '</h1>';
    echo '<form action="submit_quiz.php" method="POST">';
    echo '<input type="hidden" name="quiz_id" value="' . $quiz_id . '">'; // Pass the quiz_id

    $question_number = 1;

    foreach ($questions_result as $row) {
        echo '<div class="question-container">';
        echo '<div class="question-text">' . $row['question_text'] . '</div>';

        $question_type = $row['question_type'];

        if ($question_type == 'mcq') {

            $answers = explode(';', $row['wrong_answers']);

            $all_answers = [$row['correct_answers']];

            foreach ($answers as $wrong_answer) {
                $all_answers[] = trim($wrong_answer);
            }

            shuffle($all_answers);

            echo '<div class="answers">';
            foreach ($all_answers as $answer) {
                echo '<label><input type="radio" name="answer[' . $row['question_id'] . ']" value="' . $answer . '" required> ' . $answer . '</label>';
            }
            echo '</div>';
        } elseif ($question_type == 'short-text') {

            echo '<input type="text" name="answer[' . $row['question_id'] . ']" required><br>';
        } elseif ($question_type == 'true-false') {

            echo '<div class="answers">';
            echo '<label><input type="radio" name="answer[' . $row['question_id'] . ']" value="True" required> True</label>';
            echo '<label><input type="radio" name="answer[' . $row['question_id'] . ']" value="False" required> False</label>';
            echo '</div>';
        }

        echo '</div>';
        $question_number++;
    }

    echo '<div class="quiz-progress">Question ' . ($question_number - 1) . ' of ' . count($questions_result) . '</div>';
    echo '<input type="submit" value="Submit Quiz">';
    echo '</form>';
    echo '</div>';
} else {
    echo "No questions available for this quiz.";
}
?>

<!-- Modal for settings -->
<div id="settingsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Settings</div>
        <label for="volume">Volume</label>
        <input type="range" id="volume" class="volume-slider" min="0" max="100" value="50">
        <div>
            <button id="muteBtn" class="mute-btn">Mute</button>
        </div>
    </div>
</div>

<audio id="quizAudio" autoplay loop>
    <source src="assets/quizmusic.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>

<script>
        let timer;
        let seconds = 0;

        function startTimer() {
            timer = setInterval(function() {
                seconds++;
                let minutes = Math.floor(seconds / 60);
                let remainingSeconds = seconds % 60;
                document.getElementById("timer").innerHTML = minutes + "m " + remainingSeconds + "s";
            }, 1000); // Update every second
        }

        function stopTimer() {
            document.getElementById("timer").innerHTML = "0" + "m " + "0" + "s";
            clearInterval(timer); 
        }

        function submitQuiz() {
            stopTimer();
            let attemptedDuration = seconds; 
            document.getElementById("attempted_duration").value = attemptedDuration;

            document.getElementById("quiz_form").submit();
        }

        window.onload = function() {
            stopTimer();
            startTimer();
        };
    </script>
<script>

function openSettings() {
    document.getElementById('settingsModal').style.display = 'block';
}


document.getElementById('muteBtn').addEventListener('click', function() {
    var audio = document.getElementById('quizAudio');
    if (audio.paused) {
        audio.play();
        this.textContent = 'Mute';
    } else {
        audio.pause();
        this.textContent = 'Unmute';
    }
});

window.onclick = function(event) {
    if (event.target == document.getElementById('settingsModal')) {
        document.getElementById('settingsModal').style.display = 'none';
    }
}

document.getElementById('volume').addEventListener('input', function() {
    var audio = document.getElementById('quizAudio');
    audio.volume = this.value / 100; // Audio volume must be between 0 and 1
});

document.addEventListener('DOMContentLoaded', function() {
    var audio = document.getElementById('quizAudio');
    var volumeSlider = document.getElementById('volume');
    audio.volume = volumeSlider.value / 100; 
});



</script>
