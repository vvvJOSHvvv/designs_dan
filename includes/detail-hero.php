<?php
/**
 * 상세 페이지 공통 상단(뒤로가기 + 제목 + 소개문). 9개 상세 페이지가 전부 이걸 씁니다.
 *
 * 이 파일을 불러오기 전에 설정할 변수:
 *   $detailParentSlug (필수) — 부모 탭 slug ('architecture' | 'design' | 'solutions')
 *   $detailTitleKey   (필수) — 제목 번역 키
 *   $detailIntroKey   (선택) — 소개문 번역 키
 *   $detailIcon       (선택) — 선형 아이콘 이름 (includes/icons.php의 $ICON_PATHS 키, 예: 'ruler')
 *   $detailPhoto      (선택) — 실사진 배너 경로 (asset() 함수에 넘길 상대경로, 예: 'assets/images/architecture-design.jpg')
 *   $detailPhotoAlt   (선택) — 위 사진의 alt 텍스트. $detailPhoto가 있으면 채워주는 게 좋음
 */
$parentTab = findNavTab($detailParentSlug);
?>
<section class="detail-hero">
    <div class="container">
        <a class="detail-back" href="<?= url('/') ?>#<?= htmlspecialchars($detailParentSlug) ?>">
            <?= te('detail.back') ?>
        </a>
        <p class="eyebrow"><?= $parentTab ? te($parentTab['label_key']) : '' ?></p>
        <h1><?= !empty($detailIcon) ? '<span class="detail-hero__icon">' . icon($detailIcon) . '</span> ' : '' ?><?= te($detailTitleKey) ?></h1>
        <?php if (!empty($detailIntroKey)): ?>
            <p class="detail-hero__intro"><?= te($detailIntroKey) ?></p>
        <?php endif; ?>
        <?php if (!empty($detailPhoto)): ?>
            <div class="detail-hero__photo">
                <img src="<?= asset($detailPhoto) ?>" alt="<?= htmlspecialchars($detailPhotoAlt ?? '') ?>" loading="lazy">
            </div>
        <?php endif; ?>
    </div>
</section>
