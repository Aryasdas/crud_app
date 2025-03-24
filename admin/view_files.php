<?php
// Include necessary files
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/functions.php';

// Ensure only logged-in admins can access this page
if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

// Fetch all files from the database
$stmt = $conn->prepare("SELECT id, file_name, file_path FROM files");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Files</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Uploaded Files</h1>
    <?php if ($result->num_rows === 0): ?>
        <p>No files found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>File Name</th>
                <th>Download</th>
                <th>Delete</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['file_name']); ?></td>
                <td><a href="<?php echo htmlspecialchars($row['file_path']); ?>" download>Download</a></td>
                <td>
                    <a href="delete_file.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this file?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
</body>
</html>