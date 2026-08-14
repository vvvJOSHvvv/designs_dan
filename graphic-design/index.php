<?php
/**
 * 2026-08-12 구조 개편으로 이 페이지는 /design/graphic/ 으로 옮겨졌습니다.
 * 예전 주소로 들어오는 사람(북마크 등)을 위해 새 주소로 그대로 보내줍니다.
 */
require __DIR__ . '/../config.php';
header('Location: ' . url('/design/graphic/'), true, 301);
exit;
