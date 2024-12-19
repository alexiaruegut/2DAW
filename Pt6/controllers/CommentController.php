<?php
namespace controllers;

use models\Comment;

class CommentController {
    private $commentModel;

    public function __construct(Comment $comment) {
        $this->commentModel = $comment;
    }

    public function listComments() {
        return $this->commentModel->readAll();
    }

    public function createComment($data) {
        $this->commentModel->content = $data['content'];
        $this->commentModel->post_id = $data['post_id'];
        $this->commentModel->user_id = $data['user_id'];

        return $this->commentModel->create();
    }

    public function getCommentsByPostId($post_id) {
        return $this->commentModel->readByPostId($post_id);
    }

    public function updateComment($id, $data) {
        $this->commentModel->id = $id;
        $this->commentModel->content = $data['content'];

        return $this->commentModel->update();
    }

    public function deleteComment($id) {
        $this->commentModel->id = $id;
        return $this->commentModel->delete();
    }

    public function getCommentById($id) {
        return $this->commentModel->getCommentById($id);
    }
}
