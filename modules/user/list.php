<?php
$stmt =$pdo->query("SELECT id, nama, email FROM users ORDER BY id DESC");
$users =$stmt->fetchAll();
?>
<section class="content">
    <h2>Daftar Pengguna</h2>
    <p><a href="index.php?page=user/add">+ Tambah Pengguna Baru</a></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr><td colspan="4">Belum ada data pengguna.</td></tr>
            <?php else: ?>
                <?php foreach ($users as $index =>$row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= e($row['nama']) ?></td>
                        <td><?= e($row['email']) ?></td>
                        <td>
                            <a href="index.php?page=user/edit&id=<?= (int)$row['id'] ?>">Edit</a> |
                            <form method="post" action="index.php?page=user/delete" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()) ?>">
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</section>