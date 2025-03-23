
<?php
include '../includes/auth.php';
if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

echo "Welcome, Admin!";
?>
