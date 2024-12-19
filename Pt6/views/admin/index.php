<script src="https://cdn.tailwindcss.com"></script>
<div class="p-8 text-center">
    <h1 class="text-3xl font-semibold mt-10 mb-10 text-center text-gray-800">PANEL ADMINISTRATIVO</h1>
    <?php if ($loggedUser): ?>
        <p class="text-xl font-semibold mt-10 mb-10 text-center text-orange-400">
            <?php echo htmlspecialchars("BIENVENID@, " . $loggedUser['username'] . ". Gestiona LUMINA:"); ?>
        </p>
    <?php endif; ?>

    <div class="bg-orange-200 bg-opacity-20 p-8 rounded-lg shadow-lg w-full max-w-lg mx-auto mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">USUARIOS</h2>
        <a href="/admin/usuarios" class="text-orange-500 hover:underline">Editar usuarios</a>
    </div>

    <div class="bg-orange-200 bg-opacity-20 p-8 rounded-lg shadow-lg w-full max-w-lg mx-auto mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">POSTS</h2>
        <a href="/admin/posts" class="text-orange-500 hover:underline">Editar posts</a>
    </div>

    <div class="bg-orange-200 bg-opacity-20 p-8 rounded-lg shadow-lg w-full max-w-lg mx-auto mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">COMENTARIOS</h2>
        <a href="/admin/comentarios" class="text-orange-500 hover:underline">Editar comentarios</a>
    </div>
</div>