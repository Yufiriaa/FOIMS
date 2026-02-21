<?php
include_once __DIR__ . "/Dbh.Class.php";

class Users extends Dbh {

    // Get user by email (for checking duplicates)
    protected function getUsers($email) {
        $query = "SELECT * FROM user WHERE EMAIL = ?";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array($email))) {
            return 0;
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert new user
    protected function insertUser($name, $email, $passwordHash) {

        $query = "INSERT INTO user (NAME, EMAIL, PASSWORD) VALUES (?, ?, ?)";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array($name, $email, $passwordHash))) {
            return false;
        }

        return true;
    }

    // Check if the role is an organization owner
    protected function getRole($userID) {
        $query = "SELECT 1 FROM organizations WHERE USER_ID = ? LIMIT 1 ";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID])) {
            return false;
        }

        return $stmt->fetchColumn() !== false;
    }
}
