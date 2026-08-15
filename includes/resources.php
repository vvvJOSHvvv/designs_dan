<?php

/**
 * 자료실(자료 다운로드) 카테고리 데이터 (2026-08-14 추가)
 *
 * 도면, 어플, 명함, 인쇄용 이미지 등 DESIGN DAN이 작업해서 고객에게 전달해야 하는
 * 파일들을 모아두는 곳입니다. solutions/apps/index.php 의 $apps 배열과 똑같은
 * 패턴이라, 지금은 카테고리 틀만 만들어두고 실제 파일은 나중에 채웁니다.
 *
 * 파일을 추가하려면:
 *   1. assets/resources/ 폴더(없으면 새로 생성)에 실제 파일을 넣는다.
 *   2. 아래 해당 카테고리의 'files' 배열에 한 줄 추가:
 *      ['name_en' => 'Floor Plan v2', 'name_ko' => '평면도 v2', 'file' => 'floor-plan-v2.pdf']
 *   -> 파일이 하나라도 생기면 "준비중" 배지 대신 자동으로 다운로드 목록이 표시됩니다.
 *
 * 새 카테고리를 추가하려면 이 배열에 항목을 하나 더 추가하고, 필요하면 index.php의
 * card-grid--3 을 다른 개수로 바꿔주면 됩니다.
 */

$RESOURCE_CATEGORIES = [
    [
        'icon'    => '📐',
        'name_en' => 'Drawings',
        'name_ko' => '도면',
        'desc_en' => 'Floor plans, elevations, and construction drawings.',
        'desc_ko' => '평면도, 입면도, 시공 도면 등',
        'files'   => [],
    ],
    [
        'icon'    => '📱',
        'name_en' => 'Apps',
        'name_ko' => '어플',
        'desc_en' => 'Files and assets related to apps we built for you.',
        'desc_ko' => '제작해 드린 앱 관련 파일',
        'files'   => [],
    ],
    [
        'icon'    => '🪪',
        'name_en' => 'Business Cards',
        'name_ko' => '명함',
        'desc_en' => 'Print-ready business card files.',
        'desc_ko' => '인쇄용 명함 파일',
        'files'   => [],
    ],
    [
        'icon'    => '🖼️',
        'name_en' => 'Print Images',
        'name_ko' => '인쇄 이미지',
        'desc_en' => 'Flyers, posters, and other print-ready images.',
        'desc_ko' => '전단지, 포스터 등 인쇄용 이미지',
        'files'   => [],
    ],
    [
        'icon'    => '📁',
        'name_en' => 'Other Files',
        'name_ko' => '기타 자료',
        'desc_en' => 'Any other materials prepared for you.',
        'desc_ko' => '그 외 전달해 드릴 자료',
        'files'   => [],
    ],
];
