<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['profile_image'])) {
        $image = $_FILES['profile_image'];
        $target_dir = "../uploads/images/";
        $image_path = uploadFile($image, $target_dir);

        if ($image_path) {
            $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
            $image_name = basename($image['name']);
            $user_id = $_SESSION['user_id'];
            $stmt->bind_param("si", $image_name, $user_id);
            $stmt->execute();
        }
        
        

            if ($stmt->execute()) {
                echo "Profile image updated successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error uploading image!";
        }
    }

?>

<form method="POST" action="" enctype="multipart/form-data">
    <input type="file" name="profile_image" required>
    <button type="submit">Upload Profile Image</button>
</form>