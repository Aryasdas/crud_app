<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['file'];
    $target_dir = "../uploads/files/";
    $file_path = uploadFile($file, $target_dir);

    if ($file_path) {
        $stmt = $conn->prepare("INSERT INTO files ( file_name, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $_SESSION['user_id'], basename($file['name']), $file_path);

        if ($stmt->execute()) {
            echo "File uploaded successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading file!";
    }
}
?>

<form method="POST" action="" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <button type="submit">Upload File</button>
</form>