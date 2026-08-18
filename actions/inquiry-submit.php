<?php
/**
 * 홈 화면 문의하기 폼(#contact)의 실제 제출 처리 (2026-08-14 추가).
 * index.php의 <form id="contactForm" method="post" action="<?= url('/actions/inquiry-submit.php') ?>">
 * 에서 POST로 넘어온다. 처리 후 답변 게시판의 방금 쓴 글로 이동시킨다.
 */
require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/answers-data.php';
require __DIR__ . '/../includes/rate-limit.php';
require __DIR__ . '/../includes/error-page.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . url('/#contact'));
    exit;
}

// 2026-08-16: 예전엔 실패 시 전부 조용히 /#contact로 돌려보내서, 고객이 "보낸 건지
// 안 보낸 건지" 알 수 없었다 — 실패 이유를 화면으로 알려준다.
$failWith = function (string $descKey): void {
    renderErrorPage(400, 'error.form.title', $descKey);
    exit;
};

// 대량 자동 제출 방지: 같은 IP에서 1시간에 8건 넘게 오면 더 안 받는다
// (정상적인 고객이 짧은 시간에 이만큼 문의를 새로 쓸 일은 거의 없다).
try {
    $rateLimited = tooManyAttempts('inquiry_submit', clientIp(), 8, 3600);
} catch (Throwable $e) {
    renderDbErrorPage($e);
}
if ($rateLimited) {
    $failWith('error.form.rate');
}

// 스팸봇 방지 (2026-08-16 추가, index.php의 #contactForm 참고):
//   1) 허니팟(website) 필드가 채워져 있으면 봇 — 성공한 척 리다이렉트만 해주고 저장은 안 한다
//      (봇에게 "막혔다"는 신호를 주지 않아야 재시도/우회를 덜 시도한다).
//   2) 폼이 열리고 3초도 안 지나 제출됐으면(초고속 자동 제출) 같은 방식으로 무시한다.
if (trim($_POST['website'] ?? '') !== '') {
    header('Location: ' . url('/#contact'));
    exit;
}
$formTs = (int) ($_POST['form_ts'] ?? 0);
if ($formTs > 0 && (time() - $formTs) < 3) {
    header('Location: ' . url('/#contact'));
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$inquiryType = trim($_POST['inquiry_type'] ?? '');
$message = trim($_POST['message'] ?? '');
$password = trim($_POST['password'] ?? '');

// 최소한의 서버측 검증 (HTML required만 믿지 않음)
if ($name === '' || $email === '' || $message === '') {
    $failWith('error.form.required');
}

try {
    recordFailedAttempt('inquiry_submit', clientIp()); // 성공 여부와 무관하게 "1시간 8건" 카운트에 반영

    $id = createInquiry([
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'inquiry_type' => $inquiryType,
        'message' => $message,
        'password' => $password,
        'lang' => $LANG,
    ]);
} catch (Throwable $e) {
    // 저장 실패 — 고객에게 "전송되지 않았다"고 명확히 알려주고 대체 연락처를 안내한다.
    // (여기서 조용히 홈으로 돌려보내면 고객은 보냈다고 착각하고 답변을 기다리게 된다.)
    error_log('[DESIGN DAN] inquiry save failed: ' . $e->getMessage());
    renderErrorPage(503, 'error.form.title', 'error.form.save');
    exit;
}

// $LANG은 쿠키에 저장되어 있으므로 주소에 굳이 다시 안 붙여도 다음 페이지에서 유지된다.
header('Location: ' . url('/answers/view.php?id=' . $id . '&submitted=1'));
exit;
