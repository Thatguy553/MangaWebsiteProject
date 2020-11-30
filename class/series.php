<?php
class Series
{
    // DB Connection
    private $conn;

    // Table To Access
    private $table = "series";

    // Columns
    public $UID;
    public $Title;
    public $Description;
    public $Chapters;
    public $Folder;
    public $Image;
    public $ExistingImage;
    public $Created;

    // Connecting...
    public function __construct($db)
    {
        $this->conn = $db;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (!file_exists(__DIR__ . "/../series")) {
            mkdir(__DIR__ . "/../series");
        }
    }

    // Grab Everything
    public function getSeries()
    {
        $query = "SELECT * FROM " . $this->table . "";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Insert Series
    public function insert()
    {

        $this->Image = $_FILES['files'];
        $this->Folder = uniqid('series_');
        $query = "INSERT INTO " . $this->table . " SET Title = :title, Description = :desc, Chapters = :chapters, Image = :image, Folder = :folder";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->Title = htmlspecialchars(strip_tags($this->Title));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->Chapters = htmlspecialchars(strip_tags($this->Chapters));
        $this->Image['name'][0] = htmlspecialchars(strip_tags($this->Image['name'][0]));
        $this->Folder = htmlspecialchars(strip_tags($this->Folder));

        // Bind
        $stmt->bindParam(":title", $this->Title);
        $stmt->bindParam(":desc", $this->Description);
        $stmt->bindParam(":chapters", $this->Chapters);
        $stmt->bindParam(":image", $this->Image['name'][0]);
        $stmt->bindParam(":folder", $this->Folder);

        if ($stmt->execute()) {
            mkdir(__DIR__ . "/../series/" . $this->Folder);
            move_uploaded_file($this->Image['tmp_name'][0], __DIR__ . "/../series/" . $this->Folder . "/" . $this->Image['name'][0]);
            return true;
        }
        return false;
    }

    public function search()
    {
        $query = "SELECT UID, Title, Description, Chapters, Image, Folder FROM " . $this->table . " WHERE UID = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->UID);
        $stmt->execute();

        if ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->UID = $rows['UID'];
            $this->Title = $rows['Title'];
            $this->Description = $rows['Description'];
            $this->Chapters = $rows['Chapters'];
            $this->Image = $rows['Image'];
            $this->Folder = $rows['Folder'];
        }
    }

    public function update()
    {
        $this->Image = $_FILES['files'];
        $query = "UPDATE " . $this->table . " SET Title = :title, Description = :desc, Chapters = :chapters, Image = :image WHERE UID = :uid";
        $stmt = $this->conn->prepare($query);

        // Image Replace
        unlink(__DIR__ . "/../series/" . $this->Folder . "/" . $this->ExistingImage);

        // Sanitization
        $this->UID = htmlspecialchars(strip_tags($this->UID));
        $this->Title = htmlspecialchars(strip_tags($this->Title));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->Chapters = htmlspecialchars(strip_tags($this->Chapters));
        $this->Image['name'][0] = htmlspecialchars(strip_tags($this->Image['name'][0]));

        // Bind
        $stmt->bindParam(":uid", $this->UID);
        $stmt->bindParam(":title", $this->Title);
        $stmt->bindParam(":desc", $this->Description);
        $stmt->bindParam(":chapters", $this->Chapters);
        $stmt->bindParam(":image", $this->Image['name'][0]);

        if ($stmt->execute()) {
            if (move_uploaded_file($this->Image['tmp_name'][0], __DIR__ . "/../series/" . $this->Folder . "/" . $this->Image['name'][0])) {
                return true;
            }
        }

        return false;
    }

    // Delete
    public function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE UID = ?";
        $qFolder = "SELECT * FROM " . $this->table . " WHERE UID = ?";
        $stmt = $this->conn->prepare($query);
        $FolderStmt = $this->conn->prepare($qFolder);

        // Sanitization
        $this->UID = htmlspecialchars(strip_tags($this->UID));

        // Bind
        $stmt->bindParam(1, $this->UID);
        $FolderStmt->bindParam(1, $this->UID);

        if ($FolderStmt->execute()) {
            if ($rows = $FolderStmt->fetch(PDO::FETCH_ASSOC)) {
                array_map('unlink', glob(__DIR__ . "/../series/" . $rows['Folder'] . "/*.*"));
                if (rmdir(__DIR__ . "/../series/" . $rows['Folder'])) {
                    if ($stmt->execute()) {
                        return true;
                    }
                }
            } else {
                return false;
            }
        }

        return false;
    }
}