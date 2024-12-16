<?php
// Simulate session and include database logic
session_start();
include_once('database.php');

try {
    // Fetch lecturers without an admin from the database
    $lecturers = Database::getLecturersWithoutAdmin();

    // Fetch non-banned students
    $users = Database::getStudentsNotBanned();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit(); // Stop further execution if there's a database error
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="css/admin-dashboard.css"> <!-- External CSS -->
        <script>
        function openTab(evt, tabName) {
            var i, tabContent, tabLinks;
            tabContent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            tabLinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tabLinks.length; i++) {
                tabLinks[i].className = tabLinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function banUser(userId) {
            const reason = document.getElementById(`reason-${userId}`).value.trim();
            if (!reason) {
                alert('Please enter a reason for banning the user.');
                return;
            }
            window.location.href = `process-ban-user.php?user_id=${userId}&reason=${encodeURIComponent(reason)}`;
        }

        function approveLecturer(lecturerId) {
            if (confirm("Are you sure you want to approve this lecturer?")) {
                window.location.href = `process-lecturer-approval.php?action=approve&lecturer_id=${lecturerId}`;
            }
        }

        function rejectLecturer(lecturerId) {
            if (confirm("Are you sure you want to reject this lecturer?")) {
                window.location.href = `process-lecturer-approval.php?action=reject&lecturer_id=${lecturerId}`;
            }
        }
        </script>
    </head>

    <body>
        <div class="main-content">
            <div class="topbar">
                <h1>Welcome, Admin!</h1>
            </div>

            <!-- Tab Navigation -->
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'banUsers')">Ban Users</button>
                <button class="tablinks" onclick="openTab(event, 'approveLecturers')">Approve Lecturers</button>
            </div>

            <!-- Ban Users Section -->
            <div id="banUsers" class="tabcontent">
                <h2>Ban Users</h2>
                <div class="user-list">
                    <?php foreach ($users as $user): ?>
                    <div class="user-card">
                        <h3><?php echo htmlspecialchars($user['student_name']); ?></h3>
                        <p>Email: <?php echo htmlspecialchars($user['student_email']); ?></p>
                        <textarea id="reason-<?php echo $user['student_id']; ?>" placeholder="Enter reason for banning"></textarea>
                        <a 
                            href="#" 
                            class="ban-link" 
                            onclick="banUser('<?php echo $user['student_id']; ?>')">
                            Ban User
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Approve Lecturers Section -->
            <div id="approveLecturers" class="tabcontent">
                <h2>Approve Lecturers</h2>
                <div class="lecturer-list">
                    <?php foreach ($lecturers as $lecturer): ?>
                    <div class="lecturer-card">
                        <h3><?php echo htmlspecialchars($lecturer['lecturer_name']); ?></h3>
                        <p>Email: <?php echo htmlspecialchars($lecturer['lecturer_email']); ?></p>
                        <p>Registration Date: <?php echo htmlspecialchars($lecturer['lecturer_created_at']); ?></p>
                        <div class="action-buttons">
                            <button class="approve-button" onclick="approveLecturer(<?php echo $lecturer['lecturer_id']; ?>)">Approve</button>
                            <button class="reject-button" onclick="rejectLecturer(<?php echo $lecturer['lecturer_id']; ?>)">Reject</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </body>

</html>
