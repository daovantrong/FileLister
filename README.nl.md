<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: Modern PHP Directory Listing Script v1.5.36

FileLister is een krachtig, lichtgewicht en modern **PHP directory listing script** dat je serverbestanden omzet in een mooie, mobile-friendly **web file explorer**. Het is de perfecte alternatief voor `h5ai` of `Apache Index`, met een single-file deployment optie en ingebouwde file previews.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 Inhoudsopgave
- [✨ Functies](#-functies)
- [📦 Installatie](#-installatie)
- [⚙️ Configuratie](#-configuratie)
- [🎨 Thema's](#-themas)
- [🧩 Aangepaste HTML Hooks](#-aangepaste-html-hooks)
- [🌍 Meertalige ondersteuning](#-meertalige-ondersteuning)
- [👁️ Bestandsvoorvertoning](#-bestandsvoorvertoning--viewer)
- [🔗 Delen & Downloaden](#-delen--downloaden)
- [⌨️ Sneltoetsen](#-sneltoetsen)
- [🛡️ Beveiligingsdetails](#-beveiligingsdetails)
- [📋 Vereisten](#-vereisten)

---

## ✨ Functies

### 🚀 **Productieklaar & Snel**
- **Standalone Versie**: Single-file deployment (`Standalone.php`) met alle bronnen embedded. Voer `php build.php` uit om te genereren.
- **Docker Ondersteuning**: Kant-en-klare `Dockerfile` en `docker-compose.yml`.
- **Serveer Index**: Optioneel serveer `index.html` indien aanwezig in een directory.

### 🎨 **Moderne Gebruikersinterface**
- **Schoon & Responsief**: Mobile-first layout, werkt op elk apparaat.
- **9 Thema's**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (anime glassmorphism).
- **Raster & Lijst Weergaven**: Schakel tussen kaart raster en gedetailleerde lijst weergaven.
- **README Rendering**: Rendert automatisch `README.md` bestanden onderaan directory listings.
- **Gelokaliseerd**: Taalkiezer met 18+ ondersteunde locales.

### 🛡️ **Beveiliging Versterkt**
- **CSP met Nonces**: Request-per-cryptografische nonce op alle inline scripts. Geen `unsafe-inline`.
- **Rate Limiting**: Geïntegreerde anti-DDoS request throttling (60 req/60s standaard).
- **Vertrouwde Proxies**: Veilige `X-Forwarded-For` afhandeling — alleen toegepast als request komt van vertrouwde proxy IP.
- **Path Traversal Bescherming**: Alle `?dir=` input wordt opgelost via `realpath()` en gebonden aan `$lister_root`.
- **Verbergen Gevoelige Bestanden**: Negeert automatisch `.env`, `.git`, `.htaccess`, en PHP bestanden.
- **Beveiligingsheaders**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (alleen HTTPS).
- **Geen MD5/SHA-1**: Standaard hash set ingesteld op `CRC32,XXH128,SHA-256,SHA3-256`. MD5 en SHA-1 standaard uitgesloten.

### 🔍 **Bestandsintegriteit (Info & Hash)**
- Verificeert 40+ hash algoritmen per bestand, inclusief SHA-3, WHIRLPOOL, XXH128, CRC32.
- Configureerbare maximale bestandsgrootte voor hashing.
- Resultaten inline weergegeven in de Info modal.

### 📤 **Exporteren & Delen**
- Kopieer/Download bestandenlijst in **JSON, CSV, TSV, NDJSON** formaten.
- Deel bestanden via QR codes en directe links.

---

## 📦 Installatie & Deployment Modi

FileLister ondersteunt 4 deployment modi. Kies die past bij je configuratie:

---

### Modus 1: Standalone (Enkel PHP Bestand) — Aanbevolen voor Productie

Alle bronnen zijn gecompileerd in een zelfbevattend bestand. Geen `_/` map nodig.

```bash
# Stap 1: Bouw het standalone bestand
php build.php

# Stap 2: Upload Standalone.php naar je server
# Stap 3: Hernoem naar index.php (of elke naam die je wilt)
```

> **Config**: Stelt automatisch `'use_embedded' => true` in. Geen andere config nodig.

---

### Modus 2: Normaal (Bronbestanden)

Klassieke multi-file configuratie. Snelste voor ontwikkeling.

```
your-web-root/
├── index.php        ← Ingangspunt (require_once 'core.php')
├── core.php         ← Core logica & config
└── _/               ← CSS, JS, iconen, vertalingsbestanden
```

**Stappen:**
1. Kopieer `index.php`, `core.php`, en `_/` naar je web directory.
2. Toegang via browser: `http://yoursite.com/`
3. Geen extra configuratie nodig.

---

### Modus 3: Subdirectory Deployment

Voer FileLister uit in een subdirectory die zijn eigen inhoud indexeert.

```
your-web-root/
├── files/           ← Directory die je wilt indexeren
│   ├── index.php    ← FileLister ingangspunt
│   └── core.php
└── _/               ← Gedeelde assets (auto-gedetecteerd door ouder scan)
```

De functie `detect_assets_path()` scant automatisch **tot 5 ouder directories** om de `_/` assets map te lokaliseren. Geen handmatige `assets_path` config vereist in de meeste gevallen.

Als assets niet auto-gedetecteerd:
```php
'assets_path' => '../_',   // Of volledige pad zoals '/var/www/html/_'
```

---

### Modus 4: Globale Deployment (Indexeer Elke Directory op de Server)

Gebruik **een enkele FileLister installatie** om elke pad op de server te browsen, losgekoppeld van de script locatie.

```
/var/www/html/
├── filelister/      ← FileLister leeft hier
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← Directory die je echt wilt indexeren
```

**Configuratie in `core.php`:**
```php
'base_path' => '/var/data',   // ← Stel de directory in die je wilt lijst
```

> `base_path` accepteert elke **absolute filesystem pad** die het PHP proces kan lezen. Het script zal forceren dat alle `?dir=` navigatie binnen deze root blijft via `realpath()` om path traversal te voorkomen.

**Web Server Configuratie** (om FileLister als directory index te gebruiken):

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

**Apache (`.htaccess` in de doel directory):**
```apache
DirectoryIndex index.php FileLister.php index.html

# Routeer alle directory verzoeken naar FileLister:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### Modus 5: Docker

```bash
docker-compose up -d
```

Toegang op `http://localhost:8080`. Bewerk `docker-compose.yml` om je doel directory te mounten.

---

### Deployment Modus Vergelijking

| Modus | Vereiste Bestanden | Beste Voor |
|------|---------------|----------|
| **Standalone** | Alleen `Standalone.php` | Snelle deployment, shared hosting |
| **Normaal** | `index.php` + `core.php` + `_/` | Ontwikkeling, volledige controle |
| **Subdirectory** | Zelfde als Normaal, geplaatst in subdirectory | Indexeren van een specifieke subdirectory |
| **Globaal** | Normaal + `base_path` config | Enkele instantie indexeren elke server pad |
| **Docker** | `Dockerfile` + `docker-compose.yml` | Gecontaineriseerde omgevingen |

---

## ⚙️ Configuratie

Alle instellingen zijn in de `$config` array in `core.php` (of `Standalone.php`).

### Algemeen

| Sleutel | Standaard | Beschrijving |
|-----|---------|-------------|
| `title` | `''` | Aangepaste pagina titel. Als leeg, auto-gegenereerd van pad. |
| `title_prefix` | `'Index of'` | Voorvoegsel voor auto-gegenereerde titel. |
| `title_suffix` | `' - FileLister'` | Achtervoegsel voor auto-gegenereerde titel. |
| `language` | `''` | Forceer een locale (`en`, `vi`, `zh`, `ja`…). Auto-detecteert als leeg. |
| `allowed_langs` | (18 talen) | Talen beschikbaar in de selector dropdown. |
| `theme` | `'ocean'` | Standaard thema. Opties: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | Standaard weergave. Opties: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | PHP tijdzone string. |
| `date_format` | `'Y-m-d H:i:s'` | PHP datum formaat string. |
| `base_path` | `''` | Root directory voor globale/subdirectory deployment. |
| `favicon_path` | `''` | Pad naar aangepaste favicon. |

### Weergave Opties

| Sleutel | Standaard | Beschrijving |
|-----|---------|-------------|
| `show_hidden` | `false` | Toon verborgen bestanden (beginnend met `.`). |
| `show_size` | `true` | Toon bestandsgrootte kolom. |
| `show_date` | `true` | Toon laatste wijzigingsdatum kolom. |
| `show_type` | `true` | Toon bestandstype kolom (lijst weergave). |
| `show_folder_size` | `true` | Bereken map grootten (recursief — kan langzaam zijn voor grote mappen). |
| `show_breadcrumb` | `true` | Toon navigatie breadcrumb. |
| `show_footer` | `true` | Toon footer bar. |
| `show_copyright` | `true` | Toon copyright info in footer. |
| `show_language_selector` | `true` | Toon taalwisselaar controle. |
| `show_theme_selector` | `true` | Toon themawisselaar knop. |

### Functies

| Sleutel | Standaard | Beschrijving |
|-----|---------|-------------|
| `enable_search` | `true` | Schakel live bestand zoeken in. |
| `enable_preview` | `true` | Schakel bestand voorvertoning modal in (afbeeldingen, video, audio, PDF, code). |
| `enable_download` | `true` | Toon download knoppen op bestanden. |
| `enable_share` | `true` | Schakel bestand delen modal in met QR code. |
| `enable_qrcode` | `true` | Genereer QR codes in deel modal. |
| `enable_shortcuts` | `true` | Schakel toetsenbord sneltoetsen in. |
| `enable_export` | `true` | Schakel exporteren/kopiëren van bestandenlijst in (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | Render `README.md` bestanden onderaan directory listings. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | Komma-gescheiden lijst van hash algoritmen. Ondersteund: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, en 30+ meer. |
| `hash_uppercase` | `true` | Toon hash waarden in hoofdletters. |
| `max_hash_size` | `1000` | Maximale bestandsgrootte (MB) toegestaan voor hashing. |

### Beveiliging

| Sleutel | Standaard | Beschrijving |
|-----|---------|-------------|
| `ignore_files` | (zie hieronder) | Bestanden om te verbergen. Standaard omvat `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | Extensies om te verbergen. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | Mappen om te verbergen. |
| `allowed_extensions` | `[]` | Whitelist van extensies (leeg = sta alles toe). |
| `protected_paths` | `['/etc', '/var/www/.git']` | Altijd geblokkeerde absolute paden. |
| `enable_rate_limit` | `true` | Schakel IP-gebaseerde rate limiting in. |
| `rate_limit_requests` | `60` | Maximum verzoeken per venster. |
| `rate_limit_period` | `60` | Rate limit tijd venster (seconden). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | IPs uitgezonderd van rate limiting. |
| `trusted_proxies` | `[]` | IPs toegestaan om `X-Forwarded-For` in te stellen. Leeg = vertrouw niemand. |
| `enable_dev` | `true` | **⚠️ Stel in op `false` in productie.** Schakelt PHP fout weergave in en schakelt cache uit. |

> [!CAUTION]
> Stel altijd `'enable_dev' => false` in voordat je naar productie deployt. In dev modus worden PHP fouten weergegeven wat kan leiden tot blootstelling van bestandspaden, configuratie details, en stack traces aan bezoekers.

### Geavanceerd

| Sleutel | Standaard | Beschrijving |
|-----|---------|-------------|
| `assets_path` | `''` | Pad naar `_/` assets map. Auto-gedetecteerd als leeg. |
| `use_embedded` | `false` | Forceer embedded assets modus (gebruikt door `Standalone.php`). |
| `thumbnail_directory` | `''` | Aangepast pad voor thumbnail cache. Auto-ingesteld op `_/thumbs` als leeg. |
| `thumbnail_width` | `200` | Maximale thumbnail breedte (px). |
| `thumbnail_height` | `200` | Maximale thumbnail hoogte (px). |
| `thumbnail_cache_expiry` | `30` | Dagen voordat gecachte thumbnails worden gezuiverd. `0` = altijd schoonmaken. `-1` = nooit schoonmaken. |
| `readme_files` | (lijst) | Bestandsnamen om te scannen voor README rendering. |
| `custom_css` | `'_/css/custom.css'` | Pad naar aangepaste CSS bestand (geladen indien bestaat). |
| `custom_js` | `'_/js/custom.js'` | Pad naar aangepaste JS bestand (geladen indien bestaat). |
| `serve_index_files` | `false` | Serveer `index.html` direct indien aanwezig. ⚠️ Potentiële XSS risico indien niet-vertrouwde bestanden bestaan. |
| `index_files` | `['index.html', …]` | Index bestandsnamen om te zoeken. |

### Configureer Server als Directory Index

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### Sta Externe Hosts Toe (CSP)
FileLister gebruikt een strenge **Content Security Policy**. Om resources van externe domeinen te laden, bewerk de `Content-Security-Policy` header in `core.php`:

```php
// Voeg je domein toe aan de juiste richtlijn:
// img-src: voor externe afbeeldingen
// script-src: voor externe scripts (gebruik met zorg)
// style-src: voor externe CSS
```

---

## 🎨 Thema Aanpassing

### Beschikbare Thema's
| Thema | Beschrijving |
|-------|-------------|
| `light` | Schone witte thema |
| `dark` | Donkere modus |
| `auto` | Volg systeemvoorkeur |
| `ocean` | Blauwe oceaan tonen |
| `forest` | Groene aarde tonen |
| `dracula` | Dracula donkere paars |
| `nord` | Noordelijke arctische palet |
| `high-contrast` | Toegankelijkheidsfocus |
| `cute` | Anime glassmorphism met achtergrondafbeelding |

### Creëer een Aangepast Thema

1. **Kopieer een thema**: Dupliceer `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **Bewerk CSS variabelen**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... andere variabelen */
}
```

3. **Registreer in JS**: Voeg je thema naam toe aan de `toggleTheme()` array in `_/js/app.js`.

4. **Activeer in config**:
```php
'theme' => 'mytheme',
```

5. **Whitelist in config** (zodat thema selector werkt): In `index.php`, zoek `$allowed_themes` en voeg `'mytheme'` toe aan de array.

---

## 🧩 Aangepaste HTML Hooks

Injecteer aangepaste HTML, CSS of JavaScript op specifieke pagina posities zonder core bestanden te bewerken. Configureer de `html_hooks` array in `core.php`:

```php
'html_hooks' => array(
    'head_end'      => '',  // Voor </head>
    'body_start'    => '',  // Na <body>
    'header_start'  => '',  // Na <header> opent
    'header_end'    => '',  // Voor </header>
    'main_before'   => '',  // Voor <main>
    'main_start'    => '',  // In <main>, voor items
    'main_end'      => '',  // In <main>, na items
    'main_after'    => '',  // Na </main>
    'footer_before' => '',  // Voor <footer>
    'footer_start'  => '',  // Na <footer> opent
    'footer_end'    => '',  // Voor </footer>
    'footer_after'  => '',  // Na </footer>
    'body_end'      => '',  // Voor </body>
    'html_end'      => '',  // Voor </html>
),
```

### Voorbeeld: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 Meertalige Ondersteuning
FileLister auto-detecteert de browser taal en ondersteunt **18+ talen**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

Stel een vaste taal in met `'language' => 'vi'`, of laat leeg voor auto-detectie.

---

## 👁️ Bestandsvoorvertoning & Viewer
Geïntegreerde high-performance viewer voor diverse bestandstypen:
- **Afbeeldingen**: jpg, png, gif, webp, svg (realtime thumbnails in raster weergave)
- **Video's**: mp4, webm, avi, mov, mkv
- **Audio**: mp3, ogg, flac, wav, m4a
- **Documenten**: Geïntegreerde PDF viewer en Markdown rendering
- **Code**: Syntax highlighting via Prism.js voor 100+ talen

---

## 🔗 Delen & Downloaden
- Genereer onmiddellijke **QR codes** voor mobiele bestandsoverdrachten.
- Directe download links voor alle bestanden.
- Veilige bestand delen via unieke URLs.
- **Volledige Unicode ondersteuning**: bestandsnamen in Vietnamees, Chinees, Japans, Arabisch, en andere niet-ASCII scripts zijn correct percent-encoded in deel links en QR codes.

---

## ⌨️ Sneltoetsen
| Toets | Actie |
|-----|--------|
| `/` of `Ctrl+F` | Focus zoekvak |
| `Esc` | Sluit modal / wis zoek |
| `↑` / `↓` | Navigeer door items |
| `Enter` | Open geselecteerd item |
| `g` dan `h` | Ga naar huis (root) |
| `g` dan `u` | Ga een directory niveau omhoog |
| `?` | Toon sneltoetsen hulp |

---

## 🛡️ Beveiligingsdetails

FileLister omvat meerdere versterkte beveiligingslagen:

| Laag | Detail |
|-------|--------|
| **Path Traversal** | `?dir=` input gevalideerd met `realpath()` en gebonden aan `$lister_root`. |
| **CSP Nonce** | Willekeurige 128-bit nonce per request op alle inline scripts. Geen `unsafe-inline`. |
| **Rate Limiting** | IP-gebaseerde throttling opgeslagen in tijdelijke bestanden. Standaard: 60 req/60s. |
| **Vertrouwde Proxies** | `X-Forwarded-For` alleen vertrouwd van expliciet geconfigureerde proxy IPs. |
| **Gevoelige Bestanden** | `.env`, `.git`, `.htaccess`, PHP bestanden automatisch verborgen. |
| **Beveiligingsheaders** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` om camera/mic/geo uit te schakelen. |
| **HSTS** | `Strict-Transport-Security` automatisch verzonden wanneer op HTTPS. |
| **CORS** | Export endpoint staat alleen same-origin verzoeken toe. Geen arbitraire origin reflectie. |
| **Geen Oude Hashes** | MD5 en SHA-1 uitgesloten van standaard hash typen. |
| **Symlink Bescherming** | Symlinks overgeslagen tijdens folder traversal om loops en lekken te voorkomen. |
| **Dev Modus** | `enable_dev: false` in productie schakelt fout weergave uit. |

> [!IMPORTANT]
> Na configuratie, stel onmiddellijk `'enable_dev' => false` in om te voorkomen dat fout berichten server internals blootleggen.

---

## 📋 Vereisten
- **PHP**: 5.2 of hoger (getest tot PHP 8.4+)
- **Extensies**: `json` (vereist), `gd` (optioneel — voor thumbnails), `zip` (optioneel)

---

## 📜 Wijzigingslog

### v1.5.36 — Beveiliging & Bug Fix Release

**Beveiligingsfixes:**
- 🔒 **[Kritiek] Opgelost CORS reflectie kwetsbaarheid** in `?export=` endpoint — reflecteert geen arbitraire `Origin` headers meer
- 🔒 **[Kritiek] Opgelost XSS in bestand voorvertoning** — bestandsnaam in "niet ondersteunde type" preview was niet escaped voor DOM invoeging
- 🔒 **[Kritiek] `enable_dev` nu standaard `false`** — voorkomt accidentele PHP fout divulgatie in productie
- 🔒 **[Hoog] Gevalideerd `dir_theme` cookie** voor gebruik om onverwacht gedrag te voorkomen

**Bug Fixes:**
- 🐛 **Opgelost QR code generatie falend** voor bestanden met Unicode namen (Vietnamees, Chinees, Japans, etc.)
- 🐛 **Opgelost deel link gebroken** voor bestanden met Unicode/niet-ASCII bestandsnamen
- 🐛 **Opgelost afbeelding voorvertoning niet ladend** voor bestanden met Unicode bestandsnamen
- 🐛 **Opgelost dubbele `</div>` tag** in footer HTML (veroorzaakte layout problemen in sommige browsers)
- 🐛 **Opgelost `style.css` geladen twee keer** (bandbreedte verspilling, dubbel-parse)
- 🐛 **Opgelost ontbrekende `custom.js` / `custom.css`** in `Standalone.php` build
- 🐛 **Opgelost thema herstel** — `dracula`, `nord`, `high-contrast`, `cute` thema's resetten niet meer bij pagina herladen
- 🐛 **Opgelost dubbele SVG iconen** geïnjecteerd samen met thumbnails in raster weergave
- 🐛 **Opgelost AJAX navigatie config parsing** — robuustere regex in plaats van fragiele index-gebaseerde extractie
- 🐛 **Opgelost `previewText()` toont 404 HTML** als bestand inhoud wanneer bestand ontoegankelijk
- 🐛 **Opgelost dode code `changeLanguage()`** verwijzend naar niet-bestaande `langToggle` element
- 🐛 **Toegevoegd SHA-512/224 en SHA-512/256** aan hash algoritme map (vermeld in docs maar ontbrekend in code)
- 🐛 **Vervangen `alert()` aanroepen** in clipboard kopie met niet-blokkerende toast notificaties
- 🐛 **Opgelost afbeelding galerij navigatie** — afbeeldingen verborgen door filter/zoek nu uitgesloten van prev/next traversal
- 🐛 **Opgelost `audio`/`video` previews** — fout handler toegevoegd wanneer media faalt om te laden

---

## ☕ Ondersteun Mijn Werk
Geniet je van dit open-source PHP script?
- [Koop me een 🍻](https://buymeacoffee.com/trong)
- Doneer via ❤️ [PayPal](https://paypal.me/DaoVanTrong)

---

## 📝 Licentie
MIT Licentie — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
