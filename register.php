<form action="register.php" method="POST">
    <input type="text" name="username" placeholder="Enter Username">
    <input type="email" name="email" placeholder="Enter Email">
    <input type="password" name="password" placeholder="Enter Password">
    <button type="submit">Register</button>
</form>
<?php 
include "includes/db.php";
include "includes/functions.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if required fields are set
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate inputs
    if (empty($username) || empty($email) || empty($password)) {
        die("Error: All fields are required.");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare and execute the query
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
    // Print POST data for debugging
    print_r($_POST);
    exit;  // Stop execution here to inspect the output
?>

