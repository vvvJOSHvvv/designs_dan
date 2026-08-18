<?php
/**
 * 이용약관 (2026-08-16 추가).
 * 실제 문구는 includes/lang.php의 'legal.terms.*' 키에 한/영 양쪽으로 들어있고,
 * 화면 구성은 includes/legal-page.php가 담당한다 (개인정보처리방침과 공용).
 */
require __DIR__ . '/../config.php';
require __DIR__ . '/../includes/legal-page.php';

renderLegalPage('legal.terms', 5);
