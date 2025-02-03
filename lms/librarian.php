<?php
include 'config.php';

class Librarian {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Method to fetch librarian details by ID
    public function getLibrarianDetails($librarian_id) {
        $sql = "SELECT librarian_name, librarian_email, librarian_created FROM librarian_details WHERE librarian_id = $librarian_id";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Method to update librarian details
    public function updateLibrarianDetails($librarian_id, $name, $email, $password = null) {
        if ($password) {
            // Update with password
            $sql = "UPDATE librarian_details SET 
                        librarian_name = '$name', 
                        librarian_email = '$email', 
                        librarian_password = '$password' 
                    WHERE librarian_id = $librarian_id";
        } else {
            // Update without password
            $sql = "UPDATE librarian_details SET 
                        librarian_name = '$name', 
                        librarian_email = '$email' 
                    WHERE librarian_id = $librarian_id";
        }
        return $this->conn->query($sql);
    }
}
?>
