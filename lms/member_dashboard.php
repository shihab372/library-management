<?php
include 'config.php';

session_start();

if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit();
}

$member_id = $_SESSION['member_id'];

class MemberDashboard {
    public $conn;
    public $memberId;
    public $memberData;

    public function __construct($dbConnection, $member_id) {
        $this->conn = $dbConnection;
        $this->memberId = $member_id;
    }

    public function fetchMemberDetails() {
        $sql = "SELECT * FROM member_details WHERE member_id = $this->memberId";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $this->memberData = $result->fetch_assoc();
        } else {
            die("Member not found.");
        }
    }

    public function getMemberName() {
        return $this->memberData['member_name']; 
    }

    public function showDashboard() {
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
          footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 6vh;
        }
    .card {
        transition: transform 0.3s;
    }

    .card:hover {
        transform: scale(1.05);
    }
    </style>
</head>
<nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand text-white ms-2">Member's Dashboard</a>
    <form class="form-inline d-flex me-3">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" style="color: white;">Search</button>
    </form>
</nav>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Welcome, <?= $this->getMemberName() ?></h1>
        <p class="text-center text-muted">Your Reading Journey Begins Here!</p>

        <div class="mt-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>View Profile</h4>
                            <p>Check and review your personal details and membership information.</p>
                            <a href="view_member_profile.php" class="btn btn-success">View Profile</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>Update Profile</h4>
                            <p>Keep your personal information up-to-date for a better experience.</p>
                            <a href="update_member_profile.php" class="btn btn-primary">Update Profile</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>View Booklist</h4>
                            <p>Explore the library's collection and discover your next read.</p>

                            <a href="view_book.php" class="btn btn-warning">View Booklist</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>Request Book</h4>
                            <p>Reserve the books you want to borrow from the library.</p>
                            <a href="request_book.php" class="btn btn-info">Request Book</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>Return Book</h4>
                            <p>Manage and confirm the return of borrowed books on time.</p>
                            <a href="return_book.php" class="btn btn-primary" style="background-color: #064247; border-color: #064247;">Return Book</a>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h4>View Fine Report</h4>
                            <p>Check details of any outstanding fines and payment history.</p>
                            <a href="view_fine_report.php" class="btn btn-primary" style="background-color: #5F1F30; border-color: #5F1F30;">View Fine Report</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="member_logout.php" class="btn btn-danger">Logout</a>
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

$dashboard = new MemberDashboard($conn, $member_id);
$dashboard->fetchMemberDetails();
$dashboard->showDashboard();
?>
