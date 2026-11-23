# Lab9Web - Praktikum 9: PHP Modular

Aplikasi PHP sederhana untuk Praktikum 9 mata kuliah Pemrograman Web. Intinya, satu aplikasi dipecah menjadi beberapa file yang punya tugas masing-masing (template, function, konfigurasi, modul fitur), lalu semua halaman dijalankan lewat satu pintu masuk, yaitu `index.php` sebagai router.

| Keterangan      | Data                 |
| --------------- | -------------------- |
| **Nama**        | Rafli Putra Sudrajat |
| **Kelas**       | I251B                |
| **NIM**         | 312510326            |
| **Mata Kuliah** | Pemrograman Web      |
| **Dosen**       | Agung Nugroho, S.Kom., M.Kom. |

---

## 1. Tujuan Project

1. Memahami modularisasi program, alasan melakukannya, dan manfaatnya.
2. Membedakan `include`, `require`, `include_once`, dan `require_once`.
3. Membuat template (header dan footer) yang dipakai bersama oleh banyak halaman.
4. Membuat function PHP dengan parameter dan nilai kembalian (`return`).
5. Menyusun struktur folder aplikasi PHP secara modular.
6. Membuat routing sederhana berbasis parameter URL, lengkap dengan validasi dan halaman 404.
7. Menggabungkan semuanya ke aplikasi CRUD dari praktikum sebelumnya.

## 2. Kebutuhan Perangkat

- XAMPP (Apache + MariaDB), dengan `mod_rewrite` aktif untuk bagian `.htaccess`
- PHP
- Browser (Chrome)
- Visual Studio Code
- Git dan akun GitHub

## 3. Cara Menjalankan Aplikasi

1. Letakkan folder `Lab9Web` di dalam `htdocs`.
2. Nyalakan **Apache** dan **MySQL** dari XAMPP Control Panel.
3. Buat database dan tabel (lihat [bagian G](#g-integrasi-dengan-database-crud)).
4. Sesuaikan koneksi di `config/database.php` bila perlu.
5. Buka `http://localhost/Lab9Web/index.php` di browser.
6. Untuk membuka halaman Data User, login dulu lewat menu **Login**.

---

## 4. Langkah Praktikum

### A. Pemanggilan file: include dan require

Percobaan dasarnya: panggil file `pesan.php` dari `uji-include.php`, lalu ubah nama `pesan.php` sementara untuk melihat bedanya.

```php
<?php
echo "Sebelum pemanggilan<br>";
include __DIR__ . '/pesan.php';
echo "Sesudah pemanggilan<br>";
?>
```

| Konstruksi | Kalau file tidak ditemukan | Dipakai untuk |
|---|---|---|
| `include` | Muncul peringatan, program tetap jalan | File tambahan yang tidak kritis |
| `require` | Error fatal, program berhenti | File wajib, misalnya konfigurasi database |
| `include_once` | Seperti `include`, tapi tidak dimuat dua kali | Helper opsional |
| `require_once` | Seperti `require`, tapi tidak dimuat dua kali | Konfigurasi dan file inti |

Di project ini, file wajib (koneksi database, helper, header, footer) dimuat dengan `require_once`, dan path-nya dibentuk dengan `__DIR__` supaya aman dari masalah path relatif.

---

### B. Template layout

Header dan footer dipisah ke `views/header.php` dan `views/footer.php`. Setiap halaman tinggal memanggilnya, jadi tampilan selalu seragam.

**views/header.php**

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi PHP Modular</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Aplikasi PHP Modular</h1>
        <p>Implementasi Template, Function Library, Routing Aman, dan CRUD</p>
    </header>
    <nav>
        <a href="index.php?page=home">Home</a>
        <a href="index.php?page=profil">Profil</a>
        <a href="index.php?page=kontak">Kontak</a>
        <a href="index.php?page=user/list">Data User</a>
    </nav>
    <main>
```

**views/footer.php**

```php
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Praktikum Pemrograman Web - PHP Modular</p>
    </footer>
</div>
</body>
</html>
```

Hasilnya: judul, menu, dan footer sama persis di semua halaman, hanya isi tengahnya yang berganti.

**Halaman Profil**

> <img width="785" height="423" alt="image" src="https://github.com/user-attachments/assets/e56b4c26-bb15-445b-bbcf-0222946f8822" />


**Halaman Kontak**

> <img width="782" height="426" alt="image" src="https://github.com/user-attachments/assets/602128dc-8de0-4a30-b4d2-ca95a78b6402" />


Kalau teks menu atau footer mau diubah, cukup mengubah satu file, tidak perlu membuka halaman satu per satu.

---

### C. Function dan helper

Function umum dikumpulkan di `helpers/functions.php` supaya bisa dipakai ulang. Salah satunya helper pesan sukses/gagal (flash message), yang menyimpan pesan ke session lalu menampilkannya sekali di halaman berikutnya.

```php
/**
 * Helper Flash Message (Tantangan Mandiri)
 */
function setFlashMessage(string $tipe, string $pesan): void
{
    $_SESSION['flash_message'] = [
        'tipe'  => $tipe, // 'success' atau 'error'
        'pesan' => $pesan
    ];
}
```

> <img width="790" height="299" alt="image" src="https://github.com/user-attachments/assets/f97c657f-0993-406d-83f2-58063639e702" />


Function ini punya dua parameter, `$tipe` (`success` atau `error`) dan `$pesan`, dan dipakai di banyak proses seperti login dan tambah data.

---

### D. Struktur direktori

> <img width="256" height="857" alt="image" src="https://github.com/user-attachments/assets/e518574a-5b9a-425a-861e-ff1f02cb028a" />


```text
Lab9Web/
├── index.php              # pintu masuk + router
├── .htaccess              # aturan URL ringkas
├── README.md
├── assets/
│   └── css/
│       └── style.css
├── config/
│   └── database.php       # koneksi database
├── helpers/
│   └── functions.php      # function umum
├── modules/
│   ├── auth/
│   │   ├── login.php
│   │   └── logout.php
│   └── user/
│       ├── add.php
│       ├── delete.php
│       ├── edit.php
│       └── list.php
└── views/
    ├── 404.php
    ├── footer.php
    ├── header.php
    ├── home.php
    ├── kontak.php
    └── profil.php
```

Pembagian tugasnya:

- `index.php`: titik masuk aplikasi sekaligus router.
- `config/`: konfigurasi aplikasi, termasuk koneksi database di satu file.
- `views/`: tampilan bersama (header, footer) dan halaman statis (home, profil, kontak, 404).
- `helpers/`: function umum yang dipakai banyak modul.
- `modules/`: fitur aplikasi per fungsi, yaitu `auth` (login/logout) dan `user` (CRUD pengguna).
- `assets/`: file statis seperti CSS.

---

### E. Routing dengan whitelist

Semua halaman dibuka lewat `index.php?page=...`. Router mencocokkan nilai `page` dengan daftar rute yang diizinkan (whitelist). Nilai dari URL tidak pernah langsung dipakai sebagai path file, jadi aman dari path traversal.

```php
<?php
require_once __DIR__ . '/helpers/functions.php';

$routes = [
    'home'        => __DIR__ . '/views/home.php',
    'profil'      => __DIR__ . '/views/profil.php',
    'kontak'      => __DIR__ . '/views/kontak.php',
    'auth/login'  => __DIR__ . '/modules/auth/login.php',
    'auth/logout' => __DIR__ . '/modules/auth/logout.php',
    'user/list'   => __DIR__ . '/modules/user/list.php',
    'user/add'    => __DIR__ . '/modules/user/add.php',
    'user/edit'   => __DIR__ . '/modules/user/edit.php',
    'user/delete' => __DIR__ . '/modules/user/delete.php',
];

$page = $_GET['page'] ?? 'home';

if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $contentFile = __DIR__ . '/views/404.php';
} else {
    $contentFile = $routes[$page];
}

require_once __DIR__ . '/views/header.php';
require $contentFile;
require_once __DIR__ . '/views/footer.php';
?>
```

**Rute valid** (contoh `index.php?page=user/list`):

> <img width="785" height="418" alt="image" src="https://github.com/user-attachments/assets/0c2c86f9-5d4d-4af8-8bb0-d6b529276ce2" />


**Rute tidak terdaftar** (contoh `page=admin/rahasia`) otomatis menampilkan halaman 404 dengan status HTTP 404:

> <img width="975" height="482" alt="image" src="https://github.com/user-attachments/assets/0eeceea5-c610-4523-9839-c64309c62624" />


---

### F. URL ringkas dengan .htaccess

Supaya URL tidak selalu panjang, saya menambahkan `.htaccess` yang meneruskan semua permintaan (selain file atau folder asli) ke router:

```apache
RewriteEngine On

# Jika file atau direktori fisik tersedia, layani langsung
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# Selain itu, arahkan ke router utama
RewriteRule ^(.+)$ index.php?page=$1 [QSA,L]
```

**Sebelum: URL biasa**

> <img width="539" height="103" alt="image" src="https://github.com/user-attachments/assets/921b8377-6a0f-40cf-8807-b61d25be586b" />


**Sesudah: URL ringkas**

> <img width="975" height="545" alt="image" src="https://github.com/user-attachments/assets/8c50edae-eddf-4b68-91a3-60c615948304" />


Alamat `/Lab9Web/profil` diteruskan ke `index.php?page=profil` secara otomatis.

---

### G. Integrasi dengan database (CRUD)

Aplikasi CRUD dari praktikum sebelumnya dipindah ke struktur modular: koneksi di `config/database.php`, halaman pengguna di `modules/user/`, dan semua tautan memakai pola `index.php?page=...`.

**1. Membuat database dan tabel**

```sql
CREATE DATABASE Lab9Web;
USE Lab9Web;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);
```

> <img width="578" height="507" alt="image" src="https://github.com/user-attachments/assets/d0320e9e-9a1c-425e-9d68-1af977e96d52" />


**2. Daftar pengguna (Read)**

Saat tabel masih kosong, halaman menampilkan "Belum ada data pengguna."

> <img width="760" height="441" alt="image" src="https://github.com/user-attachments/assets/54b1e854-b535-40b3-9b58-8825472f6a31" />


**3. Tambah pengguna (Create)**

Setelah data ditambahkan, muncul pesan sukses dan data tampil di tabel, lengkap dengan aksi **Edit** dan **Hapus**.

> <img width="810" height="400" alt="image" src="https://github.com/user-attachments/assets/46c1fc1b-6840-42d9-b64a-8060c98a63a2" />


**4. Hapus pengguna (Delete)**

Penghapusan memakai tombol (bukan tautan biasa) dan selalu meminta konfirmasi dulu, sesuai saran modul bahwa data tidak boleh terhapus hanya karena sebuah URL dibuka.

> <img width="828" height="364" alt="image" src="https://github.com/user-attachments/assets/238ec42b-62b2-423c-87a3-058c71649ab4" />


---

### H. Tantangan mandiri

**1. Menu aktif (active navigation)**

Menu yang sedang dibuka ditandai warna biru tua. Terlihat di semua screenshot, misalnya **Profil** aktif di halaman Profil dan **Data User** aktif di halaman Daftar Pengguna.

**2. Helper pesan sukses dan gagal**

Memakai `setFlashMessage()` (lihat [bagian C](#c-function-dan-helper)). Pesan hijau untuk berhasil, merah untuk gagal.

**3. Pembatasan akses (login)**

Halaman Data User hanya bisa diakses setelah login. Kalau belum login, pengguna diarahkan ke halaman login dengan pesan peringatan:

> <img width="753" height="407" alt="image" src="https://github.com/user-attachments/assets/be4d5a88-410e-43ef-8080-869c97c7b239" />


Kalau username atau password salah, muncul pesan error:

> <img width="794" height="475" alt="image" src="https://github.com/user-attachments/assets/9c4b5a72-3ff1-4401-9904-46ba04953c57" />

Kalau benar, pengguna masuk dan menu berubah menjadi **Logout (admin)**:

> <img width="760" height="441" alt="image" src="https://github.com/user-attachments/assets/bc23c8f1-80f6-4238-b085-409327b9fc0b" />


**4. URL rewrite dengan .htaccess**

Sudah dijelaskan di [bagian F](#f-url-ringkas-dengan-htaccess).

---

## 5. Daftar Rute

| Rute (`?page=`) | File | Keterangan |
|---|---|---|
| *(kosong)* / `home` | `views/home.php` | Halaman beranda |
| `profil` | `views/profil.php` | Profil pengguna |
| `kontak` | `views/kontak.php` | Formulir kontak |
| `auth/login` | `modules/auth/login.php` | Halaman login |
| `auth/logout` | `modules/auth/logout.php` | Proses logout |
| `user/list` | `modules/user/list.php` | Daftar pengguna |
| `user/add` | `modules/user/add.php` | Tambah pengguna |
| `user/edit` | `modules/user/edit.php` | Ubah data pengguna |
| `user/delete` | `modules/user/delete.php` | Hapus pengguna |
| *(rute lain)* | `views/404.php` | Halaman tidak ditemukan (status 404) |

Dengan `.htaccess` aktif, rute di atas juga bisa dibuka dengan URL ringkas, misalnya `/Lab9Web/profil`.

## 6. Kendala dan Cara Mengatasinya

| Kendala | Penyebab | Cara mengatasi |
|---|---|---|
| Error `Failed opening required` | Path file salah atau file belum ada | Cek struktur folder, bentuk path dengan `__DIR__` |
| CSS tidak tampil setelah URL ringkas | Path aset ikut berubah saat URL berubah | Samakan path CSS agar konsisten |
| URL ringkas menghasilkan 404 dari Apache | `mod_rewrite` atau `AllowOverride` belum aktif | Aktifkan `mod_rewrite`, pastikan `.htaccess` ada di folder yang benar |
| Header atau footer tampil dobel | Template dipanggil lebih dari satu tempat | Pusatkan pemanggilan layout di `index.php` |

## 7. Kesimpulan

Setelah dimodularisasi, kode jadi lebih rapi dan mudah dicari. Perubahan tampilan cukup dilakukan di satu tempat, koneksi database hanya ada di satu file, dan setiap halaman punya tanggung jawab yang jelas. Router dengan whitelist membuat aplikasi lebih aman karena hanya halaman terdaftar yang bisa dibuka. Fitur CRUD tetap berjalan normal di struktur yang baru.
