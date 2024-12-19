<?php
require_once 'config/Database.php';
require_once 'models/Comment.php';
require_once 'controllers/CommentController.php';

use config\Database;
use models\Comment;
use controllers\CommentController;

$database = new Database();
$db = $database->getConnection();

$commentModel = new Comment($db);
$commentController = new CommentController($commentModel);

// Manejo de acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $data = [
                    'content' => $_POST['content'],
                    'post_id' => $_POST['post_id'],
                    'user_id' => $_POST['user_id']
                ];
                if ($commentController->createComment($data)) {
                    echo "<p class='text-green-500'>Comentario añadido correctamente.</p>";
                } else {
                    echo "<p class='text-red-500'>Error: No se pudo añadir el comentario.</p>";
                }
                break;

            case 'edit':
                $data = [
                    'content' => $_POST['content'],
                    'post_id' => $_POST['post_id'],
                    'user_id' => $_POST['user_id']
                ];
                if ($commentController->updateComment($_POST['id'], $data)) {
                    echo "<p class='text-green-500'>Comentario actualizado correctamente.</p>";
                } else {
                    echo "<p class='text-red-500'>Error: No se pudo actualizar el comentario.</p>";
                }
                break;

            case 'delete':
                if ($commentController->deleteComment($_POST['id'])) {
                    echo "<p class='text-green-500'>Comentario eliminado correctamente.</p>";
                } else {
                    echo "<p class='text-red-500'>Error: No se pudo eliminar el comentario.</p>";
                }
                break;
        }
    }
}

// Obtener todos los comentarios
$comments = $commentController->listComments();

// Check if we are editing a specific comment
$commentToEdit = null;
if (isset($_GET['edit_id'])) {
    $commentToEdit = $commentController->getCommentById($_GET['edit_id']);
}
?>

<script src="https://cdn.tailwindcss.com"></script>
<div class="p-8">
    <h1 class="text-3xl font-semibold mt-10 mb-10 text-center text-gray-800">GESTIÓN DE COMENTARIOS</h1>
    <table class="min-w-full bg-white border border-orange-200 shadow-lg">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contenido</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID del Post</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID del Usuario</th>
                <th class="px-6 py-3 border-b-2 border-orange-200 bg-orange-200 bg-opacity-20 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($comment['id']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($comment['content']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($comment['post_id']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200"><?php echo htmlspecialchars($comment['user_id']); ?></td>
                    <td class="px-6 py-4 border-b border-orange-200">
                        <form method="get" action="" class="inline">
                            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($comment['id']); ?>">
                            <button type="submit" class="text-blue-500 hover:underline">EDITAR</button>
                        </form>
                        <form method="post" style="display:inline;" class="inline">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($comment['id']); ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?');" class="text-red-500 hover:underline">ELIMINAR</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add Comment Form -->
    <h3 class="text-2xl font-semibold mt-10 mb-4 text-center text-gray-800">AÑADIR COMENTARIO</h3>
    <form method="post" class="bg-orange-200 bg-opacity-20 p-8 rounded-2xl shadow-lg w-full max-w-lg mx-auto mb-8">
        <input type="hidden" name="action" value="add">
        <div class="mb-5">
            <label for="content" class="block text-sm font-medium text-gray-700">Contenido:</label>
            <textarea name="content" id="content" required
                class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
        </div>
        <div class="mb-5">
            <label for="post_id" class="block text-sm font-medium text-gray-700">ID del Post:</label>
            <input type="number" name="post_id" id="post_id" required
                class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="mb-5">
            <label for="user_id" class="block text-sm font-medium text-gray-700">ID del Usuario:</label>
            <input type="number" name="user_id" id="user_id" required
                class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <button type="submit"
            class="font-semibold w-full bg-orange-500 text-white py-2 rounded-2xl hover:bg-orange-600">AÑADIR COMENTARIO</button>
    </form>

    <?php if ($commentToEdit): ?>
        <!-- Edit Comment Form -->
        <h3 class="text-2xl font-semibold mt-10 mb-4 text-center text-gray-800">EDITAR COMENTARIO</h3>
        <form method="post" class="bg-orange-200 bg-opacity-20 p-8 rounded-2xl shadow-lg w-full max-w-lg mx-auto mb-8">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($commentToEdit['id']); ?>">
            <div class="mb-5">
                <label for="content" class="block text-sm font-medium text-gray-700">Contenido:</label>
                <textarea name="content" id="content" required
                    class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500"><?php echo htmlspecialchars($commentToEdit['content']); ?></textarea>
            </div>
            <div class="mb-5">
                <label for="post_id" class="block text-sm font-medium text-gray-700">ID del Post:</label>
                <input type="number" name="post_id" id="post_id" value="<?php echo htmlspecialchars($commentToEdit['post_id']); ?>" required
                    class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="mb-5">
                <label for="user_id" class="block text-sm font-medium text-gray-700">ID del Usuario:</label>
                <input type="number" name="user_id" id="user_id" value="<?php echo htmlspecialchars($commentToEdit['user_id']); ?>" required
                    class="w-full px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <button type="submit"
                class="font-semibold w-full bg-orange-500 text-white py-2 rounded-2xl hover:bg-orange-600">ACTUALIZAR COMENTARIO</button>
        </form>
    <?php endif; ?>
</div>