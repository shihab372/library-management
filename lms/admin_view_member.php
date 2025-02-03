<?php
include_once 'header_all.php';
include 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Members class
class Members {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Fetch all members from the database
    public function getAllMembers() {
        $query = "SELECT member_id, member_name, member_email, member_type FROM member_details";
        return $this->conn->query($query);
    }
}

// Initialize Members class and fetch all members
$membersClass = new Members($conn);
$members = $membersClass->getAllMembers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Library Members</h1>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Member Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($members && $members->num_rows > 0): ?>
                    <?php while ($row = $members->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['member_id'] ?></td>
                            <td><?= $row['member_name'] ?></td>
                            <td><?= $row['member_email'] ?></td>
                            <td><?= $row['member_type'] ?></td>
                            <td>
                                <a href="fine_member.php?member_id=<?= $row['member_id'] ?>" 
                                   class="btn btn-warning btn-sm">Fine</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No members found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
