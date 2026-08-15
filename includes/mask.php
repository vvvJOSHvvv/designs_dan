<?php
/**
 * 답변 게시판 목록에서 이름을 살짝 가려서 보여주는 헬퍼 (2026-08-14 추가).
 * 예: "홍길동" → "홍**", "Josh" → "J***". 한글도 안전하게 처리하려고 mb_* 함수 사용.
 */
function maskName(string $name): string
{
    $name = trim($name);
    $len = mb_strlen($name);
    if ($len <= 1) {
        return $name === '' ? '' : $name;
    }
    return mb_substr($name, 0, 1) . str_repeat('*', min($len - 1, 4));
}
