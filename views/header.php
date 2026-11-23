<?php
// Mengambil rute aktif untuk menandai menu navigasi (Tantangan Mandiri)
$currentPage =$_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi PHP Modular - Lab9Web</title>
    <!-- Gunakan path relatif konsisten dari root project -->
    <link rel="stylesheet" href="/Lab9Web/assets/css/style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Aplikasi PHP Modular</h1>
        <p>Implementasi Template, Function Library, Routing Aman, dan CRUD</p>
    </header>
    <nav>
        <a href="index.php?page=home" class="<?= $currentPage === 'home' ? 'active' : '' ?>">Home</a>
        <a href="index.php?page=profil" class="<?= $currentPage === 'profil' ? 'active' : '' ?>">Profil</a>
        <a href="index.php?page=kontak" class="<?= $currentPage === 'kontak' ? 'active' : '' ?>">Kontak</a>
        <a href="index.php?page=user/list" class="<?= str_starts_with($currentPage, 'user/') ? 'active' : '' ?>">Data User</a>
        <?php if (!empty($_SESSION['user_login'])): ?>
            <a href="index.php?page=auth/logout">Logout (<?= e($_SESSION['user_login']) ?>)</a>
        <?php else: ?>
            <a href="index.php?page=auth/login" class="<?= $currentPage === 'auth/login' ? 'active' : '' ?>">Login</a>
        <?php endif; ?>
    </nav>
    <main>
        <?php
        // Menampilkan pesan sukses/gagal jika tersedia (Tantangan Mandiri)
        if (function_exists('renderFlashMessage')) {
            renderFlashMessage();
        }
        ?>