<?php

include 'config.php';
include 'header.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $librarian_name = $_POST['librarian_name']; 
    $password = $_POST['password']; 

    // Check if inputs are not empty
    if (!empty($librarian_name) && !empty($password)) {
    
        $sql = "SELECT * FROM librarian_details WHERE librarian_name = '$librarian_name'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $librarian = $result->fetch_assoc();

            // Compare password
            if ($password === $librarian['librarian_password']) {
                // Set session variables
                $_SESSION['librarian_id'] = $librarian['librarian_id'];
                $_SESSION['librarian_name'] = $librarian['librarian_name'];

                // Redirect to dashboard
                header("Location: librarian_dashboard.php");
                exit;
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Librarian not found.";
        }
    } else {
        $error = "Librarian Name and Password cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 5vh;
        }

        .login-container {
            max-width: 900px;
            margin: 50px auto;
            height: 70vh;
            display: flex;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .illustration {
            background-color: #4a90e2;
            color: white;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .illustration img {
            width: 100%;
        }
        .form-container {
            flex: 1;
            background-color: white;
            padding: 40px;
        }
        .form-container h2 {
            margin-bottom: 30px;
            color: #4a90e2;
        }
        .btn-primary {
            background-color: #4a90e2;
            border-color: #4a90e2;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="illustration">
            <img src="l.jpg" alt="Illustration">
        </div>
        <div class="form-container">
            <h2>Librarian Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="librarian_name" class="form-label">Librarian Name</label>
                    <input type="text" name="librarian_name" id="librarian_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; <?= date('Y') ?> Library Management. All Rights Reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
