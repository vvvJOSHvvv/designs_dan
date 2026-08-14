<?php
require __DIR__ . '/../../config.php';
$pageTitle = t('detail.architecture.construction.title') . ' | DESIGN DAN';
$pageDescription = t('detail.architecture.construction.intro');
$activeNav = 'architecture';
require __DIR__ . '/../../includes/header.php';

$detailParentSlug = 'architecture';
$detailTitleKey   = 'detail.architecture.construction.title';
$detailIntroKey   = 'detail.architecture.construction.intro';
$detailIcon       = '🏗️';
$detailPhoto      = 'images/architecture-construction.jpg';
$detailPhotoAlt   = t('detail.architecture.construction.title');
?>
<main>
<?php require __DIR__ . '/../../includes/detail-hero.php'; ?>

<section class="section">
    <div class="container">
        <div class="section--dark process">
            <div class="process-steps">
                <div class="process-step">
                    <div class="process-step__top"><span class="process-step__num">01</span><span class="process-step__icon">📋</span></div>
                    <h4><?= te('process1.step1.title') ?></h4>
                    <p><?= te('process1.step1.desc') ?></p>
                </div>
                <div class="process-step">
                    <div class="process-step__top"><span class="process-step__num">02</span><span class="process-step__icon">✏️</span></div>
                    <h4><?= te('process1.step2.title') ?></h4>
                    <p><?= te('process1.step2.desc') ?></p>
                </div>
                <div class="process-step">
                    <div class="process-step__top"><span class="process-step__num">03</span><span class="process-step__icon">🏗️</span></div>
                    <h4><?= te('process1.step3.title') ?></h4>
                    <p><?= te('process1.step3.desc') ?></p>
                </div>
                <div class="process-step">
                    <div class="process-step__top"><span class="process-step__num">04</span><span class="process-step__icon">✅</span></div>
                    <h4><?= te('process1.step4.title') ?></h4>
                    <p><?= te('process1.step4.desc') ?></p>
                </div>
            </div>
            <div class="process-foot">
                <p><?= te('process1.footnote') ?></p>
                <a class="btn btn--accent" href="<?= url('/') ?>#contact"><?= te('process1.cta') ?></a>
            </div>
        </div>
    </div>
</section>

</main>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
