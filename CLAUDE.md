# Design_dan (designs-dan.com 새 버전)

기존에 **Readdy**(노코드 AI 웹사이트 빌더)로 만들었던 `https://designs-dan.com`을
직접 코딩해서 새로 만드는 프로젝트입니다.

**2026-08-12 (오전): 1단계로 기존 사이트 내용을 최대한 그대로 옮겨왔다.**
디자인/카테고리 구조를 새로 짜기 전에, 먼저 기존 사이트(Readdy 버전)를 실제로 열어서
텍스트 전체·메뉴 구조·톤을 그대로 복제하는 걸 우선순위로 했다.

**2026-08-12 (오후): 구조를 완전히 새로 짰다 — 스크롤 없는 탭+카드 방식.**
사용자가 "pdcebu처럼 스크롤 없이 카드 방식으로" + "카테고리를 5개(회사소개/건축/
디자인/솔루션/문의하기)로 간단하게" 요청해서, 아래 "탭+카드 구조" 섹션에 설명된
완전히 새로운 구조로 다시 만들었다. **이전 버전(드롭다운 네비 + 스크롤 페이지)은
폐기되었다** — 이 문서의 "탭+카드 구조" 이후 내용이 현재 실제 상태다.

앱 포트폴리오 섹션("여러 앱을 카테고리별로 소개하는 창구")은 새 구조에서
`솔루션 → 어플`(`/solutions/apps/`) 자리로 확정되었고, 지금은 앱이 하나도 없는
빈 상태다. 사용자의 "그룹통화" 앱(Node.js, Render에 별도 호스팅 예정)이 여기 들어갈
첫 앱이다. **추가하는 방법은 아래 "새 앱 추가하는 법" 섹션 참고.**

**PHP, 프레임워크 없음.** pdcebu 프로젝트(`../pdcebu`)와 동일한 컨벤션을 그대로 따랐다
(사용자가 "pdcebu랑 똑같은 방식으로" 진행해달라고 요청함). 다만 이 사이트는 지금 단계에서
DB가 필요 없는 정적 마케팅 콘텐츠라서 **DB 연결(config.php의 db.php require)은 넣지 않았다.**

**2026-08-16: "세로 스크롤 원페이지"로 잠깐 바꿨다가 같은 날 바로 되돌림.** 사용자가
"전체 사이트를 스크롤 없이 한 번에 보고 싶다"고 해서 5개 패널을 전부 항상 보이는 세로
스크롤 원페이지로 바꿨는데, 사용자가 다시 "그게 아니라 지금처럼 탭 하나 = 화면 하나
(풋터까지 스크롤 없이 딱 맞는) 방식을 유지한 채로 스크롤 자체를 없애고 싶었다"고
정정함 — 즉 처음 요청은 "링크 하나로 전체를 다 보여주고 싶다"는 의미였는데, 실제로는
"탭+카드 구조(아래 섹션)의 스크롤 없는 화면 자체가 유지되길 원한다"는 뜻이었다.
**결론: 로컬 git으로 그 커밋을 revert해서 원래 탭+카드 구조로 완전히 되돌렸다** — 이
문서의 "탭+카드 구조" 이후 내용이 지금도 여전히 현재 실제 상태다(안 바뀜). **앞으로
"한 번에 다 보여주고 싶다" 류의 요청이 다시 나오면, 먼저 "탭을 계속 눌러야 하는 게
싫다는 뜻인지 vs 각 탭이 스크롤 없이 한 화면에 딱 맞는 지금 방식은 유지하고 싶은지"부터
명확히 확인할 것 — 이번에 이 구분이 안 돼서 한 번 왔다갔다했다.**

---

## 탭+카드 구조 (2026-08-12 오후 개편)

기존에는 위아래로 스크롤하는 긴 홈페이지 하나 + 드롭다운 네비였다. 지금은 다르다:

- **상단 탭 5개**: 회사 소개(About) / 건축(Architecture) / 디자인(Design) /
  솔루션(Solutions) / 문의하기(Contact). 이 5개가 전부다 — 드롭다운 없음.
- **홈페이지(`index.php`) 안에 5개의 "패널"이 전부 들어있다.** 탭을 클릭하면
  페이지 이동 없이(스크롤도 없이) 그 패널만 보이고 나머지는 숨겨진다. 주소창에는
  `http://localhost:8080/#architecture` 처럼 해시가 붙어서, 새로고침하거나
  링크를 공유해도 같은 탭이 열린다.
- **건축/디자인/솔루션 탭 안에는 카드가 있다.** 이 카드들은 하위 항목이다:
  - 건축: 설계(Design) / 항공측량(Aerial Survey) / 시공(Construction)
  - 디자인: 그래픽 & 상업(Graphic) / 영상(Video)
  - 솔루션: 컨설팅(Consulting) / 업무자동화(Automation) / 홈페이지(Website) / 어플(Apps)
- **카드를 클릭하면 별도의 상세 페이지로 이동한다** (패널 안에서 펼쳐지는 게 아니라
  진짜 페이지 이동, 예: `/architecture/design/`). 사용자가 명확히 "클릭하면 별도
  상세 페이지로 이동"을 선택함.
- 회사 소개, 문의하기 패널은 하위 카드 없이 그 안에 내용이 바로 들어있다.

### 이 구조가 동작하는 원리 (한 줄 요약: 서버는 그대로 다 그려주고, JS가 숨김/보임만 담당)

1. `index.php`가 5개 `<section class="panel" data-panel="회사소개/architecture/...">`를
   **전부 다 서버에서 렌더링**한다. 자바스크립트가 꺼져 있어도 (JS 없이) 전체 내용을
   다 볼 수 있다는 뜻 — 검색엔진이나 접근성에도 유리하다.
2. 서버는 기본적으로 `about` 패널에만 `is-active` 클래스를 붙여서 보낸다.
3. `assets/js/app.js`가 페이지 로딩 시 주소의 해시(`#architecture` 등)를 읽어서
   해당하는 패널에 `is-active`를 옮겨 붙인다. CSS는 `.panel { display:none; }` /
   `.panel.is-active { display:block; }` 로 딱 하나만 보이게 한다 (`assets/css/app.css`
   `.panel` 규칙 참고).
4. 탭(`[data-tab]` 속성이 붙은 링크, 상단 네비 + 모바일 메뉴)을 클릭하면 페이지를
   새로 불러오지 않고, JS가 `window.location.hash`만 바꾼다 → `hashchange` 이벤트가
   `activateTab()`을 호출해서 패널을 바꾼다.

## 폴더 구조

```
Design_dan/
├── index.php                       홈페이지 = 5개 패널(회사소개/건축/디자인/솔루션/문의하기)
├── config.php                      BASE_URL 계산 + asset()/url() 헬퍼 + lang.php/services.php 로드
├── architecture/
│   ├── design/index.php            상세 페이지: 건축 → 설계
│   ├── aerial-survey/index.php     상세 페이지: 건축 → 항공측량
│   └── construction/index.php      상세 페이지: 건축 → 시공
├── design/
│   ├── graphic/index.php           상세 페이지: 디자인 → 그래픽 & 상업
│   └── video/index.php             상세 페이지: 디자인 → 영상
├── solutions/
│   ├── consulting/index.php        상세 페이지: 솔루션 → 컨설팅
│   ├── automation/index.php        상세 페이지: 솔루션 → 업무자동화
│   ├── website/index.php           상세 페이지: 솔루션 → 홈페이지
│   └── apps/index.php              상세 페이지: 솔루션 → 어플 (★ 새 앱은 여기에 추가)
├── graphic-design/
│   └── index.php                   예전 주소(`/graphic-design/`) → `/design/graphic/`로 301 리다이렉트
├── includes/
│   ├── services.php                $NAV_SERVICES = 탭 5개 + 각 탭의 하위 카드 배열, findNavTab() 헬퍼
│   ├── lang.php                    번역 엔진 (아래 "한/영 전환" 참고)
│   ├── header.php                  <head> + 상단 탭 네비 + 모바일 햄버거 메뉴
│   ├── footer.php                  하단 푸터
│   └── detail-hero.php             상세 페이지 공통 부품 (뒤로가기 링크 + 아이콘 + 제목 + 소개문)
└── assets/
    ├── css/app.css                 전체 스타일 (BEM, :root 색상 변수, .panel/.service-card/.card-grid--3 등)
    ├── js/app.js                   모바일 메뉴 + 문의폼 카운터/제출 + 탭 전환 로직 + 언어전환 해시 유지
    └── images/                     (비어있음)
```

## 상세 페이지를 새로 만들 때 (9개 페이지가 이미 이 패턴)

상세 페이지는 `Design_dan/` 기준 **2단계 아래**(`architecture/design/index.php`처럼)에
있으므로 `require` 경로가 홈페이지와 다르다:

```php
<?php
require __DIR__ . '/../../config.php';              // 2단계 위로
$pageTitle = t('card.architecture.design.title') . ' | DESIGN DAN';
$pageDescription = t('...');
$activeNav = 'architecture';                          // 상위 탭 slug (뒤로가기 링크에 쓰임)
$isDetailPage = true;                                 // 다크 블루프린트 배경
$isDetailFit = true;                                  // 스크롤 없이 한 화면에 맞추기 (아래 섹션 참고)
require __DIR__ . '/../../includes/header.php';

$detailParentSlug = 'architecture';                   // findNavTab()으로 상위 탭 라벨 찾을 때 씀
$detailTitleKey   = 'card.architecture.design.title';
$detailIntroKey   = 'detail.architecture.design.intro'; // 없으면 생략 가능
$detailIcon       = 'ruler';                          // includes/icons.php의 $ICON_PATHS 키, 없으면 생략 가능
?>
<main>
<?php require __DIR__ . '/../../includes/detail-hero.php'; ?>
<section class="section">
    <div class="container">
        <!-- 카드 그리드(.card-grid.card-grid--3), 프로세스 등 자유롭게 -->
        <div class="detail-cta">
            <a class="btn btn--primary" href="<?= url('/') ?>#contact"><?= te('cta.contact') ?> →</a>
        </div>
    </div>
</section>
</main>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
```

## 카드 상세 페이지도 스크롤 없이 한 화면에 맞추기 (2026-08-16 추가)

사용자가 "건축>설계 같은 상세 페이지에 들어가면 스크롤해야 나머지가 보인다,
여기도 홈 탭처럼 스크롤 없이 보고 싶다"고 요청 — 9개 카드 상세 페이지 전부
1440×900 기준으로 풋터까지 스크롤 없이 한 화면에 들어오도록 압축했다.

- **`$isDetailFit = true;`** — 새 변수. `$isDetailPage = true;` 바로 아래 추가하면
  된다(위 코드 예시 참고). `includes/header.php`가 이 값을 보고 `<body>`에
  `page-detail-fit` 클래스를 추가로 붙인다.
- **admin/answers 페이지는 이 플래그를 안 쓴다** — 문의 개수·답변 길이가 페이지마다
  달라서 "한 화면에 압축"이 오히려 어색하다. 그래서 기존 `$isDetailPage`와
  분리된 새 플래그로 만들었다 — `$isDetailPage`(다크 배경)와
  `$isDetailFit`(스크롤 없이 압축) 둘 다 true인 페이지 = 9개 카드 상세 페이지만.
- **압축 규칙은 전부 `app.css`의 `.page-detail-fit ...` 선택자 안에 있다**
  (`.detail-hero`, `.section`, `.card`, `.process`, `.consulting-grid`,
  `.gd-steps`, `.automation`, `.footer` 등 — 홈 탭/admin/answers의 같은 클래스는
  전혀 영향 없음, 항상 body에 `page-detail-fit` 클래스가 있을 때만 적용됨).
  홈 탭과 똑같이 vh 기준 `clamp()`를 많이 써서 화면 높이에 맞춰 자동으로
  반응한다. 세로 중앙 정렬(`body.page-detail-fit main { justify-content:center }`)도
  홈 탭과 같은 원리 — 내용이 짧은 페이지는 화면 가운데 예쁘게 뜬다.
- **컨설팅(카드 6개+4단계 프로세스)이 가장 무거운 페이지였다** — 처음엔 1364px로
  풋터가 한참 넘어갔다. 카드 6개를 3×2(두 줄) 대신 **화면이 넓을 때(901px 이상)만
  한 줄(6칸)**로 펼치도록 바꾼 게 제일 크게 도움이 됐다(`@media (min-width:901px)`로
  감쌌다 — 안 감싸면 모바일에서도 6열로 찌그러지는 버그가 생긴다, 실제로 한 번
  겪었다). 그래도 영어 버전은 설명문이 길어서 896px에 딱 맞을 때까지 카드
  폰트·패딩·풋터 여백을 여러 차례 추가로 줄여야 했다 — 이 페이지에 새 카드/문구를
  추가할 계획이면 다시 넘칠 수 있으니 주의.
- **디자인 상세(2개 섹션)**: `.section` 두 개가 연달아 나오면 위아래 padding이
  겹쳐 쌓이므로, `.page-detail-fit .section + .section { padding-top: 0; }`로
  두 번째 섹션의 위쪽 padding을 뺐다. 새로 섹션을 여러 개 이어붙이는 페이지를
  만들 때도 이 규칙이 자동으로 적용된다.
- **검증**: 9개 페이지 × 한/영 2개 언어 = 18개 조합을 로컬에서 iframe으로 실제
  렌더링해서 `document.documentElement.scrollHeight`를 1440×900 기준으로 전부
  측정 확인(모두 896px, 스크롤 불필요). 데스크톱(1440px)·태블릿(800px)·
  모바일(375px) 스크린샷으로 반응형 단계별 카드 열 수도 확인했다. 태블릿/모바일은
  화면 자체가 짧아서 "스크롤 없음" 목표가 원래부터 해당 안 됨(홈 탭과 동일한
  전제) — 자연스럽게 위→아래로 스크롤된다.
- **사진 배너가 너무 얇았던 문제 (2026-08-16, 같은 날 바로 수정)**: 처음 압축할 때
  `.detail-hero__photo img`를 `clamp(60px, 7.5vh, 120px)`로 잡았는데, 사용자가
  실제 화면 스크린샷을 보내서 "건축>항공측량 상세 페이지 사진이 거의 안 보이고
  위아래로 빈 공간만 몰려있다"고 지적했다. 원인: 사진이 있는 3개 페이지(건축>설계
  /항공측량/시공)는 카드가 2~3개뿐이라 900px 안에서 원래 꽤 여유가 있었는데
  (900px에서 위아래 빈 공간이 각각 100~200px 정도 남았었다), 그 여유를 세로 중앙
  정렬이 그냥 빈 공간으로만 소비하고 사진 자체는 작은 값(7.5vh)에 묶여있어서
  "내용이 화면 가운데 작게 떠 있고 사진만 얇은 띠처럼 잘려 보이는" 상태였다.
  `clamp(120px, 24vh, 320px)`로 키워서(900px 기준 68px → 216px) 이 여유 공간을
  사진이 실제로 채우게 만들었다 — 9개 페이지 전부 다시 측정해서 여전히 896px에
  맞는 것 확인, 1680×1150 같은 더 큰 화면에서도 비율 맞게 커지는 것 확인.
  **사진이 있는 페이지에 카드나 문구를 더 추가하게 되면** 이 여유 공간이 줄어들
  수 있으니, 그때는 사진 높이를 다시 줄여야 할 수도 있다는 점 기억할 것.
- **★ 전체를 vh 기준으로 다시 잡음 (2026-08-16 3차, 현재 상태)**: 사용자가 컨설팅
  페이지 스크린샷을 보내며 "너무 답답해 보인다"고 지적. 원인은 1차 압축 값이 대부분
  **고정 px**이었다는 점이다 — 900px 화면에 맞추려고 작게 잡은 값이 1150px 같은 큰
  화면에서도 그대로 작게 남아서, "글씨는 깨알같은데 위아래 빈 공간은 400px 넘게
  남는" 화면이 됐다. 그래서 **거의 모든 값을 `clamp(최소, N vh, 최대)` 형태로 교체**했다:
  - **계수(N) 정하는 법**: 900px 화면에서 1vh = 9px이므로, **"900px에서 딱 맞던
    기존 픽셀값 ÷ 9"**를 계수로 쓴다. 이러면 900px에서는 지금까지처럼 정확히 맞고,
    화면이 커지면 그만큼 자연스럽게 커진다. (한 번은 계수까지 같이 키웠다가 9개
    페이지 중 6개가 900px에서 넘쳐버려서 되돌렸다 — **계수는 그대로, 최대값만
    여는 것**이 핵심이다.)
  - **풋터를 특히 조심할 것**: 메뉴 항목이 6개라 글자 크기·줄간격을 조금만 키워도
    풋터 전체가 크게 불어난다 — 실제로 2차 수정 때 풋터만 165px → 236px로 늘어나
    컨설팅/그래픽 영어 버전이 딱 그만큼 넘쳤다. 원인 찾는 데 시간이 걸렸으니,
    앞으로 상세 페이지가 넘치면 **풋터 높이부터 재볼 것**.
  - **컨설팅은 6칸 한 줄 유지**: 3칸 2줄로 바꿔봤지만 900px에서 300px 넘게, 1150px
    에서도 영어 기준 90px 넘게 초과해서 도저히 안 들어간다(카드 줄이 하나 더 생기는
    셈이라 근본적으로 무리). 대신 카드 안쪽 글자·여백이 화면 높이에 따라 커지도록
    해서 큰 화면에서는 훨씬 덜 답답해졌다.
  - **검증**: 9개 페이지 × 한/영 × (1440×900, 1680×1150) = 36개 조합 전부 iframe
    실측으로 초과 0건 확인. 1280×800(작은 노트북)도 한국어 전 페이지 통과.
    영어 컨설팅만 800px 화면에서는 조금 넘치는데, 이건 영어 문장이 길어서 생기는
    한계라 더 줄이면 글씨가 다시 깨알같아진다 — 여기서 멈췄다.
- **나중에 상세 페이지 내용을 더 추가하고 싶으면**: 카드/단계를 늘리기 전에
  1440×900에서 실제로 넘치는지부터 확인할 것 — 이미 여백이 꽤 타이트하게
  잡혀있어서 추가 압축 여지가 많지 않다. 정말 안 들어가면 컨설팅처럼
  `grid-template-columns`를 늘려서 한 줄로 펼치는 방법부터 시도해볼 것
  (패딩/글자를 더 줄이는 것보다 가독성에 유리하다).

## 새 앱 추가하는 법 (★ "그룹통화" 앱을 위한 자리)

`solutions/apps/index.php` 안에 있는 `$apps = [];` 배열이 이 사이트에 배포된 앱
목록이다. 지금은 비어 있어서 "첫 번째 앱을 준비 중입니다" 안내 문구만 보인다.

**앱이 하나라도 생기면 (예: 그룹통화가 Render에 올라가면) 이렇게 하면 끝이다:**

```php
$apps = [];
$apps[] = [
    'icon'    => '🎙️',                             // 카드에 보일 이모지 아이콘
    'name_en' => 'Group Call',                       // 영어 이름
    'name_ko' => '그룹통화',                          // 한글 이름
    'desc_en' => 'Voice group calling app.',          // 영어 한 줄 설명
    'desc_ko' => '음성 그룹 통화 앱입니다.',            // 한글 한 줄 설명
    'url'     => 'https://group-call.onrender.com',   // Render에 배포된 실제 주소
    'status'  => 'live',                              // 'live' = 바로 실행 가능, 'soon' = 준비중 배지만 표시
];
```

배열에 항목이 하나라도 있으면 빈 상태 안내 대신 자동으로 카드 그리드가 나타난다.
`status: 'live'`인 카드는 클릭하면 `url`을 새 탭으로 연다. `status: 'soon'`이면
클릭이 안 되고 "준비중" 배지만 뜬다 (미리 카드를 만들어두고 싶을 때 유용).

`app이름.designs-dan.com` 같은 서브도메인 연결은 이 코드와 무관한 **DNS 작업**이다
(도메인 등록처 확인부터 필요, 아직 미확인 상태 — 아래 "남은 것" 참고).

## 공통 규칙 (pdcebu와 동일)

- **경로는 항상 `url()`/`asset()`을 통한다.** 절대경로를 직접 쓰지 말 것 — 하위
  폴더로 배포하면 깨진다.
- **정적 파일은 `asset()`을 통한다.** 파일 수정시각이 `?v=`로 붙어 캐시가 자동 갱신된다.
- CSS 클래스는 BEM(`블록__요소--상태`)을 쓴다. 색·간격은 `app.css` 맨 위 `:root`
  변수를 쓰고 새 색을 즉흥적으로 만들지 않는다.
- 사용자 입력값을 출력할 땐 `htmlspecialchars()`를 거친다.

## 네비게이션 = includes/services.php

`$NAV_SERVICES` 배열 하나가 탭 5개 + 각 탭의 하위 카드를 전부 정의한다. 탭 순서나
카드 순서를 바꾸고 싶으면 이 배열의 순서만 바꾸면 된다 (다른 파일 수정 불필요 —
`index.php`, `header.php`, `footer.php` 모두 이 배열을 loop로 읽어서 그린다).

`findNavTab($slug)` 헬퍼로 특정 탭의 데이터(라벨, 하위 카드 목록)를 어디서든
가져올 수 있다 — 홈페이지 카드 grid, 상세 페이지의 "상위 카테고리로 돌아가기"
링크 둘 다 이걸 쓴다.

## 한/영 전환

기존 사이트에 언어 토글 버튼(🌐 KO)이 있었지만 실제로는 눌러도 아무 일도 안 일어났다
(라벨만 "KO"로 고정되어 있었음). 이번에 실제로 동작하게 만들었다.

- **`includes/lang.php`**: 이 프로젝트의 번역 엔진. 주소 끝에 `?lang=ko` 또는 `?lang=en`을
  붙이면 그 언어로 렌더링하고, 쿠키(`site_lang`)에 저장해서 다음 페이지 이동 시에도
  유지된다. 아무 것도 없으면 기본값은 **영어**(`SITE_DEFAULT_LANG`).
  - `t('키')` — 현재 언어의 문구를 문자열로 반환 (없으면 영어로, 그것도 없으면 키 자체).
  - `te('키')` — `<?= te('키') ?>` 형태로 템플릿에서 바로 쓰는 별칭. `t()`와 동일.
  - `langSwitchUrl($targetLang)` / `otherLang($lang)` — 토글 버튼 링크 생성용.
  - 모든 문구는 `$TRANSLATIONS['en'][...]`, `$TRANSLATIONS['ko'][...]` 양쪽에 같은 키로
    들어있다. **새 문구를 추가할 땐 반드시 양쪽 다 채울 것.**
  - **주의**: 번역 문구 안에 `&amp;` 같은 HTML 엔티티나 `<strong>` 태그가 그대로 들어있는
    경우가 있다 (`te()` 출력은 추가로 이스케이프하지 않고 템플릿에 바로 꽂기 때문). 이
    문구를 `<meta>` 태그처럼 `htmlspecialchars()`로 다시 감싸야 하는 곳에서는 먼저
    `html_entity_decode(..., ENT_QUOTES, 'UTF-8')`을 거쳐야 이중 인코딩(`&amp;amp;`)이
    안 생긴다 (`header.php`의 `$pageDescription` 처리 참고).
- 헤더의 언어 토글은 **데스크톱**(`#langToggle`)과 **모바일**(`#langToggleMobile`)
  둘 다 있다. 버튼에는 항상 **지금 언어가 아니라 전환될 언어**가 표시된다.
- `app.js`가 토글 클릭 시 지금 보고 있던 탭(`#architecture` 등 해시)을 유지해서
  이동시킨다 — 언어를 바꿔도 보고 있던 탭이 안 바뀐다.
- 한글 버전에서는 제목이 단어 중간에서 줄바꿈되지 않도록 `word-break: keep-all`을
  `html[lang="ko"]`에만 적용했다.

## 풋터 크기 축소 + 짧은 페이지에서도 풋터가 화면 아래에 붙게 (2026-08-12 추가)

- `body`를 세로 flex 컨테이너(`display:flex; flex-direction:column; min-height:100%`)로
  만들고 `<main>`에 `flex:1 0 auto`를 줘서, 내용이 짧은 탭/페이지여도 풋터가 항상 화면
  맨 아래에 붙는다 (예전엔 흰 여백이 풋터 밑에 남았음). 새 페이지를 만들 때도 반드시
  `<main>`으로 본문을 감싸야 이 레이아웃이 정상 작동한다 (기존 9개 상세페이지, 홈 전부
  이미 이렇게 되어 있음).
- 풋터의 위아래 여백·줄간격을 기존의 약 2/3 크기로 줄였다 (`.footer` 관련 CSS 참고).

## 홈 화면 전체를 잇는 다크 배경 + 세리프 제목 폰트 (2026-08-12 추가, 이후 이음새 없이 통합)

- **배경**: 실제 사진이 없는 상태라, 건축 설계 회사에 어울리는 **다크 배경 + 금색
  블루프린트(설계도면) 라인아트**를 만들었다. 순수 CSS/SVG로 직접 그린 것이라 저작권
  문제 없음 (`assets/images/blueprint-building.svg` = 건물 실루엣+치수선+컴퍼스 모티프,
  `assets/images/blueprint-grid.svg` = 반복되는 옅은 격자 패턴).
  - **처음엔 탭(패널)마다 따로 배경을 그렸다가, 탭↔풋터 경계에서 색이 살짝 끊겨 보인다는
    피드백을 받고 구조를 바꿨다.** 지금은 배경 전체가 `body.page-home` 단 한 곳에만
    있고 (`background-attachment: fixed`로 화면 기준 고정), `.panel--brand-bg`와
    `body.page-home .footer`, `body.page-home main`은 전부 배경을 비워서(`transparent`)
    이 body 배경이 네비게이션바→탭 내용→풋터까지 하나로 그대로 비쳐 보이게 만들었다.
    덕분에 탭을 넘기거나 풋터로 스크롤해도 이음새가 전혀 안 보인다.
  - **다른 사진으로 바꾸고 싶으면**: `body.page-home`의 `background-image` 첫 번째
    그라디언트 레이어 뒤에 실제 사진을 깔거나, `.about__media`의 `.media-placeholder`를
    `<img>`로 바꾸면 된다.
  - 패턴이 너무 흐리거나 진하면 두 SVG 파일 안의 `stroke-opacity` 숫자만 조절하면 됨
    (낮을수록 흐려짐).
  - **주의(중요) — 배경을 다시 손댈 때 순서를 지킬 것**: `body > main`에는 원래
    다른(비-홈) 페이지들을 위한 흰 배경 규칙이 있다. 홈 화면에서는 이 흰 배경이
    `body.page-home`의 어두운 배경을 가려버리므로 `body.page-home main { background:
    transparent }`로 다시 지워준다. 이 순서를 건너뛰면 예전에 실제로 겪었던 "탭
    내용 아래로 흰 띠가 보이는" 버그가 재발한다 (`app.css`의 "body.page-home" 관련
    주석들 참고).
- **카드 색상**: 건축/디자인/솔루션 탭의 카드(`.service-card`)와 문의하기 탭의 문의
  폼(`.card`, `.panel--brand-bg .card`로 범위를 좁힘)을 순백색 대신 **따뜻한 크림색**
  (`--color-bg-cream`)으로 바꿨다 — 어두운 배경의 금색 톤과 더 잘 어울린다. 카드 안의
  아이콘 배지(`.service-card__icon`)는 대비를 위해 흰색을 그대로 유지. **다른 상세
  페이지들의 `.card`는 건드리지 않았다** — 그 페이지들은 밝은 배경이라 원래 흰색이
  맞기 때문에, `.panel--brand-bg .card`처럼 범위를 좁혀서 홈 화면 문의하기 탭에만
  적용했다.
- **폰트**: 큰 제목에는 우아한 세리프체 **Fraunces**(구글 폰트)를 새로 추가해서 적용했다
  (`--font-display` 변수, `header.php`의 구글 폰트 링크에 추가됨). 적용 위치: 회사소개
  헤드라인(`.about__copy h2`), 각 탭 제목(`.section-head h2`), 상세페이지 제목
  (`.detail-hero h1`). 본문 글자·버튼·네비 등은 그대로 Inter(산세리프) 유지 — "세리프
  제목 + 산세리프 본문" 조합은 고급스러운 느낌을 내는 흔한 방식이다.
  - **한글에는 세리프체가 적용 안 됨**: Fraunces는 한글 글자가 없는 폰트라서, 한글
    버전에서는 브라우저가 자동으로 `--font-sans`(Inter 등)로 대체해서 보여준다.
    한글 헤드라인용 세리프체(예: '리디바탕' 등)를 따로 넣고 싶으면 요청할 것.

## 문의하기 탭 스크롤 제거 — 세로 여백 압축 (2026-08-12 추가)

- **문제**: 5개 탭 중 문의하기(Contact)만 내용이 길어서 1440×900 화면에서 스크롤이
  생겼다 (압축 전: 패널 945px, 문서 전체 1299px).
- **해결 방식**: 디자인을 바꾸지 않고 위아래 여백(padding/margin)만 여러 차례에 걸쳐
  줄여서 압축했다. 주로 건드린 곳:
  - `.panel--brand-bg` 패널 자체의 상하 padding (5개 탭 전부 공유하는 클래스라, 이
    변경은 회사소개/건축/디자인/솔루션 탭의 여백도 같이 살짝 줄어드는 효과를 냈다 —
    의도한 부수효과이고 다른 탭들도 더 컴팩트해져서 나쁘지 않다).
  - `.section-head`(탭 제목 영역) margin, `.eyebrow` margin, 새로 추가한
    `.section-head__intro`(탭 소개문) margin.
  - 문의하기 폼 전용: `#contactForm` padding(ID로 좁혀서 다른 페이지의 `.card`엔 영향
    없음), `.form-grid` gap, `.field label/input/select/textarea`의 padding·margin·
    font-size, `.contact__info-item`(이메일/전화/인스타/영업시간 목록) padding.
  - `index.php`의 문의하기 제목에서 `<br>` 강제 줄바꿈을 없애 한 줄로 합침
    (`contact.title1` + `contact.title2`), 제출 버튼 위 margin도 축소.
- **결과**: 문의하기 패널 945px → 582px, 문서 전체 1299px → 936px (약 28% 감소).
  1440×900 화면 기준 스크롤이 사실상 사라졌다 (Playwright로 데스크톱/모바일/한국어
  버전 전부 스크린샷 확인 완료 — 폼이 좁아 보이거나 답답해 보이지 않고 잘 읽힘).
- **나중에 다시 압축이 필요하면**: 위에 나열한 클래스들의 padding/margin 숫자만 더
  줄이면 된다. 단, `.panel--brand-bg`는 5개 탭 공용이니 여기를 더 줄이면 모든 탭에
  영향 간다는 점 유의.

## 탭 내용을 화면 세로 가운데로 정렬 (2026-08-12 추가)

- **문제**: 카드/폼 등 탭 내용이 전부 화면 위쪽에 붙어 있고, 아래쪽(풋터 위)에 빈 공간이
  많이 남아 보였다 (특히 화면이 큰 모니터일수록 심함).
- **해결**: `body.page-home .panel.is-active`를 세로 방향 flex 컨테이너로 만들고
  `justify-content: center`를 줘서, 지금 보이는 탭의 내용(`.container` 하나 전체 —
  제목+카드, 또는 회사소개의 글/사진, 또는 문의하기의 정보+폼)을 패널이 차지하는
  세로 공간 안에서 가운데로 오게 했다.
  - **핵심은 "능동 반응형"**: `flex: 1 0 auto`의 `0`이 flex-shrink를 0으로 만들기
    때문에, 패널은 내용 크기보다 작게 찌그러들지 않는다. 즉,
    - 화면이 내용보다 넉넉하면(일반적인 노트북/모니터) → 남는 공간의 가운데로 이동.
    - 화면이 내용보다 작으면(작은 창, 낮은 해상도) → 패널이 내용 크기만큼 자연스럽게
      늘어나고 예전처럼 위에서부터 순서대로 보이며 필요하면 스크롤된다.
    - 즉 화면 크기가 달라질 때마다 따로 계산하거나 미디어 쿼리를 추가할 필요 없이
      항상 알아서 적절하게 반응한다.
- **가운데 정렬이 실제로 "보이려면" 탭 내용이 화면 높이(대략 900px 기준)보다 작아야
  한다** — 그래서 이 작업과 같이, 회사소개(About)·솔루션(Solutions) 탭도 문의하기 탭
  때처럼 높이를 줄였다:
  - **솔루션 탭**: 카드 4개가 2×2로 쌓여서 유독 길었다 → `card-grid`에
    `card-grid--4`를 추가해서 건축 탭처럼 카드 4개가 한 줄로 나오게 바꿨다
    (`index.php`의 솔루션 카드 그리드). 모바일/태블릿에서는 기존 반응형 규칙이 그대로
    적용되어 자동으로 다시 여러 줄로 쌓인다.
  - **회사소개 탭**: 글 문단이 좁은 칸에서 줄바꿈이 많이 일어나 세로로 길어졌다 →
    `.about` 그리드 비율을 `1fr 1fr`에서 `1.15fr .85fr`로 바꿔 글 칸을 넓히고(줄바꿈
    수 감소), 제목·문단·배지(pill) 사이 여백도 같이 줄였다.
  - **문의하기 탭**: 지난번 압축(위 섹션 참고)에 이어 입력창 패딩·라벨 여백·메시지창
    높이·제목 영역 여백을 한 번 더 줄여서 900px 기준 여유분을 936px → 906px까지
    좁혔다 (완전히 900 이하로 떨어뜨리진 않았다 — 더 줄이면 입력칸이 너무 답답해
    보일 것 같아 여기서 멈췄다. 아주 살짝 짧은 화면에서는 가운데 정렬 대신 예전처럼
    위 정렬 + 약간의 스크롤로 자연스럽게 대체된다).
  - 이 결과 1440×900 기준: 회사소개/건축/디자인/솔루션 4개 탭은 정확히 900px로 딱
    맞고, 문의하기만 906px(6px 초과, 사실상 거의 안 보임). 한국어 버전은 텍스트가
    더 짧아서 5개 탭 전부 정확히 900px에 맞는다.
- **나중에 다른 탭을 추가하거나 내용을 늘릴 때**: 내용이 화면보다 커지면 가운데
  정렬 효과가 자동으로 사라지고 예전처럼 위 정렬+스크롤로 돌아가니 레이아웃이
  깨지진 않는다. 다만 "가운데 정렬이 잘 보이게" 하고 싶으면 위와 같은 방식(칼럼
  비율 조정, 카드 줄 수 줄이기, 여백 미세 조정)으로 900px 안에 들어오도록
  맞추면 된다.

## 탭 전환 시 sticky 네비 뒤로 내용이 가려지던 진짜 원인 (2026-08-12 추가, 중요)

- **증상**: 사용자가 "문의하기 탭 내용이 위쪽에 쏠려 있고 카드/폼 여백도 좁아서
  언밸런스해 보인다"고 피드백을 줬다. 처음엔 단순히 세로 가운데 정렬이 안 먹혀서
  그런 줄 알고 여백을 이것저것 줄이며 900px에 맞추려 했는데, 진짜 원인은 따로
  있었다.
- **진짜 원인**: 탭을 누르거나(`app.js`의 `window.location.hash = slug`) 주소창에
  `#contact` 같은 해시가 붙은 채로 페이지가 열리면, **브라우저가 자동으로 그
  id를 가진 요소로 스크롤하는 기본 동작**이 같이 실행된다. 그런데 상단 네비
  (`.nav`)가 `position: sticky`로 화면에 계속 떠 있다는 걸 브라우저의 이 자동
  스크롤 계산은 모른다 — 그래서 탭 내용을 "화면 맨 위(0)"에 딱 맞춰서 스크롤해
  버리고, 그 결과 sticky 네비가 탭 내용의 위쪽 ~80px를 가려버린다. 전체 페이지가
  의도치 않게 아래로 스크롤된 상태가 되어 "내용이 위로 쏠리고 아래에 어색한 빈
  공간이 남는" 것처럼 보였던 것 — 사실은 세로 정렬 문제가 아니라 **탭을 열 때마다
  매번 스크롤이 어긋나는 버그**였다.
  - Playwright로 직접 `window.scrollY`를 찍어보고서야 확인됨: 탭 진입 시
    `scrollY`가 항상 80이었다 (nav 높이만큼).
  - 상세 페이지의 `.hero`가 이미 똑같은 문제를 `margin-top:-84px; padding-top:84px;`
    조합으로 해결해온 전례가 있다 — 즉 이 사이트에서 반복적으로 나타나는 종류의
    버그다.
- **해결**: `.panel`에 `scroll-margin-top: 84px;`를 추가했다. 이 CSS 속성은
  "이 요소로 스크롤할 때 위쪽에 이만큼 여유를 두고 멈춰라"라는 뜻이라, 브라우저의
  자동 스크롤(주소창 해시 진입이든 `location.hash =` 코드로 인한 것이든 전부 포함)이
  더 이상 sticky 네비 밑으로 파고들지 않는다. 탭 내용이 원래 네비 바로 아래(스크롤
  0)에 있었기 때문에, 이 수정 이후로는 탭 전환 시 사실상 스크롤이 전혀 발생하지
  않는다 (Playwright로 재검증: 탭 진입 후 `scrollY`가 항상 0).
- **이 버그를 계기로 되돌린 것**: 이 버그 때문에 "내용이 짧아 보인다"고 착각해서
  문의하기 탭 여백을 지나치게 줄였었는데, 진짜 원인을 고친 뒤에는 다시 여유
  있게 되돌렸다:
  - `#contactForm` padding, `.field` 입력칸 패딩/라벨 여백, `.form-grid` 간격,
    `.field textarea` 최소 높이, `.contact__info-item` 패딩, 문의 제출 버튼
    margin-top — 전부 예전보다 넉넉하게 복원.
  - `.contact` 그리드에 `align-items: center`를 추가해서, 왼쪽 정보 목록(이메일/
    전화/인스타/영업시간)이 오른쪽 폼 카드보다 짧을 때 위쪽에 붕 뜨지 않고 폼과
    세로로 가운데 맞춰지도록 했다 — 이게 "카드 간 언밸런스"의 또 다른 원인이었다.
  - 여백을 넉넉하게 되돌리면서 문의하기 탭이 다시 900px보다 길어질 수 있는데,
    이제는 스크롤 버그가 없으니 괜찮다 — 화면이 넉넉하면 위 섹션의 가운데 정렬이
    자연스럽게 적용되고, 화면이 좁으면 그냥 위 정렬 + 스크롤로 자연스럽게
    보인다(더 이상 네비 뒤에 숨거나 이상한 위치로 스크롤되지 않는다).
  - `.panel--brand-bg`(전체 패딩), `.section-head`(제목 영역 여백), 문의하기 폼의
    각종 여백을 `vh` 기준 `clamp()`로 만들어서, 화면 높이가 낮을 때는 자동으로
    줄어들고 화면이 넉넉할 때는 원래의 여유 있는 값으로 돌아오게 했다 — 특정
    픽셀 값 하나에 맞추는 대신 실제 창 높이에 맞춰 계속 반응한다.
- **앞으로 새 탭/섹션을 추가할 때 꼭 기억할 것**: `id`가 있고 탭 전환(`location.hash`)
  으로 스크롤될 수 있는 요소는 항상 `.panel`처럼 `scroll-margin-top`을 sticky 네비
  높이만큼 줘야 한다. 안 그러면 이번과 똑같이 "내용이 네비 뒤에 가려지고 스크롤이
  어긋나는" 문제가 재발한다.

## 건축 · 디자인 · 솔루션 탭 실사진 삽입 (2026-08-13, 최종 정리)

사용자가 AI로 생성한 사진들을 세 차례에 걸쳐 줬다. 시행착오를 거쳐 **아래 내용이
최종 확정된 방식**이다 — 중간에 있었던 "카테고리별 배경 이미지" 시도는 사용자가
최종적으로 되돌리라고 해서 폐기했다. 새 카테고리/사진을 추가할 때는 이 섹션만
보면 된다.

- **폴더 구조 (Mac, `sites/Design_dan/imge/`)**: 카테고리별 하위 폴더
  (`건축/`, `디자인/`, `솔루션/`)에 `배경.png`(사용 안 함, 아래 참고)과
  하위 서비스 개수만큼 `OOO 카드.png`(그 카드에 넣을 사진)가 들어있는 구조.
  원본은 장당 1~3MB PNG(대부분 1536×1024)라 JPEG 품질 82로 재인코딩해서
  `assets/images/`에 저장했다 (장당 120~340KB로 축소). 원본 PNG는 `imge/` 폴더에
  그대로 남아있다.
  - `건축/설계 카드.png` → `assets/images/architecture-design.jpg`
  - `건축/측량 카드.png` → `assets/images/architecture-survey.jpg`
  - `건축/시공 카드.png` → `assets/images/architecture-construction.jpg`
  - `디자인/상업디자인 카드.png` → `assets/images/design-graphic-card.jpg`
  - `디자인/영상 카드.png` → `assets/images/design-video-card.jpg`
  - `솔루션/컨설팅 카드.png` → `assets/images/solutions-consulting.jpg`
  - `솔루션/자동화 카드.png` → `assets/images/solutions-automation.jpg`
  - `솔루션/홈체이지 제작 카드.png` → `assets/images/solutions-website.jpg`
  - `솔루션/어플 카드.png` → `assets/images/solutions-apps.jpg`
- **배경(`배경.png`)은 쓰지 않는다 — 전 탭 공용 그라데이션 배경으로 통일**:
  한 차례 `#architecture.panel--brand-bg` / `#design.panel--brand-bg`에 각각
  카테고리 사진을 `background-image`로 넣어본 적이 있는데, 사용자가 "모든
  카테고리에 이미지는 삭제 해서 기존 그라데이션 이미지로 해 줘"라고 명시적으로
  되돌려달라고 해서 **완전히 제거했다**. 지금은 5개 탭(회사소개/건축/디자인/
  솔루션/문의하기) 전부 `body.page-home`의 공용 다크 그라데이션 + 블루프린트
  SVG 배경 하나만 쓴다. `건축/배경.png`, `디자인/디자인 배경.png`,
  `솔루션/솔루션 배경.png`는 앞으로도 쓸 계획이 없으니 새로 사진을 추가할 때
  헷갈리지 말 것 — **카드(`OOO 카드.png`)만 쓴다.**
- **카드(`OOO 카드.png`)는 서비스 카드 위쪽 사진으로**: `includes/services.php`의
  각 카드 항목에 선택적 `'photo'` 키를 추가했고, `index.php`의 건축/디자인/솔루션
  카드 그리드 반복문에서 `photo`가 있으면 카드 맨 위에 `.service-card__photo`(둥근
  모서리, 카드 패딩만큼 음수 마진으로 카드 끝까지 꽉 채움)를 렌더링하도록 했다.
  사진 아래쪽에는 카드 크림색으로 자연스럽게 번지는 그라데이션(`::after`)을 깔아서
  사진이 뚝 잘리지 않고 부드럽게 카드 본문과 이어지게 했다.
  - 새 서비스에 카드 사진을 추가하려면: 이미지를 `assets/images/`에 넣고
    `services.php`의 해당 항목에 `'photo' => 'images/파일명.jpg'` 한 줄만
    추가하면 된다 (마크업은 이미 조건부로 처리돼 있어서 손댈 필요 없음).
- **아이콘 + 제목은 가로 배치**: 원래 아이콘 아래에 제목이 세로로 쌓이는
  구조였는데, 사용자가 "삼각자 아이콘 옆에 설계 이렇게, 모든 카드 아이콘 옆에
  해당 타이틀 넣어줘"라고 요청해서 바꿨다. `index.php`에서 아이콘(`.service-card__icon`)과
  `<h3>`를 `.service-card__head`(`display:flex; align-items:center; gap:14px`)
  로 감싸서 한 줄에 나란히 놓이게 했다. 모든 카드(건축 3개·디자인 2개·솔루션
  4개)에 동일하게 적용됨.
  - 새 카드를 추가할 때도 이 `.service-card__head` 래퍼 안에 아이콘+제목을
    넣는 패턴을 그대로 따라야 세로로 다시 쌓이지 않는다.
- **디자인 카드 2장(그래픽/영상)이 건축 카드에 비해 "부자연스럽다"는 피드백
  (2026-08-13, 3차 수정 — 최종)**: `상업디자인 카드.png` / `영상 카드.png`는
  사진 자체에 제목·설명·아이콘까지 이미 다 디자인되어 있는 "포스터형" 이미지라
  (순수 사진이 아님), 처음엔 카드 사진 영역 높이/기준점만 조정해서 문구가
  잘리지 않게 미봉책으로 고쳤었다. 그런데 사용자가 "건축 카테고리 카드에
  이미지는 아주 자연 스러워 하지만 디자인 카테고리에 그래픽&상업 카드의
  이미지는 자연스럽지 않아 비교 되지?? 건축의 카드 처럼 깔끔 하게 정리 해 줘"
  라고 다시 피드백을 줘서, 미봉책 대신 **원본 이미지에서 글자·아이콘이 없는
  순수 제품/장비 사진 영역만 다시 잘라내 파일 자체를 교체**했다 (Python
  PIL로 `PIL.Image.crop()`) — 그래픽 카드는 오른쪽의 문구류(팬톤 컬러칩·
  노트·명함·펜) 플랫레이 부분만, 영상 카드는 오른쪽의 드론+시네마 카메라
  촬영 장비 부분만 남겼다. 이제 건축 카드와 완전히 동일한 기본 168px cover
  크롭만으로 자연스럽게 나온다 — `#design` 전용 object-position 오버라이드는
  더 이상 필요 없어서 제거했다. 영어 버전에서도 사진 속 한글 문구(로고 각인
  "DESIGN DAN" 등)는 일부 그대로 보이지만, 브랜드 소품 사진이라 자연스럽다.
  - **새 카드 사진을 만들 때 참고할 것**: AI로 생성한 "포스터형" 이미지(문구·
    아이콘이 이미지 안에 이미 디자인된 것)를 카드 사진으로 쓰려면, 처음부터
    문구 없는 순수 사진/제품샷 영역이 이미지 안에 따로 있는지 확인하고 그
    부분만 잘라 쓰는 게 낫다 — 안 그러면 이번처럼 건축 탭의 깔끔한 사진들과
    나란히 놓였을 때 이질감이 생긴다.
- **솔루션 > 어플 카드 사진의 체크보드(투명 배경 표시 패턴)가 그대로 보이던
  문제 (2026-08-13, 4차 수정)**: `어플 카드.png`는 원래 투명 PNG로 만들어질
  의도였던 것 같은데, 실제로는 알파 채널 없이(RGB) 회색/흰색 체크무늬가
  픽셀에 그대로 구워져(baked-in) 있었다 — 그래서 사이트에 올리면 "배경 없는
  벡터 아이콘들이 둥둥 떠 있는" 것처럼 부자연스럽게 보였다. Adobe 배경 제거
  도구를 시도했으나 이 샌드박스는 Adobe 업로드 서버(at.adobe.com)로 나가는
  아웃바운드 네트워크가 막혀 있어 사용 불가 → 대신 Python(PIL + scipy)으로
  직접 처리했다: 체크무늬는 두 가지 거의 무채색(R≈G≈B) 밝은 회색(~239, ~254)
  이 교대로 나타나는 매우 규칙적인 패턴이라는 점을 이용해 (1) "무채색이면서
  밝은" 픽셀을 체크무늬 후보로 표시 → (2) `scipy.ndimage.binary_dilation`으로
  점선 가이드라인 주변의 안티앨리어싱 얼룩까지 포함해서 살짝 확장 → (3) 작은
  잡티(그림자 노이즈)는 연결 요소 크기 기준으로 제거 → (4) 가장자리를
  가우시안 블러로 부드럽게 → (5) 흰색→크림색(`#f6f2ec`, 카드 배경색과 동일)
  세로 그라데이션 배경 위에 합성. 처리 스크립트는 저장해두지 않았으니 같은
  체크보드 문제가 다른 이미지에서도 생기면 이 방식을 그대로 재현하면 된다
  (핵심: 무채색+밝기 임계값으로 체크무늬 마스크 생성 → 팽창/노이즈 제거 →
  블러 → 카드와 같은 색 배경에 합성).
- **상세 페이지 사진은 그대로 유지**: `architecture/design`,
  `architecture/aerial-survey`, `architecture/construction` 3개 상세 페이지에
  넣은 `includes/detail-hero.php`의 `$detailPhoto` 배너(제목 아래 큼직한 사진)는
  이번 라운드와 무관해서 그대로 뒀다 — 카드용 사진과 같은 원본을 재사용한다.
- **주의 — `asset()` 함수 경로 규칙**: `asset()` 함수는 내부에서 이미
  `/assets/`를 붙여주기 때문에, 호출할 때 `asset('images/파일명.jpg')`처럼
  `assets/`를 빼고 넘겨야 한다. `asset('assets/images/...')`처럼 잘못 넘기면
  `.../assets/assets/images/...`로 경로가 겹쳐져서 이미지가 안 뜬다 (처음에 이
  실수를 했다가 스크린샷에서 깨진 이미지로 발견하고 고쳤음 — 새 이미지를
  추가할 때 항상 조심할 것).

## 로컬에서 확인하기

**가장 쉬운 방법 — `sites/start-servers.command` 더블클릭**
`pdcebu`, `Design_dan`이 같이 들어있는 `sites` 폴더에 `start-servers.command`를 만들어뒀다.
더블클릭하면 터미널이 열리면서 `sites` 폴더를 기준으로 서버가 뜨고, 그 상태로
`http://localhost:8080/Design_dan/`(그리고 `http://localhost:8080/pdcebu/`도 동시에)
접속할 수 있다. 끌 때는 그 터미널 창에서 Ctrl+C. macOS에서 처음 더블클릭할 때
"확인되지 않은 개발자" 경고가 뜨면, 파일 우클릭 → 열기로 한 번만 승인하면 그다음부터는
바로 더블클릭이 된다.

아래는 수동으로 띄우고 싶을 때 참고용 — `config.php`의 `BASE_URL` 계산이 "지금 어느
폴더를 docroot로 잡았는지"를 스스로 알아내기 때문에, **아래 두 방법 다 정상 작동한다.**

**방법 A — Design_dan 폴더 안에서 실행 (더 간단함)**
```
cd Design_dan
php -S localhost:8080
```
→ **http://localhost:8080/** 로 접속 (`/Design_dan/` 안 붙음).

**방법 B — pdcebu와 똑같이, 상위 폴더(sites)에서 실행**
```
cd sites          # pdcebu, Design_dan 이 같이 들어있는 폴더
php -S localhost:8080
```
→ **http://localhost:8080/Design_dan/** 로 접속.

**주의할 것 딱 하나:** 방법 A로 띄웠는데 주소에 `/Design_dan/`을 붙이면 404 나고,
반대로 방법 B로 띄웠는데 `/Design_dan/` 없이 루트로 들어가면 엉뚱한 페이지(또는 404)가
뜬다. 지금 내가 어느 폴더에서 `php -S`를 실행했는지에 맞는 주소를 써야 한다.

DB는 필요 없어서 바로 뜬다.

이번 세션에서 새 탭+카드 구조를 `php -l`(문법 검사, 16개 PHP 파일 전부 통과) +
`php -S` + curl(모든 경로 200/301 확인) + Playwright 스크린샷(데스크톱 5개 탭,
모바일, 한/영 두 언어, 상세 페이지, 어플 빈 상태 화면, 탭 클릭 실동작)으로
전부 확인 완료.

## 현재 상태 (2026-08-12 오후 기준)

| 영역 | 상태 |
|---|---|
| 탭 5개(회사소개/건축/디자인/솔루션/문의하기) + 홈페이지 스크롤 없는 패널 전환 | 완료 |
| 건축/디자인/솔루션 하위 카드 → 상세 페이지 9개 | 완료 |
| 예전 `/graphic-design/` 주소 → `/design/graphic/` 301 리다이렉트 | 완료 |
| 한/영 전환 (실제로 동작) | 완료 — `?lang=`, 쿠키 유지, 탭 상태 유지, 데스크톱/모바일 토글 둘 다 |
| 문의 폼 | **2026-08-14부터 실제로 DB에 저장됨** (답변 게시판 섹션 참고) — 다만 새 문의가 와도 관리자에게 이메일 알림은 아직 안 감(관리자가 `/admin/`에 직접 들어가서 확인해야 함) |
| 실제 사진/이미지 | **전부 없음.** About 섹션은 베이지색 placeholder 박스 |
| 어플(`/solutions/apps/`) | 자리는 완성, **앱은 아직 0개** — "새 앱 추가하는 법" 참고 |

## 남은 것 — 다음에 할 일

1. **실제 사진 준비.** About 섹션 팀/사무실 사진, 각 상세 페이지 아이콘을 실제 사진/
   일러스트로 교체하고 싶으면 `assets/images/`에 넣고 해당 `<div>`를 `<img>`로 바꾸면 된다.
2. **문의 폼 저장은 완료.** 2026-08-14에 답변 게시판을 만들면서 실제 DB 저장으로
   바뀌었다 (아래 "답변 게시판" 섹션 참고). 남은 건 "새 문의 왔을 때 관리자에게
   이메일 알림 보내기"뿐 — PHP `mail()` 또는 외부 이메일 서비스(Resend/SendGrid
   등) 연동이 필요하고, 아직 안 되어 있음. 지금은 관리자가 `/admin/`에 직접
   들어가서 확인해야 새 문의를 알 수 있다.
3. **첫 앱(그룹통화) 추가.** Render 배포가 끝나면 위 "새 앱 추가하는 법" 그대로
   `solutions/apps/index.php`의 `$apps[]`에 한 줄 추가.
4. **DNS/도메인 실제 배포는 완전히 별도 작업.** 지금까지는 전부 로컬 코드 작업만
   했고, `designs-dan.com` 도메인을 실제로 이 새 코드에 연결하는 작업(도메인
   등록처 확인, 호스팅 선택, DNS 레코드 수정, `app이름.designs-dan.com` 서브도메인
   설정)은 아직 시작 안 함.

## 호스팅 & 배포 (2026-08-14 추가)

`designs-dan.com`은 Render(Docker 웹 서비스)에 배포되어 있다.

- **GitHub 저장소**: `github.com/vvvJOSHvvv/designs_dan` (public). 이 세션은 GitHub에
  직접 push할 권한이 없어서, 코드를 수정할 때마다 바뀐 파일을 사용자가 GitHub
  웹 화면에서 드래그 앤 드롭으로 다시 업로드해야 한다.
- **Render 웹 서비스**: `designs_dan` (Docker, Singapore, Free 플랜). GitHub `main`
  브랜치에 새 커밋이 올라오면 **자동 배포**된다 (`autoDeploy: yes`). 기본 주소는
  `https://designs-dan.onrender.com`.
- **Dockerfile**: `php:8.2-apache` 베이스, `DocumentRoot`를 프로젝트 루트로 지정.
  외부 패키지 의존성 없음(순수 PHP)이라 그대로 빌드된다.
- **커스텀 도메인**: `designs-dan.com` / `www.designs-dan.com`을 Render Custom
  Domain으로 연결. DNS는 Readdy 쪽 DNS 관리 화면(`readdy.ai` 로그인 후 도메인
  설정)에서 편집:
  - `designs-dan.com` (A) → `216.24.57.1`
  - `www.designs-dan.com` (CNAME) → `designs-dan.onrender.com`
  - 나머지 레코드(send/_domainkey/_acme-challenge 등)는 Readdy 이메일·인증서용이라
    건드리지 않음.

**배포 순서 요약**: (1) 이 세션에서 코드 수정 → (2) 사용자가 바뀐 파일을 GitHub에
재업로드 → (3) Render가 자동으로 감지해서 재배포 (사용자가 따로 할 것 없음).

### ⚠️ 트러블슈팅 — "DNS는 맞는데 계속 예전 Readdy 사이트가 나옴"

2026-08-14에 실제로 겪은 문제라 기록해둔다. Render Custom Domain에 DNS 레코드를
전부 정확히 맞춰놓고(A/CNAME 둘 다 Render 쪽 값으로), Render 대시보드에서도
`Verified` + `Certificate Issued`로 초록불이 다 떴는데도, 몇 시간 동안 계속
`designs-dan.com`(www 없는 루트)에서만 예전 Readdy 사이트가 나오는 현상이 있었다.
(`www.designs-dan.com`은 바로 정상 작동함 — 이 차이가 결정적 단서였다.)

**원인**: DNS 레코드 문제가 아니라, Readdy 계정 자체의 "**커스텀 도메인**" 화면에서
`designs-dan.com`이 여전히 Readdy의 예전 프로젝트(예: "라이브 버전 179")에
"**기본 도메인**"으로 게시(publish)된 상태로 남아있었기 때문이었다. 이건 DNS
레코드 편집 화면(Readdy → 도메인 설정 → DNS 설정)과는 **완전히 별개의 설정**이라,
DNS를 아무리 정확하게 고쳐도 Readdy 쪽에서 그 도메인을 "내가 게시한 사이트"로
붙잡고 있는 한 안 풀린다.

**해결**: Readdy 로그인 → 프로젝트 → "커스텀 도메인" 화면 → `designs-dan.com` 옆
점 3개(⋮) 메뉴 → **"게시 취소"** 클릭 (예전 Readdy 사이트 자체를 내리는 것 — 우리는
이미 Render로 완전히 이전했으니 안전함). 이후 Readdy 쪽 캐시가 풀리기까지 다시
몇 시간 정도 더 걸렸다 (거의 정확히 게시 취소 후 2시간 반쯤 지나서 확인됨).
중간에 일시적으로 예전 사이트 / 404 / 새 사이트가 뒤섞여서 보이는 등 불안정한
상태를 거쳤지만, 결국 전 세계 캐시가 다 풀리면서 정상화됐다.

**교훈**: 만약 나중에 또 이런 "DNS는 맞는데 반영이 안 됨" 증상이 생기면, DNS
레코드보다 먼저 Readdy(또는 원래 쓰던 사이트 빌더) 계정에 그 도메인을 "게시"
상태로 붙잡고 있는 설정이 남아있는지부터 확인할 것.

## 자료실 탭 (2026-08-14 추가)

> **배포 상태 (2026-08-14 기준): 로컬/Mac 폴더에만 반영, GitHub·라이브 사이트에는
> 아직 안 올라감.** 자료실 탭 + 탭 순서(자료실↔문의하기) 변경 둘 다 사용자가
> "추가 작업을 하고 나중에 같이" GitHub에 올리기로 함. 그래서 지금 `designs-dan.com`
> 라이브 사이트 nav에는 자료실 탭이 안 보이는 게 정상. 다음에 GitHub 업로드할 때
> 아래 "아직 GitHub에 안 올라간 변경사항 모음" 섹션의 전체 파일 목록을 같이 올려야 함
> (자료실 탭 하나만이 아니라, 이후에 이어서 작업한 문의하기 탭 제거 + 상세페이지
> 다크 배경 통일까지 전부 한 묶음으로 밀려있는 상태).

홈 탭에 "문의하기" 다음으로 **자료실**(`#resources`) 탭을 추가했다. 도면·어플·명함·
인쇄 이미지 등 고객에게 전달해야 할 작업 파일을 카테고리별로 모아 다운로드할 수 있게
만든 자리다. 지금은 카테고리 틀만 있고 실제 파일은 아직 없음(전부 "준비중" 배지).

- **카테고리 데이터**: `includes/resources.php`의 `$RESOURCE_CATEGORIES` 배열.
  `solutions/apps/index.php`의 `$apps` 배열과 똑같은 패턴 — 항목에 `'files' => []`가
  비어있으면 "준비중" 배지, 하나라도 있으면 자동으로 다운로드 링크 목록이 뜬다.
- **파일 추가하는 법**:
  1. `assets/resources/` 폴더(없으면 새로 생성)에 실제 파일을 넣는다.
  2. `includes/resources.php`에서 해당 카테고리의 `'files'` 배열에 한 줄 추가:
     `['name_en' => 'Floor Plan v2', 'name_ko' => '평면도 v2', 'file' => 'floor-plan-v2.pdf']`
- **새 카테고리 추가**: `$RESOURCE_CATEGORIES`에 항목을 하나 더 추가하면 끝
  (nav 탭 자체는 `includes/services.php`의 `$NAV_SERVICES`에 등록되어 있고, 이건
  자료실 안의 하위 카테고리 목록만 다루는 별도 배열이다).
- 관련 파일: `includes/resources.php`(신규), `index.php`(자료실 패널 섹션),
  `includes/services.php`(nav에 `resources` 탭 추가), `includes/lang.php`
  (`nav.resources`, `tab.resources.*`), `assets/css/app.css`(`.resource-card__files`).

## 문의하기 탭 제거 + 이메일 문의 → 문의하기 버튼 (2026-08-14 추가)

상단 nav 탭에서 "문의하기"를 뺐다 (오른쪽에 이미 있는 "문의하기" 버튼과 중복돼서).
대신 그 오른쪽 CTA 버튼 이름을 기존 "이메일 문의"에서 "문의하기"로 바꿨다 —
`nav.email_inquiry` 키는 삭제하고 기존 `nav.contact` 키를 재사용.

실제 `#contact` 패널(`index.php`)과 `findNavTab('contact')` 호출은 그대로 남아있어서,
`data-tab="contact"` 링크(각 상세페이지의 "상담 문의하기" 버튼 등)는 계속 정상
동작한다 — 탭 전환 JS(`app.js`)가 `$NAV_SERVICES` 배열이 아니라 실제
`.panel[data-panel]` 요소를 기준으로 동작하기 때문. 자세한 설명은
`includes/services.php` 상단 주석 참고.

- 관련 파일: `includes/services.php`(`$NAV_SERVICES`에서 `contact` 항목 삭제),
  `includes/header.php`(CTA 버튼을 `nav.contact` 키로 변경), `includes/lang.php`
  (`nav.email_inquiry` 키 삭제).

## 상세페이지(9개) 다크 배경 통일 (2026-08-14 추가)

카드를 눌러 들어간 상세페이지(예: 건축>설계, 디자인>그래픽&상업)의 배경이 흰색이라
홈 화면의 어두운 블루프린트 톤과 안 어울린다는 피드백 → 사용자가 "전체 다크로
통일" 선택. 홈 탭과 똑같은 다크 블루프린트 그라데이션 배경을 9개 상세페이지 전부에
적용했다 (`graphic-design/index.php`는 리다이렉트 전용이라 대상 아님).

- **동작 원리**: 각 상세페이지 파일에서 `header.php`를 불러오기 직전에
  `$isDetailPage = true;`를 설정 → `header.php`가 `<body class="page-detail">`를
  붙인다 (`page-home`과 마찬가지 패턴, 서로 배타적). `app.css`에서
  `body.page-home, body.page-detail { background: ... }`로 같은 블루프린트
  배경을 공유하고, `body.page-detail`에 `color: var(--color-text-inverse)`를
  줘서 카드 등 자체 배경이 없는 텍스트가 자동으로 밝은색이 되게 했다.
- **밝은 배경 컴포넌트는 그대로 유지**: `.card`/`.card--cream`(흰색/크림 카드가
  번갈아 나오는 기존 리듬), `.section--cream`(디자인>그래픽 페이지의 "제작
  프로세스" 박스), `.gd-step`/`.automation__apps`/`.empty-state` — 이 컴포넌트들은
  전부 자체 `color: var(--color-text)`를 컨테이너에 직접 지정해뒀기 때문에, body
  텍스트색이 뒤집혀도 안쪽 제목/본문 글자색이 깨지지 않는다 (기존에 `.card`가 쓰던
  것과 같은 안전 패턴을 확장 적용).
- **골드 vs 앰버 eyebrow**: 어두운 배경 위 eyebrow(작은 라벨 텍스트)는
  `var(--color-accent)`(밝은 골드), 크림 박스 위 eyebrow는 기존
  `var(--color-accent-warm)`(앰버)를 유지 — `body.page-detail .section:not
  (.section--cream) .eyebrow` 처럼 `.section--cream`을 명시적으로 제외해서 두
  버전이 서로 안 섞이게 했다.
- **인라인 스타일 2곳 직접 수정**: `design/graphic/index.php`의 프로젝트 소개
  문단(`color:var(--color-text-muted)` → `var(--color-text-inverse-muted)`),
  `solutions/automation/index.php`의 첫 기능 항목 상단 테두리
  (`border-top:1px solid var(--color-border)` → `var(--color-border-dark)`) —
  인라인 스타일은 CSS 클래스 규칙으로 덮어쓸 수 없어서 값 자체를 바꿔야 했다.
- **이미 다크였던 컴포넌트는 그대로**: `.section--dark`(건축>시공, 솔루션>컨설팅의
  프로세스 박스)는 원래부터 자체 다크 배경/글자색을 갖고 있어서 손댈 필요 없었음.
- 새 상세페이지를 추가할 때: 다른 8개처럼 `header.php` require 직전에
  `$isDetailPage = true;`만 넣으면 자동으로 같은 다크 배경이 적용된다.
- 관련 파일: `includes/header.php`(`$isDetailPage` 변수 + body 클래스),
  `assets/css/app.css`(`body.page-detail` 관련 규칙 전체),
  9개 상세페이지 전부(각각 `$isDetailPage = true;` 한 줄 추가),
  `design/graphic/index.php` + `solutions/automation/index.php`(인라인 스타일
  값 수정, 위 항목 참고).

## 답변 게시판 + 관리자 페이지 (2026-08-14 추가)

> **2026-08-14: 자료실/문의하기 정리/상세페이지 다크모드/답변 게시판 코드 전부
> GitHub `main`에 업로드 완료 → Render 자동 배포됨.** 다만 답변 게시판은 아직
> **`DATABASE_URL` 환경변수를 설정 안 함** — 지금 상태로는 문의 폼을 제출하면
> 에러는 안 나지만, 컨테이너 임시 파일(SQLite)에 저장되다가 다음 배포/재시작 때
> 조용히 사라질 수 있다. 아래 "운영 배포 전 꼭 해야 할 일" 참고 — 아직 진행 안 함.

홈 화면의 "문의하기" 폼이 이제 진짜로 저장되고, 보낸 사람은 자기 글을 게시판에서
다시 볼 수 있다. 요청한 대로 "비밀번호로 잠그는 게시판"(네이버 카페 비밀글과 같은
패턴) 방식으로 만들었고, 관리자는 별도 로그인 후 모든 문의를 보고 답변/견적을 달
수 있다.

**"답변" nav 위치 (2026-08-14, 배치 확정)**: 처음엔 왼쪽 탭 줄(자료실 옆)에 뒀다가,
"자료실 옆 vs 문의하기 옆" 중 어디가 나을지 논의 끝에 **문의하기 옆**으로 옮겼다 —
답변은 자료실(완성 파일 다운로드)보다 문의하기(내가 쓴 글에 대한 응답 확인)와 성격이
같은 짝이라는 판단. 그래서 지금은 왼쪽 탭 줄(`$NAV_SERVICES` + 답변)이 아니라,
오른쪽 `.nav__actions` 안에서 EN 토글과 문의하기 버튼 사이에 있다
(`includes/header.php`의 `.nav__answers-link`). 모바일 메뉴에는 원래 문의하기로
갈 방법이 아예 없었는데(=`.nav__actions .btn`이 좁은 화면에서 그냥 숨겨지기만 하고
대체 링크가 없었음), 이번에 답변 바로 아래에 문의하기 버튼을 새로 추가해서 그
빈틈도 같이 메웠다. **CSS 주의**: 모바일 브레이크포인트(`@media max-width:960px`)에서
`.nav__menu, .nav__actions .btn, .nav__lang`을 숨기는 규칙에 `.nav__answers-link`를
반드시 같이 넣어야 한다 — 안 그러면 모바일에서 버거 메뉴 옆에 "답변"이 중복으로
남는다 (실제로 한 번 이렇게 빠뜨렸다가 스크린샷 확인 중 발견해서 고침).

### 사용자 쪽 흐름

1. 홈 `#contact`에서 이름/이메일/전화/문의유형/메시지 + **비밀번호(선택)**를 입력해 제출.
   비밀번호를 넣으면 비공개 글이 되고, 비워두면 공개 글이 된다.
2. 제출하면 자동으로 `/answers/view.php?id=번호`로 이동 — 이게 "내 글" 주소이니
   나중에 답변 확인하려면 이 주소나 비밀번호를 기억해 둬야 한다.
3. 상단 nav의 **답변** 탭(`/answers/`)에 모든 문의가 목록으로 뜬다. 이름은
   `홍**`처럼 일부만 보이게 가리고, 이메일/전화번호는 목록·상세 어디에도 공개
   노출 안 함(관리자만 볼 수 있음). 비공개 글은 🔒 표시.
4. 비공개 글을 누르면 비밀번호를 입력해야 내용이 보인다 (세션에 저장되어, 같은
   브라우저에서는 다시 안 물어봄).
5. 관리자가 답변을 달면 상태가 "답변 완료"로 바뀌고, 그 페이지에 답변 내용 +
   (있으면) 견적 내용이 크림색 박스로 따로 표시된다.

### 관리자 쪽 흐름

- **⚠️ 2026-08-18부터 풋터에 "관리자 로그인" 링크가 없다** (아래 "관리자 화면 숨기기"
  섹션 참고). 관리자는 **주소창에 `/admin` 을 직접 입력**해서 들어간다 →
  로그인 화면 → `/admin/index.php`에서 전체 문의 목록(비공개 글도 비밀번호 없이 다
  보임) → 글 클릭 → `/admin/view.php`에서 연락처(이메일/전화)까지 전부 보고,
  답변/견적 작성 폼으로 답변 등록.
- 로그인 안 하고 `/admin/*.php`에 들어가면 자동으로 로그인 페이지로 리다이렉트.

### 첫 관리자 계정 만들기

관리자 회원가입 화면은 따로 없다 (보안상 아무나 관리자를 못 만들게). 대신
**`/admin/setup.php`**가 "관리자 계정이 하나도 없을 때만" 동작하는 1회용
부트스트랩 페이지다. 배포 후 제일 먼저:

1. `https://designs-dan.com/admin/setup.php` 접속
2. 원하는 아이디 + 비밀번호(8자 이상) 입력 후 계정 만들기
3. 그 다음부터 이 페이지는 "이미 관리자 계정이 있어서 사용할 수 없습니다"만
   보여준다 (재사용 불가 — 계정을 더 추가하려면 지금은 DB에 직접 넣어야 함,
   나중에 관리자 화면에서 계정 추가 기능을 만들 수도 있음).

### 데이터 구조 (DB)

- `includes/db.php`의 `db()` 함수가 PDO 연결을 돌려준다. 딱 한 곳에서만
  연결하면 되므로, DB를 쓰는 페이지는 전부 `require includes/db.php` +
  `require includes/answers-data.php`를 불러온다.
- **운영(Render)**: 환경변수 `DATABASE_URL`이 있으면 그걸 Postgres 연결
  문자열로 파싱해서 쓴다 (`postgres://user:pass@host:5432/dbname` 형태).
- **로컬 개발**: `DATABASE_URL`이 없으면 `data/app.db`(SQLite 파일)를 자동
  생성해서 쓴다. `data/`는 `.gitignore`에 등록되어 있어 GitHub에는 절대 안
  올라간다 (문의자 개인정보가 들어있으므로 안전).
- 테이블 3개, 최초 연결 시 자동 생성(`db_init_schema()`):
  `admin_users`(id, username, password_hash), `inquiries`(id, name, email,
  phone, inquiry_type, message, password_hash, status, created_at),
  `inquiry_replies`(id, inquiry_id, admin_username, reply_message,
  quote_text, created_at).
- 비밀번호(관리자 로그인 비밀번호 + 문의 비공개 비밀번호)는 전부
  `password_hash()`로 해시해서 저장, 평문 저장 없음.

### 관련 파일

- `includes/db.php`(신규, DB 연결), `includes/answers-data.php`(신규, DB 조회/저장
  함수 모음), `includes/auth.php`(신규, 관리자 세션 헬퍼), `includes/mask.php`(신규,
  목록에서 이름 가리기)
- `actions/inquiry-submit.php`(신규, 홈 문의 폼 제출 처리)
- `answers/index.php`, `answers/view.php`(신규, 공개 게시판)
- `admin/login.php`, `admin/logout.php`, `admin/index.php`, `admin/view.php`,
  `admin/setup.php`(신규, 관리자 전용)
- `index.php`(문의 폼에 비밀번호 필드 추가 + 실제 POST로 제출되도록 변경),
  `assets/js/app.js`(가짜 `alert()` 제출 방지 코드 제거),
  `includes/header.php`/`includes/footer.php`(nav·footer에 "답변" 링크 추가,
  footer "관리자 로그인" 링크를 실제 주소로 연결), `includes/lang.php`(답변
  게시판/관리자 관련 번역 키 대량 추가), `assets/css/app.css`(`.answer-list`,
  `.badge--pending`/`--answered`, `.answer-detail__label` 등), `.gitignore`(신규,
  `data/` 제외 목록)

### 운영 배포 전 꼭 해야 할 일 (아직 안 함)

1. **외부 DB 준비.** Render 무료 플랜은 파일이 배포/재시작마다 초기화되기 때문에,
   SQLite처럼 컨테이너 안에 파일로 저장하는 방식은 운영에서 못 쓴다. 무료
   Postgres(예: Supabase)에 가입하고 프로젝트를 만들면 연결 문자열(`postgres://...`)이
   나온다.
2. **Render에 `DATABASE_URL` 환경변수 등록.** 이 연결 문자열은 비밀번호가 포함되어
   있어서 코드나 GitHub(공개 저장소)에 절대 넣으면 안 된다 — **Josh님이 Render
   대시보드(Environment 탭)에 직접 입력**하는 걸 추천. (Claude가 이 값을 대신
   입력하는 건 보안상 하지 않기로 함.)
3. 배포되면 위 "첫 관리자 계정 만들기" 순서대로 `/admin/setup.php`에서 계정 생성.
4. (선택, 나중에) 새 문의 왔을 때 관리자에게 이메일로 알림 — 아직 안 만들었음.

## GitHub 업로드 이력 (2026-08-14 완료)

> 아래 목록은 2026-08-14에 GitHub 웹 드래그앤드롭으로 `main` 브랜치에 전부
> 업로드 완료됐고, Render가 자동 배포했다. 어떤 파일들이 이 시점에 한꺼번에
> 나갔는지 기록 목적으로 남겨둔다 (`.gitignore`는 이때 같이 못 올라감 — Finder에서
> 숨김 파일이라 빠졌음, 다음 업로드 때 같이 챙길 것).

- **자료실 탭 신규 추가**: `includes/resources.php`(신규), `config.php`
  (`resources.php` require 추가), `index.php`, `includes/services.php`,
  `includes/lang.php`, `assets/css/app.css`
- **문의하기 탭 제거 + 버튼 이름 변경**: `includes/services.php`,
  `includes/header.php`, `includes/lang.php`
- **상세페이지 9개 다크 배경 통일**: `includes/header.php`, `assets/css/app.css`,
  `architecture/aerial-survey/index.php`, `architecture/construction/index.php`,
  `architecture/design/index.php`, `design/graphic/index.php`,
  `design/video/index.php`, `solutions/apps/index.php`,
  `solutions/automation/index.php`, `solutions/consulting/index.php`,
  `solutions/website/index.php`
- **답변 게시판 + 관리자 페이지**: `includes/db.php`(신규),
  `includes/answers-data.php`(신규), `includes/auth.php`(신규),
  `includes/mask.php`(신규), `actions/inquiry-submit.php`(신규),
  `answers/index.php`(신규), `answers/view.php`(신규), `admin/login.php`(신규),
  `admin/logout.php`(신규), `admin/index.php`(신규), `admin/view.php`(신규),
  `admin/setup.php`(신규), `.gitignore`(신규), `index.php`, `assets/js/app.js`,
  `includes/header.php`, `includes/footer.php`, `includes/lang.php`,
  `assets/css/app.css` — **⚠️ 이건 GitHub에 올리는 것 외에 DB 연결(Render
  `DATABASE_URL` 환경변수)까지 끝나야 실제로 동작함. 위 "답변 게시판" 섹션의
  "운영 배포 전 꼭 해야 할 일" 참고.**

정리하면: `includes/header.php`, `includes/services.php`, `includes/lang.php`,
`assets/css/app.css`, `index.php`, `config.php`, `includes/resources.php`(신규),
`assets/js/app.js`, `.gitignore`(신규), 9개 상세페이지 전부, 그리고 답변
게시판/관리자 관련 신규 파일 12개(`includes/db.php`, `includes/answers-data.php`,
`includes/auth.php`, `includes/mask.php`, `actions/inquiry-submit.php`,
`answers/index.php`, `answers/view.php`, `admin/login.php`, `admin/logout.php`,
`admin/index.php`, `admin/view.php`, `admin/setup.php`)가 GitHub 업로드 대상이다.

## ERP(견적서·계약서 자동 작성) — 계획 단계, 아직 착수 안 함 (2026-08-14 기록)

> **상태: 설계만 논의했고 코드는 하나도 안 만들었다.** 사용자가 "지금 작업할
> 건 아니고, 나중에 'ERP 진행'이라고 말하면 이 내용 기억했다가 시작하자"고
> 명시적으로 요청함 — 다음에 이 얘기가 나오면 여기부터 바로 시작할 것.

### 사용자가 원하는 것 (요청 원문 요약)

관리자 페이지에 견적서·계약서 양식을 저장해두고, 화면에서 **항목/상세/단가/수량만
입력하면 나머지(공급자 정보, 합계, 서식 등)가 자동으로 채워진** 문서가 만들어지는
시스템. "출력" 또는 "PDF 출력"하면 엑셀 또는 PDF로 파일 저장하거나, 지정한
이메일로 보낼 수 있으면 좋겠다는 것.

### 확정된 결정 (질문해서 답 받음)

- **위치**: 완전히 새 프로젝트가 아니라 **지금의 `/admin` 관리자 페이지에 기능
  추가**로 진행 (로그인·DB를 그대로 재사용).
- **PDF 방식**: 브라우저 인쇄가 아니라 **서버에서 실제 PDF 파일을 생성**하는
  방식 원함 (버튼 누르면 PDF가 바로 만들어짐).
- **발송 방식**: 아직 확정 안 함, 진행하면서 바뀔 수 있음. 이메일 발송(Resend 등
  외부 서비스 필요) 대신 **생성된 파일을 자료실이나 답변 게시판에 올려서
  고객이 거기서 받아가게 하는 방식**도 좋은 대안으로 언급함.
- **범위**: 견적서·계약서 **둘 다 결국 만들 것**. 어느 걸 먼저 할지는 아직
  안 정함 — 착수 시점에 다시 논의.

### Claude의 의견/추천 (사용자에게 이미 전달함, 착수 시 이 방향으로 시작)

- **데이터 구조**: 문의(`inquiries`)와는 별도 테이블로. 문의에서 시작 안 한
  견적서도 있을 수 있어서다. 대신 `linked_inquiry_id`처럼 선택적으로 문의와
  연결은 해둔다. 제안하는 테이블: `quotes`(견적서 헤더: 견적번호, 고객정보,
  발행일, 유효기간, 상태, linked_inquiry_id) + `quote_items`(항목/상세/단가/
  수량/소계, quotes에 FK). 계약서는 견적서를 승인받은 뒤 그 내용으로 만드는
  흐름을 추천 — `contracts` 테이블이 `quote_id`를 참조하는 구조. 즉 실제 업무
  흐름은 **문의 → 견적서 → (고객 승인) → 계약서**.
- **PDF 라이브러리**: `dompdf` 추천. 별도 외부 프로그램(wkhtmltopdf 같은 바이너리)
  설치 없이 PHP 안에서 HTML→PDF 변환이 되고, Composer로 설치 가능. 단, 이 프로젝트는
  지금까지 `composer.json`이 아예 없는 "의존성 0개" 구조였어서, ERP 착수 시점에
  **Composer를 처음 도입**하고 `Dockerfile`에 `composer install` 단계를 추가해야
  한다 — 이 프로젝트의 첫 외부 패키지 의존성이 되는 것이니 신중하게.
- **생성된 PDF 파일을 서버에 저장하지 말 것**: Render 무료 플랜은 파일이
  배포/재시작마다 사라지므로, 완성된 PDF를 파일로 저장해두면 언젠가 없어진다.
  대신 **항목/단가/수량 등 원본 데이터만 DB에 저장**하고, 다운로드 요청이 올
  때마다 그 데이터로 PDF를 즉석에서 새로 렌더링해서 내려주는 방식을 강하게
  추천 — "파일이 사라지는" 문제 자체가 안 생김. (답변 게시판에 첨부하는
  경우도 마찬가지로, 실제 PDF 파일이 아니라 "이 견적서 데이터를 PDF로 보기"
  링크를 답변에 남기는 방식이 안전함.)
- **놓치면 안 되는 항목**: 한국 견적서/계약서는 보통 공급가액 + 부가세(10%) +
  합계 구조라, 항목 합계 계산에 부가세 처리가 필요함. 그리고 회사 정보(상호,
  사업자등록번호, 대표자명, 주소, 계좌번호, 로고 이미지)를 매번 입력하지 않고
  한 번만 등록해두면 모든 견적서/계약서에 자동으로 들어가는 "회사 설정" 화면이
  필요함 (아직 `admin_users`에도 이런 정보 저장할 곳이 없음 — 새 테이블 또는
  설정 테이블 필요).
- **계약서 관련**: 전자서명 기능은 요청받은 적 없음 — 서명란은 이미지/공백으로만
  두고, 출력해서 물리적으로 서명하거나 이미 갖고 있는 도장 이미지를 넣는 정도로
  충분해 보임. 나중에 전자서명이 필요하다고 하면 그때 별도로 설계.

### 착수 시 첫 단계 (체크리스트)

1. `composer.json` 생성 + `dompdf` 설치, `Dockerfile`에 `composer install` 단계 추가
2. DB 스키마 추가: `quotes`, `quote_items`, `contracts`(견적서 먼저 할지 합의 후),
   회사 정보 저장용 테이블/설정
3. `/admin/quotes/` 하위에 목록·작성·상세 화면 (항목 여러 개 동적 추가되는 표,
   단가×수량 자동 계산, 부가세 자동 계산)
4. PDF 렌더링 라우트 (`/admin/quotes/pdf.php?id=...` 형태로, 매번 DB에서 새로
   그려서 내려줌)
5. (범위 확정되면) 답변 게시판에 "이 문의에 대해 견적서 작성" 버튼 연결,
   또는 자료실에 올리는 방식 검토
6. (나중) 이메일 발송 — 그때 가서 Resend 등 서비스 선택

## 선형 아이콘 시스템 (2026-08-15 완료)

사용자 요청: "전체적으로 적용 돼 있는 아이콘을 선형 아이콘으로 만들어줘" —
사이트 전체에서 쓰던 이모지 아이콘(📐🏛️🚁📧 등)을 전부 Lucide 기반의
outline(선형) SVG 아이콘으로 교체했다.

### 구조

- **`includes/icons.php`** (신규) — `$ICON_PATHS` 배열(아이콘 이름 → SVG 내부
  `<path>` 마크업)과 `icon(string $name, array $opts = [])` 헬퍼 함수를 담은
  파일. `icon('ruler')`처럼 호출하면 `viewBox="0 0 24 24" fill="none"
  stroke="currentColor" stroke-width="2"` 스타일의 `<svg class="icon">...</svg>`
  문자열을 반환한다. 모르는 이름을 넘기면 레이아웃이 안 깨지도록 조용히 빈
  문자열(`''`)을 반환한다.
- **`config.php`**에서 `require_once __DIR__ . '/includes/icons.php';`로
  전역에서 `icon()`을 쓸 수 있게 불러온다 (services.php보다 먼저 로드해야
  `$NAV_SERVICES`/`$RESOURCE_CATEGORIES` 배열의 `'icon'` 키 값과 무관하게
  항상 사용 가능).
- 아이콘 출처: [Lucide](https://lucide.dev) (`lucide-static` npm 패키지,
  ISC 라이선스, 무료·상업적 사용 가능). 새 아이콘이 더 필요하면 lucide.dev에서
  이름을 찾은 뒤 해당 SVG의 `<path>`(등) 부분만 복사해서 `$ICON_PATHS`에
  한 줄 추가하면 된다.

### 아이콘 이름 값 저장 방식이 바뀐 곳

`includes/services.php`의 `$NAV_SERVICES`와 `includes/resources.php`의
`$RESOURCE_CATEGORIES` 배열의 `'icon'` 키 값이 **이모지 문자열**에서
**Lucide 아이콘 이름 문자열**(예: `'ruler'`, `'smartphone'`)로 바뀌었다.
렌더링하는 곳(`index.php`)도 `<?= $item['icon'] ?>` (이모지 그대로 출력)에서
`<?= icon($item['icon']) ?>` (이름으로 SVG 조회해서 출력)로 바뀌었다.
새 서비스/자료실 카테고리를 추가할 때는 이제 이모지가 아니라
`includes/icons.php`의 `$ICON_PATHS` 키 이름을 넣어야 한다.

### 적용된 범위

- 상단 탭(건축/디자인/솔루션) 카드 아이콘 (`includes/services.php`)
- 자료실 카테고리 아이콘 (`includes/resources.php`)
- 9개 상세 페이지 전부: 히어로 제목 옆 아이콘(`$detailIcon`, `includes/
  detail-hero.php`에서 `<span class="detail-hero__icon">`으로 감싸서 렌더링),
  카드형 아이콘(`card__icon`), 프로세스 단계 아이콘(`process-step__icon`),
  자동화 기능 아이콘(`automation__feature-icon`)
- 홈(`index.php`): 회사소개 pill 아이콘(👤💡💡🛡️), 문의하기 연락처 아이콘
  (📧📞📷🕘 → 새 `.contact-icon` 배지 스타일로 감쌈), 자료실 파일 다운로드
  화살표(⬇)
- 답변 게시판/관리자: 목록의 비밀글 자물쇠 아이콘(🔒), 빈 상태 말풍선
  아이콘(💬), 관리자 계정 생성 완료 체크 아이콘(✅)
- 네비게이션 언어 전환 버튼(데스크톱+모바일)의 지구본 아이콘(🌐)

### CSS 사이징 (`assets/css/app.css`)

이모지는 폰트 크기만으로 자동으로 크기가 잡혔지만, SVG는 명시적으로 크기를
지정해야 한다. 파일 맨 위(`* { box-sizing: border-box; }` 바로 다음)에 아이콘
전용 규칙 블록을 추가했다:

- `.icon` (기본값) — `width/height: 1em`으로 부모 글자 크기를 따라감 (텍스트
  옆에 자연스럽게 놓이는 경우, 예: pill/lock/lang 아이콘).
- 카드·배지형 아이콘(`.card__icon`, `.service-card__icon`,
  `.automation__feature-icon`, `.process-step__icon`, `.empty-state__icon`)은
  각 컨테이너 안의 `.icon`에 명시적 px 크기를 지정해서 예전 이모지와 비슷한
  시각적 비중을 맞췄다.
- 문의하기 연락처 아이콘은 새로 만든 `.contact-icon` 클래스(흰 배경 40px
  둥근 배지, 카드 아이콘과 통일된 톤)로 감쌌다 — `index.php`의 4개
  `contact__info-item` 안쪽 `div`에 `class="contact-icon"`을 추가함.
- 상세 페이지 히어로 제목의 아이콘은 `.detail-hero__icon`으로 `h1` 글자
  크기(`0.85em`)에 비례해서 반응형으로 커지도록 했다.

### 새 아이콘이 필요한 페이지를 추가/수정할 때

1. `https://lucide.dev`에서 원하는 아이콘 이름을 찾는다.
2. `includes/icons.php`의 `$ICON_PATHS` 배열에 `'이름' => '<path .../>...'`
   한 줄 추가 (SVG의 `<path>`/`<circle>`/`<rect>` 등 내부 마크업만 복사,
   `<svg>` 바깥 태그와 `<!-- @license -->` 주석은 제외).
3. 원하는 곳에서 `<?= icon('이름') ?>`으로 호출.
4. 카드·배지 안에 넣는 아이콘이면, 필요시 `assets/css/app.css`의 아이콘
   사이징 블록에 그 컨테이너 클래스용 `.icon` 크기 규칙을 추가.

### 검증 완료

`php -l`로 수정한 19개 PHP 파일 전부 문법 확인, 로컬 PHP 서버 + curl로 전체
페이지 200 응답과 아이콘 렌더링(빈 아이콘 컨테이너 없음) 확인, Playwright로
데스크톱(1440px)·모바일(390px) 스크린샷을 홈/9개 상세페이지/답변 게시판/
관리자 로그인에서 한글·영어 둘 다 촬영해서 육안 확인 완료. 맥으로 동기화
완료(2026-08-15). **GitHub 업로드는 아직 안 함** — 사용자가 다음에 배포를
요청하면 이번에 바뀐 21개 파일(`includes/icons.php`(신규),
`includes/detail-hero.php`, `includes/header.php`, `includes/services.php`,
`includes/resources.php`, `config.php`, `index.php`, 9개 상세페이지,
`answers/index.php`, `admin/index.php`, `admin/view.php`, `admin/setup.php`,
`assets/css/app.css`)를 함께 올려야 한다.

## 코드 정리 + 보안 강화 (2026-08-16 추가)

사용자가 "지저분한 코드 삭제 + 보완할 부분 보완 + 개발자 의도 파악해서 선 작업"을
요청해서 진행한 작업. **로컬에 git 저장소가 없어서(지금까지 GitHub 웹 업로드
방식만 써왔음) 이번 작업 전에 `git init` + 전체 스냅샷 커밋을 먼저 만들어
안전망으로 남겨뒀다** (`.git/`는 로컬 전용, GitHub와 무관 — 여전히 실제 배포는
기존 방식대로 변경 파일을 GitHub 웹에 드래그앤드롭하면 된다).

### 정리한 것

- **`_to_delete/`** (예전 부분 업데이트 zip 백업 여러 개, 이름 그대로 삭제 대상) —
  전부 삭제. 내용은 이미 현재 코드/이 문서에 다 반영되어 있었다.
- **`designs_dan_deploy/` 폴더 + `designs_dan_deploy.zip`** — 2026-08-14 오후
  시점의 스냅샷이라 답변 게시판/관리자/자료실/아이콘 시스템이 전부 빠진 오래된
  중복본이었다. 삭제하기 전에 이 안에만 있던 `Dockerfile`/`.dockerignore`를
  프로젝트 루트로 옮겼다 (아래 참고 — 지금까지 실제 프로젝트 루트에 Dockerfile이
  없었다, 이 스냅샷 폴더 안에만 있었음).
- **`.DS_Store` 전부 삭제** (맥 잡파일, 여러 폴더에 흩어져 있었음).

### Dockerfile을 프로젝트 루트로 복구 + 강화

`designs_dan_deploy/Dockerfile`을 루트로 옮기고, 다음을 추가했다:

- **`docker/php-production.ini`** — `display_errors Off`, `log_errors On`.
  기존엔 `php.ini`를 아예 안 넣어서 PHP 컴파일 기본값(대부분 On)이 그대로
  쓰이고 있었다 — DB 연결 실패 같은 예외가 나면 방문자에게 내부 경로/쿼리가
  그대로 노출될 수 있었다.
- **`docker/apache-security.conf`** — `/var/www/html/data/`(SQLite 폴백 위치)와
  `*.db`/`*.sqlite` 확장자를 Apache 레벨에서 통째로 막는다. `.htaccess`가
  아니라 이미지 안에 직접 넣은 이유: `.htaccess`는 `AllowOverride`가 꺼져있으면
  무시되는데, 이 베이스 이미지 기본 설정이 그렇다. **이게 지금까지 가장 심각한
  구멍이었다** — `DATABASE_URL`을 아직 안 넣은 상태(맞음, 지금 라이브 상태)라면
  `https://designs-dan.com/data/app.db`로 SQLite 파일이 그대로 다운로드
  가능했다(문의자 개인정보 + 비밀번호 해시 포함).
- `.dockerignore`에 `data/`, `imge/`, `_to_delete/` 추가.

### 코드 보안 개선 (전부 오늘 적용, 로컬에서 curl로 하나씩 실동작 확인함)

- **세션 쿠키 하드닝** (`includes/session-boot.php` 신규) — `HttpOnly` +
  `SameSite=Lax` + (https일 때만) `Secure`. `includes/auth.php`,
  `answers/view.php`가 이걸 쓰도록 바꿈.
- **로그인/비밀번호 브루트포스 방어** (`includes/rate-limit.php` 신규,
  `rate_limit_attempts` 테이블 신규 — `includes/db.php`의 `db_init_schema()`에
  추가돼서 다음 연결 때 자동 생성됨) — IP당 15분에 5번 틀리면 잠금.
  `admin/login.php`(관리자 로그인), `answers/view.php`(비공개 글 비밀번호,
  IP+글번호 기준이라 다른 글 보는 건 안 막힘)에 적용.
- **문의 폼 스팸 방지** — 화면엔 안 보이는 허니팟 필드(`website`) + 폼 로딩 후
  3초 안 제출 차단 (`index.php`의 `.hp-field`, `actions/inquiry-submit.php`).
  같은 IP에서 1시간에 8건 넘게 오면 추가로 막음(`inquiry_submit` rate limit).
  둘 다 봇에게 "막혔다"는 신호를 안 주려고 그냥 정상 리다이렉트만 해준다.
- **CSRF 토큰** (`includes/csrf.php` 신규) — 관리자 로그인, 관리자 답변 등록,
  관리자 최초 계정 생성(setup), 비공개 글 비밀번호 확인 — 상태를 바꾸는 폼
  전부에 적용.
- **`/admin/setup.php` 레이스 컨디션 방지** — Render 환경변수
  `ADMIN_SETUP_TOKEN`을 넣어두면 `?token=` 값이 정확히 맞아야만 이 페이지가
  동작한다. **아직 Render에 안 넣었다 — 넣는 걸 권장.** 안 넣으면 예전처럼
  토큰 없이 동작(로컬 개발 그대로 됨, 하위호환).
  - 넣는 법: Render 대시보드 → `designs_dan` 서비스 → Environment →
    `ADMIN_SETUP_TOKEN` = 아무 긴 랜덤 문자열. 그 다음
    `https://designs-dan.com/admin/setup.php?token=그값`으로 접속.
- **`session_regenerate_id(true)`** — 관리자 로그인 성공 시 세션ID를 새로
  발급 (세션 고정 공격 방지).

### 배포 시 참고

- 이번에 바뀐 파일이 많다 (신규: `Dockerfile`, `.dockerignore`,
  `docker/php-production.ini`, `docker/apache-security.conf`,
  `includes/session-boot.php`, `includes/rate-limit.php`, `includes/csrf.php`;
  수정: `includes/db.php`, `includes/auth.php`, `includes/lang.php`,
  `admin/login.php`, `admin/setup.php`, `admin/view.php`, `answers/view.php`,
  `actions/inquiry-submit.php`, `index.php`, `assets/css/app.css`). 아직
  GitHub에 안 올라감 — 2026-08-15의 아이콘 시스템 변경분(21개 파일)과
  같이 한 번에 올리는 걸 권장.
- **Dockerfile이 이번에 처음으로 GitHub에 올라가는 상황이라면** Render가
  기존 이미지 캐시를 못 쓰고 처음부터 다시 빌드할 수 있다 — 정상이다, 순수
  PHP라 빌드는 여전히 빠르다.
- `data/app.db`(로컬 SQLite)는 테스트 후 삭제해서 깨끗한 상태로 남겨뒀다.
  로컬에서 다시 켜면 `/admin/setup.php`부터 새로 진행하면 된다.

## 안정성 보강 — 에러 처리 / 404 / 파비콘 / 공유 미리보기 / 법적 고지 / SEO (2026-08-16 추가)

사용자가 "어떤 내용을 추가하면 더 안정적인 홈페이지가 될까?"라고 물어서, 실제로
없는 것들을 점검해 우선순위를 제시하고 **"내가 해야 하는 것만 남기고 전부 진행"**
지시를 받아 아래를 만들었다.

### 1) DB 예외 처리 (`includes/error-page.php` 신규)

**이 프로젝트에는 그동안 `try/catch`가 단 한 곳도 없었다.** DB가 잠깐 끊기면
방문자에게 흰 화면이 그대로 보이고, 특히 문의 폼을 제출하던 고객은 "보낸 건지
안 보낸 건지" 알 수 없는 상태였다.

- `renderErrorPage($httpStatus, $titleKey, $descKey)` — 사이트 디자인(다크 블루프린트)을
  유지한 안내 화면을 그린다. `renderDbErrorPage($e)`는 로그에 실제 원인을 남기고
  (`error_log` → 운영에서는 Render 로그에 보인다) 방문자에게는 내부 정보를 노출하지
  않는 안내만 보여준다.
- DB를 쓰는 페이지 전부에 적용: `answers/index.php`, `answers/view.php`,
  `admin/index.php`, `admin/view.php`, `admin/login.php`, `admin/setup.php`,
  `actions/inquiry-submit.php`.
- **중요한 패턴**: DB 조회는 **화면을 그리기 전에 모두 끝내야 한다.** `renderErrorPage`가
  헤더를 직접 그리므로, 헤더가 이미 출력된 뒤에 예외가 나면 에러 페이지를 제대로
  못 그린다. 그래서 `answers/view.php`는 예전에 본문 중간에서 하던
  `getRepliesFor()` 호출을 위쪽 `try` 블록으로 올렸다.
- **함정(실제로 겪음)**: `renderErrorPage`/`renderLegalPage`는 **함수**라서 전역
  `$LANG`·`$NAV_SERVICES`가 자동으로 안 보인다 → `global $LANG, $NAV_SERVICES;`를
  넣지 않으면 상단 네비가 안 그려지고 "Undefined variable $NAV_SERVICES" 경고가
  화면에 쏟아진다. 처음에 이걸 빼먹었다가 브라우저 확인 중 발견해서 고쳤다.
  **header.php/footer.php를 함수 안에서 부를 때는 이 두 전역을 항상 챙길 것.**
- 검증: 일부러 잘못된 `DATABASE_URL`로 서버를 띄워서 `/answers/`, `/answers/view.php`,
  `/admin/setup.php`, 문의 제출이 전부 **HTTP 503 + 안내 화면**을 주고 치명적 오류
  노출이 0건인 것을 확인했다.

### 2) 문의 폼 실패 안내 (`actions/inquiry-submit.php`)

예전엔 실패 시 전부 조용히 `/#contact`로 리다이렉트해서 고객이 실패를 알 수 없었다.
지금은 이유별로 안내 화면을 보여준다 — 필수값 누락(400), 대량 제출 차단(400),
저장 실패(503, 대체 연락처 안내 포함). 허니팟/타이밍에 걸린 **봇에게만** 예전처럼
조용히 리다이렉트한다(막혔다는 신호를 주지 않기 위해).

### 3) 관리자 "답변 대기 N" 배지 (`admin/index.php`)

새 문의가 와도 목록을 훑어야 알 수 있었는데, 로그인 직후 제목 옆에 대기 건수가
배지로 뜬다. **이메일 알림은 아직 없다** — 아래 "남은 것" 참고.

### 4) 404 페이지 (`404.php` 신규)

없는 주소로 들어오면 Apache 기본 에러 화면 대신 사이트 디자인이 유지된 안내가 뜬다.
`docker/apache-security.conf`에 `ErrorDocument 404 /404.php` 추가.
**로컬 `php -S`는 ErrorDocument를 지원하지 않으므로** 확인할 때는 `/404.php`로 직접
접속하면 된다(HTTP 404를 정상적으로 반환한다).

### 5) 파비콘 (`assets/images/favicon.svg` 신규)

브랜드 톤(다크 배경 + 금색)에 맞춘 "D" 모노그램 + 옅은 블루프린트 격자. 순수 SVG라
저작권 이슈 없음. `header.php`에 `rel="icon"` + `apple-touch-icon`으로 연결.

### 6) 카카오톡·SNS 공유 미리보기 (`includes/header.php`)

**예전엔 `og:` 태그가 0개라, 링크를 카톡으로 보내면 제목·설명·이미지 없이 맹링크로만
떴다.** `og:type/site_name/locale/title/description/url/image` + `twitter:card` 계열 +
`canonical`을 추가했다.

- **이미지는 반드시 절대 URL**이어야 한다(카톡·페이스북은 상대경로를 못 읽음) →
  `$_SERVER['HTTP_HOST']`와 프로토콜로 origin을 만들어 붙인다. Render는 프록시 뒤에
  있으므로 `HTTP_X_FORWARDED_PROTO`도 함께 본다.
- **페이지별 대표 이미지**: `header.php`를 부르기 전에 `$ogImage`에 `asset()` 상대경로를
  넣으면 그 이미지가 쓰인다. 9개 상세 페이지에는 각자 카드 사진을 지정해뒀다
  (예: 건축>설계 → `images/architecture-design.jpg`). 지정 안 하면 기본값은
  `images/about-main.jpg`.
- `$pageDescription`에 `&amp;`나 `<strong>`이 섞여 있을 수 있어서 meta description과
  똑같이 `strip_tags` + `html_entity_decode`를 거친 뒤 다시 이스케이프한다
  (이중 인코딩 방지 — lang.php 주석 참고).

### 7) 개인정보처리방침 / 이용약관 (`privacy/`, `terms/`, `includes/legal-page.php` 신규)

풋터 링크가 `href="#"`(죽은 링크)였다. **문의 폼으로 이름·이메일·전화번호를 수집하고
있으니 개인정보처리방침은 사실상 필수**라서 실제 페이지로 만들었다.

- 두 페이지가 "제목 + 개정일 + (소제목 + 본문) × N" 구조로 같아서
  `renderLegalPage($keyPrefix, $sectionCount)` 하나로 묶었다.
- 문구는 `lang.php`의 `legal.privacy.*` / `legal.terms.*` 키에 한/영 양쪽으로 있다.
  항목을 추가하려면 `.s6.title`/`.s6.body`를 양쪽 언어에 넣고 호출의 개수만 6으로 올린다.
- **내용은 이 사이트가 실제로 하는 동작에 맞춰 썼다** (수집 항목, 비밀번호를 해시로만
  저장, 답변 게시판에 이름만 일부 가려 노출하고 연락처는 비공개 등). 법률 검토를 받은
  문서는 아니므로, 정식으로 필요하면 전문가 확인을 받는 게 좋다.
- 이 페이지들은 카드 상세 페이지와 달리 `$isDetailFit`을 **안 쓴다** — 고지문은 길고
  더 늘어날 수 있어서 자연스럽게 스크롤되는 게 맞다.

### 8) robots.txt / sitemap.xml (`robots.txt`, `sitemap.php` 신규)

- `robots.txt`: 전체 허용 + `/admin/`, `/actions/`, `/data/` 차단 + sitemap 위치 안내.
- `sitemap.php`: **정적 파일로 두면 페이지 추가 때마다 손으로 고쳐야 하고 빠뜨리기
  쉬워서**, `includes/services.php`의 `$NAV_SERVICES`를 읽어 자동 생성한다 — 새 상세
  페이지를 services.php에 추가하면 sitemap에도 자동 반영된다. 한/영을 `xhtml:link
  hreflang`으로 서로 alternate로 알려준다. 현재 13개 URL 출력.
- 관례적인 주소로도 접속되도록 `docker/apache-security.conf`에
  `Alias /sitemap.xml /var/www/html/sitemap.php`를 넣었다(mod_alias는 Debian Apache
  기본 활성). **로컬 `php -S`는 Alias를 지원하지 않으니** 로컬 확인은 `/sitemap.php`로.

### 검증 (2026-08-16)

`php -l` 전체 통과, CSS 중괄호 짝 확인, 로컬 서버로 전 경로 상태코드 확인
(`/`·`/privacy/`·`/terms/`·`/sitemap.php`·`/robots.txt` 200, `/404.php` 404,
`/graphic-design/` 301 유지), sitemap XML 파싱 성공(13 URL), og:image가 페이지별로
다르게 나오는지 확인, 문의 폼 정상 제출 + 필수값 누락 안내 + DB 장애 503 안내 확인,
관리자 계정 생성→로그인→"답변 대기 1" 배지 확인, **9개 카드 상세 페이지가 여전히
1440×900 한 화면에 들어가는지 재확인(회귀 없음)**, 개인정보처리방침/이용약관/404를
데스크톱·모바일·한/영으로 스크린샷 확인.

### 남은 것 — Josh님이 직접 하셔야 하는 것

1. **`DATABASE_URL` 설정 (★ 가장 중요, 계속 미해결)** — Render 대시보드 →
   `designs_dan` → Environment. 지금은 문의가 컨테이너 임시 파일에 저장돼서
   **재배포/재시작마다 사라진다.** 무료 Postgres(Supabase 등) 연결 문자열 필요.
   비밀번호가 포함된 값이라 Claude가 대신 입력하지 않는다.
2. **`ADMIN_SETUP_TOKEN` 설정 (권장)** — 같은 Environment 탭. 첫 관리자 계정 생성
   페이지를 아무나 먼저 못 쓰게 막는 토큰.
3. **새 문의 이메일 알림** — 코드로 넣으려면 외부 발송 서비스(Resend/SendGrid 등)
   계정과 API 키가 필요하다. 어떤 서비스를 쓸지 정해주시면 이어서 붙일 수 있다.
   지금은 `/admin/`에 들어가면 대기 건수가 보이는 것까지만 되어 있다.
4. **GitHub 업로드** — 이번 변경분 + 2026-08-15 아이콘 시스템 + 보안 강화분이
   아직 전부 로컬에만 있다.

## 관리자 화면 숨기기 — 풋터 링크 제거 + `/admin` 진입 (2026-08-18 추가)

사용자 요청: "관리자 로그인 페이지는 숨겨줘 / 풋터 아래 관리자 로그인 글씨는 삭제 /
관리자가 `/admin`이라고 주소창에 입력했을 때 로그인 페이지 열리도록."

- **풋터 링크 삭제**: `includes/footer.php`의 `.footer__legal`에서 관리자 로그인
  `<a>`를 제거했다. 이제 풋터 우측 하단에는 개인정보처리방침·이용약관 둘만 남는다.
  안 쓰게 된 번역 키 `footer.staff_login`도 한/영 양쪽에서 삭제했다
  (`includes/lang.php` — 예전에 `nav.email_inquiry`를 지운 것과 같은 정리 방식).
- **`/admin` 진입은 추가 작업이 필요 없었다**: `admin/index.php`가 이미
  `requireAdminLogin()`으로 로그인 안 된 상태면 `login.php`로 보내주기 때문에,
  `/admin` → (Apache `mod_dir`이 `/admin/`으로 301) → `DirectoryIndex`가
  `index.php` 실행 → 로그인 화면으로 302 흐름이 그대로 동작한다. 로컬 `php -S`에서도
  `/admin`, `/admin/`, `/admin/index.php` 세 형태 모두 `/admin/login.php`로
  리다이렉트되는 것을 확인했다.
- **검색엔진 노출 차단 추가**: `header.php`에 `$isNoIndex` 플래그를 만들고
  `admin/index.php`·`login.php`·`view.php`·`setup.php` 4개에 `$isNoIndex = true;`를
  넣어 `<meta name="robots" content="noindex,nofollow">`가 붙게 했다.
  `robots.txt`에서 `/admin/`을 이미 막아뒀지만, robots.txt는 "크롤링하지 말라"는
  요청일 뿐이라 어딘가에 주소가 노출되면 색인될 수 있어서 meta로 한 번 더 막는다.
  **관리자 화면 외에는 붙지 않는다**(홈·개인정보처리방침·답변 게시판 모두 0건 확인).
- **주의**: "숨김"은 어디까지나 *링크를 노출하지 않는다*는 뜻이고, 주소를 아는 사람은
  누구나 로그인 화면에 도달할 수 있다. 실제 보호는 로그인 자체
  (비밀번호 해시 + 5회 실패 시 15분 잠금 + CSRF 토큰, 위 보안 섹션 참고)가 담당한다.
- 검증: `php -l` 전체 통과, 홈/상세/개인정보/답변 페이지에서 "관리자 로그인"·"Staff
  Login" 문자열 0건 확인(한/영 양쪽), `/admin` 리다이렉트 추적으로 최종 주소가
  `/admin/login.php`(HTTP 200, 로그인 폼)인 것 확인, noindex가 관리자 4개 화면에만
  붙은 것 확인, 브라우저 스크린샷으로 풋터·로그인 화면 육안 확인.

## 배포 전 용량 최적화 (2026-08-18 추가)

사용자가 "내일 호스팅을 업데이트할 거야, 용량을 최적화하고 지저분한 내용 정리해줘"
라고 요청 — 실제 배포 대상 용량을 점검하고 최적화했다.

### 1) 이미지 재압축 — 1.6MB → 1.0MB (36% 감소)

`assets/images/`의 카드/배너 사진 10장이 전부 **실제 화면 표시 크기보다 훨씬 큰
해상도**로 저장되어 있었다. 예: 카드 사진(`.service-card__photo img`)은 CSS에서
`height: 168px`, 가장 넓은 카드도 폭 ~580px밖에 안 되는데, 원본은 1341~1400px
폭이었다 — 2배(레티나) 감안해도 2~3배 오버스펙.

- **카드 전용 사진(솔루션 4장 + 그래픽/영상 2장)**: 긴 변 기준 최대 900px로
  리사이즈, JPEG 품질 80.
- **건축 3장(카드 + 상세페이지 배너 겸용)**: 배너가 더 크게 쓰이므로 덜 줄임 —
  최대 1300px, 품질 80.
- **about-main.jpg**: 최대 1100px, 품질 82.
- 전부 Python Pillow로 리사이즈 + `optimize=True, progressive=True` JPEG 재인코딩.
- **검증**: 데스크톱(1440px)·홈 솔루션 카드(가장 많이 줄인 이미지)·건축 상세
  배너를 스크린샷으로 육안 확인 — 압축 흔적이나 화질 저하 없음.
- 원본은 이번 세션 스크래치패드에 백업해뒀다(세션 종료 시 사라짐) — 혹시 마음에
  안 들면 이 대화 중에 말씀해주시면 되돌릴 수 있다.

### 2) 죽은 CSS 제거 — 937줄 → 889줄

`app.css`의 모든 클래스 셀렉터를 PHP/JS 전체와 대조해서 **실제로 안 쓰이는 것**만
골라 지웠다(사용 중인 클래스는 절대 안 건드림):

- `.hero`/`.hero__inner` 전체 블록 — 2026-08-12 오전 이전(탭+카드 구조로 바뀌기 전)
  단일 페이지 히어로의 잔재.
- `.media-placeholder`(+ `.panel--brand-bg` 안의 오버라이드) — 회사소개 실사진이
  들어오기 전 "사진 준비중" 안내 박스, 실사진으로 교체되며 죽음.
- `.gd-cta`/`.gd-hero`(+ `.page-detail-fit` 오버라이드) — 그래픽 디자인 페이지의
  예전 CTA 박스, 지금은 다른 페이지들과 같은 `.detail-cta` 버튼 패턴으로 통일됨.
- `.section-head--split`, `.section--tight`, `.nav__mobile-group`,
  `.btn--outline-dark`, `.footer__soon` — 한 번도 실제로 안 쓰인 유틸리티 클래스들.
- **검증**: 제거 후 같은 방식으로 다시 스캔해서 실제 사용 중인 클래스는 전부
  남아있는지 확인, `php -l` 전체 통과, 중괄호 짝 확인, 그래픽 페이지(`.gd-step`
  사용)와 모바일 메뉴를 스크린샷으로 재확인 — 시각적 변화 없음.
- `includes/icons.php`의 아이콘 47개도 전부 대조해봤는데 안 쓰는 게 하나도 없어서
  그대로 뒀다.

### 3) `imge/` 원본 폴더(25MB) 배포 대상에서 제외

`imge/`는 카드 사진을 만들기 전 AI로 생성한 원본 PNG 백업(나중에 다시 자를 때
참고용, CLAUDE.md의 "건축·디자인·솔루션 탭 실사진 삽입" 섹션 참고)이라 **사이트에는
전혀 필요 없다.** 지금까지 `.dockerignore`에는 있었지만(그래서 라이브 사이트에는
원래도 안 들어갔음) **`.gitignore`에는 빠져 있어서** 로컬 안전망 git 저장소에
25MB가 그대로 딸려있었다. `.gitignore`에 추가하고 `git rm -r --cached imge/`로
추적만 해제했다(디스크의 실제 파일은 그대로 남아있음, `git status`로 확인 가능).
**내일 GitHub에 파일을 올릴 때 `imge/` 폴더는 드래그하지 않아도 된다** — 이미
`.dockerignore`로 막혀 있어서 실수로 올라가도 라이브 이미지에는 안 들어가지만,
GitHub 저장소 용량만 불필요하게 커진다.

### 최종 결과

| 항목 | 이전 | 이후 |
|---|---|---|
| `assets/images/` | 1.6MB | 1.0MB |
| `app.css` | 937줄 | 889줄 |
| 실제 배포 대상 전체 (git·imge·data 제외) | ~2.1MB | **1.5MB** |
| `imge/` 로컬 git 추적 | 25MB 추적됨 | 추적 해제(디스크엔 그대로) |

### 내일 GitHub 업로드 시 참고

- **올려야 하는 것**: `imge/`, `data/`, `.git` 폴더를 뺀 나머지 전부. 지금까지
  누적된 변경분(2026-08-15 아이콘 시스템부터 오늘 용량 최적화까지)이 전부 아직
  GitHub에 안 올라가 있다 — 8/16~8/18 사이 작업한 파일 전부 포함해서 올려야 한다.
- **안 올려도(오히려 안 올리는 게 나은) 것**: `imge/`(원본 백업, 25MB),
  `data/`(로컬 SQLite, 어차피 `.gitignore`에 있어서 커밋 화면에 안 보일 것),
  `CLAUDE.md`(공개 저장소에 굳이 필요 없는 내부 작업 기록 — 이미 `.dockerignore`로
  라이브 사이트에서는 막혀있지만, 올리고 싶지 않으면 그냥 빼면 된다).
