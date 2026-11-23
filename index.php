<?php
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/functions.php';

// Whitelist rute resmi (lebih dari 5 rute)
$routes = [
    'home'        => __DIR__ . '/views/home.php',
    'profil'      => __DIR__ . '/views/profil.php',
    'kontak'      => __DIR__ . '/views/kontak.php',
    'user/list'   => __DIR__ . '/modules/user/list.php',
    'user/add'    => __DIR__ . '/modules/user/add.php',
    'user/edit'   => __DIR__ . '/modules/user/edit.php',
    'user/delete' => __DIR__ . '/modules/user/delete.php',
    'auth/login'  => __DIR__ . '/modules/auth/login.php',
    'auth/logout' => __DIR__ . '/modules/auth/logout.php',
];

// Daftar rute yang wajib login (Tantangan Mandiri: Pembatasan Akses)
$protectedRoutes = ['user/add', 'user/edit', 'user/delete'];

$page =$_GET['page'] ?? 'home';

// Validasi tipe data dan keberadaan di whitelist
if (!is_string($page) || !array_key_exists($page,$routes)) {
    http_response_code(404);
    $contentFile = __DIR__ . '/views/404.php';
} elseif (in_array($page, $protectedRoutes, true) && empty($_SESSION['user_login'])) {
    setFlashMessage('error', 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.');
    header('Location: index.php?page=auth/login');
    exit;
} else {
    $contentFile = $routes[$page];
}

// Tangani rute aksi tanpa tampilan HTML (delete & logout) sebelum header dimuat
if (in_array($page, ['user/delete', 'auth/logout'], true) && file_exists($contentFile)) {
    require $contentFile;
    exit;
}

require_once __DIR__ . '/views/header.php';
require $contentFile;
require_once __DIR__ . '/views/footer.php';