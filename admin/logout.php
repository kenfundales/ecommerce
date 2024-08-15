<?php
    // Start the session
    session_start();

    // Check if the session variable for the user exists
    if(isset($_SESSION['aid'])) {
        // Unset the session variable for the user
        unset($_SESSION['aid']);
    }
    // Redirect to login page
    header("Location:login.php");
    exit;
?>
