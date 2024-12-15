<?php
include_once("process-register.php");
include_once("process-login.php");

session_start();
session_destroy();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Montserrat', sans-serif;
    }

    body{
      background-color: #c9d6ff;
      background: linear-gradient(to right, #e2e2e2, #c9d6ff);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      height: 100vh;
    }

    .container{
      background-color: #fff;
      border-radius: 30px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
      position: relative;
      overflow: hidden;
      width: 768px;
      max-width: 100%;
      min-height: 480px;
    }
    .container h4{
      align-items: center;
      padding: none;
    }
    .container p{
      font-size: 14px;
      line-height: 20px;
      letter-spacing: 0.3px;
      margin: 20px 0;
    }

    .container span{
      font-size: 12px;
    }

    .container a{
      color: #333;
      font-size: 13px;
      text-decoration: none;
      margin: 15px 0 10px;
    }

    .container button{
      background-color: #52a447;
      color: #fff;
      font-size: 12px;
      padding: 10px 45px;
      border: 1px solid transparent;
      border-radius: 8px;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-top: 10px;
      cursor: pointer;
    }

    .button-container {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      width: 100%;
      margin-top: 20px;
    }


    .role-button {
      background-color: #4169E1; 
      color: white;
      border: 2px solid transparent;
      border-radius: 50px; 
      padding: 10px 25px;
      font-size: 14px;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      cursor: pointer;
      transition: background-color 0.3s ease, border-color 0.3s ease;
      width: 100%;
      text-align: center;
    }


    .role-button:hover {
      background-color: #4169E1; 
      border-color: #fff; 
    }


    .role-button:active {
      background-color: #4169E1; 
    }


    .role-button.selected {
      background-color: #4169E1; 
      border-color: #fff; 
    }
    .role-button.selected::after {
      content: "";
      position: absolute;
      bottom: 0; 
      left: 0;
      width: 100%;
      height: 2px; 
      background-color: #fff; 
    }
    .role-button:not(.selected)::after {
      background-color: transparent; 
      width: 0; 
    }


    .role-button:focus {
      outline: 2px solid #fff;
    }


    .container button.hidden{
      background-color: transparent;
      border-color: #fff;
    }

    .container form{
      background-color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 0 40px;
      height: 100%;
    }

    .container input{
      background-color: #eee;
      border: none;
      margin: 8px 0;
      padding: 10px 15px;
      font-size: 13px;
      border-radius: 8px;
      width: 100%;
      outline: none;
    }

    .form-container{
      position: absolute;
      top: 0;
      height: 100%;
      transition: all 0.6s ease-in-out;
    }

    .sign-in{
      left: 0;
      width: 50%;
      z-index: 2;
    }

    .container.active .sign-in{
      transform: translateX(100%);
    }

    .sign-up{
      left: 0;
      width: 50%;
      opacity: 0;
      z-index: 1;
    }

    .container.active .sign-up{
      transform: translateX(100%);
      opacity: 1;
      z-index: 5;
      animation: move 0.6s;
    }

    @keyframes move{
    0%, 49.99%{
      opacity: 0;
      z-index: 1;
    }
    50%, 100%{
      opacity: 1;
      z-index: 5;
    }
    }

    .social-icons{
      margin: 20px 0;
    }

    .social-icons a{
      border: 1px solid #ccc;
      border-radius: 20%;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      margin: 0 3px;
      width: 40px;
      height: 40px;
    }

    .toggle-container{
      background-color: #52a447;
      position: absolute;
      top: 0;
      left: 50%;
      width: 50%;
      height: 100%;
      overflow: hidden;
      transition: all 0.6s ease-in-out;
      border-radius: 150px 0 0 100px;
      z-index: 1000;
    }

    .container.active .toggle-container{
      transform: translateX(-100%);
      border-radius: 0 150px 100px 0;
    }

    .toggle{
      background-color: #52a447;
      height: 100%;
      background: linear-gradient(to right, #5c6bc0, #52a447);
      color: #fff;
      position: relative;
      left: -100%;
      height: 100%;
      width: 200%;
      transform: translateX(0);
      transition: all 0.6s ease-in-out;
    }

    .container.active .toggle{
      transform: translateX(50%);
    }

    .toggle-panel{
      background-color: #52a447;
      position: absolute;
      width: 50%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 0 30px;
      text-align: center;
      top: 0;
      transform: translateX(0);
      transition: all 0.6s ease-in-out;
    }

    .toggle-left{
      transform: translateX(-200%);
    }

    .container.active .toggle-left{
      transform: translateX(0);
    }

    .toggle-right{
      right: 0;
      transform: translateX(0);
    }

    .container.active .toggle-right{
      transform: translateX(200%);
    }


    </style>
  </head>
  <body>
    <h1>Welcome to Learnleap!</h1>
    <div class="container" id="container">
      <div class="form-container sign-up">
        <form method="POST" action="process-register.php">
          <h1>Create Account</h1>
          <span>Use your email for registration!</span>
          <input type="text" name="name" placeholder="Name" required>
          <input type="email" name="email" placeholder="Email" required>
          <input type="password" name="password" placeholder="Password" required>
          <h4>Please select your role</h4>
          <div class="button-container">
            <label>
              <input type="radio" name="role" value="student" required> Student
            </label>
            <label>
              <input type="radio" name="role" value="lecturer" required> Lecturer
            </label>


          </div>

          <button type="submit">Sign Up</button>
        </form>
      </div>
      <div class="form-container sign-in">
        <form method="POST" action="process-login.php">
          <h1>Log In</h1>
          <span>Use your email and password to log in!</span>
          <input type="email" name="email" placeholder="Email" required>
          <input type="password" name="password" placeholder="Password" required>
          <div class="button-container">
            <label>
              <input type="radio" name="role" value="student" required> Student
            </label>
            <label>
              <input type="radio" name="role" value="lecturer" required> Lecturer
            </label>

          </div>

          <a href="#">Forgot your password?</a>
          <button type="submit">Sign In</button>
        </form>
      </div>
      <div class="toggle-container">
        <div class="toggle">
          <div class="toggle-panel toggle-left">
            <h1>Welcome Back!</h1>
            <p>Enter your personal details to use all features!</p>
            <button class="hidden" id="login">Sign in</button>

          </div>

          <div class="toggle-panel toggle-right">
            <h1>Hello!</h1>
            <p>Register with your personal details to use all features!</p>
            <button class="hidden" id="register">Sign Up</button>
          </div>
        </div>
      </div>
    </div>
    <script>
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');

    registerBtn.addEventListener('click', () => {
      container.classList.add("active");
    });

    loginBtn.addEventListener('click', () => {
      container.classList.remove("active");
    });
    // Get all radio buttons with the class 'role-button'
    const roleButtons = document.querySelectorAll('.role-input');

    // radio button listener
    roleButtons.forEach(button => {
      button.addEventListener('change', () => {
        // Remove 'selected' class from all buttons
        roleButtons.forEach(btn => btn.classList.remove('selected'));

        // role button selection
        if (button.checked) {
          button.classList.add('selected');
        }
      });
    });
    </script>
  </body>
</html>
