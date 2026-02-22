<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: Script moderno per elenchi di directory PHP v1.5.36

FileLister è uno script potente, leggero e moderno per **elenchi di directory PHP** che trasforma i tuoi file server in un bello e mobile-friendly **esploratore di file web**. È l'alternativa perfetta a `h5ai` o `Apache Index`, offrendo un'opzione di distribuzione a file singolo e anteprime di file integrate.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 Sommario
- [✨ Caratteristiche](#-caratteristiche)
- [📦 Installazione](#-installazione)
- [⚙️ Configurazione](#-configurazione)
- [🎨 Temi](#-temi)
- [🧩 Hook HTML personalizzati](#-hook-html-personalizzati)
- [🌍 Supporto multilingue](#-supporto-multilingue)
- [👁️ Anteprima file](#-anteprima-file--viewer)
- [🔗 Condividi & Scarica](#-condividi--scarica)
- [⌨️ Scorciatoie da tastiera](#-scorciatoie-da-tastiera)
- [🛡️ Dettagli di sicurezza](#-dettagli-di-sicurezza)
- [📋 Requisiti](#-requisiti)

---

## ✨ Caratteristiche

### 🚀 **Pronto per la Produzione & Veloce**
- **Versione Standalone**: Distribuzione a file singolo (`Standalone.php`) con tutte le risorse incorporate. Esegui `php build.php` per generare.
- **Supporto Docker**: `Dockerfile` e `docker-compose.yml` pronti all'uso.
- **Servi Index**: Opzionalmente servi `index.html` se presente in una directory.

### 🎨 **Interfaccia Utente Moderna**
- **Pulita & Responsiva**: Layout mobile-first, funziona su qualsiasi dispositivo.
- **9 Temi**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (glassmorphism anime).
- **Viste Griglia & Lista**: Passa tra viste griglia a schede e lista dettagliata.
- **Rendering README**: Renderizza automaticamente file `README.md` in fondo agli elenchi di directory.
- **Localizzato**: Selettore di lingua con 18+ locali supportati.

### 🛡️ **Sicurezza Rafforzata**
- **CSP con Nonces**: Nonce crittografico per richiesta su tutti gli script inline. Nessun `unsafe-inline`.
- **Limitazione di Tasso**: Throttling di richieste anti-DDoS integrato (60 req/60s per impostazione predefinita).
- **Proxy Affidabili**: Gestione sicura di `X-Forwarded-For` — applicata solo se la richiesta proviene da un IP proxy affidabile.
- **Protezione Path Traversal**: Tutti gli input `?dir=` sono risolti tramite `realpath()` e vincolati a `$lister_root`.
- **Nascondimento File Sensibili**: Ignora automaticamente `.env`, `.git`, `.htaccess`, e file PHP.
- **Intestazioni di Sicurezza**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (solo HTTPS).
- **Nessun MD5/SHA-1**: Set di hash predefinito impostato su `CRC32,XXH128,SHA-256,SHA3-256`. MD5 e SHA-1 esclusi per impostazione predefinita.

### 🔍 **Integrità File (Info & Hash)**
- Verifica 40+ algoritmi di hash per file, inclusi SHA-3, WHIRLPOOL, XXH128, CRC32.
- Dimensione massima file configurabile per hashing.
- Risultati visualizzati inline nel modale Info.

### 📤 **Esporta & Condividi**
- Copia/Scarica lista file in formati **JSON, CSV, TSV, NDJSON**.
- Condividi file tramite codici QR e link diretti.

---

## 📦 Installazione & Modi di Distribuzione

FileLister supporta 4 modi di distribuzione. Scegli quello che si adatta alla tua configurazione:

---

### Modo 1: Standalone (File PHP Singolo) — Raccomandato per Produzione

Tutte le risorse sono compilate in un file auto-contenuto. Nessuna cartella `_/` necessaria.

```bash
# Passo 1: Costruisci il file standalone
php build.php

# Passo 2: Carica Standalone.php sul tuo server
# Passo 3: Rinominalo in index.php (o qualsiasi nome tu preferisca)
```

> **Config**: Imposta automaticamente `'use_embedded' => true`. Nessuna altra config necessaria.

---

### Modo 2: Normale (File Sorgente)

Configurazione multi-file classica. Più veloce per lo sviluppo.

```
your-web-root/
├── index.php        ← Punto di ingresso (require_once 'core.php')
├── core.php         ← Logica core & config
└── _/               ← File CSS, JS, icone, traduzioni
```

**Passi:**
1. Copia `index.php`, `core.php`, e `_/` nella tua directory web.
2. Accedi via browser: `http://yoursite.com/`
3. Nessuna configurazione aggiuntiva necessaria.

---

### Modo 3: Distribuzione Sottodirectory

Esegui FileLister in una sottocartella che indicizza il suo contenuto.

```
your-web-root/
├── files/           ← Directory che vuoi indicizzare
│   ├── index.php    ← Punto di ingresso FileLister
│   └── core.php
└── _/               ← Asset condivisi (auto-rilevati da scansione padre)
```

La funzione `detect_assets_path()` scansiona automaticamente **fino a 5 directory padre** per localizzare la cartella asset `_/`. Nessuna config manuale `assets_path` richiesta nella maggior parte dei casi.

Se gli asset non vengono auto-rilevati:
```php
'assets_path' => '../_',   // O percorso completo come '/var/www/html/_'
```

---

### Modo 4: Distribuzione Globale (Indicizza Qualsiasi Directory sul Server)

Usa **una singola installazione FileLister** per navigare qualsiasi percorso sul server, scollegato dalla posizione dello script.

```
/var/www/html/
├── filelister/      ← FileLister vive qui
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← Directory che vuoi davvero indicizzare
```

**Configurazione in `core.php`:**
```php
'base_path' => '/var/data',   // ← Imposta la directory che vuoi elencare
```

> `base_path` accetta qualsiasi **percorso assoluto del filesystem** che il processo PHP possa leggere. Lo script forzerà che tutta la navigazione `?dir=` rimanga entro questa radice tramite `realpath()` per prevenire path traversal.

**Configurazione Server Web** (per usare FileLister come indice di directory):

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

**Apache (`.htaccess` nella directory target):**
```apache
DirectoryIndex index.php FileLister.php index.html

# Instrada tutte le richieste di directory a FileLister:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### Modo 5: Docker

```bash
docker-compose up -d
```

Accedi a `http://localhost:8080`. Modifica `docker-compose.yml` per montare la tua directory target.

---

### Confronto Modi di Distribuzione

| Modo | File Necessari | Migliore Per |
|------|---------------|----------|
| **Standalone** | Solo `Standalone.php` | Distribuzione veloce, hosting condiviso |
| **Normale** | `index.php` + `core.php` + `_/` | Sviluppo, controllo completo |
| **Sottodirectory** | Uguale a Normale, posizionato in sottocartella | Indicizzazione di una sottocartella specifica |
| **Globale** | Normale + config `base_path` | Istanza singola indicizzante qualsiasi percorso server |
| **Docker** | `Dockerfile` + `docker-compose.yml` | Ambienti containerizzati |

---

## ⚙️ Configurazione

Tutte le impostazioni sono nell'array `$config` in `core.php` (o `Standalone.php`).

### Generale

| Chiave | Predefinito | Descrizione |
|-----|---------|-------------|
| `title` | `''` | Titolo pagina personalizzato. Se vuoto, auto-generato dal percorso. |
| `title_prefix` | `'Index of'` | Prefisso per titolo auto-generato. |
| `title_suffix` | `' - FileLister'` | Suffisso per titolo auto-generato. |
| `language` | `''` | Forza un locale (`en`, `vi`, `zh`, `ja`…). Auto-rileva se vuoto. |
| `allowed_langs` | (18 lingue) | Lingue disponibili nel dropdown del selettore. |
| `theme` | `'ocean'` | Tema predefinito. Opzioni: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | Vista predefinita. Opzioni: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | Stringa fuso orario PHP. |
| `date_format` | `'Y-m-d H:i:s'` | Stringa formato data PHP. |
| `base_path` | `''` | Directory radice per distribuzione globale/sottodirectory. |
| `favicon_path` | `''` | Percorso a favicon personalizzato. |

### Opzioni di Visualizzazione

| Chiave | Predefinito | Descrizione |
|-----|---------|-------------|
| `show_hidden` | `false` | Mostra file nascosti (inizianti con `.`). |
| `show_size` | `true` | Mostra colonna dimensione file. |
| `show_date` | `true` | Mostra colonna data ultima modifica. |
| `show_type` | `true` | Mostra colonna tipo file (vista lista). |
| `show_folder_size` | `true` | Calcola dimensioni cartelle (ricorsivo — può essere lento per cartelle grandi). |
| `show_breadcrumb` | `true` | Mostra breadcrumb navigazione. |
| `show_footer` | `true` | Mostra barra piè di pagina. |
| `show_copyright` | `true` | Mostra info copyright nel piè di pagina. |
| `show_language_selector` | `true` | Mostra controllo selettore lingua. |
| `show_theme_selector` | `true` | Mostra pulsante selettore tema. |

### Caratteristiche

| Chiave | Predefinito | Descrizione |
|-----|---------|-------------|
| `enable_search` | `true` | Abilita ricerca file live. |
| `enable_preview` | `true` | Abilita modale anteprima file (immagini, video, audio, PDF, codice). |
| `enable_download` | `true` | Mostra pulsanti download sui file. |
| `enable_share` | `true` | Abilita modale condivisione file con codice QR. |
| `enable_qrcode` | `true` | Genera codici QR nel modale condivisione. |
| `enable_shortcuts` | `true` | Abilita scorciatoie tastiera. |
| `enable_export` | `true` | Abilita esporta/copia lista file (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | Renderizza file `README.md` in fondo agli elenchi di directory. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | Lista separata da virgola di algoritmi hash. Supportati: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, e 30+ altri. |
| `hash_uppercase` | `true` | Mostra valori hash in maiuscolo. |
| `max_hash_size` | `1000` | Dimensione massima file (MB) consentita per hashing. |

### Sicurezza

| Chiave | Predefinito | Descrizione |
|-----|---------|-------------|
| `ignore_files` | (vedi sotto) | File da nascondere. Include per default `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | Estensioni da nascondere. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | Cartelle da nascondere. |
| `allowed_extensions` | `[]` | Whitelist di estensioni (vuoto = consenti tutti). |
| `protected_paths` | `['/etc', '/var/www/.git']` | Percorsi assoluti sempre bloccati. |
| `enable_rate_limit` | `true` | Abilita limitazione tasso basata su IP. |
| `rate_limit_requests` | `60` | Massimo richieste per finestra. |
| `rate_limit_period` | `60` | Finestra tempo limitazione tasso (secondi). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | IP esenti da limitazione tasso. |
| `trusted_proxies` | `[]` | IP autorizzati a impostare `X-Forwarded-For`. Vuoto = non fidarti di nessuno. |
| `enable_dev` | `true` | **⚠️ Imposta su `false` in produzione.** Abilita display errori PHP e disabilita cache. |

> [!CAUTION]
> Imposta sempre `'enable_dev' => false` prima di distribuire in produzione. In modalità dev, gli errori PHP vengono visualizzati il che può esporre percorsi file, dettagli configurazione, e tracce stack ai visitatori.

### Avanzato

| Chiave | Predefinito | Descrizione |
|-----|---------|-------------|
| `assets_path` | `''` | Percorso alla cartella asset `_/`. Auto-rilevato se vuoto. |
| `use_embedded` | `false` | Forza modalità asset incorporati (usato da `Standalone.php`). |
| `thumbnail_directory` | `''` | Percorso personalizzato per cache thumbnail. Auto-impostato a `_/thumbs` se vuoto. |
| `thumbnail_width` | `200` | Larghezza massima thumbnail (px). |
| `thumbnail_height` | `200` | Altezza massima thumbnail (px). |
| `thumbnail_cache_expiry` | `30` | Giorni prima che thumbnail cacheati siano purgati. `0` = sempre pulisci. `-1` = mai pulisci. |
| `readme_files` | (lista) | Nomi file da scansionare per rendering README. |
| `custom_css` | `'_/css/custom.css'` | Percorso a file CSS personalizzato (caricato se esiste). |
| `custom_js` | `'_/js/custom.js'` | Percorso a file JS personalizzato (caricato se esiste). |
| `serve_index_files` | `false` | Servi `index.html` direttamente se presente. ⚠️ Rischio XSS potenziale se esistono file non fidati. |
| `index_files` | `['index.html', …]` | Nomi file indice da cercare. |

### Configura Server come Indice Directory

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### Permetti Host Esterni (CSP)
FileLister usa una **Politica Sicurezza Contenuto** rigorosa. Per caricare risorse da domini esterni, modifica l'intestazione `Content-Security-Policy` in `core.php`:

```php
// Aggiungi il tuo dominio alla direttiva appropriata:
// img-src: per immagini esterne
// script-src: per script esterni (usa con cautela)
// style-src: per CSS esterni
```

---

## 🎨 Personalizzazione Tema

### Temi Disponibili
| Tema | Descrizione |
|-------|-------------|
| `light` | Tema bianco pulito |
| `dark` | Modalità scura |
| `auto` | Segui preferenza sistema |
| `ocean` | Toni oceano blu |
| `forest` | Toni terra verdi |
| `dracula` | Viola scuro Dracula |
| `nord` | Tavolozza artica nordica |
| `high-contrast` | Focus accessibilità |
| `cute` | Glassmorphism anime con immagine sfondo |

### Crea un Tema Personalizzato

1. **Copia un tema**: Duplica `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **Modifica variabili CSS**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... altre variabili */
}
```

3. **Registra in JS**: Aggiungi il nome del tuo tema all'array `toggleTheme()` in `_/js/app.js`.

4. **Attiva in config**:
```php
'theme' => 'mytheme',
```

5. **Whitelist in config** (perché il selettore tema funzioni): In `index.php`, cerca `$allowed_themes` e aggiungi `'mytheme'` all'array.

---

## 🧩 Hook HTML Personalizzati

Inietta HTML, CSS o JavaScript personalizzato in posizioni specifiche di pagina senza modificare file core. Configura l'array `html_hooks` in `core.php`:

```php
'html_hooks' => array(
    'head_end'      => '',  // Prima di </head>
    'body_start'    => '',  // Dopo <body>
    'header_start'  => '',  // Dopo <header> apre
    'header_end'    => '',  // Prima di </header>
    'main_before'   => '',  // Prima di <main>
    'main_start'    => '',  // Dentro <main>, prima di items
    'main_end'      => '',  // Dentro <main>, dopo items
    'main_after'    => '',  // Dopo </main>
    'footer_before' => '',  // Prima di <footer>
    'footer_start'  => '',  // Dopo <footer> apre
    'footer_end'    => '',  // Prima di </footer>
    'footer_after'  => '',  // Dopo </footer>
    'body_end'      => '',  // Prima di </body>
    'html_end'      => '',  // Prima di </html>
),
```

### Esempio: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 Supporto Multilingue
FileLister auto-rileva la lingua del browser e supporta **18+ lingue**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

Imposta una lingua fissa con `'language' => 'vi'`, o lascia vuoto per auto-rilevamento.

---

## 👁️ Anteprima File & Viewer
Viewer ad alte prestazioni integrato per vari tipi di file:
- **Immagini**: jpg, png, gif, webp, svg (thumbnail in tempo reale in vista griglia)
- **Video**: mp4, webm, avi, mov, mkv
- **Audio**: mp3, ogg, flac, wav, m4a
- **Documenti**: Viewer PDF integrato e rendering Markdown
- **Codice**: Evidenziazione sintassi tramite Prism.js per 100+ linguaggi

---

## 🔗 Condividi & Scarica
- Genera **QR code istantanei** per trasferimenti file mobili.
- Link di download diretti per tutti i file.
- Condivisione file sicura tramite URL unici.
- **Supporto Unicode completo**: i nomi file in vietnamita, cinese, giapponese, arabo, e altri script non-ASCII sono correttamente percent-encoded nei link di condivisione e QR code.

---

## ⌨️ Scorciatoie Tastiera
| Tasto | Azione |
|-----|--------|
| `/` o `Ctrl+F` | Focalizza scatola ricerca |
| `Esc` | Chiudi modale / cancella ricerca |
| `↑` / `↓` | Naviga tra items |
| `Enter` | Apri item selezionato |
| `g` poi `h` | Vai a casa (radice) |
| `g` poi `u` | Vai su un livello directory |
| `?` | Mostra aiuto scorciatoie tastiera |

---

## 🛡️ Dettagli Sicurezza

FileLister include molteplici livelli di sicurezza rafforzati:

| Livello | Dettaglio |
|-------|--------|
| **Path Traversal** | Input `?dir=` validato con `realpath()` e vincolato a `$lister_root`. |
| **CSP Nonce** | Nonce casuale 128-bit per richiesta su tutti gli script inline. Nessun `unsafe-inline`. |
| **Limitazione Tasso** | Throttling basato su IP memorizzato in file temporanei. Predefinito: 60 req/60s. |
| **Proxy Affidabili** | `X-Forwarded-For` fidato solo da IP proxy configurati esplicitamente. |
| **File Sensibili** | `.env`, `.git`, `.htaccess`, file PHP nascosti automaticamente. |
| **Intestazioni Sicurezza** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` per disabilitare camera/mic/geo. |
| **HSTS** | `Strict-Transport-Security` inviato automaticamente quando su HTTPS. |
| **CORS** | Endpoint esportazione permette solo richieste same-origin. Nessuna riflessione origin arbitraria. |
| **Nessun Hash Vecchio** | MD5 e SHA-1 esclusi dai tipi hash predefiniti. |
| **Protezione Symlink** | Symlink saltati durante traversal cartella per prevenire loop e perdite. |
| **Modalità Dev** | `enable_dev: false` in produzione disabilita display errori. |

> [!IMPORTANT]
> Dopo configurazione, imposta immediatamente `'enable_dev' => false` per impedire che messaggi errore espongano interni server.

---

## 📋 Requisiti
- **PHP**: 5.2 o superiore (testato fino a PHP 8.4+)
- **Estensioni**: `json` (richiesto), `gd` (opzionale — per thumbnail), `zip` (opzionale)

---

## 📜 Registro Cambi

### v1.5.36 — Versione Sicurezza & Correzione Bug

**Correzioni Sicurezza:**
- 🔒 **[Critico] Corretto vulnerabilità riflessione CORS** in endpoint `?export=` — non riflette più intestazioni `Origin` arbitrarie
- 🔒 **[Critico] Corretto XSS in anteprima file** — nome file in preview "tipo non supportato" non era escaped prima dell'inserimento in DOM
- 🔒 **[Critico] `enable_dev` ora predefinito `false`** — previene divulgazione accidentale errori PHP in produzione
- 🔒 **[Alto] Convalidato cookie `dir_theme`** prima dell'uso per prevenire comportamento inaspettato

**Correzioni Bug:**
- 🐛 **Corretto generazione QR fallita** per file con nomi Unicode (vietnamita, cinese, giapponese, etc.)
- 🐛 **Corretto link condivisione rotto** per file con nomi file Unicode/non-ASCII
- 🐛 **Corretto anteprima immagine non caricante** per file con nomi file Unicode
- 🐛 **Corretto tag `</div>` duplicato** in HTML footer (causava problemi layout in alcuni browser)
- 🐛 **Corretto `style.css` caricato due volte** (spreco banda, doppio-parse)
- 🐛 **Corretto `custom.js` / `custom.css` mancante** in build `Standalone.php`
- 🐛 **Corretto ripristino tema** — temi `dracula`, `nord`, `high-contrast`, `cute` non si resettano più al ricarico pagina
- 🐛 **Corretto icone SVG duplicate** iniettate insieme a thumbnail in vista griglia
- 🐛 **Corretto parsing config navigazione AJAX** — regex più robusto invece di estrazione basata su indice fragile
- 🐛 **Corretto `previewText()` mostrando HTML 404** come contenuto file quando file inaccessibile
- 🐛 **Corretto codice morto `changeLanguage()`** riferente elemento `langToggle` inesistente
- 🐛 **Aggiunto SHA-512/224 e SHA-512/256** alla mappa algoritmi hash (elencati in docs ma mancanti in codice)
- 🐛 **Sostituito chiamate `alert()`** in copia clipboard con notifiche toast non-blocanti
- 🐛 **Corretto navigazione galleria immagini** — immagini nascoste da filtro/ricerca ora escluse da traversal prev/next
- 🐛 **Corretto preview `audio`/`video`** — aggiunto gestore errore quando media fallisce a caricare

---

## ☕ Supporta Il Mio Lavoro
Ti piace questo script PHP open-source?
- [Comprami una 🍻](https://buymeacoffee.com/trong)
- Dona via ❤️ [PayPal](https://paypal.me/DaoVanTrong)

---

## 📝 Licenza
Licenza MIT — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
