<?php

include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = $_POST['role'] ?? ''; // 'student' or 'lecturer'

    // form validation
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        die("All fields are required!");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format!");
    }

    $lecturer = Database::getLecturerByEmail($email);

    $student = Database::getStudentByEmail($email);


    if (!empty($lecturer) || !empty($student)) {
        echo "This email is already registered. Please choose another one.";
    } else {
        echo "Email is available. Proceeding with account creation...";
        if ($role === 'student') {
            Database::createStudent($email, $password, $name);
        } elseif ($role === 'lecturer') {
            Database::createLecturer($email, $password, $name);
        } else {
            die("Invalid role selected!");
        }
        header("Location: login-register.php");
    }


}
