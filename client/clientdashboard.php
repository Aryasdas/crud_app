<?php
// Include necessary files
include '../includes/auth.php';
include '../includes/db.php';

// Ensure only logged-in clients can access this page
if (!isLoggedIn()) {
    redirect('../login.php');
}

// Fetch client details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $profile_image);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <p>Email: <?php echo htmlspecialchars($email); ?></p>
    <?php if ($profile_image): ?>
        <img src="../uploads/images/<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image" width="100">
    <?php else: ?>
        <p>No profile image uploaded.</p>
    <?php endif; ?>
    <ul>
        <li><a href="profile.php">Update Profile</a></li>
        <li><a href="view_files.php">View Files</a></li>
        <li><a href="view_images.php">View Images</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>