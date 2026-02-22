<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: Moderne PHP Directory Listing Script v1.5.36

FileLister er et kraftfullt, lettvekts og moderne **PHP directory listing script** som transformerer serverfilene dine til en vakker og mobilvennlig **web file explorer**. Det er det perfekte alternativet til `h5ai` eller `Apache Index`, med et single-file deployment alternativ og innebygde filforhåndsvisninger.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 Innholdsfortegnelse
- [✨ Funksjoner](#-funksjoner)
- [📦 Installasjon](#-installasjon)
- [⚙️ Konfigurasjon](#-konfigurasjon)
- [🎨 Temaer](#-temaer)
- [🧩 Tilpassede HTML Hooks](#-tilpassede-html-hooks)
- [🌍 Flerspråklig støtte](#-flerspråklig-støtte)
- [👁️ Filforhåndsvisning](#-filforhåndsvisning--viewer)
- [🔗 Del & Last ned](#-del--last-ned)
- [⌨️ Tastatursnarveier](#-tastatursnarveier)
- [🛡️ Sikkerhetsdetaljer](#-sikkerhetsdetaljer)
- [📋 Krav](#-krav)

---

## ✨ Funksjoner

### 🚀 **Produksjonsklar & Rask**
- **Standalone Versjon**: Single-file deployment (`Standalone.php`) med alle ressurser innebygde. Kjør `php build.php` for å generere.
- **Docker Støtte**: Klare `Dockerfile` og `docker-compose.yml`.
- **Server Index**: Valgfritt server `index.html` hvis tilstede i en katalog.

### 🎨 **Moderne Brukergrensesnitt**
- **Ren & Responsive**: Mobile-first layout, fungerer på alle enheter.
- **9 Temaer**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (anime glassmorphism).
- **Rutenett & Liste Vyer**: Bytt mellom kort rutenett og detaljerte listevyer.
- **README Rendering**: Rendrer automatisk `README.md` filer nederst i kataloglistinger.
- **Lokalisert**: Språkvelger med 18+ støttede lokaliteter.

### 🛡️ **Sikkerhet Forbedret**
- **CSP med Nonces**: Forespørsel-per-kryptografisk nonce på alle inline-skript. Ingen `unsafe-inline`.
- **Rate Limiting**: Integrert anti-DDoS forespørsel throttling (60 req/60s som standard).
- **Pålitelige Proxier**: Sikker `X-Forwarded-For` håndtering — kun anvendt hvis forespørsel kommer fra pålitelig proxy IP.
- **Path Traversal Beskyttelse**: All `?dir=` input løses via `realpath()` og bundet til `$lister_root`.
- **Skjule Sensitive Filer**: Ignorerer automatisk `.env`, `.git`, `.htaccess`, og PHP filer.
- **Sikkerhetsheaders**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (kun HTTPS).
- **Ingen MD5/SHA-1**: Standard hash sett satt til `CRC32,XXH128,SHA-256,SHA3-256`. MD5 og SHA-1 ekskludert som standard.

### 🔍 **Filintegritet (Info & Hash)**
- Verifiserer 40+ hash algoritmer per fil, inkludert SHA-3, WHIRLPOOL, XXH128, CRC32.
- Konfigurerbar maksimal filstørrelse for hashing.
- Resultater vist inline i Info modal.

### 📤 **Eksporter & Del**
- Kopier/Last ned filliste i **JSON, CSV, TSV, NDJSON** formater.
- Del filer via QR koder og direkte lenker.

---

## 📦 Installasjon & Deployment Modi

FileLister støtter 4 deployment modi. Velg den som passer din konfigurasjon:

---

### Modus 1: Standalone (Enkelt PHP Fil) — Anbefalt for Produksjon

Alle ressurser er kompilert i en selvstendig fil. Ingen `_/` mappe nødvendig.

```bash
# Steg 1: Bygg standalone filen
php build.php

# Steg 2: Last opp Standalone.php til din server
# Steg 3: Gi nytt navn til index.php (eller hvilket som helst navn du vil)
```

> **Config**: Setter automatisk `'use_embedded' => true`. Ingen annen config nødvendig.

---

### Modus 2: Normal (Kilde Filer)

Klassisk multi-fil konfigurasjon. Raskest for utvikling.

```
your-web-root/
├── index.php        ← Inngangspunkt (require_once 'core.php')
├── core.php         ← Core logikk & config
└── _/               ← CSS, JS, ikoner, oversettelsesfiler
```

**Steg:**
1. Kopier `index.php`, `core.php`, og `_/` til din webkatalog.
2. Tilgang via nettleser: `http://yoursite.com/`
3. Ingen ekstra konfigurasjon nødvendig.

---

### Modus 3: Underkatalog Deployment

Kjør FileLister i en underkatalog som indexer sitt eget innhold.

```
your-web-root/
├── files/           ← Katalog du vil indeksere
│   ├── index.php    ← FileLister inngangspunkt
│   └── core.php
└── _/               ← Delte assets (auto-detektierte gjennom forelderskanning)
```

Funksjonen `detect_assets_path()` skanner automatisk **opp til 5 forelderkataloger** for å lokalisere `_/` assets mappe. Ingen manuell `assets_path` config nødvendig i de fleste tilfeller.

Hvis assets ikke auto-detektieres:
```php
'assets_path' => '../_',   // Eller full sti som '/var/www/html/_'
```

---

### Modus 4: Global Deployment (Indekser Hver Katalog på Serveren)

Bruk **en enkelt FileLister installasjon** for å bla gjennom hver sti på serveren, frakoblet fra skriptstedet.

```
/var/www/html/
├── filelister/      ← FileLister lever her
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← Katalog du virkelig vil indeksere
```

**Konfigurasjon i `core.php`:**
```php
'base_path' => '/var/data',   // ← Sett katalogen du vil liste
```

> `base_path` aksepterer hvilken som helst **absolutt filsystem sti** som PHP prosessen kan lese. Skriptet vil tvinge all `?dir=` navigasjon til å holde seg innenfor denne roten via `realpath()` for å forhindre path traversal.

**Web Server Konfigurasjon** (for å bruke FileLister som katalogindeks):

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

# Ruter alle katalogforespørsler til FileLister:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### Modus 5: Docker

```bash
docker-compose up -d
```

Tilgang på `http://localhost:8080`. Rediger `docker-compose.yml` for å montere din målkatalog.

---

### Deployment Modus Sammenligning

| Modus | Nødvendige Filer | Beste For |
|------|---------------|----------|
| **Standalone** | Kun `Standalone.php` | Rask deployment, delt hosting |
| **Normal** | `index.php` + `core.php` + `_/` | Utvikling, full kontroll |
| **Underkatalog** | Samme som Normal, plassert i underkatalog | Indeksering av en spesifikk underkatalog |
| **Global** | Normal + `base_path` config | Enkelt instans indeksering hver server sti |
| **Docker** | `Dockerfile` + `docker-compose.yml` | Containeriserte miljøer |

---

## ⚙️ Konfigurasjon

Alle innstillinger er i `$config` arrayen i `core.php` (eller `Standalone.php`).

### Generelt

| Nøkkel | Standard | Beskrivelse |
|-----|---------|-------------|
| `title` | `''` | Tilpasset sidetittel. Hvis tom, auto-generert fra sti. |
| `title_prefix` | `'Index of'` | Prefiks for auto-generert tittel. |
| `title_suffix` | `' - FileLister'` | Suffiks for auto-generert tittel. |
| `language` | `''` | Tving et locale (`en`, `vi`, `zh`, `ja`…). Auto-detektierer hvis tom. |
| `allowed_langs` | (18 språk) | Språk tilgjengelige i velger dropdown. |
| `theme` | `'ocean'` | Standard tema. Alternativer: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | Standard vy. Alternativer: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | PHP tidssone streng. |
| `date_format` | `'Y-m-d H:i:s'` | PHP datoformat streng. |
| `base_path` | `''` | Rotkatalog for global/underkatalog deployment. |
| `favicon_path` | `''` | Sti til tilpasset favicon. |

### Visningsalternativer

| Nøkkel | Standard | Beskrivelse |
|-----|---------|-------------|
| `show_hidden` | `false` | Vis skjulte filer (starter med `.`). |
| `show_size` | `true` | Vis filstørrelse kolonne. |
| `show_date` | `true` | Vis siste modifikasjonsdato kolonne. |
| `show_type` | `true` | Vis filtype kolonne (liste vy). |
| `show_folder_size` | `true` | Beregn mappestørrelser (rekursivt — kan være tregt for store mapper). |
| `show_breadcrumb` | `true` | Vis navigasjon breadcrumb. |
| `show_footer` | `true` | Vis footer bar. |
| `show_copyright` | `true` | Vis copyright info i footer. |
| `show_language_selector` | `true` | Vis språkveksler kontroll. |
| `show_theme_selector` | `true` | Vis temaveksler knapp. |

### Funksjoner

| Nøkkel | Standard | Beskrivelse |
|-----|---------|-------------|
| `enable_search` | `true` | Aktiver live filsøk. |
| `enable_preview` | `true` | Aktiver filforhåndsvisning modal (bilder, video, lyd, PDF, kode). |
| `enable_download` | `true` | Vis nedlastingsknapper på filer. |
| `enable_share` | `true` | Aktiver fil deling modal med QR kode. |
| `enable_qrcode` | `true` | Generer QR koder i delings modal. |
| `enable_shortcuts` | `true` | Aktiver tastatursnarveier. |
| `enable_export` | `true` | Aktiver eksporter/kopier filliste (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | Render `README.md` filer nederst i kataloglistinger. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | Komma-separert liste av hash algoritmer. Støttede: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, og 30+ flere. |
| `hash_uppercase` | `true` | Vis hash verdier i store bokstaver. |
| `max_hash_size` | `1000` | Maksimal filstørrelse (MB) tillatt for hashing. |

### Sikkerhet

| Nøkkel | Standard | Beskrivelse |
|-----|---------|-------------|
| `ignore_files` | (se nedenfor) | Filer å skjule. Standard inkluderer `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | Utvidelser å skjule. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | Mapper å skjule. |
| `allowed_extensions` | `[]` | Whitelist av utvidelser (tom = tillat alle). |
| `protected_paths` | `['/etc', '/var/www/.git']` | Alltid blokkerte absolutte stier. |
| `enable_rate_limit` | `true` | Aktiver IP-basert rate limiting. |
| `rate_limit_requests` | `60` | Maksimale forespørsler per vindu. |
| `rate_limit_period` | `60` | Rate limit tidsvindu (sekunder). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | IPs ekskludert fra rate limiting. |
| `trusted_proxies` | `[]` | IPs tillatt å sette `X-Forwarded-For`. Tom = stol på ingen. |
| `enable_dev` | `true` | **⚠️ Sett til `false` i produksjon.** Aktiverer PHP feil display og deaktiverer cache. |

> [!CAUTION]
> Sett alltid `'enable_dev' => false` før du deployer til produksjon. I dev modus vises PHP feil hvilket kan eksponere filstier, konfigurasjonsdetaljer, og stack traces til besøkende.

### Avansert

| Nøkkel | Standard | Beskrivelse |
|-----|---------|-------------|
| `assets_path` | `''` | Sti til `_/` assets mappe. Auto-detektierert hvis tom. |
| `use_embedded` | `false` | Tving innebygde assets modus (brukt av `Standalone.php`). |
| `thumbnail_directory` | `''` | Tilpasset sti for thumbnail cache. Auto-stilt til `_/thumbs` hvis tom. |
| `thumbnail_width` | `200` | Maksimal thumbnail bredde (px). |
| `thumbnail_height` | `200` | Maksimal thumbnail høyde (px). |
| `thumbnail_cache_expiry` | `30` | Dager før cachede thumbnails renses. `0` = alltid rens. `-1` = aldri rens. |
| `readme_files` | (liste) | Filnavn å skanne for README rendering. |
| `custom_css` | `'_/css/custom.css'` | Sti til tilpasset CSS fil (lastet hvis finnes). |
| `custom_js` | `'_/js/custom.js'` | Sti til tilpasset JS fil (lastet hvis finnes). |
| `serve_index_files` | `false` | Server `index.html` direkte hvis tilstede. ⚠️ Potensiell XSS risiko hvis ikke-pålitelige filer finnes. |
| `index_files` | `['index.html', …]` | Indeks filnavn å søke etter. |

### Konfigurer Server som Directory Index

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### Tillat Eksterne Verter (CSP)
FileLister bruker en streng **Content Security Policy**. For å laste ressurser fra eksterne domener, rediger `Content-Security-Policy` headeren i `core.php`:

```php
// Legg til ditt domene til rett direktiv:
// img-src: for eksterne bilder
// script-src: for eksterne skript (bruk med forsiktighet)
// style-src: for ekstern CSS
```

---

## 🎨 Tema Tilpasning

### Tilgjengelige Temaer
| Tema | Beskrivelse |
|-------|-------------|
| `light` | Ren hvitt tema |
| `dark` | Mørk modus |
| `auto` | Følg systempreferanse |
| `ocean` | Blå havstoner |
| `forest` | Grønne jordstoner |
| `dracula` | Dracula mørk lilla |
| `nord` | Nordisk arktisk palett |
| `high-contrast` | Tilgjengelighetsfokus |
| `cute` | Anime glassmorphism med bakgrunnsbilde |

### Opprett et Tilpasset Tema

1. **Kopier et tema**: Dupliser `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **Rediger CSS variabler**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... andre variabler */
}
```

3. **Registrer i JS**: Legg til ditt tema navn til `toggleTheme()` arrayen i `_/js/app.js`.

4. **Aktiver i config**:
```php
'theme' => 'mytheme',
```

5. **Whitelist i config** (så tema velger fungerer): I `index.php`, søk `$allowed_themes` og legg til `'mytheme'` til arrayen.

---

## 🧩 Tilpassede HTML Hooks

Injiser tilpasset HTML, CSS eller JavaScript på spesifikke sideposisjoner uten å redigere core filer. Konfigurer `html_hooks` arrayen i `core.php`:

```php
'html_hooks' => array(
    'head_end'      => '',  // Før </head>
    'body_start'    => '',  // Etter <body>
    'header_start'  => '',  // Etter <header> åpner
    'header_end'    => '',  // Før </header>
    'main_before'   => '',  // Før <main>
    'main_start'    => '',  // I <main>, før items
    'main_end'      => '',  // I <main>, etter items
    'main_after'    => '',  // Etter </main>
    'footer_before' => '',  // Før <footer>
    'footer_start'  => '',  // Etter <footer> åpner
    'footer_end'    => '',  // Før </footer>
    'footer_after'  => '',  // Etter </footer>
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

## 🌍 Flerspråklig Støtte
FileLister auto-detektierer nettleser språk og støtter **18+ språk**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

Sett et fast språk med `'language' => 'vi'`, eller la stå tomt for auto-deteksjon.

---

## 👁️ Filforhåndsvisning & Viewer
Integrert high-performance viewer for diverse filtyper:
- **Bilder**: jpg, png, gif, webp, svg (realtid thumbnails i rutenettsvy)
- **Videoer**: mp4, webm, avi, mov, mkv
- **Lyd**: mp3, ogg, flac, wav, m4a
- **Dokumenter**: Integrert PDF viewer og Markdown rendering
- **Kode**: Syntax highlighting via Prism.js for 100+ språk

---

## 🔗 Del & Last ned
- Generer øyeblikkelige **QR koder** for mobile filoverføringer.
- Direkte nedlastingslenker for alle filer.
- Sikker fil deling via unike URLs.
- **Full Unicode støtte**: filnavn på vietnamesisk, kinesisk, japansk, arabisk, og andre ikke-ASCII skript er korrekt prosent-kodet i delingslenker og QR koder.

---

## ⌨️ Tastatursnarveier
| Tast | Handling |
|-----|--------|
| `/` eller `Ctrl+F` | Fokuser søkeboks |
| `Esc` | Lukk modal / tøm søk |
| `↑` / `↓` | Naviger gjennom items |
| `Enter` | Åpne valgt item |
| `g` så `h` | Gå hjem (rot) |
| `g` så `u` | Gå opp en katalog nivå |
| `?` | Vis tastatursnarveier hjelp |

---

## 🛡️ Sikkerhetsdetaljer

FileLister inkluderer flere forbedrede sikkerhetslag:

| Lag | Detalj |
|-------|--------|
| **Path Traversal** | `?dir=` input validert med `realpath()` og bundet til `$lister_root`. |
| **CSP Nonce** | Tilfeldig 128-bit nonce per forespørsel på alle inline-skript. Ingen `unsafe-inline`. |
| **Rate Limiting** | IP-basert throttling lagret i midlertidige filer. Standard: 60 req/60s. |
| **Pålitelige Proxier** | `X-Forwarded-For` kun pålitelig fra eksplisitt konfigurerte proxy IPs. |
| **Sensitive Filer** | `.env`, `.git`, `.htaccess`, PHP filer automatisk skjult. |
| **Sikkerhetsheaders** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` for å deaktivere kamera/mic/geo. |
| **HSTS** | `Strict-Transport-Security` sendt automatisk når på HTTPS. |
| **CORS** | Export endpoint tillater kun same-origin forespørsler. Ingen vilkårlig origin refleksjon. |
| **Ingen Gamle Hashes** | MD5 og SHA-1 ekskludert fra standard hash typer. |
| **Symlink Beskyttelse** | Symlinks hoppet over under folder traversal for å forhindre løkker og lekkasjer. |
| **Dev Modus** | `enable_dev: false` i produksjon deaktiverer feil display. |

> [!IMPORTANT]
> Etter konfigurasjon, sett øyeblikkelig `'enable_dev' => false` for å forhindre at feilmeldinger eksponerer server internals.

---

## 📋 Krav
- **PHP**: 5.2 eller høyere (testet opp til PHP 8.4+)
- **Utvidelser**: `json` (kreves), `gd` (valgfri — for thumbnails), `zip` (valgfri)

---

## 📜 Endringslogg

### v1.5.36 — Sikkerhet & Bug Fix Release

**Sikkerhetsfikser:**
- 🔒 **[Kritisk] Fikset CORS refleksjons sårbarhet** i `?export=` endpoint — reflekterer ikke lenger vilkårlige `Origin` headers
- 🔒 **[Kritisk] Fikset XSS i filforhåndsvisning** — filnavn i "ikke støttet type" forhåndsvisning var ikke escaped før DOM innsetting
- 🔒 **[Kritisk] `enable_dev` nå standard `false`** — forhindrer uforutsett PHP feil avsløring i produksjon
- 🔒 **[Høy] Validerte `dir_theme` cookie** før bruk for å forhindre uventet oppførsel

**Bug Fixes:**
- 🐛 **Fikset QR kode generering feil** for filer med Unicode navn (vietnamesisk, kinesisk, japansk, etc.)
- 🐛 **Fikset delingslenke ødelagt** for filer med Unicode/ikke-ASCII filnavn
- 🐛 **Fikset bildeforhåndsvisning ikke laster** for filer med Unicode filnavn
- 🐛 **Fikset duplisert `</div>` tagg** i footer HTML (forårsaket layout problemer i noen nettlesere)
- 🐛 **Fikset `style.css` lastet to ganger** (båndbreddespill, dobbel-parse)
- 🐛 **Fikset manglende `custom.js` / `custom.css`** i `Standalone.php` build
- 🐛 **Fikset tema gjenoppretting** — `dracula`, `nord`, `high-contrast`, `cute` temaer tilbakestiller ikke lenger ved sideinnlasting
- 🐛 **Fikset dupliserte SVG ikoner** injisert sammen med thumbnails i rutenettsvy
- 🐛 **Fikset AJAX navigasjonsconfig parsing** — robustere regex i stedet for skjøre indeks-basert ekstraksjon
- 🐛 **Fikset `previewText()` viser 404 HTML** som filinnhold når fil utilgjengelig
- 🐛 **Fikset død kode `changeLanguage()`** refererende ikke-eksisterende `langToggle` element
- 🐛 **Lagt til SHA-512/224 og SHA-512/256** til hash algoritme kart (nevnt i docs men manglet i kode)
- 🐛 **Erstattet `alert()` kall** i clipboard kopi med ikke-blokkerende toast notifikasjoner
- 🐛 **Fikset bildegalleri navigasjon** — bilder skjult av filter/søk nå ekskludert fra prev/next traversal
- 🐛 **Fikset `audio`/`video` forhåndsvisninger** — feil håndterer lagt til når media feiler å laste

---

## ☕ Støtt Mitt Arbeid
Liker du dette open-source PHP scriptet?
- [Kjøp meg en 🍻](https://buymeacoffee.com/trong)
- Doner via ❤️ [PayPal](https://paypal.me/DaoVanTrong)

---

## 📝 Lisens
MIT Lisens — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
