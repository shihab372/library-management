<?php
include 'config.php';
include 'header_all.php';

class Librarian {
    public $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function add($name, $email, $password) {
        
        $sql = "INSERT INTO librarian_details (librarian_name, librarian_email, librarian_password) 
                VALUES ('$name', '$email', '$password')";

        if ($this->conn->query($sql)) {
            return "Librarian added successfully!";
        } else {
            return "Error: " . $this->conn->error;
        }
    }
}

// Initialize the Librarian class
$librarian = new Librarian($conn);

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Add librarian and display the result message
    $message = $librarian->add($name, $email, $password);
    echo "<script>alert('$message');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Librarian</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Librarian</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Librarian Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Librarian Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Librarian</button>
        </form>

        <div class="text-center mt-4">
            <!-- Corrected Back to Dashboard Link -->
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>
