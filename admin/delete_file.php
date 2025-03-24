<?php
// Include necessary files
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/functions.php';

// Ensure only logged-in admins can access this page
if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

// Check if the file ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "Error: File ID not provided.";
    exit;
}

$file_id = $_GET['id'];

// Fetch file details from the database
$stmt = $conn->prepare("SELECT file_path FROM files WHERE id = ?");
$stmt->bind_param("i", $file_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo "Error: File not found.";
    exit;
}

$stmt->bind_result($file_path);
$stmt->fetch();
$stmt->close();

// Delete the file from the server
if (file_exists($file_path)) {
    if (unlink($file_path)) {
        // File deleted successfully, now delete the record from the database
        $stmt = $conn->prepare("DELETE FROM files WHERE id = ?");
        $stmt->bind_param("i", $file_id);

        if ($stmt->execute()) {
            echo "File deleted successfully!";
        } else {
            echo "Error: Failed to delete file record from the database.";
        }

        $stmt->close();
    } else {
        echo "Error: Failed to delete file from the server.";
    }
} else {
    echo "Error: File does not exist on the server.";
}

// Redirect back to the file management page
redirect('view_files.php');
?>