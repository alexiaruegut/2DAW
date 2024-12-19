<?php
namespace controllers;

use models\PostModel;

class PostController {
    private $postModel;

    public function __construct(PostModel $post) {
        $this->postModel = $post;
    }

    public function listPosts() {
        return $this->postModel->readAll();
    }

    public function createPost($data) {
        $this->postModel->title = $data['title'];
        $this->postModel->photoUrl = $data['photoUrl'];
        $this->postModel->content = $data['content'];
        $this->postModel->likes = '0';
        $this->postModel->author_id = $data['author_id'];

        return $this->postModel->create();
    }

    public function getPostById($id) {
        return $this->postModel->readById($id);
    }

    public function updatePost($id, $data) {
        $this->postModel->id = $id;
        $this->postModel->title = $data['title'];
        $this->postModel->photoUrl = $data['photoUrl'];
        $this->postModel->content = $data['content'];

        return $this->postModel->update();
    }

    public function deletePost($id) {
        $this->postModel->id = $id;
        return $this->postModel->delete();
    }
}
