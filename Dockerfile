# DESIGN DAN (designs-dan.com) — Render 배포용 Dockerfile
#
# Render는 PHP를 기본(native) 런타임으로 지원하지 않아서, PHP + Apache가 들어있는
# 공식 이미지를 그대로 써서 컨테이너로 띄웁니다. 이 프로젝트는 순수 PHP라
# composer.json도 없고 외부 패키지 의존성도 없어서 이 정도로 충분합니다.
FROM php:8.2-apache

# Apache의 DocumentRoot를 프로젝트 루트로 지정 (index.php가 바로 도메인 루트에서
# 보이도록). config.php가 $_SERVER['DOCUMENT_ROOT'] 기준으로 BASE_URL을 스스로
# 계산하기 때문에, 이 값이 프로젝트 루트와 같으면 별도 설정 없이 그대로 동작합니다.
ENV APACHE_DOCUMENT_ROOT=/var/www/html

RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
    && sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 보안 하드닝 (2026-08-16 추가):
#   - display_errors 끄기: DB 연결 실패 등 예외가 방문자에게 내부 경로/쿼리를
#     노출하지 않도록. php:8.2-apache는 기본 php.ini가 없어 컴파일 기본값
#     (display_errors On)이 그대로 쓰이던 상태였다.
#   - data/*.db 접근 차단: DATABASE_URL이 없을 때 로컬 SQLite 폴백(includes/db.php)이
#     문서 루트 안에 생기는데, 지금까지 이걸 막는 설정이 전혀 없어서 배포된 상태
#     그대로면 /data/app.db가 웹에서 직접 다운로드 가능했다(문의자 개인정보 +
#     비밀번호 해시 포함). 자세한 내용은 docker/apache-security.conf 참고.
COPY docker/php-production.ini /usr/local/etc/php/conf.d/zz-app.ini
COPY docker/apache-security.conf /etc/apache2/conf-enabled/zz-app-security.conf

# 프로젝트 파일 전체 복사
COPY . /var/www/html/

# Render의 헬스체크/일반 요청이 원활하도록 권한 정리
RUN chown -R www-data:www-data /var/www/html

# Render는 컨테이너가 $PORT 환경변수로 리슨하길 기대합니다. Apache 기본 포트(80)를
# 그대로 쓰도록 Render 대시보드에서 서비스를 만들 때 포트를 80으로 지정하면 됩니다.
EXPOSE 80
