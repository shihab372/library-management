<?php
include 'config.php';
include 'header_all.php';
session_start();

if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit();
}

class Book {
    public $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    
    public function getAllBooks() {
        $books = [];
        $sql = "SELECT book_id, book_title, book_genre, book_author, published_year FROM book_details";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
        }
        return $books;
    }
}

$book = new Book($conn);
$books = $book->getAllBooks();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Book List</h2>
        <table class="table table-bordered table-hover mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Author</th>
                    <th>Published Year</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($books)) { ?>
                <?php foreach ($books as $book) { ?>
                <tr>
                    <td><?= $book['book_id'] ?></td>
                    <td><?= $book['book_title'] ?></td>
                    <td><?= $book['book_genre'] ?></td>
                    <td><?= $book['book_author'] ?></td>
                    <td><?= $book['published_year'] ?></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                    <td colspan="5" class="text-center">No books available</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="member_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>