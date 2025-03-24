<?php
include '../includes/auth.php';
include '../includes/db.php';

if (!isLoggedIn() || !isAdmin()) {
    header("Location: ../login.php");
    exit;
}

// Ensure 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: User ID is missing.");
}

$user_id = (int) $_GET['id']; // Convert to integer for safety

// Fetch user details
$stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if user exists
if (!$user) {
    die("Error: User not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);

    // Validate inputs
    if (empty($username) || empty($email) || empty($role)) {
        die("Error: All fields are required.");
    }

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $role, $user_id);

    if ($stmt->execute()) {
        echo "User updated successfully!";
        header("Location: manage_users.php"); // Redirect to user list
        exit;
    } else {
        die("Error: " . $stmt->error);
    }
}
?>

<!-- User Edit Form -->
<form method="POST">
    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    <select name="role" required>
        <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="client" <?php echo ($user['role'] == 'client') ? 'selected' : ''; ?>>Client</option>
    </select>
    <button type="submit">Update User</button>
</form>
