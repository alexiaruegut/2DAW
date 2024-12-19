<script src="https://cdn.tailwindcss.com"></script>
<div class="min-h-screen p-8">
    <h1 class="text-3xl font-semibold mt-10 mb-10 text-center text-gray-800">PUBLICACIONES</h1>
    <?php if ($loggedUser): ?>
        <p class="text-xl font-semibold mt-10 mb-10 text-center text-orange-400">
            <?php echo htmlspecialchars("BIENVENID@, " . $loggedUser['username'] . ". Publica comentarios e interactua con los demás usuarios."); ?>
        </p>
    <?php endif; ?>

    <?php foreach ($posts as $post): ?>
        <div class="flex items-center justify-center">
            <div class="bg-orange-200 bg-opacity-20 p-6 rounded-lg shadow-lg mb-8 w-3/6 flex flex-col">
                <p><img src="<?php echo htmlspecialchars($post['photoUrl']); ?>" class="w-full h-auto rounded-lg mb-4"></p>
                <h2 class="text-2xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($post['title']); ?></h2>
                <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($post['content']); ?></p>

                <?php foreach ($users as $user): ?>
                    <?php if ($user['id'] == $post['author_id']): ?>
                        <a href="/perfil/<?php echo htmlspecialchars($user['id']); ?>" class="text-orange-500 hover:underline">
                            <?php echo htmlspecialchars($user['username']); ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if ($loggedUser): ?>
                    <form method="post" action="/comment" class="mt-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Comentario:</label>
                        <textarea name="content" id="content" required
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 mb-2"></textarea>
                        <input type="number" name="post_id" id="post_id" value="<?php echo $post['id'] ?>" required hidden>
                        <button type="submit"
                            class="font-semibold w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">PUBLICAR</button>
                    </form>
                <?php endif; ?>

                <ul id="comments<?php echo htmlspecialchars($post['id']); ?>" class="mt-4 bg-white rounded-2xl p-4">
                <p class="text-gray-700 font-bold">COMENTARIOS:</p>
                    <?php foreach ($comments as $comment): ?>
                        <?php if ($comment['post_id'] == $post['id']): ?>
                            <?php foreach ($users as $user): ?>
                                <?php if ($user['id'] == $comment['user_id']): ?>
                                    <li class="text-gray-700 mb-2">
                                        <?php echo $user['username'] . ': ' . htmlspecialchars($comment['content']); ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>
</div>