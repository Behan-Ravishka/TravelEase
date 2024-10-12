<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Unset session variables
    session_unset();
    session_destroy();
    
    // Redirect to index.php with a logout notification
    header("Location: index.php?logout=success");
    exit;
} else {
    // If not logged in, redirect to index.php
    header("Location: index.php");
    exit;
}
?>
