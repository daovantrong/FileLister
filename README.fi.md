<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: Moderni PHP Directory Listing Script v1.5.36

FileLister on tehokas, kevyt ja moderni **PHP directory listing script** joka muuntaa palvelintiedostosi kauniiksi, mobiiliystävällisiksi **web file exploreriksi**. Se on täydellinen vaihtoehto `h5ai`:lle tai `Apache Index`:lle, tarjoten yhden tiedoston käyttöönotto vaihtoehdon ja sisäänrakennetut tiedoston esikatselut.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 Sisällysluettelo
- [✨ Ominaisuudet](#-ominaisuudet)
- [📦 Asennus](#-asennus)
- [⚙️ Konfiguraatio](#-konfiguraatio)
- [🎨 Teemat](#-teemat)
- [🧩 Mukautetut HTML Hookit](#-mukautetut-html-hookit)
- [🌍 Monikielinen tuki](#-monikielinen-tuki)
- [👁️ Tiedoston esikatselu](#-tiedoston-esikatselu--viewer)
- [🔗 Jaa & Lataa](#-jaa--lataa)
- [⌨️ Näppäimistön pikakuvakkeet](#-näppäimistön-pikakuvakkeet)
- [🛡️ Turvallisuustiedot](#-turvallisuustiedot)
- [📋 Vaatimukset](#-vaatimukset)

---

## ✨ Ominaisuudet

### 🚀 **Tuotantovalmis & Nopea**
- **Standalone Versio**: Yhden tiedoston käyttöönotto (`Standalone.php`) jossa kaikki resurssit upotettu. Suorita `php build.php` generoidaksesi.
- **Docker Tuki**: Valmiit `Dockerfile` ja `docker-compose.yml`.
- **Palvele Index**: Vaihtoehtoisesti palvele `index.html` jos läsnä kansiossa.

### 🎨 **Moderni Käyttöliittymä**
- **Siisti & Responsiivinen**: Mobile-first layout, toimii kaikilla laitteilla.
- **9 Teemaa**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (anime glassmorphism).
- **Ruudukko & Lista Näkymät**: Vaihda ruudukko- ja lista näkymien välillä.
- **README Rendering**: Renderöi automaattisesti `README.md` tiedostot kansiolistojen alareunassa.
- **Lokalisoidut**: Kieli valitsin 18+ tuetuilla lokaliteeteilla.

### 🛡️ **Turvallisuus Parannettu**
- **CSP ja Nonces**: Pyyntö-per-kryptografinen nonce kaikilla inline-skripteillä. Ei `unsafe-inline`.
- **Rate Limiting**: Integroitua anti-DDoS pyyntö throttling (60 req/60s oletuksena).
- **Luotettavat Proxyt**: Turvallinen `X-Forwarded-For` käsittely — vain sovellettu jos pyyntö tulee luotettavalta proxy IP:ltä.
- **Path Traversal Suojaus**: Kaikki `?dir=` syöte ratkaistaan `realpath()`:lla ja sidotaan `$lister_root`:iin.
- **Piilota Arkaluonteiset Tiedostot**: Ohittaa automaattisesti `.env`, `.git`, `.htaccess`, ja PHP tiedostot.
- **Turvallisuus Headers**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (vain HTTPS).
- **Ei MD5/SHA-1**: Oletus hash joukko asetettu `CRC32,XXH128,SHA-256,SHA3-256`:ksi. MD5 ja SHA-1 suljettu oletuksena.

### 🔍 **Tiedoston Eheyys (Info & Hash)**
- Vahvistaa 40+ hash algoritmia per tiedosto, mukaan lukien SHA-3, WHIRLPOOL, XXH128, CRC32.
- Konfiguroitavissa oleva maksimi tiedostokoko hashingille.
- Tulokset näytetään inline Info modalissa.

### 📤 **Vie & Jaa**
- Kopioi/Lataa tiedostolista **JSON, CSV, TSV, NDJSON** muodoissa.
- Jaa tiedostot QR koodeilla ja suorilla linkeillä.

---

## 📦 Asennus & Käyttöönotto Modit

FileLister tukee 4 käyttöönotto modia. Valitse joka sopii konfiguraatioosi:

---

### Modus 1: Standalone (Yksittäinen PHP Tiedosto) — Suositeltu Tuotannolle

Kaikki resurssit on käännetty itsenäiseksi tiedostoksi. Ei `_/` kansiota tarvita.

```bash
# Vaihe 1: Rakenna standalone tiedosto
php build.php

# Vaihe 2: Lataa Standalone.php palvelimellesi
# Vaihe 3: Nimeä uudelleen index.php:ksi (tai minkä nimiseksi haluat)
```

> **Config**: Asettaa automaattisesti `'use_embedded' => true`. Ei muuta configia tarvita.

---

### Modus 2: Normaali (Lähde Tiedostot)

Klassinen multi-tiedosto konfiguraatio. Nopein kehitykseen.

```
your-web-root/
├── index.php        ← Sisäänkäyntipiste (require_once 'core.php')
├── core.php         ← Ydin logiikka & config
└── _/               ← CSS, JS, ikonit, käännöstiedostot
```

**Vaiheet:**
1. Kopioi `index.php`, `core.php`, ja `_/` webkansioosi.
2. Käytä selaimella: `http://yoursite.com/`
3. Ei lisäkonfiguraatiota tarvita.

---

### Modus 3: Alikansio Käyttöönotto

Aja FileLister alikansiossa joka indeksoi oman sisältönsä.

```
your-web-root/
├── files/           ← Kansio jonka haluat indeksoida
│   ├── index.php    ← FileLister sisäänkäyntipiste
│   └── core.php
└── _/               ← Jaetut resurssit (auto-tunnistettu vanhempi skannauksella)
```

Funktio `detect_assets_path()` skannaa automaattisesti **korkeintaan 5 vanhempi kansiota** paikantaakseen `_/` resurssi kansion. Ei manuaalista `assets_path` configia tarvita useimmissa tapauksissa.

Jos resurssit eivät auto-tunnistu:
```php
'assets_path' => '../_',   // Tai täysi polku kuten '/var/www/html/_'
```

---

### Modus 4: Globaali Käyttöönotto (Indeksoi Jokainen Kansio Palvelimella)

Käytä **yksittäistä FileLister asennusta** selataksesi jokaista polkua palvelimella, irrotettu skriptin sijainnista.

```
/var/www/html/
├── filelister/      ← FileLister elää täällä
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← Kansio jonka todella haluat indeksoida
```

**Konfiguraatio `core.php`:ssa:**
```php
'base_path' => '/var/data',   // ← Aseta kansio jonka haluat listata
```

> `base_path` hyväksyy minkä tahansa **absoluuttisen tiedostojärjestelmä polun** jonka PHP prosessi voi lukea. Skripti pakottaa kaikki `?dir=` navigoinnit pysymään tässä juuressa `realpath()`:lla estääkseen path traversalin.

**Web Palvelin Konfiguraatio** (käyttääkseen FileLister kansioindeksinä):

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

**Apache (`.htaccess` kohde kansiossa):**
```apache
DirectoryIndex index.php FileLister.php index.html

# Reititä kaikki kansio pyynnöt FileListerille:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### Modus 5: Docker

```bash
docker-compose up -d
```

Käytä osoitteessa `http://localhost:8080`. Muokkaa `docker-compose.yml` kiinnittääksesi kohdekansiosi.

---

### Käyttöönotto Modus Vertailu

| Modus | Vaaditut Tiedostot | Paras |
|------|---------------|----------|
| **Standalone** | Vain `Standalone.php` | Nopea käyttöönotto, jaettu hosting |
| **Normaali** | `index.php` + `core.php` + `_/` | Kehitys, täysi kontrolli |
| **Alikansio** | Sama kuin Normaali, sijoitettu alikansioon | Indeksointi tietyn alikansion |
| **Globaali** | Normaali + `base_path` config | Yksittäinen instanssi indeksointi joka palvelin polku |
| **Docker** | `Dockerfile` + `docker-compose.yml` | Kontainerisoidut ympäristöt |

---

## ⚙️ Konfiguraatio

Kaikki asetukset ovat `$config` arrayssa `core.php`:ssa (tai `Standalone.php`:ssa).

### Yleinen

| Avain | Oletus | Kuvaus |
|-----|---------|-------------|
| `title` | `''` | Mukautettu sivunimi. Jos tyhjä, auto-generoitu polusta. |
| `title_prefix` | `'Index of'` | Etuliite auto-generoidulle nimelle. |
| `title_suffix` | `' - FileLister'` | Takaliite auto-generoidulle nimelle. |
| `language` | `''` | Pakota locale (`en`, `vi`, `zh`, `ja`…). Auto-tunnistaa jos tyhjä. |
| `allowed_langs` | (18 kieltä) | Kielet saatavilla valitsin dropdownissa. |
| `theme` | `'ocean'` | Oletus teema. Vaihtoehdot: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | Oletus näkymä. Vaihtoehdot: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | PHP aikavyöhyke string. |
| `date_format` | `'Y-m-d H:i:s'` | PHP päivämääräformaatti string. |
| `base_path` | `''` | Juuri kansio globaali/ali kansio käyttöönotolle. |
| `favicon_path` | `''` | Polku mukautettuun faviconiin. |

### Näyttöasetukset

| Avain | Oletus | Kuvaus |
|-----|---------|-------------|
| `show_hidden` | `false` | Näytä piilotetut tiedostot (alkavat `.`:lla). |
| `show_size` | `true` | Näytä tiedostokoko sarake. |
| `show_date` | `true` | Näytä viimeisin muokkauspäivä sarake. |
| `show_type` | `true` | Näytä tiedostotyyppi sarake (lista näkymä). |
| `show_folder_size` | `true` | Laske kansio koot (rekursiivisesti — voi olla hidasta suurille kansioille). |
| `show_breadcrumb` | `true` | Näytä navigaatio breadcrumb. |
| `show_footer` | `true` | Näytä footer bar. |
| `show_copyright` | `true` | Näytä copyright info footerissa. |
| `show_language_selector` | `true` | Näytä kieli vaihdin kontrolli. |
| `show_theme_selector` | `true` | Näytä teema vaihdin nappi. |

### Ominaisuudet

| Avain | Oletus | Kuvaus |
|-----|---------|-------------|
| `enable_search` | `true` | Aktivoi live tiedostohaku. |
| `enable_preview` | `true` | Aktivoi tiedoston esikatselu modal (kuvat, video, ääni, PDF, koodi). |
| `enable_download` | `true` | Näytä lataus napit tiedostoilla. |
| `enable_share` | `true` | Aktivoi tiedoston jakaminen modal QR koodilla. |
| `enable_qrcode` | `true` | Generoi QR koodit jakamis modalissa. |
| `enable_shortcuts` | `true` | Aktivoi näppäimistön pikakuvakkeet. |
| `enable_export` | `true` | Aktivoi vie/kopioi tiedostolista (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | Renderoi `README.md` tiedostot kansiolistojen alareunassa. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | Pilku-erotettu lista hash algoritmeista. Tuetut: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, ja 30+ enemmän. |
| `hash_uppercase` | `true` | Näytä hash arvot isoilla kirjaimilla. |
| `max_hash_size` | `1000` | Maksimi tiedostokoko (MB) sallittu hashingille. |

### Turvallisuus

| Avain | Oletus | Kuvaus |
|-----|---------|-------------|
| `ignore_files` | (katso alla) | Tiedostot piilottaa. Oletus sisältää `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | Laajennukset piilottaa. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | Kansiot piilottaa. |
| `allowed_extensions` | `[]` | Laajennusten whitelist (tyhjä = salli kaikki). |
| `protected_paths` | `['/etc', '/var/www/.git']` | Aina estetyt absoluuttiset polut. |
| `enable_rate_limit` | `true` | Aktivoi IP-pohjainen rate limiting. |
| `rate_limit_requests` | `60` | Maksimi pyynnöt per ikkuna. |
| `rate_limit_period` | `60` | Rate limit aikaikkuna (sekunteja). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | IP:t pois rate limitingistä. |
| `trusted_proxies` | `[]` | IP:t sallittu asettamaan `X-Forwarded-For`. Tyhjä = älä luota kehenkään. |
| `enable_dev` | `true` | **⚠️ Aseta `false`:ksi tuotannossa.** Aktivoi PHP virhe näyttö ja deaktivoi cache. |

> [!CAUTION]
> Aseta aina `'enable_dev' => false` ennen käyttöönottoa tuotantoon. Dev modissa PHP virheet näytetään mikä voi paljastaa tiedostopolkuja, konfiguraatio yksityiskohtia, ja stack traceja vierailijoille.

### Edistynyt

| Avain | Oletus | Kuvaus |
|-----|---------|-------------|
| `assets_path` | `''` | Polku `_/` resurssi kansioon. Auto-tunnistettu jos tyhjä. |
| `use_embedded` | `false` | Pakota upotetut resurssit modus (käytetty `Standalone.php`:ssa). |
| `thumbnail_directory` | `''` | Mukautettu polku thumbnail cachelle. Auto-asetettu `_/thumbs`:ksi jos tyhjä. |
| `thumbnail_width` | `200` | Maksimi thumbnail leveys (px). |
| `thumbnail_height` | `200` | Maksimi thumbnail korkeus (px). |
| `thumbnail_cache_expiry` | `30` | Päivät ennen kuin cachetut thumbnailit tyhjennetään. `0` = aina tyhjennä. `-1` = älä koskaan tyhjennä. |
| `readme_files` | (lista) | Tiedostonimet skannata README renderoimiseksi. |
| `custom_css` | `'_/css/custom.css'` | Polku mukautettuun CSS tiedostoon (ladattu jos löytyy). |
| `custom_js` | `'_/js/custom.js'` | Polku mukautettuun JS tiedostoon (ladattu jos löytyy). |
| `serve_index_files` | `false` | Palvele `index.html` suoraan jos läsnä. ⚠️ Potentiaali XSS riski jos epäluotettavia tiedostoja löytyy. |
| `index_files` | `['index.html', …]` | Indeksi tiedostonimet etsiä. |

### Konfiguroi Palvelin Kansioindeksiksi

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### Salli Ulkoiset Isännät (CSP)
FileLister käyttää tiukkaa **Content Security Policy**. Ladataaksesi resursseja ulkoisista domaineista, muokkaa `Content-Security-Policy` headeria `core.php`:ssa:

```php
// Lisää domainisi oikeaan direktiiviin:
// img-src: ulkoisille kuville
// script-src: ulkoisille skripteille (käytä varoen)
// style-src: ulkoiselle CSS:lle
```

---

## 🎨 Teema Mukauttaminen

### Saatavilla Teemat
| Teema | Kuvaus |
|-------|-------------|
| `light` | Siisti valkoinen teema |
| `dark` | Tumma modus |
| `auto` | Seuraa järjestelmäpreferenssia |
| `ocean` | Siniset merisävyt |
| `forest` | Vihreät maasävyt |
| `dracula` | Dracula tumma lila |
| `nord` | Pohjoismainen arktinen paletti |
| `high-contrast` | Saavutettavuus fokus |
| `cute` | Anime glassmorphism taustakuvalla |

### Luo Mukautettu Teema

1. **Kopioi teema**: Duplikoi `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **Muokkaa CSS muuttujia**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... muut muuttujat */
}
```

3. **Rekisteröi JS:ssä**: Lisää teemasi nimi `toggleTheme()` arrayhin `_/js/app.js`:ssä.

4. **Aktivoi configissa**:
```php
'theme' => 'mytheme',
```

5. **Whitelist configissa** (jotta teema valitsin toimii): `index.php`:ssä, etsi `$allowed_themes` ja lisää `'mytheme'` arrayhin.

---

## 🧩 Mukautetut HTML Hookit

Injektoi mukautettu HTML, CSS tai JavaScript spesifisiin sivupositionihin ilman core tiedostojen muokkaamista. Konfiguroi `html_hooks` array `core.php`:ssa:

```php
'html_hooks' => array(
    'head_end'      => '',  // Ennen </head>
    'body_start'    => '',  // Jälkeen <body>
    'header_start'  => '',  // Jälkeen <header> avautuu
    'header_end'    => '',  // Ennen </header>
    'main_before'   => '',  // Ennen <main>
    'main_start'    => '',  // Sisällä <main>, ennen items
    'main_end'      => '',  // Sisällä <main>, jälkeen items
    'main_after'    => '',  // Jälkeen </main>
    'footer_before' => '',  // Ennen <footer>
    'footer_start'  => '',  // Jälkeen <footer> avautuu
    'footer_end'    => '',  // Ennen </footer>
    'footer_after'  => '',  // Jälkeen </footer>
    'body_end'      => '',  // Ennen </body>
    'html_end'      => '',  // Ennen </html>
),
```

### Esimerkki: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 Monikielinen Tuki
FileLister auto-tunnistaa selain kielen ja tukee **18+ kieltä**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

Aseta kiinteä kieli `'language' => 'vi'`:llä, tai jätä tyhjäksi auto-tunnistukseen.

---

## 👁️ Tiedoston Esikatselu & Viewer
Integroitu high-performance viewer erilaisille tiedostotyypeille:
- **Kuvat**: jpg, png, gif, webp, svg (realtime thumbnailit grid näkymässä)
- **Videot**: mp4, webm, avi, mov, mkv
- **Ääni**: mp3, ogg, flac, wav, m4a
- **Dokumentit**: Integroitu PDF viewer ja Markdown rendering
- **Koodi**: Syntax highlighting Prism.js:llä 100+ kielelle

---

## 🔗 Jaa & Lataa
- Generoi välittömät **QR koodit** mobiili tiedostosiirtoihin.
- Suorat lataus linkit kaikille tiedostoille.
- Turvallinen tiedoston jakaminen uniikkien URL:ien kautta.
- **Täysi Unicode tuki**: tiedostonimet vietnamiksi, kiinaksi, japaniksi, arabiksi, ja muille ei-ASCII skripteille ovat oikein prosentti-koodattu jakamislinkeissä ja QR koodeissa.

---

## ⌨️ Näppäimistön Pikakuvakkeet
| Näppäin | Toiminto |
|-----|--------|
| `/` tai `Ctrl+F` | Fokusoi hakuboksi |
| `Esc` | Sulje modal / tyhjennä haku |
| `↑` / `↓` | Navigoi itemien läpi |
| `Enter` | Avaa valittu item |
| `g` sitten `h` | Mene kotiin (juuri) |
| `g` sitten `u` | Mene ylös yksi kansio taso |
| `?` | Näytä näppäimistön pikakuvakkeet apu |

---

## 🛡️ Turvallisuustiedot

FileLister sisältää useita parannettuja turvallisuustasoja:

| Taso | Yksityiskohta |
|-------|--------|
| **Path Traversal** | `?dir=` input validoidaan `realpath()`:lla ja sidotaan `$lister_root`:iin. |
| **CSP Nonce** | Satunnainen 128-bit nonce per pyyntö kaikilla inline-skripteillä. Ei `unsafe-inline`. |
| **Rate Limiting** | IP-pohjainen throttling tallennettu tilapäisiin tiedostoihin. Oletus: 60 req/60s. |
| **Luotettavat Proxyt** | `X-Forwarded-For` vain luotettava eksplisiittisesti konfiguroiduista proxy IP:istä. |
| **Arkaluonteiset Tiedostot** | `.env`, `.git`, `.htaccess`, PHP tiedostot automaattisesti piilotettu. |
| **Turvallisuus Headers** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` poistaaksesi kamera/mic/geo. |
| **HSTS** | `Strict-Transport-Security` lähetetty automaattisesti kun HTTPS:llä. |
| **CORS** | Export endpoint sallii vain same-origin pyynnöt. Ei mielivaltaista origin refleksion. |
| **Ei Vanhoja Hashes** | MD5 ja SHA-1 ekskludoitu standard hash tyypeistä. |
| **Symlink Suojaus** | Symlinkit ohitettu folder traversalissa estääkseen silmukoita ja vuotoja. |
| **Dev Modus** | `enable_dev: false` tuotannossa deaktivoi virhe näyttö. |

> [!IMPORTANT]
> Konfiguraation jälkeen, aseta välittömästi `'enable_dev' => false` estääkseen virheviestien paljastamasta palvelin internals.

---

## 📋 Vaatimukset
- **PHP**: 5.2 tai korkeampi (testattu PHP 8.4+:iin asti)
- **Laajennukset**: `json` (vaadittu), `gd` (valinnainen — thumbnailsille), `zip` (valinnainen)

---

## 📜 Muutosloki

### v1.5.36 — Turvallisuus & Bug Fix Release

**Turvallisuus Korjaukset:**
- 🔒 **[Kriittinen] Korjattu CORS reflektio haavoittuvuus** `?export=` endpointissä — ei enää heijasta mielivaltaisia `Origin` headereita
- 🔒 **[Kriittinen] Korjattu XSS tiedoston esikatselussa** — tiedostonimi "ei-tuettu tyyppi" esikatselussa ei ollut escaped ennen DOM injektiota
- 🔒 **[Kriittinen] `enable_dev` nyt oletuksena `false`** — estää tahaton PHP virhe paljastuminen tuotannossa
- 🔒 **[Korkea] Validoitu `dir_theme` cookie** ennen käyttöä estääkseen odottamaton käyttäytyminen

**Bug Fixes:**
- 🐛 **Korjattu QR koodi generointi epäonnistui** tiedostoille Unicode nimillä (vietnam, kiina, japani, etc.)
- 🐛 **Korjattu jakamislinkki rikki** tiedostoille Unicode/ei-ASCII tiedostonimillä
- 🐛 **Korjattu kuva esikatselu ei lataa** tiedostoille Unicode tiedostonimillä
- 🐛 **Korjattu duplikoitu `</div>` tag** footer HTML:ssa (aiheutti layout ongelmia joissakin selaimissa)
- 🐛 **Korjattu `style.css` ladattu kaksi kertaa** (kaistanleveyden tuhlaus, kaksinkertainen-parse)
- 🐛 **Korjattu puuttuva `custom.js` / `custom.css`** `Standalone.php` buildissä
- 🐛 **Korjattu teema palautus** — `dracula`, `nord`, `high-contrast`, `cute` teemat eivät enää nollaudu sivun uudelleenlatauksessa
- 🐛 **Korjattu duplikoitu SVG ikonit** injisoitu yhdessä thumbnails kanssa grid näkymässä
- 🐛 **Korjattu AJAX navigationsconfig parsing** — robustempi regex sijaan haurasta indeks-pohjaisesta ekstraktiosta
- 🐛 **Korjattu `previewText()` näyttää 404 HTML** tiedoston sisältönä kun tiedosto saavuttamaton
- 🐛 **Korjattu kuollut koodi `changeLanguage()`** viittaava ei-olemassaolevaan `langToggle` elementtiin
- 🐛 **Lisätty SHA-512/224 ja SHA-512/256** hash algoritmi karttaan (mainittu docsissa mutta puuttui koodista)
- 🐛 **Korvattu `alert()` kutsut** clipboard kopiossa ei-blokkaavilla toast notifikaatioilla
- 🐛 **Korjattu kuva galleria navigointi** — kuvat piilotettu filter/haulla nyt ekskludoitu prev/next traversalista
- 🐛 **Korjattu `audio`/`video` esikatselut** — virhe käsittelijä lisätty kun media epäonnistuu latauksessa

---

## ☕ Tue Työtäni
Pitäisitkö tästä open-source PHP scriptistä?
- [Osta minulle 🍻](https://buymeacoffee.com/trong)
- Lahjoita ❤️ [PayPal](https://paypal.me/DaoVanTrong) kautta

---

## 📝 Lisenssi
MIT Lisenssi — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
