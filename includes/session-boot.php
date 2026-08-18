<?php
/**
 * 세션을 안전한 쿠키 옵션으로 시작하는 공용 헬퍼 (2026-08-16 추가).
 * 예전엔 includes/auth.php와 answers/view.php가 각자 옵션 없이
 * session_start()만 불렀는데, 그러면 PHP 기본값(HttpOnly/SameSite 미설정)이
 * 그대로 쓰여서 세션 쿠키가 자바스크립트에서 읽히거나 크로스사이트 요청에
 * 그대로 실려나갈 수 있었다. 이 파일을 쓰는 곳은 전부 session_start() 대신
 * startAppSession()을 호출해야 한다.
 */
function startAppSession(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'; // Render는 프록시 뒤에서 이 헤더로 알려준다

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $isHttps, // 로컬 http 개발 서버에서는 꺼지고, 운영(https)에서는 켜짐
        'httponly' => true,     // 자바스크립트(document.cookie)에서 세션 쿠키를 못 읽게
        'samesite' => 'Lax',    // 다른 사이트에서 걸어온 링크로도 로그인 상태 유지는 되지만, 크로스사이트 POST엔 안 실림
    ]);
    session_start();
}
