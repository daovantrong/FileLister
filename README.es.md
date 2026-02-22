<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: Script moderno de listado de directorios PHP v1.5.36

FileLister es un **script de listado de directorios PHP** potente, ligero y moderno que transforma tus archivos de servidor en un **explorador de archivos web** hermoso y amigable para móviles. Es la alternativa perfecta a `h5ai` o `Apache Index`, ofreciendo una opción de despliegue de archivo único y vistas previas de archivos integradas.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 Tabla de Contenidos
- [✨ Características](#-características)
- [📦 Instalación](#-instalación)
- [⚙️ Configuración](#-configuración)
- [🎨 Temas](#-temas)
- [🧩 Ganchos HTML personalizados](#-ganchos-html-personalizados)
- [🌍 Soporte multiidioma](#-soporte-multiidioma)
- [👁️ Vista previa de archivos](#-vista-previa-de-archivos--visor)
- [🔗 Compartir & Descargar](#-compartir--descargar)
- [⌨️ Atajos de teclado](#-atajos-de-teclado)
- [🛡️ Detalles de seguridad](#-detalles-de-seguridad)
- [📋 Requisitos](#-requisitos)

---

## ✨ Características

### 🚀 **Listo para Producción & Rápido**
- **Versión Independiente**: Despliegue de archivo único (`Standalone.php`) con todos los recursos embebidos. Ejecuta `php build.php` para generar.
- **Soporte Docker**: `Dockerfile` y `docker-compose.yml` listos para usar.
- **Servir Índice**: Opcionalmente servir `index.html` si está presente en un directorio.

### 🎨 **Interfaz de Usuario Moderna**
- **Limpia & Responsiva**: Diseño móvil primero, funciona en cualquier dispositivo.
- **9 Temas**: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute` (glassmorphism anime).
- **Vistas de Cuadrícula & Lista**: Alternar entre vistas de cuadrícula de tarjetas y lista detallada.
- **Renderizado README**: Renderiza automáticamente archivos `README.md` en la parte inferior de listados de directorios.
- **Localizado**: Selector de idioma con 18+ locales soportados.

### 🛡️ **Seguridad Reforzada**
- **CSP con Nonces**: Nonce criptográfico por solicitud en todos los scripts inline. Sin `unsafe-inline`.
- **Limitación de Tasa**: Throttling de solicitudes anti-DDoS integrado (60 req/60s por defecto).
- **Proxies Confiables**: Manejo seguro de `X-Forwarded-For` — solo aplicado si la solicitud viene de una IP proxy confiable.
- **Protección de Travesía de Ruta**: Toda entrada `?dir=` se resuelve vía `realpath()` y se restringe a `$lister_root`.
- **Ocultamiento de Archivos Sensibles**: Ignora automáticamente `.env`, `.git`, `.htaccess`, y archivos PHP.
- **Encabezados de Seguridad**: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`, `Strict-Transport-Security` (solo HTTPS).
- **Sin MD5/SHA-1**: Conjunto de hash por defecto establecido en `CRC32,XXH128,SHA-256,SHA3-256`. MD5 y SHA-1 excluidos por defecto.

### 🔍 **Integridad de Archivos (Info & Hash)**
- Verifica 40+ algoritmos de hash por archivo, incluyendo SHA-3, WHIRLPOOL, XXH128, CRC32.
- Tamaño máximo de archivo configurable para hashing.
- Resultados mostrados inline en el modal de Info.

### 📤 **Exportar & Compartir**
- Copiar/Descargar lista de archivos en formatos **JSON, CSV, TSV, NDJSON**.
- Compartir archivos vía códigos QR y enlaces directos.

---

## 📦 Instalación & Modos de Despliegue

FileLister soporta 4 modos de despliegue. Elige el que se ajuste a tu configuración:

---

### Modo 1: Independiente (Archivo PHP Único) — Recomendado para Producción

Todos los recursos se compilan en un archivo autocontenido. No se necesita carpeta `_/`.

```bash
# Paso 1: Construir el archivo independiente
php build.php

# Paso 2: Subir Standalone.php a tu servidor
# Paso 3: Renombrarlo a index.php (o cualquier nombre que prefieras)
```

> **Config**: Establece automáticamente `'use_embedded' => true`. No se necesita otra config.

---

### Modo 2: Normal (Archivos Fuente)

Configuración clásica multi-archivo. Más rápida para desarrollo.

```
your-web-root/
├── index.php        ← Punto de entrada (require_once 'core.php')
├── core.php         ← Lógica core & config
└── _/               ← Archivos CSS, JS, iconos, traducciones
```

**Pasos:**
1. Copia `index.php`, `core.php`, y `_/` a tu directorio web.
2. Accede vía navegador: `http://yoursite.com/`
3. No se necesita configuración adicional.

---

### Modo 3: Despliegue en Subdirectorio

Ejecuta FileLister dentro de una subcarpeta que indexa su propio contenido.

```
your-web-root/
├── files/           ← Directorio que quieres indexar
│   ├── index.php    ← Punto de entrada FileLister
│   └── core.php
└── _/               ← Activos compartidos (auto-detectado por escaneo padre)
```

La función `detect_assets_path()` escanea automáticamente **hasta 5 directorios padre** para localizar la carpeta de activos `_/`. No se requiere config manual de `assets_path` en la mayoría de casos.

Si los activos no se auto-detectan:
```php
'assets_path' => '../_',   // O ruta completa como '/var/www/html/_'
```

---

### Modo 4: Despliegue Global (Indexar Cualquier Directorio en el Servidor)

Usa **una sola instalación FileLister** para navegar cualquier ruta en el servidor, desacoplada de la ubicación del script.

```
/var/www/html/
├── filelister/      ← FileLister vive aquí
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← Directorio que realmente quieres indexar
```

**Configuración en `core.php`:**
```php
'base_path' => '/var/data',   // ← Establece el directorio que quieres listar
```

> `base_path` acepta cualquier **ruta absoluta del sistema de archivos** que el proceso PHP pueda leer. El script forzará que toda navegación `?dir=` se mantenga dentro de esta raíz vía `realpath()` para prevenir travesía de ruta.

**Configuración de Servidor Web** (para usar FileLister como índice de directorio):

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

**Apache (`.htaccess` en el directorio objetivo):**
```apache
DirectoryIndex index.php FileLister.php index.html

# Enrutar todas las solicitudes de directorio a FileLister:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### Modo 5: Docker

```bash
docker-compose up -d
```

Accede en `http://localhost:8080`. Edita `docker-compose.yml` para montar tu directorio objetivo.

---

### Comparación de Modos de Despliegue

| Modo | Archivos Requeridos | Mejor Para |
|------|---------------|----------|
| **Independiente** | Solo `Standalone.php` | Despliegue rápido, hosting compartido |
| **Normal** | `index.php` + `core.php` + `_/` | Desarrollo, control completo |
| **Subdirectorio** | Igual que Normal, colocado en subcarpeta | Indexar una subcarpeta específica |
| **Global** | Normal + config `base_path` | Instancia única indexando cualquier ruta de servidor |
| **Docker** | `Dockerfile` + `docker-compose.yml` | Entornos containerizados |

---

## ⚙️ Configuración

Todas las configuraciones están en el array `$config` en `core.php` (o `Standalone.php`).

### General

| Clave | Por Defecto | Descripción |
|-----|---------|-------------|
| `title` | `''` | Título de página personalizado. Si vacío, auto-generado desde ruta. |
| `title_prefix` | `'Index of'` | Prefijo para título auto-generado. |
| `title_suffix` | `' - FileLister'` | Sufijo para título auto-generado. |
| `language` | `''` | Forzar un locale (`en`, `vi`, `zh`, `ja`…). Auto-detecta si vacío. |
| `allowed_langs` | (18 idiomas) | Idiomas disponibles en el menú desplegable selector. |
| `theme` | `'ocean'` | Tema por defecto. Opciones: `light`, `dark`, `auto`, `ocean`, `forest`, `dracula`, `nord`, `high-contrast`, `cute`. |
| `view_mode` | `'list'` | Vista por defecto. Opciones: `grid`, `list`. |
| `timezone` | `'Asia/Ho_Chi_Minh'` | Cadena de zona horaria PHP. |
| `date_format` | `'Y-m-d H:i:s'` | Cadena de formato de fecha PHP. |
| `base_path` | `''` | Directorio raíz para despliegue global/subdirectorio. |
| `favicon_path` | `''` | Ruta a favicon personalizado. |

### Opciones de Visualización

| Clave | Por Defecto | Descripción |
|-----|---------|-------------|
| `show_hidden` | `false` | Mostrar archivos ocultos (empezando con `.`). |
| `show_size` | `true` | Mostrar columna de tamaño de archivo. |
| `show_date` | `true` | Mostrar columna de fecha de modificación. |
| `show_type` | `true` | Mostrar columna de tipo de archivo (vista lista). |
| `show_folder_size` | `true` | Calcular tamaños de carpeta (recursivo — puede ser lento para carpetas grandes). |
| `show_breadcrumb` | `true` | Mostrar breadcrumb de navegación. |
| `show_footer` | `true` | Mostrar barra de pie de página. |
| `show_copyright` | `true` | Mostrar info de copyright en pie de página. |
| `show_language_selector` | `true` | Mostrar control de conmutador de idioma. |
| `show_theme_selector` | `true` | Mostrar botón de conmutador de tema. |

### Características

| Clave | Por Defecto | Descripción |
|-----|---------|-------------|
| `enable_search` | `true` | Habilitar búsqueda de archivos en tiempo real. |
| `enable_preview` | `true` | Habilitar modal de vista previa de archivos (imágenes, video, audio, PDF, código). |
| `enable_download` | `true` | Mostrar botones de descarga en archivos. |
| `enable_share` | `true` | Habilitar modal de compartir archivos con código QR. |
| `enable_qrcode` | `true` | Generar códigos QR en modal de compartir. |
| `enable_shortcuts` | `true` | Habilitar atajos de teclado. |
| `enable_export` | `true` | Habilitar exportar/copiar lista de archivos (JSON, CSV, TSV, NDJSON). |
| `enable_readme` | `true` | Renderizar archivos `README.md` en la parte inferior de listados de directorios. |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | Lista separada por comas de algoritmos de hash. Soportados: `MD5`, `SHA-1`, `SHA-256`, `SHA-512`, `SHA-512/224`, `SHA-512/256`, `SHA3-256`, `WHIRLPOOL`, `CRC32`, `XXH128`, y 30+ más. |
| `hash_uppercase` | `true` | Mostrar valores de hash en mayúsculas. |
| `max_hash_size` | `1000` | Tamaño máximo de archivo (MB) permitido para hashing. |

### Seguridad

| Clave | Por Defecto | Descripción |
|-----|---------|-------------|
| `ignore_files` | (ver abajo) | Archivos a ocultar. Por defecto incluye `index.php`, `.htaccess`, `.htpasswd`, `.git`, `.env`. |
| `ignore_extensions` | `['php']` | Extensiones a ocultar. |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | Carpetas a ocultar. |
| `allowed_extensions` | `[]` | Lista blanca de extensiones (vacío = permitir todos). |
| `protected_paths` | `['/etc', '/var/www/.git']` | Rutas absolutas siempre bloqueadas. |
| `enable_rate_limit` | `true` | Habilitar limitación de tasa basada en IP. |
| `rate_limit_requests` | `60` | Máximo de solicitudes por ventana. |
| `rate_limit_period` | `60` | Ventana de tiempo de limitación de tasa (segundos). |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | IPs exentas de limitación de tasa. |
| `trusted_proxies` | `[]` | IPs permitidas para configurar `X-Forwarded-For`. Vacío = no confiar en nadie. |
| `enable_dev` | `true` | **⚠️ Establecer en `false` en producción.** Habilita display de errores PHP y deshabilita cache. |

> [!CAUTION]
> Siempre establece `'enable_dev' => false` antes de desplegar a producción. En modo dev, los errores PHP se muestran lo que puede exponer rutas de archivos, detalles de configuración, y trazas de pila a visitantes.

### Avanzado

| Clave | Por Defecto | Descripción |
|-----|---------|-------------|
| `assets_path` | `''` | Ruta a carpeta de activos `_/`. Auto-detectado si vacío. |
| `use_embedded` | `false` | Forzar modo de activos embebidos (usado por `Standalone.php`). |
| `thumbnail_directory` | `''` | Ruta personalizada para cache de thumbnails. Auto-establecido a `_/thumbs` si vacío. |
| `thumbnail_width` | `200` | Ancho máximo de thumbnail (px). |
| `thumbnail_height` | `200` | Alto máximo de thumbnail (px). |
| `thumbnail_cache_expiry` | `30` | Días antes de que thumbnails cacheados sean purgados. `0` = siempre limpiar. `-1` = nunca limpiar. |
| `readme_files` | (lista) | Nombres de archivo a escanear para renderizado README. |
| `custom_css` | `'_/css/custom.css'` | Ruta a archivo CSS personalizado (cargado si existe). |
| `custom_js` | `'_/js/custom.js'` | Ruta a archivo JS personalizado (cargado si existe). |
| `serve_index_files` | `false` | Servir `index.html` directamente si presente. ⚠️ Riesgo potencial de XSS si existen archivos no confiables. |
| `index_files` | `['index.html', …]` | Nombres de archivo índice a buscar. |

### Configurar Servidor como Índice de Directorio

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### Permitir Hosts Externos (CSP)
FileLister usa una **Política de Seguridad de Contenido** estricta. Para cargar recursos de dominios externos, edita el header `Content-Security-Policy` en `core.php`:

```php
// Agrega tu dominio a la directiva apropiada:
// img-src: para imágenes externas
// script-src: para scripts externos (usar con precaución)
// style-src: para CSS externos
```

---

## 🎨 Personalización de Tema

### Temas Disponibles
| Tema | Descripción |
|-------|-------------|
| `light` | Tema blanco limpio |
| `dark` | Modo oscuro |
| `auto` | Sigue preferencia del sistema |
| `ocean` | Tonos oceánicos azules |
| `forest` | Tonos terrestres verdes |
| `dracula` | Púrpura oscuro Dracula |
| `nord` | Paleta ártica nórdica |
| `high-contrast` | Enfoque en accesibilidad |
| `cute` | Glassmorphism anime con imagen de fondo |

### Crear un Tema Personalizado

1. **Copiar un tema**: Duplica `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`.

2. **Editar variables CSS**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... otras variables */
}
```

3. **Registrar en JS**: Agrega el nombre de tu tema al array `toggleTheme()` en `_/js/app.js`.

4. **Activar en config**:
```php
'theme' => 'mytheme',
```

5. **Lista blanca en config** (para que funcione el selector de tema):  En `index.php`, busca `$allowed_themes` y agrega `'mytheme'` al array.

---

## 🧩 Ganchos HTML Personalizados

Inyecta HTML, CSS o JavaScript personalizado en posiciones específicas de página sin editar archivos core. Configura el array `html_hooks` en `core.php`:

```php
'html_hooks' => array(
    'head_end'      => '',  // Antes de </head>
    'body_start'    => '',  // Después de <body>
    'header_start'  => '',  // Después de <header> abre
    'header_end'    => '',  // Antes de </header>
    'main_before'   => '',  // Antes de <main>
    'main_start'    => '',  // Dentro de <main>, antes de items
    'main_end'      => '',  // Dentro de <main>, después de items
    'main_after'    => '',  // Después de </main>
    'footer_before' => '',  // Antes de <footer>
    'footer_start'  => '',  // Después de <footer> abre
    'footer_end'    => '',  // Antes de </footer>
    'footer_after'  => '',  // Después de </footer>
    'body_end'      => '',  // Antes de </body>
    'html_end'      => '',  // Antes de </html>
),
```

### Ejemplo: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 Soporte Multiidioma
FileLister auto-detecta el idioma del navegador y soporta **18+ idiomas**:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

Establece un idioma fijo con `'language' => 'vi'`, o déjalo vacío para auto-detección.

---

## 👁️ Vista Previa de Archivos & Visor
Visor de alto rendimiento integrado para varios tipos de archivo:
- **Imágenes**: jpg, png, gif, webp, svg (con thumbnails en tiempo real en vista cuadrícula)
- **Videos**: mp4, webm, avi, mov, mkv
- **Audio**: mp3, ogg, flac, wav, m4a
- **Documentos**: Visor PDF integrado y renderizado Markdown
- **Código**: Resaltado de sintaxis vía Prism.js para 100+ lenguajes

---

## 🔗 Compartir & Descargar
- Genera códigos **QR instantáneos** para transferencias de archivos móviles.
- Enlaces de descarga directa para todos los archivos.
- Compartición segura de archivos vía URLs únicas.
- **Soporte Unicode completo**: los nombres de archivo en vietnamita, chino, japonés, árabe, y otros scripts no-ASCII se codifican correctamente en porcentaje en enlaces de compartir y códigos QR.

---

## ⌨️ Atajos de Teclado
| Tecla | Acción |
|-----|--------|
| `/` o `Ctrl+F` | Enfocar caja de búsqueda |
| `Esc` | Cerrar modal / limpiar búsqueda |
| `↑` / `↓` | Navegar a través de items |
| `Enter` | Abrir item seleccionado |
| `g` luego `h` | Ir a casa (raíz) |
| `g` luego `u` | Ir arriba un nivel de directorio |
| `?` | Mostrar ayuda de atajos de teclado |

---

## 🛡️ Detalles de Seguridad

FileLister incluye múltiples capas de seguridad reforzadas:

| Capa | Detalle |
|-------|--------|
| **Travesía de Ruta** | Entrada `?dir=` validada con `realpath()` y restringida a `$lister_root`. |
| **Nonce CSP** | Nonce aleatorio de 128-bit por solicitud en todos los scripts inline. Sin `unsafe-inline`. |
| **Limitación de Tasa** | Throttling basado en IP almacenado en archivos temporales. Por defecto: 60 req/60s. |
| **Proxies Confiables** | `X-Forwarded-For` solo confiable desde IPs proxy configuradas explícitamente. |
| **Archivos Sensibles** | `.env`, `.git`, `.htaccess`, archivos PHP ocultados automáticamente. |
| **Encabezados de Seguridad** | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Permissions-Policy` para deshabilitar cámara/mic/geo. |
| **HSTS** | `Strict-Transport-Security` enviado automáticamente cuando en HTTPS. |
| **CORS** | Endpoint de exportación solo permite solicitudes same-origin. Sin reflexión de origen arbitrario. |
| **Sin Hashes Antiguos** | MD5 y SHA-1 excluidos de tipos de hash por defecto. |
| **Protección de Symlink** | Symlinks saltados durante traversal de carpeta para prevenir bucles y fugas. |
| **Modo Dev** | `enable_dev: false` en producción deshabilita display de errores. |

> [!IMPORTANT]
> Después de configuración, establece inmediatamente `'enable_dev' => false` para prevenir que mensajes de error expongan internos del servidor.

---

## 📋 Requisitos
- **PHP**: 5.2 o superior (probado hasta PHP 8.4+)
- **Extensiones**: `json` (requerido), `gd` (opcional — para thumbnails), `zip` (opcional)

---

## 📜 Registro de Cambios

### v1.5.36 — Versión de Seguridad & Corrección de Errores

**Correcciones de Seguridad:**
- 🔒 **[Crítico] Corregido vulnerabilidad de reflexión CORS** en endpoint `?export=` — ya no refleja cabeceras `Origin` arbitrarias
- 🔒 **[Crítico] Corregido XSS en vista previa de archivos** — nombre de archivo en preview "tipo no soportado" no escapado antes de insertar en DOM
- 🔒 **[Crítico] `enable_dev` ahora por defecto `false`** — previene divulgación accidental de errores PHP en producción
- 🔒 **[Alto] Validado cookie `dir_theme`** antes de uso para prevenir comportamiento inesperado

**Correcciones de Errores:**
- 🐛 **Corregido generación de QR fallando** para archivos con nombres Unicode (vietnamita, chino, japonés, etc.)
- 🐛 **Corregido enlace de compartir roto** para archivos con nombres de archivo Unicode/no-ASCII
- 🐛 **Corregido vista previa de imagen no cargando** para archivos con nombres de archivo Unicode
- 🐛 **Corregido etiqueta `</div>` duplicada** en HTML de pie de página (causaba problemas de layout en algunos navegadores)
- 🐛 **Corregido `style.css` cargado dos veces** (desperdicio de ancho de banda, doble-parse)
- 🐛 **Corregido `custom.js` / `custom.css` faltante** en build `Standalone.php`
- 🐛 **Corregido restauración de tema** — temas `dracula`, `nord`, `high-contrast`, `cute` ya no se resetean en recarga de página
- 🐛 **Corregido iconos SVG duplicados** inyectados junto con thumbnails en vista cuadrícula
- 🐛 **Corregido parsing de config de navegación AJAX** — regex más robusto en lugar de extracción basada en índice frágil
- 🐛 **Corregido `previewText()` mostrando HTML 404** como contenido de archivo cuando archivo inaccesible
- 🐛 **Corregido código muerto `changeLanguage()`** referenciando elemento `langToggle` inexistente
- 🐛 **Agregado SHA-512/224 y SHA-512/256** al mapa de algoritmos hash (listados en docs pero faltantes en código)
- 🐛 **Reemplazado llamadas `alert()`** en copia de clipboard con notificaciones toast no-bloqueantes
- 🐛 **Corregido navegación de galería de imágenes** — imágenes ocultas por filtro/búsqueda ahora excluidas de traversal prev/next
- 🐛 **Corregido previews `audio`/`video`** — agregado manejador de error cuando media falla en cargar

---

## ☕ Apoya Mi Trabajo
¿Disfrutando este script PHP de código abierto?
- [Cómprame una 🍻](https://buymeacoffee.com/trong)
- Dona vía ❤️ [PayPal](https://paypal.me/DaoVanTrong)

---

## 📝 Licencia
Licencia MIT — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
