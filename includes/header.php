<?php
// 이 파일을 불러오기 전에 각 페이지에서 다음 변수를 정의해야 합니다.
//   $pageTitle       (필수) 브라우저 탭 제목
//   $pageDescription (선택) meta description
//   $activeNav       (선택) includes/services.php 의 'slug' 값 — 상단 탭 강조용
//   $isHomeTabs      (선택, true/false) index.php에서만 true — true면 탭 클릭 시
//                     페이지 이동 없이 JS로 패널만 바꾼다. 다른 페이지에선 항상 false로 두면
//                     탭 클릭 시 "홈 + 해당 탭"으로 실제 이동한다.
//   $isDetailPage    (선택, true/false) 9개 상세페이지(architecture/design 등) +
//                     admin/answers 페이지에서 true — 다크 블루프린트 배경을 쓰도록
//                     <body class="page-detail">를 붙인다 (app.css의 body.page-detail 참고).
//   $isDetailFit     (선택, true/false, 2026-08-16 추가) 9개 카드 상세페이지에서만 true —
//                     admin/answers는 안 씀. true면 <body>에 "page-detail-fit"이 추가로 붙어서
//                     화면(뷰포트) 안에 풋터까지 스크롤 없이 들어오도록 세로 중앙 정렬 +
//                     여백 압축이 적용된다 (app.css의 body.page-detail-fit 참고, 홈 탭과
//                     같은 원리). admin/answers 페이지는 내용 길이가 가변적이라 이 압축을
//                     적용하지 않는다 — 그래서 $isDetailPage와 별도 플래그로 분리했다.
//   $isNoIndex       (선택, true/false, 2026-08-18 추가) 관리자 화면(admin/*)에서 true —
//                     검색엔진에 노출되지 않도록 <meta name="robots" content="noindex,nofollow">를
//                     넣는다. robots.txt에서도 /admin/ 을 막아뒀지만, robots.txt는 "크롤링
//                     하지 말라"는 요청일 뿐이고 어딘가에 링크가 걸리면 주소 자체는 색인될 수
//                     있어서 meta로 한 번 더 막는다.
$pageDescription = $pageDescription ?? t('home.title');
$isHomeTabs = $isHomeTabs ?? false;
$isDetailPage = $isDetailPage ?? false;
$isDetailFit = $isDetailFit ?? false;
$isNoIndex = $isNoIndex ?? false;

// 공유 미리보기(og:)·검색엔진용 값들 (2026-08-16 추가).
// $pageDescription 안에는 &amp; 같은 엔티티나 <strong> 태그가 들어있는 경우가 있어서
// (lang.php 주석 참고) 태그를 벗기고 엔티티를 되돌린 뒤에 다시 이스케이프해야
// 이중 인코딩(&amp;amp;)이 안 생긴다 — meta description과 같은 처리다.
$metaDescription = html_entity_decode(strip_tags($pageDescription), ENT_QUOTES, 'UTF-8');
// 절대 URL이 필요하다 (카카오톡·페이스북 등은 상대경로 이미지를 못 읽는다).
$siteScheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https' ? 'https' : 'http';
$siteHost = $_SERVER['HTTP_HOST'] ?? 'designs-dan.com';
$siteOrigin = $siteScheme . '://' . $siteHost;
$ogUrl = $siteOrigin . ($_SERVER['REQUEST_URI'] ?? '/');
// 페이지별 대표 이미지를 지정하고 싶으면 header.php를 부르기 전에 $ogImage에
// asset() 상대경로(예: 'images/architecture-design.jpg')를 넣으면 된다.
$ogImageUrl = $siteOrigin . asset($ogImage ?? 'images/about-main.jpg');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($LANG) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">
<?php if ($isNoIndex): ?>
<meta name="robots" content="noindex,nofollow">
<?php endif; ?>
<link rel="icon" type="image/svg+xml" href="<?= asset('images/favicon.svg') ?>">
<link rel="apple-touch-icon" href="<?= asset('images/favicon.svg') ?>">
<link rel="canonical" href="<?= htmlspecialchars($ogUrl) ?>">
<!-- 카카오톡·페이스북 등에 링크를 붙였을 때 제목/설명/이미지가 나오게 하는 태그들 -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="DESIGN DAN">
<meta property="og:locale" content="<?= $LANG === 'ko' ? 'ko_KR' : 'en_US' ?>">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
<meta property="og:description" content="<?= htmlspecialchars($metaDescription) ?>">
<meta property="og:url" content="<?= htmlspecialchars($ogUrl) ?>">
<meta property="og:image" content="<?= htmlspecialchars($ogImageUrl) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($metaDescription) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($ogImageUrl) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Fraunces:wght@400;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body<?= $isHomeTabs ? ' class="page-home"' : ($isDetailPage ? ' class="page-detail' . ($isDetailFit ? ' page-detail-fit' : '') . '"' : '') ?>>

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
            <a class="nav__lang" id="langToggle" href="<?= htmlspecialchars(langSwitchUrl(otherLang($LANG))) ?>" aria-label="Switch language"><?= icon('globe') ?> <?= htmlspecialchars(t('nav.lang_switch_label')) ?></a>
            <!-- 2026-08-14: 답변 게시판은 홈 탭(JS 패널)이 아니라 실제 페이지(/answers/)라서
                 $NAV_SERVICES 루프(왼쪽 탭 줄)에 안 넣는다. "문의하기 옆이 좋겠다"는 판단에 따라
                 오른쪽 문의하기 버튼 바로 옆에 둔다 (활성 표시는 $activeNav==='answers'로 판단). -->
            <a class="nav__link nav__answers-link<?= ($activeNav ?? '') === 'answers' ? ' nav__link--active' : '' ?>" href="<?= url('/answers/') ?>">
                <?= htmlspecialchars(t('nav.answers')) ?>
            </a>
            <a class="btn btn--primary btn--sm" data-tab="contact" href="<?= url('/') ?>#contact"><?= htmlspecialchars(t('nav.contact')) ?></a>
            <button type="button" class="nav__burger" id="navBurger" aria-label="메뉴 열기" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <div class="nav__mobile" id="navMobile">
        <a class="nav__mobile-lang" id="langToggleMobile" href="<?= htmlspecialchars(langSwitchUrl(otherLang($LANG))) ?>">
            <?= icon('globe') ?> <?= $LANG === 'ko' ? 'View in English' : '한국어로 보기' ?>
        </a>
        <?php foreach ($NAV_SERVICES as $service): ?>
            <a class="nav__mobile-link nav__tab<?= ($activeNav ?? '') === $service['slug'] ? ' nav__mobile-link--active' : '' ?>"
               data-tab="<?= htmlspecialchars($service['slug']) ?>"
               href="<?= url('/') ?>#<?= htmlspecialchars($service['slug']) ?>">
                <?= htmlspecialchars(t($service['label_key'])) ?>
            </a>
        <?php endforeach; ?>
        <a class="nav__mobile-link<?= ($activeNav ?? '') === 'answers' ? ' nav__mobile-link--active' : '' ?>" href="<?= url('/answers/') ?>">
            <?= htmlspecialchars(t('nav.answers')) ?>
        </a>
        <!-- 2026-08-14: 데스크톱에서 답변을 문의하기 버튼 옆에 두기로 한 김에, 모바일
             메뉴에도 문의하기 버튼을 답변 바로 아래에 추가했다 (원래 모바일 메뉴에는
             문의하기로 갈 방법이 아예 없었음 — .nav__actions .btn이 모바일에서 숨겨지기만
             하고 대체 링크가 없었던 빈틈). -->
        <a class="btn btn--primary" data-tab="contact" href="<?= url('/') ?>#contact" style="margin-top:14px;justify-content:center;">
            <?= htmlspecialchars(t('nav.contact')) ?>
        </a>
    </div>
</header>
