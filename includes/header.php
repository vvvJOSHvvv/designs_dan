<?php
// 이 파일을 불러오기 전에 각 페이지에서 다음 변수를 정의해야 합니다.
//   $pageTitle       (필수) 브라우저 탭 제목
//   $pageDescription (선택) meta description
//   $activeNav       (선택) includes/services.php 의 'slug' 값 — 상단 탭 강조용
//   $isHomeTabs      (선택, true/false) index.php에서만 true — true면 탭 클릭 시
//                     페이지 이동 없이 JS로 패널만 바꾼다. 다른 페이지에선 항상 false로 두면
//                     탭 클릭 시 "홈 + 해당 탭"으로 실제 이동한다.
$pageDescription = $pageDescription ?? t('home.title');
$isHomeTabs = $isHomeTabs ?? false;
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($LANG) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars(html_entity_decode(strip_tags($pageDescription), ENT_QUOTES, 'UTF-8')) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Fraunces:wght@400;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body<?= $isHomeTabs ? ' class="page-home"' : '' ?>>

<header class="nav" id="siteNav">
    <div class="nav__inner">
        <a class="nav__logo" href="<?= url('/') ?>">DESIGN DAN</a>

        <nav class="nav__menu nav__tabs" aria-label="주 메뉴">
            <?php foreach ($NAV_SERVICES as $service): ?>
                <a class="nav__link nav__tab<?= ($activeNav ?? '') === $service['slug'] ? ' nav__link--active' : '' ?>"
                   data-tab="<?= htmlspecialchars($service['slug']) ?>"
                   href="<?= url('/') ?>#<?= htmlspecialchars($service['slug']) ?>">
                    <?= htmlspecialchars(t($service['label_key'])) ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="nav__actions">
            <a class="nav__lang" id="langToggle" href="<?= htmlspecialchars(langSwitchUrl(otherLang($LANG))) ?>" aria-label="Switch language">🌐 <?= htmlspecialchars(t('nav.lang_switch_label')) ?></a>
            <a class="btn btn--primary btn--sm" data-tab="contact" href="<?= url('/') ?>#contact"><?= htmlspecialchars(t('nav.email_inquiry')) ?></a>
            <button type="button" class="nav__burger" id="navBurger" aria-label="메뉴 열기" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <div class="nav__mobile" id="navMobile">
        <a class="nav__mobile-lang" id="langToggleMobile" href="<?= htmlspecialchars(langSwitchUrl(otherLang($LANG))) ?>">
            🌐 <?= $LANG === 'ko' ? 'View in English' : '한국어로 보기' ?>
        </a>
        <?php foreach ($NAV_SERVICES as $service): ?>
            <a class="nav__mobile-link nav__tab<?= ($activeNav ?? '') === $service['slug'] ? ' nav__mobile-link--active' : '' ?>"
               data-tab="<?= htmlspecialchars($service['slug']) ?>"
               href="<?= url('/') ?>#<?= htmlspecialchars($service['slug']) ?>">
                <?= htmlspecialchars(t($service['label_key'])) ?>
            </a>
        <?php endforeach; ?>
    </div>
</header>
