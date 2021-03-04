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

        // SQL
        $checkSQL = "SELECT * FROM " . $this->table . " WHERE username = ?";

        // Preparation of SQL above
        $chkStmt = $this->conn->prepare($checkSQL);

        // Sanitization of user provided information
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Filter of user provided information
        $this->username = filter_var($this->username, FILTER_SANITIZE_STRING);
        $this->password = filter_var($this->password, FILTER_SANITIZE_STRING);

        // Bind user provided username to prepared SQL
        $chkStmt->bindParam(1, $this->username);


        // Execute prepared and binded SQL
        $chkStmt->execute();

        // Array returned from database fetch assigned to variable
        $row = $chkStmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return json_encode(['Error' => 'No Matches']);
        }

        // Verify password with PHP method, this->password being the user provided password, $row['password'] being the password from the database
        if (password_verify($this->password, $row['password']))
            return $row;
        else
            return json_encode(['Error' => 'Incorrect Password']);
    }

    public function signup()
    {
        // Predefined variables
        $this->created = date('Y-m-d');
        $this->APIAccess = 0;
        $this->APIKey = '';

        // Errors Array
        $errors = [];

        // SQL
        $checkSQL = "SELECT * FROM " . $this->table . " WHERE username = ?";
        $insertSQL = "INSERT INTO $this->table (username, password, role, created, APIAccess, APIKey) VALUES(?, ?, ?, ?, ?, ?)";

        // Preparation
        $chkStmt = $this->conn->prepare($checkSQL);
        $insStmt = $this->conn->prepare($insertSQL);

        // Sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->role = htmlspecialchars(strip_tags($this->role));

        // Filter
        $this->username = filter_var($this->username, FILTER_SANITIZE_STRING);
        $this->password = filter_var($this->password, FILTER_SANITIZE_STRING);
        $this->role = filter_var($this->role, FILTER_SANITIZE_STRING);

        // Hash Pass
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);


        // Bind
        $chkStmt->bindParam(1, $this->username);

        $insStmt->bindParam(1, $this->username);
        $insStmt->bindParam(2, $this->password);
        $insStmt->bindParam(3, $this->role);
        $insStmt->bindParam(4, $this->created);
        $insStmt->bindParam(5, $this->APIAccess);
        $insStmt->bindParam(6, $this->APIKey);

        $chkStmt->execute();

        // Error Checks
        if ($row = $chkStmt->fetch(PDO::FETCH_ASSOC)) {
            $errors['Error'] = 'User Exists';
        }

        if (!empty($errors)) {
            return json_encode($errors);
        }

        if ($insStmt->execute())
            return json_encode(['Signup' => 'success']);
    }

    public function search()
    {
        // SQL to decide where to select data from etc
        $selectSQL = "SELECT * FROM $this->table WHERE username = :user";

        // Preperation of SQL for variable binding and execution
        $stmt = $this->conn->prepare($selectSQL);

        // Sanitization and filtering incase of injection
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->username = filter_var($this->username, FILTER_SANITIZE_STRING);

        // Bind user provided data to SQL
        $stmt->bindParam(":user", $this->username);

        // execute SQL above and return database results or an error for no results
        if ($stmt->execute())
            return $stmt;
        else
            return json_encode(['Results' => 'None']);
    }

    public function display()
    {
        // Select all the data from a certain database table
        $selectSQL = "SELECT * FROM $this->table";

        // Prepare the SQL string for exectution
        $stmt = $this->conn->prepare($selectSQL);

        // Exectute the SQL above and return the array should there be one.
        $stmt->execute();
        return $stmt;
    }
}