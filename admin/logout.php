<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/auth.php';

unset($_SESSION['admin_username']);
session_destroy();

header('Location: ' . url('/admin/login.php'));
exit;
