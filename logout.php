<?php
    // Start the session
    session_start();

    // Check if the session variable for the user exists
    if(isset($_SESSION['cid'])) {
        // Unset the session variable for the user
        unset($_SESSION['cid']);
    }
    // Redirect to login page
    header("Location:login.php");
    exit;
?>
