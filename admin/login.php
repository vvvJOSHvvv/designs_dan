<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/answers-data.php';
require __DIR__ . '/../includes/auth.php';

// 이미 로그인되어 있으면 목록으로
if (isAdminLoggedIn()) {
    header('Location: ' . url('/admin/index.php'));
    exit;
}

$loginError = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $admin = $username !== '' ? findAdminByUsername($username) : null;
    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: ' . url('/admin/index.php'));
        exit;
    }
    $loginError = true;
}

$pageTitle = t('admin.login.title') . ' | DESIGN DAN';
$activeNav = '';
$isDetailPage = true;
require __DIR__ . '/../includes/header.php';
?>
<main>
<section class="detail-hero">
    <div class="container">
        <a class="detail-back" href="<?= url('/') ?>"><?= te('answers.back_to_home') ?></a>
        <h1><?= te('admin.login.title') ?></h1>
    </div>
</section>
<section class="section" style="padding-top:16px;">
    <div class="container" style="max-width:420px;">
        <form method="post" class="card form-grid">
            <div class="field field--full">
                <label for="username"><?= te('admin.login.username') ?></label>
                <input type="text" id="username" name="username" autofocus required>
            </div>
            <div class="field field--full">
                <label for="password"><?= te('admin.login.password') ?></label>
                <input type="password" id="password" name="password" required>
            </div>
            <?php if ($loginError): ?>
                <p class="field--full" style="color:#c0392b;font-size:13.5px;"><?= te('admin.login.error') ?></p>
            <?php endif; ?>
            <button type="submit" class="btn btn--primary field--full" style="justify-content:center;"><?= te('admin.login.submit') ?></button>
        </form>
    </div>
</section>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
