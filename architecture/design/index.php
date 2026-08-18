<?php
require __DIR__ . '/../../config.php';
$pageTitle = t('detail.architecture.design.title') . ' | DESIGN DAN';
$pageDescription = t('detail.architecture.design.intro');
$activeNav = 'architecture';
$isDetailPage = true;
$isDetailFit = true;
$ogImage = 'images/architecture-design.jpg'; // 카카오톡·SNS 공유 시 이 페이지 대표 이미지
require __DIR__ . '/../../includes/header.php';

$detailParentSlug = 'architecture';
$detailTitleKey   = 'detail.architecture.design.title';
$detailIntroKey   = 'detail.architecture.design.intro';
$detailIcon       = 'ruler';
$detailPhoto      = 'images/architecture-design.jpg';
$detailPhotoAlt   = t('detail.architecture.design.title');
?>
<main>
<?php require __DIR__ . '/../../includes/detail-hero.php'; ?>

<section class="section">
    <div class="container">
        <div class="card-grid">
            <div class="card">
                <div class="card__icon"><?= icon('landmark') ?></div>
                <h3><?= te('arch.card1.title') ?></h3>
                <p><?= te('arch.card1.desc') ?></p>
                <div class="card__tags">
                    <span class="tag"><?= te('arch.card1.tag1') ?></span>
                    <span class="tag"><?= te('arch.card1.tag2') ?></span>
                    <span class="tag"><?= te('arch.card1.tag3') ?></span>
                </div>
            </div>
            <div class="card card--cream">
                <div class="card__icon"><?= icon('ruler') ?></div>
                <h3><?= te('arch.card2.title') ?></h3>
                <p><?= te('arch.card2.desc') ?></p>
                <div class="card__tags">
                    <span class="tag"><?= te('arch.card2.tag1') ?></span>
                    <span class="tag"><?= te('arch.card2.tag2') ?></span>
                    <span class="tag"><?= te('arch.card2.tag3') ?></span>
                </div>
            </div>
        </div>

        <div class="detail-cta">
            <a class="btn btn--primary" href="<?= url('/') ?>#contact"><?= te('cta.contact') ?> →</a>
        </div>
    </div>
</section>

</main>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
