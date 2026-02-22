<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: Modern PHP Directory Listing Script v1.5.36

FileLister is a powerful, lightweight, and modern **PHP directory listing script** that transforms your server files into a beautiful, mobile-friendly **web file explorer**. It's the perfect alternative to `h5ai` or `Apache Index`, offering a single-file deployment option and built-in file previews.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 Table of Contents
- [✨ Features](#-features)
- [📦 Installation](#-installation)
- [⚙️ Configuration](#-configuration)
- [🎨 Themes](#-theme-customization)
- [🧩 HTML Hooks](#-custom-html-hooks)
- [🌍 Multi-language Support](#-multi-language-support)
- [👁️ File Preview](#-file-preview--viewer)
- [🔗 Share & Download](#-share--download)
- [⌨️ Keyboard Shortcuts](#-keyboard-shortcuts)
- [🛡️ Security Details](#-security-details)
- [📋 Requirements](#-requirements)

---

## ✨ Features

### 🚀 **Production Ready & Fast**
- **Standalone Version**: Single-file deployment (`Standalone.php`) with all assets embedded. Run `php build.php` to generate.
- **Docker Support**: Ready-to-use `Dockerfile` and `docker-compose.yml`.
- **Serve Index**: Optionally serve `index.html` if present in a directory.

### 🎨 **Modern User Interface**
- **Clean & Responsive**: Mobile-first layout, works on any device.
- **9 Themes**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (anime glassmorphism).
- **Grid & List Views**: Toggle between card grid and detailed list views.
- **README Rendering**: Automatically renders `README.md` files at the bottom of directory listings.
- **Localized**: Language selector with 18+ supported locales.

### 🛡️ **Security Hardened**
- **CSP with Nonces**: Per-request cryptographic nonce on all inline scripts. No `unsafe-inline`.
- **Rate Limiting**: Built-in anti-DDoS request throttling (60 req/60s by default).
- **Trusted Proxies**: Safe `X-Forwarded-For` handling — only applied if request comes from a trusted proxy IP.
- **Path Traversal Protection**: All `?dir=` input is resolved via `realpath()` and constrained to `$lister_root`.
- **Sensitive File Hiding**: Auto-ignores `.env`, `.git`, `.htaccess`, and PHP files.
- **Security Headers**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (HTTPS only).
- **No MD5/SHA-1**: Default hash set is `CRC32,XXH128,SHA-256,SHA3-256`. MD5 and SHA-1 are excluded by default.

### 🔍 **File Integrity (Info & Hash)**
- Verify 40+ hash algorithms per file, including SHA-3, WHIRLPOOL, XXH128, CRC32.
- Configurable maximum file size for hashing.
- Results displayed inline in the Info modal.

### 📤 **Export & Share**
- Copy/Download file list in **JSON, CSV, TSV, NDJSON** formats.
- Share files via QR codes and direct links.

---

## 📦 Installation & Deployment Modes

FileLister supports 4 deployment modes. Pick the one that fits your setup:

---

### Mode 1: Standalone (Single PHP File) — Recommended for Production

All assets are compiled into one self-contained file. No `_/` folder needed.

```bash
# Step 1: Build the standalone file
php build.php

# Step 2: Upload Standalone.php to your server
# Step 3: Rename it to index.php (or any name you prefer)
```

> **Config**: Automatically sets `'use_embedded' => true`. No other config needed.

---

### Mode 2: Normal (Source Files)

Classic multi-file setup. Fastest for development.

```
your-web-root/
├── index.php        ← Entry point (require_once 'core.php')
├── core.php         ← Core logic & config
└── _/               ← CSS, JS, icons, translation files
```

**Steps:**
1. Copy `index.php`, `core.php`, and `_/` to your web directory.
2. Access via browser: `http://yoursite.com/`
3. No additional configuration needed.

---

### Mode 3: Subdirectory Deployment

Run FileLister inside a subfolder that indexes its own content.

```
your-web-root/
├── files/           ← Directory you want to index
│   ├── index.php    ← FileLister entry point
│   └── core.php
└── _/               ← Shared assets (auto-detected by parent scan)
```

The `detect_assets_path()` function automatically scans **up to 5 parent directories** to locate the `_/` assets folder. No manual `assets_path` config required in most cases.

If assets aren't auto-detected:
```php
'assets_path' => '../_',   // Or full path like '/var/www/html/_'
```

---

### Mode 4: Global Deployment (Index Any Directory on Server)

Use a **single FileLister installation** to browse any path on the server, decoupled from the script location.

```
/var/www/html/
├── filelister/      ← FileLister lives here
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← Directory you actually want to index
```

**Configuration in `core.php`:**
```php
'base_path' => '/var/data',   // ← Set the directory you want to list
```

> `base_path` accepts any **absolute filesystem path** that the PHP process can read. The script will enforce that all `?dir=` navigation stays within this root via `realpath()` to prevent path traversal.

**Web Server Configuration** (to use FileLister as directory index):

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

**Apache (`.htaccess` in the target directory):**
```apache
DirectoryIndex index.php FileLister.php index.html

# Route all directory requests to FileLister:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### Mode 5: Docker

```bash
docker-compose up -d
```

Access at `http://localhost:8080`. Edit `docker-compose.yml` to mount your target directory.

---

### Deployment Mode Comparison

| Mode | Files Required | Best For |
|------|---------------|----------|
| **Standalone** | `Standalone.php` only | Quick deployment, shared hosting |
| **Normal** | `index.php` + `core.php` + `_/` | Development, full control |
| **Subdirectory** | Same as Normal, placed in subfolder | Indexing a specific subfolder |
| **Global** | Normal + `base_path` config | Single instance indexing any server path |
| **Docker** | `Dockerfile` + `docker-compose.yml` | Containerized environments |

---

## ⚙️ Configuration

All settings are in the `$config` array in `core.php` (or `Standalone.php`).

### General


| Key | Default | Description |
|-----|---------|-------------|
| `title` | `''` | Custom page title. If empty, auto-generated from path. |
| `title_prefix` | `'Index of'` | Prefix for auto-generated title. |
| `title_suffix` | `' - FileLister'` | Suffix for auto-generated title. |
| `language` | `''` | Force a locale (`en`, `vi`, `zh`, `ja`…). Auto-detects if empty. |
| `allowed_langs` | (18 languages) | Languages available in the selector dropdown. |
| `theme` | `'ocean'` | Default theme. Options: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | Default view. Options: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | PHP timezone string. |
| `date_format` | `'Y-m-d H:i:s'` | PHP date format string. |
| `base_path` | `''` | Root directory for global/subdirectory deployment. |
| `favicon_path` | `''` | Path to custom favicon. |

### Display Options

| Key | Default | Description |
|-----|---------|-------------|
| `show_hidden` | `false` | Show hidden files (starting with `.`). |
| `show_size` | `true` | Show file size column. |
| `show_date` | `true` | Show last modified date column. |
| `show_type` | `true` | Show file type column (list view). |
| `show_folder_size` | `true` | Calculate folder sizes (recursive — can be slow for large folders). |
| `show_breadcrumb` | `true` | Show navigation breadcrumb. |
| `show_footer` | `true` | Show footer bar. |
| `show_copyright` | `true` | Show copyright info in footer. |
| `show_language_selector` | `true` | Display language switcher control. |
| `show_theme_selector` | `true` | Display theme toggle button. |

### Features

| Key | Default | Description |
|-----|---------|-------------|
| `enable_search` | `true` | Enable live file search. |
| `enable_preview` | `true` | Enable file preview modal (images, video, audio, PDF, code). |
| `enable_download` | `true` | Show download buttons on files. |
| `enable_share` | `true` | Enable file sharing modal with QR code. |
| `enable_qrcode` | `true` | Generate QR codes in share modal. |
| `enable_shortcuts` | `true` | Enable keyboard shortcuts. |
| `enable_export` | `true` | Enable export/copy file list (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | Render `README.md` files at the bottom of directory listings. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | Comma-separated list of hash algorithms. Supported: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, and 30+ more. |
| `hash_uppercase` | `true` | Display hash values in uppercase. |
| `max_hash_size` | `1000` | Max file size (MB) allowed for hashing. |

### Security

| Key | Default | Description |
|-----|---------|-------------|
| `ignore_files` | (see below) | Files to hide. Defaults include `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | Extensions to hide. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | Folders to hide. |
| `allowed_extensions` | `[]` | Whitelist of extensions (empty = allow all). |
| `protected_paths` | `['/etc', '/var/www/.git']` | Absolute paths that are always blocked. |
| `enable_rate_limit` | `true` | Enable per-IP rate limiting. |
| `rate_limit_requests` | `60` | Maximum requests per window. |
| `rate_limit_period` | `60` | Rate limit time window (seconds). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | IPs exempt from rate limiting. |
| `trusted_proxies` | `[]` | IPs allowed to set `X-Forwarded-For`. Empty = trust nobody. |
| `enable_dev` | `true` | **⚠️ Set to `false` in production.** Enables PHP error display and disables cache. |

> [!CAUTION]
> Always set `'enable_dev' => false` before deploying to production. In dev mode, PHP errors are displayed which can expose file paths, configuration details, and stack traces to visitors.

### Advanced

| Key | Default | Description |
|-----|---------|-------------|
| `assets_path` | `''` | Path to `_/` assets folder. Auto-detected if empty. |
| `use_embedded` | `false` | Force embedded assets mode (used by `Standalone.php`). |
| `thumbnail_directory` | `''` | Custom path for thumbnail cache. Auto-set to `_/thumbs` if empty. |
| `thumbnail_width` | `200` | Max thumbnail width (px). |
| `thumbnail_height` | `200` | Max thumbnail height (px). |
| `thumbnail_cache_expiry` | `30` | Days before cached thumbnails are purged. `0` = always clean. `-1` = never clean. |
| `readme_files` | (list) | Filenames to scan for README rendering. |
| `custom_css` | `'_/css/custom.css'` | Path to custom CSS file (loaded if it exists). |
| `custom_js` | `'_/js/custom.js'` | Path to custom JS file (loaded if it exists). |
| `serve_index_files` | `false` | Serve `index.html` directly if present. ⚠️ Potential XSS risk if untrusted files exist. |
| `index_files` | `['index.html', …]` | Index file names to look for. |

### Server Configuration as Directory Index

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### Allowing External Hosts (CSP)
FileLister uses a strict **Content Security Policy**. To load resources from external domains, edit the `Content-Security-Policy` header in `core.php`:

```php
// Add your domain to the appropriate directive:
// img-src: for external images
// script-src: for external scripts (use with caution)
// style-src: for external CSS
```

---

## 🎨 Theme Customization

### Available Themes
| Theme | Description |
|-------|-------------|
| `light` | Clean white theme |
| `dark` | Dark mode |
| `auto` | Follows OS preference |
| `ocean` | Blue ocean tones |
| `forest` | Green earth tones |
| `dracula` | Dracula dark purple |
| `nord` | Nordic arctic palette |
| `high-contrast` | Accessibility focused |
| `cute` | Anime glassmorphism with background image |

### Create a Custom Theme

1. **Copy a theme**: Duplicate `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **Edit CSS variables**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... other variables */
}
```

3. **Register in JS**: Add your theme name to the `toggleTheme()` array in `_/js/app.js`.

4. **Activate in config**:
```php
'theme' => 'mytheme',
```

5. **Whitelist in config** (for the theme selector to work):  In `index.php`, search for `$allowed_themes` and add `'mytheme'` to the array.

---

## 🧩 Custom HTML Hooks

Inject custom HTML, CSS, or JavaScript at specific page locations without editing core files. Configure the `html_hooks` array in `core.php`:

```php
'html_hooks' => array(
    'head_end'      => '',  // Before </head>
    'body_start'    => '',  // After <body>
    'header_start'  => '',  // After <header> opens
    'header_end'    => '',  // Before </header>
    'main_before'   => '',  // Before <main>
    'main_start'    => '',  // Inside <main>, before items
    'main_end'      => '',  // Inside <main>, after items
    'main_after'    => '',  // After </main>
    'footer_before' => '',  // Before <footer>
    'footer_start'  => '',  // After <footer> opens
    'footer_end'    => '',  // Before </footer>
    'footer_after'  => '',  // After </footer>
    'body_end'      => '',  // Before </body>
    'html_end'      => '',  // Before </html>
),
```

### Example: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 Multi-language Support
FileLister auto-detects browser language and supports **18+ languages**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

Set a fixed language with `'language' => 'vi'`, or leave empty for auto-detection.

---

## 👁️ File Preview & Viewer
Integrated high-performance viewer for various file types:
- **Images**: jpg, png, gif, webp, svg (with real-time thumbnails in grid view)
- **Videos**: mp4, webm, avi, mov, mkv
- **Audio**: mp3, ogg, flac, wav, m4a
- **Documents**: Built-in PDF viewer and Markdown rendering
- **Code**: Syntax highlighting via Prism.js for 100+ languages

---

## 🔗 Share & Download
- Generate instant **QR Codes** for mobile file transfers.
- Direct download links for all files.
- Secure file sharing via unique URLs.
- **Full Unicode support**: filenames in Vietnamese, Chinese, Japanese, Arabic, and other non-ASCII scripts are correctly percent-encoded in share links and QR codes.

---

## ⌨️ Keyboard Shortcuts
| Key | Action |
|-----|--------|
| `/` or `Ctrl+F` | Focus search box |
| `Esc` | Close modal / clear search |
| `↑` / `↓` | Navigate through items |
| `Enter` | Open selected item |
| `g` then `h` | Go to home (root) |
| `g` then `u` | Go up one directory level |
| `?` | Show keyboard shortcuts help |

---

## 🛡️ Security Details

FileLister includes multiple hardened security layers:

| Layer | Detail |
|-------|--------|
| **Path Traversal** | `?dir=` input is validated with `realpath()` and constrained to `$lister_root`. |
| **CSP Nonce** | Per-request 128-bit random nonce on all inline scripts. No `unsafe-inline`. |
| **Rate Limiting** | IP-based throttling stored in temp files. Default: 60 req/60s. |
| **Trusted Proxies** | `X-Forwarded-For` is only trusted from explicitly configured proxy IPs. |
| **Sensitive Files** | `.env`, `.git`, `.htaccess`, PHP files automatically hidden. |
| **Security Headers** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` to disable camera/mic/geo. |
| **HSTS** | `Strict-Transport-Security` sent automatically when on HTTPS. |
| **CORS** | Export endpoint only allows same-origin requests. No arbitrary origin reflection. |
| **No Legacy Hashes** | MD5 and SHA-1 are excluded from default hash types. |
| **Symlink Protection** | Symlinks are skipped during folder traversal to prevent loops and leaks. |
| **Dev Mode** | `enable_dev: false` in production disables error display. |

> [!IMPORTANT]
> After setup, immediately set `'enable_dev' => false` to prevent error messages from exposing server internals.

---

## 📋 Requirements
- **PHP**: 5.2 or higher (tested up to PHP 8.4+)
- **Extensions**: `json` (required), `gd` (optional — for thumbnails), `zip` (optional)

---

## 📜 Changelog

### v1.5.36 — Security & Bug Fix Release

**Security Fixes:**
- 🔒 **[Critical] Fixed CORS reflection vulnerability** in `?export=` endpoint — no longer reflects arbitrary `Origin` headers
- 🔒 **[Critical] Fixed XSS in file preview** — filename in "unsupported type" preview was not escaped before inserting into DOM
- 🔒 **[Critical] `enable_dev` now defaults to `false`** — prevents accidental PHP error disclosure in production
- 🔒 **[High] Validated `dir_theme` cookie** before use to prevent unexpected behavior

**Bug Fixes:**
- 🐛 **Fixed QR code generation failing** for files with Unicode names (Vietnamese, Chinese, Japanese, etc.)
- 🐛 **Fixed share link broken** for files with Unicode/non-ASCII filenames
- 🐛 **Fixed image preview not loading** for files with Unicode filenames
- 🐛 **Fixed duplicate `</div>` tag** in footer HTML (caused layout issues in some browsers)
- 🐛 **Fixed `style.css` being loaded twice** (wasted bandwidth, double-parse)
- 🐛 **Fixed `custom.js` / `custom.css` missing** from `Standalone.php` build
- 🐛 **Fixed theme restore** — `dracula`, `nord`, `high-contrast`, `cute` themes no longer reset on page reload
- 🐛 **Fixed duplicate SVG icons** injected alongside thumbnails in grid view
- 🐛 **Fixed AJAX navigation config parsing** — more robust regex instead of brittle index-based extraction
- 🐛 **Fixed `previewText()` showing 404 HTML** as file content when file is inaccessible
- 🐛 **Fixed `changeLanguage()` dead code** referencing non-existent `langToggle` element
- 🐛 **Added SHA-512/224 and SHA-512/256** to hash algorithm map (were listed in docs but missing from code)
- 🐛 **Replaced `alert()` calls** in clipboard copy with non-blocking toast notifications
- 🐛 **Fixed image gallery navigation** — images hidden by filter/search are now excluded from prev/next traversal
- 🐛 **Fixed `audio`/`video` previews** — added error handler when media fails to load

---

## ☕ Support My Work
Enjoying this open-source PHP script?
- [Buy me a 🍻](https://buymeacoffee.com/trong)
- Tip via ❤️ [PayPal](https://paypal.me/DaoVanTrong)

---

## 📝 License
MIT License — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
