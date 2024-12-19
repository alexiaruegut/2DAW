<?php
require_once 'config/Database.php';
require_once 'models/PostModel.php';
require_once 'controllers/PostController.php';

use config\Database;
use models\PostModel;
use controllers\PostController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Usuario actual (asumiendo que está en sesión)
    $user = $_SESSION['user'];

    // Verifica si se cargó correctamente el archivo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        // Ruta del directorio donde se guardarán las imágenes
        $uploadDir = __DIR__ . '/photos/';

        // Asegúrate de que el directorio exista
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generar un nombre único para la imagen
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = basename($_FILES['photo']['name']);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('img_', true) . '.' . $fileExtension;

        // Ruta completa del archivo a guardar
        $destination = $uploadDir . $newFileName;

        // Mueve el archivo subido al directorio de destino
        if (move_uploaded_file($fileTmpPath, $destination)) {
            // Generar la URL para guardar en la base de datos
            $photoUrl = '/views/post/photos/' . $newFileName;

            // Crear una instancia del modelo y controlador
            $postModel = new PostModel($db);
            $postController = new PostController($postModel);

            // Datos a guardar en la base de datos
            $data = [
                'title' => $_POST['title'],
                'photoUrl' => $photoUrl,
                'content' => $_POST['content'],
                'author_id' => $user['id']
            ];

            // Crear el post
            if ($postController->createPost($data)) {
                header('Location: /');
                exit;
            } else {
                echo "<p>Error: No se pudo registrar el post.</p>";
            }
        } else {
            echo "<p>Error: No se pudo guardar la imagen.</p>";
        }
    } else {
        echo "<p>Error: No se cargó ninguna imagen.</p>";
    }
}
?>
<div class="mb-5">
    <h1 class="text-3xl font-semibold mt-10 mb-10 text-center text-gray-800">PUBLICA UN POST</h1>
    <h2 class="text-xl font-semibold mt-10 mb-10 text-center text-orange-400">Comparte pensamientos, experiencias e
        ideas
    </h2>
    <form method="post" action="/publicar" enctype="multipart/form-data"
        class="bg-orange-200 bg-opacity-20 p-8 rounded-lg shadow-lg w-full max-w-lg mx-auto">
        <div class="mb-5">
            <label for="photo" class="block text-sm font-medium text-gray-700">IMAGEN</label>
            <input type="file" name="photo" id="photo" required
                class="w-full px-3 py-2 border border-white border-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="mb-5">
            <label for="title" class="block text-sm font-medium text-gray-700">TÍTULO</label>
            <input type="text" name="title" id="title" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="mb-5">
            <label for="content" class="block text-sm font-medium text-gray-700">DESCRIPCIÓN</label>
            <textarea name="content" id="content" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
        </div>
        <button type="submit"
            class="font-semibold w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">PUBLICAR</button>
    </form>
</div>