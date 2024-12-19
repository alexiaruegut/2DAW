<?php
namespace utils;

use models\User;

class Auth {
    public static function login($email, $password, $userModel) {
        $user = $userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
    }

    public static function logout() {
        session_destroy();
    }
}
