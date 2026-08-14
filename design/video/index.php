<?php
require __DIR__ . '/../../config.php';
$pageTitle = t('detail.design.video.title') . ' | DESIGN DAN';
$pageDescription = t('detail.design.video.intro');
$activeNav = 'design';
require __DIR__ . '/../../includes/header.php';

$detailParentSlug = 'design';
$detailTitleKey   = 'detail.design.video.title';
$detailIntroKey   = 'detail.design.video.intro';
$detailIcon       = '🎬';
?>
<main>
<?php require __DIR__ . '/../../includes/detail-hero.php'; ?>

<section class="section">
    <div class="container">
        <div class="card-grid card-grid--3">
            <div class="card">
                <div class="card__icon">📣</div>
                <h3><?= te('detail.design.video.f1.title') ?></h3>
                <p><?= te('detail.design.video.f1.desc') ?></p>
            </div>
            <div class="card card--cream">
                <div class="card__icon">🎥</div>
                <h3><?= te('detail.design.video.f2.title') ?></h3>
                <p><?= te('detail.design.video.f2.desc') ?></p>
            </div>
            <div class="card">
                <div class="card__icon">🚁</div>
                <h3><?= te('detail.design.video.f3.title') ?></h3>
                <p><?= te('detail.design.video.f3.desc') ?></p>
            </div>
        </div>

        <div class="detail-cta">
            <a class="btn btn--primary" href="<?= url('/') ?>#contact"><?= te('cta.contact') ?> →</a>
        </div>
    </div>
</section>

</main>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
