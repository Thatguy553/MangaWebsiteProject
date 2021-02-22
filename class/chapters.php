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
    public $Series;
    public $Title;
    public $ChNum;
    public $Rar;
    public $Pages;
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
        $query = "INSERT INTO " . $this->table . " SET series = :series, Title = :title, ChNum = :chnum, Pages = :pages, Folder = :folder, seriesFolder = :sfolder";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->Title = htmlspecialchars(strip_tags($this->Title));
        $this->Series = htmlspecialchars(strip_tags($this->Series));
        $this->ChNum = htmlspecialchars(strip_tags($this->ChNum));
        $this->Pages = htmlspecialchars(strip_tags($this->Pages));
        $this->Folder = htmlspecialchars(strip_tags($this->Folder));
        $this->ExistingFolder = htmlspecialchars(strip_tags($this->ExistingFolder));

        // Bind
        $stmt->bindParam(":series", $this->Series);
        $stmt->bindParam(":title", $this->Title);
        $stmt->bindParam(":chnum", $this->ChNum);
        $stmt->bindParam(":pages", $this->Pages);
        $stmt->bindParam(":folder", $this->Folder);
        $stmt->bindParam(":sfolder", $this->ExistingFolder);

        // Change to mkdir inside of the series that chapter is for, then move the .rar to the directory for the chapter, extract it, delete the rar, and insert into the database
        if (mkdir(__DIR__ . "/../series/" . $this->ExistingFolder . "/" . $this->Folder)) {
            if (move_uploaded_file($this->Rar['tmp_name'][0], __DIR__ . "/../series/" . $this->ExistingFolder . "/" . $this->Folder . "/" . $this->Rar['name'][0])) {
                $zip = new ZipArchive;
                $res = $zip->open(__DIR__ . "/../series/" . $this->ExistingFolder . "/" . $this->Folder . "/" . $this->Rar['name'][0]);
                if ($res === true) {
                    if ($zip->extractTo(__DIR__ . "/../series/" . $this->ExistingFolder . "/" . $this->Folder . "/")) {
                        $zip->close();
                        unlink(__DIR__ . "/../series/" . $this->ExistingFolder . "/" . $this->Folder . "/" . $this->Rar['name'][0]);
                        $this->Pages = count(scandir(__DIR__ . "/../series/" . $this->ExistingFolder . "/" . $this->Folder . "/")) - 2 ?? 0;
                        if ($stmt->execute()) {
                            return true;
                        } else {
                            print_r("Execute Failed.");
                        }
                    } else {
                        print_r("Extract To Failed.");
                    }
                } else {
                    print_r("Zip Open Failed.");
                }
            } else {
                rmdir(__DIR__ . "/../series/" . $this->Folder);
            }
        }
        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table . " SET Title = :title, ChNum = :chnum WHERE UID = :uid";
        $stmt = $this->conn->prepare($query);

        // Sanitization
        $this->UID = htmlspecialchars(strip_tags($this->UID));
        $this->ChNum = htmlspecialchars(strip_tags($this->ChNum));
        $this->Title = htmlspecialchars(strip_tags($this->Title));

        // Bind
        $stmt->bindParam(":uid", $this->UID);
        $stmt->bindParam(":chnum", $this->ChNum);
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
        $FolderStmt->bindParam(1, $this->Series);

        if ($FolderStmt->execute()) {
            if ($rows = $FolderStmt->fetch(PDO::FETCH_ASSOC)) {
                $files = glob(__DIR__ . "/../series/" . $rows['Folder'] . "/" . $this->Folder . "/*.*");

                // Deleting all the files in the list
                foreach ($files as $file) {

                    if (is_file($file))

                    // Delete the given file
                    {
                        unlink($file);
                    }
                }
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
                print_r("rows found nothing");
            }
        }

        return false;
    }

    public function searchList()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE series = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->UID);
        $stmt->execute();
        return $stmt;
    }

    public function searchSingle()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE ChNum = :chnum AND series = :series";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":chnum", $this->ChNum);
        $stmt->bindParam(":series", $this->Series);
        $stmt->execute();
        //return $stmt;

        if ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->UID = $rows['UID'];
            $this->ChNum = $rows['ChNum'];
            $this->Series = $rows['series'];
            $this->Title = $rows['Title'];
            $this->Pages = $rows['Pages'];
            $this->Folder = $rows['Folder'];
            $this->ExistingFolder = $rows['seriesFolder'];
        }
    }

    public function pageArr()
    {
        // Sanitization
        $this->Folder = htmlspecialchars(strip_tags($this->Folder));
        $this->ExistingFolder = htmlspecialchars(strip_tags($this->ExistingFolder));

        $arr = scandir(__DIR__ . "/../series/" . $this->ExistingFolder . "/" . $this->Folder . "/");

        // array_push($arr, $this->Folder, $this->ExistingFolder);
        return $arr;
    }
}