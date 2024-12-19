<?php
namespace models;

class Comment {
    private $conn;
    public $id;
    public $content;
    public $post_id;
    public $user_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO comments (content, post_id, user_id) VALUES (:content, :post_id, :user_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':post_id', $this->post_id);
        $stmt->bindParam(':user_id', $this->user_id);

        return $stmt->execute();
    }

    public function readAll() {
        $query = "SELECT * FROM comments";
        $stmt = $this->conn->query($query);
        if ($stmt) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function readByPostId($post_id) {
        $query = "SELECT * FROM comments WHERE post_id = :post_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE comments SET content = :content WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':content', $this->content);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function getCommentById($id) {
        $query = "SELECT * FROM comments WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
