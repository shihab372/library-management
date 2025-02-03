<?php
include 'config.php';

session_start();

if (!isset($_SESSION['librarian_id'])) {
    header("Location: librarian_login.php");
    exit();
}

$librarian_id = $_SESSION['librarian_id'];

class LibrarianDashboard {
    public $conn;
    public $librarianId;
    public $librarianData;

    public function __construct($dbConnection, $librarian_id) {
        $this->conn = $dbConnection;
        $this->librarianId = $librarian_id;
    }

    public function fetchLibrarianDetails() {
        $sql = "SELECT * FROM librarian_details WHERE librarian_id = $this->librarianId";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $this->librarianData = $result->fetch_assoc();
        } else {
            die("Librarian not found.");
        }
    }

    public function getLibrarianName() {
        return $this->librarianData['librarian_name'];
    }

    public function showDashboard() {
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 12vh;
        }
        .card {
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-body p {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>

<nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand text-white ms-2">Librarian's Dashboard</a>
    <form class="form-inline d-flex me-3">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" style="color: white;">Search</button>
    </form>
</nav>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Welcome, <?= $this->getLibrarianName() ?></h1>
        <p class="text-center text-muted">Your Librarian Dashboard</p>

        <div class="mt-4">
            <div class="row">
                <!-- View Profile -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>View Profile</h4>
                            <p>Access and review your personal details and information.</p>
                            <a href="view_librarian_profile.php" class="btn btn-success">View Profile</a>
                        </div>
                    </div>
                </div>

                <!-- Add Books -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>Add Books</h4>
                            <p>Add new books to the library’s inventory with ease.</p>
                            <a href="add_book.php" class="btn btn-primary">Add Books</a>
                        </div>
                    </div>
                </div>

                <!-- Manage Books -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>Manage Books</h4>
                            <p>Update or remove books from the library’s collection.</p>
                            <a href="manage_books.php" class="btn btn-warning">Manage Books</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Transactions -->
            <div class="row mt-4">
                <div class="col-md-4 offset-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>Book Transactions</h4>
                            <p>Handle issuing and returning of books for members.</p>
                            <a href="transaction.php" class="btn btn-info">Manage Transactions</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logout -->
            <div class="text-center mt-4">
                <a href="librarian_logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y') ?> Library Management System. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
    }
}

$dashboard = new LibrarianDashboard($conn, $librarian_id);
$dashboard->fetchLibrarianDetails();
$dashboard->showDashboard();
?>
