<?php
session_start();
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/functions.php';

// Check if the user is logged in and is an admin
if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if file is uploaded
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Error: No file uploaded or file upload failed.";
        redirect('upload_file.php');
        exit;
    }

    $file = $_FILES['file'];
    $target_dir = "../uploads/files/";

    // Create uploads directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Upload file and get file path
    $file_path = uploadFile($file, $target_dir);

    // Check if upload was successful
    if (!$file_path) {
        $_SESSION['error'] = "Error uploading file!";
        redirect('upload_file.php');
        exit;
    }

    // Get user ID (Ensure session user_id is set)
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "Error: User not authenticated.";
        redirect('upload_file.php');
        exit;
    }
    $user_id = $_SESSION['user_id'];
    
    // Get file name and timestamp
    $file_name = basename($file['name']);
    $uploaded_at = date('Y-m-d H:i:s');

    // Prepare and execute SQL query
    try {
        $stmt = $conn->prepare("INSERT INTO files ( file_name, file_path, uploaded_at) VALUES ( ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("isss", $file_name, $file_path, $uploaded_at);

        if ($stmt->execute()) {
            $_SESSION['success'] = "File uploaded successfully!";
        } else {
            throw new Exception("Error executing query: " . $stmt->error);
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        redirect('view_files.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <style>
        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Upload File</h1>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload File</button>
    </form>
    <p><a href="view_files.php">Back to Files List</a></p>
</body>
</html>
