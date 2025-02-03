<?php
include 'config.php';
include 'header_all.php';

class Book {
    public $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function addBook($title, $genre, $author, $year) {
        // Insert into the database
        $sql = "INSERT INTO book_details (book_title, book_genre, book_author, published_year) 
                VALUES ('$title', '$genre', '$author', $year)";

        if ($this->conn->query($sql)) {
            return "Book added successfully!";
        } else {
            return "Error: " . $this->conn->error;
        }
    }
}

// Initialize the Book class
$book = new Book($conn);

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch form data
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    // Add book and display the result message
    $message = $book->addBook($title, $genre, $author, $year);
    echo "<script>alert('$message');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Book</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="title">Book Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="genre">Book Genre</label>
                <select name="genre" id="genre" class="form-control" required>
                    <option value="Fiction">Fiction</option>
                    <option value="Dystopian">Dystopian</option>
                    <option value="Classic">Classic</option>
                    <option value="Romance">Romance</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Fantasy">Fantasy</option>
                </select>
            </div>
            <div class="form-group">
                <label for="author">Book Author</label>
                <input type="text" name="author" id="author" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="year">Published Year</label>
                <input type="number" name="year" id="year" class="form-control" min="1500" max="<?= date('Y') ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Book</button>
        </form>

        <div class="text-center mt-4">
            <a href="librarian_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>
