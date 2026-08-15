<?php
require __DIR__ . '/../../config.php';
$pageTitle = t('card.design.graphic.title') . ' | DESIGN DAN';
$pageDescription = t('gd.hero_desc');
$activeNav = 'design';
$isDetailPage = true;
require __DIR__ . '/../../includes/header.php';

$detailParentSlug = 'design';
$detailTitleKey   = 'card.design.graphic.title';
$detailIntroKey   = 'gd.hero_desc';
$detailIcon       = '🎨';
?>
<main>
<?php require __DIR__ . '/../../includes/detail-hero.php'; ?>

<section class="section">
    <div class="container">
        <div class="card-grid" style="margin-bottom:36px;">
            <div class="card card--cream">
                <div class="card__icon">🇰🇷</div>
                <h3><?= te('gd.card1.title') ?></h3>
                <p><?= te('gd.card1.desc') ?></p>
            </div>
            <div class="card card--cream">
                <div class="card__icon">🚚</div>
                <h3><?= te('gd.card2.title') ?></h3>
                <p><?= te('gd.card2.desc') ?></p>
            </div>
        </div>

        <h3 style="font-size:18px;font-weight:700;margin-bottom:6px;"><?= te('gd.projects_title') ?></h3>
        <p style="color:var(--color-text-inverse-muted);font-size:14.5px;margin-bottom:6px;"><?= te('gd.projects_desc') ?></p>
        <div class="gd-projects">
            <span class="tag"><?= te('gd.tag1') ?></span>
            <span class="tag"><?= te('gd.tag2') ?></span>
            <span class="tag"><?= te('gd.tag3') ?></span>
            <span class="tag"><?= te('gd.tag4') ?></span>
            <span class="tag"><?= te('gd.tag5') ?></span>
        </div>
    </div>
</section>

<section class="section section--cream">
    <div class="container">
        <div class="section-head">
            <p class="eyebrow"><?= te('gd.process.eyebrow') ?></p>
            <h2><?= te('gd.process.title') ?></h2>
        </div>
        <div class="gd-steps">
            <div class="gd-step">
                <p class="step-num">STEP 1</p>
                <h4><?= te('gd.step1.title') ?></h4>
                <p><?= te('gd.step1.desc') ?></p>
            </div>
            <div class="gd-step">
                <p class="step-num">STEP 2</p>
                <h4><?= te('gd.step2.title') ?></h4>
                <p><?= te('gd.step2.desc') ?></p>
            </div>
            <div class="gd-step">
                <p class="step-num">STEP 3</p>
                <h4><?= te('gd.step3.title') ?></h4>
                <p><?= te('gd.step3.desc') ?></p>
            </div>
            <div class="gd-step">
                <p class="step-num">STEP 4</p>
                <h4><?= te('gd.step4.title') ?></h4>
                <p><?= te('gd.step4.desc') ?></p>
            </div>
        </div>

        <div class="detail-cta">
            <a class="btn btn--primary" href="<?= url('/') ?>#contact"><?= te('cta.contact') ?> →</a>
        </div>
    </div>
</section>

</main>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
