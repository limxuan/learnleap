<?php

echo "<pre>";
print_r($_POST);
echo "</pre>";

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the question type from the hidden input
    $questionType = isset($_POST['question-type']) ? $_POST['question-type'] : null;

    // Initialize the variables to hold the question data
    $questionText = "";
    $answer = "";
    $options = [];
    $correctAnswer = "";

    // Common function to display question details
    function displayQuestion($questionType, $questionText, $answer = null, $options = [], $correctAnswer = null)
    {
        echo "<h2>Question Created Successfully</h2>";
        echo "<strong>Question Type:</strong> " . htmlspecialchars($questionType) . "<br>";
        echo "<strong>Question:</strong> " . htmlspecialchars($questionText) . "<br>";

        // Display options for MCQ type
        if ($questionType == 'mcq') {
            echo "<strong>Options:</strong><br>";
            foreach ($options as $index => $option) {
                echo "Option " . ($index + 1) . ": " . htmlspecialchars($option) . "<br>";
            }
            echo "<strong>Correct Answer:</strong> Option " . htmlspecialchars($correctAnswer) . "<br>";
        }

        // Display the answer for true/false
        if ($questionType == 'true-false') {
            echo "<strong>Answer:</strong> " . htmlspecialchars($answer) . "<br>";
        }
    }

    // Process based on the question type
    switch ($questionType) {
        case 'short-text':
            $questionText = isset($_POST['st-question']) ? $_POST['st-question'] : '';
            $answer = isset($_POST['st-answer']) ? $_POST['st-answer'] : '';
            break;

        case 'mcq':
            // Retrieve the MCQ question data
            $questionText = isset($_POST['mcq-question']) ? $_POST['mcq-question'] : '';
            // Retrieve the options (assuming up to 4 options)
            for ($i = 1; $i <= 4; $i++) {
                $options[] = isset($_POST["mcq-option-$i"]) ? $_POST["mcq-option-$i"] : '';
            }
            $correctAnswer = isset($_POST['mcq-correct-answer']) ? $_POST['mcq-correct-answer'] : '';
            break;

        case 'true-false':
            // Retrieve the true/false question data
            $questionText = isset($_POST['tf-question']) ? $_POST['tf-question'] : '';
            $answer = isset($_POST['tf-answer']) ? $_POST['tf-answer'] : '';
            break;

        default:
            echo "Invalid question type.";
            exit;
    }

    // Display the question based on its type
    displayQuestion($questionType, $questionText, $answer, $options, $correctAnswer);

    // Optionally, you can add logic to save this data to a database or a file

} else {
    // If the form is not submitted via POST, redirect or show an error
    echo "Invalid request.";
}
