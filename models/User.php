<?php
// the site model for users
class User {

    private $conn;
    private $table = "users";

    public $id;
    public $name;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }
     // Create users
    public function create() {

        $query = "INSERT INTO " . $this->table . " (name, email)
                  VALUES (:name, :email)";

        $stmt = $this->conn->prepare($query);

        $this->name  = htmlspecialchars(strip_tags(trim($this->name)));
        $this->email = htmlspecialchars(strip_tags(trim($this->email)));

        $stmt->bindParam(":name",  $this->name);
        $stmt->bindParam(":email", $this->email);

        return $stmt->execute();
    }
     // select users
    public function read() {

        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
     // delete user
    public function delete() {

        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = (int) $this->id;
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

     // search by keyword
    public function search($keyword) {

        $query = "SELECT * FROM " . $this->table . "
                  WHERE name  LIKE :keyword
                  OR    email LIKE :keyword2
                  ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);

        $keyword = "%" . htmlspecialchars(strip_tags(trim($keyword))) . "%";

        $stmt->bindParam(":keyword",  $keyword);
        $stmt->bindParam(":keyword2", $keyword);

        $stmt->execute();

        return $stmt;
    }

    // Check if an email already exists
    public function emailExists() {

        $query = "SELECT id FROM " . $this->table . "
                  WHERE email = :email
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags(trim($this->email)));
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}