<?php

session_start(); // Ensure the session is started before accessing it

// Check if there is any session data
if (!empty($_SESSION)) {
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
} else {
    echo "No session data available.";
}
