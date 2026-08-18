<?php
/**
 * 로그인/비밀번호 확인 무차별 대입(brute force) 방어 (2026-08-16 추가).
 * includes/db.php의 rate_limit_attempts 테이블을 씁니다. 이 파일을 쓰려는 페이지는
 * db.php를 먼저 require해야 합니다.
 *
 * 쓰는 법 (admin/login.php, answers/view.php 참고):
 *   $id = clientIp() . ':' . $inquiryId;  // scope별로 식별자를 원하는 대로 조합
 *   if (tooManyAttempts('answer_unlock', $id)) { ...잠금 안내... }
 *   elseif (!password_verify(...)) { recordFailedAttempt('answer_unlock', $id); ...틀림 안내... }
 *   else { clearAttempts('answer_unlock', $id); ...성공... }
 */

/** Render 등 프록시 뒤에서도 실제 클라이언트 IP를 최대한 알아낸다. */
function clientIp(): string
{
    $forwarded = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
    if ($forwarded !== '') {
        // "client, proxy1, proxy2" 형태 — 맨 앞이 원래 클라이언트
        return trim(explode(',', $forwarded)[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

/** 최근 $windowSeconds 안에 $maxAttempts번 넘게 실패했으면 true (더 이상 시도 못 하게). */
function tooManyAttempts(string $scope, string $identifier, int $maxAttempts = 5, int $windowSeconds = 900): bool
{
    $pdo = db();
    // created_at은 두 드라이버 모두 UTC 'YYYY-MM-DD HH:MM:SS' 형태로 저장되므로
    // PHP에서 계산한 UTC 컷오프 문자열과 그대로 문자열 비교가 가능하다.
    $cutoff = gmdate('Y-m-d H:i:s', time() - $windowSeconds);

    // 창(window) 밖으로 나간 오래된 기록은 이 김에 정리한다 (테이블이 무한정 안 커지게).
    $cleanup = $pdo->prepare(
        'DELETE FROM rate_limit_attempts WHERE scope = :scope AND identifier = :identifier AND created_at < :cutoff'
    );
    $cleanup->execute([':scope' => $scope, ':identifier' => $identifier, ':cutoff' => $cutoff]);

    $stmt = $pdo->prepare(
        'SELECT COUNT(*) AS c FROM rate_limit_attempts WHERE scope = :scope AND identifier = :identifier AND created_at >= :cutoff'
    );
    $stmt->execute([':scope' => $scope, ':identifier' => $identifier, ':cutoff' => $cutoff]);
    return (int) $stmt->fetch()['c'] >= $maxAttempts;
}

function recordFailedAttempt(string $scope, string $identifier): void
{
    $pdo = db();
    $stmt = $pdo->prepare('INSERT INTO rate_limit_attempts (scope, identifier) VALUES (:scope, :identifier)');
    $stmt->execute([':scope' => $scope, ':identifier' => $identifier]);
}

function clearAttempts(string $scope, string $identifier): void
{
    $pdo = db();
    $stmt = $pdo->prepare('DELETE FROM rate_limit_attempts WHERE scope = :scope AND identifier = :identifier');
    $stmt->execute([':scope' => $scope, ':identifier' => $identifier]);
}
