<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/answers-data.php';
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/error-page.php';
requireAdminLogin();

$id = (int) ($_GET['id'] ?? 0);

try {
    $inquiry = $id > 0 ? getInquiry($id) : null;

    if ($inquiry && $_SERVER['REQUEST_METHOD'] === 'POST' && csrfCheck($_POST['csrf_token'] ?? '')) {
        $replyMessage = trim($_POST['reply_message'] ?? '');
        $quoteText = trim($_POST['quote_text'] ?? '');
        if ($replyMessage !== '') {
            addReply($id, currentAdminUsername(), $replyMessage, $quoteText);
            header('Location: ' . url('/admin/view.php') . '?id=' . $id);
            exit;
        }
    }

    $replies = $inquiry ? getRepliesFor($inquiry['id']) : [];
} catch (Throwable $e) {
    renderDbErrorPage($e);
}

$pageTitle = t('admin.dashboard.title') . ' | DESIGN DAN';
$activeNav = '';
$isDetailPage = true;
$isNoIndex = true;   // 관리자 화면은 검색엔진에 노출 안 함
require __DIR__ . '/../includes/header.php';
?>
<main>
<section class="detail-hero">
    <div class="container">
        <a class="detail-back" href="<?= url('/admin/index.php') ?>"><?= te('answers.back_to_list') ?></a>
        <h1>#<?= (int) ($id ?: 0) ?></h1>
    </div>
</section>

<section class="section" style="padding-top:16px;">
    <div class="container" style="max-width:720px;">

        <?php if (!$inquiry): ?>
            <div class="empty-state"><p><?= te('answers.empty') ?></p></div>
        <?php else: ?>

            <div class="card" style="margin-bottom:24px;">
                <p class="answer-detail__label"><?= te('admin.contact_details') ?></p>
                <p style="margin-bottom:14px;">
                    <?= htmlspecialchars($inquiry['name']) ?><br>
                    <a href="mailto:<?= htmlspecialchars($inquiry['email']) ?>"><?= htmlspecialchars($inquiry['email']) ?></a>
                    <?php if ($inquiry['phone']): ?><br><a href="tel:<?= htmlspecialchars($inquiry['phone']) ?>"><?= htmlspecialchars($inquiry['phone']) ?></a><?php endif; ?>
                </p>

                <?php if ($inquiry['inquiry_type']): ?>
                    <p class="answer-detail__label"><?= te('answers.field.type') ?></p>
                    <p style="margin-bottom:14px;"><?= htmlspecialchars($inquiry['inquiry_type']) ?></p>
                <?php endif; ?>

                <p class="answer-detail__label"><?= te('answers.field.message') ?></p>
                <p style="white-space:pre-wrap;margin-bottom:14px;"><?= nl2br(htmlspecialchars($inquiry['message'])) ?></p>

                <p class="answer-detail__label"><?= te('answers.field.date') ?></p>
                <p><?= htmlspecialchars(substr($inquiry['created_at'], 0, 10)) ?><?= !empty($inquiry['is_locked']) ? ' · ' . icon('lock') : '' ?></p>
            </div>

            <?php if (!empty($replies)): ?>
                <p class="answer-detail__label" style="margin-bottom:8px;"><?= te('admin.reply.existing_heading') ?></p>
                <?php foreach ($replies as $reply): ?>
                    <div class="card card--cream" style="margin-bottom:16px;">
                        <p style="white-space:pre-wrap;margin-bottom:<?= $reply['quote_text'] ? '14px' : '0' ?>;"><?= nl2br(htmlspecialchars($reply['reply_message'])) ?></p>
                        <?php if (!empty($reply['quote_text'])): ?>
                            <p class="answer-detail__label"><?= te('answers.reply.quote_heading') ?></p>
                            <p style="white-space:pre-wrap;"><?= nl2br(htmlspecialchars($reply['quote_text'])) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="card">
                <p class="answer-detail__label" style="margin-bottom:10px;"><?= te('admin.reply.heading') ?></p>
                <form method="post" class="form-grid">
                    <?= csrfField() ?>
                    <div class="field field--full">
                        <label for="replyMessage"><?= te('admin.reply.message.label') ?></label>
                        <textarea id="replyMessage" name="reply_message" required style="min-height:120px;"></textarea>
                    </div>
                    <div class="field field--full">
                        <label for="quoteText"><?= te('admin.reply.quote.label') ?></label>
                        <textarea id="quoteText" name="quote_text" style="min-height:80px;"></textarea>
                        <p class="field__hint"><?= te('admin.reply.quote.hint') ?></p>
                    </div>
                    <button type="submit" class="btn btn--primary field--full" style="justify-content:center;"><?= te('admin.reply.submit') ?></button>
                </form>
            </div>

        <?php endif; ?>
    </div>
</section>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
