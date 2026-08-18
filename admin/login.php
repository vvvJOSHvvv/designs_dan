<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/answers-data.php';
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/rate-limit.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/error-page.php';

// 이미 로그인되어 있으면 목록으로
if (isAdminLoggedIn()) {
    header('Location: ' . url('/admin/index.php'));
    exit;
}

$loginError = false;
$lockedOut = false;
$rateLimitId = clientIp();
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrfCheck($_POST['csrf_token'] ?? '')) {
        if (tooManyAttempts('admin_login', $rateLimitId)) {
            $lockedOut = true;
        } else {
            $username = trim($_POST['username'] ?? '');
            $password = (string) ($_POST['password'] ?? '');
            $admin = $username !== '' ? findAdminByUsername($username) : null;
            if ($admin && password_verify($password, $admin['password_hash'])) {
                clearAttempts('admin_login', $rateLimitId);
                session_regenerate_id(true);
                $_SESSION['admin_username'] = $admin['username'];
                header('Location: ' . url('/admin/index.php'));
                exit;
            }
            recordFailedAttempt('admin_login', $rateLimitId);
            $loginError = true;
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $loginError = true; // CSRF 토큰이 없거나 틀림 — 오래된 폼이거나 위조된 요청
    }
} catch (Throwable $e) {
    renderDbErrorPage($e);
}

$pageTitle = t('admin.login.title') . ' | DESIGN DAN';
$activeNav = '';
$isDetailPage = true;
$isNoIndex = true;   // 관리자 화면은 검색엔진에 노출 안 함
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
            <?= csrfField() ?>
            <div class="field field--full">
                <label for="username"><?= te('admin.login.username') ?></label>
                <input type="text" id="username" name="username" autofocus required <?= $lockedOut ? 'disabled' : '' ?>>
            </div>
            <div class="field field--full">
                <label for="password"><?= te('admin.login.password') ?></label>
                <input type="password" id="password" name="password" required <?= $lockedOut ? 'disabled' : '' ?>>
            </div>
            <?php if ($lockedOut): ?>
                <p class="field--full" style="color:#c0392b;font-size:13.5px;"><?= te('admin.login.locked') ?></p>
            <?php elseif ($loginError): ?>
                <p class="field--full" style="color:#c0392b;font-size:13.5px;"><?= te('admin.login.error') ?></p>
            <?php endif; ?>
            <button type="submit" class="btn btn--primary field--full" style="justify-content:center;" <?= $lockedOut ? 'disabled' : '' ?>><?= te('admin.login.submit') ?></button>
        </form>
    </div>
</section>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
