<?php

/**
 * 사이트 구조 데이터 (탭 + 카드 방식, 2026-08-12 개편)
 *
 * pdcebu처럼 "스크롤을 내리는 긴 페이지"가 아니라, 상단 탭을 눌러 카드 목록이
 * 바로 바뀌는 방식으로 바꿨습니다. 홈(index.php)에 5개 패널이 전부 들어있고,
 * 탭을 누르면 JS가 그 중 하나만 보여줍니다 (페이지 이동 없음).
 *
 * 'items'가 있는 탭(건축/디자인/솔루션)은 카드 그리드로 하위 항목을 보여주고,
 * 카드를 클릭하면 'href'의 별도 상세 페이지로 이동합니다.
 * 'items'가 없는 탭(회사소개/문의하기)은 그 자체가 하나의 패널 콘텐츠입니다.
 *
 * 새 카테고리/상세 페이지를 추가하려면:
 *   1. 아래 배열에 항목 추가 (slug, label_key, teaser_key, icon, href)
 *   2. includes/lang.php 에 label_key/teaser_key 번역 추가 (en/ko 둘 다)
 *   3. href 경로에 실제 폴더+index.php 생성
 *
 * 'photo' (선택) — 카드 위쪽에 넣을 실사진 경로 (asset() 함수에 넘길 상대경로,
 * 예: 'images/architecture-design.jpg'). 없으면 예전처럼 이모지 아이콘만 나온다.
 * 예: 솔루션 > 어플(apps) 카테고리에 그룹통화를 추가할 때도 이 패턴을 따르면 됩니다
 * (자세한 예시는 CLAUDE.md의 "어플 카테고리에 새 앱 추가하기" 참고).
 */

$NAV_SERVICES = [
    [
        'slug'      => 'about',
        'label_key' => 'nav.about',
        'items'     => [],
    ],
    [
        'slug'      => 'architecture',
        'label_key' => 'nav.architecture',
        'items'     => [
            ['slug' => 'design',         'label_key' => 'card.architecture.design.title',        'teaser_key' => 'card.architecture.design.teaser',        'icon' => '📐', 'href' => '/architecture/design/',        'photo' => 'images/architecture-design.jpg'],
            ['slug' => 'aerial-survey',  'label_key' => 'card.architecture.aerial.title',         'teaser_key' => 'card.architecture.aerial.teaser',        'icon' => '🛰️', 'href' => '/architecture/aerial-survey/', 'photo' => 'images/architecture-survey.jpg'],
            ['slug' => 'construction',   'label_key' => 'card.architecture.construction.title',   'teaser_key' => 'card.architecture.construction.teaser',  'icon' => '🏗️', 'href' => '/architecture/construction/',  'photo' => 'images/architecture-construction.jpg'],
        ],
    ],
    [
        'slug'      => 'design',
        'label_key' => 'nav.design',
        'items'     => [
            ['slug' => 'graphic', 'label_key' => 'card.design.graphic.title', 'teaser_key' => 'card.design.graphic.teaser', 'icon' => '🎨', 'href' => '/design/graphic/', 'photo' => 'images/design-graphic-card.jpg'],
            ['slug' => 'video',   'label_key' => 'card.design.video.title',   'teaser_key' => 'card.design.video.teaser',   'icon' => '🎬', 'href' => '/design/video/',   'photo' => 'images/design-video-card.jpg'],
        ],
    ],
    [
        'slug'      => 'solutions',
        'label_key' => 'nav.solutions',
        'items'     => [
            ['slug' => 'consulting', 'label_key' => 'card.solutions.consulting.title', 'teaser_key' => 'card.solutions.consulting.teaser', 'icon' => '💼', 'href' => '/solutions/consulting/', 'photo' => 'images/solutions-consulting.jpg'],
            ['slug' => 'automation', 'label_key' => 'card.solutions.automation.title', 'teaser_key' => 'card.solutions.automation.teaser', 'icon' => '⚙️', 'href' => '/solutions/automation/', 'photo' => 'images/solutions-automation.jpg'],
            ['slug' => 'website',    'label_key' => 'card.solutions.website.title',    'teaser_key' => 'card.solutions.website.teaser',    'icon' => '🖥️', 'href' => '/solutions/website/',    'photo' => 'images/solutions-website.jpg'],
            ['slug' => 'apps',       'label_key' => 'card.solutions.apps.title',       'teaser_key' => 'card.solutions.apps.teaser',       'icon' => '📱', 'href' => '/solutions/apps/',       'photo' => 'images/solutions-apps.jpg'],
        ],
    ],
    [
        'slug'      => 'resources',
        'label_key' => 'nav.resources',
        'items'     => [],
    ],
];

/**
 * 2026-08-14: "문의하기"를 상단 탭 목록에서 뺐다 (오른쪽 "문의하기" 버튼과 중복돼서).
 * 실제 #contact 패널(index.php)과 findNavTab('contact') 호출은 그대로 남아있으니,
 * data-tab="contact" 링크(예: 각 상세페이지의 "Get in Touch" 버튼)는 계속 정상 동작한다 —
 * 탭 전환 JS(app.js)가 이 배열이 아니라 실제 .panel[data-panel] 요소를 기준으로 동작하기 때문.
 */

/** slug 로 상위 탭 데이터를 찾습니다 (상세 페이지의 "뒤로가기" 링크 만들 때 사용) */
function findNavTab(string $slug): ?array
{
    global $NAV_SERVICES;
    foreach ($NAV_SERVICES as $tab) {
        if ($tab['slug'] === $slug) {
            return $tab;
        }
    }
    return null;
}
