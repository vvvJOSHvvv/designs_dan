<?php
/**
 * 관리자 로그인 세션 헬퍼 (2026-08-14 추가)
 * 이 파일을 쓰는 페이지는 db.php / answers-data.php보다 먼저(또는 같이) 불러오면 됩니다.
 * PHP 세션을 쓰므로, 이 파일을 불러오기 전에 다른 곳에서 output이 먼저 나가면 안 됩니다
 * (session_start()는 HTTP 헤더가 나가기 전에 호출되어야 함) — admin/*.php 맨 위에서만 사용.
 */

require_once __DIR__ . '/session-boot.php';
startAppSession();

function isAdminLoggedIn(): bool
{
    return !empty($_SESSION['admin_username']);
}

function currentAdminUsername(): string
{
    return $_SESSION['admin_username'] ?? '';
}

/** 로그인 안 되어 있으면 로그인 페이지로 보내고 스크립트 종료. admin/*.php 맨 위에서 호출. */
function requireAdminLogin(): void
{
    if (!isAdminLoggedIn()) {
        header('Location: ' . url('/admin/login.php'));
        exit;
    }
}
