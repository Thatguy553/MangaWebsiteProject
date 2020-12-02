<?php
// Begin Chapter Class
class Chapters
{

    // DB Connection
    private $conn;

    // Table To Access
    private $table = "chapters";

    // Columns
    public $UID;
    public $Title;
    public $ChNum;
    public $Rar;
    public $Folder;
    public $ExistingFolder;

    // Connecting...
    public function __construct($db)
    {
        $this->conn = $db;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function display()
    {
        $query = "SELECT * FROM " . $this->table . "";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function insert()
    {
        $this->Folder = uniqid('chapter_');
        $query = "INSERT INTO " . $this->table . " SET Title = :title, ChNum = :chnum, Pages = :pages, Folder = :folder";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->Title = htmlspecialchars(strip_tags($this->Title));
        $this->ChNum = htmlspecialchars(strip_tags($this->ChNum));
        $this->Pages = htmlspecialchars(strip_tags($this->Pages));
        $this->Folder = htmlspecialchars(strip_tags($this->Folder));

        // Bind
        $stmt->bindParam(":title", $this->Title);
        $stmt->bindParam(":chnum", $this->ChNum);
        $stmt->bindParam(":pages", $this->Pages);
        $stmt->bindParam(":folder", $this->Folder);

        // Change to mkdir inside of the series that chapter is for, then move the .rar to the directory for the chapter, extract it, delete the rar, and insert into the database
        if (mkdir(__DIR__ . "/../series/" . $this->ExistingFolder . "/" . $this->Folder)) {
            if (move_uploaded_file($this->Rar['tmp_name'][0], __DIR__ . "/../series/" . $this->Folder . "/" . $this->Rar['name'][0])) {
                $zip = new ZipArchive;
                $res = $zip->open(__DIR__ . "/../series/" . $this->ExistingFolder . "/" . $this->Folder . "/" . $this->Rar['name'][0]);
                if ($res === true) {
                    if ($zip->extractTo(__DIR__ . "/../series/" . $this->ExistingFolder . "/" . $this->Folder . "/")) {
                        unlink(__DIR__ . "/../series/" . $this->ExistingFolder . "/" . $this->Folder . "/" . $this->Rar['name'][0]);
                        if ($stmt->execute()) {
                            $zip->close();
                            return true;
                        }
                    }
                }
            } else {
                rmdir(__DIR__ . "/../series/" . $this->Folder);
            }
        }
        return false;
    }

    public function update()
    {
        $this->Image = $_FILES['files'];
        $query = "UPDATE " . $this->table . " SET Title = :title WHERE UID = :uid";
        $stmt = $this->conn->prepare($query);

        // Sanitization
        $this->UID = htmlspecialchars(strip_tags($this->UID));
        $this->Title = htmlspecialchars(strip_tags($this->Title));

        // Bind
        $stmt->bindParam(":uid", $this->UID);
        $stmt->bindParam(":title", $this->Title);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE UID = ?";
        $qFolder = "SELECT * FROM series WHERE UID = ?";
        $stmt = $this->conn->prepare($query);
        $FolderStmt = $this->conn->prepare($qFolder);

        // Sanitization
        $this->UID = htmlspecialchars(strip_tags($this->UID));
        $this->Folder = htmlspecialchars(strip_tags($this->Folder));

        // Bind
        $stmt->bindParam(1, $this->UID);
        $FolderStmt->bindParam(1, $this->UID);

        if ($FolderStmt->execute()) {
            if ($rows = $FolderStmt->fetch(PDO::FETCH_ASSOC)) {
                array_map('unlink', glob(__DIR__ . "/../series/" . $rows['Folder'] . "/" . $this->Folder . "/*.*"));
                if (file_exists(__DIR__ . "/../series/" . $rows['Folder'] . "/" . $this->Folder)) {
                    if (rmdir(__DIR__ . "/../series/" . $rows['Folder'] . "/" . $this->Folder)) {
                        if ($stmt->execute()) {
                            return true;
                        }
                    }
                } else {
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