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

    if ($role === 'student') {
        Database::createStudent($email, $password, $name);
    } elseif ($role === 'lecturer') {
        Database::createLecturer($email, $password, $name);
    } else {
        die("Invalid role selected!");
    }
    header("Location: login-register.php");
}
