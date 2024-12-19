<?php
require_once 'config/Database.php';
require_once 'models/User.php';
require_once 'utils/Auth.php';

use config\Database;
use models\User;
use utils\Auth;

session_start();

$database = new Database();
$db = $database->getConnection();
$userModel = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (Auth::login($email, $password, $userModel)) {
        header('Location: /');
        exit;
    } else {
        echo "<p>Error: Credenciales incorrectas.</p>";
    }
}
?>

<script src="https://cdn.tailwindcss.com"></script>
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="bg-orange-100 bg-opacity-80 p-10 rounded-2xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">INICIAR SESIÓN</h2>
        <form action="/login" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-black">CORREO ELECTRÓNICO</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-600">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-black">CONTRASEÑA</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-600">
            </div>
            <p class="text-sm text-center text-gray-600 mb-4">
                ¿No tienes una cuenta? <a href="/register" class="font-bold text-orange-500 hover:underline">REGÍSTRATE</a>
            </p>
            <button type="submit"
                class="font-bold w-full bg-orange-400 text-white py-2 rounded-2xl hover:bg-orange-500">INICIAR
                SESIÓN</button>
        </form>
    </div>
</div>
</body>

</html>
