<?php
/**
 * 한/영 전환
 *
 * - 주소 끝에 ?lang=ko 또는 ?lang=en 을 붙이면 그 언어로 보여주고, 쿠키에 저장해서
 *   다음 페이지 이동에서도 같은 언어가 유지됩니다.
 * - 아무 것도 없으면 쿠키를 보고, 쿠키도 없으면 기본값(영어)을 씁니다.
 * - 텍스트를 새로 추가/수정할 땐 아래 $TRANSLATIONS 배열의 'en'/'ko' 양쪽에 같은 키로
 *   넣어주면 됩니다. 페이지에서는 te('키') 로 출력합니다.
 */

const SITE_LANGS = ['en', 'ko'];
const SITE_DEFAULT_LANG = 'en';

$LANG = SITE_DEFAULT_LANG;
if (isset($_GET['lang']) && in_array($_GET['lang'], SITE_LANGS, true)) {
    $LANG = $_GET['lang'];
    if (!headers_sent()) {
        setcookie('site_lang', $LANG, time() + 60 * 60 * 24 * 365, '/');
    }
} elseif (isset($_COOKIE['site_lang']) && in_array($_COOKIE['site_lang'], SITE_LANGS, true)) {
    $LANG = $_COOKIE['site_lang'];
}

function langSwitchUrl(string $targetLang): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    return $path . '?lang=' . $targetLang;
}

function otherLang(string $lang): string
{
    return $lang === 'ko' ? 'en' : 'ko';
}

function t(string $key): string
{
    global $TRANSLATIONS, $LANG;
    return $TRANSLATIONS[$LANG][$key] ?? $TRANSLATIONS['en'][$key] ?? $key;
}

function te(string $key): string
{
    return t($key);
}

$TRANSLATIONS = [
    'en' => [
        // ---- 상단 탭 (5개) ----
        'nav.about'        => 'About Us',
        'nav.architecture' => 'Architecture',
        'nav.design'       => 'Design',
        'nav.solutions'    => 'Solutions',
        'nav.contact'      => 'Contact',
        'nav.email_inquiry' => 'Email Inquiry',
        'nav.lang_switch_label' => 'KO',
        'badge.soon' => 'Coming Soon',

        // ---- 홈 상단(탭 바 위, 아주 짧게) ----
        'home.eyebrow' => 'DESIGN DAN',
        'home.title'   => 'Beyond Spaces, We Design Value',

        // ---- 건축 탭 ----
        'tab.architecture.eyebrow' => 'ARCHITECTURE',
        'tab.architecture.title'   => 'Architecture',
        'tab.architecture.intro'   => 'From design to survey to construction — the full architecture process, together.',
        'card.architecture.design.title'       => 'Design',
        'card.architecture.design.teaser'      => 'Residential, commercial &amp; public building design',
        'card.architecture.aerial.title'       => 'Aerial Survey',
        'card.architecture.aerial.teaser'      => 'Drone photography &amp; 3D site survey',
        'card.architecture.construction.title' => 'Construction',
        'card.architecture.construction.teaser'=> 'End-to-end construction management',

        // ---- 디자인 탭 ----
        'tab.design.eyebrow' => 'DESIGN',
        'tab.design.title'   => 'Design',
        'tab.design.intro'   => 'Visual work that completes your brand and your space.',
        'card.design.graphic.title'  => 'Graphic &amp; Commercial',
        'card.design.graphic.teaser' => 'Business cards, flyers, posters &amp; commercial print',
        'card.design.video.title'    => 'Video',
        'card.design.video.teaser'   => 'Promotional &amp; on-site video production',

        // ---- 솔루션 탭 ----
        'tab.solutions.eyebrow' => 'SOLUTIONS',
        'tab.solutions.title'   => 'Solutions',
        'tab.solutions.intro'   => 'Strategy and tools to grow your business.',
        'card.solutions.consulting.title'  => 'Consulting',
        'card.solutions.consulting.teaser' => 'Business registration to HR &amp; finance',
        'card.solutions.automation.title'  => 'Business Automation',
        'card.solutions.automation.teaser' => 'Custom automation software',
        'card.solutions.website.title'     => 'Website',
        'card.solutions.website.teaser'    => 'Websites that showcase your business',
        'card.solutions.apps.title'        => 'Apps',
        'card.solutions.apps.teaser'       => 'Apps we&rsquo;ve built &amp; deployed',

        // ---- 카드/상세페이지 공통 ----
        'card.view_details' => 'View Details',
        'detail.back'        => '← Back to list',
        'cta.contact'        => 'Get in Touch',

        // ---- About (회사소개 패널) ----
        'about.eyebrow' => 'ABOUT US',
        'about.title1'  => "Beyond Spaces,",
        'about.title2'  => "We Elevate Life's Value",
        'about.p1' => "DESIGN DAN is a professional architectural design firm based in Cebu, Philippines. We bring our clients' visions to life across residential, commercial, and public projects — creating spaces that go far beyond mere buildings, where people and space exist in harmony to elevate the value of everyday life.",
        'about.p2' => 'At the core of architectural design, we offer a full spectrum of expert services — architecture, drone survey, graphic &amp; video design, business consulting, automation software, and website development. Everything your project needs, all in one place.',
        'about.pill.client'    => 'Client-First',
        'about.pill.expertise' => 'Expertise',
        'about.pill.innovation'=> 'Innovation',
        'about.pill.trust'     => 'Trust',
        'about.cta' => 'Start a Project',
        'about.media_placeholder' => 'Team / on-site photo goes here<br>(will be replaced once available)',
        'about.media_alt' => 'A modern residential project designed by DESIGN DAN',

        // ---- 건축 > 설계 ----
        'detail.architecture.design.title' => 'Design',
        'detail.architecture.design.intro' => 'We provide professional design services across every stage, from initial concept to final completion.',
        'arch.card1.title' => 'Architectural Design',
        'arch.card1.desc'  => 'We handle the entire process from planning to construction documents for residential, commercial, and public buildings, proposing optimal spatial solutions.',
        'arch.card1.tag1' => 'Residential', 'arch.card1.tag2' => 'Commercial', 'arch.card1.tag3' => 'Public Facilities',
        'arch.card2.title' => 'Interior Design',
        'arch.card2.desc'  => 'We create interior designs that satisfy both functionality and aesthetics, reflecting brand identity and user experience.',
        'arch.card2.tag1' => 'Commercial Interior', 'arch.card2.tag2' => 'Residential Interior', 'arch.card2.tag3' => 'Renovation',

        // ---- 건축 > 항공측량 ----
        'detail.architecture.aerial.title' => 'Aerial Survey',
        'detail.architecture.aerial.intro' => 'Accurate site data is the foundation of good design. We capture your site precisely with drone photography and 3D scanning.',
        'detail.architecture.aerial.f1.title' => 'Drone Aerial Photography',
        'detail.architecture.aerial.f1.desc'  => 'High-resolution aerial photos and video of the site and surrounding area.',
        'detail.architecture.aerial.f2.title' => '3D Topographic Survey',
        'detail.architecture.aerial.f2.desc'  => 'Precise 3D terrain data used as the basis for design and planning.',
        'detail.architecture.aerial.f3.title' => 'Site Data Report',
        'detail.architecture.aerial.f3.desc'  => 'Clear, organized survey reports handed over to your design and engineering team.',

        // ---- 건축 > 시공 (기존 Project Process 재사용) ----
        'detail.architecture.construction.title' => 'Construction',
        'detail.architecture.construction.intro' => 'We realize your vision through a systematic 4-step process.',
        'process1.step1.title' => 'Planning &amp; Consultation',
        'process1.step1.desc'  => 'We carefully analyze client requirements, budget, and schedule to jointly set the project direction and goals.',
        'process1.step2.title' => 'Design &amp; Development',
        'process1.step2.desc'  => 'We create phased drawings from schematic to construction documents, communicating closely with clients to achieve perfection.',
        'process1.step3.title' => 'Construction Management',
        'process1.step3.desc'  => 'We take responsibility for integrated management of quality, schedule, and cost to ensure design intent is perfectly realized.',
        'process1.step4.title' => 'Completion &amp; Handover',
        'process1.step4.desc'  => 'After final quality inspection, we hand over the space and provide ongoing after-service support.',
        'process1.footnote' => 'Project Duration <strong>1 Month ~ 36 Months</strong> · Dedicated PM · Weekly Progress Reports',
        'process1.cta' => 'Request Consultation',

        // ---- 디자인 > 그래픽 & 상업 ----
        'gd.hero_desc'  => 'From business cards to flyers, stickers, posters, and promotional products — we provide design to print, all in one place.',
        'gd.card1.title' => 'Printed in Korea',
        'gd.card1.desc'  => 'We bring printed materials made in Korea directly to our customers.',
        'gd.card2.title' => 'Fast &amp; Reliable',
        'gd.card2.desc'  => 'High-quality printing and fast delivery guaranteed.',
        'gd.projects_title' => 'Projects',
        'gd.projects_desc'  => 'Explore the diverse graphic design projects created by DESIGN DAN.',
        'gd.tag1' => 'Business Card', 'gd.tag2' => 'Flyer', 'gd.tag3' => 'Sticker', 'gd.tag4' => 'Poster', 'gd.tag5' => 'Promotional Products',
        'gd.process.eyebrow' => 'PRODUCTION PROCESS',
        'gd.process.title'   => 'Simple 4-Step Flow',
        'gd.step1.title' => 'Consultation &amp; Briefing',
        'gd.step1.desc'  => 'We discuss your preferred design style, purpose, and quantity.',
        'gd.step2.title' => 'Draft Creation',
        'gd.step2.desc'  => 'We propose 2-3 design drafts tailored to your brand.',
        'gd.step3.title' => 'Revision &amp; Finalization',
        'gd.step3.desc'  => 'Unlimited revisions based on feedback, then final confirmation.',
        'gd.step4.title' => 'Print &amp; Delivery',
        'gd.step4.desc'  => 'High-quality printing delivered within 3-5 days or file handover.',

        // ---- 디자인 > 영상 ----
        'detail.design.video.title' => 'Video',
        'detail.design.video.intro' => 'From brand promo videos to on-site construction documentation, we produce video that tells your story.',
        'detail.design.video.f1.title' => 'Promotional Video',
        'detail.design.video.f1.desc'  => 'Short-form video for social media, ads, and brand storytelling.',
        'detail.design.video.f2.title' => 'Site Documentation',
        'detail.design.video.f2.desc'  => 'Progress and completion footage for construction &amp; renovation projects.',
        'detail.design.video.f3.title' => 'Aerial Drone Footage',
        'detail.design.video.f3.desc'  => 'Cinematic drone video, produced together with our Aerial Survey team.',

        // ---- 솔루션 > 컨설팅 ----
        'consult.intro'   => 'From startup to stabilization, our experienced consultants design and execute every stage of your business journey.',
        'consult.c1.title' => 'Business Registration &amp; Incorporation',
        'consult.c1.desc'  => 'We guide you through sole proprietorship and corporate registration, business permits, tax office filings, and license acquisition — one-stop support for all startup admin.',
        'consult.c1.tag1' => 'Business Registration', 'consult.c1.tag2' => 'Incorporation', 'consult.c1.tag3' => 'License Acquisition',
        'consult.c2.title' => 'Advertising &amp; Marketing Strategy',
        'consult.c2.desc'  => 'From selecting online and offline ad channels to content planning, SNS management, and brand identity — we build marketing strategies that reach your target customers.',
        'consult.c2.tag1' => 'SNS Marketing', 'consult.c2.tag2' => 'Ad Management', 'consult.c2.tag3' => 'Brand Strategy',
        'consult.c3.title' => 'Procurement &amp; Supply Chain',
        'consult.c3.desc'  => 'We identify suppliers, negotiate purchasing terms, and build inventory management systems to design a cost-efficient procurement process.',
        'consult.c3.tag1' => 'Supplier Sourcing', 'consult.c3.tag2' => 'Purchase Negotiation', 'consult.c3.tag3' => 'Inventory Management',
        'consult.c4.title' => 'Company Policy &amp; System Setup',
        'consult.c4.desc'  => 'We systematically establish internal regulations including employment rules, HR &amp; payroll policies, and work manuals, and co-design your organizational culture and workflow.',
        'consult.c4.tag1' => 'HR Policy', 'consult.c4.tag2' => 'Work Manual', 'consult.c4.tag3' => 'Org System',
        'consult.c5.title' => 'Finance &amp; Tax Management',
        'consult.c5.desc'  => 'From initial funding plans and P&amp;L analysis to tax filing schedules and accounting system setup — we help you build a sound financial structure.',
        'consult.c5.tag1' => 'Funding Plan', 'consult.c5.tag2' => 'Tax Management', 'consult.c5.tag3' => 'Accounting System',
        'consult.c6.title' => 'HR &amp; Recruitment System',
        'consult.c6.desc'  => 'Job posting, interview process design, onboarding programs, and employee evaluation frameworks — we help you build a people-first organization.',
        'consult.c6.tag1' => 'Recruitment Process', 'consult.c6.tag2' => 'Onboarding Design', 'consult.c6.tag3' => 'Evaluation System',
        'process2.eyebrow' => 'HOW WE WORK',
        'process2.title'   => 'How We Consult',
        'process2.intro'   => 'From diagnosis to execution — step-by-step, hands-on support.',
        'process2.step1.title' => 'Situation Diagnosis',
        'process2.step1.desc'  => 'We assess your current business status and goals to identify areas that need improvement.',
        'process2.step2.title' => 'Strategy Planning',
        'process2.step2.desc'  => 'Based on the diagnosis, we design a customized action strategy and roadmap.',
        'process2.step3.title' => 'Execution Support',
        'process2.step3.desc'  => 'We work alongside you to solve problems that arise during strategy execution.',
        'process2.step4.title' => 'Performance Management',
        'process2.step4.desc'  => 'Regular performance reviews and feedback drive continuous growth.',
        'process2.footnote' => "The first consultation is free. Tell us your situation and we'll propose the best direction.",
        'process2.cta' => 'Free Consultation',

        // ---- 솔루션 > 업무자동화 (ERF) ----
        'erf.intro'   => 'We revolutionize repetitive tasks in the architecture and design industry with automation software. From custom program development to implementation consulting and maintenance — we support the entire process.',
        'erf.tag1' => 'Custom Development', 'erf.tag2' => 'Implementation Consulting', 'erf.tag3' => 'Maintenance Support', 'erf.tag4' => 'Digital Transformation',
        'erf.feature1.title' => 'Custom Software Development',
        'erf.feature1.desc'  => 'We create automation programs optimized for your work environment, from planning to development and deployment.',
        'erf.feature2.title' => 'Workflow Design Consulting',
        'erf.feature2.desc'  => 'We analyze your current workflow, identify automation opportunities, and propose the optimal digital transformation strategy.',
        'erf.feature3.title' => 'Post-Implementation Support',
        'erf.feature3.desc'  => 'We ensure stable operation with continuous updates and technical support even after software implementation.',
        'erf.apps.heading' => 'Automation Applications',
        'erf.apps.1' => 'Auto Document Generation', 'erf.apps.2' => 'Quote &amp; Contract Automation',
        'erf.apps.3' => 'Project Schedule Management', 'erf.apps.4' => 'Design Asset Deployment',
        'erf.apps.5' => 'Automated Report Writing', 'erf.apps.6' => 'Client Communication Automation',
        'erf.cta.title' => 'Not sure where to start with business automation?',
        'erf.cta.desc'  => 'We will analyze your current work environment and propose the optimal automation solution for free.',
        'erf.cta.button' => 'Free Consultation',

        // ---- 솔루션 > 홈페이지 ----
        'detail.solutions.website.title' => 'Website',
        'detail.solutions.website.intro' => "Like the very site you're looking at, we hand-code websites built around your goals — not generic templates.",
        'detail.solutions.website.f1.title' => 'Responsive Web Design',
        'detail.solutions.website.f1.desc'  => 'Looks and works great on desktop, tablet, and mobile.',
        'detail.solutions.website.f2.title' => 'Portfolio / Category Structure',
        'detail.solutions.website.f2.desc'  => 'A site that organizes your work or products into clear categories, like this one.',
        'detail.solutions.website.f3.title' => 'Easy-to-Maintain Code',
        'detail.solutions.website.f3.desc'  => 'Clean, documented code so future updates are simple — even for non-developers.',

        // ---- 솔루션 > 어플 ----
        'detail.solutions.apps.title' => 'Apps',
        'detail.solutions.apps.intro' => 'Apps designed and built by DESIGN DAN, introduced here and linked out to where they run.',
        'detail.solutions.apps.empty_title' => 'The first app is on its way',
        'detail.solutions.apps.empty_desc'  => "We're preparing our first app. Once it's live, it will be introduced right here with a link to try it.",

        // ---- Contact (문의하기 패널) ----
        'contact.eyebrow' => 'CONTACT US',
        'contact.title1'  => "Let's Start Your",
        'contact.title2'  => 'Project Together',
        'contact.intro'   => 'We welcome inquiries in all areas including architecture, design, and business solutions.',
        'contact.label.email' => 'Email', 'contact.label.phone' => 'Phone',
        'contact.label.instagram' => 'Instagram', 'contact.label.hours' => 'Business Hours',
        'contact.hours.value' => 'Mon–Fri 09:00 – 18:00',
        'contact.form.name'  => 'Name *', 'contact.form.email' => 'Email *', 'contact.form.phone' => 'Phone',
        'contact.form.type'  => 'Inquiry Type', 'contact.form.type_placeholder' => 'Select inquiry type',
        'contact.form.type.architecture' => 'Architecture',
        'contact.form.type.design'       => 'Design',
        'contact.form.type.solutions'    => 'Solutions',
        'contact.form.type.other'        => 'Other',
        'contact.form.message' => 'Message *',
        'contact.form.submit'  => 'Send Inquiry',
        'contact.form.note'    => '* This is a demo form for now. Real email sending will be connected in a later step (see CLAUDE.md).',
        'contact.form.alert'   => "Your inquiry has been received. (This is still a demo — it isn't actually sent anywhere yet.)",

        // ---- Footer ----
        'footer.tagline' => 'From architecture and design<br>to business solutions — we are with you.',
        'footer.menu_heading' => 'Menu',
        'footer.contact_heading' => 'Contact',
        'footer.rights' => 'All rights reserved.',
        'footer.privacy' => 'Privacy Policy',
        'footer.terms'   => 'Terms of Use',
        'footer.staff_login' => 'Staff Login',
    ],

    'ko' => [
        // ---- 상단 탭 (5개) ----
        'nav.about'        => '회사 소개',
        'nav.architecture' => '건축',
        'nav.design'       => '디자인',
        'nav.solutions'    => '솔루션',
        'nav.contact'      => '문의하기',
        'nav.email_inquiry' => '이메일 문의',
        'nav.lang_switch_label' => 'EN',
        'badge.soon' => '준비중',

        // ---- 홈 상단 ----
        'home.eyebrow' => 'DESIGN DAN',
        'home.title'   => '공간을 넘어, 가치를 설계합니다',

        // ---- 건축 탭 ----
        'tab.architecture.eyebrow' => '건축',
        'tab.architecture.title'   => '건축',
        'tab.architecture.intro'   => '설계부터 측량, 시공까지 — 건축의 전 과정을 함께합니다.',
        'card.architecture.design.title'       => '설계',
        'card.architecture.design.teaser'      => '주거·상업·공공 건축 설계',
        'card.architecture.aerial.title'       => '항공측량',
        'card.architecture.aerial.teaser'      => '드론 촬영 및 3D 현장 측량',
        'card.architecture.construction.title' => '시공',
        'card.architecture.construction.teaser'=> '설계부터 준공까지 시공 관리',

        // ---- 디자인 탭 ----
        'tab.design.eyebrow' => '디자인',
        'tab.design.title'   => '디자인',
        'tab.design.intro'   => '브랜드와 공간을 완성하는 비주얼 작업입니다.',
        'card.design.graphic.title'  => '그래픽 & 상업',
        'card.design.graphic.teaser' => '명함·전단지·포스터 등 브랜드 인쇄물',
        'card.design.video.title'    => '영상',
        'card.design.video.teaser'   => '홍보·현장 영상 제작',

        // ---- 솔루션 탭 ----
        'tab.solutions.eyebrow' => '솔루션',
        'tab.solutions.title'   => '솔루션',
        'tab.solutions.intro'   => '비즈니스를 성장시키는 전략과 도구입니다.',
        'card.solutions.consulting.title'  => '컨설팅',
        'card.solutions.consulting.teaser' => '사업자 등록부터 인사·재무까지',
        'card.solutions.automation.title'  => '업무자동화',
        'card.solutions.automation.teaser' => '맞춤형 업무 자동화 소프트웨어',
        'card.solutions.website.title'     => '홈페이지',
        'card.solutions.website.teaser'    => '비즈니스를 보여주는 홈페이지 제작',
        'card.solutions.apps.title'        => '어플',
        'card.solutions.apps.teaser'       => '직접 만들고 배포한 앱들',

        // ---- 카드/상세페이지 공통 ----
        'card.view_details' => '자세히 보기',
        'detail.back'        => '← 목록으로 돌아가기',
        'cta.contact'        => '상담 문의하기',

        // ---- About (회사소개 패널) ----
        'about.eyebrow' => '회사 소개',
        'about.title1'  => '공간을 넘어,',
        'about.title2'  => '삶의 가치를 높입니다',
        'about.p1' => 'DESIGN DAN은 필리핀 세부에 기반을 둔 전문 건축 설계 회사입니다. 주거·상업·공공 프로젝트 전반에서 고객의 비전을 현실로 구현하며, 단순한 건물을 넘어 사람과 공간이 조화를 이루는 곳을 만들어 일상의 가치를 높입니다.',
        'about.p2' => '건축을 중심으로 항공측량, 그래픽·영상 디자인, 비즈니스 컨설팅, 업무 자동화 소프트웨어, 홈페이지 제작까지 전문 서비스를 폭넓게 제공합니다. 프로젝트에 필요한 모든 것을 한 곳에서 해결하세요.',
        'about.pill.client'    => '고객 최우선',
        'about.pill.expertise' => '전문성',
        'about.pill.innovation'=> '혁신',
        'about.pill.trust'     => '신뢰',
        'about.cta' => '프로젝트 시작하기',
        'about.media_placeholder' => '실제 팀/현장 사진 자리<br>(사진 준비되면 교체)',
        'about.media_alt' => 'DESIGN DAN이 설계한 모던 주택 프로젝트',

        // ---- 건축 > 설계 ----
        'detail.architecture.design.title' => '설계',
        'detail.architecture.design.intro' => '초기 컨셉부터 최종 준공까지, 모든 단계에서 전문적인 설계 서비스를 제공합니다.',
        'arch.card1.title' => '건축 설계',
        'arch.card1.desc'  => '주거·상업·공공 건축물의 기획부터 시공 도면까지 전 과정을 담당하며, 최적의 공간 솔루션을 제안합니다.',
        'arch.card1.tag1' => '주거', 'arch.card1.tag2' => '상업', 'arch.card1.tag3' => '공공시설',
        'arch.card2.title' => '인테리어 디자인',
        'arch.card2.desc'  => '브랜드 아이덴티티와 사용자 경험을 반영해 기능성과 심미성을 모두 만족하는 인테리어를 디자인합니다.',
        'arch.card2.tag1' => '상업 인테리어', 'arch.card2.tag2' => '주거 인테리어', 'arch.card2.tag3' => '리모델링',

        // ---- 건축 > 항공측량 ----
        'detail.architecture.aerial.title' => '항공측량',
        'detail.architecture.aerial.intro' => '정확한 현장 데이터가 좋은 설계의 시작입니다. 드론 촬영과 3D 스캔으로 현장을 정밀하게 기록합니다.',
        'detail.architecture.aerial.f1.title' => '드론 항공촬영',
        'detail.architecture.aerial.f1.desc'  => '현장과 주변 지역을 고해상도 항공 사진·영상으로 기록합니다.',
        'detail.architecture.aerial.f2.title' => '3D 지형 측량',
        'detail.architecture.aerial.f2.desc'  => '설계·기획의 기초 자료가 되는 정밀한 3D 지형 데이터를 제공합니다.',
        'detail.architecture.aerial.f3.title' => '현장 데이터 리포트',
        'detail.architecture.aerial.f3.desc'  => '설계·엔지니어링 팀에 바로 전달할 수 있도록 명확하게 정리된 측량 리포트를 드립니다.',

        // ---- 건축 > 시공 ----
        'detail.architecture.construction.title' => '시공',
        'detail.architecture.construction.intro' => '체계적인 4단계 프로세스로 고객의 비전을 실현합니다.',
        'process1.step1.title' => '기획 및 상담',
        'process1.step1.desc'  => '고객의 요구사항, 예산, 일정을 꼼꼼히 분석해 프로젝트의 방향과 목표를 함께 설정합니다.',
        'process1.step2.title' => '설계 및 개발',
        'process1.step2.desc'  => '기본 설계부터 시공 도면까지 단계별로 작업하며, 완성도를 높이기 위해 고객과 긴밀히 소통합니다.',
        'process1.step3.title' => '시공 관리',
        'process1.step3.desc'  => '품질·일정·비용을 통합 관리하여 설계 의도가 완벽히 구현되도록 책임집니다.',
        'process1.step4.title' => '준공 및 인도',
        'process1.step4.desc'  => '최종 품질 검수 후 공간을 인도하며, 이후에도 지속적인 사후관리를 지원합니다.',
        'process1.footnote' => '프로젝트 기간 <strong>1개월~36개월</strong> · 전담 PM 배정 · 주간 진행 보고',
        'process1.cta' => '상담 신청하기',

        // ---- 디자인 > 그래픽 & 상업 ----
        'gd.hero_desc'  => '명함부터 전단지, 스티커, 포스터, 홍보물까지 — 디자인부터 인쇄까지 한 곳에서 해결합니다.',
        'gd.card1.title' => '한국에서 인쇄',
        'gd.card1.desc'  => '한국에서 제작한 고품질 인쇄물을 고객에게 직접 전달합니다.',
        'gd.card2.title' => '빠르고 확실하게',
        'gd.card2.desc'  => '고품질 인쇄와 빠른 배송을 보장합니다.',
        'gd.projects_title' => '프로젝트',
        'gd.projects_desc'  => 'DESIGN DAN이 제작한 다양한 그래픽 디자인 프로젝트를 만나보세요.',
        'gd.tag1' => '명함', 'gd.tag2' => '전단지', 'gd.tag3' => '스티커', 'gd.tag4' => '포스터', 'gd.tag5' => '홍보물',
        'gd.process.eyebrow' => '제작 프로세스',
        'gd.process.title'   => '간단한 4단계 프로세스',
        'gd.step1.title' => '상담 및 브리핑',
        'gd.step1.desc'  => '원하시는 디자인 스타일, 용도, 수량을 함께 논의합니다.',
        'gd.step2.title' => '시안 제작',
        'gd.step2.desc'  => '브랜드에 맞는 2~3개의 디자인 시안을 제안합니다.',
        'gd.step3.title' => '수정 및 확정',
        'gd.step3.desc'  => '피드백을 반영해 무제한 수정 후 최종 확정합니다.',
        'gd.step4.title' => '인쇄 및 배송',
        'gd.step4.desc'  => '고품질 인쇄물을 3~5일 내 배송하거나 파일로 전달합니다.',

        // ---- 디자인 > 영상 ----
        'detail.design.video.title' => '영상',
        'detail.design.video.intro' => '브랜드 홍보 영상부터 건축 현장 기록 영상까지, 이야기가 있는 영상을 제작합니다.',
        'detail.design.video.f1.title' => '홍보 영상',
        'detail.design.video.f1.desc'  => 'SNS·광고·브랜드 스토리텔링을 위한 숏폼 영상을 제작합니다.',
        'detail.design.video.f2.title' => '현장 기록 영상',
        'detail.design.video.f2.desc'  => '시공·리모델링 프로젝트의 진행 과정과 완공 모습을 영상으로 기록합니다.',
        'detail.design.video.f3.title' => '드론 항공 영상',
        'detail.design.video.f3.desc'  => '항공측량 팀과 함께 촬영하는 시네마틱한 드론 영상입니다.',

        // ---- 솔루션 > 컨설팅 ----
        'consult.intro'   => '창업부터 안정화까지, 경험이 풍부한 컨설턴트가 비즈니스 여정의 모든 단계를 설계하고 실행합니다.',
        'consult.c1.title' => '사업자 등록 및 법인 설립',
        'consult.c1.desc'  => '개인사업자·법인 등록, 영업 허가, 세무서 신고, 라이선스 취득까지 — 창업에 필요한 모든 행정 업무를 원스톱으로 지원합니다.',
        'consult.c1.tag1' => '사업자 등록', 'consult.c1.tag2' => '법인 설립', 'consult.c1.tag3' => '라이선스 취득',
        'consult.c2.title' => '광고 및 마케팅 전략',
        'consult.c2.desc'  => '온오프라인 광고 채널 선정부터 콘텐츠 기획, SNS 운영, 브랜드 아이덴티티까지 — 타겟 고객에게 닿는 마케팅 전략을 구축합니다.',
        'consult.c2.tag1' => 'SNS 마케팅', 'consult.c2.tag2' => '광고 운영', 'consult.c2.tag3' => '브랜드 전략',
        'consult.c3.title' => '구매 및 공급망 관리',
        'consult.c3.desc'  => '공급업체를 발굴하고 구매 조건을 협상하며, 재고 관리 시스템을 구축해 비용 효율적인 구매 프로세스를 설계합니다.',
        'consult.c3.tag1' => '공급업체 발굴', 'consult.c3.tag2' => '구매 협상', 'consult.c3.tag3' => '재고 관리',
        'consult.c4.title' => '사내 정책 및 시스템 구축',
        'consult.c4.desc'  => '취업 규칙, 인사·급여 정책, 업무 매뉴얼 등 내부 규정을 체계적으로 수립하고, 조직 문화와 업무 방식을 함께 설계합니다.',
        'consult.c4.tag1' => '인사 정책', 'consult.c4.tag2' => '업무 매뉴얼', 'consult.c4.tag3' => '조직 체계',
        'consult.c5.title' => '재무 및 세무 관리',
        'consult.c5.desc'  => '초기 자금 조달 계획과 손익 분석부터 세무 신고 일정, 회계 시스템 구축까지 — 탄탄한 재무 구조를 만들도록 돕습니다.',
        'consult.c5.tag1' => '자금 조달 계획', 'consult.c5.tag2' => '세무 관리', 'consult.c5.tag3' => '회계 시스템',
        'consult.c6.title' => '인사 및 채용 시스템',
        'consult.c6.desc'  => '채용 공고, 면접 프로세스 설계, 온보딩 프로그램, 직원 평가 체계까지 — 사람 중심의 조직을 만들도록 돕습니다.',
        'consult.c6.tag1' => '채용 프로세스', 'consult.c6.tag2' => '온보딩 설계', 'consult.c6.tag3' => '평가 체계',
        'process2.eyebrow' => '작업 방식',
        'process2.title'   => '컨설팅 진행 방식',
        'process2.intro'   => '진단부터 실행까지, 단계별로 밀착 지원합니다.',
        'process2.step1.title' => '현황 진단',
        'process2.step1.desc'  => '현재 비즈니스 상태와 목표를 평가해 개선이 필요한 영역을 파악합니다.',
        'process2.step2.title' => '전략 수립',
        'process2.step2.desc'  => '진단 결과를 바탕으로 맞춤형 실행 전략과 로드맵을 설계합니다.',
        'process2.step3.title' => '실행 지원',
        'process2.step3.desc'  => '전략 실행 과정에서 발생하는 문제를 함께 해결합니다.',
        'process2.step4.title' => '성과 관리',
        'process2.step4.desc'  => '정기적인 성과 점검과 피드백으로 지속적인 성장을 이끕니다.',
        'process2.footnote' => '첫 상담은 무료입니다. 현재 상황을 알려주시면 최선의 방향을 제안해 드립니다.',
        'process2.cta' => '무료 상담 신청',

        // ---- 솔루션 > 업무자동화 (ERF) ----
        'erf.intro'   => '자동화 소프트웨어로 반복 업무를 혁신합니다. 맞춤형 프로그램 개발부터 도입 컨설팅, 유지보수까지 전 과정을 지원합니다.',
        'erf.tag1' => '맞춤 개발', 'erf.tag2' => '도입 컨설팅', 'erf.tag3' => '유지보수 지원', 'erf.tag4' => '디지털 전환',
        'erf.feature1.title' => '맞춤형 소프트웨어 개발',
        'erf.feature1.desc'  => '기획부터 개발, 배포까지 업무 환경에 최적화된 자동화 프로그램을 제작합니다.',
        'erf.feature2.title' => '워크플로우 설계 컨설팅',
        'erf.feature2.desc'  => '현재 업무 흐름을 분석해 자동화 가능 영역을 발굴하고, 최적의 디지털 전환 전략을 제안합니다.',
        'erf.feature3.title' => '도입 후 지원',
        'erf.feature3.desc'  => '소프트웨어 도입 이후에도 지속적인 업데이트와 기술 지원으로 안정적인 운영을 보장합니다.',
        'erf.apps.heading' => '자동화 적용 분야',
        'erf.apps.1' => '문서 자동 생성', 'erf.apps.2' => '견적·계약 자동화',
        'erf.apps.3' => '프로젝트 일정 관리', 'erf.apps.4' => '디자인 자산 배포',
        'erf.apps.5' => '보고서 자동 작성', 'erf.apps.6' => '고객 커뮤니케이션 자동화',
        'erf.cta.title' => '업무 자동화, 어디서부터 시작해야 할지 모르시겠나요?',
        'erf.cta.desc'  => '현재 업무 환경을 분석해 최적의 자동화 솔루션을 무료로 제안해 드립니다.',
        'erf.cta.button' => '무료 상담 신청',

        // ---- 솔루션 > 홈페이지 ----
        'detail.solutions.website.title' => '홈페이지',
        'detail.solutions.website.intro' => '지금 보고 계신 이 사이트처럼, 정해진 템플릿이 아니라 목적에 맞게 직접 코딩한 홈페이지를 만들어 드립니다.',
        'detail.solutions.website.f1.title' => '반응형 웹 디자인',
        'detail.solutions.website.f1.desc'  => 'PC·태블릿·모바일 어디서 봐도 깔끔하게 보입니다.',
        'detail.solutions.website.f2.title' => '포트폴리오·카테고리형 구조',
        'detail.solutions.website.f2.desc'  => '지금 이 사이트처럼, 작업물이나 상품을 카테고리로 명확하게 정리합니다.',
        'detail.solutions.website.f3.title' => '유지보수하기 쉬운 코드',
        'detail.solutions.website.f3.desc'  => '개발자가 아니어도 나중에 쉽게 수정할 수 있도록 깔끔하게 정리된 코드로 만듭니다.',

        // ---- 솔루션 > 어플 ----
        'detail.solutions.apps.title' => '어플',
        'detail.solutions.apps.intro' => 'DESIGN DAN이 직접 기획하고 만든 앱들을 소개하고, 실제로 써볼 수 있는 곳으로 연결해 드립니다.',
        'detail.solutions.apps.empty_title' => '첫 번째 앱을 준비 중입니다',
        'detail.solutions.apps.empty_desc'  => '첫 번째 앱을 준비하고 있어요. 준비가 끝나면 바로 이 자리에 소개와 함께 실행 링크가 추가됩니다.',

        // ---- Contact (문의하기 패널) ----
        'contact.eyebrow' => '문의하기',
        'contact.title1'  => '프로젝트를',
        'contact.title2'  => '함께 시작해요',
        'contact.intro'   => '건축, 디자인, 비즈니스 솔루션 등 모든 분야의 문의를 환영합니다.',
        'contact.label.email' => '이메일', 'contact.label.phone' => '전화',
        'contact.label.instagram' => '인스타그램', 'contact.label.hours' => '영업시간',
        'contact.hours.value' => '월–금 09:00 – 18:00',
        'contact.form.name'  => '이름 *', 'contact.form.email' => '이메일 *', 'contact.form.phone' => '전화번호',
        'contact.form.type'  => '문의 유형', 'contact.form.type_placeholder' => '문의 유형을 선택하세요',
        'contact.form.type.architecture' => '건축',
        'contact.form.type.design'       => '디자인',
        'contact.form.type.solutions'    => '솔루션',
        'contact.form.type.other'        => '기타',
        'contact.form.message' => '메시지 *',
        'contact.form.submit'  => '문의 보내기',
        'contact.form.note'    => '* 지금은 데모 폼입니다. 실제 메일 발송 연동은 다음 단계에서 진행합니다. (CLAUDE.md 참고)',
        'contact.form.alert'   => '문의가 접수되었습니다. (지금은 데모 상태라 실제 전송은 아직 연결되지 않았습니다.)',

        // ---- Footer ----
        'footer.tagline' => '건축과 디자인부터<br>비즈니스 솔루션까지 — 함께 합니다.',
        'footer.menu_heading' => '메뉴',
        'footer.contact_heading' => '문의',
        'footer.rights' => '모든 권리 보유.',
        'footer.privacy' => '개인정보처리방침',
        'footer.terms'   => '이용약관',
        'footer.staff_login' => '관리자 로그인',
    ],
];
