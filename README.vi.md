<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: Tập lệnh liệt kê thư mục PHP hiện đại v1.5.36

FileLister là một **script liệt kê thư mục PHP** mạnh mẽ, nhẹ và hiện đại, biến các tệp máy chủ của bạn thành một **trình duyệt tệp web** đẹp mắt, thân thiện với di động. Đây là giải pháp thay thế hoàn hảo cho `h5ai` hoặc `Apache Index`, cung cấp tùy chọn triển khai một tệp duy nhất và tính năng xem trước tệp tích hợp.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 Mục lục
- [✨ Tính năng](#-tính-năng)
- [📦 Cài đặt](#-cài-đặt)
- [⚙️ Cấu hình](#-cấu-hình)
- [🎨 Chủ đề](#-chủ-đề)
- [🧩 Hook HTML tùy chỉnh](#-hook-html-tùy-chỉnh)
- [🌍 Hỗ trợ đa ngôn ngữ](#-hỗ-trợ-đa-ngôn-ngữ)
- [👁️ Xem trước tệp](#-xem-trước-tệp--viewer)
- [🔗 Chia sẻ & Tải xuống](#-chia-sẻ--tải-xuống)
- [⌨️ Phím tắt](#-phím-tắt)
- [🛡️ Chi tiết bảo mật](#-chi-tiết-bảo-mật)
- [📋 Yêu cầu](#-yêu-cầu)

---

## ✨ Tính năng

### 🚀 **Sản xuất Sẵn sàng & Nhanh chóng**
- **Phiên bản độc lập**: Triển khai một tệp duy nhất (`Standalone.php`) với tất cả tài nguyên được nhúng. Chạy `php build.php` để tạo.
- **Hỗ trợ Docker**: Có sẵn `Dockerfile` và `docker-compose.yml`.
- **Phục vụ Index**: Tùy chọn phục vụ `index.html` nếu có trong thư mục.

### 🎨 **Giao diện người dùng hiện đại**
- **Sạch sẽ & Phản hồi tốt**: Bố cục ưu tiên di động, hoạt động trên mọi thiết bị.
- **9 Chủ đề**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (glassmorphism anime).
- **Chế độ lưới & danh sách**: Chuyển đổi giữa chế độ lưới thẻ và chế độ danh sách chi tiết.
- **Hiển thị README**: Tự động hiển thị các tệp `README.md` ở cuối danh sách thư mục.
- **Địa phương hóa**: Trình chọn ngôn ngữ với hơn 18 ngôn ngữ được hỗ trợ.

### 🛡️ **Bảo mật được tăng cường**
- **CSP với Nonces**: Nonce mã hóa cho mỗi yêu cầu trên tất cả các script nội tuyến. Không `unsafe-inline`.
- **Giới hạn tốc độ**: Tích hợp chống DDoS throttling (60 req/60s mặc định).
- **Proxy đáng tin cậy**: Xử lý `X-Forwarded-For` an toàn — chỉ áp dụng nếu yêu cầu đến từ IP proxy đáng tin cậy.
- **Bảo vệ duyệt đường dẫn**: Tất cả đầu vào `?dir=` được giải quyết qua `realpath()` và bị ràng buộc vào `$lister_root`.
- **Ẩn các tệp nhạy cảm**: Tự động bỏ qua `.env`, `.git`, `.htaccess`, và các tệp PHP.
- **Tiêu đề bảo mật**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (chỉ HTTPS).
- **Không MD5/SHA-1**: Bộ hash mặc định được đặt thành `CRC32,XXH128,SHA-256,SHA3-256`. MD5 và SHA-1 bị loại trừ theo mặc định.

### 🔍 **Tính toàn vẹn của tệp (Thông tin & Hash)**
- Xác minh hơn 40 thuật toán hash cho mỗi tệp, bao gồm SHA-3, WHIRLPOOL, XXH128, CRC32.
- Kích thước tệp tối đa có thể cấu hình cho hashing.
- Kết quả được hiển thị nội tuyến trong modal Thông tin.

### 📤 **Xuất & Chia sẻ**
- Sao chép/Tải xuống danh sách tệp ở định dạng **JSON, CSV, TSV, NDJSON**.
- Chia sẻ tệp qua mã QR và liên kết trực tiếp.

---

## 📦 Cài đặt & Các chế độ triển khai

FileLister hỗ trợ 4 chế độ triển khai. Chọn chế độ phù hợp với cấu hình của bạn:

---

### Chế độ 1: Độc lập (Một tệp PHP) — Khuyến nghị cho sản xuất

Tất cả tài nguyên được biên dịch thành một tệp tự chứa. Không cần thư mục `_/`.

```bash
# Bước 1: Xây dựng tệp độc lập
php build.php

# Bước 2: Tải Standalone.php lên máy chủ của bạn
# Bước 3: Đổi tên thành index.php (hoặc bất kỳ tên nào bạn muốn)
```

> **Cấu hình**: Tự động đặt `'use_embedded' => true`. Không cần cấu hình khác.

---

### Chế độ 2: Bình thường (Các tệp nguồn)

Cấu hình đa tệp cổ điển. Nhanh nhất cho phát triển.

```
your-web-root/
├── index.php        ← Điểm vào (require_once 'core.php')
├── core.php         ← Logic cốt lõi & cấu hình
└── _/               ← CSS, JS, icons, tệp dịch thuật
```

**Các bước:**
1. Sao chép `index.php`, `core.php`, và `_/` vào thư mục web của bạn.
2. Truy cập qua trình duyệt: `http://yoursite.com/`
3. Không cần cấu hình bổ sung.

---

### Chế độ 3: Triển khai thư mục con

Chạy FileLister bên trong thư mục con lập chỉ mục nội dung riêng của nó.

```
your-web-root/
├── files/           ← Thư mục bạn muốn lập chỉ mục
│   ├── index.php    ← Điểm nhập FileLister
│   └── core.php
└── _/               ← Tài sản chia sẻ (tự động phát hiện bởi quét parent)
```

Hàm `detect_assets_path()` tự động quét **lên đến 5 thư mục parent** để định vị thư mục tài sản `_/`. Không cần cấu hình `assets_path` thủ công trong hầu hết trường hợp.

Nếu tài sản không được tự động phát hiện:
```php
'assets_path' => '../_',   // Hoặc đường dẫn đầy đủ như '/var/www/html/_'
```

---

### Chế độ 4: Triển khai toàn cầu (Lập chỉ mục bất kỳ thư mục nào trên máy chủ)

Sử dụng **một cài đặt FileLister** để duyệt bất kỳ đường dẫn nào trên máy chủ, tách rời khỏi vị trí tập lệnh.

```
/var/www/html/
├── filelister/      ← FileLister sống ở đây
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← Thư mục bạn thực sự muốn lập chỉ mục
```

**Cấu hình trong `core.php`:**
```php
'base_path' => '/var/data',   // ← Đặt thư mục bạn muốn liệt kê
```

> `base_path` chấp nhận bất kỳ **đường dẫn hệ thống tệp tuyệt đối** nào mà quá trình PHP có thể đọc. Tập lệnh sẽ thực thi rằng tất cả điều hướng `?dir=` ở lại trong root này qua `realpath()` để ngăn chặn duyệt đường dẫn.

**Cấu hình máy chủ web** (để sử dụng FileLister làm chỉ mục thư mục):

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

**Apache (`.htaccess` trong thư mục đích):**
```apache
DirectoryIndex index.php FileLister.php index.html

# Route tất cả yêu cầu thư mục đến FileLister:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### Chế độ 5: Docker

```bash
docker-compose up -d
```

Truy cập tại `http://localhost:8080`. Chỉnh sửa `docker-compose.yml` để gắn thư mục đích của bạn.

---

### So sánh chế độ triển khai

| Chế độ | Tệp cần thiết | Tốt nhất cho |
|------|---------------|----------|
| **Độc lập** | `Standalone.php` chỉ | Triển khai nhanh, hosting chia sẻ |
| **Bình thường** | `index.php` + `core.php` + `_/` | Phát triển, kiểm soát đầy đủ |
| **Thư mục con** | Tương tự Bình thường, đặt trong thư mục con | Lập chỉ mục thư mục con cụ thể |
| **Toàn cầu** | Bình thường + cấu hình `base_path` | Một phiên bản lập chỉ mục bất kỳ đường dẫn máy chủ nào |
| **Docker** | `Dockerfile` + `docker-compose.yml` | Môi trường containerized |

---

## ⚙️ Cấu hình

Tất cả cài đặt nằm trong mảng `$config` trong `core.php` (hoặc `Standalone.php`).

### Chung

| Khóa | Mặc định | Mô tả |
|-----|---------|-------------|
| `title` | `''` | Tiêu đề trang tùy chỉnh. Nếu trống, tự động tạo từ đường dẫn. |
| `title_prefix` | `'Index of'` | Tiền tố cho tiêu đề tự động tạo. |
| `title_suffix` | `' - FileLister'` | Hậu tố cho tiêu đề tự động tạo. |
| `language` | `''` | Buộc một ngôn ngữ (`en`, `vi`, `zh`, `ja`…). Tự động phát hiện nếu trống. |
| `allowed_langs` | (18 ngôn ngữ) | Ngôn ngữ có sẵn trong menu thả xuống bộ chọn. |
| `theme` | `'ocean'` | Chủ đề mặc định. Tùy chọn: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | Chế độ xem mặc định. Tùy chọn: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | Chuỗi múi giờ PHP. |
| `date_format` | `'Y-m-d H:i:s'` | Chuỗi định dạng ngày PHP. |
| `base_path` | `''` | Thư mục gốc cho triển khai toàn cầu/thư mục con. |
| `favicon_path` | `''` | Đường dẫn đến favicon tùy chỉnh. |

### Tùy chọn hiển thị

| Khóa | Mặc định | Mô tả |
|-----|---------|-------------|
| `show_hidden` | `false` | Hiển thị tệp ẩn (bắt đầu bằng `.`). |
| `show_size` | `true` | Hiển thị cột kích thước tệp. |
| `show_date` | `true` | Hiển thị cột ngày sửa đổi lần cuối. |
| `show_type` | `true` | Hiển thị cột loại tệp (chế độ danh sách). |
| `show_folder_size` | `true` | Tính kích thước thư mục (đệ quy — có thể chậm cho thư mục lớn). |
| `show_breadcrumb` | `true` | Hiển thị breadcrumb điều hướng. |
| `show_footer` | `true` | Hiển thị thanh chân trang. |
| `show_copyright` | `true` | Hiển thị thông tin bản quyền trong chân trang. |
| `show_language_selector` | `true` | Hiển thị điều khiển chuyển đổi ngôn ngữ. |
| `show_theme_selector` | `true` | Hiển thị nút chuyển đổi chủ đề. |

### Tính năng

| Khóa | Mặc định | Mô tả |
|-----|---------|-------------|
| `enable_search` | `true` | Bật tìm kiếm tệp trực tiếp. |
| `enable_preview` | `true` | Bật modal xem trước tệp (hình ảnh, video, âm thanh, PDF, mã). |
| `enable_download` | `true` | Hiển thị nút tải xuống trên tệp. |
| `enable_share` | `true` | Bật modal chia sẻ tệp với mã QR. |
| `enable_qrcode` | `true` | Tạo mã QR trong modal chia sẻ. |
| `enable_shortcuts` | `true` | Bật phím tắt. |
| `enable_export` | `true` | Bật xuất/sao chép danh sách tệp (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | Kết xuất tệp `README.md` ở cuối danh sách thư mục. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | Danh sách được phân tách bằng dấu phẩy các thuật toán hash. Được hỗ trợ: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, và hơn 30 khác. |
| `hash_uppercase` | `true` | Hiển thị giá trị hash bằng chữ hoa. |
| `max_hash_size` | `1000` | Kích thước tệp tối đa (MB) được phép hash. |

### Bảo mật

| Khóa | Mặc định | Mô tả |
|-----|---------|-------------|
| `ignore_files` | (xem bên dưới) | Tệp để ẩn. Mặc định bao gồm `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | Phần mở rộng để ẩn. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | Thư mục để ẩn. |
| `allowed_extensions` | `[]` | Danh sách trắng phần mở rộng (trống = cho phép tất cả). |
| `protected_paths` | `['/etc', '/var/www/.git']` | Đường dẫn tuyệt đối luôn bị chặn. |
| `enable_rate_limit` | `true` | Bật giới hạn tốc độ dựa trên IP. |
| `rate_limit_requests` | `60` | Số yêu cầu tối đa mỗi cửa sổ. |
| `rate_limit_period` | `60` | Cửa sổ thời gian giới hạn tốc độ (giây). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | IP được miễn giới hạn tốc độ. |
| `trusted_proxies` | `[]` | IP được phép đặt `X-Forwarded-For`. Trống = tin cậy không ai. |
| `enable_dev` | `true` | **⚠️ Đặt thành `false` trong sản xuất.** Bật hiển thị lỗi PHP và tắt cache. |

> [!CAUTION]
> Luôn đặt `'enable_dev' => false` trước khi triển khai sản xuất. Ở chế độ dev, lỗi PHP được hiển thị có thể tiết lộ đường dẫn tệp, chi tiết cấu hình và dấu vết ngăn xếp cho khách truy cập.

### Nâng cao

| Khóa | Mặc định | Mô tả |
|-----|---------|-------------|
| `assets_path` | `''` | Đường dẫn đến thư mục tài sản `_/`. Tự động phát hiện nếu trống. |
| `use_embedded` | `false` | Buộc chế độ tài sản nhúng (được sử dụng bởi `Standalone.php`). |
| `thumbnail_directory` | `''` | Đường dẫn tùy chỉnh cho cache thumbnail. Tự động đặt thành `_/thumbs` nếu trống. |
| `thumbnail_width` | `200` | Chiều rộng thumbnail tối đa (px). |
| `thumbnail_height` | `200` | Chiều cao thumbnail tối đa (px). |
| `thumbnail_cache_expiry` | `30` | Số ngày trước khi cache thumbnail được dọn dẹp. `0` = luôn dọn dẹp. `-1` = không bao giờ dọn dẹp. |
| `readme_files` | (danh sách) | Tên tệp để quét cho kết xuất README. |
| `custom_css` | `'_/css/custom.css'` | Đường dẫn đến tệp CSS tùy chỉnh (được tải nếu tồn tại). |
| `custom_js` | `'_/js/custom.js'` | Đường dẫn đến tệp JS tùy chỉnh (được tải nếu tồn tại). |
| `serve_index_files` | `false` | Phục vụ `index.html` trực tiếp nếu có. ⚠️ Nguy cơ XSS tiềm ẩn nếu tệp không đáng tin cậy tồn tại. |
| `index_files` | `['index.html', …]` | Tên tệp chỉ mục để tìm kiếm. |

### Cấu hình máy chủ làm chỉ mục thư mục

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### Cho phép máy chủ bên ngoài (CSP)
FileLister sử dụng **Chính sách Bảo mật Nội dung** nghiêm ngặt. Để tải tài nguyên từ tên miền bên ngoài, chỉnh sửa tiêu đề `Content-Security-Policy` trong `core.php`:

```php
// Thêm tên miền của bạn vào chỉ thị thích hợp:
// img-src: cho hình ảnh bên ngoài
// script-src: cho tập lệnh bên ngoài (sử dụng với thận trọng)
// style-src: cho CSS bên ngoài
```

---

## 🎨 Tùy chỉnh chủ đề

### Chủ đề có sẵn
| Chủ đề | Mô tả |
|-------|-------------|
| `light` | Chủ đề trắng sạch |
| `dark` | Chế độ tối |
| `auto` | Theo sở thích hệ thống |
| `ocean` | Sắc thái đại dương xanh |
| `forest` | Sắc thái trái đất xanh |
| `dracula` | Tối tím Dracula |
| `nord` | Bảng màu Bắc Cực Bắc Âu |
| `high-contrast` | Tập trung vào khả năng tiếp cận |
| `cute` | Glassmorphism anime với hình nền |

### Tạo chủ đề tùy chỉnh

1. **Sao chép một chủ đề**: Nhân bản `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **Chỉnh sửa biến CSS**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... các biến khác */
}
```

3. **Đăng ký trong JS**: Thêm tên chủ đề của bạn vào mảng `toggleTheme()` trong `_/js/app.js`.

4. **Kích hoạt trong cấu hình**:
```php
'theme' => 'mytheme',
```

5. **Danh sách trắng trong cấu hình** (để bộ chọn chủ đề hoạt động):  Trong `index.php`, tìm kiếm `$allowed_themes` và thêm `'mytheme'` vào mảng.

---

## 🧩 Hook HTML tùy chỉnh

Chèn HTML tùy chỉnh, CSS, hoặc JavaScript tại các vị trí trang cụ thể mà không chỉnh sửa tệp cốt lõi. Cấu hình mảng `html_hooks` trong `core.php`:

```php
'html_hooks' => array(
    'head_end'      => '',  // Trước </head>
    'body_start'    => '',  // Sau <body>
    'header_start'  => '',  // Sau <header> mở
    'header_end'    => '',  // Trước </header>
    'main_before'   => '',  // Trước <main>
    'main_start'    => '',  // Bên trong <main>, trước các mục
    'main_end'      => '',  // Bên trong <main>, sau các mục
    'main_after'    => '',  // Sau </main>
    'footer_before' => '',  // Trước <footer>
    'footer_start'  => '',  // Sau <footer> mở
    'footer_end'    => '',  // Trước </footer>
    'footer_after'  => '',  // Sau </footer>
    'body_end'      => '',  // Trước </body>
    'html_end'      => '',  // Trước </html>
),
```

### Ví dụ: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 Hỗ trợ đa ngôn ngữ
FileLister tự động phát hiện ngôn ngữ trình duyệt và hỗ trợ **18+ ngôn ngữ**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

Đặt ngôn ngữ cố định với `'language' => 'vi'`, hoặc để trống cho tự động phát hiện.

---

## 👁️ Xem trước tệp & Viewer
Trình xem hiệu suất cao tích hợp cho nhiều loại tệp:
- **Hình ảnh**: jpg, png, gif, webp, svg (với thumbnail thời gian thực trong chế độ lưới)
- **Video**: mp4, webm, avi, mov, mkv
- **Âm thanh**: mp3, ogg, flac, wav, m4a
- **Tài liệu**: Trình xem PDF tích hợp và kết xuất Markdown
- **Mã**: Làm nổi bật cú pháp qua Prism.js cho hơn 100 ngôn ngữ

---

## 🔗 Chia sẻ & Tải xuống
- Tạo mã **QR tức thì** để chuyển tệp di động.
- Liên kết tải xuống trực tiếp cho tất cả tệp.
- Chia sẻ tệp an toàn qua URL duy nhất.
- **Hỗ trợ Unicode đầy đủ**: tên tệp trong tiếng Việt, Trung Quốc, Nhật Bản, Ả Rập và các kịch bản không phải ASCII khác được mã hóa phần trăm chính xác trong liên kết chia sẻ và mã QR.

---

## ⌨️ Phím tắt
| Phím | Hành động |
|-----|--------|
| `/` hoặc `Ctrl+F` | Tập trung hộp tìm kiếm |
| `Esc` | Đóng modal / xóa tìm kiếm |
| `↑` / `↓` | Điều hướng qua các mục |
| `Enter` | Mở mục đã chọn |
| `g` sau đó `h` | Đi về nhà (root) |
| `g` sau đó `u` | Đi lên một cấp thư mục |
| `?` | Hiển thị trợ giúp phím tắt |

---

## 🛡️ Chi tiết bảo mật

FileLister bao gồm nhiều lớp bảo mật tăng cường:

| Lớp | Chi tiết |
|-------|--------|
| **Duyệt đường dẫn** | Đầu vào `?dir=` được xác thực bằng `realpath()` và ràng buộc vào `$lister_root`. |
| **Nonce CSP** | Nonce ngẫu nhiên 128-bit mỗi yêu cầu trên tất cả tập lệnh nội tuyến. Không `unsafe-inline`. |
| **Giới hạn tốc độ** | Throttling dựa trên IP được lưu trữ trong tệp tạm thời. Mặc định: 60 req/60s. |
| **Proxy tin cậy** | `X-Forwarded-For` chỉ được tin cậy từ IP proxy được cấu hình rõ ràng. |
| **Tệp nhạy cảm** | `.env`, `.git`, `.htaccess`, tệp PHP tự động ẩn. |
| **Tiêu đề bảo mật** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` để tắt camera/mic/geo. |
| **HSTS** | `Strict-Transport-Security` được gửi tự động khi trên HTTPS. |
| **CORS** | Điểm cuối xuất chỉ cho phép yêu cầu same-origin. Không phản ánh origin tùy ý. |
| **Không Hash cũ** | MD5 và SHA-1 bị loại trừ khỏi loại hash mặc định. |
| **Bảo vệ Symlink** | Symlink bị bỏ qua trong duyệt thư mục để ngăn vòng lặp và rò rỉ. |
| **Chế độ Dev** | `enable_dev: false` trong sản xuất tắt hiển thị lỗi. |

> [!IMPORTANT]
> Sau khi thiết lập, ngay lập tức đặt `'enable_dev' => false` để ngăn thông báo lỗi tiết lộ nội bộ máy chủ.

---

## 📋 Yêu cầu
- **PHP**: 5.2 trở lên (đã kiểm tra lên đến PHP 8.4+)
- **Phần mở rộng**: `json` (bắt buộc), `gd` (tùy chọn — cho thumbnail), `zip` (tùy chọn)

---

## 📜 Nhật ký thay đổi

### v1.5.36 — Phát hành bảo mật & sửa lỗi

**Sửa lỗi bảo mật:**
- 🔒 **[Nghiêm trọng] Sửa lỗ hổng phản ánh CORS** trong điểm cuối `?export=` — không còn phản ánh tiêu đề `Origin` tùy ý
- 🔒 **[Nghiêm trọng] Sửa XSS trong xem trước tệp** — tên tệp trong "loại không được hỗ trợ" xem trước không được thoát trước khi chèn vào DOM
- 🔒 **[Nghiêm trọng] `enable_dev` giờ mặc định là `false`** — ngăn tiết lộ lỗi PHP ngẫu nhiên trong sản xuất
- 🔒 **[Cao] Xác thực cookie `dir_theme`** trước khi sử dụng để ngăn hành vi bất ngờ

**Sửa lỗi:**
- 🐛 **Sửa tạo mã QR thất bại** cho tệp có tên Unicode (tiếng Việt, Trung Quốc, Nhật Bản, v.v.)
- 🐛 **Sửa liên kết chia sẻ bị hỏng** cho tệp có tên tệp không phải ASCII
- 🐛 **Sửa xem trước hình ảnh không tải** cho tệp có tên tệp Unicode
- 🐛 **Sửa thẻ `</div>` trùng lặp** trong HTML chân trang (gây vấn đề bố cục trong một số trình duyệt)
- 🐛 **Sửa `style.css` được tải hai lần** (lãng phí băng thông, phân tích kép)
- 🐛 **Sửa `custom.js` / `custom.css` bị thiếu** từ xây dựng `Standalone.php`
- 🐛 **Sửa khôi phục chủ đề** — chủ đề `dracula`, `nord`, `high-contrast`, `cute` không còn đặt lại khi tải lại trang
- 🐛 **Sửa biểu tượng SVG trùng lặp** được chèn cùng với thumbnail trong chế độ lưới
- 🐛 **Sửa phân tích cấu hình điều hướng AJAX** — phân tích regex mạnh mẽ hơn thay vì trích xuất dựa trên chỉ mục dễ vỡ
- 🐛 **Sửa `previewText()` hiển thị HTML 404** làm nội dung tệp khi tệp không thể truy cập
- 🐛 **Sửa mã chết `changeLanguage()`** tham chiếu phần tử `langToggle` không tồn tại
- 🐛 **Thêm SHA-512/224 và SHA-512/256** vào bản đồ thuật toán hash (được liệt kê trong tài liệu nhưng thiếu trong mã)
- 🐛 **Thay thế lệnh `alert()`** trong sao chép clipboard bằng thông báo toast không chặn
- 🐛 **Sửa điều hướng thư viện hình ảnh** — hình ảnh bị ẩn bởi bộ lọc/tìm kiếm giờ được loại trừ khỏi duyệt prev/next
- 🐛 **Sửa xem trước `audio`/`video`** — thêm trình xử lý lỗi khi phương tiện không tải được

---

## ☕ Hỗ trợ công việc của tôi
Thích thú với tập lệnh PHP mã nguồn mở này?
- [Mua cho tôi 🍻](https://buymeacoffee.com/trong)
- Gửi tiền qua ❤️ [PayPal](https://paypal.me/DaoVanTrong)

---

## 📝 Giấy phép
Giấy phép MIT — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
