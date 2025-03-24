
<?php
include '../includes/auth.php';
if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

echo "Welcome, Admin!";
?>
<a href="manage_users.php">Manage users</a>
<a href="profile.php">upload profile image</a>
<a href="logout.php">logout</a>