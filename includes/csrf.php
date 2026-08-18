<?php
/**
 * CSRF 토큰 헬퍼 (2026-08-16 추가).
 * 세션이 이미 시작되어 있어야 한다(includes/session-boot.php의 startAppSession() 호출 후).
 *
 * 폼에는: <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
 * 처리 쪽에서는: if (!csrfCheck($_POST['csrf_token'] ?? '')) { ...거부... }
 */

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfCheck(string $submitted): bool
{
    if (empty($_SESSION['csrf_token']) || $submitted === '') {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $submitted);
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrfToken()) . '">';
}
