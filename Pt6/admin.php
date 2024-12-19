<?php
require_once 'config/Database.php';
require_once 'models/User.php';
require_once 'models/PostModel.php';
require_once 'models/Comment.php';
require_once 'controllers/UserController.php';
require_once 'controllers/PostController.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/CommentController.php';
require_once 'utils/Auth.php';

use config\Database;
use models\User;
use models\PostModel;
use models\Comment;
use controllers\UserController;
use controllers\PostController;
use controllers\HomeController;
use controllers\CommentController;

// Iniciar sesión
session_start();

// Inicializar base de datos
$database = new Database();
$db = $database->getConnection();

// Modelos
$userModel = new User($db);
$postModel = new PostModel($db);
$commentModel = new Comment($db);

// Controladores
$userController = new UserController($userModel);
$postController = new PostController($postModel);
$homeController = new HomeController($postModel);
$commentController = new CommentController($commentModel);

$posts = $homeController->index();
$users = $userController->listUsers();
$comments = $commentController->listComments();

// Usuario logueado
$loggedUser = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// Cargar la vista
if (!empty($GLOBALS['dir'])) {
    $dir = $GLOBALS['dir'];
} else {
    $dir = null;
}

if (!empty($loggedUser)) {
    if ($loggedUser['role'] == 'admin') {
        switch ($dir) {
            case 'users':
                require 'views/layout/header.php';
                require 'views/admin/users.php';
                require 'views/layout/footer.php';
                break;
            
            case 'posts':
                require 'views/layout/header.php';
                require 'views/admin/posts.php';
                require 'views/layout/footer.php';
                break;

            case 'comments':
                require 'views/layout/header.php';
                require 'views/admin/comments.php';
                require 'views/layout/footer.php';
                break;
            
            default:
                require 'views/layout/header.php';
                require 'views/admin/index.php';
                require 'views/layout/footer.php';
                break;
        }
    }
    else {
        header('Location: /');
        exit;
    }
}
else {
    header('Location: /');
    exit;
}
