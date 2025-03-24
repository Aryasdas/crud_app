<?php
include '../includes/auth.php';
include '../includes/db.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

$user_id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "User deleted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
redirect('manage_users.php');