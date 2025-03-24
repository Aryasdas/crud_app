<?php
include '../includes/auth.php';
include '../includes/db.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

// Fetch all users
$stmt = $conn->prepare("SELECT id, username, email, role, profile_image FROM users");
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Manage Users</h2>
<a href="create_user.php">Create New User</a>
<a href="upload_file.php">upload_file</a>
<a href="view_files.php">view_files</a>
<table boder ="1">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Profile Image</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['role']; ?></td>
        <td>
            <?php if ($row['profile_image']): ?>
                <img src="../uploads/images/<?php echo $row['profile_image']; ?>" width="50">
            <?php else: ?>
                No Image
            <?php endif; ?>
        </td>
        <td>
            <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>
            <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>