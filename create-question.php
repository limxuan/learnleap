<?php
session_start();
include_once "database.php";
// TODO: checking for lecturer id session and quiz id
if (isset($_GET['quiz_id'])) {
    $quizId = $_GET['quiz_id'];  // Access the 'id' query parameter
    $lecturerId = $_SESSION['lecturer_id'];
    $questions = Database::getQuestionsForQuiz($quizId);

} else {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-7">
    <meta name="viewport" content="width=device-width, initial-scale=2.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Web Page</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/create-question.css">
  </head>
  <body>

    <!-- Header Section -->
    <?php include_once 'navbar.php'; ?>
    <div class="container">
      <svg class="backarrow" width="32" height="26" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg" color="#6A6B6A"><path d="M28.5741 12.0023C28.5741 12.4569 28.3935 12.893 28.072 13.2144C27.7505 13.5359 27.3145 13.7165 26.8599 13.7165H5.86103L13.2178 21.0732C13.3776 21.2325 13.5044 21.4217 13.5909 21.6301C13.6774 21.8385 13.722 22.0619 13.722 22.2875C13.722 22.5131 13.6774 22.7365 13.5909 22.9448C13.5044 23.1532 13.3776 23.3424 13.2178 23.5017C12.8943 23.821 12.4581 24 12.0036 24C11.549 24 11.1128 23.821 10.7893 23.5017L0.504181 13.2165C0.344373 13.0573 0.217574 12.868 0.131055 12.6597C0.0445364 12.4513 0 12.2279 0 12.0023C0 11.7767 0.0445364 11.5533 0.131055 11.3449C0.217574 11.1366 0.344373 10.9474 0.504181 10.7881L10.7893 0.502946C11.1114 0.180915 11.5481 0 12.0036 0C12.2291 0 12.4523 0.044416 12.6607 0.130712C12.869 0.217007 13.0583 0.343493 13.2178 0.502946C13.3772 0.6624 13.5037 0.851699 13.59 1.06003C13.6763 1.26837 13.7207 1.49166 13.7207 1.71717C13.7207 1.94267 13.6763 2.16596 13.59 2.3743C13.5037 2.58263 13.3772 2.77193 13.2178 2.93138L5.86103 10.2881H26.8599C27.3145 10.2881 27.7505 10.4687 28.072 10.7902C28.3935 11.1117 28.5741 11.5477 28.5741 12.0023Z" fill="#6A6B6A"></path></svg>

      <div class="header-container">
        <p class="header-title">Create a new question</p>
        <div class="header-button-container">
          <p class="header-button-text">cancel</p>
          <button id="create-question-button" class="btn header-create-button-container">
            <p>create</p>
            <img src="assets/right-arrow-icon.svg" alt="rightarrow">
          </button>
        </div>
      </div>
      <div class="question-type-container" id="mcq-form-container">
        <p>Question Type:</p>
        <div class="question-type-btn-container">
          <input type="radio" name="question-type" value="short-text" id="short-text" class="radio-input question-radio-input">
          <label for="short-text" class="question-radio-btn radio-btn">
            <p>Short text</p>
          </label>
          <input type="radio" name="question-type" value="mcq" id="mcq" class="radio-input question-radio-input">
          <label for="mcq" class="radio-btn question-radio-btn">
            <p>Multiple choice</p>
          </label>
          <input type="radio" name="question-type" value="True or false" id="true-or-false" class="radio-input question-radio-input">
          <label for="true-or-false" class="radio-btn question-radio-btn">
            <p>True or false</p>
          </label>
        </div>
        <div class="question-form-container" id="st-form-container">
          <!-- Short Text Form -->
          <form id="short-text-form" class="question-form" action="process-create-question.php" method="POST">
            <input type="hidden" name="question-type" value="short-text">

            <div class="question-input-container">
              <p>QUESTION</p>
              <textarea name="question" id="st-question" class="input-textarea" placeholder="Add question here"></textarea>
            </div>

            <hr class="form-divider" />

            <div class="question-input-container">
              <p>ANSWER</p>
              <textarea name="answer" id="st-answer" class="input-textarea" placeholder="Add answer here"></textarea>
            </div>
          </form>

          <!-- Multiple Choice (MCQ) Form -->
          <form id="mcq-form" class="question-form" action="process-create-question.php" method="POST">
            <input type="hidden" name="question-type" value="mcq">

            <div class="question-input-container">
              <p>QUESTION</p>
              <textarea name="question" id="mcq-question" class="input-textarea" placeholder="Add question here"></textarea>
            </div>

            <hr class="form-divider" />

            <div class="question-input-container">
              <p style="color: green;">CORRECT ANSWER</p>
              <textarea name="correct-answer" id="mcq-correct-answer" class="input-textarea" placeholder="Add correct answer here"></textarea>
            </div>

            <hr class="form-divider" />

            <div class="question-input-container">
              <p style="color: red;">WRONG ANSWERS</p>
              <textarea name="wrong-answer-1" id="mcq-wrong-answer-1" class="input-textarea" placeholder="Add wrong answer here"></textarea>
              <textarea name="wrong-answer-2" id="mcq-wrong-answer-2" class="input-textarea" placeholder="Add wrong answer here"></textarea>
              <textarea name="wrong-answer-3" id="mcq-wrong-answer-3" class="input-textarea" placeholder="Add wrong answer here"></textarea>
            </div>

          </form>

          <!-- True or False Form -->
          <form id="true-or-false-form" class="question-form" action="process-create-question.php" method="POST">
            <input type="hidden" name="question-type" value="true-false">

            <div class="question-input-container">
              <p>QUESTION</p>
              <textarea name="question" id="tf-question-input" class="input-textarea" placeholder="Add question here"></textarea>
            </div>

            <hr class="form-divider" />

            <div class="question-input-container">
              <p style="color: green;">Answer</p>
              <div class="true-false-container">
                <input type="radio" name="tf-answer" value="true" id="tf-true" class="radio-input">
                <label for="tf-true" class="radio-btn question-radio-btn">
                  <p>True</p>
                </label>
                <input type="radio" name="tf-answer" value="false" id="tf-false" class="radio-input">
                <label for="tf-false" class="radio-btn question-radio-btn">
                  <p>False</p>
                </label>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script>
    // --- DOM Elements ---
    const backArrow = document.querySelector('.backarrow');
    const cancelText = document.querySelector('.header-button-text');
    const createQuestionButton = document.getElementById("create-question-button");
    const questionTypeRadios = document.querySelectorAll('input[name="question-type"]');
    const tfRadioButtons = document.querySelectorAll('input[name="tf-answer"]');
    const shortTextForm = document.getElementById('short-text-form');
    const mcqForm = document.getElementById('mcq-form');
    const trueFalseForm = document.getElementById('true-or-false-form');

    // --- Textarea IDs ---
    const stTextareaIds = ['st-question', 'st-answer'];
    const mcqTextareaIds = ['mcq-correct-answer', 'mcq-wrong-answer-1', 'mcq-wrong-answer-2', 'mcq-wrong-answer-3'];
    const trueFalseTextareaIds = ['tf-question-input'];
    const textareaIds = [...stTextareaIds, ...mcqTextareaIds, ...trueFalseTextareaIds];

    // --- Event Listeners for Back Button ---
    backArrow.addEventListener('click', goBack);
    cancelText.addEventListener('click', goBack);

    function goBack() {
      window.location.href = 'edit-quiz.php?quiz_id=' + <?php echo $quizId; ?>;
    }

    // --- Event Listeners for Textareas ---
    textareaIds.forEach(id => {
      const textarea = document.getElementById(id);
      if (textarea) {
        textarea.addEventListener('input', () => {
          resizeTextarea(textarea);
          updateButtonEnabled();
        });
      }
    });

    function resizeTextarea(textarea) {
      textarea.style.height = "auto";
      textarea.style.height = `${textarea.scrollHeight}px`;
    }

    // --- Form Management Functions ---
    function hideAllForms() {
      shortTextForm.style.display = 'none';
      mcqForm.style.display = 'none';
      trueFalseForm.style.display = 'none';
    }

    function updateButtonEnabled() {
      if (checkButtonEnabled()) {
        createQuestionButton.classList.add('create-question-button-enabled');
      } else {
        createQuestionButton.classList.remove('create-question-button-enabled');
      }
    }

    // --- Button Enablement Logic ---
    function checkButtonEnabled() {
      if (getComputedStyle(shortTextForm).display === 'block') {
        return stTextareaIds.every(id => {
          const textarea = document.getElementById(id);
          return textarea && textarea.value.trim() !== '';
        });
      } else if (getComputedStyle(mcqForm).display === 'block') {
        return mcqTextareaIds.every(id => {
          const textarea = document.getElementById(id);
          return textarea && textarea.value.trim() !== '';
        });
      } else if (getComputedStyle(trueFalseForm).display === 'block') {
        const radioSelected = document.querySelector('input[name="tf-answer"]:checked') !== null;
        const allTextareasFilled = trueFalseTextareaIds.every(id => {
          const textarea = document.getElementById(id);
          return textarea && textarea.value.trim() !== '';
        });

        return radioSelected && allTextareasFilled;
      } else {
        console.log("Something went wrong, no form is visible.");
        return false;
      }
    }

    // --- Event Listeners for Question Type Selection ---
    questionTypeRadios.forEach(radio => {
      radio.addEventListener('change', function () {
        hideAllForms();
        if (this.value === 'short-text') {
          shortTextForm.style.display = 'block';
        } else if (this.value === 'mcq') {
          mcqForm.style.display = 'block';
        } else if (this.value === 'True or false') {
          trueFalseForm.style.display = 'block';
        }
        updateButtonEnabled();
      });
    });

    // --- Event Listeners for True/False Radio Buttons ---
    tfRadioButtons.forEach(radio => {
      radio.addEventListener('change', () => {
        updateButtonEnabled();
      });
    });

    // --- Default State Setup ---
    hideAllForms();
    const defaultRadio = document.querySelector('input[name="question-type"][value="short-text"]');
    if (defaultRadio) {
      defaultRadio.checked = true;
      shortTextForm.style.display = 'block';
    }

    // --- Submit the form based on question type ---
    createQuestionButton.addEventListener('click', function (event) {
      if (checkButtonEnabled() == false) return console.log("button not enabled");
      event.preventDefault(); 

      if (getComputedStyle(shortTextForm).display === 'block') {
        shortTextForm.submit();
      } else if (getComputedStyle(mcqForm).display === 'block') {
        mcqForm.submit();
      } else if (getComputedStyle(trueFalseForm).display === 'block') {
        trueFalseForm.submit();
      } else {
        console.log("No form is currently visible to submit.");
      }
    });
    </script>
  </body>
</html>
