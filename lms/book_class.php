<?php
include_once 'config.php'; 
include 'header_all.php';

class Book {
 public $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Add a new book
    public function addBook($title, $genre, $author, $year) {
        $year = (int) $year; 
        $sql = "INSERT INTO book_details (book_title, book_genre, book_author, published_year) 
                VALUES ('$title', '$genre', '$author', $year)";
        if ($this->conn->query($sql)) {
            return "Book added successfully!";
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // Fetch all books
    public function getAllBooks() {
        $sql = "SELECT * FROM book_details";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Update a book
    public function updateBook($id, $title, $genre, $author, $year) {
        $year = (int) $year; 
        $sql = "UPDATE book_details 
                SET book_title = '$title', book_genre = '$genre', book_author = '$author', published_year = $year 
                WHERE book_id = $id";
        return $this->conn->query($sql);
    }

    // Delete a book
    public function deleteBook($id) {
        $sql = "DELETE FROM book_details WHERE book_id = $id";
        return $this->conn->query($sql);
    }
}
?>
