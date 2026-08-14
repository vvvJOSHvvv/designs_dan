<?php
require __DIR__ . '/../../config.php';
$pageTitle = t('card.solutions.website.title') . ' | DESIGN DAN';
$pageDescription = t('detail.solutions.website.intro');
$activeNav = 'solutions';
require __DIR__ . '/../../includes/header.php';

$detailParentSlug = 'solutions';
$detailTitleKey   = 'card.solutions.website.title';
$detailIntroKey   = 'detail.solutions.website.intro';
$detailIcon       = '🖥️';
?>
<main>
<?php require __DIR__ . '/../../includes/detail-hero.php'; ?>

<section class="section">
    <div class="container">
        <div class="card-grid card-grid--3">
            <div class="card">
                <div class="card__icon">📱</div>
                <h3><?= te('detail.solutions.website.f1.title') ?></h3>
                <p><?= te('detail.solutions.website.f1.desc') ?></p>
            </div>
            <div class="card card--cream">
                <div class="card__icon">🗂️</div>
                <h3><?= te('detail.solutions.website.f2.title') ?></h3>
                <p><?= te('detail.solutions.website.f2.desc') ?></p>
            </div>
            <div class="card">
                <div class="card__icon">🧩</div>
                <h3><?= te('detail.solutions.website.f3.title') ?></h3>
                <p><?= te('detail.solutions.website.f3.desc') ?></p>
            </div>
        </div>

        <div class="detail-cta">
            <a class="btn btn--primary" href="<?= url('/') ?>#contact"><?= te('cta.contact') ?> →</a>
        </div>
    </div>
</section>

</main>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
