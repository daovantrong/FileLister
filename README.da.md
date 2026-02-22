<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: Moderne PHP Directory Listing Script v1.5.36

FileLister er et kraftfuldt, letvægts og moderne **PHP directory listing script** som transformerer dine serverfiler til en smuk og mobilvenlig **web file explorer**. Det er det perfekte alternativ til `h5ai` eller `Apache Index`, med en single-file deployment mulighed og indbyggede filforhåndsvisninger.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 Indholdsfortegnelse
- [✨ Funktioner](#-funktioner)
- [📦 Installation](#-installation)
- [⚙️ Konfiguration](#-konfiguration)
- [🎨 Temaer](#-temaer)
- [🧩 Tilpassede HTML Hooks](#-tilpassede-html-hooks)
- [🌍 Flersproget support](#-flersproget-support)
- [👁️ Filforhåndsvisning](#-filforhåndsvisning--viewer)
- [🔗 Del & Download](#-del--download)
- [⌨️ Tastaturgenveje](#-tastaturgenveje)
- [🛡️ Sikkerhedsdetaljer](#-sikkerhedsdetaljer)
- [📋 Krav](#-krav)

---

## ✨ Funktioner

### 🚀 **Produktionsklar & Hurtig**
- **Standalone Version**: Single-file deployment (`Standalone.php`) med alle ressourcer indlejret. Kør `php build.php` for at generere.
- **Docker Support**: Færdige `Dockerfile` og `docker-compose.yml`.
- **Server Index**: Valgfrit server `index.html` hvis tilstede i en mappe.

### 🎨 **Moderne Brugergrænseflade**
- **Ren & Responsiv**: Mobile-first layout, fungerer på alle enheder.
- **9 Temaer**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (anime glassmorphism).
- **Gitter & Liste Visninger**: Skift mellem kort gitter og detaljerede listevisninger.
- **README Rendering**: Renderer automatisk `README.md` filer nederst i mappe lister.
- **Lokaliseret**: Sprog vælger med 18+ støttede lokaliteter.

### 🛡️ **Sikkerhed Forbedret**
- **CSP med Nonces**: Anmodning-per-kryptografisk nonce på alle inline-skripter. Ingen `unsafe-inline`.
- **Rate Limiting**: Integreret anti-DDoS anmodning throttling (60 req/60s som standard).
- **Pålidelige Proxier**: Sikker `X-Forwarded-For` håndtering — kun anvendt hvis anmodning kommer fra pålidelig proxy IP.
- **Path Traversal Beskyttelse**: Alle `?dir=` input løses via `realpath()` og bundet til `$lister_root`.
- **Skjul Følsomme Filer**: Ignorerer automatisk `.env`, `.git`, `.htaccess`, og PHP filer.
- **Sikkerhedsheaders**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (kun HTTPS).
- **Ingen MD5/SHA-1**: Standard hash sæt sat til `CRC32,XXH128,SHA-256,SHA3-256`. MD5 og SHA-1 ekskluderet som standard.

### 🔍 **Filintegritet (Info & Hash)**
- Verificerer 40+ hash algoritmer per fil, inklusive SHA-3, WHIRLPOOL, XXH128, CRC32.
- Konfigurerbar maksimal filstørrelse for hashing.
- Resultater vist inline i Info modal.

### 📤 **Eksporter & Del**
- Kopier/Download filliste i **JSON, CSV, TSV, NDJSON** formater.
- Del filer via QR koder og direkte links.

---

## 📦 Installation & Deployment Modi

FileLister støtter 4 deployment modi. Vælg den der passer din konfiguration:

---

### Modus 1: Standalone (Enkelt PHP Fil) — Anbefalet for Produktion

Alle ressourcer er kompileret i en selvstændig fil. Ingen `_/` mappe nødvendig.

```bash
# Trin 1: Byg standalone filen
php build.php

# Trin 2: Upload Standalone.php til din server
# Trin 3: Omdøb til index.php (eller hvilket navn du vil)
```

> **Config**: Sætter automatisk `'use_embedded' => true`. Ingen anden config nødvendig.

---

### Modus 2: Normal (Kilde Filer)

Klassisk multi-fil konfiguration. Hurtigst for udvikling.

```
your-web-root/
├── index.php        ← Indgangspunkt (require_once 'core.php')
├── core.php         ← Core logik & config
└── _/               ← CSS, JS, ikoner, oversættelsesfiler
```

**Trin:**
1. Kopier `index.php`, `core.php`, og `_/` til din webmappe.
2. Adgang via browser: `http://yoursite.com/`
3. Ingen ekstra konfiguration nødvendig.

---

### Modus 3: Undermappe Deployment

Kør FileLister i en undermappe som indexer sit eget indhold.

```
your-web-root/
├── files/           ← Mappe du vil indeksere
│   ├── index.php    ← FileLister indgangspunkt
│   └── core.php
└── _/               ← Delte assets (auto-detektieret gennem forælderskanning)
```

Funktionen `detect_assets_path()` scanner automatisk **op til 5 forældermapper** for at lokalisere `_/` assets mappe. Ingen manuel `assets_path` config nødvendig i de fleste tilfælde.

Hvis assets ikke auto-detektieres:
```php
'assets_path' => '../_',   // Eller fuld sti som '/var/www/html/_'
```

---

### Modus 4: Global Deployment (Indekser Hver Mappe på Serveren)

Brug **en enkelt FileLister installation** for at browse hver sti på serveren, frakoblet fra skriptstedet.

```
/var/www/html/
├── filelister/      ← FileLister lever her
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← Mappe du virkelig vil indeksere
```

**Konfiguration i `core.php`:**
```php
'base_path' => '/var/data',   // ← Sæt mappen du vil liste
```

> `base_path` accepterer enhver **absolut filsystem sti** som PHP processen kan læse. Skriptet vil tvinge al `?dir=` navigation til at holde sig indenfor denne rod via `realpath()` for at forhindre path traversal.

**Web Server Konfiguration** (for at bruge FileLister som mappeindeks):

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

**Apache (`.htaccess` i mål mappen):**
```apache
DirectoryIndex index.php FileLister.php index.html

# Ruter alle mappe anmodninger til FileLister:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### Modus 5: Docker

```bash
docker-compose up -d
```

Adgang på `http://localhost:8080`. Rediger `docker-compose.yml` for at montere din målmappe.

---

### Deployment Modus Sammenligning

| Modus | Nødvendige Filer | Bedst For |
|------|---------------|----------|
| **Standalone** | Kun `Standalone.php` | Hurtig deployment, delt hosting |
| **Normal** | `index.php` + `core.php` + `_/` | Udvikling, fuld kontrol |
| **Undermappe** | Samme som Normal, placeret i undermappe | Indeksering af en specifik undermappe |
| **Global** | Normal + `base_path` config | Enkelt instans indeksering hver server sti |
| **Docker** | `Dockerfile` + `docker-compose.yml` | Containeriserede miljøer |

---

## ⚙️ Konfiguration

Alle indstillinger er i `$config` arrayen i `core.php` (eller `Standalone.php`).

### Generelt

| Nøgle | Standard | Beskrivelse |
|-----|---------|-------------|
| `title` | `''` | Tilpasset sidetitel. Hvis tom, auto-genereret fra sti. |
| `title_prefix` | `'Index of'` | Præfiks for auto-genereret titel. |
| `title_suffix` | `' - FileLister'` | Suffiks for auto-genereret titel. |
| `language` | `''` | Tving et locale (`en`, `vi`, `zh`, `ja`…). Auto-detektierer hvis tom. |
| `allowed_langs` | (18 sprog) | Sprog tilgængelige i vælger dropdown. |
| `theme` | `'ocean'` | Standard tema. Alternativer: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | Standard visning. Alternativer: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | PHP tidszone streng. |
| `date_format` | `'Y-m-d H:i:s'` | PHP datoformat streng. |
| `base_path` | `''` | Rodmappe for global/undermappe deployment. |
| `favicon_path` | `''` | Sti til tilpasset favicon. |

### Visningsindstillinger

| Nøgle | Standard | Beskrivelse |
|-----|---------|-------------|
| `show_hidden` | `false` | Vis skjulte filer (starter med `.`). |
| `show_size` | `true` | Vis filstørrelse kolonne. |
| `show_date` | `true` | Vis sidste modificeringsdato kolonne. |
| `show_type` | `true` | Vis filtype kolonne (liste visning). |
| `show_folder_size` | `true` | Beregn mappestørrelser (rekursivt — kan være langsomt for store mapper). |
| `show_breadcrumb` | `true` | Vis navigation breadcrumb. |
| `show_footer` | `true` | Vis footer bar. |
| `show_copyright` | `true` | Vis copyright info i footer. |
| `show_language_selector` | `true` | Vis sprogskifter kontrol. |
| `show_theme_selector` | `true` | Vis temaskifter knap. |

### Funktioner

| Nøgle | Standard | Beskrivelse |
|-----|---------|-------------|
| `enable_search` | `true` | Aktiver live filsøgning. |
| `enable_preview` | `true` | Aktiver filforhåndsvisning modal (billeder, video, lyd, PDF, kode). |
| `enable_download` | `true` | Vis download knapper på filer. |
| `enable_share` | `true` | Aktiver fil deling modal med QR kode. |
| `enable_qrcode` | `true` | Generer QR koder i delings modal. |
| `enable_shortcuts` | `true` | Aktiver tastaturgenveje. |
| `enable_export` | `true` | Aktiver eksporter/kopier filliste (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | Render `README.md` filer nederst i mappe lister. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | Komma-separeret liste af hash algoritmer. Støttede: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, og 30+ flere. |
| `hash_uppercase` | `true` | Vis hash værdier i store bogstaver. |
| `max_hash_size` | `1000` | Maksimal filstørrelse (MB) tilladt for hashing. |

### Sikkerhed

| Nøgle | Standard | Beskrivelse |
|-----|---------|-------------|
| `ignore_files` | (se nedenfor) | Filer at skjule. Standard inkluderer `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | Udvidelser at skjule. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | Mapper at skjule. |
| `allowed_extensions` | `[]` | Whitelist af udvidelser (tom = tillad alle). |
| `protected_paths` | `['/etc', '/var/www/.git']` | Altid blokerede absolutte stier. |
| `enable_rate_limit` | `true` | Aktiver IP-baseret rate limiting. |
| `rate_limit_requests` | `60` | Maksimale anmodninger per vindue. |
| `rate_limit_period` | `60` | Rate limit tidsvindue (sekunder). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | IPs ekskluderet fra rate limiting. |
| `trusted_proxies` | `[]` | IPs tilladt at sætte `X-Forwarded-For`. Tom = stol på ingen. |
| `enable_dev` | `true` | **⚠️ Sæt til `false` i produktion.** Aktiverer PHP fejl display og deaktiverer cache. |

> [!CAUTION]
> Sæt altid `'enable_dev' => false` før du deployer til produktion. I dev modus vises PHP fejl hvilket kan eksponere filstier, konfigurationsdetaljer, og stack traces til besøgende.

### Avanceret

| Nøgle | Standard | Beskrivelse |
|-----|---------|-------------|
| `assets_path` | `''` | Sti til `_/` assets mappe. Auto-detektieret hvis tom. |
| `use_embedded` | `false` | Tving indlejrede assets modus (brugt af `Standalone.php`). |
| `thumbnail_directory` | `''` | Tilpasset sti for thumbnail cache. Auto-sat til `_/thumbs` hvis tom. |
| `thumbnail_width` | `200` | Maksimal thumbnail bredde (px). |
| `thumbnail_height` | `200` | Maksimal thumbnail højde (px). |
| `thumbnail_cache_expiry` | `30` | Dage før cachede thumbnails renses. `0` = altid rens. `-1` = aldrig rens. |
| `readme_files` | (liste) | Filnavne at skanne for README rendering. |
| `custom_css` | `'_/css/custom.css'` | Sti til tilpasset CSS fil (indlæst hvis findes). |
| `custom_js` | `'_/js/custom.js'` | Sti til tilpasset JS fil (indlæst hvis findes). |
| `serve_index_files` | `false` | Server `index.html` direkte hvis tilstede. ⚠️ Potentiel XSS risiko hvis ikke-pålidelige filer findes. |
| `index_files` | `['index.html', …]` | Indeks filnavne at søge efter. |

### Konfigurer Server som Directory Index

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### Tillad Eksterne Værter (CSP)
FileLister bruger en streng **Content Security Policy**. For at indlæse ressourcer fra eksterne domæner, rediger `Content-Security-Policy` headeren i `core.php`:

```php
// Tilføj dit domæne til rette direktiv:
// img-src: for eksterne billeder
// script-src: for eksterne skript (brug med forsigtighed)
// style-src: for ekstern CSS
```

---

## 🎨 Tema Tilpasning

### Tilgængelige Temaer
| Tema | Beskrivelse |
|-------|-------------|
| `light` | Rent hvidt tema |
| `dark` | Mørk modus |
| `auto` | Følg systempræference |
| `ocean` | Blå havstoner |
| `forest` | Grønne jordstoner |
| `dracula` | Dracula mørk lilla |
| `nord` | Nordisk arktisk palet |
| `high-contrast` | Tilgængelighedsfokus |
| `cute` | Anime glassmorphism med baggrundsbillede |

### Opret et Tilpasset Tema

1. **Kopier et tema**: Duplicer `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **Rediger CSS variabler**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... andre variabler */
}
```

3. **Registrer i JS**: Tilføj dit tema navn til `toggleTheme()` arrayen i `_/js/app.js`.

4. **Aktiver i config**:
```php
'theme' => 'mytheme',
```

5. **Whitelist i config** (så tema vælger fungerer): I `index.php`, søg `$allowed_themes` og tilføj `'mytheme'` til arrayen.

---

## 🧩 Tilpassede HTML Hooks

Injicer tilpasset HTML, CSS eller JavaScript på specifikke sidepositioner uden at redigere core filer. Konfigurer `html_hooks` arrayen i `core.php`:

```php
'html_hooks' => array(
    'head_end'      => '',  // Før </head>
    'body_start'    => '',  // Efter <body>
    'header_start'  => '',  // Efter <header> åbner
    'header_end'    => '',  // Før </header>
    'main_before'   => '',  // Før <main>
    'main_start'    => '',  // I <main>, før items
    'main_end'      => '',  // I <main>, efter items
    'main_after'    => '',  // Efter </main>
    'footer_before' => '',  // Før <footer>
    'footer_start'  => '',  // Efter <footer> åbner
    'footer_end'    => '',  // Før </footer>
    'footer_after'  => '',  // Efter </footer>
    'body_end'      => '',  // Før </body>
    'html_end'      => '',  // Før </html>
),
```

### Eksempel: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 Flersproget Support
FileLister auto-detektierer browser sprog og støtter **18+ sprog**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

Sæt et fast sprog med `'language' => 'vi'`, eller lad stå tomt for auto-detektion.

---

## 👁️ Filforhåndsvisning & Viewer
Integreret high-performance viewer for diverse filtyper:
- **Billeder**: jpg, png, gif, webp, svg (realtid thumbnails i gittervisning)
- **Videoer**: mp4, webm, avi, mov, mkv
- **Lyd**: mp3, ogg, flac, wav, m4a
- **Dokumenter**: Integreret PDF viewer og Markdown rendering
- **Kode**: Syntax highlighting via Prism.js for 100+ sprog

---

## 🔗 Del & Download
- Generer øjeblikkelige **QR koder** for mobile filoverførsler.
- Direkte download links for alle filer.
- Sikker fil deling via unikke URLs.
- **Fuld Unicode støtte**: filnavne på vietnamesisk, kinesisk, japansk, arabisk, og andre ikke-ASCII skript er korrekt procent-kodet i delingslinks og QR koder.

---

## ⌨️ Tastaturgenveje
| Tast | Handling |
|-----|--------|
| `/` eller `Ctrl+F` | Fokuser søgeboks |
| `Esc` | Luk modal / tøm søg |
| `↑` / `↓` | Naviger gennem items |
| `Enter` | Åbn valgt item |
| `g` så `h` | Gå hjem (rod) |
| `g` så `u` | Gå op et mappe niveau |
| `?` | Vis tastaturgenveje hjælp |

---

## 🛡️ Sikkerhedsdetaljer

FileLister inkluderer flere forbedrede sikkerhedslag:

| Lag | Detalje |
|-------|--------|
| **Path Traversal** | `?dir=` input valideret med `realpath()` og bundet til `$lister_root`. |
| **CSP Nonce** | Tilfældig 128-bit nonce per anmodning på alle inline-skript. Ingen `unsafe-inline`. |
| **Rate Limiting** | IP-baseret throttling gemt i midlertidige filer. Standard: 60 req/60s. |
| **Pålidelige Proxier** | `X-Forwarded-For` kun pålidelig fra eksplicit konfigureret proxy IPs. |
| **Følsomme Filer** | `.env`, `.git`, `.htaccess`, PHP filer automatisk skjult. |
| **Sikkerhedsheaders** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` for at deaktivere kamera/mic/geo. |
| **HSTS** | `Strict-Transport-Security` sendt automatisk når på HTTPS. |
| **CORS** | Export endpoint tillader kun same-origin anmodninger. Ingen vilkårlig origin refleksion. |
| **Ingen Gamle Hashes** | MD5 og SHA-1 ekskluderet fra standard hash typer. |
| **Symlink Beskyttelse** | Symlinks sprunget over under folder traversal for at forhindre løkker og lækager. |
| **Dev Modus** | `enable_dev: false` i produktion deaktiverer fejl display. |

> [!IMPORTANT]
> Efter konfiguration, sæt øjeblikkelig `'enable_dev' => false` for at forhindre at fejlmeddelelser eksponerer server internals.

---

## 📋 Krav
- **PHP**: 5.2 eller højere (testet op til PHP 8.4+)
- **Udvidelser**: `json` (krævet), `gd` (valgfri — for thumbnails), `zip` (valgfri)

---

## 📜 Ændringslog

### v1.5.36 — Sikkerhed & Bug Fix Release

**Sikkerhedsrettelser:**
- 🔒 **[Kritisk] Rettet CORS refleksions sårbarhed** i `?export=` endpoint — reflekterer ikke længere vilkårlige `Origin` headers
- 🔒 **[Kritisk] Rettet XSS i filforhåndsvisning** — filnavn i "ikke støttet type" forhåndsvisning var ikke escaped før DOM indsættelse
- 🔒 **[Kritisk] `enable_dev` nu standard `false`** — forhindrer utilsigtet PHP fejl afsløring i produktion
- 🔒 **[Høj] Valideret `dir_theme` cookie** før brug for at forhindre uventet adfærd

**Bug Fixes:**
- 🐛 **Rettet QR kode generering fejlede** for filer med Unicode navne (vietnamesisk, kinesisk, japansk, etc.)
- 🐛 **Rettet delingslink ødelagt** for filer med Unicode/ikke-ASCII filnavne
- 🐛 **Rettet billedeforhåndsvisning ikke indlæser** for filer med Unicode filnavne
- 🐛 **Rettet duplikeret `</div>` tag** i footer HTML (forårsagede layout problemer i nogle browsere)
- 🐛 **Rettet `style.css` indlæst to gange** (båndbreddespild, dobbelt-parse)
- 🐛 **Rettet manglende `custom.js` / `custom.css`** i `Standalone.php` build
- 🐛 **Rettet tema gendannelse** — `dracula`, `nord`, `high-contrast`, `cute` temaer nulstiller ikke længere ved side genindlæsning
- 🐛 **Rettet duplikerede SVG ikoner** injiceret sammen med thumbnails i gittervisning
- 🐛 **Rettet AJAX navigationsconfig parsing** — mere robust regex i stedet for skrøbelig indeks-baseret ekstraktion
- 🐛 **Rettet `previewText()` viser 404 HTML** som filindhold når fil utilgængelig
- 🐛 **Rettet død kode `changeLanguage()`** refererende ikke-eksisterende `langToggle` element
- 🐛 **Tilføjet SHA-512/224 og SHA-512/256** til hash algoritme kort (nævnt i docs men manglet i kode)
- 🐛 **Erstattet `alert()` kald** i clipboard kopi med ikke-blokkerende toast notifikationer
- 🐛 **Rettet billedgalleri navigation** — billeder skjult af filter/søg nu ekskluderet fra prev/next traversal
- 🐛 **Rettet `audio`/`video` forhåndsvisninger** — fejl håndterer tilføjet når media fejler at indlæse

---

## ☕ Støt Mit Arbejde
Kan du lide dette open-source PHP script?
- [Køb mig en 🍻](https://buymeacoffee.com/trong)
- Doner via ❤️ [PayPal](https://paypal.me/DaoVanTrong)

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
