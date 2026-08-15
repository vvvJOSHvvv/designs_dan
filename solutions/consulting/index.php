<?php
require __DIR__ . '/../../config.php';
$pageTitle = t('card.solutions.consulting.title') . ' | DESIGN DAN';
$pageDescription = t('consult.intro');
$activeNav = 'solutions';
$isDetailPage = true;
require __DIR__ . '/../../includes/header.php';

$detailParentSlug = 'solutions';
$detailTitleKey   = 'card.solutions.consulting.title';
$detailIntroKey   = 'consult.intro';
$detailIcon       = '💼';
?>
<main>
<?php require __DIR__ . '/../../includes/detail-hero.php'; ?>

<section class="section">
    <div class="container">
        <div class="consulting-grid">
            <div class="card">
                <div class="card__icon">📄</div>
                <h3><?= te('consult.c1.title') ?></h3>
                <p><?= te('consult.c1.desc') ?></p>
                <div class="card__tags">
                    <span class="tag"><?= te('consult.c1.tag1') ?></span><span class="tag"><?= te('consult.c1.tag2') ?></span><span class="tag"><?= te('consult.c1.tag3') ?></span>
                </div>
            </div>
            <div class="card">
                <div class="card__icon">📣</div>
                <h3><?= te('consult.c2.title') ?></h3>
                <p><?= te('consult.c2.desc') ?></p>
                <div class="card__tags">
                    <span class="tag"><?= te('consult.c2.tag1') ?></span><span class="tag"><?= te('consult.c2.tag2') ?></span><span class="tag"><?= te('consult.c2.tag3') ?></span>
                </div>
            </div>
            <div class="card">
                <div class="card__icon">📦</div>
                <h3><?= te('consult.c3.title') ?></h3>
                <p><?= te('consult.c3.desc') ?></p>
                <div class="card__tags">
                    <span class="tag"><?= te('consult.c3.tag1') ?></span><span class="tag"><?= te('consult.c3.tag2') ?></span><span class="tag"><?= te('consult.c3.tag3') ?></span>
                </div>
            </div>
            <div class="card">
                <div class="card__icon">📘</div>
                <h3><?= te('consult.c4.title') ?></h3>
                <p><?= te('consult.c4.desc') ?></p>
                <div class="card__tags">
                    <span class="tag"><?= te('consult.c4.tag1') ?></span><span class="tag"><?= te('consult.c4.tag2') ?></span><span class="tag"><?= te('consult.c4.tag3') ?></span>
                </div>
            </div>
            <div class="card">
                <div class="card__icon">💰</div>
                <h3><?= te('consult.c5.title') ?></h3>
                <p><?= te('consult.c5.desc') ?></p>
                <div class="card__tags">
                    <span class="tag"><?= te('consult.c5.tag1') ?></span><span class="tag"><?= te('consult.c5.tag2') ?></span><span class="tag"><?= te('consult.c5.tag3') ?></span>
                </div>
            </div>
            <div class="card">
                <div class="card__icon">🧑‍💼</div>
                <h3><?= te('consult.c6.title') ?></h3>
                <p><?= te('consult.c6.desc') ?></p>
                <div class="card__tags">
                    <span class="tag"><?= te('consult.c6.tag1') ?></span><span class="tag"><?= te('consult.c6.tag2') ?></span><span class="tag"><?= te('consult.c6.tag3') ?></span>
                </div>
            </div>
        </div>

        <div class="section--dark process" style="margin-top:32px;">
            <div class="process-head">
                <div>
                    <p class="eyebrow"><?= te('process2.eyebrow') ?></p>
                    <h2><?= te('process2.title') ?></h2>
                </div>
                <p><?= te('process2.intro') ?></p>
            </div>
            <div class="process-steps">
                <div class="process-step">
                    <div class="process-step__top"><span class="process-step__num">01</span><span class="process-step__icon">🔍</span></div>
                    <h4><?= te('process2.step1.title') ?></h4>
                    <p><?= te('process2.step1.desc') ?></p>
                </div>
                <div class="process-step">
                    <div class="process-step__top"><span class="process-step__num">02</span><span class="process-step__icon">🧩</span></div>
                    <h4><?= te('process2.step2.title') ?></h4>
                    <p><?= te('process2.step2.desc') ?></p>
                </div>
                <div class="process-step">
                    <div class="process-step__top"><span class="process-step__num">03</span><span class="process-step__icon">🤝</span></div>
                    <h4><?= te('process2.step3.title') ?></h4>
                    <p><?= te('process2.step3.desc') ?></p>
                </div>
                <div class="process-step">
                    <div class="process-step__top"><span class="process-step__num">04</span><span class="process-step__icon">📈</span></div>
                    <h4><?= te('process2.step4.title') ?></h4>
                    <p><?= te('process2.step4.desc') ?></p>
                </div>
            </div>
            <div class="process-foot">
                <p><?= te('process2.footnote') ?></p>
                <a class="btn btn--accent" href="<?= url('/') ?>#contact"><?= te('process2.cta') ?></a>
            </div>
        </div>
    </div>
</section>

</main>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
