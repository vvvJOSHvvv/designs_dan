<?php
/**
 * sitemap.xml 생성 (2026-08-16 추가).
 *
 * 정적 파일로 두면 페이지를 추가할 때마다 손으로 고쳐야 하고 빠뜨리기 쉬워서,
 * includes/services.php의 $NAV_SERVICES 배열을 그대로 읽어서 자동 생성한다 —
 * 새 카테고리/상세 페이지를 services.php에 추가하면 sitemap에도 자동으로 들어간다.
 *
 * 운영에서는 docker/apache-security.conf의 Alias 덕분에 관례적인 주소인
 * https://designs-dan.com/sitemap.xml 로 접속된다. 로컬 php -S 개발 서버는 Alias를
 * 지원하지 않으므로 /sitemap.php 로 직접 확인하면 된다.
 */
require __DIR__ . '/config.php';

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https' ? 'https' : 'http';
$origin = $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'designs-dan.com');

// 홈은 탭이 해시(#architecture 등)로 구분되므로 URL은 하나뿐이다 — 해시는 검색엔진이
// 별도 페이지로 보지 않으니 홈은 한 줄만 넣는다.
$urls = [
    ['loc' => '/', 'priority' => '1.0', 'freq' => 'monthly'],
];

// 건축/디자인/솔루션 하위 카드 = 실제 상세 페이지 9개
foreach ($NAV_SERVICES as $tab) {
    foreach ($tab['items'] as $item) {
        if (!empty($item['href'])) {
            $urls[] = ['loc' => $item['href'], 'priority' => '0.8', 'freq' => 'monthly'];
        }
    }
}

$urls[] = ['loc' => '/answers/', 'priority' => '0.5', 'freq' => 'weekly'];
$urls[] = ['loc' => '/privacy/', 'priority' => '0.3', 'freq' => 'yearly'];
$urls[] = ['loc' => '/terms/',   'priority' => '0.3', 'freq' => 'yearly'];

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($urls as $u): ?>
<?php $abs = $origin . url($u['loc']); ?>
    <url>
        <loc><?= htmlspecialchars($abs, ENT_XML1) ?></loc>
        <?php /* 한/영 두 버전이 같은 주소에 ?lang= 으로 있으므로 서로를 alternate로 알려준다 */ ?>
        <xhtml:link rel="alternate" hreflang="en" href="<?= htmlspecialchars($abs . '?lang=en', ENT_XML1) ?>"/>
        <xhtml:link rel="alternate" hreflang="ko" href="<?= htmlspecialchars($abs . '?lang=ko', ENT_XML1) ?>"/>
        <changefreq><?= $u['freq'] ?></changefreq>
        <priority><?= $u['priority'] ?></priority>
    </url>
<?php endforeach; ?>
</urlset>
