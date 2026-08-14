<?php
require __DIR__ . '/../../config.php';
$pageTitle = t('card.solutions.apps.title') . ' | DESIGN DAN';
$pageDescription = t('detail.solutions.apps.intro');
$activeNav = 'solutions';
require __DIR__ . '/../../includes/header.php';

$detailParentSlug = 'solutions';
$detailTitleKey   = 'card.solutions.apps.title';
$detailIntroKey   = 'detail.solutions.apps.intro';
$detailIcon       = '📱';
?>
<main>
<?php require __DIR__ . '/../../includes/detail-hero.php'; ?>

<section class="section">
    <div class="container">

        <?php
        /**
         * 여기에 배포한 앱을 하나씩 추가하면 카드가 자동으로 생깁니다.
         * "그룹통화" 앱이 Render에 올라가면, 아래처럼 $apps 배열에 한 줄 추가하면 끝입니다.
         * (그 다음부터는 이 배열이 비어있지 않으니 자동으로 "준비 중" 문구 대신 카드가 보입니다.)
         *
         * $apps[] = [
         *     'icon'    => '🎙️',                          // 카드에 보일 이모지 아이콘
         *     'name_en' => 'Group Call',                    // 영어 이름
         *     'name_ko' => '그룹통화',                       // 한글 이름
         *     'desc_en' => 'Voice group calling app.',       // 영어 한 줄 설명
         *     'desc_ko' => '음성 그룹 통화 앱입니다.',         // 한글 한 줄 설명
         *     'url'     => 'https://group-call.onrender.com', // Render에 배포된 실제 주소
         *     'status'  => 'live',                           // 'live' = 바로 실행 가능, 'soon' = 준비중 배지만 표시
         * ];
         */
        $apps = [];
        ?>

        <?php if (empty($apps)): ?>
            <div class="empty-state">
                <div class="empty-state__icon">📱</div>
                <h3><?= te('detail.solutions.apps.empty_title') ?></h3>
                <p><?= te('detail.solutions.apps.empty_desc') ?></p>
            </div>
        <?php else: ?>
            <div class="card-grid card-grid--3">
                <?php foreach ($apps as $app): ?>
                    <?php
                    $name   = $LANG === 'ko' ? $app['name_ko'] : $app['name_en'];
                    $desc   = $LANG === 'ko' ? $app['desc_ko'] : $app['desc_en'];
                    $isSoon = ($app['status'] ?? 'live') === 'soon';
                    ?>
                    <a class="card app-card<?= $isSoon ? ' app-card--soon' : '' ?>"
                       href="<?= $isSoon ? '#' : htmlspecialchars($app['url']) ?>"
                       <?= $isSoon ? 'aria-disabled="true" onclick="return false;"' : 'target="_blank" rel="noopener"' ?>>
                        <div class="card__icon"><?= htmlspecialchars($app['icon']) ?></div>
                        <h3><?= htmlspecialchars($name) ?></h3>
                        <p><?= htmlspecialchars($desc) ?></p>
                        <?php if ($isSoon): ?>
                            <span class="badge badge--soon"><?= te('badge.soon') ?></span>
                        <?php else: ?>
                            <span class="service-card__cta"><?= $LANG === 'ko' ? '앱 실행하기' : 'Open App' ?> →</span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

</main>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
