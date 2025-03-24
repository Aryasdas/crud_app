<?php
// Start session and include necessary files
session_start();
include '../includes/db.php';
include '../includes/functions.php';

// Unset all session variables
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();

// Redirect to login page with success message
$_SESSION['message'] = "You have been successfully logged out.";
// redirect('../login.php');
?>