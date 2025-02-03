<?php
include 'config.php';
include 'header_all.php';
session_start();

if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit();
}

$member_id = $_SESSION['member_id'];

class MemberProfile {
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

    public function displayProfile() {
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-3">
        <h2 class="text-center">View Profile</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="card-title">Profile Details</h4>
                <hr>
                <p><strong>Name:</strong> <?= $this->memberData['member_name']; ?></p>
                <p><strong>Member Created:</strong> <?= $this->memberData['member_created']; ?></p>
                <p><strong>Membership:</strong> <?= $this->memberData['member_type']; ?></p>
                <p><strong>Email:</strong> <?= $this->memberData['member_email']; ?></p>
            </div>
        </div>
        <div class="mt-3 text-center">
            <a href="member_dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>
<?php
    }
}

$profile = new MemberProfile($conn, $member_id);
$profile->fetchMemberDetails();
$profile->displayProfile();
?>