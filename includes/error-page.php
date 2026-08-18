<?php
/**
 * 사이트 디자인을 유지한 에러 안내 화면 (2026-08-16 추가).
 *
 * 이 프로젝트는 지금까지 예외 처리가 한 곳도 없어서, DB가 잠깐 끊기거나
 * 쿼리가 실패하면 방문자에게 흰 화면(또는 운영에서는 display_errors가 꺼져 있으니
 * 아무것도 없는 500 화면)이 그대로 보였다. 특히 문의 폼을 제출하던 고객은
 * "보낸 건지 안 보낸 건지" 알 수 없어서 가장 곤란한 케이스였다.
 *
 * 쓰는 법:
 *   require __DIR__ . '/../includes/error-page.php';
 *   renderErrorPage(503, 'error.db.title', 'error.db.desc');  // 그리고 exit
 *
 * 주의: 이 함수는 헤더/풋터를 직접 그리므로, 호출 전에 다른 output이 이미
 * 나가 있으면 안 된다(=페이지 렌더링 전 단계에서만 호출할 것).
 */
function renderErrorPage(int $httpStatus, string $titleKey, string $descKey): void
{
    // header.php/footer.php는 전역 $LANG(언어)과 $NAV_SERVICES(상단 탭 목록)를 쓴다.
    // 이 렌더러는 함수라서 전역이 자동으로 안 보이므로 명시적으로 끌어와야 한다 —
    // 안 하면 네비게이션이 안 그려지고 "Undefined variable $NAV_SERVICES" 경고가 뜬다
    // (2026-08-16, 실제로 이 버그를 화면 확인 중 발견해서 고쳤다).
    global $LANG, $NAV_SERVICES;

    if (!headers_sent()) {
        http_response_code($httpStatus);
    }

    $pageTitle = t($titleKey) . ' | DESIGN DAN';
    $pageDescription = t($descKey);
    $activeNav = '';
    $isDetailPage = true;
    $isDetailFit = true;

    require __DIR__ . '/header.php';
    ?>
    <main>
    <section class="section">
        <div class="container" style="max-width:560px;text-align:center;">
            <div class="card card--cream">
                <h1 style="font-family:var(--font-display);font-size:clamp(22px,2.6vh,30px);margin-bottom:10px;"><?= te($titleKey) ?></h1>
                <p style="color:var(--color-text-muted);margin-bottom:20px;"><?= te($descKey) ?></p>
                <a class="btn btn--primary" href="<?= url('/') ?>"><?= te('error.back_home') ?></a>
            </div>
        </div>
    </section>
    </main>
    <?php
    require __DIR__ . '/footer.php';
}

/**
 * DB 연결/쿼리 실패 시 공통 처리 — 로그에는 실제 원인을 남기고(운영에서는
 * docker/php-production.ini의 error_log 설정에 따라 stderr로 나가서 Render 로그에
 * 보인다), 방문자에게는 내부 정보를 노출하지 않는 안내만 보여준다.
 */
function renderDbErrorPage(Throwable $e): void
{
    error_log('[DESIGN DAN] DB error: ' . $e->getMessage());
    renderErrorPage(503, 'error.db.title', 'error.db.desc');
    exit;
}
