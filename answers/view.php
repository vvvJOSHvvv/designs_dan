<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/answers-data.php';

$id = (int) ($_GET['id'] ?? 0);
$inquiry = $id > 0 ? getInquiry($id) : null;

$passwordError = false;
if ($inquiry && !empty($inquiry['is_locked']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedPassword = (string) ($_POST['password'] ?? '');
    if (verifyInquiryPassword($inquiry, $submittedPassword)) {
        $_SESSION['unlocked_inquiries'][$id] = true;
        header('Location: ' . url('/answers/view.php') . '?id=' . $id);
        exit;
    }
    $passwordError = true;
}

$isUnlocked = !$inquiry || empty($inquiry['is_locked']) || !empty($_SESSION['unlocked_inquiries'][$id]);

$pageTitle = t('answers.title') . ' | DESIGN DAN';
$pageDescription = t('answers.intro');
$activeNav = 'answers';
$isDetailPage = true;
require __DIR__ . '/../includes/header.php';
?>
<main>
<section class="detail-hero">
    <div class="container">
        <a class="detail-back" href="<?= url('/answers/') ?>"><?= te('answers.back_to_list') ?></a>
        <p class="eyebrow"><?= te('answers.eyebrow') ?></p>
        <h1><?= !$inquiry ? '—' : ($isUnlocked ? te('answers.field.message') . ' #' . (int) $inquiry['id'] : te('answers.locked_title')) ?></h1>
    </div>
</section>

<section class="section">
    <div class="container" style="max-width:720px;">

        <?php if (!$inquiry): ?>
            <div class="empty-state"><p><?= te('answers.empty') ?></p></div>

        <?php elseif (!$isUnlocked): ?>
            <div class="card">
                <p style="margin-bottom:16px;"><?= te('answers.password.prompt') ?></p>
                <form method="post" class="form-grid">
                    <div class="field field--full">
                        <label for="viewPassword"><?= te('answers.password.label') ?></label>
                        <input type="password" id="viewPassword" name="password" autofocus required>
                    </div>
                    <?php if ($passwordError): ?>
                        <p class="field--full" style="color:#c0392b;font-size:13.5px;"><?= te('answers.password.error') ?></p>
                    <?php endif; ?>
                    <button type="submit" class="btn btn--primary field--full" style="justify-content:center;"><?= te('answers.password.submit') ?></button>
                </form>
            </div>

        <?php else: ?>
            <?php if (!empty($_GET['submitted'])): ?>
                <div class="card" style="margin-bottom:24px;background:var(--color-bg-cream);">
                    <p><?= te('answers.submitted_banner') ?></p>
                </div>
            <?php endif; ?>

            <div class="card" style="margin-bottom:24px;">
                <p class="answer-detail__label"><?= te('answers.field.name') ?></p>
                <p style="margin-bottom:14px;"><?= htmlspecialchars($inquiry['name']) ?></p>

                <?php if ($inquiry['inquiry_type']): ?>
                    <p class="answer-detail__label"><?= te('answers.field.type') ?></p>
                    <p style="margin-bottom:14px;"><?= htmlspecialchars($inquiry['inquiry_type']) ?></p>
                <?php endif; ?>

                <p class="answer-detail__label"><?= te('answers.field.message') ?></p>
                <p style="white-space:pre-wrap;margin-bottom:14px;"><?= nl2br(htmlspecialchars($inquiry['message'])) ?></p>

                <p class="answer-detail__label"><?= te('answers.field.date') ?></p>
                <p><?= htmlspecialchars(substr($inquiry['created_at'], 0, 10)) ?></p>
            </div>

            <?php $replies = getRepliesFor($inquiry['id']); ?>
            <?php if (empty($replies)): ?>
                <div class="card card--cream">
                    <p><?= te('answers.reply.none') ?></p>
                </div>
            <?php else: ?>
                <?php foreach ($replies as $reply): ?>
                    <div class="card card--cream" style="margin-bottom:16px;">
                        <p class="answer-detail__label"><?= te('answers.reply.heading') ?></p>
                        <p style="white-space:pre-wrap;margin-bottom:<?= $reply['quote_text'] ? '14px' : '0' ?>;"><?= nl2br(htmlspecialchars($reply['reply_message'])) ?></p>
                        <?php if (!empty($reply['quote_text'])): ?>
                            <p class="answer-detail__label"><?= te('answers.reply.quote_heading') ?></p>
                            <p style="white-space:pre-wrap;"><?= nl2br(htmlspecialchars($reply['quote_text'])) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</section>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
