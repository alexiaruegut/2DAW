<?php
require_once 'config/Database.php';
require_once 'models/User.php';
require_once 'controllers/UserController.php';

use config\Database;
use models\User;
use controllers\UserController;

$database = new Database();
$db = $database->getConnection();

$userModel = new User($db);
$userController = new UserController($userModel);

// Manejo de acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $data = [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'role' => $_POST['role']
                ];
                if ($userController->register($data)) {
                    echo "<p class='text-green-500'>Usuario añadido correctamente.</p>";
                } else {
                    echo "<p class='text-red-500'>Error: No se pudo añadir el usuario.</p>";
                }
                break;

            case 'edit':
                // If editing, update the user details
                $data = [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'role' => $_POST['role']
                ];
                if ($userController->update($_POST['id'], $data)) {
                    echo "<p>Usuario actualizado correctamente.</p>";
                } else {
                    echo "<p>Error: No se pudo actualizar el usuario.</p>";
                }
                break;

            case 'delete':
                if ($userController->delete($_POST['id'])) {
                    echo "<p>Usuario eliminado correctamente.</p>";
                } else {
                    echo "<p>Error: No se pudo eliminar el usuario.</p>";
                }
                break;
        }
    }
}

// Obtener todos los usuarios
$users = $userController->listUsers();

// Check if we are editing a specific user
$userToEdit = null;
if (isset($_GET['edit_id'])) {
    $userToEdit = $userController->getUserById($_GET['edit_id']);
}
?>

<script src="https://cdn.tailwindcss.com"></script>
<div class="p-8">
    <h1 class="text-3xl font-semibold mt-10 mb-10 text-center text-gray-800">GESTIÓN DE USUARIOS</h1>
    <table class="min-w-full bg-white border border-orange-200 shadow-lg">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre de Usuario</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Correo Electrónico</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rol</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($user['id']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($user['username']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($user['email']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($user['role']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200">
                        <form method="get" action="" class="inline">
                            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <button type="submit" class="text-blue-500 hover:underline">EDITAR</button>
                        </form>
                        <form method="post" style="display:inline;" class="inline">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');" class="text-red-500 hover:underline">ELIMINAR</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add User Form -->
    <h3 class="text-2xl font-semibold mt-10 mb-4 text-center text-gray-800">AÑADIR USUARIO</h3>
    <form method="post" class="bg-orange-200 bg-opacity-20 p-8 rounded-lg shadow-lg w-full max-w-lg mx-auto mb-8">
        <input type="hidden" name="action" value="add">
        <div class="mb-5">
            <label for="username" class="block text-sm font-medium text-gray-700">Nombre de usuario:</label>
            <input type="text" name="username" id="username" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="mb-5">
            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico:</label>
            <input type="email" name="email" id="email" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
            <input type="password" name="password" id="password" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="mb-5">
            <label for="role" class="block text-sm font-medium text-gray-700">Rol:</label>
            <select name="role" id="role" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option value="subscriber">Suscriptor</option>
                <option value="writer">Escritor</option>
                <option value="admin">Administrador</option>
            </select>
        </div>
        <button type="submit"
            class="font-semibold w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">AÑADIR USUARIO</button>
    </form>

    <?php if ($userToEdit): ?>
        <!-- Edit User Form -->
        <h3 class="text-2xl font-semibold mt-10 mb-4 text-center text-gray-800">EDITAR USUARIO</h3>
        <form method="post" class="bg-orange-200 bg-opacity-20 p-8 rounded-lg shadow-lg w-full max-w-lg mx-auto mb-8">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($userToEdit['id']); ?>">
            <div class="mb-5">
                <label for="username" class="block text-sm font-medium text-gray-700">Nombre de usuario:</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($userToEdit['username']); ?>" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($userToEdit['email']); ?>" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="mb-5">
                <label for="role" class="block text-sm font-medium text-gray-700">Rol:</label>
                <select name="role" id="role" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="subscriber" <?php echo $userToEdit['role'] === 'subscriber' ? 'selected' : ''; ?>>Suscriptor</option>
                    <option value="writer" <?php echo $userToEdit['role'] === 'writer' ? 'selected' : ''; ?>>Escritor</option>
                    <option value="admin" <?php echo $userToEdit['role'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                </select>
            </div>
            <button type="submit"
                class="font-semibold w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">ACTUALIZAR USUARIO</button>
        </form>
    <?php endif; ?>
</div>
