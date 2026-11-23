<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verifyCsrfToken($_POST['csrf_token'] ?? null)) {
    setFlashMessage('error', 'Permintaan penghapusan tidak sah.');
    header('Location: index.php?page=user/list');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $stmt =$pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' =>$id]);
    setFlashMessage('success', 'Data pengguna berhasil dihapus.');
} else {
    setFlashMessage('error', 'ID pengguna tidak valid.');
}

header('Location: index.php?page=user/list');
exit;