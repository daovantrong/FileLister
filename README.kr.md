<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: 현대적인 PHP 디렉토리 목록 스크립트 v1.5.36

FileLister는 강력하고 가벼우며 현대적인 **PHP 디렉토리 목록 스크립트**로, 서버 파일을 아름답고 모바일 친화적인 **웹 파일 탐색기**로 변환합니다. `h5ai` 또는 `Apache Index`의 완벽한 대안으로, 단일 파일 배포 옵션과 내장 파일 미리보기를 제공합니다.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 목차
- [✨ 기능](#-기능)
- [📦 설치](#-설치)
- [⚙️ 설정](#-설정)
- [🎨 테마](#-테마)
- [🧩 사용자 정의 HTML 후크](#-사용자-정의-html-후크)
- [🌍 다국어 지원](#-다국어-지원)
- [👁️ 파일 미리보기](#-파일-미리보기--viewer)
- [🔗 공유 & 다운로드](#-공유--다운로드)
- [⌨️ 키보드 단축키](#-키보드-단축키)
- [🛡️ 보안 세부 사항](#-보안-세부-사항)
- [📋 요구 사항](#-요구-사항)

---

## ✨ 기능

### 🚀 **프로덕션 준비 & 빠름**
- **독립형 버전**: 모든 리소스가 임베드된 단일 파일 배포 (`Standalone.php`). 생성하려면 `php build.php` 실행.
- **Docker 지원**: 즉시 사용 가능한 `Dockerfile` 및 `docker-compose.yml`.
- **인덱스 제공**: 디렉토리에 존재하는 경우 선택적으로 `index.html` 제공.

### 🎨 **현대적인 사용자 인터페이스**
- **깨끗 & 반응형**: 모바일 우선 레이아웃, 모든 장치에서 작동.
- **9 테마**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (애니메이션 글래스모피즘).
- **그리드 & 리스트 뷰**: 카드 그리드 뷰와 상세 리스트 뷰 간 전환.
- **README 렌더링**: 디렉토리 목록 하단에서 `README.md` 파일을 자동으로 렌더링.
- **현지화됨**: 18+ 지원되는 로케일이 있는 언어 선택기.

### 🛡️ **보안 강화**
- **CSP와 Nonces**: 모든 인라인 스크립트에 요청별 암호화 nonce. `unsafe-inline` 없음.
- **속도 제한**: 통합된 반 DDoS 요청 스로틀링 (기본적으로 60 req/60s).
- **신뢰할 수 있는 프록시**: 안전한 `X-Forwarded-For` 처리 — 신뢰할 수 있는 프록시 IP에서 요청이 올 때만 적용.
- **경로 횡단 보호**: 모든 `?dir=` 입력이 `realpath()`로 해결되고 `$lister_root`로 제한.
- **민감한 파일 숨김**: `.env`, `.git`, `.htaccess`, PHP 파일을 자동으로 무시.
- **보안 헤더**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (HTTPS만).
- **MD5/SHA-1 없음**: 기본 해시 세트가 `CRC32,XXH128,SHA-256,SHA3-256`으로 설정. MD5와 SHA-1은 기본적으로 제외.

### 🔍 **파일 무결성 (정보 & 해시)**
- SHA-3, WHIRLPOOL, XXH128, CRC32를 포함한 파일당 40+ 해시 알고리즘 검증.
- 해싱을 위한 구성 가능한 최대 파일 크기.
- 결과가 정보 모달에서 인라인 표시.

### 📤 **내보내기 & 공유**
- **JSON, CSV, TSV, NDJSON** 형식으로 파일 목록 복사/다운로드.
- QR 코드와 직접 링크로 파일 공유.

---

## 📦 설치 & 배포 모드

FileLister는 4개의 배포 모드를 지원합니다. 설정에 맞는 것을 선택:

---

### 모드 1: 독립형 (단일 PHP 파일) — 프로덕션 권장

모든 리소스가 자체 포함 파일로 컴파일. `_/` 폴더 필요 없음.

```bash
# 단계 1: 독립형 파일 구축
php build.php

# 단계 2: Standalone.php를 서버에 업로드
# 단계 3: index.php로 이름 변경 (또는 선호하는 이름)
```

> **설정**: 자동으로 `'use_embedded' => true` 설정. 다른 설정 필요 없음.

---

### 모드 2: 일반 (소스 파일)

클래식 멀티 파일 설정. 개발에서 가장 빠름.

```
your-web-root/
├── index.php        ← 진입점 (require_once 'core.php')
├── core.php         ← 코어 로직 & 설정
└── _/               ← CSS, JS, 아이콘, 번역 파일
```

**단계:**
1. `index.php`, `core.php`, `_/`를 웹 디렉토리에 복사.
2. 브라우저로 접근: `http://yoursite.com/`
3. 추가 설정 필요 없음.

---

### 모드 3: 하위 디렉토리 배포

자신의 콘텐츠를 인덱싱하는 하위 폴더에서 FileLister 실행.

```
your-web-root/
├── files/           ← 인덱싱할 디렉토리
│   ├── index.php    ← FileLister 진입점
│   └── core.php
└── _/               ← 공유 자산 (부모 스캔으로 자동 감지)
```

`detect_assets_path()` 함수는 `_/` 자산 폴더를 찾기 위해 자동으로 **최대 5개의 부모 디렉토리**를 스캔합니다. 대부분의 경우 수동 `assets_path` 설정 필요 없음.

자산이 자동 감지되지 않으면:
```php
'assets_path' => '../_',   // 또는 '/var/www/html/_' 같은 전체 경로
```

---

### 모드 4: 글로벌 배포 (서버의 임의 디렉토리 인덱싱)

스크립트 위치에서 분리된 서버의 임의 경로를 탐색하기 위해 **단일 FileLister 설치** 사용.

```
/var/www/html/
├── filelister/      ← FileLister가 여기 살음
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← 실제로 인덱싱할 디렉토리
```

**`core.php`에서 설정:**
```php
'base_path' => '/var/data',   // ← 목록할 디렉토리 설정
```

> `base_path`는 PHP 프로세스가 읽을 수 있는 임의의 **절대 파일 시스템 경로**를 허용합니다. 스크립트는 `realpath()`를 사용하여 모든 `?dir=` 탐색이 이 루트 내에 유지되도록 강제하여 경로 횡단을 방지합니다.

**웹 서버 설정** (FileLister를 디렉토리 인덱스로 사용):

**Nginx:**
```nginx
server {
    root /var/data;
    index index.php FileLister.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME /var/www/html/filelister/index.php;
    }
}
```

**Apache (타겟 디렉토리의 `.htaccess`):**
```apache
DirectoryIndex index.php FileLister.php index.html

# 모든 디렉토리 요청을 FileLister로 라우팅:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### 모드 5: Docker

```bash
docker-compose up -d
```

`http://localhost:8080`에서 접근. 타겟 디렉토리를 마운트하기 위해 `docker-compose.yml` 편집.

---

### 배포 모드 비교

| 모드 | 필요한 파일 | 최적 |
|------|---------------|----------|
| **독립형** | `Standalone.php`만 | 빠른 배포, 공유 호스팅 |
| **일반** | `index.php` + `core.php` + `_/` | 개발, 전체 제어 |
| **하위 디렉토리** | 일반과 같음, 하위 폴더에 배치 | 특정 하위 폴더 인덱싱 |
| **글로벌** | 일반 + `base_path` 설정 | 서버 경로를 인덱싱하는 단일 인스턴스 |
| **Docker** | `Dockerfile` + `docker-compose.yml` | 컨테이너화 환경 |

---

## ⚙️ 설정

모든 설정은 `core.php` (또는 `Standalone.php`)의 `$config` 배열에 있습니다.

### 일반

| 키 | 기본 | 설명 |
|-----|---------|-------------|
| `title` | `''` | 사용자 정의 페이지 제목. 비어 있으면 경로에서 자동 생성. |
| `title_prefix` | `'Index of'` | 자동 생성 제목의 접두사. |
| `title_suffix` | `' - FileLister'` | 자동 생성 제목의 접미사. |
| `language` | `''` | 로케일을 강제 (`en`, `vi`, `zh`, `ja`…). 비어 있으면 자동 감지. |
| `allowed_langs` | (18개 언어) | 선택기 드롭다운에서 사용할 수 있는 언어. |
| `theme` | `'ocean'` | 기본 테마. 옵션: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | 기본 뷰. 옵션: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | PHP 시간대 문자열. |
| `date_format` | `'Y-m-d H:i:s'` | PHP 날짜 형식 문자열. |
| `base_path` | `''` | 글로벌/하위 디렉토리 배포의 루트 디렉토리. |
| `favicon_path` | `''` | 사용자 정의 favicon 경로. |

### 표시 옵션

| 키 | 기본 | 설명 |
|-----|---------|-------------|
| `show_hidden` | `false` | 숨겨진 파일 표시 (`.`로 시작). |
| `show_size` | `true` | 파일 크기 열 표시. |
| `show_date` | `true` | 마지막 수정 날짜 열 표시. |
| `show_type` | `true` | 파일 유형 열 표시 (리스트 뷰). |
| `show_folder_size` | `true` | 폴더 크기 계산 (재귀적 — 큰 폴더에서 느릴 수 있음). |
| `show_breadcrumb` | `true` | 탐색 breadcrumb 표시. |
| `show_footer` | `true` | 푸터 바 표시. |
| `show_copyright` | `true` | 푸터에 저작권 정보 표시. |
| `show_language_selector` | `true` | 언어 전환기 컨트롤 표시. |
| `show_theme_selector` | `true` | 테마 전환 버튼 표시. |

### 기능

| 키 | 기본 | 설명 |
|-----|---------|-------------|
| `enable_search` | `true` | 라이브 파일 검색 활성화. |
| `enable_preview` | `true` | 파일 미리보기 모달 활성화 (이미지, 비디오, 오디오, PDF, 코드). |
| `enable_download` | `true` | 파일에 다운로드 버튼 표시. |
| `enable_share` | `true` | QR 코드가 있는 파일 공유 모달 활성화. |
| `enable_qrcode` | `true` | 공유 모달에서 QR 코드 생성. |
| `enable_shortcuts` | `true` | 키보드 단축키 활성화. |
| `enable_export` | `true` | 파일 목록 내보내기/복사 활성화 (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | 디렉토리 목록 하단에서 `README.md` 파일 렌더링. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | 해시 알고리즘의 쉼표 구분 목록. 지원: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, 그리고 30+ 더. |
| `hash_uppercase` | `true` | 해시 값을 대문자로 표시. |
| `max_hash_size` | `1000` | 해싱에 허용되는 최대 파일 크기 (MB). |

### 보안

| 키 | 기본 | 설명 |
|-----|---------|-------------|
| `ignore_files` | (아래 참조) | 숨길 파일. 기본적으로 `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env` 포함. |
| `ignore_extensions` | `['php']` | 숨길 확장자. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | 숨길 폴더. |
| `allowed_extensions` | `[]` | 확장자 화이트리스트 (빈 = 모두 허용). |
| `protected_paths` | `['/etc', '/var/www/.git']` | 항상 차단되는 절대 경로. |
| `enable_rate_limit` | `true` | IP 기반 속도 제한 활성화. |
| `rate_limit_requests` | `60` | 창당 최대 요청. |
| `rate_limit_period` | `60` | 속도 제한 시간 창 (초). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | 속도 제한에서 제외된 IP. |
| `trusted_proxies` | `[]` | `X-Forwarded-For`를 설정할 수 있는 IP. 빈 = 아무도 신뢰하지 않음. |
| `enable_dev` | `true` | **⚠️ 프로덕션에서 `false`로 설정.** PHP 오류 표시 활성화 및 캐시 비활성화. |

> [!CAUTION]
> 프로덕션에 배포하기 전에 항상 `'enable_dev' => false` 설정. dev 모드에서, 방문자에게 파일 경로, 설정 세부 사항, 스택 트레이스를 노출할 수 있는 PHP 오류가 표시됩니다.

### 고급

| 키 | 기본 | 설명 |
|-----|---------|-------------|
| `assets_path` | `''` | `_/` 자산 폴더 경로. 비어 있으면 자동 감지. |
| `use_embedded` | `false` | 임베디드 자산 모드 강제 (`Standalone.php`에서 사용). |
| `thumbnail_directory` | `''` | 썸네일 캐시의 사용자 정의 경로. 비어 있으면 자동으로 `_/thumbs`로 설정. |
| `thumbnail_width` | `200` | 최대 썸네일 너비 (px). |
| `thumbnail_height` | `200` | 최대 썸네일 높이 (px). |
| `thumbnail_cache_expiry` | `30` | 캐시된 썸네일이 제거되기 전의 일수. `0` = 항상 정리. `-1` = 절대 정리하지 않음. |
| `readme_files` | (목록) | README 렌더링을 위해 스캔할 파일 이름. |
| `custom_css` | `'_/css/custom.css'` | 사용자 정의 CSS 파일 경로 (존재하면 로드). |
| `custom_js` | `'_/js/custom.js'` | 사용자 정의 JS 파일 경로 (존재하면 로드). |
| `serve_index_files` | `false` | 존재하면 `index.html` 직접 제공. ⚠️ 신뢰할 수 없는 파일이 존재하는 경우 잠재적 XSS 위험. |
| `index_files` | `['index.html', …]` | 찾을 인덱스 파일 이름. |

### 서버를 디렉토리 인덱스로 설정

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### 외부 호스트 허용 (CSP)
FileLister는 엄격한 **Content Security Policy**를 사용합니다. 외부 도메인에서 리소스를 로드하려면 `core.php`에서 `Content-Security-Policy` 헤더를 편집:

```php
// 적절한 디렉티브에 도메인 추가:
// img-src: 외부 이미지용
// script-src: 외부 스크립트용 (주의해서 사용)
// style-src: 외부 CSS용
```

---

## 🎨 테마 사용자 정의

### 사용 가능한 테마
| 테마 | 설명 |
|-------|-------------|
| `light` | 깔끔한 흰색 테마 |
| `dark` | 다크 모드 |
| `auto` | 시스템 선호도 따름 |
| `ocean` | 푸른 바다 톤 |
| `forest` | 녹색 지구 톤 |
| `dracula` | Dracula 다크 퍼플 |
| `nord` | 북유럽 북극 팔레트 |
| `high-contrast` | 접근성 포커스 |
| `cute` | 배경 이미지와 함께 애니메이션 글래스모피즘 |

### 사용자 정의 테마 생성

1. **테마 복사**: `_/css/themes/ocean.css` 복제 → `_/css/themes/mytheme.css`.

2. **CSS 변수 편집**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... 다른 변수 */
}
```

3. **JS에서 등록**: `_/js/app.js`의 `toggleTheme()` 배열에 테마 이름 추가.

4. **설정에서 활성화**:
```php
'theme' => 'mytheme',
```

5. **설정에서 화이트리스트** (테마 선택기가 작동하려면): `index.php`에서 `$allowed_themes` 검색하여 `'mytheme'`를 배열에 추가.

---

## 🧩 사용자 정의 HTML 후크

코어 파일을 편집하지 않고 특정 페이지 위치에 사용자 정의 HTML, CSS 또는 JavaScript 주입. `core.php`에서 `html_hooks` 배열 구성:

```php
'html_hooks' => array(
    'head_end'      => '',  // </head> 전
    'body_start'    => '',  // <body> 후
    'header_start'  => '',  // <header> 열기 후
    'header_end'    => '',  // </header> 전
    'main_before'   => '',  // <main> 전
    'main_start'    => '',  // <main> 내, 항목 전
    'main_end'      => '',  // <main> 내, 항목 후
    'main_after'    => '',  // </main> 후
    'footer_before' => '',  // <footer> 전
    'footer_start'  => '',  // <footer> 열기 후
    'footer_end'    => '',  // </footer> 전
    'footer_after'  => '',  // </footer> 후
    'body_end'      => '',  // </body> 전
    'html_end'      => '',  // </html> 전
),
```

### 예: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 다국어 지원
FileLister는 브라우저 언어를 자동 감지하고 **18+ 언어**를 지원합니다:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

`'language' => 'vi'`로 고정 언어 설정, 또는 자동 감지를 위해 빈 채로 두기.

---

## 👁️ 파일 미리보기 & 뷰어
다양한 파일 유형을 위한 통합 고성능 뷰어:
- **이미지**: jpg, png, gif, webp, svg (그리드 뷰에서 실시간 썸네일)
- **비디오**: mp4, webm, avi, mov, mkv
- **오디오**: mp3, ogg, flac, wav, m4a
- **문서**: 통합 PDF 뷰어 및 Markdown 렌더링
- **코드**: Prism.js를 사용한 100+ 언어의 구문 강조

---

## 🔗 공유 & 다운로드
- 모바일 파일 전송을 위한 즉시 **QR 코드** 생성.
- 모든 파일의 직접 다운로드 링크.
- 고유 URL을 통한 안전한 파일 공유.
- **완전 Unicode 지원**: 베트남어, 중국어, 일본어, 아랍어 및 기타 비 ASCII 스크립트의 파일 이름이 공유 링크와 QR 코드에서 올바르게 퍼센트 인코딩됩니다.

---

## ⌨️ 키보드 단축키
| 키 | 액션 |
|-----|--------|
| `/` 또는 `Ctrl+F` | 검색 상자 포커스 |
| `Esc` | 모달 닫기 / 검색 지우기 |
| `↑` / `↓` | 항목 탐색 |
| `Enter` | 선택된 항목 열기 |
| `g` 그 다음 `h` | 홈으로 이동 (루트) |
| `g` 그 다음 `u` | 한 디렉토리 레벨 위로 |
| `?` | 키보드 단축키 도움말 표시 |

---

## 🛡️ 보안 세부 사항

FileLister는 여러 강화 보안 레이어를 포함합니다:

| 레이어 | 세부 사항 |
|-------|--------|
| **경로 횡단** | `?dir=` 입력이 `realpath()`로 검증되고 `$lister_root`로 제한. |
| **CSP Nonce** | 모든 인라인 스크립트에 요청별 랜덤 128비트 Nonce. `unsafe-inline` 없음. |
| **속도 제한** | 임시 파일에 저장된 IP 기반 스로틀링. 기본: 60 req/60s. |
| **신뢰할 수 있는 프록시** | `X-Forwarded-For`는 명시적으로 구성된 프록시 IP에서만 신뢰. |
| **민감한 파일** | `.env`, `.git`, `.htaccess`, PHP 파일 자동 숨김. |
| **보안 헤더** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy`로 카메라/마이크/지리 비활성화. |
| **HSTS** | HTTPS에서 자동으로 `Strict-Transport-Security` 전송. |
| **CORS** | 내보내기 엔드포인트는 same-origin 요청만 허용. 임의 origin 반사 없음. |
| **오래된 해시 없음** | MD5와 SHA-1은 기본 해시 유형에서 제외. |
| **Symlink 보호** | 폴더 순회 중 Symlink 건너뛰어 루프와 누수 방지. |
| **Dev 모드** | 프로덕션에서 `enable_dev: false`가 오류 표시 비활성화. |

> [!IMPORTANT]
> 설정 후, 즉시 `'enable_dev' => false` 설정하여 오류 메시지가 서버 내부를 노출하지 않도록.

---

## 📋 요구 사항
- **PHP**: 5.2 이상 (PHP 8.4+까지 테스트)
- **확장**: `json` (필수), `gd` (선택 — 썸네일용), `zip` (선택)

---

## 📜 변경 로그

### v1.5.36 — 보안 & 버그 수정 버전

**보안 수정:**
- 🔒 **[중요] `?export=` 엔드포인트의 CORS 반사 취약성 수정** — 임의의 `Origin` 헤더를 더 이상 반사하지 않음
- 🔒 **[중요] 파일 미리보기에서 XSS 수정** — "지원되지 않는 유형" 미리보기에서 파일 이름이 DOM 삽입 전에 이스케이프되지 않음
- 🔒 **[중요] `enable_dev`가 기본적으로 `false`** — 프로덕션에서 우발적인 PHP 오류 공개 방지
- 🔒 **[높음] `dir_theme` 쿠키 사용 전 검증** 예기치 않은 동작 방지

**버그 수정:**
- 🐛 **Unicode 이름의 파일에 대한 QR 코드 생성 실패 수정** (베트남어, 중국어, 일본어 등)
- 🐛 **Unicode/비 ASCII 파일 이름의 공유 링크 파손 수정**
- 🐛 **Unicode 파일 이름의 이미지 미리보기 로드 수정**
- 🐛 **푸터 HTML의 중복 `</div>` 태그 수정** (일부 브라우저에서 레이아웃 문제 유발)
- 🐛 **`style.css`가 두 번 로드되는 수정** (대역폭 낭비, 이중 파싱)
- 🐛 **`Standalone.php` 빌드에서 누락된 `custom.js` / `custom.css` 수정**
- 🐛 **테마 복원 수정** — `dracula`, `nord`, `high-contrast`, `cute` 테마가 페이지 리로드 시 재설정되지 않음
- 🐛 **그리드 뷰에서 썸네일과 함께 주입된 중복 SVG 아이콘 수정**
- 🐛 **AJAX 탐색 설정 파싱 수정** — 취약한 인덱스 기반 추출 대신 강력한 정규 표현식
- 🐛 **`previewText()`가 404 HTML 표시 수정** 파일이 접근 불가능한 경우의 파일 내용으로
- 🐛 **존재하지 않는 `langToggle` 요소를 참조하는 데드코드 `changeLanguage()` 수정**
- 🐛 **SHA-512/224 및 SHA-512/256 추가** 해시 알고리즘 맵에 (문서에 목록되어 있지만 코드에 누락)
- 🐛 **클립보드 복사에서 `alert()` 호출 교체** 비블로킹 토스트 알림으로
- 🐛 **이미지 갤러리 탐색 수정** — 필터/검색으로 숨겨진 이미지가 prev/next 순회에서 제외됨
- 🐛 **`audio`/`video` 미리보기 수정** — 미디어가 로드에 실패한 경우 오류 핸들러 추가

---

## ☕ 내 작업 지원
이 오픈소스 PHP 스크립트를 즐기시나요?
- [🍻 사주세요](https://buymeacoffee.com/trong)
- ❤️ [PayPal](https://paypal.me/DaoVanTrong)을 통해 기부

---

## 📝 라이선스
MIT 라이선스 — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
