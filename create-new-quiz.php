<?php
session_start();
if (!isset($_SESSION['lecturer_id'])) {
  header("Location: login.php");
  exit;
} else {
  $user_id = $_SESSION['lecturer_id'];
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Web Page</title>
    <!-- External CSS file link (optional) -->
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>

    <!-- Header Section -->
    <header class="navbar">
    </header>
    <div class="container">
      <svg class="backarrow" width="31" height="26" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg" color="#6A6B6A"><path d="M28.5741 12.0023C28.5741 12.4569 28.3935 12.893 28.072 13.2144C27.7505 13.5359 27.3145 13.7165 26.8599 13.7165H5.86103L13.2178 21.0732C13.3776 21.2325 13.5044 21.4217 13.5909 21.6301C13.6774 21.8385 13.722 22.0619 13.722 22.2875C13.722 22.5131 13.6774 22.7365 13.5909 22.9448C13.5044 23.1532 13.3776 23.3424 13.2178 23.5017C12.8943 23.821 12.4581 24 12.0036 24C11.549 24 11.1128 23.821 10.7893 23.5017L0.504181 13.2165C0.344373 13.0573 0.217574 12.868 0.131055 12.6597C0.0445364 12.4513 0 12.2279 0 12.0023C0 11.7767 0.0445364 11.5533 0.131055 11.3449C0.217574 11.1366 0.344373 10.9474 0.504181 10.7881L10.7893 0.502946C11.1114 0.180915 11.5481 0 12.0036 0C12.2291 0 12.4523 0.044416 12.6607 0.130712C12.869 0.217007 13.0583 0.343493 13.2178 0.502946C13.3772 0.6624 13.5037 0.851699 13.59 1.06003C13.6763 1.26837 13.7207 1.49166 13.7207 1.71717C13.7207 1.94267 13.6763 2.16596 13.59 2.3743C13.5037 2.58263 13.3772 2.77193 13.2178 2.93138L5.86103 10.2881H26.8599C27.3145 10.2881 27.7505 10.4687 28.072 10.7902C28.3935 11.1117 28.5741 11.5477 28.5741 12.0023Z" fill="#6A6B6A"></path></svg>
      <form action="process-create-new-quiz.php" method="POST">
        <div class="content">
          <p class="question-title">Create New Quiz</p>
          <div class="input-container">
            <div class="input-section">
              <p class="input-title">Quiz Name:</p> 
              <textarea name="quiz-name" id="quiz-name-input" class="textarea-input" placeholder="Enter quiz name" rows="1"></textarea>
            </div>
            <div class="input-section">
              <p class="input-title">Quiz Description:</p> 
              <textarea name="quiz-description" id="quiz-description-input" class="textarea-input" placeholder="Enter quiz description"></textarea>
            </div>
            <div class="input-section">
              <p class="input-title">Visibility:</p> 
              <div class="visibility-btn-container">
                <input name="quiz-visibility" value="public" type="radio" id="visibility-public" class="radio-input">
                <label for="visibility-public" class="radio-btn">
                  <img src="assets/public-icon.svg" alt="Public"> 
                  <p>Public</p>
                </label>
                <input type="radio" value="private" name="quiz-visibility" id="visibility-private" class="radio-input">
                <label for="visibility-private" class="radio-btn">
                  <img src="assets/private-icon.svg" alt="Private"> 
                  <p>Private</p>
                </label>
              </div>
            </div>
          </div>
          <button type="submit" class="btn" disabled>
            <img src="assets/plus-icon.svg" alt="Plus">
            <p>Create Quiz</p>
          </button>
        </div>
      </form>
    </div>

    <script>
    const quizNameInput = document.getElementById('quiz-name-input');
    const quizDescriptionInput = document.getElementById('quiz-description-input');
    const visibilityRadios = document.querySelectorAll('input[name="quiz-visibility"]');
    const button = document.querySelector('.btn');

    // Function to check if all required fields are filled
    function checkForm() {
      const isQuizNameFilled = quizNameInput.value.trim() !== '';
      const isQuizDescriptionFilled = quizDescriptionInput.value.trim() !== '';
      const isVisibilitySelected = Array.from(visibilityRadios).some(radio => radio.checked);

      // Enable/Disable the button based on the form's completeness
      if (isQuizNameFilled && isQuizDescriptionFilled && isVisibilitySelected) {
        button.classList.add('btn-enabled');
        button.disabled = false;  // Enable the button
      } else {
        button.classList.remove('btn-enabled');
        button.disabled = true;   // Disable the button
      }
    }

    // Event listeners to check form on input changes
    quizNameInput.addEventListener('input', () => {
      quizNameInput.style.height = "auto"; // Reset height to calculate the new height
      quizNameInput.style.height = quizNameInput.scrollHeight + 'px'; // Set new height based 
      checkForm()
    });
    quizDescriptionInput.addEventListener('input', () => {
      quizDescriptionInput.style.height = "auto"; // Reset height to calculate the new height
      quizDescriptionInput.style.height = quizDescriptionInput.scrollHeight + 'px'; // Set new height based 
      checkForm()
      
    });
    visibilityRadios.forEach(radio => radio.addEventListener('change', checkForm));

    // Initial check on page load
    checkForm();
    </script>
  </body>
</html>
