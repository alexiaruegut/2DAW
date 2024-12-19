<?php
namespace models;

class PostModel {
    private $conn;
    public $id;
    public $title;
    public $photoUrl;
    public $content;
    public $likes;
    public $author_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO posts (title, photoUrl, content, likes, author_id) VALUES (:title, :photoUrl, :content, :likes, :author_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':photoUrl', $this->photoUrl);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':likes', $this->likes);
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

    public function readById($id) {
        $query = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE posts SET title = :title, photoUrl = :photoUrl, content = :content WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':photoUrl', $this->photoUrl);
        $stmt->bindParam(':content', $this->content);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
