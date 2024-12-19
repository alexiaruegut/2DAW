<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUMINA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<!-- <body>
    <nav class="bg-orange-200 bg-opacity-20 text-black p-3 shadow-lg">
        <div class="container mx-auto flex justify-between items-center py-4">
            <a href="/" class="text-xl text-orange-400 font-bold">LUMINA</a>
            <div class="hidden md:flex space-x-4">
                <a href="/" class="hover:text-orange-400">INICIO</a>
                <?php if ($loggedUser): ?>
                    <a href="/publicar" class="hover:text-orange-400">PUBLICAR</a>
                    <a href="/perfil" class="hover:text-orange-400">PERFIL</a>
                    <a href="views/user/logout.php" class="hover:text-orange-400">CERRAR SESIÓN</a>
                    <?php if ($loggedUser['role'] == 'admin'): ?>
                        <li><a href="/admin" class="hover:text-orange-400>PANEL ADMIN</a></li>
                    <?php endif; ?>
                    <?php else: ?>
                <a href=" /login" class="font-bold hover:text-orange-400">INICIAR SESIÓN</a>
                        <a href="/register" class="hover:text-orange-400">REGISTRARSE</a>
                    <?php endif; ?>
            </div>
            <button class="md:hidden flex items-center px-3 py-2 border rounded text-white border-white">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                </svg>
            </button>
        </div>
    </nav> -->
<body class="min-h-screen flex flex-col">
<nav class="bg-orange-200 bg-opacity-20 text-black p-3 shadow-lg">
    <div class="container mx-auto flex justify-between items-center py-4">
        <a href="/" class="text-xl text-orange-400 font-bold">LUMINA</a>
        <div class="hidden md:flex space-x-4">
            <a href="/" class="hover:text-orange-400">INICIO</a>
            <?php if ($loggedUser): ?>
                <a href="/publicar" class="hover:text-orange-400">PUBLICAR</a>
                <a href="/perfil" class="hover:text-orange-400">PERFIL</a>
                <a href="views/user/logout.php" class="hover:text-orange-400">CERRAR SESIÓN</a>
                <?php if ($loggedUser['role'] == 'admin'): ?>
                    <a href="/admin" class="font-bold hover:text-orange-400">PANEL ADMIN</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="/login" class="font-bold hover:text-orange-400">INICIAR SESIÓN</a>
                <a href="/register" class="hover:text-orange-400">REGISTRARSE</a>
            <?php endif; ?>
        </div>
        <button class="md:hidden flex items-center px-3 py-2 border rounded text-white border-white">
            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
            </svg>
        </button>
    </div>
</nav>

