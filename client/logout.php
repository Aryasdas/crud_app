<?php
// Include necessary files
include '../includes/auth.php';

// Destroy the session
session_destroy();

// Redirect to login page
redirect('../login.php');
?>