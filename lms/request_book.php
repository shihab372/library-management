<?php
include 'config.php';
include 'header_all.php';
session_start();

if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit();
}

class BookRequest {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function addBookRequest($memberId, $bookTitle, $authorName, $publishedYear) {
        $sql = "INSERT INTO borrow_return (member_id, book_id, issue_status, return_status)
                SELECT $memberId, book_id, 'Not Issued', 'Not Returned'
                FROM book_details
                WHERE book_title = '$bookTitle' AND book_author = '$authorName' AND published_year = '$publishedYear'";

        if ($this->conn->query($sql)) {
            return "Request sent successfully!";
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    public function fetchMemberRequests($memberId) {
        $sql = "SELECT br.br_id, b.book_title, br.issue_status, br.return_status, br.issue_date, br.return_date
                FROM borrow_return br
                LEFT JOIN book_details b ON br.book_id = b.book_id
                WHERE br.member_id = $memberId";
        return $this->conn->query($sql);
    }
}

$request = new BookRequest($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_request'])) {
    $memberId = $_SESSION['member_id'];
    $bookTitle = $_POST['book_title'];
    $authorName = $_POST['author_name'];
    $publishedYear = $_POST['published_year'];

    $message = $request->addBookRequest($memberId, $bookTitle, $authorName, $publishedYear);
}

$memberId = $_SESSION['member_id'];
$requests = $request->fetchMemberRequests($memberId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Request</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Book Request</h2>

        <?php if (isset($message)) { ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php } ?>

        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="book_title" class="form-label">Book Title</label>
                <input type="text" class="form-control" id="book_title" name="book_title" placeholder="Enter book title" required>
            </div>
            <div class="mb-3">
                <label for="author_name" class="form-label">Author Name</label>
                <input type="text" class="form-control" id="author_name" name="author_name" placeholder="Enter author name" required>
            </div>
            <div class="mb-3">
                <label for="published_year" class="form-label">Published Year</label>
                <input type="number" class="form-control" id="published_year" name="published_year" placeholder="Enter published year" required>
            </div>
            <div class="d-flex justify-content-start gap-2">
                <button type="submit" name="send_request" class="btn btn-primary">Send Request</button>
                <a href="check_issue.php" class="btn btn-success">Check Issued Books</a>
                <a href="member_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>
