<?php
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    setFlashMessage('error', 'ID pengguna tidak valid.');
    header('Location: index.php?page=user/list');
    exit;
}

$stmt =$pdo->prepare("SELECT id, nama, email FROM users WHERE id = :id");
$stmt->execute(['id' =>$id]);
$user =$stmt->fetch();

if (!$user) {
    setFlashMessage('error', 'Data pengguna tidak ditemukan.');
    header('Location: index.php?page=user/list');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        setFlashMessage('error', 'Token keamanan tidak valid.');
        header('Location: index.php?page=user/list');
        exit;
    }

    $nama  = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nama === '' || !validasiEmail($email)) {
        setFlashMessage('error', 'Nama wajib diisi dan email harus valid.');
    } else {
        $update =$pdo->prepare("UPDATE users SET nama = :nama, email = :email WHERE id = :id");
        $update->execute(['nama' =>$nama, 'email' => $email, 'id' =>$id]);
        setFlashMessage('success', 'Data pengguna berhasil diperbarui.');
        header('Location: index.php?page=user/list');
        exit;
    }
}
?>
<section class="content">
    <h2>Edit Pengguna</h2>
    <form method="post" action="index.php?page=user/edit&id=<?= (int)$user['id'] ?>">
        <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()) ?>">
        <p>
            <label>Nama Lengkap:<br><input type="text" name="nama" value="<?= e($user['nama']) ?>" required></label>
        </p>
        <p>
            <label>Email:<br><input type="email" name="email" value="<?= e($user['email']) ?>" required></label>
        </p>
        <button type="submit">Update</button>
        <a href="index.php?page=user/list">Batal</a>
    </form>
</section>