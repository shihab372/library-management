<?php
include 'config.php';

session_start();

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit();
}

$member_id = $_SESSION['member_id'];

// Fetch the member report
$query = "SELECT member_name, member_report FROM member_details WHERE member_id = $member_id";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $member = $result->fetch_assoc();
} else {
    die("No report found for this member.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Member Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Welcome, <?= $member['member_name'] ?></h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Your Fine Report</h5>
                <p class="card-text">
                    <?= $member['member_report'] ? $member['member_report'] : 'No report available.' ?>
                </p>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="member_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
