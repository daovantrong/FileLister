<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: Script moderne de listage de répertoires PHP v1.5.36

FileLister est un **script de listage de répertoires PHP** puissant, léger et moderne qui transforme vos fichiers serveur en un **explorateur de fichiers web** magnifique et adapté aux mobiles. C'est l'alternative parfaite à `h5ai` ou `Apache Index`, offrant une option de déploiement à fichier unique et des aperçus de fichiers intégrés.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 Table des Matières
- [✨ Fonctionnalités](#-fonctionnalités)
- [📦 Installation](#-installation)
- [⚙️ Configuration](#-configuration)
- [🎨 Thèmes](#-thèmes)
- [🧩 Crochets HTML personnalisés](#-crochets-html-personnalisés)
- [🌍 Support multilingue](#-support-multilingue)
- [👁️ Aperçu des fichiers](#-aperçu-des-fichiers--visualiseur)
- [🔗 Partager & Télécharger](#-partager--télécharger)
- [⌨️ Raccourcis clavier](#-raccourcis-clavier)
- [🛡️ Détails de sécurité](#-détails-de-sécurité)
- [📋 Prérequis](#-prérequis)

---

## ✨ Fonctionnalités

### 🚀 **Prêt pour la Production & Rapide**
- **Version Autonome**: Déploiement à fichier unique (`Standalone.php`) avec toutes les ressources intégrées. Exécutez `php build.php` pour générer.
- **Support Docker**: `Dockerfile` et `docker-compose.yml` prêts à l'emploi.
- **Servir Index**: Servir optionnellement `index.html` s'il est présent dans un répertoire.

### 🎨 **Interface Utilisateur Moderne**
- **Propre & Responsive**: Mise en page mobile-first, fonctionne sur n'importe quel appareil.
- **9 Thèmes**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (glassmorphism anime).
- **Vues Grille & Liste**: Basculer entre les vues grille de cartes et liste détaillée.
- **Rendu README**: Rend automatiquement les fichiers `README.md` en bas des listages de répertoires.
- **Localisé**: Sélecteur de langue avec 18+ locales supportées.

### 🛡️ **Sécurité Renforcée**
- **CSP avec Nonces**: Nonce cryptographique par requête sur tous les scripts inline. Pas de `unsafe-inline`.
- **Limitation de Débit**: Throttling de requêtes anti-DDoS intégré (60 req/60s par défaut).
- **Proxies Fiables**: Gestion sécurisée de `X-Forwarded-For` — appliqué seulement si la requête vient d'une IP proxy fiable.
- **Protection Traversée de Chemin**: Toute entrée `?dir=` est résolue via `realpath()` et contrainte à `$lister_root`.
- **Masquage de Fichiers Sensibles**: Ignore automatiquement `.env`, `.git`, `.htaccess`, et fichiers PHP.
- **En-têtes de Sécurité**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (HTTPS uniquement).
- **Pas de MD5/SHA-1**: Ensemble de hash par défaut défini sur `CRC32,XXH128,SHA-256,SHA3-256`. MD5 et SHA-1 exclus par défaut.

### 🔍 **Intégrité des Fichiers (Info & Hash)**
- Vérifie 40+ algorithmes de hash par fichier, incluant SHA-3, WHIRLPOOL, XXH128, CRC32.
- Taille maximale de fichier configurable pour le hachage.
- Résultats affichés en ligne dans le modal Info.

### 📤 **Exporter & Partager**
- Copier/Télécharger liste de fichiers en formats **JSON, CSV, TSV, NDJSON**.
- Partager des fichiers via codes QR et liens directs.

---

## 📦 Installation & Modes de Déploiement

FileLister supporte 4 modes de déploiement. Choisissez celui qui convient à votre configuration:

---

### Mode 1: Autonome (Fichier PHP Unique) — Recommandé pour la Production

Toutes les ressources sont compilées dans un fichier auto-contenu. Pas besoin de dossier `_/`.

```bash
# Étape 1: Construire le fichier autonome
php build.php

# Étape 2: Téléverser Standalone.php sur votre serveur
# Étape 3: Le renommer en index.php (ou n'importe quel nom que vous préférez)
```

> **Config**: Définit automatiquement `'use_embedded' => true`. Aucune autre config nécessaire.

---

### Mode 2: Normal (Fichiers Source)

Configuration multi-fichier classique. Plus rapide pour le développement.

```
your-web-root/
├── index.php        ← Point d'entrée (require_once 'core.php')
├── core.php         ← Logique core & config
└── _/               ← Fichiers CSS, JS, icônes, traductions
```

**Étapes:**
1. Copiez `index.php`, `core.php`, et `_/` dans votre répertoire web.
2. Accédez via navigateur: `http://yoursite.com/`
3. Aucune configuration supplémentaire nécessaire.

---

### Mode 3: Déploiement en Sous-répertoire

Exécutez FileLister dans un sous-dossier qui indexe son propre contenu.

```
your-web-root/
├── files/           ← Répertoire que vous voulez indexer
│   ├── index.php    ← Point d'entrée FileLister
│   └── core.php
└── _/               ← Actifs partagés (auto-détectés par scan parent)
```

La fonction `detect_assets_path()` scanne automatiquement **jusqu'à 5 répertoires parents** pour localiser le dossier d'actifs `_/`. Pas de config `assets_path` manuelle requise dans la plupart des cas.

Si les actifs ne sont pas auto-détectés:
```php
'assets_path' => '../_',   // Ou chemin complet comme '/var/www/html/_'
```

---

### Mode 4: Déploiement Global (Indexer N'importe Quel Répertoire sur le Serveur)

Utilisez **une seule installation FileLister** pour naviguer n'importe quel chemin sur le serveur, découplé de l'emplacement du script.

```
/var/www/html/
├── filelister/      ← FileLister vit ici
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← Répertoire que vous voulez vraiment indexer
```

**Configuration dans `core.php`:**
```php
'base_path' => '/var/data',   // ← Définissez le répertoire que vous voulez lister
```

> `base_path` accepte n'importe quel **chemin absolu du système de fichiers** que le processus PHP peut lire. Le script forcera que toute navigation `?dir=` reste dans cette racine via `realpath()` pour prévenir la traversée de chemin.

**Configuration du Serveur Web** (pour utiliser FileLister comme index de répertoire):

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

**Apache (`.htaccess` dans le répertoire cible):**
```apache
DirectoryIndex index.php FileLister.php index.html

# Router toutes les requêtes de répertoire vers FileLister:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### Mode 5: Docker

```bash
docker-compose up -d
```

Accédez à `http://localhost:8080`. Éditez `docker-compose.yml` pour monter votre répertoire cible.

---

### Comparaison des Modes de Déploiement

| Mode | Fichiers Requis | Meilleur Pour |
|------|---------------|----------|
| **Autonome** | `Standalone.php` seulement | Déploiement rapide, hébergement partagé |
| **Normal** | `index.php` + `core.php` + `_/` | Développement, contrôle complet |
| **Sous-répertoire** | Même que Normal, placé dans sous-dossier | Indexer un sous-dossier spécifique |
| **Global** | Normal + config `base_path` | Instance unique indexant n'importe quel chemin serveur |
| **Docker** | `Dockerfile` + `docker-compose.yml` | Environnements containerisés |

---

## ⚙️ Configuration

Tous les paramètres sont dans le array `$config` dans `core.php` (ou `Standalone.php`).

### Général

| Clé | Par Défaut | Description |
|-----|---------|-------------|
| `title` | `''` | Titre de page personnalisé. Si vide, auto-généré depuis le chemin. |
| `title_prefix` | `'Index of'` | Préfixe pour titre auto-généré. |
| `title_suffix` | `' - FileLister'` | Suffixe pour titre auto-généré. |
| `language` | `''` | Forcer un locale (`en`, `vi`, `zh`, `ja`…). Auto-détecte si vide. |
| `allowed_langs` | (18 langues) | Langues disponibles dans le menu déroulant sélecteur. |
| `theme` | `'ocean'` | Thème par défaut. Options: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | Vue par défaut. Options: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | Chaîne de fuseau horaire PHP. |
| `date_format` | `'Y-m-d H:i:s'` | Chaîne de format de date PHP. |
| `base_path` | `''` | Répertoire racine pour déploiement global/sous-répertoire. |
| `favicon_path` | `''` | Chemin vers favicon personnalisé. |

### Options d'Affichage

| Clé | Par Défaut | Description |
|-----|---------|-------------|
| `show_hidden` | `false` | Montrer les fichiers cachés (commençant par `.`). |
| `show_size` | `true` | Montrer la colonne taille de fichier. |
| `show_date` | `true` | Montrer la colonne date de modification. |
| `show_type` | `true` | Montrer la colonne type de fichier (vue liste). |
| `show_folder_size` | `true` | Calculer tailles de dossier (récursif — peut être lent pour gros dossiers). |
| `show_breadcrumb` | `true` | Montrer breadcrumb de navigation. |
| `show_footer` | `true` | Montrer barre de pied de page. |
| `show_copyright` | `true` | Montrer info copyright dans pied de page. |
| `show_language_selector` | `true` | Montrer contrôle sélecteur de langue. |
| `show_theme_selector` | `true` | Montrer bouton sélecteur de thème. |

### Fonctionnalités

| Clé | Par Défaut | Description |
|-----|---------|-------------|
| `enable_search` | `true` | Activer recherche de fichiers en temps réel. |
| `enable_preview` | `true` | Activer modal d'aperçu de fichiers (images, vidéo, audio, PDF, code). |
| `enable_download` | `true` | Montrer boutons de téléchargement sur fichiers. |
| `enable_share` | `true` | Activer modal de partage de fichiers avec code QR. |
| `enable_qrcode` | `true` | Générer codes QR dans modal de partage. |
| `enable_shortcuts` | `true` | Activer raccourcis clavier. |
| `enable_export` | `true` | Activer exporter/copier liste de fichiers (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | Rendre fichiers `README.md` en bas des listages de répertoires. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | Liste séparée par virgules d'algorithmes de hash. Supportés: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, et 30+ plus. |
| `hash_uppercase` | `true` | Afficher valeurs de hash en majuscules. |
| `max_hash_size` | `1000` | Taille maximale de fichier (MB) autorisée pour le hachage. |

### Sécurité

| Clé | Par Défaut | Description |
|-----|---------|-------------|
| `ignore_files` | (voir ci-dessous) | Fichiers à masquer. Par défaut inclut `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | Extensions à masquer. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | Dossiers à masquer. |
| `allowed_extensions` | `[]` | Liste blanche d'extensions (vide = permettre tous). |
| `protected_paths` | `['/etc', '/var/www/.git']` | Chemins absolus toujours bloqués. |
| `enable_rate_limit` | `true` | Activer limitation de débit basée sur IP. |
| `rate_limit_requests` | `60` | Maximum de requêtes par fenêtre. |
| `rate_limit_period` | `60` | Fenêtre de temps de limitation de débit (secondes). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | IPs exemptées de limitation de débit. |
| `trusted_proxies` | `[]` | IPs autorisées à définir `X-Forwarded-For`. Vide = ne faire confiance à personne. |
| `enable_dev` | `true` | **⚠️ Définir sur `false` en production.** Active affichage d'erreurs PHP et désactive cache. |

> [!CAUTION]
> Définissez toujours `'enable_dev' => false` avant de déployer en production. En mode dev, les erreurs PHP sont affichées ce qui peut exposer chemins de fichiers, détails de configuration, et traces de pile aux visiteurs.

### Avancé

| Clé | Par Défaut | Description |
|-----|---------|-------------|
| `assets_path` | `''` | Chemin vers dossier d'actifs `_/`. Auto-détecté si vide. |
| `use_embedded` | `false` | Forcer mode actifs intégrés (utilisé par `Standalone.php`). |
| `thumbnail_directory` | `''` | Chemin personnalisé pour cache de thumbnails. Auto-défini à `_/thumbs` si vide. |
| `thumbnail_width` | `200` | Largeur maximale de thumbnail (px). |
| `thumbnail_height` | `200` | Hauteur maximale de thumbnail (px). |
| `thumbnail_cache_expiry` | `30` | Jours avant que thumbnails cachés soient purgés. `0` = toujours nettoyer. `-1` = jamais nettoyer. |
| `readme_files` | (liste) | Noms de fichiers à scanner pour rendu README. |
| `custom_css` | `'_/css/custom.css'` | Chemin vers fichier CSS personnalisé (chargé s'il existe). |
| `custom_js` | `'_/js/custom.js'` | Chemin vers fichier JS personnalisé (chargé s'il existe). |
| `serve_index_files` | `false` | Servir `index.html` directement s'il est présent. ⚠️ Risque potentiel XSS si fichiers non-fiables existent. |
| `index_files` | `['index.html', …]` | Noms de fichiers index à rechercher. |

### Configurer Serveur comme Index de Répertoire

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### Permettre Hôtes Externes (CSP)
FileLister utilise une **Politique de Sécurité de Contenu** stricte. Pour charger des ressources de domaines externes, éditez l'en-tête `Content-Security-Policy` dans `core.php`:

```php
// Ajoutez votre domaine à la directive appropriée:
// img-src: pour images externes
// script-src: pour scripts externes (utiliser avec prudence)
// style-src: pour CSS externes
```

---

## 🎨 Personnalisation de Thème

### Thèmes Disponibles
| Thème | Description |
|-------|-------------|
| `light` | Thème blanc propre |
| `dark` | Mode sombre |
| `auto` | Suit la préférence système |
| `ocean` | Tons océaniques bleus |
| `forest` | Tons terrestres verts |
| `dracula` | Violet sombre Dracula |
| `nord` | Palette arctique nordique |
| `high-contrast` | Focus accessibilité |
| `cute` | Glassmorphism anime avec image de fond |

### Créer un Thème Personnalisé

1. **Copier un thème**: Dupliquez `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **Éditer variables CSS**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... autres variables */
}
```

3. **Enregistrer en JS**: Ajoutez le nom de votre thème au array `toggleTheme()` dans `_/js/app.js`.

4. **Activer en config**:
```php
'theme' => 'mytheme',
```

5. **Liste blanche en config** (pour que le sélecteur de thème fonctionne):  Dans `index.php`, cherchez `$allowed_themes` et ajoutez `'mytheme'` au array.

---

## 🧩 Crochets HTML Personnalisés

Injectez HTML, CSS ou JavaScript personnalisé à des positions spécifiques de page sans éditer les fichiers core. Configurez le array `html_hooks` dans `core.php`:

```php
'html_hooks' => array(
    'head_end'      => '',  // Avant </head>
    'body_start'    => '',  // Après <body>
    'header_start'  => '',  // Après <header> ouvre
    'header_end'    => '',  // Avant </header>
    'main_before'   => '',  // Avant <main>
    'main_start'    => '',  // Dans <main>, avant items
    'main_end'      => '',  // Dans <main>, après items
    'main_after'    => '',  // Après </main>
    'footer_before' => '',  // Avant <footer>
    'footer_start'  => '',  // Après <footer> ouvre
    'footer_end'    => '',  // Avant </footer>
    'footer_after'  => '',  // Après </footer>
    'body_end'      => '',  // Avant </body>
    'html_end'      => '',  // Avant </html>
),
```

### Exemple: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 Support Multilingue
FileLister auto-détecte la langue du navigateur et supporte **18+ langues**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

Définissez une langue fixe avec `'language' => 'vi'`, ou laissez vide pour auto-détection.

---

## 👁️ Aperçu des Fichiers & Visualiseur
Visualiseur haute performance intégré pour divers types de fichiers:
- **Images**: jpg, png, gif, webp, svg (avec thumbnails en temps réel en vue grille)
- **Vidéos**: mp4, webm, avi, mov, mkv
- **Audio**: mp3, ogg, flac, wav, m4a
- **Documents**: Visualiseur PDF intégré et rendu Markdown
- **Code**: Mise en évidence syntaxique via Prism.js pour 100+ langages

---

## 🔗 Partager & Télécharger
- Générez des codes **QR instantanés** pour transferts de fichiers mobiles.
- Liens de téléchargement direct pour tous les fichiers.
- Partage sécurisé de fichiers via URLs uniques.
- **Support Unicode complet**: les noms de fichiers en vietnamien, chinois, japonais, arabe, et autres scripts non-ASCII sont correctement encodés en pourcentage dans les liens de partage et codes QR.

---

## ⌨️ Raccourcis Clavier
| Touche | Action |
|-----|--------|
| `/` ou `Ctrl+F` | Focaliser boîte de recherche |
| `Esc` | Fermer modal / effacer recherche |
| `↑` / `↓` | Naviguer à travers items |
| `Enter` | Ouvrir item sélectionné |
| `g` puis `h` | Aller à la maison (racine) |
| `g` puis `u` | Remonter d'un niveau de répertoire |
| `?` | Montrer aide raccourcis clavier |

---

## 🛡️ Détails de Sécurité

FileLister inclut de multiples couches de sécurité renforcées:

| Couche | Détail |
|-------|--------|
| **Traversée de Chemin** | Entrée `?dir=` validée avec `realpath()` et contrainte à `$lister_root`. |
| **Nonce CSP** | Nonce aléatoire 128-bit par requête sur tous les scripts inline. Pas de `unsafe-inline`. |
| **Limitation de Débit** | Throttling basé sur IP stocké dans fichiers temporaires. Par défaut: 60 req/60s. |
| **Proxies Fiables** | `X-Forwarded-For` seulement fiable depuis IPs proxy configurées explicitement. |
| **Fichiers Sensibles** | `.env`, `.git`, `.htaccess`, fichiers PHP masqués automatiquement. |
| **En-têtes de Sécurité** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` pour désactiver caméra/mic/geo. |
| **HSTS** | `Strict-Transport-Security` envoyé automatiquement quand sur HTTPS. |
| **CORS** | Endpoint d'exportation seulement permet requêtes same-origin. Pas de réflexion d'origine arbitraire. |
| **Pas de Hash Anciens** | MD5 et SHA-1 exclus des types de hash par défaut. |
| **Protection Symlink** | Symlinks sautés durant traversal de dossier pour prévenir boucles et fuites. |
| **Mode Dev** | `enable_dev: false` en production désactive affichage d'erreurs. |

> [!IMPORTANT]
> Après configuration, définissez immédiatement `'enable_dev' => false` pour empêcher que messages d'erreur exposent internes du serveur.

---

## 📋 Prérequis
- **PHP**: 5.2 ou supérieur (testé jusqu'à PHP 8.4+)
- **Extensions**: `json` (requis), `gd` (optionnel — pour thumbnails), `zip` (optionnel)

---

## 📜 Journal des Modifications

### v1.5.36 — Version Sécurité & Correction de Bugs

**Corrections de Sécurité:**
- 🔒 **[Critique] Corrigé vulnérabilité de réflexion CORS** dans endpoint `?export=` — ne reflète plus en-têtes `Origin` arbitraires
- 🔒 **[Critique] Corrigé XSS dans aperçu de fichiers** — nom de fichier dans preview "type non supporté" non échappé avant insertion dans DOM
- 🔒 **[Critique] `enable_dev` maintenant par défaut `false`** — empêche divulgation accidentelle d'erreurs PHP en production
- 🔒 **[Haut] Validé cookie `dir_theme`** avant utilisation pour prévenir comportement inattendu

**Corrections de Bugs:**
- 🐛 **Corrigé génération QR échouant** pour fichiers avec noms Unicode (vietnamien, chinois, japonais, etc.)
- 🐛 **Corrigé lien de partage cassé** pour fichiers avec noms de fichier Unicode/non-ASCII
- 🐛 **Corrigé aperçu image ne chargeant pas** pour fichiers avec noms de fichier Unicode
- 🐛 **Corrigé balise `</div>` dupliquée** dans HTML de pied de page (causait problèmes de layout dans certains navigateurs)
- 🐛 **Corrigé `style.css` chargé deux fois** (gaspillage de bande passante, double-parse)
- 🐛 **Corrigé `custom.js` / `custom.css` manquant** dans build `Standalone.php`
- 🐛 **Corrigé restauration de thème** — thèmes `dracula`, `nord`, `high-contrast`, `cute` ne se réinitialisent plus à rechargement de page
- 🐛 **Corrigé icônes SVG dupliquées** injectées avec thumbnails en vue grille
- 🐛 **Corrigé parsing de config de navigation AJAX** — regex plus robuste au lieu d'extraction basée sur index fragile
- 🐛 **Corrigé `previewText()` affichant HTML 404** comme contenu de fichier quand fichier inaccessible
- 🐛 **Corrigé code mort `changeLanguage()`** référençant élément `langToggle` inexistant
- 🐛 **Ajouté SHA-512/224 et SHA-512/256** à la carte d'algorithmes hash (listés dans docs mais manquants dans code)
- 🐛 **Remplacé appels `alert()`** dans copie clipboard par notifications toast non-bloquantes
- 🐛 **Corrigé navigation de galerie d'images** — images cachées par filtre/recherche maintenant exclues de traversal prev/next
- 🐛 **Corrigé previews `audio`/`video`** — ajouté gestionnaire d'erreur quand média échoue à charger

---

## ☕ Soutenez Mon Travail
Vous appréciez ce script PHP open-source?
- [Offrez-moi une 🍻](https://buymeacoffee.com/trong)
- Donnez via ❤️ [PayPal](https://paypal.me/DaoVanTrong)

---

## 📝 Licence
Licence MIT — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
