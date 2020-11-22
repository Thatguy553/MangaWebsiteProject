<?php

class Accounting
{
    // DB Connection var
    private $conn;

    // Table To Access
    private $table = "users";

    // Columns
    public $UID;
    public $username;
    public $password;
    public $role;

    // Connecting...
    public function __construct($db)
    {
        $this->conn = $db;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function login() {
        
            $query = "SELECT * FROM " . $this->table . " WHERE username = ?";
            $stmt = $this->conn->prepare($query);

            // Sanitize
            $this->username = htmlspecialchars(strip_tags($this->username));

            // Bind
            $stmt->bindParam(1, $this->username);

            $stmt->execute();

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($this->password, $row['password'])) {
                    #session_start();
                    $_SESSION['user'] = $row['username'];
                    $_SESSION['pass'] = $row['password'];
                    $_SESSION['role'] = $row['role'];
                    return true;
                } else {
                    return false;
                }
            }
        
    }

    public function signup() {
        $query = "INSERT INTO " . $this->table . " SET username = :user, password = :pass, role = :role";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->role = htmlspecialchars(strip_tags($this->role));

        // Hashing
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind
        $stmt->bindParam(":user", $this->username);
        $stmt->bindParam(":pass", $this->password);
        $stmt->bindParam(":role", $this->role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Unnecessary for now.
    public function logout() {
        session_start();
        
        session_unset();
        
        session_destroy();   
    }
}
