<?php

include_once('database.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // form validation
    if (empty($email) || empty($password)) {
        die("Both email and password are required!");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format!");
    }
    // check role
    $role = $_POST['role'] ?? '';
    if (empty($role)) {
        die("Please select a role!");
    }

    // determine role
    if ($role === 'student') {
        $user = Database::getStudentByEmail($email);
    } elseif ($role === 'lecturer') {
        $user = Database::getLecturerByEmail($email);
    } else {
        die("Invalid role selected!");
    }

    // user check
    if ($user) {
        // pw verification
        if ($role === 'student' && password_verify($password, $user['student_password'])) {
            // Start session and set session variables
            session_start();
            $_SESSION['student_id'] = $user['student_id'];
            $_SESSION['role'] = 'student';
            echo "Login successful! Welcome, " . $user['student_name'];
            header("Location: explore.php");
        } elseif ($role === 'lecturer' && password_verify($password, $user['lecturer_password'])) {
            // start session
            session_start();
            $_SESSION['lecturer_id'] = $user['lecturer_id'];
            $_SESSION['role'] = 'lecturer';
            header("Location: lecturer-dashboard.php");
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that email!";
    }
}
