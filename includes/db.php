<?php
/**
 * DB 연결 (2026-08-14 추가 — 답변 게시판/문의 저장용)
 *
 * 운영(Render): 환경변수 DATABASE_URL 에 Postgres 연결 문자열을 넣으면 그걸 씁니다.
 *   예: postgres://user:pass@host:5432/dbname
 *   (Render 무료 플랜은 파일이 배포/재시작마다 초기화되기 때문에, 문의 데이터를
 *   컨테이너 안 파일(SQLite 등)에 저장하면 안 됩니다 — 반드시 외부 DB 필요.
 *   추천: Supabase 무료 Postgres. 연결 문자열은 Render 대시보드의 환경변수에
 *   Josh님이 직접 입력하는 걸 추천합니다 — 코드/GitHub에는 절대 넣지 않습니다.)
 *
 * 로컬 개발/테스트: DATABASE_URL이 없으면 프로젝트 폴더 안의 data/app.db
 *   (SQLite 파일)를 자동으로 만들어서 씁니다. 스키마(테이블)는 두 경우 모두
 *   최초 연결 시 자동으로 생성됩니다 (없으면 만들고, 있으면 그대로 둠).
 *
 * data/ 폴더는 .gitignore에 등록해서 로컬 SQLite 파일이 실수로 GitHub(공개
 * 저장소)에 올라가지 않도록 합니다.
 */

function db(): PDO
{
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $databaseUrl = getenv('DATABASE_URL') ?: '';

    if ($databaseUrl !== '') {
        // postgres://user:pass@host:port/dbname 형태 파싱
        $parts = parse_url($databaseUrl);
        $host = $parts['host'] ?? 'localhost';
        $port = $parts['port'] ?? 5432;
        $dbname = isset($parts['path']) ? ltrim($parts['path'], '/') : '';
        $user = $parts['user'] ?? '';
        $pass = $parts['pass'] ?? '';
        $sslmode = 'require'; // Supabase 등 대부분의 외부 Postgres는 SSL 필요

        $dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode={$sslmode}";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        db_init_schema($pdo, 'pgsql');
        return $pdo;
    }

    // --- 로컬 개발용 SQLite 폴백 ---
    $dataDir = __DIR__ . '/../data';
    if (!is_dir($dataDir)) {
        mkdir($dataDir, 0775, true);
    }
    $dbFile = $dataDir . '/app.db';
    $pdo = new PDO('sqlite:' . $dbFile, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $pdo->exec('PRAGMA foreign_keys = ON');
    db_init_schema($pdo, 'sqlite');
    return $pdo;
}

function db_init_schema(PDO $pdo, string $driver): void
{
    static $checked = false;
    if ($checked) {
        return; // 요청 하나당 한 번만 확인 (매번 CREATE TABLE IF NOT EXISTS 날릴 필요 없음)
    }
    $checked = true;

    if ($driver === 'pgsql') {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS admin_users (
                id SERIAL PRIMARY KEY,
                username TEXT UNIQUE NOT NULL,
                password_hash TEXT NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT NOW()
            );
            CREATE TABLE IF NOT EXISTS inquiries (
                id SERIAL PRIMARY KEY,
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                phone TEXT,
                inquiry_type TEXT,
                message TEXT NOT NULL,
                password_hash TEXT,
                lang TEXT NOT NULL DEFAULT 'ko',
                status TEXT NOT NULL DEFAULT 'pending',
                created_at TIMESTAMP NOT NULL DEFAULT NOW()
            );
            CREATE TABLE IF NOT EXISTS inquiry_replies (
                id SERIAL PRIMARY KEY,
                inquiry_id INTEGER NOT NULL REFERENCES inquiries(id) ON DELETE CASCADE,
                admin_username TEXT NOT NULL,
                reply_message TEXT NOT NULL,
                quote_text TEXT,
                created_at TIMESTAMP NOT NULL DEFAULT NOW()
            );
        ");
    } else {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS admin_users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                password_hash TEXT NOT NULL,
                created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS inquiries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                phone TEXT,
                inquiry_type TEXT,
                message TEXT NOT NULL,
                password_hash TEXT,
                lang TEXT NOT NULL DEFAULT 'ko',
                status TEXT NOT NULL DEFAULT 'pending',
                created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS inquiry_replies (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                inquiry_id INTEGER NOT NULL REFERENCES inquiries(id) ON DELETE CASCADE,
                admin_username TEXT NOT NULL,
                reply_message TEXT NOT NULL,
                quote_text TEXT,
                created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }
}
