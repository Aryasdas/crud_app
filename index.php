<?php
session_start();
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Management System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 30px;
        }
        .hero {
            text-align: center;
            padding: 50px 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }
        .feature-card {
            flex: 1 1 300px;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .cta-buttons {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .btn-secondary {
            background-color: #95a5a6;
        }
        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #2c3e50;
            color: white;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>File Management System</h1>
            <p>Easily upload, manage, and share your files</p>
        </div>
    </header>

    <div class="container">
        <section class="hero">
            <h2>Welcome to Our File Management System</h2>
            <p>A secure platform for uploading, organizing, and sharing your files with ease.</p>
            
            <div class="cta-buttons">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo ($_SESSION['role'] === 'admin') ? 'admin/dashboard.php' : 'client/dashboard.php'; ?>" class="btn">Go to Dashboard</a>
                    <a href="logout.php" class="btn btn-secondary">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn">Login</a>
                    <a href="register.php" class="btn btn-secondary">Register</a>
                <?php endif; ?>
            </div>
        </section>

        <section class="features">
            <div class="feature-card">
                <h3>File Upload</h3>
                <p>Securely upload your files to our system with just a few clicks.</p>
            </div>
            <div class="feature-card">
                <h3>Organize</h3>
                <p>Categorize and manage your files for easy access anytime.</p>
            </div>
            <div class="feature-card">
                <h3>Share</h3>
                <p>Easily share files with other users or download them when needed.</p>
            </div>
        </section>

        <section class="feature-card">
            <h3>About This System</h3>
            <p>Our File Management System provides a complete solution for handling your documents, images, and other files. With separate interfaces for administrators and regular users, you get exactly the functionality you need.</p>
            <p>Administrators can manage all users and files, while regular users can upload and manage their own content.</p>
        </section>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> File Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>