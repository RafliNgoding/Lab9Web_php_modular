<?php

/**
 * Mengamankan output teks agar tidak dieksekusi sebagai HTML/JS (XSS protection)
 */
function e(string $nilai): string
{
    return htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8');
}

/**
 * 1. Memformat angka menjadi format mata uang Rupiah
 */
function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/**
 * 2. Menghitung nominal potongan diskon berdasarkan persentase
 */
function hitungDiskon(float $harga, float$persen = 10): float
{
    if ($persen < 0 || $persen > 100) {
        return 0;
    }
    return $harga * ($persen / 100);
}

/**
 * 3. Memvalidasi format alamat email
 */
function validasiEmail(string $email): bool
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * 4. Meringkas teks panjang sesuai batas karakter maksimum
 */
function ringkasTeks(string $teks, int$batas = 100): string
{
    $teksBersih = trim(strip_tags($teks));
    if (mb_strlen($teksBersih) <=$batas) {
        return $teksBersih;
    }
    return mb_substr($teksBersih, 0,$batas) . '...';
}

/**
 * Helper Flash Message (Tantangan Mandiri)
 */
function setFlashMessage(string $tipe, string$pesan): void
{
    $_SESSION['flash_message'] = [
        'tipe'  => $tipe, // 'success' atau 'error'
        'pesan' => $pesan
    ];
}

function renderFlashMessage(): void
{
    if (!empty($_SESSION['flash_message'])) {
        $flash =$_SESSION['flash_message'];
        $kelas =$flash['tipe'] === 'success' ? 'alert-success' : 'alert-error';
        echo '<div class="' . $kelas . '">' . e($flash['pesan']) . '</div>';
        unset($_SESSION['flash_message']);
    }
}

/**
 * Helper Token CSRF sederhana untuk form POST
 */
function getCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken(?string $token): bool
{
    return is_string($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'],$token);
}