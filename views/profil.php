<?php
$namaMahasiswa = "Rafli Putra Sudrajat";
$emailMahasiswa = "rafli.312510326@mhs.pelitabangsa.ac.id";
$bio = "Mahasiswa Teknik Informatika yang sedang mempelajari arsitektur aplikasi web modular menggunakan PHP, PDO, dan konsep routing berbasis whitelist.";
?>
<section class="content">
    <h2>Profil Pengguna</h2>
    <p><strong>Nama:</strong> <?= e($namaMahasiswa) ?></p>
    <p>
        <strong>Email:</strong> <?= e($emailMahasiswa) ?>
        (Status: <?= validasiEmail($emailMahasiswa) ? 'Valid' : 'Tidak Valid' ?>)
    </p>
    <p><strong>Bio Singkat:</strong> <?= e(ringkasTeks($bio, 80)) ?></p>
</section>