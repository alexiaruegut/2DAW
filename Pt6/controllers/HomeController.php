<?php
namespace controllers;

use models\PostModel;

class HomeController {
    private $postModel;

    public function __construct(PostModel $post) {
        $this->postModel = $post;
    }

    public function index() {
        return $this->postModel->readAll();
    }
}
