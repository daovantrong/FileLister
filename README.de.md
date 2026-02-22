<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: Modernes PHP-Verzeichnislistenskript v1.5.36

FileLister ist ein mächtiges, leichtes und modernes **PHP-Verzeichnislistenskript**, das Ihre Serverdateien in einen schönen, mobilfreundlichen **Web-Datei-Explorer** verwandelt. Es ist die perfekte Alternative zu `h5ai` oder `Apache Index`, bietet eine Single-File-Bereitstellungsoption und integrierte Dateivorschauen.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 Inhaltsverzeichnis
- [✨ Funktionen](#-funktionen)
- [📦 Installation](#-installation)
- [⚙️ Konfiguration](#-konfiguration)
- [🎨 Themes](#-themes)
- [🧩 Benutzerdefinierte HTML-Hooks](#-benutzerdefinierte-html-hooks)
- [🌍 Mehrsprachiger Support](#-mehrsprachiger-support)
- [👁️ Dateivorschau](#-dateivorschau--viewer)
- [🔗 Teilen & Herunterladen](#-teilen--herunterladen)
- [⌨️ Tastaturkürzel](#-tastaturkürzel)
- [🛡️ Sicherheitsdetails](#-sicherheitsdetails)
- [📋 Anforderungen](#-anforderungen)

---

## ✨ Funktionen

### 🚀 **Produktionsbereit & Schnell**
- **Standalone-Version**: Single-File-Bereitstellung (`Standalone.php`) mit allen Ressourcen eingebettet. Führen Sie `php build.php` aus, um zu generieren.
- **Docker-Support**: Fertige `Dockerfile` und `docker-compose.yml`.
- **Index bedienen**: Optional `index.html` bedienen, falls in einem Verzeichnis vorhanden.

### 🎨 **Moderne Benutzeroberfläche**
- **Sauber & Responsive**: Mobile-first Layout, funktioniert auf jedem Gerät.
- **9 Themes**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (Anime-Glassmorphismus).
- **Raster- & Listenansichten**: Zwischen Kartenraster- und detaillierten Listenansichten wechseln.
- **README-Rendering**: Rendert automatisch `README.md`-Dateien am Ende von Verzeichnislisten.
- **Lokalisiert**: Sprachauswahl mit 18+ unterstützten Locales.

### 🛡️ **Sicherheit Verstärkt**
- **CSP mit Nonces**: Anforderungskryptografischer Nonce auf allen Inline-Skripten. Kein `unsafe-inline`.
- **Ratelimiting**: Integriertes Anti-DDoS-Anforderungsthrottling (60 req/60s standardmäßig).
- **Vertrauenswürdige Proxies**: Sichere `X-Forwarded-For`-Handhabung — nur angewendet, wenn Anfrage von vertrauenswürdiger Proxy-IP kommt.
- **Path-Traversal-Schutz**: Alle `?dir=`-Eingaben werden via `realpath()` aufgelöst und auf `$lister_root` beschränkt.
- **Verstecken Sensibler Dateien**: Ignoriert automatisch `.env`, `.git`, `.htaccess` und PHP-Dateien.
- **Sicherheits-Header**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (nur HTTPS).
- **Keine MD5/SHA-1**: Standard-Hash-Satz gesetzt auf `CRC32,XXH128,SHA-256,SHA3-256`. MD5 und SHA-1 standardmäßig ausgeschlossen.

### 🔍 **Dateiintegrität (Info & Hash)**
- Überprüft 40+ Hash-Algorithmen pro Datei, einschließlich SHA-3, WHIRLPOOL, XXH128, CRC32.
- Konfigurierbare maximale Dateigröße für Hashing.
- Ergebnisse inline im Info-Modal angezeigt.

### 📤 **Exportieren & Teilen**
- Dateiliste in **JSON, CSV, TSV, NDJSON**-Formaten kopieren/herunterladen.
- Dateien über QR-Codes und direkte Links teilen.

---

## 📦 Installation & Bereitstellungsmodi

FileLister unterstützt 4 Bereitstellungsmodi. Wählen Sie den, der zu Ihrer Konfiguration passt:

---

### Modus 1: Standalone (Einzelne PHP-Datei) — Empfohlen für Produktion

Alle Ressourcen werden in eine selbstenthaltende Datei kompiliert. Kein `_/`-Ordner benötigt.

```bash
# Schritt 1: Standalone-Datei bauen
php build.php

# Schritt 2: Standalone.php auf Ihren Server hochladen
# Schritt 3: In index.php umbenennen (oder einen beliebigen Namen, den Sie bevorzugen)
```

> **Config**: Setzt automatisch `'use_embedded' => true`. Keine weitere Config benötigt.

---

### Modus 2: Normal (Quell-Dateien)

Klassische Multi-File-Konfiguration. Schnellster für Entwicklung.

```
your-web-root/
├── index.php        ← Einstiegspunkt (require_once 'core.php')
├── core.php         ← Core-Logik & Config
└── _/               ← CSS, JS, Icons, Übersetzungsdateien
```

**Schritte:**
1. Kopieren Sie `index.php`, `core.php` und `_/` in Ihr Web-Verzeichnis.
2. Über Browser zugreifen: `http://yoursite.com/`
3. Keine zusätzliche Konfiguration benötigt.

---

### Modus 3: Unterverzeichnis-Bereitstellung

Führen Sie FileLister in einem Unterordner aus, der seinen eigenen Inhalt indiziert.

```
your-web-root/
├── files/           ← Verzeichnis, das Sie indizieren möchten
│   ├── index.php    ← FileLister-Einstiegspunkt
│   └── core.php
└── _/               ← Geteilte Assets (auto-erkannt durch Eltern-Scan)
```

Die Funktion `detect_assets_path()` scannt automatisch **bis zu 5 Eltern-Verzeichnisse**, um den `_/`-Assets-Ordner zu lokalisieren. In den meisten Fällen keine manuelle `assets_path`-Config erforderlich.

Falls Assets nicht auto-erkannt:
```php
'assets_path' => '../_',   // Oder voller Pfad wie '/var/www/html/_'
```

---

### Modus 4: Globale Bereitstellung (Jedes Verzeichnis auf dem Server indizieren)

Verwenden Sie **eine einzige FileLister-Installation**, um jeden Pfad auf dem Server zu durchsuchen, entkoppelt vom Script-Standort.

```
/var/www/html/
├── filelister/      ← FileLister lebt hier
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← Verzeichnis, das Sie tatsächlich indizieren möchten
```

**Konfiguration in `core.php`:**
```php
'base_path' => '/var/data',   // ← Setzen Sie das Verzeichnis, das Sie listen möchten
```

> `base_path` akzeptiert jeden **absoluten Dateisystem-Pfad**, den der PHP-Prozess lesen kann. Das Script wird erzwingen, dass alle `?dir=`-Navigation innerhalb dieser Wurzel via `realpath()` bleibt, um Path-Traversal zu verhindern.

**Webserver-Konfiguration** (um FileLister als Verzeichnisindex zu verwenden):

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

**Apache (`.htaccess` im Zielverzeichnis):**
```apache
DirectoryIndex index.php FileLister.php index.html

# Alle Verzeichnisanfragen an FileLister routen:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### Modus 5: Docker

```bash
docker-compose up -d
```

Auf `http://localhost:8080` zugreifen. Bearbeiten Sie `docker-compose.yml`, um Ihr Zielverzeichnis zu mounten.

---

### Vergleich der Bereitstellungsmodi

| Modus | Erforderliche Dateien | Bester Für |
|------|---------------|----------|
| **Standalone** | Nur `Standalone.php` | Schnelle Bereitstellung, Shared Hosting |
| **Normal** | `index.php` + `core.php` + `_/` | Entwicklung, volle Kontrolle |
| **Unterverzeichnis** | Gleich wie Normal, in Unterordner platziert | Indizieren eines spezifischen Unterordners |
| **Global** | Normal + `base_path`-Config | Einzelne Instanz, die jeden Serverpfad indiziert |
| **Docker** | `Dockerfile` + `docker-compose.yml` | Containerisierte Umgebungen |

---

## ⚙️ Konfiguration

Alle Einstellungen sind im `$config`-Array in `core.php` (oder `Standalone.php`).

### Allgemein

| Schlüssel | Standard | Beschreibung |
|-----|---------|-------------|
| `title` | `''` | Benutzerdefinierter Seitentitel. Wenn leer, auto-generiert von Pfad. |
| `title_prefix` | `'Index of'` | Präfix für auto-generierten Titel. |
| `title_suffix` | `' - FileLister'` | Suffix für auto-generierten Titel. |
| `language` | `''` | Erzwinge ein Locale (`en`, `vi`, `zh`, `ja`…). Auto-erkennt, wenn leer. |
| `allowed_langs` | (18 Sprachen) | Verfügbare Sprachen im Selektor-Dropdown. |
| `theme` | `'ocean'` | Standard-Theme. Optionen: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | Standard-Ansicht. Optionen: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | PHP-Zeitzonen-String. |
| `date_format` | `'Y-m-d H:i:s'` | PHP-Datumsformat-String. |
| `base_path` | `''` | Wurzelverzeichnis für globale/Unterverzeichnis-Bereitstellung. |
| `favicon_path` | `''` | Pfad zu benutzerdefiniertem Favicon. |

### Anzeigeoptionen

| Schlüssel | Standard | Beschreibung |
|-----|---------|-------------|
| `show_hidden` | `false` | Versteckte Dateien anzeigen (beginnend mit `.`). |
| `show_size` | `true` | Dateigrößen-Spalte anzeigen. |
| `show_date` | `true` | Letzte Änderungsdatum-Spalte anzeigen. |
| `show_type` | `true` | Dateityp-Spalte anzeigen (Listenansicht). |
| `show_folder_size` | `true` | Ordnergrößen berechnen (rekursiv — kann für große Ordner langsam sein). |
| `show_breadcrumb` | `true` | Navigations-Breadcrumb anzeigen. |
| `show_footer` | `true` | Fußzeilenleiste anzeigen. |
| `show_copyright` | `true` | Copyright-Info in Fußzeile anzeigen. |
| `show_language_selector` | `true` | Sprachumschalter-Steuerung anzeigen. |
| `show_theme_selector` | `true` | Theme-Umschalter-Button anzeigen. |

### Funktionen

| Schlüssel | Standard | Beschreibung |
|-----|---------|-------------|
| `enable_search` | `true` | Live-Dateisuche aktivieren. |
| `enable_preview` | `true` | Dateivorschau-Modal aktivieren (Bilder, Video, Audio, PDF, Code). |
| `enable_download` | `true` | Download-Buttons auf Dateien anzeigen. |
| `enable_share` | `true` | Dateiteilungs-Modal mit QR-Code aktivieren. |
| `enable_qrcode` | `true` | QR-Codes in Teilungs-Modal generieren. |
| `enable_shortcuts` | `true` | Tastaturkürzel aktivieren. |
| `enable_export` | `true` | Exportieren/Kopieren der Dateiliste aktivieren (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | `README.md`-Dateien am Ende von Verzeichnislisten rendern. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | Komma-getrennte Liste von Hash-Algorithmen. Unterstützt: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, und 30+ mehr. |
| `hash_uppercase` | `true` | Hash-Werte in Großbuchstaben anzeigen. |
| `max_hash_size` | `1000` | Maximale Dateigröße (MB) für Hashing erlaubt. |

### Sicherheit

| Schlüssel | Standard | Beschreibung |
|-----|---------|-------------|
| `ignore_files` | (siehe unten) | Zu versteckende Dateien. Standardmäßig umfasst `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | Zu versteckende Erweiterungen. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | Zu versteckende Ordner. |
| `allowed_extensions` | `[]` | Whitelist von Erweiterungen (leer = alle erlauben). |
| `protected_paths` | `['/etc', '/var/www/.git']` | Immer blockierte absolute Pfade. |
| `enable_rate_limit` | `true` | IP-basierte Ratelimitation aktivieren. |
| `rate_limit_requests` | `60` | Maximale Anfragen pro Fenster. |
| `rate_limit_period` | `60` | Ratelimit-Zeitfenster (Sekunden). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | Von Ratelimitation ausgenommene IPs. |
| `trusted_proxies` | `[]` | Erlaubte IPs zum Setzen von `X-Forwarded-For`. Leer = niemandem vertrauen. |
| `enable_dev` | `true` | **⚠️ In Produktion auf `false` setzen.** Aktiviert PHP-Fehleranzeige und deaktiviert Cache. |

> [!CAUTION]
> Setzen Sie immer `'enable_dev' => false` vor dem Bereitstellen in Produktion. Im Dev-Modus werden PHP-Fehler angezeigt, was Dateipfade, Konfigurationsdetails und Stack-Traces an Besucher exponieren kann.

### Erweitert

| Schlüssel | Standard | Beschreibung |
|-----|---------|-------------|
| `assets_path` | `''` | Pfad zum `_/`-Assets-Ordner. Auto-erkannt, wenn leer. |
| `use_embedded` | `false` | Eingebetteten Assets-Modus erzwingen (verwendet von `Standalone.php`). |
| `thumbnail_directory` | `''` | Benutzerdefinierter Pfad für Thumbnail-Cache. Auto-gesetzt auf `_/thumbs`, wenn leer. |
| `thumbnail_width` | `200` | Maximale Thumbnail-Breite (px). |
| `thumbnail_height` | `200` | Maximale Thumbnail-Höhe (px). |
| `thumbnail_cache_expiry` | `30` | Tage vor dem Löschen gecachter Thumbnails. `0` = immer bereinigen. `-1` = nie bereinigen. |
| `readme_files` | (Liste) | Zu scannende Dateinamen für README-Rendering. |
| `custom_css` | `'_/css/custom.css'` | Pfad zur benutzerdefinierten CSS-Datei (geladen, wenn vorhanden). |
| `custom_js` | `'_/js/custom.js'` | Pfad zur benutzerdefinierten JS-Datei (geladen, wenn vorhanden). |
| `serve_index_files` | `false` | `index.html` direkt bedienen, wenn vorhanden. ⚠️ Potenzielles XSS-Risiko, wenn nicht-vertrauenswürdige Dateien vorhanden sind. |
| `index_files` | `['index.html', …]` | Zu suchende Index-Dateinamen. |

### Server als Verzeichnisindex konfigurieren

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### Externe Hosts erlauben (CSP)
FileLister verwendet eine strenge **Content Security Policy**. Um Ressourcen von externen Domains zu laden, bearbeiten Sie den `Content-Security-Policy`-Header in `core.php`:

```php
// Fügen Sie Ihre Domain zur entsprechenden Direktive hinzu:
// img-src: für externe Bilder
// script-src: für externe Skripte (mit Vorsicht verwenden)
// style-src: für externes CSS
```

---

## 🎨 Theme-Anpassung

### Verfügbare Themes
| Theme | Beschreibung |
|-------|-------------|
| `light` | Sauberes weißes Theme |
| `dark` | Dunkelmodus |
| `auto` | Folgt Systempräferenz |
| `ocean` | Blaue Ozeantöne |
| `forest` | Grüne Erdtöne |
| `dracula` | Dracula dunkles Lila |
| `nord` | Nordische arktische Palette |
| `high-contrast` | Zugänglichkeitsfokus |
| `cute` | Anime-Glassmorphismus mit Hintergrundbild |

### Ein benutzerdefiniertes Theme erstellen

1. **Ein Theme kopieren**: Duplizieren Sie `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **CSS-Variablen bearbeiten**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... andere Variablen */
}
```

3. **In JS registrieren**: Fügen Sie Ihren Themennamen zum `toggleTheme()`-Array in `_/js/app.js` hinzu.

4. **In Config aktivieren**:
```php
'theme' => 'mytheme',
```

5. **In Config whitelisten** (damit Theme-Selektor funktioniert):  In `index.php`, suchen Sie nach `$allowed_themes` und fügen Sie `'mytheme'` zum Array hinzu.

---

## 🧩 Benutzerdefinierte HTML-Hooks

Injizieren Sie benutzerdefiniertes HTML, CSS oder JavaScript an spezifischen Seitenpositionen, ohne Core-Dateien zu bearbeiten. Konfigurieren Sie das `html_hooks`-Array in `core.php`:

```php
'html_hooks' => array(
    'head_end'      => '',  // Vor </head>
    'body_start'    => '',  // Nach <body>
    'header_start'  => '',  // Nach <header> öffnet
    'header_end'    => '',  // Vor </header>
    'main_before'   => '',  // Vor <main>
    'main_start'    => '',  // In <main>, vor Items
    'main_end'      => '',  // In <main>, nach Items
    'main_after'    => '',  // Nach </main>
    'footer_before' => '',  // Vor <footer>
    'footer_start'  => '',  // Nach <footer> öffnet
    'footer_end'    => '',  // Vor </footer>
    'footer_after'  => '',  // Nach </footer>
    'body_end'      => '',  // Vor </body>
    'html_end'      => '',  // Vor </html>
),
```

### Beispiel: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 Mehrsprachiger Support
FileLister auto-erkennt die Browsersprache und unterstützt **18+ Sprachen**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

Setzen Sie eine feste Sprache mit `'language' => 'vi'`, oder lassen Sie leer für Auto-Erkennung.

---

## 👁️ Dateivorschau & Viewer
Integrierter Hochleistungs-Viewer für verschiedene Dateitypen:
- **Bilder**: jpg, png, gif, webp, svg (mit Echtzeit-Thumbnails in Rasteransicht)
- **Videos**: mp4, webm, avi, mov, mkv
- **Audio**: mp3, ogg, flac, wav, m4a
- **Dokumente**: Integrierter PDF-Viewer und Markdown-Rendering
- **Code**: Syntaxhervorhebung via Prism.js für 100+ Sprachen

---

## 🔗 Teilen & Herunterladen
- Generieren Sie sofortige **QR-Codes** für mobile Dateiübertragungen.
- Direkte Download-Links für alle Dateien.
- Sichere Dateifreigabe via einzigartige URLs.
- **Vollständige Unicode-Unterstützung**: Dateinamen in Vietnamesisch, Chinesisch, Japanisch, Arabisch und anderen nicht-ASCII-Scripts werden korrekt in Sharing-Links und QR-Codes prozentual kodiert.

---

## ⌨️ Tastaturkürzel
| Taste | Aktion |
|-----|--------|
| `/` oder `Ctrl+F` | Suchfeld fokussieren |
| `Esc` | Modal schließen / Suche löschen |
| `↑` / `↓` | Durch Items navigieren |
| `Enter` | Ausgewähltes Item öffnen |
| `g` dann `h` | Nach Hause gehen (Wurzel) |
| `g` dann `u` | Eine Verzeichnisebene hinaufgehen |
| `?` | Tastaturkürzel-Hilfe anzeigen |

---

## 🛡️ Sicherheitsdetails

FileLister umfasst mehrere verstärkte Sicherheitsschichten:

| Schicht | Detail |
|-------|--------|
| **Path-Traversal** | `?dir=`-Eingabe mit `realpath()` validiert und auf `$lister_root` beschränkt. |
| **CSP Nonce** | Zufälliger 128-Bit-Nonce pro Anfrage auf allen Inline-Skripten. Kein `unsafe-inline`. |
| **Ratelimiting** | IP-basierter Throttling in temporären Dateien gespeichert. Standard: 60 req/60s. |
| **Vertrauenswürdige Proxies** | `X-Forwarded-For` nur von explizit konfigurierten Proxy-IPs vertraut. |
| **Sensible Dateien** | `.env`, `.git`, `.htaccess`, PHP-Dateien automatisch versteckt. |
| **Sicherheits-Header** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` zum Deaktivieren von Kamera/Mikro/Geo. |
| **HSTS** | `Strict-Transport-Security` automatisch gesendet, wenn auf HTTPS. |
| **CORS** | Export-Endpunkt erlaubt nur Same-Origin-Anfragen. Keine willkürliche Origin-Reflexion. |
| **Keine alten Hashes** | MD5 und SHA-1 aus Standard-Hash-Typen ausgeschlossen. |
| **Symlink-Schutz** | Symlinks während Ordner-Traversal übersprungen, um Schleifen und Lecks zu verhindern. |
| **Dev-Modus** | `enable_dev: false` in Produktion deaktiviert Fehleranzeige. |

> [!IMPORTANT]
> Nach Setup, setzen Sie sofort `'enable_dev' => false`, um zu verhindern, dass Fehlermeldungen Server-Interna exponieren.

---

## 📋 Anforderungen
- **PHP**: 5.2 oder höher (getestet bis PHP 8.4+)
- **Erweiterungen**: `json` (erforderlich), `gd` (optional — für Thumbnails), `zip` (optional)

---

## 📜 Änderungsprotokoll

### v1.5.36 — Sicherheits- & Fehlerbehebungs-Version

**Sicherheitsfixes:**
- 🔒 **[Kritisch] CORS-Reflexionslücke behoben** in `?export=`-Endpunkt — reflektiert keine willkürlichen `Origin`-Header mehr
- 🔒 **[Kritisch] XSS in Dateivorschau behoben** — Dateiname in "nicht unterstützter Typ"-Vorschau nicht vor DOM-Einfügung escaped
- 🔒 **[Kritisch] `enable_dev` jetzt standardmäßig `false`** — verhindert zufällige PHP-Fehler-Divulgation in Produktion
- 🔒 **[Hoch] `dir_theme`-Cookie vor Verwendung validiert** um unerwartetes Verhalten zu verhindern

**Fehlerbehebungen:**
- 🐛 **QR-Code-Generierung fehlgeschlagen behoben** für Dateien mit Unicode-Namen (Vietnamesisch, Chinesisch, Japanisch, etc.)
- 🐛 **Share-Link gebrochen behoben** für Dateien mit Unicode/Nicht-ASCII-Dateinamen
- 🐛 **Bildvorschau nicht ladend behoben** für Dateien mit Unicode-Dateinamen
- 🐛 **Duplizierte `</div>`-Tag behoben** in Footer-HTML (verursachte Layout-Probleme in einigen Browsern)
- 🐛 **`style.css` zweimal geladen behoben** (Bandbreitenverschwendung, doppelte Analyse)
- 🐛 **Fehlende `custom.js` / `custom.css`** in `Standalone.php`-Build behoben
- 🐛 **Theme-Wiederherstellung behoben** — `dracula`-, `nord`-, `high-contrast`-, `cute`-Themes setzen sich nicht mehr bei Seiten-Neuladen zurück
- 🐛 **Duplizierte SVG-Icons behoben** mit Thumbnails in Rasteransicht injiziert
- 🐛 **AJAX-Navigationsconfig-Parsing behoben** — robusterer Regex anstatt fragiler index-basierter Extraktion
- 🐛 **`previewText()` 404-HTML zeigend behoben** als Dateiinhalt, wenn Datei unzugänglich
- 🐛 **Toter Code `changeLanguage()` behoben** referenzierend nicht-existentes `langToggle`-Element
- 🐛 **SHA-512/224 und SHA-512/256 hinzugefügt** zur Hash-Algorithmus-Map (in Docs gelistet aber in Code fehlend)
- 🐛 **Ersetzt `alert()`-Aufrufe** in Clipboard-Kopie durch nicht-blockierende Toast-Benachrichtigungen
- 🐛 **Bildgalerie-Navigation behoben** — Bilder durch Filter/Suche versteckt werden jetzt von prev/next-Traversal ausgeschlossen
- 🐛 **`audio`/`video`-Vorschauen behoben** — Fehlerhandler hinzugefügt, wenn Medium beim Laden fehlschlägt

---

## ☕ Unterstützen Sie Meine Arbeit
Genießen Sie dieses Open-Source-PHP-Script?
- [Kaufen Sie mir ein 🍻](https://buymeacoffee.com/trong)
- Spenden Sie via ❤️ [PayPal](https://paypal.me/DaoVanTrong)

---

## 📝 Lizenz
MIT-Lizenz — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
