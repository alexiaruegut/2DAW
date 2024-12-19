<?php
require_once 'config/Database.php';
require_once 'models/PostModel.php';
require_once 'controllers/PostController.php';

use config\Database;
use models\PostModel;
use controllers\PostController;

$database = new Database();
$db = $database->getConnection();

$postModel = new PostModel($db);
$postController = new PostController($postModel);

// Manejo de acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $data = [
                    'title' => $_POST['title'],
                    'photoUrl' => $_POST['photoUrl'],
                    'content' => $_POST['content'],
                    'author_id' => $_POST['author_id']
                ];
                if ($postController->createPost($data)) {
                    echo "<p class='text-green-500'>Post añadido correctamente.</p>";
                } else {
                    echo "<p class='text-red-500'>Error: No se pudo añadir el post.</p>";
                }
                break;

            case 'edit':
                // If editing, update the post details
                $data = [
                    'title' => $_POST['title'],
                    'photoUrl' => $_POST['photoUrl'],
                    'content' => $_POST['content'],
                    'author_id' => $_POST['author_id']
                ];
                if ($postController->updatePost($_POST['id'], $data)) {
                    echo "<p class='text-green-500'>Post actualizado correctamente.</p>";
                } else {
                    echo "<p class='text-red-500'>Error: No se pudo actualizar el post.</p>";
                }
                break;

            case 'delete':
                if ($postController->deletePost($_POST['id'])) {
                    echo "<p class='text-green-500'>Post eliminado correctamente.</p>";
                } else {
                    echo "<p class='text-red-500'>Error: No se pudo eliminar el post.</p>";
                }
                break;
        }
    }
}

// Obtener todos los posts
$posts = $postController->listPosts();

// Check if we are editing a specific post
$postToEdit = null;
if (isset($_GET['edit_id'])) {
    $postToEdit = $postController->getPostById($_GET['edit_id']);
}
?>

<script src="https://cdn.tailwindcss.com"></script>
<div class="p-8">
    <h1 class="text-3xl font-semibold mt-10 mb-10 text-center text-gray-800">GESTIÓN DE POSTS</h1>
    <table class="min-w-full bg-white border border-orange-200 shadow-lg">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Título</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">URL de la Foto</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contenido</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Autor</th>
                <th class="px-6 py-3 border-b-2 border-grorangeay-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($post['id']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($post['title']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($post['photoUrl']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($post['content']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($post['author_id']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200">
                        <form method="get" action="" class="inline">
                            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($post['id']); ?>">
                            <button type="submit" class="text-blue-500 hover:underline">EDITAR</button>
                        </form>
                        <form method="post" style="display:inline;" class="inline">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este post?');" class="text-red-500 hover:underline">ELIMINAR</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add Post Form -->
    <h3 class="text-2xl font-semibold mt-10 mb-4 text-center text-gray-800">AÑADIR POST</h3>
    <form method="post" class="bg-orange-200 bg-opacity-20 p-8 rounded-2xl shadow-lg w-full max-w-lg mx-auto mb-8">
        <input type="hidden" name="action" value="add">
        <div class="mb-5">
            <label for="title" class="block text-sm font-medium text-gray-700">Título:</label>
            <input type="text" name="title" id="title" required
                class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="mb-5">
            <label for="photoUrl" class="block text-sm font-medium text-gray-700">URL de la Foto:</label>
            <input type="text" name="photoUrl" id="photoUrl" required
                class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="mb-5">
            <label for="content" class="block text-sm font-medium text-gray-700">Contenido:</label>
            <textarea name="content" id="content" required
                class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
        </div>
        <div class="mb-5">
            <label for="author_id" class="block text-sm font-medium text-gray-700">Autor:</label>
            <input type="number" name="author_id" id="author_id" required
                class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <button type="submit"
            class="font-semibold w-full bg-orange-500 text-white py-2 rounded-2xl hover:bg-orange-600">AÑADIR POST</button>
    </form>

    <?php if ($postToEdit): ?>
        <!-- Edit Post Form -->
        <h3 class="text-2xl font-semibold mt-10 mb-4 text-center text-gray-800">EDITAR POST</h3>
        <form method="post" class="bg-orange-200 bg-opacity-20 p-8 rounded-2xl shadow-lg w-full max-w-lg mx-auto mb-8">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($postToEdit['id']); ?>">
            <div class="mb-5">
                <label for="title" class="block text-sm font-medium text-gray-700">Título:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($postToEdit['title']); ?>" required
                    class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="mb-5">
                <label for="photoUrl" class="block text-sm font-medium text-gray-700">URL de la Foto:</label>
                <input type="text" name="photoUrl" id="photoUrl" value="<?php echo htmlspecialchars($postToEdit['photoUrl']); ?>" required
                    class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="mb-5">
                <label for="content" class="block text-sm font-medium text-gray-700">Contenido:</label>
                <textarea name="content" id="content" required
                    class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500"><?php echo htmlspecialchars($postToEdit['content']); ?></textarea>
            </div>
            <div class="mb-5">
                <label for="author_id" class="block text-sm font-medium text-gray-700">Autor:</label>
                <input type="number" name="author_id" id="author_id" value="<?php echo htmlspecialchars($postToEdit['author_id']); ?>" required
                    class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <button type="submit"
                class="font-semibold w-full bg-orange-500 text-white py-2 rounded-2xl hover:bg-orange-600">ACTUALIZAR POST</button>
        </form>
    <?php endif; ?>
</div>