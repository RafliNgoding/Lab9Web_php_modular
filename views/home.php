<?php
$hargaProduk = 350000;
$diskon = hitungDiskon($hargaProduk, 15);$hargaAkhir = $hargaProduk -$diskon;
$deskripsi = "Aplikasi PHP Modular ini memisahkan bagian tampilan, konfigurasi database, kumpulan fungsi pembantu, dan modul fitur agar kode mudah dipelihara dan dikembangkan dalam tim.";
?>
<section class="content">
    <h2>Halaman Home</h2>
    <p><?= e(ringkasTeks($deskripsi, 95)) ?></p>

    <h3>Simulasi Perhitungan Produk</h3>
    <ul>
        <li>Harga Normal: <?= formatRupiah($hargaProduk) ?></li>
        <li>Diskon (15%): <?= formatRupiah($diskon) ?></li>
        <li><strong>Harga Setelah Diskon: <?= formatRupiah($hargaAkhir) ?></strong></li>
    </ul>
</section>