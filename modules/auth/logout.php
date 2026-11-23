<?php
// modules/auth/logout.php
unset($_SESSION['user_login']);
setFlashMessage('success', 'Anda telah keluar dari sesi.');
header('Location: index.php?page=home');
exit;