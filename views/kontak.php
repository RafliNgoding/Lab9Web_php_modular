<?php
$hasilKirim = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');

    if ($nama === '' || !validasiEmail($email) || $pesan === '') {$hasilKirim = '<div class="alert-error">Pastikan nama, email valid, dan pesan sudah diisi.</div>';
    } else {
        $hasilKirim = '<div class="alert-success">Terima kasih ' . e($nama) . ', pesan berhasil divalidasi.</div>';
    }
}
?>
<section class="content">
    <h2>Hubungi Kami</h2>
    <?= $hasilKirim ?>
    <form method="post" action="index.php?page=kontak">
        <p>
            <label>Nama:<br><input type="text" name="nama" required></label>
        </p>
        <p>
            <label>Email:<br><input type="email" name="email" required></label>
        </p>
        <p>
            <label>Pesan:<br><textarea name="pesan" rows="4" required></textarea></label>
        </p>
        <button type="submit">Kirim Pesan</button>
    </form>
</section>