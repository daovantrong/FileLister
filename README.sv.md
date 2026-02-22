<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: Modern PHP Directory Listing Script v1.5.36

FileLister är ett kraftfullt, lättviktigt och modernt **PHP directory listing script** som transformerar dina serverfiler till en vacker och mobilvänlig **webbfilutforskare**. Det är det perfekta alternativet till `h5ai` eller `Apache Index`, med ett single-file deployment alternativ och inbyggda filförhandsvisningar.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 Innehållsförteckning
- [✨ Funktioner](#-funktioner)
- [📦 Installation](#-installation)
- [⚙️ Konfiguration](#-konfiguration)
- [🎨 Teman](#-teman)
- [🧩 Anpassade HTML Hooks](#-anpassade-html-hooks)
- [🌍 Flerspråkigt stöd](#-flerspråkigt-stöd)
- [👁️ Filförhandsvisning](#-filförhandsvisning--viewer)
- [🔗 Dela & Ladda ner](#-dela--ladda-ner)
- [⌨️ Tangentbordsgenvägar](#-tangentbordsgenvägar)
- [🛡️ Säkerhetsdetaljer](#-säkerhetsdetaljer)
- [📋 Krav](#-krav)

---

## ✨ Funktioner

### 🚀 **Produktionsredo & Snabb**
- **Standalone Version**: Single-file deployment (`Standalone.php`) med alla resurser inbäddade. Kör `php build.php` för att generera.
- **Docker Stöd**: Färdiga `Dockerfile` och `docker-compose.yml`.
- **Servera Index**: Valfritt servera `index.html` om närvarande i en katalog.

### 🎨 **Modern Användargränssnitt**
- **Ren & Responsiv**: Mobile-first layout, fungerar på alla enheter.
- **9 Teman**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (anime glassmorphism).
- **Rutnät & Lista Vyer**: Växla mellan kort rutnät och detaljerade listvyer.
- **README Rendering**: Renderar automatiskt `README.md` filer längst ner i kataloglistningar.
- **Lokaliserad**: Språk väljare med 18+ stödjer lokaler.

### 🛡️ **Säkerhet Förstärkt**
- **CSP med Nonces**: Begäran-per-kryptografisk nonce på alla inline-skript. Ingen `unsafe-inline`.
- **Rate Limiting**: Integrerad anti-DDoS begäran throttling (60 req/60s som standard).
- **Pålitliga Proxier**: Säker `X-Forwarded-For` hantering — endast tillämpad om begäran kommer från pålitlig proxy IP.
- **Path Traversal Skydd**: Alla `?dir=` indata löses via `realpath()` och bundna till `$lister_root`.
- **Dölja Känsliga Filer**: Ignorerar automatiskt `.env`, `.git`, `.htaccess`, och PHP filer.
- **Säkerhetsheaders**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (endast HTTPS).
- **Ingen MD5/SHA-1**: Standard hash set inställd på `CRC32,XXH128,SHA-256,SHA3-256`. MD5 och SHA-1 exkluderade som standard.

### 🔍 **Filintegritet (Info & Hash)**
- Verifierar 40+ hash algoritmer per fil, inklusive SHA-3, WHIRLPOOL, XXH128, CRC32.
- Konfigurerbar maximal filstorlek för hashing.
- Resultat visas inline i Info modal.

### 📤 **Exportera & Dela**
- Kopiera/Ladda ner fillista i **JSON, CSV, TSV, NDJSON** format.
- Dela filer via QR koder och direkta länkar.

---

## 📦 Installation & Deployment Modi

FileLister stöder 4 deployment modi. Välj den som passar din konfiguration:

---

### Modus 1: Standalone (Enstaka PHP Fil) — Rekommenderad för Produktion

Alla resurser är kompilerade i en självständig fil. Ingen `_/` mapp behövs.

```bash
# Steg 1: Bygg standalone filen
php build.php

# Steg 2: Ladda upp Standalone.php till din server
# Steg 3: Döp om till index.php (eller vilket namn du vill)
```

> **Config**: Sätter automatiskt `'use_embedded' => true`. Ingen annan config behövs.

---

### Modus 2: Normal (Källfiler)

Klassisk multi-fil konfiguration. Snabbast för utveckling.

```
your-web-root/
├── index.php        ← Ingångspunkt (require_once 'core.php')
├── core.php         ← Core logik & config
└── _/               ← CSS, JS, ikoner, översättningsfiler
```

**Steg:**
1. Kopiera `index.php`, `core.php`, och `_/` till din webbkatalog.
2. Åtkomst via webbläsare: `http://yoursite.com/`
3. Ingen extra konfiguration behövs.

---

### Modus 3: Underkatalog Deployment

Kör FileLister i en underkatalog som indexerar sitt eget innehåll.

```
your-web-root/
├── files/           ← Katalog du vill indexera
│   ├── index.php    ← FileLister ingångspunkt
│   └── core.php
└── _/               ← Delade tillgångar (auto-detektierade genom förälderskanning)
```

Funktionen `detect_assets_path()` skannar automatiskt **upp till 5 förälderkataloger** för att lokalisera `_/` tillgångsmappar. Ingen manuell `assets_path` config krävs i de flesta fall.

Om tillgångar inte auto-detektieras:
```php
'assets_path' => '../_',   // Eller fullständig sökväg som '/var/www/html/_'
```

---

### Modus 4: Global Deployment (Indexera Varje Katalog på Servern)

Använd **en enda FileLister installation** för att bläddra varje sökväg på servern, frikopplad från skriptplatsen.

```
/var/www/html/
├── filelister/      ← FileLister lever här
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← Katalog du verkligen vill indexera
```

**Konfiguration i `core.php`:**
```php
'base_path' => '/var/data',   // ← Ställ in katalogen du vill lista
```

> `base_path` accepterar vilken **absolut filsystem sökväg** som helst som PHP processen kan läsa. Skriptet kommer tvinga all `?dir=` navigering att stanna inom denna rot via `realpath()` för att förhindra path traversal.

**Web Server Konfiguration** (för att använda FileLister som katalogindex):

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

**Apache (`.htaccess` i målkatalogen):**
```apache
DirectoryIndex index.php FileLister.php index.html

# Routa alla katalogbegäranden till FileLister:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### Modus 5: Docker

```bash
docker-compose up -d
```

Åtkomst på `http://localhost:8080`. Redigera `docker-compose.yml` för att montera din målkatalog.

---

### Deployment Modus Jämförelse

| Modus | Krävs Filer | Bästa För |
|------|---------------|----------|
| **Standalone** | Endast `Standalone.php` | Snabb deployment, delad hosting |
| **Normal** | `index.php` + `core.php` + `_/` | Utveckling, full kontroll |
| **Underkatalog** | Samma som Normal, placerad i underkatalog | Indexering av en specifik underkatalog |
| **Global** | Normal + `base_path` config | Enkel instans indexering varje server sökväg |
| **Docker** | `Dockerfile` + `docker-compose.yml` | Containeriserade miljöer |

---

## ⚙️ Konfiguration

Alla inställningar är i `$config` arrayen i `core.php` (eller `Standalone.php`).

### Allmänt

| Nyckel | Standard | Beskrivning |
|-----|---------|-------------|
| `title` | `''` | Anpassad sidtitel. Om tom, auto-genererad från sökväg. |
| `title_prefix` | `'Index of'` | Prefix för auto-genererad titel. |
| `title_suffix` | `' - FileLister'` | Suffix för auto-genererad titel. |
| `language` | `''` | Tvinga ett locale (`en`, `vi`, `zh`, `ja`…). Auto-detektierar om tom. |
| `allowed_langs` | (18 språk) | Språk tillgängliga i väljare dropdown. |
| `theme` | `'ocean'` | Standard tema. Alternativ: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | Standard vy. Alternativ: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | PHP tidszon sträng. |
| `date_format` | `'Y-m-d H:i:s'` | PHP datumformat sträng. |
| `base_path` | `''` | Rotkatalog för global/underkatalog deployment. |
| `favicon_path` | `''` | Sökväg till anpassad favicon. |

### Visningsalternativ

| Nyckel | Standard | Beskrivning |
|-----|---------|-------------|
| `show_hidden` | `false` | Visa dolda filer (börjar med `.`). |
| `show_size` | `true` | Visa filstorlek kolumn. |
| `show_date` | `true` | Visa sista modifieringsdatum kolumn. |
| `show_type` | `true` | Visa filtyp kolumn (listvy). |
| `show_folder_size` | `true` | Beräkna mappstorlekar (rekursivt — kan vara långsamt för stora mappar). |
| `show_breadcrumb` | `true` | Visa navigations breadcrumb. |
| `show_footer` | `true` | Visa sidfot bar. |
| `show_copyright` | `true` | Visa copyright info i sidfot. |
| `show_language_selector` | `true` | Visa språkväxlare kontroll. |
| `show_theme_selector` | `true` | Visa temaväxlare knapp. |

### Funktioner

| Nyckel | Standard | Beskrivning |
|-----|---------|-------------|
| `enable_search` | `true` | Aktivera live filsökning. |
| `enable_preview` | `true` | Aktivera filförhandsvisning modal (bilder, video, ljud, PDF, kod). |
| `enable_download` | `true` | Visa nedladdningsknappar på filer. |
| `enable_share` | `true` | Aktivera fil delning modal med QR kod. |
| `enable_qrcode` | `true` | Generera QR koder i delnings modal. |
| `enable_shortcuts` | `true` | Aktivera tangentbordsgenvägar. |
| `enable_export` | `true` | Aktivera exportera/kopiera fillista (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | Rendera `README.md` filer längst ner i kataloglistningar. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | Komma-separerad lista av hash algoritmer. Stödda: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, och 30+ fler. |
| `hash_uppercase` | `true` | Visa hash värden i versaler. |
| `max_hash_size` | `1000` | Maximal filstorlek (MB) tillåten för hashing. |

### Säkerhet

| Nyckel | Standard | Beskrivning |
|-----|---------|-------------|
| `ignore_files` | (se nedan) | Filer att dölja. Standard inkluderar `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | Tillägg att dölja. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | Mappar att dölja. |
| `allowed_extensions` | `[]` | Whitelist av tillägg (tom = tillåt alla). |
| `protected_paths` | `['/etc', '/var/www/.git']` | Alltid blockerade absoluta sökvägar. |
| `enable_rate_limit` | `true` | Aktivera IP-baserad rate limiting. |
| `rate_limit_requests` | `60` | Maximala förfrågningar per fönster. |
| `rate_limit_period` | `60` | Rate limit tidsfönster (sekunder). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | IPs undantagna från rate limiting. |
| `trusted_proxies` | `[]` | IPs tillåtna att sätta `X-Forwarded-For`. Tom = lita på ingen. |
| `enable_dev` | `true` | **⚠️ Sätt till `false` i produktion.** Aktiverar PHP fel display och inaktiverar cache. |

> [!CAUTION]
> Sätt alltid `'enable_dev' => false` innan du deployar till produktion. I dev läge visas PHP fel vilket kan exponera filvägar, konfigurationsdetaljer, och stack traces till besökare.

### Avancerat

| Nyckel | Standard | Beskrivning |
|-----|---------|-------------|
| `assets_path` | `''` | Sökväg till `_/` tillgångsmappar. Auto-detektierad om tom. |
| `use_embedded` | `false` | Tvinga inbäddade tillgångar läge (använd av `Standalone.php`). |
| `thumbnail_directory` | `''` | Anpassad sökväg för thumbnail cache. Auto-ställd till `_/thumbs` om tom. |
| `thumbnail_width` | `200` | Maximal thumbnail bredd (px). |
| `thumbnail_height` | `200` | Maximal thumbnail höjd (px). |
| `thumbnail_cache_expiry` | `30` | Dagar innan cachade thumbnails rensas. `0` = alltid rensa. `-1` = aldrig rensa. |
| `readme_files` | (lista) | Filnamn att skanna för README rendering. |
| `custom_css` | `'_/css/custom.css'` | Sökväg till anpassad CSS fil (laddad om den finns). |
| `custom_js` | `'_/js/custom.js'` | Sökväg till anpassad JS fil (laddad om den finns). |
| `serve_index_files` | `false` | Servera `index.html` direkt om närvarande. ⚠️ Potentiell XSS risk om icke-pålitliga filer finns. |
| `index_files` | `['index.html', …]` | Index filnamn att söka efter. |

### Konfigurera Server som Directory Index

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### Tillåt Externa Värdar (CSP)
FileLister använder en strikt **Content Security Policy**. För att ladda resurser från externa domäner, redigera `Content-Security-Policy` headern i `core.php`:

```php
// Lägg till din domän till rätt direktiv:
// img-src: för externa bilder
// script-src: för externa skript (använd med omsorg)
// style-src: för extern CSS
```

---

## 🎨 Tema Anpassning

### Tillgängliga Teman
| Tema | Beskrivning |
|-------|-------------|
| `light` | Ren vit tema |
| `dark` | Mörk läge |
| `auto` | Följ systempreferens |
| `ocean` | Blå havstoner |
| `forest` | Gröna jordstoner |
| `dracula` | Dracula mörk lila |
| `nord` | Nordisk arktisk palett |
| `high-contrast` | Tillgänglighetsfokus |
| `cute` | Anime glassmorphism med bakgrundsbild |

### Skapa ett Anpassat Tema

1. **Kopiera ett tema**: Duplicera `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **Redigera CSS variabler**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... andra variabler */
}
```

3. **Registrera i JS**: Lägg till ditt tema namn till `toggleTheme()` arrayen i `_/js/app.js`.

4. **Aktivera i config**:
```php
'theme' => 'mytheme',
```

5. **Whitelist i config** (så tema väljare fungerar): I `index.php`, sök `$allowed_themes` och lägg till `'mytheme'` till arrayen.

---

## 🧩 Anpassade HTML Hooks

Injicera anpassad HTML, CSS eller JavaScript på specifika sidpositioner utan att redigera core filer. Konfigurera `html_hooks` arrayen i `core.php`:

```php
'html_hooks' => array(
    'head_end'      => '',  // Innan </head>
    'body_start'    => '',  // Efter <body>
    'header_start'  => '',  // Efter <header> öppnar
    'header_end'    => '',  // Innan </header>
    'main_before'   => '',  // Innan <main>
    'main_start'    => '',  // I <main>, innan items
    'main_end'      => '',  // I <main>, efter items
    'main_after'    => '',  // Efter </main>
    'footer_before' => '',  // Innan <footer>
    'footer_start'  => '',  // Efter <footer> öppnar
    'footer_end'    => '',  // Innan </footer>
    'footer_after'  => '',  // Efter </footer>
    'body_end'      => '',  // Innan </body>
    'html_end'      => '',  // Innan </html>
),
```

### Exempel: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 Flerspråkigt Stöd
FileLister auto-detektierar webbläsar språk och stöder **18+ språk**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

Ställ in ett fast språk med `'language' => 'vi'`, eller lämna tomt för auto-detektion.

---

## 👁️ Filförhandsvisning & Viewer
Integrerad high-performance viewer för diverse filtyper:
- **Bilder**: jpg, png, gif, webp, svg (realtid thumbnails i rutnätsvy)
- **Videor**: mp4, webm, avi, mov, mkv
- **Ljud**: mp3, ogg, flac, wav, m4a
- **Dokument**: Integrerad PDF viewer och Markdown rendering
- **Kod**: Syntax highlighting via Prism.js för 100+ språk

---

## 🔗 Dela & Ladda ner
- Generera omedelbara **QR koder** för mobila filöverföringar.
- Direkta nedladdningslänkar för alla filer.
- Säker fil delning via unika URLs.
- **Fullständig Unicode stöd**: filnamn på vietnamesiska, kinesiska, japanska, arabiska, och andra icke-ASCII skript är korrekt procent-kodade i delningslänkar och QR koder.

---

## ⌨️ Tangentbordsgenvägar
| Tangent | Åtgärd |
|-----|--------|
| `/` eller `Ctrl+F` | Fokusera sökruta |
| `Esc` | Stäng modal / rensa sök |
| `↑` / `↓` | Navigera genom items |
| `Enter` | Öppna valt item |
| `g` sedan `h` | Gå hem (rot) |
| `g` sedan `u` | Gå upp en katalog nivå |
| `?` | Visa tangentbordsgenvägar hjälp |

---

## 🛡️ Säkerhetsdetaljer

FileLister inkluderar flera förstärkta säkerhetslager:

| Lager | Detalj |
|-------|--------|
| **Path Traversal** | `?dir=` indata validerad med `realpath()` och bunden till `$lister_root`. |
| **CSP Nonce** | Slumpmässig 128-bit nonce per förfrågan på alla inline-skript. Ingen `unsafe-inline`. |
| **Rate Limiting** | IP-baserad throttling lagrad i temporära filer. Standard: 60 req/60s. |
| **Pålitliga Proxier** | `X-Forwarded-For` endast pålitlig från explicit konfigurerade proxy IPs. |
| **Känsliga Filer** | `.env`, `.git`, `.htaccess`, PHP filer automatiskt dolda. |
| **Säkerhetsheaders** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` för att inaktivera kamera/mic/geo. |
| **HSTS** | `Strict-Transport-Security` skickad automatiskt när på HTTPS. |
| **CORS** | Export endpoint tillåter endast same-origin förfrågningar. Ingen godtycklig origin reflexion. |
| **Inga Gamla Hashes** | MD5 och SHA-1 exkluderade från standard hash typer. |
| **Symlink Skydd** | Symlinks hoppade över under folder traversal för att förhindra loopar och läckor. |
| **Dev Läge** | `enable_dev: false` i produktion inaktiverar fel display. |

> [!IMPORTANT]
> Efter konfiguration, sätt omedelbart `'enable_dev' => false` för att förhindra att felmeddelanden exponerar server internals.

---

## 📋 Krav
- **PHP**: 5.2 eller högre (testat upp till PHP 8.4+)
- **Tillägg**: `json` (krävs), `gd` (valfri — för thumbnails), `zip` (valfri)

---

## 📜 Ändringslogg

### v1.5.36 — Säkerhet & Bug Fix Release

**Säkerhetsfixar:**
- 🔒 **[Kritisk] Åtgärdat CORS reflexionssårbarhet** i `?export=` endpoint — reflekterar inte längre godtyckliga `Origin` headers
- 🔒 **[Kritisk] Åtgärdat XSS i filförhandsvisning** — filnamn i "ej stödd typ" förhandsvisning var inte escaped innan DOM infogning
- 🔒 **[Kritisk] `enable_dev` nu standard `false`** — förhindrar oavsiktlig PHP fel avslöjande i produktion
- 🔒 **[Hög] Validerat `dir_theme` cookie** innan användning för att förhindra oväntat beteende

**Bug Fixes:**
- 🐛 **Åtgärdat QR kod generering misslyckande** för filer med Unicode namn (vietnamesiska, kinesiska, japanska, etc.)
- 🐛 **Åtgärdat delningslänk trasig** för filer med Unicode/icke-ASCII filnamn
- 🐛 **Åtgärdat bildförhandsvisning inte laddar** för filer med Unicode filnamn
- 🐛 **Åtgärdat duplicerad `</div>` tagg** i footer HTML (orsakade layout problem i några webbläsare)
- 🐛 **Åtgärdat `style.css` laddad två gånger** (bandbreddsspill, dubbel-parse)
- 🐛 **Åtgärdat saknade `custom.js` / `custom.css`** i `Standalone.php` build
- 🐛 **Åtgärdat tema återställning** — `dracula`, `nord`, `high-contrast`, `cute` teman återställer inte längre vid sidomladdning
- 🐛 **Åtgärdat duplicerade SVG ikoner** injicerade tillsammans med thumbnails i rutnätsvy
- 🐛 **Åtgärdat AJAX navigationsconfig parsing** — robustare regex istället för bräcklig index-baserad extraktion
- 🐛 **Åtgärdat `previewText()` visar 404 HTML** som filinnehåll när fil oåtkomlig
- 🐛 **Åtgärdat död kod `changeLanguage()`** refererande icke-existerande `langToggle` element
- 🐛 **Tillagt SHA-512/224 och SHA-512/256** till hash algoritm karta (nämnda i docs men saknade i kod)
- 🐛 **Ersatt `alert()` anrop** i clipboard kopia med icke-blockerande toast notifikationer
- 🐛 **Åtgärdat bildgalleri navigering** — bilder dolda av filter/sök nu exkluderade från prev/next traversal
- 🐛 **Åtgärdat `audio`/`video` förhandsvisningar** — fel hanterare tillagd när media misslyckas ladda

---

## ☕ Stöd Mitt Arbete
Tycker du om detta open-source PHP script?
- [Köp mig en 🍻](https://buymeacoffee.com/trong)
- Donera via ❤️ [PayPal](https://paypal.me/DaoVanTrong)

---

## 📝 Licens
MIT Licens — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
