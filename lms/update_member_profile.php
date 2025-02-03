<?php
include 'config.php';
include 'member_class.php';
include 'header_all.php';
session_start();

if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit();
}

$member_id = $_SESSION['member_id'];
$member = new Member($conn);

// Fetch existing member details
$memberDetails = $member->getMemberDetails($member_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['member_name'];
    $email = $_POST['member_email'];
    $type = $_POST['member_type'];
    $password = $_POST['member_password'];

    // Check if password is provided
    if (empty($password)) {
        $password = null; 
    }

    // Update member details
    if ($member->updateMemberDetails($member_id, $name, $email, $type, $password)) {
        $success_message = "Profile updated successfully!";
        // Refresh member details
        $memberDetails = $member->getMemberDetails($member_id);
    } else {
        $error_message = "Failed to update profile. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Update Profile</h2>

        <?php if (isset($success_message)) { ?>
        <div class="alert alert-success"><?= $success_message ?></div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
        <?php } ?>

        <form method="POST" action="" class="mt-4">
            <div class="mb-3">
                <label for="member_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="member_name" name="member_name"
                    placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
                <label for="member_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="member_email" name="member_email"
                    placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="member_type" class="form-label">Membership Type</label>
                <input type="text" class="form-control" id="member_type" name="member_type"
                    placeholder="Enter your membership type" required>
            </div>
            <div class="mb-3">
                <label for="member_password" class="form-label">Password (Leave blank to keep unchanged)</label>
                <input type="password" class="form-control" id="member_password" name="member_password"
                    placeholder="Enter a new password">
            </div>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary me-2">Update</button>
                <a href="member_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </form>
    </div>
</body>

</html>
