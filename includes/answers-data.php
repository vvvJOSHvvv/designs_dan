<?php
/**
 * 답변 게시판 데이터 접근 함수 모음 (2026-08-14 추가)
 * includes/db.php의 db() 함수 위에서 동작합니다. 이 파일을 쓰려는 페이지는
 * require __DIR__ . '/../includes/db.php'; 와
 * require __DIR__ . '/../includes/answers-data.php'; 를 둘 다 불러와야 합니다.
 */

/** 문의글 하나 생성. 비밀번호가 있으면 해시해서 저장(is_locked 여부는 password_hash 유무로 판단). */
function createInquiry(array $data): int
{
    $pdo = db();
    $passwordHash = null;
    if (!empty($data['password'])) {
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
    }
    $stmt = $pdo->prepare(
        'INSERT INTO inquiries (name, email, phone, inquiry_type, message, password_hash, lang, status)
         VALUES (:name, :email, :phone, :inquiry_type, :message, :password_hash, :lang, \'pending\')'
    );
    $stmt->execute([
        ':name' => $data['name'],
        ':email' => $data['email'],
        ':phone' => $data['phone'] ?? '',
        ':inquiry_type' => $data['inquiry_type'] ?? '',
        ':message' => $data['message'],
        ':password_hash' => $passwordHash,
        ':lang' => $data['lang'] ?? 'ko',
    ]);
    return (int) $pdo->lastInsertId();
}

/** 목록용 — 비밀번호 해시는 안 주고, 잠겨있는지 여부(is_locked)만 boolean으로 내려준다. */
function listInquiries(): array
{
    $pdo = db();
    $rows = $pdo->query('SELECT * FROM inquiries ORDER BY id DESC')->fetchAll();
    foreach ($rows as &$row) {
        $row['is_locked'] = !empty($row['password_hash']);
        unset($row['password_hash']);
    }
    return $rows;
}

function getInquiry(int $id): ?array
{
    $pdo = db();
    $stmt = $pdo->prepare('SELECT * FROM inquiries WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    if (!$row) {
        return null;
    }
    $row['is_locked'] = !empty($row['password_hash']);
    return $row;
}

function verifyInquiryPassword(array $inquiry, string $password): bool
{
    if (empty($inquiry['password_hash'])) {
        return true; // 애초에 비밀글이 아니면 항상 통과
    }
    return password_verify($password, $inquiry['password_hash']);
}

function getRepliesFor(int $inquiryId): array
{
    $pdo = db();
    $stmt = $pdo->prepare('SELECT * FROM inquiry_replies WHERE inquiry_id = :id ORDER BY id ASC');
    $stmt->execute([':id' => $inquiryId]);
    return $stmt->fetchAll();
}

function addReply(int $inquiryId, string $adminUsername, string $replyMessage, string $quoteText = ''): void
{
    $pdo = db();
    $stmt = $pdo->prepare(
        'INSERT INTO inquiry_replies (inquiry_id, admin_username, reply_message, quote_text)
         VALUES (:inquiry_id, :admin_username, :reply_message, :quote_text)'
    );
    $stmt->execute([
        ':inquiry_id' => $inquiryId,
        ':admin_username' => $adminUsername,
        ':reply_message' => $replyMessage,
        ':quote_text' => $quoteText !== '' ? $quoteText : null,
    ]);
    $update = $pdo->prepare("UPDATE inquiries SET status = 'answered' WHERE id = :id");
    $update->execute([':id' => $inquiryId]);
}

/** admin_users에 계정이 하나도 없을 때만 true (부트스트랩 화면 admin/setup.php에서 사용) */
function hasAnyAdminUser(): bool
{
    $pdo = db();
    $count = (int) $pdo->query('SELECT COUNT(*) AS c FROM admin_users')->fetch()['c'];
    return $count > 0;
}

function createAdminUser(string $username, string $password): void
{
    $pdo = db();
    $stmt = $pdo->prepare('INSERT INTO admin_users (username, password_hash) VALUES (:username, :password_hash)');
    $stmt->execute([
        ':username' => $username,
        ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
    ]);
}

function findAdminByUsername(string $username): ?array
{
    $pdo = db();
    $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE username = :username');
    $stmt->execute([':username' => $username]);
    $row = $stmt->fetch();
    return $row ?: null;
}
