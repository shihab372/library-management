<?php
include 'config.php';
include 'header_all.php';
session_start();

if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit();
}

class ReturnBook {
    public $conn;
    public $member_id;

    public function __construct($dbConnection, $memberId) {
        $this->conn = $dbConnection;
        $this->member_id = $memberId;
    }

    // Fetch books available for return
    public function getBooksToReturn() {
        $books = [];
        $sql = "SELECT br.br_id, b.book_title, br.issue_date 
                FROM book_details b 
                JOIN borrow_return br ON b.book_id = br.book_id 
                WHERE br.member_id = $this->member_id AND br.return_status = 'Not Returned'";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
        }
        return $books;
    }

    // Update the borrow_return table
    public function returnBook($transaction_id, $mem_rt_date) {
        $sql = "SELECT issue_date, return_date FROM borrow_return WHERE br_id = $transaction_id";
        $result = $this->conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            $issue_date = $row['issue_date'];
            $due_date = $row['return_date'];

            if ($mem_rt_date > $issue_date) {
                // Always update mem_rt_date regardless of due date
                $update_sql = "UPDATE borrow_return 
                               SET mem_rt_date = '$mem_rt_date', return_status = 'Returned' 
                               WHERE br_id = $transaction_id";
                if ($this->conn->query($update_sql)) {
                    if ($mem_rt_date > $due_date) {
                        return "Book returned successfully, but the due date was exceeded!";
                    }
                    return "Book returned successfully!";
                } else {
                    return "Error updating return status.";
                }
            } else {
                // If the return date is before or on the issue date
                return "Return date must be after the issue date!";
            }
        }
        return "Invalid transaction ID.";
    }
}

$member_id = $_SESSION['member_id'];
$returnBook = new ReturnBook($conn, $member_id);
$books = $returnBook->getBooksToReturn();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transaction_id = $_POST['transaction_id'];
    $mem_rt_date = $_POST['mem_rt_date'];

    $message = $returnBook->returnBook($transaction_id, $mem_rt_date);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Return Book</h2>

        <?php if (!empty($message)) { ?>
            <div class="alert alert-info"><?= $message ?></div>
        <?php } ?>

        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="transaction_id" class="form-label">Select Book</label>
                <select class="form-control" id="transaction_id" name="transaction_id" required>
                    <option value="" disabled selected>Select a book</option>
                    <?php foreach ($books as $book) { ?>
                        <option value="<?= $book['br_id'] ?>">
                            <?= $book['book_title'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="mem_rt_date" class="form-label">Return Date</label>
                <input type="date" class="form-control" id="mem_rt_date" name="mem_rt_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="member_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>
</body>

</html>
