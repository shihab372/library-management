<?php
include 'config.php';

class Member {
    public $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getMemberDetails($member_id) {
        $sql = "SELECT member_name, member_email, member_type, member_password FROM member_details WHERE member_id = $member_id";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function updateMemberDetails($member_id, $name, $email, $type, $password = null) {
        if ($password) {
            // Update with password
            $sql = "UPDATE member_details SET 
                        member_name = '$name', 
                        member_email = '$email', 
                        member_type = '$type', 
                        member_password = '$password' 
                    WHERE member_id = $member_id";
        } else {
            // Update without password
            $sql = "UPDATE member_details SET 
                        member_name = '$name', 
                        member_email = '$email', 
                        member_type = '$type' 
                    WHERE member_id = $member_id";
        }
        return $this->conn->query($sql);
    }
}
?>