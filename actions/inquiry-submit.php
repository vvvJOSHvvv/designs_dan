<?php
/**
 * 홈 화면 문의하기 폼(#contact)의 실제 제출 처리 (2026-08-14 추가).
 * index.php의 <form id="contactForm" method="post" action="<?= url('/actions/inquiry-submit.php') ?>">
 * 에서 POST로 넘어온다. 처리 후 답변 게시판의 방금 쓴 글로 이동시킨다.
 */
require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/answers-data.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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
    header('Location: ' . url('/#contact'));
    exit;
}

$id = createInquiry([
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'inquiry_type' => $inquiryType,
    'message' => $message,
    'password' => $password,
    'lang' => $LANG,
]);

// $LANG은 쿠키에 저장되어 있으므로 주소에 굳이 다시 안 붙여도 다음 페이지에서 유지된다.
header('Location: ' . url('/answers/view.php?id=' . $id . '&submitted=1'));
exit;
