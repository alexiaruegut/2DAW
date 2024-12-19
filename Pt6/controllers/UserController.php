<?php
namespace controllers;

use models\User;

class UserController {
    private $userModel;

    public function __construct(User $user) {
        $this->userModel = $user;
    }

    public function register($data) {
        $this->userModel->username = $data['username'];
        $this->userModel->email = $data['email'];
        $this->userModel->password = $data['password'];
        $this->userModel->role = $data['role'];

        return $this->userModel->create();
    }

    public function update($id, $data) {
        $this->userModel->username = $data['username'];
        $this->userModel->email = $data['email'];
        $this->userModel->role = $data['role'];

        return $this->userModel->update($id, $data);
    }

    public function listUsers() {
        return $this->userModel->readAll();
    }

    public function delete($id) {
        return $this->userModel->delete($id);
    }

    public function getUserById($id) {
        return $this->userModel->getById($id);
    }

    public function getUserByEmail($email) {
        return $this->userModel->getUserByEmail($email);
    }
}
