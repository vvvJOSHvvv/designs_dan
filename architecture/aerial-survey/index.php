<?php
require __DIR__ . '/../../config.php';
$pageTitle = t('detail.architecture.aerial.title') . ' | DESIGN DAN';
$pageDescription = t('detail.architecture.aerial.intro');
$activeNav = 'architecture';
$isDetailPage = true;
$isDetailFit = true;
$ogImage = 'images/architecture-survey.jpg'; // 카카오톡·SNS 공유 시 이 페이지 대표 이미지
require __DIR__ . '/../../includes/header.php';

$detailParentSlug = 'architecture';
$detailTitleKey   = 'detail.architecture.aerial.title';
$detailIntroKey   = 'detail.architecture.aerial.intro';
$detailIcon       = 'satellite';
$detailPhoto      = 'images/architecture-survey.jpg';
$detailPhotoAlt   = t('detail.architecture.aerial.title');
?>
<main>
<?php require __DIR__ . '/../../includes/detail-hero.php'; ?>

<section class="section">
    <div class="container">
        <div class="card-grid card-grid--3">
            <div class="card">
                <div class="card__icon"><?= icon('drone') ?></div>
                <h3><?= te('detail.architecture.aerial.f1.title') ?></h3>
                <p><?= te('detail.architecture.aerial.f1.desc') ?></p>
            </div>
            <div class="card card--cream">
                <div class="card__icon"><?= icon('map') ?></div>
                <h3><?= te('detail.architecture.aerial.f2.title') ?></h3>
                <p><?= te('detail.architecture.aerial.f2.desc') ?></p>
            </div>
            <div class="card">
                <div class="card__icon"><?= icon('file_text') ?></div>
                <h3><?= te('detail.architecture.aerial.f3.title') ?></h3>
                <p><?= te('detail.architecture.aerial.f3.desc') ?></p>
            </div>
        </div>

        <div class="detail-cta">
            <a class="btn btn--primary" href="<?= url('/') ?>#contact"><?= te('cta.contact') ?> →</a>
        </div>
    </div>
</section>

</main>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
