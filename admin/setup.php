<?php
/**
 * 첫 관리자 계정 생성 페이지 (2026-08-14 추가).
 * admin_users 테이블에 계정이 하나도 없을 때만 동작하고, 계정이 하나라도 생기면
 * 그 이후로는 항상 "이미 있음" 안내만 보여준다 (부트스트랩 전용, 회원가입 페이지 아님).
 * 사용법은 CLAUDE.md의 "관리자 계정 만들기" 참고.
 */
require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/answers-data.php';

$alreadyHasAdmin = hasAnyAdminUser();
$setupError = '';
$setupDone = false;

if (!$alreadyHasAdmin && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    if ($username === '' || $password === '') {
        $setupError = 'required';
    } elseif (mb_strlen($password) < 8) {
        $setupError = 'too_short';
    } else {
        createAdminUser($username, $password);
        $setupDone = true;
        $alreadyHasAdmin = true;
    }
}

$pageTitle = t('admin.setup.title') . ' | DESIGN DAN';
$isDetailPage = true;
require __DIR__ . '/../includes/header.php';
?>
<main>
<section class="detail-hero">
    <div class="container">
        <a class="detail-back" href="<?= url('/') ?>"><?= te('answers.back_to_home') ?></a>
        <h1><?= te('admin.setup.title') ?></h1>
        <p class="detail-hero__intro"><?= te('admin.setup.note') ?></p>
    </div>
</section>
<section class="section" style="padding-top:16px;">
    <div class="container" style="max-width:420px;">

        <?php if ($setupDone): ?>
            <div class="card card--cream">
                <p style="margin-bottom:14px;">✅ <?= htmlspecialchars($_POST['username'] ?? '') ?></p>
                <a class="btn btn--primary" href="<?= url('/admin/login.php') ?>"><?= te('admin.login.title') ?> →</a>
            </div>
        <?php elseif ($alreadyHasAdmin): ?>
            <div class="card"><p><?= te('admin.setup.done') ?></p></div>
        <?php else: ?>
            <form method="post" class="card form-grid">
                <div class="field field--full">
                    <label for="username"><?= te('admin.login.username') ?></label>
                    <input type="text" id="username" name="username" autofocus required>
                </div>
                <div class="field field--full">
                    <label for="password"><?= te('admin.login.password') ?></label>
                    <input type="password" id="password" name="password" minlength="8" required>
                    <p class="field__hint">8자 이상 / at least 8 characters</p>
                </div>
                <?php if ($setupError): ?>
                    <p class="field--full" style="color:#c0392b;font-size:13.5px;">
                        <?= $setupError === 'too_short' ? '비밀번호는 8자 이상이어야 합니다.' : '아이디와 비밀번호를 모두 입력해 주세요.' ?>
                    </p>
                <?php endif; ?>
                <button type="submit" class="btn btn--primary field--full" style="justify-content:center;"><?= te('admin.setup.submit') ?></button>
            </form>
        <?php endif; ?>

    </div>
</section>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
