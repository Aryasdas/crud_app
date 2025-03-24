<?php
// Include necessary files
include '../includes/auth.php';
include '../includes/db.php';

// Ensure only logged-in clients can access this page
if (!isLoggedIn()) {
    redirect('../login.php');
}

// Fetch files from the database
$stmt = $conn->prepare("SELECT file_name, file_path FROM files");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Files</title>
</head>
<body>
    <h1>Uploaded Files</h1>
    <?php if ($result->num_rows === 0): ?>
        <p>No files found.</p>
    <?php else: ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <a href="<?php echo htmlspecialchars($row['file_path']); ?>" download>
                    <?php echo htmlspecialchars($row['file_name']); ?>
                </a>
            </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>
    <p><a href="clientdashboard.php">Back to Dashboard</a></p>
</body>
</html>