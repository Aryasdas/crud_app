<?php
// Include necessary files
include '../includes/auth.php';
include '../includes/db.php';

// Ensure only logged-in clients can access this page
if (!isLoggedIn()) {
    redirect('../login.php');
}

// Fetch images from the database

$stmt = $conn->prepare("SELECT images FROM users");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row["images"] . "<br>";
    }
} else {
    echo "0 results";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Images</title>
</head>
<body>
    <h1>Uploaded Images</h1>
    <?php if ($result->num_rows === 0): ?>
        <p>No images found.</p>
    <?php else: ?>
        <div>
            <?php while ($row = $result->fetch_assoc()): ?>
            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="<?php echo htmlspecialchars($row['image_name']); ?>" width="200">
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    <p><a href="clientdashboard.php">Back to Dashboard</a></p>
</body>
</html>