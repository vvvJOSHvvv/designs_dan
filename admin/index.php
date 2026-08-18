<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/answers-data.php';
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/error-page.php';
requireAdminLogin();

try {
    $inquiries = listInquiries();
} catch (Throwable $e) {
    renderDbErrorPage($e);
}

// 답변 대기중인 문의 개수 — 로그인하면 바로 눈에 보이도록 목록 위에 배지로 표시한다
// (2026-08-16 추가: 예전엔 새 문의가 와도 목록을 하나하나 봐야 알 수 있었다).
$pendingCount = 0;
foreach ($inquiries as $row) {
    if (($row['status'] ?? '') !== 'answered') {
        $pendingCount++;
    }
}

$pageTitle = t('admin.dashboard.title') . ' | DESIGN DAN';
$activeNav = '';
$isDetailPage = true;
$isNoIndex = true;   // 관리자 화면은 검색엔진에 노출 안 함
require __DIR__ . '/../includes/header.php';
?>
<main>
<section class="detail-hero">
    <div class="container" style="display:flex;align-items:flex-end;justify-content:space-between;gap:16px;flex-wrap:wrap;">
        <div>
            <p class="eyebrow"><?= htmlspecialchars(currentAdminUsername()) ?></p>
            <h1><?= te('admin.dashboard.title') ?>
                <?php if ($pendingCount > 0): ?>
                    <span class="badge badge--pending" style="vertical-align:middle;margin-left:8px;"><?= te('admin.dashboard.pending_count') ?> <?= (int) $pendingCount ?></span>
                <?php endif; ?>
            </h1>
        </div>
        <a class="btn btn--outline" href="<?= url('/admin/logout.php') ?>"><?= te('admin.dashboard.logout') ?></a>
    </div>
</section>

<section class="section" style="padding-top:16px;">
    <div class="container">
        <?php if (empty($inquiries)): ?>
            <div class="empty-state"><p><?= te('answers.empty') ?></p></div>
        <?php else: ?>
            <ul class="answer-list">
                <?php foreach ($inquiries as $row): ?>
                    <?php $isAnswered = $row['status'] === 'answered'; ?>
                    <li>
                        <a class="answer-list__row" href="<?= url('/admin/view.php') ?>?id=<?= (int) $row['id'] ?>">
                            <span class="answer-list__title">
                                <?php if (!empty($row['is_locked'])): ?><span class="answer-list__lock"><?= icon('lock') ?></span><?php endif; ?>
                                <?= htmlspecialchars($row['name']) ?> · <?= htmlspecialchars($row['email']) ?>
                                <?= $row['inquiry_type'] ? ' · ' . htmlspecialchars($row['inquiry_type']) : '' ?>
                            </span>
                            <span class="answer-list__meta">
                                <span class="badge <?= $isAnswered ? 'badge--answered' : 'badge--pending' ?>">
                                    <?= $isAnswered ? te('answers.status.answered') : te('answers.status.pending') ?>
                                </span>
                                <span class="answer-list__date"><?= htmlspecialchars(substr($row['created_at'], 0, 10)) ?></span>
                                <span class="answer-list__cta"><?= te('admin.dashboard.view') ?></span>
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
