<?php

include_once('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Form validation
    if (empty($email) || empty($password)) {
        die("Both email and password are required!");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format!");
    }

    // Check role
    $role = $_POST['role'] ?? '';
    if (empty($role)) {
        die("Please select a role!");
    }

    // Determine role
    if ($role === 'student') {
        $user = Database::getStudentByEmail($email);
    } elseif ($role === 'lecturer') {
        $user = Database::getLecturerByEmail($email);
    } else {
        die("Invalid role selected!");
    }

    // Get all banned emails
    $bannedEmails = Database::getAllBannedEmails();
    $bannedEmailsList = array_column($bannedEmails, 'email'); // Extract emails from the result

    // Check if the user email is banned
    if (in_array($email, $bannedEmailsList)) {
        echo "Your account has been banned. Please contact support.";
        exit;  // Stop further execution
    }

    // Check if user exists
    if ($user) {
        // For student login
        if ($role === 'student' && password_verify($password, $user['student_password'])) {
            // Start session and set session variables
            session_start();
            $_SESSION['student_id'] = $user['student_id'];
            $_SESSION['role'] = 'student';
            echo "Login successful! Welcome, " . $user['student_name'];
            header("Location: explore.php");
        }
        // For lecturer login
        elseif ($role === 'lecturer' && password_verify($password, $user['lecturer_password'])) {
            // Check if the lecturer is approved by admin
            if ($user['admin_id'] === null) {
                echo "Your account has not been approved by an admin yet. Please contact support.";
                exit;
            }

            // Start session and set session variables
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
