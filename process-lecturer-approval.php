<?php

//TODO: remove this later
session_start();
include_once('database.php');
$_SESSION['admin_id'] = 1;

if (isset($_GET['action']) && isset($_GET['lecturer_id'])) {
    $action = $_GET['action'];
    $lecturerId = $_GET['lecturer_id'];
    $adminId = $_SESSION['admin_id'];

    try {
        // Check if the lecturer exists
        echo "Lecturer ID: " . $lecturerId;
        $lecturer = Database::getLecturer($lecturerId);

        if (!$lecturer) {
            echo "Lecturer not found.";
            exit();
        }

        if ($action === 'approve') {
            // Update lecturer status to approved
            Database::approveLecturer($lecturerId, $adminId);
            echo "Lecturer approved successfully.";
        } elseif ($action === 'reject') {
            // Reject the lecturer
            Database::rejectLecturer($lecturerId);
            echo "Lecturer rejected.";
        } else {
            echo "Invalid action.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    header("Location: admin-dashboard.php");
} else {
    echo "Invalid request.";
}
