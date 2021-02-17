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
    public $created;
    public $APIAccess;
    public $APIKey;

    // Connecting...
    public function __construct($db)
    {
        $this->conn = $db;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function login()
    {

        $query = "SELECT * FROM " . $this->table . " WHERE username = ?";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));

        // Bind
        $stmt->bindParam(1, $this->username);

        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($this->password, $row['password'])) {

                $details = array(
                    "UID" => $row['UID'],
                    "user" => $row['username'],
                    "role" => $row['role'],
                    "API" => $row['APIAccess'],
                    "Key" => $row['API-Key'],
                );

                return $details;
            } else {
                return false;
            }
        }

    }

    public function signup()
    {
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

    public function search()
    {
        $query = "SELECT UID, username, role, created, APIAccess, APIKey FROM " . $this->table . " WHERE username = :user OR UID = :user";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->UID = htmlspecialchars(strip_tags($this->UID));

        // Bind
        $stmt->bindParam(":user", $this->UID);
        $stmt->execute();

        if ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->UID = $rows['UID'];
            $this->username = $rows['username'];
            $this->role = $rows['role'];
            $this->created = $rows['created'];
            $this->APIAccess = $rows['APIAccess'];
            $this->APIKey = $rows['APIKey'];
        }
    }

    public function display()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}