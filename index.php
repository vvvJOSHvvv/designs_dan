<?php
require __DIR__ . '/config.php';
$pageTitle = 'DESIGN DAN | ' . t('home.title');
$pageDescription = t('home.title');
$isHomeTabs = true;
require __DIR__ . '/includes/header.php';

$archTab      = findNavTab('architecture');
$designTab    = findNavTab('design');
$solutionsTab = findNavTab('solutions');
?>

<main>

    <!-- ============ 회사 소개 (기본으로 보이는 탭) ============ -->
    <!-- panel--brand-bg: 건축 설계 회사 느낌에 맞춘 다크 + 블루프린트 라인아트 배경.
         5개 탭 전부에 동일하게 적용된다 (app.css 참고) -->
    <section class="panel panel--brand-bg is-active" id="about" data-panel="about">
        <div class="container about">
            <div class="about__copy">
                <p class="eyebrow"><?= te('about.eyebrow') ?></p>
                <h2><?= te('about.title1') ?><span class="accent"><?= te('about.title2') ?></span></h2>
                <p><?= te('about.p1') ?></p>
                <p><?= te('about.p2') ?></p>
                <div class="about__pills">
                    <span class="pill"><?= icon('user') ?> <?= te('about.pill.client') ?></span>
                    <span class="pill"><?= icon('lightbulb') ?> <?= te('about.pill.expertise') ?></span>
                    <span class="pill"><?= icon('lightbulb') ?> <?= te('about.pill.innovation') ?></span>
                    <span class="pill"><?= icon('shield_check') ?> <?= te('about.pill.trust') ?></span>
                </div>
                <a class="btn btn--accent" data-tab="contact" href="<?= url('/') ?>#contact"><?= te('about.cta') ?> →</a>
            </div>
            <div class="about__media">
                <img class="about__media-photo" src="<?= asset('images/about-main.jpg') ?>" alt="<?= htmlspecialchars(t('about.media_alt')) ?>" loading="lazy">
            </div>
        </div>
    </section>

    <!-- ============ 건축 (카드 3개) ============ -->
    <section class="panel panel--brand-bg" id="architecture" data-panel="architecture">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow"><?= te('tab.architecture.eyebrow') ?></p>
                <h2><?= te('tab.architecture.title') ?></h2>
                <p class="section-head__intro"><?= te('tab.architecture.intro') ?></p>
            </div>
            <div class="card-grid card-grid--3">
                <?php foreach ($archTab['items'] as $item): ?>
                    <a class="service-card" href="<?= url($item['href']) ?>">
                        <?php if (!empty($item['photo'])): ?>
                            <div class="service-card__photo"><img src="<?= asset($item['photo']) ?>" alt="<?= htmlspecialchars(t($item['label_key'])) ?>" loading="lazy"></div>
                        <?php endif; ?>
                        <div class="service-card__head">
                            <div class="service-card__icon"><?= icon($item['icon']) ?></div>
                            <h3><?= te($item['label_key']) ?></h3>
                        </div>
                        <p><?= te($item['teaser_key']) ?></p>
                        <span class="service-card__cta"><?= te('card.view_details') ?> →</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============ 디자인 (카드 2개) ============ -->
    <section class="panel panel--brand-bg" id="design" data-panel="design">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow"><?= te('tab.design.eyebrow') ?></p>
                <h2><?= te('tab.design.title') ?></h2>
                <p class="section-head__intro"><?= te('tab.design.intro') ?></p>
            </div>
            <div class="card-grid">
                <?php foreach ($designTab['items'] as $item): ?>
                    <a class="service-card" href="<?= url($item['href']) ?>">
                        <?php if (!empty($item['photo'])): ?>
                            <div class="service-card__photo"><img src="<?= asset($item['photo']) ?>" alt="<?= htmlspecialchars(t($item['label_key'])) ?>" loading="lazy"></div>
                        <?php endif; ?>
                        <div class="service-card__head">
                            <div class="service-card__icon"><?= icon($item['icon']) ?></div>
                            <h3><?= te($item['label_key']) ?></h3>
                        </div>
                        <p><?= te($item['teaser_key']) ?></p>
                        <span class="service-card__cta"><?= te('card.view_details') ?> →</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============ 솔루션 (카드 4개) ============ -->
    <section class="panel panel--brand-bg" id="solutions" data-panel="solutions">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow"><?= te('tab.solutions.eyebrow') ?></p>
                <h2><?= te('tab.solutions.title') ?></h2>
                <p class="section-head__intro"><?= te('tab.solutions.intro') ?></p>
            </div>
            <div class="card-grid card-grid--4">
                <?php foreach ($solutionsTab['items'] as $item): ?>
                    <a class="service-card" href="<?= url($item['href']) ?>">
                        <?php if (!empty($item['photo'])): ?>
                            <div class="service-card__photo"><img src="<?= asset($item['photo']) ?>" alt="<?= htmlspecialchars(t($item['label_key'])) ?>" loading="lazy"></div>
                        <?php endif; ?>
                        <div class="service-card__head">
                            <div class="service-card__icon"><?= icon($item['icon']) ?></div>
                            <h3><?= te($item['label_key']) ?></h3>
                        </div>
                        <p><?= te($item['teaser_key']) ?></p>
                        <span class="service-card__cta"><?= te('card.view_details') ?> →</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============ 자료실 ============ -->
    <section class="panel panel--brand-bg" id="resources" data-panel="resources">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow"><?= te('tab.resources.eyebrow') ?></p>
                <h2><?= te('tab.resources.title') ?></h2>
                <p class="section-head__intro"><?= te('tab.resources.intro') ?></p>
            </div>
            <div class="card-grid card-grid--3">
                <?php foreach ($RESOURCE_CATEGORIES as $cat): ?>
                    <?php
                    $catName = $LANG === 'ko' ? $cat['name_ko'] : $cat['name_en'];
                    $catDesc = $LANG === 'ko' ? $cat['desc_ko'] : $cat['desc_en'];
                    ?>
                    <div class="card resource-card">
                        <div class="card__icon"><?= icon($cat['icon']) ?></div>
                        <h3><?= htmlspecialchars($catName) ?></h3>
                        <p><?= htmlspecialchars($catDesc) ?></p>
                        <?php if (!empty($cat['files'])): ?>
                            <ul class="resource-card__files">
                                <?php foreach ($cat['files'] as $f): ?>
                                    <?php $fileName = $LANG === 'ko' ? $f['name_ko'] : $f['name_en']; ?>
                                    <li><a href="<?= asset('resources/' . $f['file']) ?>" download><?= htmlspecialchars($fileName) ?> <?= icon('download') ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <span class="badge badge--soon"><?= te('badge.soon') ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============ 문의하기 ============ -->
    <section class="panel panel--brand-bg" id="contact" data-panel="contact">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow"><?= te('contact.eyebrow') ?></p>
                <h2><?= te('contact.title1') ?> <?= te('contact.title2') ?></h2>
                <p class="section-head__intro"><?= te('contact.intro') ?></p>
            </div>

            <div class="contact">
                <div>
                    <div class="contact__info-item">
                        <div class="contact-icon"><?= icon('mail') ?></div>
                        <div><p class="label"><?= te('contact.label.email') ?></p><p class="value"><a href="mailto:designdan2020@gmail.com">designdan2020@gmail.com</a></p></div>
                    </div>
                    <div class="contact__info-item">
                        <div class="contact-icon"><?= icon('phone') ?></div>
                        <div><p class="label"><?= te('contact.label.phone') ?></p><p class="value"><a href="tel:+639455997774">+63-94-5599-7774</a></p></div>
                    </div>
                    <div class="contact__info-item">
                        <div class="contact-icon"><?= icon('camera') ?></div>
                        <div><p class="label"><?= te('contact.label.instagram') ?></p><p class="value"><a href="https://instagram.com/design_dan2020" target="_blank" rel="noopener">@design_dan2020</a></p></div>
                    </div>
                    <div class="contact__info-item">
                        <div class="contact-icon"><?= icon('clock') ?></div>
                        <div><p class="label"><?= te('contact.label.hours') ?></p><p class="value"><?= te('contact.hours.value') ?></p></div>
                    </div>
                </div>

                <form class="card" id="contactForm" method="post" action="<?= url('/actions/inquiry-submit.php') ?>">
                    <div class="form-grid">
                        <div class="field">
                            <label for="cName"><?= te('contact.form.name') ?></label>
                            <input type="text" id="cName" name="name" required>
                        </div>
                        <div class="field">
                            <label for="cEmail"><?= te('contact.form.email') ?></label>
                            <input type="email" id="cEmail" name="email" required>
                        </div>
                        <div class="field">
                            <label for="cPhone"><?= te('contact.form.phone') ?></label>
                            <input type="tel" id="cPhone" name="phone">
                        </div>
                        <div class="field">
                            <label for="cType"><?= te('contact.form.type') ?></label>
                            <select id="cType" name="inquiry_type">
                                <option value=""><?= te('contact.form.type_placeholder') ?></option>
                                <option><?= te('contact.form.type.architecture') ?></option>
                                <option><?= te('contact.form.type.design') ?></option>
                                <option><?= te('contact.form.type.solutions') ?></option>
                                <option><?= te('contact.form.type.other') ?></option>
                            </select>
                        </div>
                        <div class="field field--full">
                            <label for="contactMessage"><?= te('contact.form.message') ?> <span id="contactMessageCount" style="font-weight:400;color:var(--color-text-soft)">(0/500)</span></label>
                            <textarea id="contactMessage" name="message" maxlength="500" required></textarea>
                        </div>
                        <div class="field field--full">
                            <label for="cPassword"><?= te('contact.form.password') ?></label>
                            <input type="password" id="cPassword" name="password" autocomplete="new-password">
                            <p class="field__hint"><?= te('contact.form.password_hint') ?></p>
                        </div>
                    </div>
                    <?php /* 스팸봇 방지 (2026-08-16 추가): 사람 눈엔 안 보이는 허니팟 필드 —
                             자동 입력 봇은 폼의 모든 필드를 채우는 경우가 많아서, 이 칸이
                             채워져 있으면 봇으로 간주하고 서버에서 조용히 무시한다
                             (actions/inquiry-submit.php 참고). 타임스탬프는 "폼이 열리고
                             몇 초 안 지나 바로 제출"되는 초고속 자동 제출을 걸러낸다. */ ?>
                    <div class="hp-field" aria-hidden="true">
                        <label for="cWebsite">Website</label>
                        <input type="text" id="cWebsite" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <input type="hidden" name="form_ts" value="<?= time() ?>">
                    <button type="submit" class="btn btn--primary" style="margin-top:10px;width:100%;justify-content:center;"><?= te('contact.form.submit') ?></button>
                    <p class="form-note"><?= te('contact.form.note') ?></p>
                </form>
            </div>
        </div>
    </section>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
