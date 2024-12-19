<?php

require_once __DIR__ . '/vendor/autoload.php';

$router = new AltoRouter();

// Define tus rutas
$router->map('GET', '/', function() {
    include __DIR__ . '/home.php';
});

$router->map('GET', '/perfil', function() {
    include __DIR__ . '/profile.php';
});

$router->map('GET', '/admin', function() {
    include __DIR__ . '/admin.php';
});

$router->map('GET', '/admin/usuarios', function() {
    $GLOBALS['dir'] = 'users';
    include __DIR__ . '/admin.php';
});

$router->map('GET', '/admin/posts', function() {
    $GLOBALS['dir'] = 'posts';
    include __DIR__ . '/admin.php';
});

$router->map('GET', '/admin/comentarios', function() {
    $GLOBALS['dir'] = 'comments';
    include __DIR__ . '/admin.php';
});

$router->map('POST', '/admin/usuarios', function() {
    $GLOBALS['dir'] = 'users';
    include __DIR__ . '/admin.php';
});

$router->map('POST', '/admin/posts', function() {
    $GLOBALS['dir'] = 'posts';
    include __DIR__ . '/admin.php';
});

$router->map('POST', '/admin/comentarios', function() {
    $GLOBALS['dir'] = 'comments';
    include __DIR__ . '/admin.php';
});

$router->map('GET', '/perfil/[i:id]', function($id) {
    $GLOBALS['id'] = $id;
    include __DIR__ . '/profile.php';
});

$router->map('GET', '/publicar', function() {
    include __DIR__ . '/post.php';
});

$router->map('POST', '/publicar', function() {
    include __DIR__ . '/post.php';
});

$router->map('GET', '/register', function() {
    include __DIR__ . '/views/user/register.php';
});

$router->map('POST', '/register', function() {
    include __DIR__ . '/views/user/register.php';
});

$router->map('GET', '/login', function() {
    include __DIR__ . '/views/user/login.php';
});

$router->map('POST', '/login', function() {
    include __DIR__ . '/views/user/login.php';
});

$router->map('POST', '/comment', function() {
    include __DIR__ . '/comment.php';
});

// Match la ruta actual
$match = $router->match();

if ($match) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // Página no encontrada
    http_response_code(404);
    echo "Página no encontrada";
}
