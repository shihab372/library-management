<?php
include 'config.php';
include 'header_all.php';

class MemberReport {
    public $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function updateReport($memberId, $report) {
        // Update the member_report column for the given member_id
        $sql = "UPDATE member_details SET member_report = '$report' WHERE member_id = $memberId";

        if ($this->conn->query($sql)) {
            return "Member report updated successfully!";
        } else {
            return "Error: " . $this->conn->error;
        }
    }
}

$memberReport = new MemberReport($conn);
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch input data
    $memberId = intval($_POST['member_id']);
    $report = $_POST['report'];

    // Update member report and display the result message
    $message = $memberReport->updateReport($memberId, $report);
    echo "<script>alert('$message');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Update Member Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Update Member Report</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="member_id">Member ID</label>
                <input type="number" name="member_id" id="member_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="report">Report Description</label>
                <textarea name="report" id="report" rows="5" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-3">send report</button>
        </form>

        <div class="text-center mt-4">
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>
