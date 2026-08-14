<?php

// 이 사이트(Design_dan)의 기준 주소를 항상 같은 값으로 계산합니다.
// (하위 폴더에 있는 페이지에서 불러와도 항상 문서 루트 기준 절대경로가 나오도록,
//  현재 페이지 경로가 아니라 config.php 자신의 위치 기준으로 계산합니다.)
// pdcebu 프로젝트와 동일한 패턴입니다 — 여러 프로젝트를 한 서버에 같이 올려도
// 항상 자기 자신의 경로를 정확히 계산합니다.
$documentRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? __DIR__), '/');
$configDir = str_replace('\\', '/', __DIR__);
define('BASE_URL', rtrim(str_replace($documentRoot, '', $configDir), '/'));

function asset(string $path): string
{
    $cleanPath = trim($path, '/');
    $segments = array_map('rawurlencode', explode('/', $cleanPath));
    $url = BASE_URL . '/assets/' . implode('/', $segments);

    // 파일이 수정될 때마다 주소 끝에 ?v=수정시각 을 붙여서,
    // 브라우저가 예전 캐시된 파일을 계속 쓰지 않고 새 버전을 받아오게 합니다.
    $fullPath = __DIR__ . '/assets/' . $cleanPath;
    if (is_file($fullPath)) {
        $url .= '?v=' . filemtime($fullPath);
    }

    return $url;
}

function url(string $path = ''): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

// 한/영 전환 (t()/te() 헬퍼가 여기서 나옵니다 — 아래 services.php보다 먼저 불러와야 함)
require_once __DIR__ . '/includes/lang.php';

// 서비스 카테고리 & 네비게이션 데이터 (상단 드롭다운 메뉴가 여기서 나옵니다)
require_once __DIR__ . '/includes/services.php';
