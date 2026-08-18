<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/answers-data.php';
require __DIR__ . '/../includes/mask.php';
require __DIR__ . '/../includes/error-page.php';

// DB를 먼저 읽고 나서 화면을 그린다 — 헤더가 이미 출력된 뒤에 DB 오류가 나면
// 에러 페이지를 제대로 그릴 수 없기 때문(renderErrorPage가 헤더를 직접 그린다).
try {
    $inquiries = listInquiries();
} catch (Throwable $e) {
    renderDbErrorPage($e);
}

$pageTitle = t('answers.title') . ' | DESIGN DAN';
$pageDescription = t('answers.intro');
$activeNav = 'answers';
$isDetailPage = true;
require __DIR__ . '/../includes/header.php';
?>
<main>
<section class="detail-hero">
    <div class="container">
        <a class="detail-back" href="<?= url('/') ?>#contact"><?= te('answers.back_to_home') ?></a>
        <p class="eyebrow"><?= te('answers.eyebrow') ?></p>
        <h1><?= te('answers.title') ?></h1>
        <p class="detail-hero__intro"><?= te('answers.intro') ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (empty($inquiries)): ?>
            <div class="empty-state">
                <div class="empty-state__icon"><?= icon('message_circle') ?></div>
                <p><?= te('answers.empty') ?></p>
            </div>
        <?php else: ?>
            <ul class="answer-list">
                <?php foreach ($inquiries as $row): ?>
                    <?php
                    $isAnswered = $row['status'] === 'answered';
                    $typeLabel = $row['inquiry_type'] !== '' ? htmlspecialchars($row['inquiry_type']) : '—';
                    ?>
                    <li>
                        <a class="answer-list__row" href="<?= url('/answers/view.php') ?>?id=<?= (int) $row['id'] ?>">
                            <span class="answer-list__title">
                                <?php if (!empty($row['is_locked'])): ?><span class="answer-list__lock"><?= icon('lock') ?></span><?php endif; ?>
                                <?= htmlspecialchars(maskName($row['name'])) ?> · <?= $typeLabel ?>
                            </span>
                            <span class="answer-list__meta">
                                <span class="badge <?= $isAnswered ? 'badge--answered' : 'badge--pending' ?>">
                                    <?= $isAnswered ? te('answers.status.answered') : te('answers.status.pending') ?>
                                </span>
                                <span class="answer-list__date"><?= htmlspecialchars(substr($row['created_at'], 0, 10)) ?></span>
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
