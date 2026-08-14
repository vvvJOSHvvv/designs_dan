<?php
require __DIR__ . '/../../config.php';
$pageTitle = t('card.solutions.automation.title') . ' | DESIGN DAN';
$pageDescription = t('erf.intro');
$activeNav = 'solutions';
require __DIR__ . '/../../includes/header.php';

$detailParentSlug = 'solutions';
$detailTitleKey   = 'card.solutions.automation.title';
$detailIntroKey   = 'erf.intro';
$detailIcon       = '⚙️';
?>
<main>
<?php require __DIR__ . '/../../includes/detail-hero.php'; ?>

<section class="section">
    <div class="container">
        <div class="about__pills" style="margin-bottom:28px;">
            <span class="tag"><?= te('erf.tag1') ?></span>
            <span class="tag"><?= te('erf.tag2') ?></span>
            <span class="tag"><?= te('erf.tag3') ?></span>
            <span class="tag"><?= te('erf.tag4') ?></span>
        </div>

        <div class="automation">
            <div>
                <div class="automation__feature" style="border-top:1px solid var(--color-border);padding-top:22px;">
                    <div class="automation__feature-icon">💻</div>
                    <div>
                        <h4><?= te('erf.feature1.title') ?></h4>
                        <p><?= te('erf.feature1.desc') ?></p>
                    </div>
                </div>
                <div class="automation__feature">
                    <div class="automation__feature-icon">🧭</div>
                    <div>
                        <h4><?= te('erf.feature2.title') ?></h4>
                        <p><?= te('erf.feature2.desc') ?></p>
                    </div>
                </div>
                <div class="automation__feature">
                    <div class="automation__feature-icon">🛠️</div>
                    <div>
                        <h4><?= te('erf.feature3.title') ?></h4>
                        <p><?= te('erf.feature3.desc') ?></p>
                    </div>
                </div>
            </div>

            <div>
                <div class="automation__apps">
                    <p class="heading"><?= te('erf.apps.heading') ?></p>
                    <ul>
                        <li class="tag"><?= te('erf.apps.1') ?></li>
                        <li class="tag"><?= te('erf.apps.2') ?></li>
                        <li class="tag"><?= te('erf.apps.3') ?></li>
                        <li class="tag"><?= te('erf.apps.4') ?></li>
                        <li class="tag"><?= te('erf.apps.5') ?></li>
                        <li class="tag"><?= te('erf.apps.6') ?></li>
                    </ul>
                </div>
                <div class="automation__cta">
                    <h4><?= te('erf.cta.title') ?></h4>
                    <p><?= te('erf.cta.desc') ?></p>
                    <a class="btn btn--accent" href="<?= url('/') ?>#contact"><?= te('erf.cta.button') ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

</main>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
