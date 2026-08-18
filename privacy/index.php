<?php
/**
 * 개인정보처리방침 (2026-08-16 추가).
 * 문의 폼에서 이름·이메일·전화번호를 수집하고 있으므로 사실상 필수 페이지다.
 * 실제 문구는 includes/lang.php의 'legal.privacy.*' 키에 한/영 양쪽으로 들어있고,
 * 화면 구성은 includes/legal-page.php가 담당한다 (이용약관과 공용).
 */
require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/legal-page.php';

renderLegalPage('legal.privacy', 5);
