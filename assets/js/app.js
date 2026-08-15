// DESIGN DAN — 공통 스크립트
// 1) 모바일 햄버거 메뉴 열고 닫기
// 2) 문의 폼 글자수 카운터(0/500) — 폼 자체는 actions/inquiry-submit.php로 실제 제출됨
//    (2026-08-14: 답변 게시판 추가하면서 진짜 저장되도록 바뀜, CLAUDE.md 참고)
// 3) 한/영 전환 버튼: 페이지 이동 시 지금 보고 있던 섹션(#anchor)을 그대로 유지
// 4) 홈 화면 탭 전환: 스크롤 없이 카드/섹션을 탭처럼 전환 (해시 기반, 뒤로가기 지원)

document.addEventListener('DOMContentLoaded', function () {
    var burger = document.getElementById('navBurger');
    var mobile = document.getElementById('navMobile');

    if (burger && mobile) {
        burger.addEventListener('click', function () {
            var isOpen = mobile.classList.toggle('is-open');
            burger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    var message = document.getElementById('contactMessage');
    var counter = document.getElementById('contactMessageCount');
    if (message && counter) {
        var max = message.getAttribute('maxlength') || 500;
        var update = function () { counter.textContent = message.value.length + '/' + max; };
        message.addEventListener('input', update);
        update();
    }

    // 2026-08-14: 문의 폼이 이제 실제로 서버(actions/inquiry-submit.php)에 저장되므로
    // JS로 submit을 막고 alert만 띄우던 예전 방식은 제거했다. 폼은 그냥 평범하게
    // 제출되고(action="/actions/inquiry-submit.php"), 서버가 처리 후 답변 게시판의
    // 방금 쓴 글로 리다이렉트한다.

    // 언어 전환 링크는 서버에서 경로+?lang= 까지만 만들어주므로,
    // 지금 스크롤 중인 섹션(#about, #contact 등)이 있으면 여기서 그대로 붙여준다.
    ['langToggle', 'langToggleMobile'].forEach(function (id) {
        var link = document.getElementById(id);
        if (!link) return;
        link.addEventListener('click', function (e) {
            if (window.location.hash) {
                e.preventDefault();
                window.location.href = link.getAttribute('href') + window.location.hash;
            }
        });
    });

    // ---- 탭 전환 로직 (홈 화면 전용, 카드형 페이지) ----
    // body에 page-home 클래스가 있을 때만 동작한다 (detail 페이지 등에는 영향 없음).
    if (document.body.classList.contains('page-home')) {
        var panels = Array.prototype.slice.call(document.querySelectorAll('.panel[data-panel]'));
        var tabLinks = Array.prototype.slice.call(document.querySelectorAll('[data-tab]'));
        var defaultTab = 'about';
        var validTabs = panels.map(function (p) { return p.getAttribute('data-panel'); });

        var activateTab = function (slug, opts) {
            opts = opts || {};
            if (validTabs.indexOf(slug) === -1) slug = defaultTab;

            panels.forEach(function (p) {
                p.classList.toggle('is-active', p.getAttribute('data-panel') === slug);
            });

            tabLinks.forEach(function (link) {
                var isActive = link.getAttribute('data-tab') === slug;
                if (link.classList.contains('nav__link')) {
                    link.classList.toggle('nav__link--active', isActive);
                }
                if (link.classList.contains('nav__mobile-link')) {
                    link.classList.toggle('nav__mobile-link--active', isActive);
                }
            });

            if (!opts.skipScroll) {
                window.scrollTo({ top: 0, behavior: 'auto' });
            }

            // 모바일 메뉴가 열려 있으면 탭 클릭 시 자동으로 닫아준다.
            if (mobile && mobile.classList.contains('is-open')) {
                mobile.classList.remove('is-open');
                if (burger) burger.setAttribute('aria-expanded', 'false');
            }
        };

        tabLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                var slug = link.getAttribute('data-tab');
                if (!slug || validTabs.indexOf(slug) === -1) return; // 알 수 없는 탭이면 기본 링크 동작 유지
                e.preventDefault();
                if (window.location.hash !== '#' + slug) {
                    window.location.hash = slug; // hashchange 이벤트가 activateTab을 호출한다
                } else {
                    activateTab(slug);
                }
            });
        });

        window.addEventListener('hashchange', function () {
            var slug = window.location.hash.replace('#', '');
            activateTab(slug || defaultTab);
        });

        // 페이지 처음 열렸을 때: 주소의 해시를 보고 해당 탭을 활성화한다 (없으면 기본 탭 = about).
        var initialSlug = window.location.hash.replace('#', '');
        activateTab(initialSlug || defaultTab, { skipScroll: true });
    }
});
