<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        setFlashMessage('error', 'Token keamanan tidak valid.');
        header('Location: index.php?page=user/list');
        exit;
    }

    $nama  = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nama === '' || !validasiEmail($email)) {
        setFlashMessage('error', 'Nama wajib diisi dan email harus berformat valid.');
    } else {
        $stmt =$pdo->prepare("INSERT INTO users (nama, email) VALUES (:nama, :email)");
        $stmt->execute(['nama' => $nama, 'email' =>$email]);
        setFlashMessage('success', 'Data pengguna berhasil ditambahkan.');
        header('Location: index.php?page=user/list');
        exit;
    }
}
?>
<section class="content">
    <h2>Tambah Pengguna</h2>
    <form method="post" action="index.php?page=user/add">
        <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()) ?>">
        <p>
            <label>Nama Lengkap:<br><input type="text" name="nama" required></label>
        </p>
        <p>
            <label>Email:<br><input type="email" name="email" required></label>
        </p>
        <button type="submit">Simpan</button>
        <a href="index.php?page=user/list">Batal</a>
    </form>
</section>