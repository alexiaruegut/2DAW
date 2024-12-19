<?php
namespace models;

class Post {
    private $conn;
    public $id;
    public $title;
    public $content;
    public $author_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO posts (title, content, author_id) VALUES (:title, :content, :author_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':author_id', $this->author_id);

        return $stmt->execute();
    }

    public function readAll() {
        $query = "SELECT * FROM posts";
        $stmt = $this->conn->query($query);
        if ($stmt) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return [];
    }
}