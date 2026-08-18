<?php
/**
 * 개인정보처리방침 / 이용약관 공통 렌더러 (2026-08-16 추가).
 * 두 페이지가 "제목 + 개정일 + (소제목 + 본문) 여러 개" 구조로 똑같아서 하나로 묶었다.
 *
 * 쓰는 법 (privacy/index.php, terms/index.php 참고):
 *   renderLegalPage('legal.privacy', 5);   // legal.privacy.title / .updated / .s1~.s5 를 읽는다
 *
 * 문구는 includes/lang.php의 $TRANSLATIONS['en'|'ko']에 'legal.privacy.*',
 * 'legal.terms.*' 키로 들어있다. 항목을 추가하려면 lang.php에 .s6.title/.s6.body를
 * 양쪽 언어로 넣고 이 함수 호출의 개수만 6으로 올리면 된다.
 *
 * 이 페이지들은 카드 상세 페이지와 달리 "한 화면에 맞추기"($isDetailFit)를 쓰지 않는다 —
 * 법적 고지문은 내용이 길고 앞으로 더 늘어날 수 있어서, 자연스럽게 스크롤되는 게 맞다.
 */
function renderLegalPage(string $keyPrefix, int $sectionCount): void
{
    // header.php/footer.php가 쓰는 전역 — 함수 안에서는 명시적으로 끌어와야 한다
    // (안 하면 상단 네비가 안 그려진다. includes/error-page.php의 같은 주석 참고).
    global $LANG, $NAV_SERVICES;

    $pageTitle = t($keyPrefix . '.title') . ' | DESIGN DAN';
    $pageDescription = t($keyPrefix . '.title');
    $activeNav = '';
    $isDetailPage = true;

    require __DIR__ . '/header.php';
    ?>
    <main>
    <section class="detail-hero">
        <div class="container">
            <a class="detail-back" href="<?= url('/') ?>"><?= te('answers.back_to_home') ?></a>
            <h1><?= te($keyPrefix . '.title') ?></h1>
            <p class="detail-hero__intro"><?= te($keyPrefix . '.updated') ?></p>
        </div>
    </section>

    <section class="section" style="padding-top:16px;">
        <div class="container" style="max-width:760px;">
            <?php for ($i = 1; $i <= $sectionCount; $i++): ?>
                <div class="card<?= $i % 2 === 0 ? ' card--cream' : '' ?>" style="margin-bottom:16px;">
                    <h3><?= te($keyPrefix . '.s' . $i . '.title') ?></h3>
                    <p style="margin-bottom:0;"><?= te($keyPrefix . '.s' . $i . '.body') ?></p>
                </div>
            <?php endfor; ?>

            <div class="detail-cta">
                <a class="btn btn--primary" href="<?= url('/') ?>#contact"><?= te('cta.contact') ?> →</a>
            </div>
        </div>
    </section>
    </main>
    <?php
    require __DIR__ . '/footer.php';
}
