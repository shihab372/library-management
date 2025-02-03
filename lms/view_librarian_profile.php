<?php
include 'config.php';
include 'librarian.php'; // Include the Librarian class
include 'header_all.php';

session_start();

if (!isset($_SESSION['librarian_id'])) {
    header("Location: librarian_login.php");
    exit();
}

$librarian_id = $_SESSION['librarian_id'];

class LibrarianProfile {
    public $librarian;
    public $librarianData;

    public function __construct($dbConnection, $librarian_id) {
        $this->librarian = new Librarian($dbConnection); // Instantiate the Librarian class
        $this->librarianData = $this->librarian->getLibrarianDetails($librarian_id);
        if (!$this->librarianData) {
            die("Librarian not found.");
        }
    }

    public function displayProfile() {
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Librarian Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-3">
        <h2 class="text-center">Librarian Profile</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="card-title">Profile Details</h4>
                <hr>
                <!-- Display librarian details directly without htmlspecialchars -->
                <p><strong>Name:</strong> <?= $this->librarianData['librarian_name']; ?></p>
                <p><strong>Email:</strong> <?= $this->librarianData['librarian_email']; ?></p>
                <p><strong>Account Created:</strong> <?= $this->librarianData['librarian_created']; ?></p>
            </div>
        </div>
        <div class="mt-3 text-center">
            <a href="librarian_dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>
<?php
    }
}

$profile = new LibrarianProfile($conn, $librarian_id);
$profile->displayProfile();
?>
