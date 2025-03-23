<form action="register.php" method="POST">
    <input type="text" name="username" placeholder="Enter Username" required>
    <input type="email" name="email" placeholder="Enter Email" required>
    <input type="password" name="password" placeholder="Enter Password" required>
    <select name="role">
        <option value="client">Client</option>
        <option value="admin">Admin</option>
    </select>
    <button type="submit">Register</button>
</form>

<?php 
include "includes/db.php";
include "includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize input
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : 'client'; // Default to 'client'

    // Validate inputs
    if (empty($username) || empty($email) || empty($password)) {
        die("Error: All fields are required.");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare and execute query
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
