<?php

session_start();
$_SESSION['admin_id'] = 1;
include_once('database.php');

// Get the user ID and reason from the GET request
if (isset($_GET['user_id']) && isset($_GET['reason'])) {
    $userId = intval($_GET['user_id']);
    $reason = htmlspecialchars($_GET['reason'], ENT_QUOTES, 'UTF-8');
    $type = "student";

    // Call the Database class to ban the user
    $result = Database::banUser($userId, $type, $reason);
    header("Location: admin-dashboard.php");
}
