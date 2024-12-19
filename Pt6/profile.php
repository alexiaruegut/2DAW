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

// Iniciar sesión
session_start();

// Inicializar base de datos
$database = new Database();
$db = $database->getConnection();

// Id de usuario
if (!empty($GLOBALS['id'])) {
    $id = $GLOBALS['id'];
} else {
    $id = null; // Or handle it however you need if $id is null
}

// Modelos
$userModel = new User($db);
$postModel = new PostModel($db);
$commentModel = new Comment($db);

// Controladores
$userController = new UserController($userModel);
$postController = new PostController($postModel);
$homeController = new HomeController($postModel);
$commentController = new CommentController($commentModel);

// Ejemplo: listar publicaciones
$posts = $homeController->index();
$users = $userController->listUsers();

// Usuario logueado
if ($_SESSION == null && $id == null) {
    $loggedUser = null;
    header("Location: /");
    exit();
} else {
    $loggedUser = isset($_SESSION['user']) ? $_SESSION['user'] : null;
    // Cargar la vista
    require 'views/layout/header.php';
    require 'views/user/profile.php';
    require 'views/layout/footer.php';
}
