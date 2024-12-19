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
use utils\Auth;

session_start();

// Conexión a la base de datos
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'content' => $_POST['content'],
        'post_id' => $_POST['post_id'],
        'user_id' => $_SESSION['user']['id']
    ];

    // Crear el comentario 
    $commentController->createComment($data);
    header('Location: /');
    exit;
}
