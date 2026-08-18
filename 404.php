<?php
/**
 * 404 페이지 (2026-08-16 추가).
 * Apache의 ErrorDocument로 연결되어 있어서(docker/apache-security.conf 참고),
 * 없는 주소로 들어오면 Apache 기본 에러 화면 대신 이 페이지가 사이트 디자인 그대로
 * 보인다. 로컬 php -S 개발 서버는 ErrorDocument를 지원하지 않으므로 이 파일에
 * 직접 접속(/404.php)해서 확인하면 된다.
 */
require __DIR__ . '/config.php';
require __DIR__ . '/includes/error-page.php';

renderErrorPage(404, 'error.404.title', 'error.404.desc');
