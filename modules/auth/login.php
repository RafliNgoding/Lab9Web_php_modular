<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['user_login'] = $username;
        setFlashMessage('success', 'Login berhasil. Selamat datang, ' . $username . '!');
        header('Location: index.php?page=user/list');
        exit;
    } else {
        setFlashMessage('error', 'Username atau password salah.');
        header('Location: index.php?page=auth/login');
        exit;
    }
}
?>
<section class="content">
    <h2>Login Sistem</h2>
    <form method="post" action="index.php?page=auth/login">
        <p>
            <label>Username:<br>
            <input type="text" name="username" required></label>
        </p>
        <p>
            <label>Password:<br>
            <input type="password" name="password" required></label>
        </p>
        <button type="submit">Masuk</button>
    </form>
</section>