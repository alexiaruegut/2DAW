<?php
require_once '../../config/Database.php';
require_once '../../models/User.php';
require_once '../../controllers/UserController.php';

use config\Database;
use models\User;
use controllers\UserController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $userModel = new User($db);
    $userController = new UserController($userModel);

    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'role' => $_POST['role']
    ];

    if ($userController->register($data)) {
        header('Location: login.php');
        exit;
    } else {
        echo "<p>Error: No se pudo registrar el usuario.</p>";
    }
}
