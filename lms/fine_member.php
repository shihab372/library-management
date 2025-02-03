<?php
include 'config.php';
include 'header_all.php';

if (!isset($_GET['member_id']) || empty($_GET['member_id'])) {
    die("Invalid request. Member ID is required.");
}

$member_id = $_GET['member_id']; 

// Fetch data from the borrow_return table for the given member ID
$query = "SELECT issue_date, return_date, mem_rt_date, return_status 
          FROM borrow_return 
          WHERE member_id = $member_id"; 
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Fine Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Fine Details for Member ID: <?= $member_id ?></h1>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Issue Date</th>
                    <th>Return Date</th>
                    <th>Member Return Date</th>
                    <th>Return Status</th>
                    <th>Delay Time (Days)</th>
                    <th>Fine Amount (BDT)</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        // Initialize variables for fine calculation
                        $issue_date = $row['issue_date'];
                        $return_date = $row['return_date'];
                        $mem_rt_date = $row['mem_rt_date'];
                        $return_status = $row['return_status'];
                        $delay_time = 0;
                        $fine = 0;

                        if (!empty($mem_rt_date)) { // If the book has been returned
                            if (strtotime($mem_rt_date) > strtotime($return_date)) {
                                $return_date_obj = new DateTime($return_date);
                                $mem_rt_date_obj = new DateTime($mem_rt_date);
                                $delay_time = $mem_rt_date_obj->diff($return_date_obj)->days;
                                $fine = $delay_time * 50; // Assume 50 BDT fine per day
                            }
                        } else {
                            // If mem_rt_date is NULL, book has not been returned
                            $delay_time = 0;
                            $fine = 0; // No fine for unreturned books in this logic
                        }
                        ?>
                        <tr>
                            <td><?= $issue_date ?></td>
                            <td><?= $return_date ?></td>
                            <td><?= $mem_rt_date ?? 'Not Returned' ?></td>
                            <td><?= $return_status ?></td>
                            <td><?= $delay_time ?></td>
                            <td><?= number_format($fine, 2) ?> BDT</td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No records found for this member.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="admin_view_member.php" class="btn btn-secondary">Back to Members</a>
        </div>
    </div>
</body>
</html>
