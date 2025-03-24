<?php
// Include necessary files
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/functions.php';

// Ensure only logged-in clients can access this page
if (!isLoggedIn()) {
    redirect('../login.php');
}

$user_id = $_SESSION['user_id'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Update profile
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $user_id);

    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Handle profile image upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])) {
    $target_dir = "../uploads/images/";
    $image_path = uploadFile($_FILES['profile_image'], $target_dir);

    if ($image_path) {
        $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
        $stmt->bind_param("si", basename($_FILES['profile_image']['name']), $user_id);

        if ($stmt->execute()) {
            echo "Profile image uploaded successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading profile image.";
    }
}

// Fetch current profile details
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
    <title>Update Profile</title>
</head>
<body>
    <h1>Update Profile</h1>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
        <button type="submit">Update Profile</button>
    </form>

    <h2>Upload Profile Image</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="file" name="profile_image" required>
        <button type="submit">Upload Image</button>
    </form>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>