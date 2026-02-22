<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: סקריפט רשימת ספריות PHP מודרני v1.5.36

FileLister הוא סקריפט רשימת ספריות PHP חזק, קל משקל ומודרני שממיר את קבצי השרת שלך לחוקר קבצים יפה, ידידותי לנייד **web file explorer**. זהו האלטרנטיבה המושלמת ל-`h5ai` או `Apache Index`, המציע אפשרות פריסת קובץ יחיד ותצוגות מקדימות של קבצים. מובנות.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 תוכן עניינים
- [✨ תכונות](#-תכונות)
- [📦 התקנה](#-התקנה)
- [⚙️ קונפיגורציה](#-קונפיגורציה)
- [🎨 עיצובים](#-עיצובים)
- [🧩 וווק HTML מותאמים אישית](#-וווק-html-מותאמים-אישית)
- [🌍 תמיכה רב-לשונית](#-תמיכה-רב-לשונית)
- [👁️ תצוגה מקדימה של קובץ](#-תצוגה-מקדימה-של-קובץ--viewer)
- [🔗 שתף & הורד](#-שתף--הורד)
- [⌨️ קיצורי מקלדת](#-קיצורי-מקלדת)
- [🛡️ פרטי אבטחה](#-פרטי-אבטחה)
- [📋 דרישות](#-דרישות)

---

## ✨ תכונות

### 🚀 **מוכן לייצור & מהיר**
- **גרסה עצמאית**: פריסת קובץ יחיד (`Standalone.php`) עם כל המשאבים מוטמעים. הפעל `php build.php` כדי ליצור.
- **תמיכה ב-Docker**: `Dockerfile` ו-`docker-compose.yml` מוכנים לשימוש.
- **שרת אינדקס**: שרת אופציונלי `index.html` אם קיים בתיקייה.

### 🎨 **ממשק משתמש מודרני**
- **נקי & רספונסיבי**: פריסת mobile-first, עובד על כל המכשירים.
- **9 ערכובים**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (anime glassmorphism).
- **תצוגת רשת & רשימת תצוגות**: מעבר בין תצוגת רשת כרטיסים ותצוגת רשימה מפורטת.
- **עיבוד README**: מעבד אוטומטית קבצי `README.md` בתחתית רשימות התיקיות.
- **מקומן**: בוחר שפה עם 18+ אזורים נתמכים.

### 🛡️ **אבטחה משופרת**
- **CSP עם Nonces**: nonce קריפטוגרפי לפי בקשה על כל סקריפטים inline. ללא `unsafe-inline`.
- **הגבלת קצב**: throttling בקשות אנטי-DDoS משולב (60 req/60s כברירת מחדל).
- **פרוקסי מהימנים**: טיפול ב-`X-Forwarded-For` מאובטח — מיושם רק אם הבקשה מגיעה מ-IP פרוקסי מהימן.
- **הגנת ניווט נתיב**: כל קלט `?dir=` מתורגם דרך `realpath()` וקשור ל-`$lister_root`.
- **הסתרת קבצים רגישים**: מתעלם אוטומטית מ-`.env`, `.git`, `.htaccess`, וקבצי PHP.
- **כותרות אבטחה**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (רק HTTPS).
- **ללא MD5/SHA-1**: קבוצת hash ברירת מחדל מוגדרת ל-`CRC32,XXH128,SHA-256,SHA3-256`. MD5 ו-SHA-1 מוצאים כברירת מחדל.

### 🔍 **שלמות קובץ (מידע & Hash)**
- מאמת 40+ אלגוריתמי hash לקובץ, כולל SHA-3, WHIRLPOOL, XXH128, CRC32.
- גודל קובץ מקסימלי ניתן להגדרה עבור hashing.
- תוצאות מוצגות inline במודאל מידע.

### 📤 **ייצוא & שיתוף**
- העתק/הורד רשימת קבצים ב**JSON, CSV, TSV, NDJSON** פורמטים.
- שתף קבצים דרך קודי QR וקישורים ישירים.

---

## 📦 התקנה & מצבי פריסה

FileLister תומך ב-4 מצבי פריסה. בחר את זה שמתאים לתצורה שלך:

---

### מצב 1: עצמאי (קובץ PHP יחיד) — מומלץ לייצור

כל הנכסים מתורגמים לקובץ עצמאי. אין צורך בתיקיית `_/`.

```bash
# שלב 1: בנה את הקובץ העצמאי
php build.php

# שלב 2: העלה Standalone.php לשרת שלך
# שלב 3: שנה שם ל-index.php (או כל שם שתרצה)
```

> **Config**: מגדיר אוטומטית `'use_embedded' => true`. אין צורך ב-config נוסף.

---

### מצב 2: רגיל (קבצי מקור)

תצורה קלאסית של קבצים מרובים. הכי מהירה לפיתוח.

```
your-web-root/
├── index.php        ← נקודת כניסה (require_once 'core.php')
├── core.php         ← לוגיקה ליבה & config
└── _/               ← קבצי CSS, JS, איקונים, תרגומים
```

**שלבים:**
1. העתק `index.php`, `core.php`, ו-`_/` לתיקיית האינטרנט שלך.
2. גש דרך דפדפן: `http://yoursite.com/`
3. אין צורך ב-config נוסף.

---

### מצב 3: פריסת תת-ספרייה

הפעל FileLister בתת-ספרייה שמכילה את התוכן שלה.

```
your-web-root/
├── files/           ← ספרייה שתרצה להכיל
│   ├── index.php    ← נקודת כניסה FileLister
│   └── core.php
└── _/               ← נכסים משותפים (auto-מזוהים על ידי סריקת הורה)
```

הפונקציה `detect_assets_path()` סורקת אוטומטית **עד 5 ספריות הורה** כדי לאתר את תיקיית נכסי `_/`. אין צורך ב-config `assets_path` ידני ברוב המקרים.

אם נכסים לא auto-מזוהים:
```php
'assets_path' => '../_',   // או נתיב מלא כמו '/var/www/html/_'
```

---

### מצב 4: פריסה גלובלית (הכל את כל הספרייה בשרת)

השתמש ב**התקנה יחידה של FileLister** כדי לעיין בכל נתיב בשרת, מנותק ממיקום הסקריפט.

```
/var/www/html/
├── filelister/      ← FileLister חי כאן
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← ספרייה שתרצה להכיל באמת
```

**קונפיגורציה ב-`core.php`:**
```php
'base_path' => '/var/data',   // ← הגדר את הספרייה שתרצה לרשום
```

> `base_path` מקבל כל **נתיב מערכת קבצים מוחלט** שהתהליך PHP יכול לקרוא. הסקריפט יכפה שכל ניווט `?dir=` יישאר בתוך שורש זה דרך `realpath()` כדי למנוע ניווט נתיב.

**קונפיגורציית שרת אינטרנט** (כדי להשתמש ב-FileLister כאינדקס ספרייה):

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

**Apache (`.htaccess` בספריית יעד):**
```apache
DirectoryIndex index.php FileLister.php index.html

# נתב את כל בקשות הספרייה ל-FileLister:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### מצב 5: Docker

```bash
docker-compose up -d
```

גש ב-`http://localhost:8080`. ערוך `docker-compose.yml` כדי להצמיד את ספריית היעד שלך.

---

### השוואת מצבי פריסה

| מצב | קבצים נדרשים | הכי טוב ל |
|------|---------------|----------|
| **עצמאי** | רק `Standalone.php` | פריסה מהירה, אירוח משותף |
| **רגיל** | `index.php` + `core.php` + `_/` | פיתוח, שליטה מלאה |
| **תת-ספרייה** | כמו רגיל, ממוקם בתת-ספרייה | הכלה של תת-ספרייה ספציפית |
| **גלובלי** | רגיל + config `base_path` | מופע יחיד מכיל כל נתיב שרת |
| **Docker** | `Dockerfile` + `docker-compose.yml` | סביבות מוכלות |

---

## ⚙️ קונפיגורציה

כל ההגדרות נמצאות ב-array `$config` ב-`core.php` (או `Standalone.php`).

### כללי

| מפתח | ברירת מחדל | תיאור |
|-----|---------|-------------|
| `title` | `''` | כותרת עמוד מותאמת אישית. אם ריק, auto-נוצר מנתיב. |
| `title_prefix` | `'Index of'` | קידומת לכותרת auto-נוצרת. |
| `title_suffix` | `' - FileLister'` | סיומת לכותרת auto-נוצרת. |
| `language` | `''` | כפה אזור (`en`, `vi`, `zh`, `ja`…). auto-מזהה אם ריק. |
| `allowed_langs` | (18 שפות) | שפות זמינות בתפריט נפתח של בוחר. |
| `theme` | `'ocean'` | עיצוב ברירת מחדל. אפשרויות: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | תצוגה ברירת מחדל. אפשרויות: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | מחרוזת אזור זמן PHP. |
| `date_format` | `'Y-m-d H:i:s'` | מחרוזת פורמט תאריך PHP. |
| `base_path` | `''` | שורש ספרייה לפריסה גלובלית/תת-ספרייה. |
| `favicon_path` | `''` | נתיב ל-favicon מותאם אישית. |

### אפשרויות תצוגה

| מפתח | ברירת מחדל | תיאור |
|-----|---------|-------------|
| `show_hidden` | `false` | הצג קבצים מוסתרים (מתחילים עם `.`). |
| `show_size` | `true` | הצג עמודה גודל קובץ. |
| `show_date` | `true` | הצג עמודה תאריך שינוי אחרון. |
| `show_type` | `true` | הצג עמודה סוג קובץ (תצוגת רשימה). |
| `show_folder_size` | `true` | חשב גדלי ספריות (רקורסיבי — עלול להיות איטי לספריות גדולות). |
| `show_breadcrumb` | `true` | הצג breadcrumb ניווט. |
| `show_footer` | `true` | הצג בר footer. |
| `show_copyright` | `true` | הצג מידע זכויות יוצרים ב-footer. |
| `show_language_selector` | `true` | הצג בקר בוחר שפה. |
| `show_theme_selector` | `true` | הצג כפתור בוחר עיצוב. |

### תכונות

| מפתח | ברירת מחדל | תיאור |
|-----|---------|-------------|
| `enable_search` | `true` | אפשר חיפוש קבצים חי. |
| `enable_preview` | `true` | אפשר מודאל תצוגה מקדימה של קבצים (תמונות, וידאו, אודיו, PDF, קוד). |
| `enable_download` | `true` | הצג כפתורי הורדה על קבצים. |
| `enable_share` | `true` | אפשר מודאל שיתוף קבצים עם קוד QR. |
| `enable_qrcode` | `true` | צור קודי QR במודאל שיתוף. |
| `enable_shortcuts` | `true` | אפשר קיצורי מקלדת. |
| `enable_export` | `true` | אפשר ייצוא/העתק רשימת קבצים (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | עיבד קבצי `README.md` בתחתית רשימות ספריות. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | רשימה מופרדת בפסיקים של אלגוריתמי hash. נתמכים: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, ו-30+ נוספים. |
| `hash_uppercase` | `true` | הצג ערכי hash באותיות גדולות. |
| `max_hash_size` | `1000` | גודל קובץ מקסימלי מותר ל-hashing (MB). |

### אבטחה

| מפתח | ברירת מחדל | תיאור |
|-----|---------|-------------|
| `ignore_files` | (ראה למטה) | קבצים להסתיר. ברירת מחדל כוללת `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | הרחבות להסתיר. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | ספריות להסתיר. |
| `allowed_extensions` | `[]` | רשימת היתרים של הרחבות (ריק = אפשר הכל). |
| `protected_paths` | `['/etc', '/var/www/.git']` | נתיבים מוחלטים תמיד חסומים. |
| `enable_rate_limit` | `true` | אפשר הגבלת קצב מבוססת IP. |
| `rate_limit_requests` | `60` | בקשות מקסימליות לכל חלון. |
| `rate_limit_period` | `60` | חלון זמן הגבלת קצב (שניות). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | IPים פטורים מהגבלת קצב. |
| `trusted_proxies` | `[]` | IPים מורשים להגדיר `X-Forwarded-For`. ריק = אל תסמוך באף אחד. |
| `enable_dev` | `true` | **⚠️ הגדר ל-`false` בייצור.** מאפשר תצוגת שגיאות PHP ומבטל cache. |

> [!CAUTION]
> הגדר תמיד `'enable_dev' => false` לפני פריסה לייצור. במצב dev, שגיאות PHP מוצגות מה שעלול לחשוף נתיבי קבצים, פרטי קונפיגורציה, ו-stack traces למבקרים.

### מתקדם

| מפתח | ברירת מחדל | תיאור |
|-----|---------|-------------|
| `assets_path` | `''` | נתיב לתיקיית נכסי `_/`. auto-מזוהה אם ריק. |
| `use_embedded` | `false` | כפה מצב נכסים מוטבעים (משמש `Standalone.php`). |
| `thumbnail_directory` | `''` | נתיב מותאם אישית ל-cache thumbnails. auto-מוגדר ל-`_/thumbs` אם ריק. |
| `thumbnail_width` | `200` | רוחב thumbnail מקסימלי (px). |
| `thumbnail_height` | `200` | גובה thumbnail מקסימלי (px). |
| `thumbnail_cache_expiry` | `30` | ימים לפני ש-thumbnails cached נמחקים. `0` = נקה תמיד. `-1` = אל תנקה אף פעם. |
| `readme_files` | (רשימה) | שמות קבצים לסריקה עבור עיבוד README. |
| `custom_css` | `'_/css/custom.css'` | נתיב לקובץ CSS מותאם אישית (נטען אם קיים). |
| `custom_js` | `'_/js/custom.js'` | נתיב לקובץ JS מותאם אישית (נטען אם קיים). |
| `serve_index_files` | `false` | שרת `index.html` ישירות אם קיים. ⚠️ סיכון XSS פוטנציאלי אם קבצים לא מהימנים קיימים. |
| `index_files` | `['index.html', …]` | שמות קבצי אינדקס לחפש. |

### הגדר שרת כאינדקס ספרייה

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### אפשר מארחים חיצוניים (CSP)
FileLister משתמש ב-**Content Security Policy** קפדני. כדי לטעון משאבים מדומיינים חיצוניים, ערוך את הכותרת `Content-Security-Policy` ב-`core.php`:

```php
// הוסף את הדומיין שלך להנחיה המתאימה:
// img-src: לתמונות חיצוניות
// script-src: לסקריפטים חיצוניים (השתמש בזהירות)
// style-src: ל-CSS חיצוני
```

---

## 🎨 התאמה אישית של עיצוב

### עיצובים זמינים
| עיצוב | תיאור |
|-------|-------------|
| `light` | עיצוב לבן נקי |
| `dark` | מצב כהה |
| `auto` | עקוב אחר העדפת מערכת |
| `ocean` | גווני ים כחולים |
| `forest` | גווני יער ירוקים |
| `dracula` | כהה לילך Dracula |
| `nord` | פלטת ארקטית צפונית |
| `high-contrast` | מיקוד נגישות |
| `cute` | glassmorphism אנימה עם תמונת רקע |

### צור עיצוב מותאם אישית

1. **העתק עיצוב**: שכפל `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **ערוך משתני CSS**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... משתנים אחרים */
}
```

3. **רשום ב-JS**: הוסף את שם העיצוב שלך ל-`toggleTheme()` array ב-`_/js/app.js`.

4. **הפעל ב-config**:
```php
'theme' => 'mytheme',
```

5. **רשימת היתרים ב-config** (כדי שבוחר העיצוב יעבוד): ב-`index.php`, חפש `$allowed_themes` והוסף `'mytheme'` ל-array.

---

## 🧩 וווק HTML מותאמים אישית

הזרק HTML, CSS או JavaScript מותאמים אישית במיקומי עמוד ספציפיים מבלי לערוך קבצי core. הגדר את ה-array `html_hooks` ב-`core.php`:

```php
'html_hooks' => array(
    'head_end'      => '',  // לפני </head>
    'body_start'    => '',  // אחרי <body>
    'header_start'  => '',  // אחרי <header> נפתח
    'header_end'    => '',  // לפני </header>
    'main_before'   => '',  // לפני <main>
    'main_start'    => '',  // בתוך <main>, לפני פריטים
    'main_end'      => '',  // בתוך <main>, אחרי פריטים
    'main_after'    => '',  // אחרי </main>
    'footer_before' => '',  // לפני <footer>
    'footer_start'  => '',  // אחרי <footer> נפתח
    'footer_end'    => '',  // לפני </footer>
    'footer_after'  => '',  // אחרי </footer>
    'body_end'      => '',  // לפני </body>
    'html_end'      => '',  // לפני </html>
),
```

### דוגמה: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 תמיכה רב-לשונית
FileLister auto-מזהה שפת דפדפן ותומך ב-**18+ שפות**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

הגדר שפה קבועה עם `'language' => 'vi'`, או השאר ריק ל-auto-זיהוי.

---

## 👁️ תצוגה מקדימה של קובץ & Viewer
Viewer ביצועים גבוהים משולב לסוגי קבצים שונים:
- **תמונות**: jpg, png, gif, webp, svg (thumbnails בזמן אמת בתצוגת רשת)
- **וידאו**: mp4, webm, avi, mov, mkv
- **אודיו**: mp3, ogg, flac, wav, m4a
- **מסמכים**: viewer PDF משולב ו-rendering Markdown
- **קוד**: syntax highlighting via Prism.js ל-100+ שפות

---

## 🔗 שתף & הורד
- צור **קודי QR מיידיים** להעברות קבצים ניידות.
- קישורי הורדה ישירים לכל הקבצים.
- שיתוף קבצים מאובטח דרך URL יחידים.
- **תמיכה Unicode מלאה**: שמות קבצים בעברית, סינית, יפנית, ערבית, וסקריפטים לא-ASCII אחרים מקודדים נכון באחוזים בקישורי שיתוף ובקודי QR.

---

## ⌨️ קיצורי מקלדת
| מקש | פעולה |
|-----|--------|
| `/` או `Ctrl+F` | פוקס על תיבת חיפוש |
| `Esc` | סגור מודאל / נקה חיפוש |
| `↑` / `↓` | נווט דרך פריטים |
| `Enter` | פתח פריט נבחר |
| `g` ואז `h` | עבור לבית (שורש) |
| `g` ואז `u` | עבור למעלה ברמה ספרייה אחת |
| `?` | הצג עזרת קיצורי מקלדת |

---

## 🛡️ פרטי אבטחה

FileLister כולל שכבות אבטחה משופרות מרובות:

| שכבה | פרט |
|-------|--------|
| **ניווט נתיב** | קלט `?dir=` מאומת עם `realpath()` וקשור ל-`$lister_root`. |
| **CSP Nonce** | nonce אקראי 128-bit לבקשה על כל סקריפטים inline. ללא `unsafe-inline`. |
| **הגבלת קצב** | throttling מבוסס IP מאוחסן בקבצי זמניים. ברירת מחדל: 60 req/60s. |
| **פרוקסי מהימנים** | `X-Forwarded-For` מהימן רק מ-IP פרוקסי מוגדרים במפורש. |
| **קבצים רגישים** | `.env`, `.git`, `.htaccess`, קבצי PHP מוסתרים אוטומטית. |
| **כותרות אבטחה** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` להסרת מצלמה/mic/geo. |
| **HSTS** | `Strict-Transport-Security` נשלח אוטומטית כאשר על HTTPS. |
| **CORS** | endpoint ייצוא מאפשר רק בקשות same-origin. ללא השתקפות origin שרירותית. |
| **ללא hash ישנים** | MD5 ו-SHA-1 מוצאים מסוגי hash ברירת מחדל. |
| **הגנת symlink** | symlinks מדולגים ב-traversal ספרייה כדי למנוע לולאות ודליפות. |
| **מצב Dev** | `enable_dev: false` בייצור משבית תצוגת שגיאות. |

> [!IMPORTANT]
> אחרי קונפיגורציה, הגדר מיידית `'enable_dev' => false` כדי למנוע שהודעות שגיאה יחשפו internals של שרת.

---

## 📋 דרישות
- **PHP**: 5.2 או גבוה (נבדק עד PHP 8.4+)
- **הרחבות**: `json` (נדרש), `gd` (אופציונלי — עבור thumbnails), `zip` (אופציונלי)

---

## 📜 יומן שינויים

### v1.5.36 — שחרור אבטחה & תיקון באגים

**תיקוני אבטחה:**
- 🔒 **[קריטי] תוקן פגיעות השתקפות CORS** ב-endpoint `?export=` — לא משקף יותר כותרות `Origin` שרירותיות
- 🔒 **[קריטי] תוקן XSS בתצוגה מקדימה של קובץ** — שם קובץ בתצוגה מקדימה "סוג לא נתמך" לא היה escaped לפני הזרקת DOM
- 🔒 **[קריטי] `enable_dev` עכשיו ברירת מחדל `false`** — מונע חשיפת שגיאת PHP לא מכוונת בייצור
- 🔒 **[גבוה] אומת `dir_theme` cookie** לפני שימוש כדי למנוע התנהגות לא צפויה

**תיקוני באגים:**
- 🐛 **תוקן יצירת קוד QR נכשלה** עבור קבצים עם שמות Unicode (וייטנאמית, סינית, יפנית, וכו')
- 🐛 **תוקן קישור שיתוף שבור** עבור קבצים עם שמות קבצים Unicode/לא-ASCII
- 🐛 **תוקן תצוגה מקדימה של תמונה לא טוענת** עבור קבצים עם שמות קבצים Unicode
- 🐛 **תוקן תג `</div>` כפול** ב-HTML footer (גרם לבעיות פריסה בדפדפנים מסוימים)
- 🐛 **תוקן `style.css` נטען פעמיים** (בזבוז רוחב פס, ניתוח כפול)
- 🐛 **תוקן קבצים חסרים `custom.js` / `custom.css`** ב-build `Standalone.php`
- 🐛 **תוקן שחזור עיצוב** — עיצובי `dracula`, `nord`, `high-contrast`, `cute` לא מתאפסים יותר ברענון עמוד
- 🐛 **תוקן סמלים SVG כפולים** מוזרקים יחד עם thumbnails בתצוגת רשת
- 🐛 **תוקן AJAX ניווט config parsing** — regex חזק יותר במקום חילוץ מבוסס אינדקס שביר
- 🐛 **תוקן `previewText()` מציג HTML 404** כתוכן קובץ כאשר קובץ בלתי נגיש
- 🐛 **תוקן קוד מת `changeLanguage()`** מפנה לאלמנט `langToggle` לא קיים
- 🐛 **נוסף SHA-512/224 ו-SHA-512/256** למפת אלגוריתמי hash (רשום ב-docs אך חסר בקוד)
- 🐛 **הוחלף קריאות `alert()`** בהעתקת clipboard עם הודעות toast לא חסימות
- 🐛 **תוקן ניווט גלריה תמונות** — תמונות מוסתרות על ידי מסנן/חיפוש כעת מוציאות מ-traversal prev/next
- 🐛 **תוקן תצוגות מקדימות `audio`/`video`** — נוסף מטפל שגיאה כאשר מדיה נכשלת בטעינה

---

## ☕ תמך בעבודתי
נהנה מהסקריפט הפתוח הזה של PHP?
- [קנה לי 🍻](https://buymeacoffee.com/trong)
- תרום דרך ❤️ [PayPal](https://paypal.me/DaoVanTrong)

---

## 📝 רישיון
רישיון MIT — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
