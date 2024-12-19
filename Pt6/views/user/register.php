<?php
require_once 'config/Database.php';
require_once 'models/User.php';
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
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'role' => $_POST['role']
    ];

    if ($userController->register($data)) {
        header('Location: /');
        exit;
    } else {
        echo "<p>Error: No se pudo registrar el usuario.</p>";
    }
}
?>

<script src="https://cdn.tailwindcss.com"></script>
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="bg-orange-100 bg-opacity-80 p-10 rounded-2xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">REGISTRARSE</h2>
        <form method="post" action="/register">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-black">NOMBRE DE USUARIO</label>
                <input type="text" name="username" id="username" required
                    class="w-full px-4 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-600">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-black">CORREO ELECTRÓNICO</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-600">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-black">CONTRASEÑA</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-600">
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-black">ROL</label>
                <select name="role" id="role"
                    class="w-full px-4 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-600">
                    <option value="subscriber">Suscriptor</option>
                    <option value="writer">Escritor</option>
                </select>
            </div>
            <p class="text-sm text-center text-gray-600 mb-4">
                ¿Ya tienes una cuenta? <a href="/login" class="font-bold text-orange-500 hover:underline">INICIA SESIÓN</a>
            </p>
            <button type="submit"
                class="font-bold w-full bg-orange-400 text-white py-2 rounded-2xl hover:bg-orange-500">REGISTRARSE</button>
        </form>
    </div>
</div>
</body>

</html>