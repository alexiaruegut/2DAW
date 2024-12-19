<?php
require_once 'controllers/UserController.php';

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
        'email' => $_POST['email']
    ];
    
    $updatedUser = $userController->update($loggedUser['id'], $data);
    
    if ($updatedUser) {
        // Actualizar la información de loggedUser con los datos del usuario actualizado
        $_SESSION['user']['username'] = $data['username'];
        $_SESSION['user']['email'] = $data['email'];

        // Redirigir al usuario a la página principal
        header('Location: /');
        exit;
    } else {
        echo "<p class='text-red-500'>Error: No se pudo actualizar el usuario.</p>";
    }
} elseif (!empty($loggedUser) && empty($id)) {
    echo '<div class="p-8">
            <h1 class="text-3xl font-semibold mt-10 mb-10 text-center text-gray-800">MI PERFIL DE USUARIO</h1>
            <form method="post" action="profile.php" class="bg-orange-200 bg-opacity-20 p-8 rounded-lg shadow-lg w-full max-w-lg mx-auto">
                <div class="mb-5">
                    <label for="username" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                    <input type="text" name="username" id="username" value="' . htmlspecialchars($loggedUser['username']) . '" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" name="email" id="email" value="' . htmlspecialchars($loggedUser['email']) . '" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <button type="submit"
                    class="font-semibold w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">Actualizar Perfil</button>
            </form>
        </div>';
} else {
    foreach ($users as $user) {
        if ($user['id'] == $id) {
            echo '<div class="p-8">
                    <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Perfil del usuario ' . htmlspecialchars($user['username']) . '</h2>
                    </div>
                </div>';
        }
    }
}
?>