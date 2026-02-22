<?php
/**
 * Begin index.php
 * FileLister: The Modern PHP Directory Script
 * Modern file browser
 * @version 1.5
 * @link https://github.com/daovantrong/filelister
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 */
define('APP_VERSION', '1.5.36');

// ============================================================================
// CONFIGURATION
// ============================================================================
$config = array(
    'title' => '',                            // If not empty, uses this exactly as the page title
    'title_prefix' => 'Index of',             // Prefix for auto-generated title (used when 'title' is empty)
    'title_suffix' => ' - FileLister',        // Suffix for auto-generated title (used when 'title' is empty)
    'meta_description' => '',               // Custom meta description (empty = default)
    'meta_keywords' => '',                  // Custom meta keywords (empty = default)
    'author' => '',                         // Author name (empty = default)
    'og_title' => '',                       // Custom OpenGraph title (empty = use page title)
    'og_description' => '',                 // Custom OpenGraph description (empty = use meta description)
    'language' => '',                       // Auto-detect from browser if empty (en, vi, zh, es, fr, de, ja, kr,...)
    'allowed_langs' => array(
        'en' => 'EN',
        'vi' => 'VI',
        'zh' => 'ZH',
        'ja' => 'JA',
        'ko' => 'KO',
        'kr' => 'KR',
        'es' => 'ES',
        'fr' => 'FR',
        'de' => 'DE',
        'it' => 'IT',
        'nl' => 'NL',
        'sv' => 'SV',
        'no' => 'NO',
        'da' => 'DA',
        'fi' => 'FI',
        'he' => 'HE',
        'ar' => 'AR',
        'ru' => 'RU'
    ),
    'show_language_selector' => true,
    'theme' => 'ocean',                     // cute, light, dark, auto, ocean, forest
    'show_theme_selector' => true,
    'view_mode' => 'list',                    // Default view mode: grid or list

    // DISPLAY OPTIONS
    'show_hidden' => false,                 // Show hidden files (starting with .)
    'show_size' => true,
    'show_date' => true,
    'show_type' => true,
    'show_folder_size' => true,             // May be slow for large folders
    'show_breadcrumb' => true,
    'show_footer' => true,
    'show_copyright' => true,

    // FEATURES
    'enable_search' => true,
    'enable_preview' => true,
    'enable_download' => true,
    'enable_share' => true,
    'enable_qrcode' => true,
    'enable_shortcuts' => true,
    'enable_export' => true,               // Export/Copy file list (JSON, CSV, TSV, NDJSON)
    'enable_readme' => true,                // Enable/disable rendering README.md files
    'max_hash_size' => 1000,               // Max file size for hashing in MB (default: 1000MB)

    // Hash Types Configuration
    // Available Hash Algorithms:
    //   Cryptographic (Secure):
    //     - SHA-2: SHA-224, SHA-256, SHA-384, SHA-512, SHA-512/224, SHA-512/256
    //     - SHA-3: SHA3-224, SHA3-256, SHA3-384, SHA3-512
    //     - Others: WHIRLPOOL, RIPEMD-160, RIPEMD-256, RIPEMD-320, TIGER-192
    //   Legacy Cryptographic (Not Recommended for Security):
    //     - MD2, MD4, MD5, SHA-1
    //   Checksums (Fast, Non-cryptographic):
    //     - CRC32, CRC32B, CRC32C, ADLER32
    //     - XXH32, XXH64, XXH3, XXH128 (Modern, Fast)
    //     - FNV132, FNV1A32, FNV164, FNV1A64
    //     - MURMUR3A, MURMUR3C, MURMUR3F
    // Maximum Security:  'SHA3-512,SHA-512,WHIRLPOOL'
    // Speed Optimized  :  'XXH128,CRC32,MD5'
    // Comprehensive: 'MD5,SHA-256,SHA-512,SHA3-256,CRC32,XXH64,WHIRLPOOL'

    // FIX VUL-07: Removed MD5 and SHA-1 (cryptographically broken).
    // Use strong algorithms: SHA-256, SHA3-256, XXH128 for integrity checks.
    // MD5/SHA-1 left commented for legacy compatibility only.
    'enable_hashtype' => 'CRC32,XXH128,SHA-256,SHA3-256',
    'hash_uppercase' => true,                // Display hash values in uppercase

    // SECURITY
    // To use as directory index, set in Virtual Host: index index.php FileLister.php;
    'ignore_files' => array(basename(__FILE__), 'index.php', '.htaccess', '.htpasswd', '.git', '.env', 'Thumbs.db', '.DS_Store'),
    'ignore_extensions' => array('php'),
    'ignore_folders' => array('_', '.git', '.svn', 'node_modules', 'vendor'),
    'allowed_extensions' => array(),             // Empty = show all
    'protected_paths' => array('/etc', '/var/www/.git'),

    // ADVANCED
    'date_format' => 'Y-m-d H:i:s',
    'timezone' => 'Asia/Ho_Chi_Minh',
    'thumbnail_directory' => '',           // MUST be web-accessible path! Empty = auto {assets_path}/thumbs
    // Example: '_/thumbs' or 'thumbs' (NOT '/var/cache' - browser can't access!)
    'thumbnail_width' => 200,
    'thumbnail_height' => 200,
    'thumbnail_cache_expiry' => 30,         // Cache expiry in days (0 = clean every time, -1 = never)
    'readme_files' => array('README.md', 'README.en.md', 'README.vi.md', 'readme.md', 'README.txt', 'readme.txt', 'README', 'readme'),
    'custom_css' => '_/css/custom.css',
    'custom_js' => '_/js/custom.js',


    // ASSETS CONFIGURATION
    // Folder name for CSS, JS, lang files
    // Leave empty for auto-detect (default: '_')
    // Set folder name: 'static' or full path: '/var/www/assets'
    'assets_path' => '',
    'use_embedded' => false,

    // RATE LIMITING & ANTI-DDoS
    'enable_rate_limit' => true,             // Enable basic rate limiting
    'rate_limit_requests' => 60,             // Number of requests allowed
    'rate_limit_period' => 60,               // Time window in seconds
    'rate_limit_exclude_ips' => array('127.0.0.1', '::1'), // IPs to exclude from rate limiting
    // FIX VUL-02: TRUSTED PROXIES
    // Only trust X-Forwarded-For if request comes from these IPs.
    // If empty, we typically trust nothing unless logic allows.
    // 'trusted_proxies' => array('10.0.0.1', '172.16.0.1'),
    'trusted_proxies' => array(),            // Empty by default (Secure)


    // DEV MODE & CUSTOMIZATION
    // FIX VUL-03: Set false in production. Enables full PHP error display when true.
    // Use environment variable: getenv('APP_ENV') === 'development'
    'enable_dev' => false,                // Enable developer mode (disable cache, random version assets)
    'favicon_path' => '',                 // Path to custom favicon (relative to root or absolute URL). If null, checks for favicon.ico or uses default SVG.

    // HTML HOOKS (Inject Custom HTML insertion location at specific locations)
    'html_hooks' => array(
        'head_end' => '<!-- Custom HTML insertion location 1 -->',           // Before </head>
        'body_start' => '<!-- Custom HTML insertion location 2 -->',         // After <body> Before <header>
        'header_start' => '<!-- Custom HTML insertion location 3 -->',      // After <header>
        'header_end' => '<!-- Custom HTML insertion location 4 -->',       // Before </header>
        'main_before' => '<!-- Custom HTML insertion location 5 -->',        // Before <main>
        'main_start' => '<!-- Custom HTML insertion location 6 -->',         // Inside <main>, before items
        'main_end' => '<!-- Custom HTML insertion location 7 -->',           // Inside <main>, after items
        'main_after' => '<!-- Custom HTML insertion location 8 -->',         // After </main>
        'footer_before' => '<!-- Custom HTML insertion location 9 -->',      // Before <footer>
        'footer_start' => '<!-- Custom HTML insertion location 10 -->',      // After <footer>
        'footer_end' => '<!-- Custom HTML insertion location 11 -->',      // Before </footer>
        'footer_after' => '<!-- Custom HTML insertion location 12 -->',       // After </footer>
        'body_end' => '<!-- Custom HTML insertion location 13 -->',           // Before </body>
        'html_end' => '<!-- Custom HTML insertion location 14 -->',           // Before </html>
    ),

    // THEME SETTINGS (Advanced customization per theme)
    'theme_settings' => array(
        // Example:
        // 'light'         => array('icon_set' => 'default'),
        // 'dark'          => array('icon_set' => 'default'),
        // 'ocean'         => array('icon_set' => 'ocean_icons'),
        // 'forest'        => array('icon_set' => 'forest_icons'),
        // 'dracula'       => array('icon_set' => 'dracula_icons'),
        // 'nord'          => array('icon_set' => 'nord_icons'),
        // 'high-contrast' => array('icon_set' => 'high_contrast_icons'),
        // 'cute'          => array('icon_set' => 'cute_icons'),
        // 'auto'          => array('icon_set' => 'default'),
    ),

    // ROOT PATH (for global deployment)
    // If empty, uses the directory where the script is located.
    'base_path' => '',

    // INDEX FILES
    // WARNING: Enabling this allows serving HTML files directly, which can be an XSS risk 
    // if malicious files are uploaded to the indexed directory.
    'serve_index_files' => false,            // Serve index files if present (e.g. index.html)
    'index_files' => array('index.html', 'index.htm', 'default.htm'),
);

// ============================================================================
// PHP VERSION DETECTION (for optimization purposes only)
// ============================================================================

/**
 * Detect PHP version to use optimal native functions for each version.
 * This does NOT interfere with server error_reporting settings.
 * Code is written to be compatible and optimized for each PHP version.
 */
define('PHP_VERSION_ID_COMPAT', PHP_VERSION_ID);
define('IS_PHP_52', PHP_VERSION_ID >= 50200 && PHP_VERSION_ID < 50300);
define('IS_PHP_53', PHP_VERSION_ID >= 50300 && PHP_VERSION_ID < 50400);
define('IS_PHP_54', PHP_VERSION_ID >= 50400 && PHP_VERSION_ID < 50500);
define('IS_PHP_55', PHP_VERSION_ID >= 50500 && PHP_VERSION_ID < 50600);
define('IS_PHP_56', PHP_VERSION_ID >= 50600 && PHP_VERSION_ID < 70000);
define('IS_PHP_70_PLUS', PHP_VERSION_ID >= 70000);
define('IS_PHP_74_PLUS', PHP_VERSION_ID >= 70400);
define('IS_PHP_80_PLUS', PHP_VERSION_ID >= 80000);

// Router for PHP built-in server or standalone mode
if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $targetFile = __DIR__ . $url['path'];
    if ($url['path'] !== '/' && is_file($targetFile) && strpos(str_replace('\\', '/', realpath($targetFile)), str_replace('\\', '/', __DIR__)) === 0) {
        // Correct MIME types for common assets
        $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $mimes = array(
            'css' => 'text/css',
            'js' => 'application/javascript',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            'bmp' => 'image/bmp'
        );
        if (isset($mimes[$ext])) {
            header('Content-Type: ' . $mimes[$ext]);
        }
        readfile($targetFile);
        exit;
    }
}

// Helper functions using version-specific optimizations
if (!function_exists('compat_is_countable')) {
    /**
     * Countable check - PHP 7.3+ has is_countable(), older versions need manual check
     */
    function compat_is_countable($var)
    {
        if (IS_PHP_74_PLUS && function_exists('is_countable')) {
            return is_countable($var);
        }
        return is_array($var) || $var instanceof Countable;
    }
}

if (!function_exists('compat_array_key_exists')) {
    /**
     * Array key exists - optimized for each PHP version
     * PHP 7.4+ optimized array_key_exists, older versions may use isset for speed
     */
    function compat_array_key_exists($key, $array)
    {
        // All versions support array_key_exists, using native function
        return array_key_exists($key, $array);
    }
}


// Set timezone
date_default_timezone_set($config['timezone']);

// Set Asset Version
$asset_version = (!empty($config['enable_dev']) && $config['enable_dev'] === true) ? rand() : APP_VERSION;

// Sanitize configuration values to prevent division by zero or invalid calculations
$config['thumbnail_width'] = max(1, (int) $config['thumbnail_width']);
$config['thumbnail_height'] = max(1, (int) $config['thumbnail_height']);
$config['max_hash_size'] = max(1, (int) $config['max_hash_size']);

// Dev Mode Configuration
if (!empty($config['enable_dev']) && $config['enable_dev'] === true) {
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
} else {
    // Production Mode: Disable error display to prevent information disclosure
    ini_set('display_errors', 0);
}

// ── CSP NONCE (FIX VUL-04) ────────────────────────────────────────────────
// Generate a per-request cryptographic nonce to replace 'unsafe-inline'.
// All inline <script> tags MUST carry nonce="<_?= $csp_nonce ?_>".
if (function_exists('random_bytes')) {
    $csp_nonce = base64_encode(random_bytes(16));
} elseif (function_exists('openssl_random_pseudo_bytes')) {
    $csp_nonce = base64_encode(openssl_random_pseudo_bytes(16));
} else {
    // PHP 5.2 fallback (not cryptographically secure – upgrade PHP)
    $csp_nonce = base64_encode(uniqid(mt_rand(), true));
}

// SECURITY HEADERS
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
// FIX VUL-04: Replaced 'unsafe-inline' with per-request nonce.
// All inline <script> blocks use nonce attribute; no inline event handlers allowed.
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-" . $csp_nonce . "' https://fonts.googleapis.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https://img.shields.io; connect-src 'self' https://api.ipify.org https://api64.ipify.org; object-src 'none'; base-uri 'self'; form-action 'self';");
// Permissions-Policy: disable unnecessary browser features
header("Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(), usb=()");
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
}

// ============================================================================
// THUMBNAIL CLASS 
// ============================================================================

/**
 * Thumbnail generator with caching support
 */
class Thumbnail
{
    private $cacheDir;  // Absolute filesystem path for read/write
    private $cacheUrl;  // Web-accessible relative URL for browser src
    private $maxWidth;
    private $maxHeight;
    private $cacheExpiry;

    /**
     * @param string $cacheDir  Absolute filesystem path to store thumbnails
     * @param string $cacheUrl  Web-accessible URL path (relative) used as img src
     */
    public function __construct($cacheDir = '', $cacheUrl = '', $maxWidth = 200, $maxHeight = 200, $cacheExpiry = 30)
    {
        $this->cacheDir = $cacheDir;
        $this->cacheUrl = $cacheUrl;
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
        $this->cacheExpiry = (int) $cacheExpiry;

        // Don't try to create cache dir if disabled (empty string)
        if (!empty($cacheDir)) {
            $this->ensureCacheDir();
        }
    }

    private function ensureCacheDir()
    {
        if (!is_dir($this->cacheDir)) {
            @mkdir($this->cacheDir, 0755, true);
        }
    }

    /**
     * Check if thumbnail generation is enabled and available
     */
    public function isEnabled()
    {
        // Disabled if cache dir is empty
        if (empty($this->cacheDir)) {
            return false;
        }

        return is_dir($this->cacheDir) && is_writable($this->cacheDir);
    }

    /**
     * Clean cache directory of expired thumbnails
     */
    public function cleanCache()
    {
        if (!$this->isEnabled() || $this->cacheExpiry < 0) {
            return;
        }

        $pattern = $this->cacheDir . DIRECTORY_SEPARATOR . 'thumb-*';
        $files = glob($pattern);
        if (!$files)
            return;

        $now = time();
        $expirySeconds = $this->cacheExpiry * 86400;

        foreach ($files as $file) {
            if (is_file($file)) {
                $mtime = @filemtime($file);
                if ($mtime && ($now - $mtime > $expirySeconds)) {
                    @unlink($file);
                }
            }
        }
    }

    public function getThumbnail($sourcePath)
    {
        // Return null if thumbnails are disabled
        if (!$this->isEnabled()) {
            return null;
        }

        if (!file_exists($sourcePath)) {
            return null;
        }

        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        if (!in_array($extension, array('jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'))) {
            return null; // Expand support for webp and bmp
        }

        $hash = sha1($sourcePath . filemtime($sourcePath) . $this->maxWidth . $this->maxHeight);
        $thumbName = 'thumb-' . $hash . '.' . $extension;
        $thumbPath = $this->cacheDir . DIRECTORY_SEPARATOR . $thumbName;

        if (file_exists($thumbPath)) {
            // Return web-accessible URL (not filesystem path)
            return rtrim($this->cacheUrl, '/') . '/' . $thumbName;
        }

        if ($this->generate($sourcePath, $thumbPath, $extension)) {
            // Return web-accessible URL (not filesystem path)
            return rtrim($this->cacheUrl, '/') . '/' . $thumbName;
        }

        return null;
    }

    private function generate($sourcePath, $destPath, $extension)
    {
        // Check for GD library
        if (!extension_loaded('gd') || !function_exists('imagecreatefromjpeg')) {
            return false;
        }
        // Use @ suppression for getimagesize() on all versions
        // This is appropriate since we handle errors by checking return value
        // getimagesize() can emit notices for corrupt/invalid files
        $imageInfo = @getimagesize($sourcePath);
        if (!$imageInfo || $imageInfo === false) {
            return false;
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];

        if ($width <= 0 || $height <= 0) {
            return false;
        }

        // Create source image using version-appropriate methods
        $sourceImage = null;
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                if (IS_PHP_70_PLUS) {
                    $sourceImage = imagecreatefromjpeg($sourcePath);
                } else {
                    $sourceImage = @imagecreatefromjpeg($sourcePath);
                }
                break;
            case 'png':
                if (IS_PHP_70_PLUS) {
                    $sourceImage = imagecreatefrompng($sourcePath);
                } else {
                    $sourceImage = @imagecreatefrompng($sourcePath);
                }
                break;
            case 'gif':
                if (IS_PHP_70_PLUS) {
                    $sourceImage = imagecreatefromgif($sourcePath);
                } else {
                    $sourceImage = @imagecreatefromgif($sourcePath);
                }
                break;
            case 'webp':
                if (function_exists('imagecreatefromwebp')) {
                    $sourceImage = @imagecreatefromwebp($sourcePath);
                }
                break;
            case 'bmp':
                if (function_exists('imagecreatefrombmp')) {
                    $sourceImage = @imagecreatefrombmp($sourcePath);
                }
                break;
        }

        if (!$sourceImage) {
            return false;
        }

        // Calculate new dimensions
        if ($height <= 0)
            return false; // Extra safety check
        $ratio = $width / $height;

        $newWidth = $this->maxWidth;
        $newHeight = $this->maxHeight;

        if ($newHeight <= 0)
            return false; // Prevent division by zero

        if ($newWidth / $newHeight > $ratio) {
            if ($ratio <= 0)
                return false; // Safety check
            $newWidth = $newHeight * $ratio;
        } else {
            if ($ratio <= 0)
                return false; // Safety check
            $newHeight = $newWidth / $ratio;
        }

        // Ensure target dimensions are positive
        $newWidth = max(1, (int) $newWidth);
        $newHeight = max(1, (int) $newHeight);

        // Use version-specific image creation
        // PHP 5.5+ has better imagecreatetruecolor performance
        if (IS_PHP_70_PLUS) {
            // PHP 7.0+ optimized true color creation
            // $newWidth and $newHeight are already cast to int and ensured positive above
        }
        $destImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG and GIF
        if ($extension == 'png' || $extension == 'gif') {
            imagecolortransparent($destImage, imagecolorallocatealpha($destImage, 0, 0, 0, 127));
            imagealphablending($destImage, false);
            imagesavealpha($destImage, true);
        }

        // Resample image - all PHP versions support this
        imagecopyresampled($destImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save image with version-specific quality settings
        $success = false;
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                if (IS_PHP_70_PLUS) {
                    // PHP 7.0+ supports better JPEG quality control
                    $success = imagejpeg($destImage, $destPath, 85);
                } else {
                    $success = @imagejpeg($destImage, $destPath, 80);
                }
                break;
            case 'png':
                if (IS_PHP_70_PLUS) {
                    // PHP 7.0+ uses compression level 0-9 (9 = max compression)
                    $success = imagepng($destImage, $destPath, 6);
                } else {
                    $success = @imagepng($destImage, $destPath);
                }
                break;
            case 'gif':
                if (IS_PHP_70_PLUS) {
                    $success = imagegif($destImage, $destPath);
                } else {
                    $success = @imagegif($destImage, $destPath);
                }
                break;
            case 'webp':
                if (function_exists('imagewebp')) {
                    $success = @imagewebp($destImage, $destPath, 80);
                }
                break;
            case 'bmp':
                if (function_exists('imagebmp')) {
                    $success = @imagebmp($destImage, $destPath);
                }
                break;
        }

        imagedestroy($sourceImage);
        imagedestroy($destImage);

        return $success;
    }
}

// ============================================================================
// HELPER FUNCTIONS
// ============================================================================

/**
 * Auto-detect assets path
 */
function detect_assets_path()
{
    global $config, $lister_root;

    // Force embedded mode if configured
    if (!empty($config['use_embedded']) && $config['use_embedded'] === true) {
        return 'embedded';
    }

    // Use configured path if set
    if (!empty($config['assets_path'])) {
        // If it's a full path (starts with / or contains /), use as-is if it exists
        if (strpos($config['assets_path'], '/') !== false) {
            if (is_dir($config['assets_path'])) {
                return $config['assets_path'];
            }
        }
        // Otherwise treat as folder name for auto-detection
        $assets_folder = $config['assets_path'];
    } else {
        // Default folder name
        $assets_folder = '_';
    }

    // Check lister root directory
    if (is_dir($lister_root . '/' . $assets_folder)) {
        // Use relative path if possible, but for absolute safety in subfolders, 
        // we might want a relative-to-root path if we can determine it.
        // For now, let's stick to the folder name, but check if we're in a sub-web-path.
        return $assets_folder;
    }

    // Check parent directories (up to 5 levels)
    $levels = array('..', '../..', '../../..', '../../../..', '../../../../..');
    foreach ($levels as $level) {
        $path = $lister_root . '/' . $level . '/' . $assets_folder;
        if (is_dir($path)) {
            return $level . '/' . $assets_folder;
        }
    }

    // Fallback: Check if it's in the same directory as the script
    if (is_dir(dirname(__FILE__) . '/' . $assets_folder)) {
        return $assets_folder;
    }

    // Use embedded assets
    return 'embedded';
}

/**
 * Format file size
 */
function format_size($bytes)
{
    if ($bytes <= 0)
        return '0 B';
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $i = floor(log($bytes) / log(1024));
    return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
}

/**
 * Get file icon class based on extension
 */
function get_icon($filename, $is_dir = false)
{
    if ($is_dir) {
        return 'folder';
    }

    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $icon_map = array(
        // Images
        'jpg' => 'image',
        'jpeg' => 'image',
        'png' => 'image',
        'gif' => 'image',
        'bmp' => 'image',
        'svg' => 'image',
        'webp' => 'image',
        'ico' => 'image',
        'tiff' => 'image',
        'tif' => 'image',
        'psd' => 'image',
        'ai' => 'image',

        // Videos
        'mp4' => 'video',
        'avi' => 'video',
        'mov' => 'video',
        'wmv' => 'video',
        'flv' => 'video',
        'webm' => 'video',
        'mkv' => 'video',
        'm4v' => 'video',
        'mpg' => 'video',
        'mpeg' => 'video',
        '3gp' => 'video',
        'ogv' => 'video',

        // Audio
        'mp3' => 'audio',
        'wav' => 'audio',
        'ogg' => 'audio',
        'flac' => 'audio',
        'm4a' => 'audio',
        'wma' => 'audio',
        'aac' => 'audio',
        'opus' => 'audio',
        'mid' => 'audio',
        'midi' => 'audio',
        'amr' => 'audio',

        // Documents
        'pdf' => 'pdf',
        'doc' => 'word',
        'docx' => 'word',
        'odt' => 'word',
        'xls' => 'excel',
        'xlsx' => 'excel',
        'csv' => 'excel',
        'ods' => 'excel',
        'ppt' => 'powerpoint',
        'pptx' => 'powerpoint',
        'odp' => 'powerpoint',
        'txt' => 'text',
        'rtf' => 'text',
        'md' => 'markdown',
        'log' => 'text',

        // Archives
        'zip' => 'archive',
        'rar' => 'archive',
        '7z' => 'archive',
        'tar' => 'archive',
        'gz' => 'archive',
        'bz2' => 'archive',
        'xz' => 'archive',
        'iso' => 'archive',
        'dmg' => 'archive',

        // Code - Web
        'html' => 'code',
        'htm' => 'code',
        'xhtml' => 'code',
        'css' => 'code',
        'scss' => 'code',
        'sass' => 'code',
        'less' => 'code',
        'js' => 'javascript',
        'jsx' => 'javascript',
        'ts' => 'typescript',
        'tsx' => 'typescript',
        'vue' => 'code',
        'svelte' => 'code',
        'php' => 'php',
        'asp' => 'code',
        'aspx' => 'code',
        'jsp' => 'code',

        // Code - Programming Languages
        'py' => 'python',
        'pyc' => 'python',
        'pyo' => 'python',
        'rb' => 'ruby',
        'rake' => 'ruby',
        'java' => 'java',
        'class' => 'java',
        'jar' => 'java',
        'c' => 'cpp',
        'cpp' => 'cpp',
        'cc' => 'cpp',
        'cxx' => 'cpp',
        'h' => 'cpp',
        'hpp' => 'cpp',
        'hxx' => 'cpp',
        'cs' => 'csharp',
        'au3' => 'code',
        'vb' => 'code',
        'swift' => 'swift',
        'go' => 'go',
        'rs' => 'rust',
        'kt' => 'kotlin',
        'kts' => 'kotlin',
        'scala' => 'code',
        'clj' => 'code',
        'pl' => 'perl',
        'pm' => 'perl',
        'sh' => 'shell',
        'bash' => 'shell',
        'zsh' => 'shell',
        'sql' => 'database',
        'db' => 'database',
        'sqlite' => 'database',

        // Code - Config & Data
        'json' => 'config',
        'xml' => 'config',
        'yml' => 'config',
        'yaml' => 'config',
        'toml' => 'config',
        'ini' => 'config',
        'cfg' => 'config',
        'conf' => 'config',
        'env' => 'config',
        'properties' => 'config',

        // Fonts
        'ttf' => 'font',
        'otf' => 'font',
        'woff' => 'font',
        'woff2' => 'font',
        'eot' => 'font',
        'fon' => 'font',

        // Executables
        'exe' => 'executable',
        'app' => 'executable',
        'deb' => 'executable',
        'rpm' => 'executable',
        'apk' => 'executable',

        // Books
        'epub' => 'book',
        'mobi' => 'book',
        'azw' => 'book',
        'azw3' => 'book',
    );

    return isset($icon_map[$ext]) ? $icon_map[$ext] : 'file';
}

/**
 * Get file type name
 */
function get_file_type($filename, $is_dir = false)
{
    if ($is_dir)
        return 'Folder';

    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $type_map = array(
        'jpg' => 'JPEG Image',
        'jpeg' => 'JPEG Image',
        'png' => 'PNG Image',
        'gif' => 'GIF Image',
        'bmp' => 'BMP Image',
        'svg' => 'SVG Image',
        'webp' => 'WebP Image',
        'ico' => 'Icon',

        'mp4' => 'MP4 Video',
        'avi' => 'AVI Video',
        'mov' => 'MOV Video',
        'wmv' => 'WMV Video',
        'flv' => 'FLV Video',
        'webm' => 'WebM Video',
        'mkv' => 'MKV Video',

        'mp3' => 'MP3 Audio',
        'wav' => 'WAV Audio',
        'ogg' => 'OGG Audio',
        'flac' => 'FLAC Audio',
        'm4a' => 'M4A Audio',

        'pdf' => 'PDF Document',
        'doc' => 'Word Document',
        'docx' => 'Word Document',
        'xls' => 'Excel Spreadsheet',
        'xlsx' => 'Excel Spreadsheet',
        'csv' => 'CSV File',
        'ppt' => 'PowerPoint',
        'pptx' => 'PowerPoint',
        'txt' => 'Text File',
        'rtf' => 'Rich Text',
        'md' => 'Markdown',

        'zip' => 'ZIP Archive',
        'rar' => 'RAR Archive',
        '7z' => '7Z Archive',
        'tar' => 'TAR Archive',
        'gz' => 'GZIP Archive',

        'php' => 'PHP Script',
        'js' => 'JavaScript',
        'jsx' => 'JSX File',
        'ts' => 'TypeScript',
        'tsx' => 'TSX File',
        'css' => 'Stylesheet',
        'html' => 'HTML Document',
        'xml' => 'XML Document',
        'json' => 'JSON Data',
        'py' => 'Python Script',
        'rb' => 'Ruby Script',
        'java' => 'Java Source',
        'c' => 'C Source',
        'cpp' => 'C++ Source',
        'cs' => 'C# Source',
        'go' => 'Go Source',
        'rs' => 'Rust Source',
        'sh' => 'Shell Script',
        'sql' => 'SQL Script',
    );

    return isset($type_map[$ext]) ? $type_map[$ext] : strtoupper($ext) . ' File';
}

/**
 * Calculate folder size recursively
 * Hardened against symlink loops and excessive recursion
 */
function get_folder_size($path, $depth = 0)
{
    $max_depth = 10;
    if ($depth > $max_depth) {
        return 0;
    }

    $total = 0;
    $items = @scandir($path);
    if ($items) {
        foreach ($items as $item) {
            if ($item == '.' || $item == '..')
                continue;

            $full = $path . '/' . $item;

            // Security: Don't follow symlinks to avoid infinite loops
            // Security: Respect is_allowed settings
            if (is_link($full) || !is_allowed($path, $item)) {
                continue;
            }

            if (is_dir($full)) {
                $total += get_folder_size($full, $depth + 1);
            } else {
                $total += @filesize($full);
            }
        }
    }
    return $total;
}

/**
 * Count files in folder (Non-recursive)
 */
function count_files($path)
{
    $count = 0;
    $items = @scandir($path);
    if ($items) {
        foreach ($items as $item) {
            if ($item != '.' && $item != '..') {
                $full = $path . '/' . $item;
                // Security: Don't count symlinks or hidden/ignored items
                if (!is_link($full) && is_allowed($path, $item)) {
                    $count++;
                }
            }
        }
    }
    return $count;
}

/**
 * Check if path is allowed
 */
function is_allowed($path, $filename = '')
{
    global $config;

    $full_path = str_replace('\\', '/', $path . '/' . $filename);
    $basename = basename($full_path);

    // Check protected paths (exact match or parent)
    foreach ($config['protected_paths'] as $protected) {
        $protected_norm = str_replace('\\', '/', $protected);
        if (strpos($full_path, $protected_norm) === 0) {
            return false;
        }
    }

    // Check if any part of the path is in ignore_folders
    $path_parts = explode('/', trim(str_replace(__DIR__, '', $full_path), '/'));
    foreach ($path_parts as $part) {
        if (in_array($part, $config['ignore_folders'])) {
            return false;
        }
    }

    // Check ignored files
    if (in_array($basename, $config['ignore_files'])) {
        return false;
    }

    // Check hidden files - Unix/Linux style (dot files)
    if (!$config['show_hidden'] && strpos($basename, '.') === 0) {
        return false;
    }

    // Note: Windows hidden file detection moved to get_file_list() for performance

    // Check ignored extensions
    $ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
    if (!empty($config['ignore_extensions']) && in_array($ext, $config['ignore_extensions'])) {
        return false;
    }

    // Check allowed extensions
    if (!empty($config['allowed_extensions']) && !in_array($ext, $config['allowed_extensions'])) {
        if (!is_dir($full_path)) {
            return false;
        }
    }

    return true;
}

/**
 * Basic Rate Limiter
 */
function check_rate_limit()
{
    global $config;

    if (empty($config['enable_rate_limit'])) {
        return;
    }

    $ip = get_server_ip();
    if (in_array($ip, $config['rate_limit_exclude_ips'])) {
        return;
    }

    $limit = $config['rate_limit_requests'];
    $period = $config['rate_limit_period'];

    $temp_dir = sys_get_temp_dir();
    $hash = md5('lister_ratelimit_' . $ip);
    $file = $temp_dir . DIRECTORY_SEPARATOR . $hash;

    $now = time();
    $requests = array();

    if (file_exists($file)) {
        $content = @file_get_contents($file);
        if ($content) {
            $requests = json_decode($content, true);
        }
    }

    if (!is_array($requests)) {
        $requests = array();
    }

    // Filter old requests
    $requests = array_filter($requests, function ($t) use ($now, $period) {
        return $t > ($now - $period);
    });

    if (count($requests) >= $limit) {
        header('HTTP/1.1 429 Too Many Requests');
        header('Retry-After: ' . $period);
        echo "429 Too Many Requests. Please wait " . $period . " seconds.";
        exit;
    }

    $requests[] = $now;
    @file_put_contents($file, json_encode($requests));
}


/**
 * Get real client IP address (server-side fallback)
 * Prioritizes Cloudflare headers, supports proxy/reverse proxy
 * Filters out private IPs (127.0.0.1, ::1, 192.168.x.x, etc.)
 */
function get_server_ip()
{
    global $config;

    $user_ip = $_SERVER['REMOTE_ADDR'];
    $trusted_proxies = isset($config['trusted_proxies']) ? $config['trusted_proxies'] : array();

    // FIX VUL-02: Only check headers if REMOTE_ADDR is a trusted proxy
    if (in_array($user_ip, $trusted_proxies)) {
        $keys = array(
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_REAL_IP',
            'HTTP_X_FORWARDED_FOR',
        );

        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                $ips = explode(',', $_SERVER[$key]);
                foreach ($ips as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        return $ip;
                    }
                }
            }
        }
    }

    return $user_ip;
}

/**
 * Get file list from directory
 */
function get_file_list($dir)
{
    global $config, $lister_root;

    $files = array();
    $items = @scandir($dir);

    if (!$items)
        return $files;

    foreach ($items as $item) {
        if ($item == '.' || $item == '..')
            continue;

        $full_path = $dir . '/' . $item;

        // Check if allowed
        if (!is_allowed($dir, $item))
            continue;

        // Check if folder is ignored
        if (is_dir($full_path) && in_array($item, $config['ignore_folders'])) {
            continue;
        }

        $is_dir = is_dir($full_path);
        $size = 0;

        if ($is_dir) {
            if ($config['show_folder_size']) {
                $size = get_folder_size($full_path);
            }
        } else {
            $size = @filesize($full_path);
        }

        // Calculate relative path for URL
        $relative_path = '';
        // Normalize directory path first (convert backslashes to forward slashes)
        $dir_normalized = str_replace('\\', '/', $dir);

        // Use stripos for case-insensitive check (Windows)
        if (stripos($dir_normalized, $lister_root) === 0) {
            $relative_path = substr($dir_normalized, strlen($lister_root));
            $relative_path = trim($relative_path, '/');
        }

        // Build complete path for this item
        $item_relative_path = $relative_path ? $relative_path . '/' . $item : $item;


        // Encode path segments for URLs
        $url_parts = array();
        foreach (explode('/', $item_relative_path) as $part) {
            if (!empty($part)) {
                $url_parts[] = rawurlencode($part);
            }
        }

        $url_path_encoded = implode('/', $url_parts); // For direct links (href) - fully encoded
        $url_path_raw = $item_relative_path; // For data attributes (JavaScript will encode) - NOT encoded
        $dir_path = $item_relative_path; // For ?dir= parameter (gets encoded by urlencode)

        $mtime = @filemtime($full_path);

        $files[] = array(
            'name' => $item,
            'path' => $full_path,
            'is_dir' => $is_dir,
            'size' => $size,
            'size_formatted' => $is_dir ? ($config['show_folder_size'] ? count_files($full_path) . ' items' : '') : format_size($size),
            'modified' => $mtime,
            'date_formatted' => date($config['date_format'], $mtime),
            'type' => get_file_type($item, $is_dir),
            'icon' => get_icon($item, $is_dir),
            'ext' => (function ($item, $is_dir) {
                if ($is_dir)
                    return 'folder';
                $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                // Fix for dotfiles: if it starts with . and has only one dot, it has no extension
                if (strpos($item, '.') === 0 && substr_count($item, '.') === 1)
                    return '';
                return $ext;
            })($item, $is_dir),
            'url' => $is_dir ? '?dir=' . urlencode($dir_path) : $url_path_encoded, // Use encoded for hrefs
            'url_raw' => $url_path_raw, // Raw path for JavaScript data attributes
            'thumb' => null,
        );

        // Generate thumbnail for images if not a directory
        if (!$is_dir && in_array($files[count($files) - 1]['ext'], array('jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'))) {
            // Lazy initialization of thumbnailer
            static $thumbnailer = null;
            if ($thumbnailer === null) {
                // Determine the web-accessible URL path and the filesystem path for the thumb cache.
                // They must be kept separate: cacheDir for file I/O, cacheUrl as browser-loadable src.
                if (!empty($config['thumbnail_directory'])) {
                    // User supplied a custom directory (should be web-accessible relative path)
                    $thumbUrl = $config['thumbnail_directory'];
                    // Convert to absolute filesystem path for file operations
                    $thumbDir = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $thumbUrl);
                } else {
                    // Default: use assets folder subfolder 'thumbs'
                    // cacheUrl = relative web path (e.g. '_/thumbs')
                    $assets_url = !empty($config['assets_path']) ? rtrim($config['assets_path'], '/') : '_';
                    $thumbUrl = $assets_url . '/thumbs';
                    // cacheDir = absolute filesystem path
                    $thumbDir = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $thumbUrl);
                }
                $expiry = isset($config['thumbnail_cache_expiry']) ? $config['thumbnail_cache_expiry'] : 30;
                $thumbnailer = new Thumbnail($thumbDir, $thumbUrl, $config['thumbnail_width'], $config['thumbnail_height'], $expiry);

                // Probabilistic cleanup (1% chance) to maintain performance
                if (mt_rand(1, 100) === 1) {
                    $thumbnailer->cleanCache();
                }
            }

            $thumbUrl = $thumbnailer->getThumbnail($full_path);
            if ($thumbUrl) {
                // Thumbnail generated successfully — use it
                $files[count($files) - 1]['thumb'] = $thumbUrl;
            } else {
                // Fallback: thumbnail generation failed or GD not available —
                // embed the original image URL directly so the image is still shown.
                $files[count($files) - 1]['thumb'] = $url_path_encoded;
            }
        }
    }

    return $files;
}

/**
 * Try to resolve a file path on Windows handling encoding issues
 * Returns the valid path if found, or false if not found
 */
function resolve_windows_path($path)
{
    if (file_exists($path)) {
        return $path;
    }

    // Only try fallbacks on Windows
    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
        return false;
    }

    $dir = dirname($path);
    $basename = basename($path);

    if (!is_dir($dir)) {
        return false;
    }

    $items = @scandir($dir);
    if (!$items) {
        return false;
    }

    // List of encodings to check based on supported languages
    // en, vi, zh, ja, kr, es, fr, de, it, nl, sv, no, da, fi, he, ar, ru
    $encodings = array(
        'UTF-8',
        'Windows-1252', // Western (EN, ES, FR, DE, IT, NL, SV, NO, DA, FI)
        'CP1258',       // Vietnamese
        'Windows-1251', // Cyrillic (RU)
        'Windows-1256', // Arabic
        'Windows-1255', // Hebrew
        'SJIS',         // Japanese (CP932)
        'GBK',          // Chinese Simplified (CP936)
        'Big5',         // Chinese Traditional
        'EUC-KR',       // Korean (CP949)
        'CP932',        // Japanese fallback
        'CP936',        // Chinese fallback
        'CP949',        // Korean fallback
        'CP850',        // DOS Western
        'ISO-8859-1',   // Western Legacy
    );

    foreach ($items as $item) {
        if ($item == '.' || $item == '..')
            continue;

        // 1. Direct match check
        if ($item === $basename) {
            return $dir . '/' . $item;
        }

        // 2. Try converting filesystem item to UTF-8 to compare with requested basename
        foreach ($encodings as $enc) {
            $converted_item = false;
            if (function_exists('mb_convert_encoding')) {
                // Suppress errors for invalid conversions
                $converted_item = @mb_convert_encoding($item, 'UTF-8', $enc);
            } elseif (function_exists('iconv')) {
                $converted_item = @iconv($enc, 'UTF-8', $item);
            }

            if ($converted_item && $converted_item === $basename) {
                return $dir . '/' . $item;
            }
        }

        // 3. Reverse check: Try converting requested basename to specific encodings 
        // and compare with raw item (useful if FS returns raw bytes)
        foreach ($encodings as $enc) {
            $converted_base = false;
            if (function_exists('mb_convert_encoding')) {
                $converted_base = @mb_convert_encoding($basename, $enc, 'UTF-8');
            } elseif (function_exists('iconv')) {
                $converted_base = @iconv('UTF-8', $enc, $basename);
            }

            if ($converted_base && $converted_base === $item) {
                return $dir . '/' . $item;
            }
        }
    }

    return false;
}


/**
 * Sorter class for PHP 5.2 compatibility (no closures)
 */
class DirListerSorter
{
    public static $sort_by = 'name';
    public static $order = 'asc';

    public static function compare($a, $b)
    {
        $result = 0;
        switch (self::$sort_by) {
            case 'size':
                $result = $a['size'] - $b['size'];
                break;
            case 'date':
                $result = $a['modified'] - $b['modified'];
                break;
            case 'type':
                $result = strcmp($a['type'], $b['type']);
                break;
            case 'name':
            default:
                $result = strcasecmp($a['name'], $b['name']);
                break;
        }
        return self::$order == 'desc' ? -$result : $result;
    }
}

/**
 * Sort files (Windows style: folders first, sorted separately)
 */
function sort_files($files, $sort_by = 'name', $order = 'asc')
{
    // Separate folders and files
    $folders = array();
    $regular_files = array();

    foreach ($files as $file) {
        if ($file['is_dir']) {
            $folders[] = $file;
        } else {
            $regular_files[] = $file;
        }
    }

    // Configure Sorter
    DirListerSorter::$sort_by = $sort_by;
    DirListerSorter::$order = $order;

    // Sort folders and files separately
    usort($folders, array('DirListerSorter', 'compare'));
    usort($regular_files, array('DirListerSorter', 'compare'));

    // Merge: folders first, then files
    return array_merge($folders, $regular_files);
}

/**
 * Get breadcrumb path
 */
function get_breadcrumb($current_path)
{
    global $lister_root;

    $breadcrumb = array();
    $root_dir = $lister_root;
    $current_path = str_replace('\\', '/', $current_path);

    // Get relative path
    if (stripos($current_path, $root_dir) === 0) {
        $relative_path = substr($current_path, strlen($root_dir));
        $relative_path = trim($relative_path, '/');
    } else {
        return array();
    }

    if (empty($relative_path)) {
        return array();
    }

    $parts = explode('/', $relative_path);
    $path = '';

    foreach ($parts as $part) {
        if (empty($part))
            continue;

        $path .= ($path === '' ? '' : '/') . $part;

        $breadcrumb[] = array(
            'name' => $part,
            'path' => $path, // Relative path for display/logic if needed
            'url' => '?dir=' . urlencode($path),
        );
    }

    return $breadcrumb;
}

// ============================================================================
// MAIN LOGIC
// ============================================================================

// Detect Lister Root (support global deployment)
$lister_root = !empty($config['base_path']) ? realpath($config['base_path']) : __DIR__;
if (!$lister_root)
    $lister_root = __DIR__;
$lister_root = str_replace('\\', '/', $lister_root);

// Detect assets path
$assets_path = detect_assets_path();

// Security: Check Rate Limit
check_rate_limit();

// Get current directory
$current_dir = $lister_root;
if (isset($_GET['dir'])) {
    $requested_dir = realpath($lister_root . '/' . $_GET['dir']);
    if ($requested_dir && strpos(str_replace('\\', '/', $requested_dir), $lister_root) === 0) {
        $current_dir = $requested_dir;
    }
}


// Check for default index files
if (!empty($config['serve_index_files']) && $config['serve_index_files']) {
    foreach ($config['index_files'] as $index_file) {
        $index_path = $current_dir . '/' . $index_file;
        if (file_exists($index_path) && is_allowed($current_dir, $index_file)) {
            $ext = strtolower(pathinfo($index_path, PATHINFO_EXTENSION));
            $mime = 'text/html';
            if ($ext == 'txt')
                $mime = 'text/plain';

            header('Content-Type: ' . $mime);
            readfile($index_path);
            exit;
        }
    }
}

// Get file list
$files = get_file_list($current_dir);

// Sort files
$files = sort_files($files, 'name', 'asc');

// Get breadcrumb
$breadcrumb = get_breadcrumb($current_dir);

// Calculate totals
$total_items = count($files);
$total_folders = 0;
$total_size = 0;

// Only calculate size if show_folder_size is enabled
if ($config['show_folder_size']) {
    foreach ($files as $f) {
        if ($f['is_dir']) {
            $total_folders++;
        }
        $total_size += $f['size'];
    }
} else {
    // Just count folders and files, no size calculation
    foreach ($files as $f) {
        if ($f['is_dir']) {
            $total_folders++;
        }
    }
}
$total_files = $total_items - $total_folders;

// Auto-detect language
$allowed_langs_config = isset($config['allowed_langs']) ? $config['allowed_langs'] : array(
    'en' => 'EN',
    'vi' => 'VI',
    'zh' => 'ZH',
    'ja' => 'JA',
    'ko' => 'KO',
    'kr' => 'KR',
    'es' => 'ES',
    'fr' => 'FR',
    'de' => 'DE',
    'it' => 'IT',
    'nl' => 'NL',
    'sv' => 'SV',
    'no' => 'NO',
    'da' => 'DA',
    'fi' => 'FI',
    'he' => 'HE',
    'ar' => 'AR',
    'ru' => 'RU'
);
$allowed_langs = array_keys($allowed_langs_config);

// Clear previously saved language if selector is hidden
if (isset($config['show_language_selector']) && !$config['show_language_selector']) {
    if (isset($_COOKIE['dir_lang'])) {
        setcookie('dir_lang', '', time() - 3600, '/');
        unset($_COOKIE['dir_lang']);
    }
}

$default_lang = in_array('en', $allowed_langs, true) ? 'en' : (isset($allowed_langs[0]) ? $allowed_langs[0] : 'en');
$lang = $default_lang;

if (isset($config['show_language_selector']) && $config['show_language_selector']) {
    // Priority: GET > COOKIE > CONFIG > BROWSER
    if (isset($_GET['lang']) && in_array($_GET['lang'], $allowed_langs, true)) {
        $lang = $_GET['lang'];
    } elseif (isset($_COOKIE['dir_lang']) && in_array($_COOKIE['dir_lang'], $allowed_langs, true)) {
        $lang = $_COOKIE['dir_lang'];
    } elseif (!empty($config['language']) && in_array($config['language'], $allowed_langs, true)) {
        $lang = $config['language'];
    } else {
        $detected = substr(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : $default_lang, 0, 2);
        $lang = in_array($detected, $allowed_langs, true) ? $detected : $default_lang;
    }
} else {
    // Ignore client choice, enforce CONFIG > BROWSER
    if (!empty($config['language']) && in_array($config['language'], $allowed_langs, true)) {
        $lang = $config['language'];
    } else {
        $detected = substr(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : $default_lang, 0, 2);
        $lang = in_array($detected, $allowed_langs, true) ? $detected : $default_lang;
    }
}

// Load translations
$translations = array();
function load_translations($lang)
{
    global $translations, $config;
    // Extract folder name from assets_path (default to '_')
    $assets_folder = !empty($config['assets_path']) ? basename($config['assets_path']) : '_';
    $file = __DIR__ . '/' . $assets_folder . '/lang/' . $lang . '.json';
    if (file_exists($file)) {
        $json = file_get_contents($file);
        $translations = json_decode($json, true);
    } else {
        // Fallback to English if file not found
        if ($lang !== 'en') {
            $assets_folder = !empty($config['assets_path']) ? basename($config['assets_path']) : '_';
            $file = __DIR__ . '/' . $assets_folder . '/lang/en.json';
            if (file_exists($file)) {
                $json = file_get_contents($file);
                $translations = json_decode($json, true);
            }
        }
    }
}
load_translations($lang);

function t($key)
{
    global $translations;
    $keys = explode('.', $key);
    $value = $translations;
    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $key;
        }
    }
    return is_string($value) ? htmlspecialchars($value) : $key;
}

/**
 * Get HTML Hook Content
 */
function get_html_hook($hook_name)
{
    global $config;
    if (isset($config['html_hooks'][$hook_name]) && !empty($config['html_hooks'][$hook_name])) {
        return $config['html_hooks'][$hook_name] . "\n";
    }
    return '';
}

// Embedded favicon content (injected by build.php for Standalone version)
$embedded_favicon_svg = null;

/**
 * Get Favicon HTML
 */
function get_favicon_html()
{
    global $config, $lister_root, $embedded_favicon_svg;

    // 1. Check config
    if (!empty($config['favicon_path'])) {
        return '<link rel="shortcut icon" href="' . htmlspecialchars($config['favicon_path']) . '">';
    }

    // 2. Check for favicon.ico in root
    if (file_exists($lister_root . '/favicon.ico')) {
        return '<link rel="shortcut icon" href="favicon.ico">';
    }

    // 3. Fallback: Use Theme's Folder Icon as Favicon
    // Determine current theme's icon set
    $icon_set = null;
    if (isset($config['theme_settings'][$GLOBALS['theme_mode']]['icon_set'])) {
        $icon_set = $config['theme_settings'][$GLOBALS['theme_mode']]['icon_set'];
    }

    // Try to find physical theme icon file
    $svg_content = '';
    if ($icon_set && file_exists($lister_root . '/_/icons/' . $icon_set . '/folder.svg')) {
        $svg_content = file_get_contents($lister_root . '/_/icons/' . $icon_set . '/folder.svg');
    }
    // If not found, try default folder icon from file
    elseif (file_exists($lister_root . '/_/icons/folder.svg')) {
        $svg_content = file_get_contents($lister_root . '/_/icons/folder.svg');
    }
    // If ANY file read failed (e.g. Standalone with no assets), use embedded default
    elseif ($embedded_favicon_svg) {
        $svg_content = $embedded_favicon_svg;
    }

    // Ultimate fallback if everything fails
    if (empty($svg_content)) {
        $svg_content = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect x="10" y="30" width="80" height="55" rx="5" fill="#3b82f6" /><path d="M10 30 L35 30 L45 15 L90 15 L90 30" fill="#3b82f6" opacity="0.7" /></svg>';
    }

    $base64 = base64_encode($svg_content);
    return '<link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,' . $base64 . '">';
}

// Auto-detect theme and view mode
$_allowed_theme_values = array('light', 'dark', 'ocean', 'forest', 'dracula', 'nord', 'high-contrast', 'cute', 'auto');
$_cookie_theme = isset($_COOKIE['dir_theme']) ? $_COOKIE['dir_theme'] : '';
$theme_mode = in_array($_cookie_theme, $_allowed_theme_values, true) ? $_cookie_theme : $config['theme'];
$view_mode = (isset($_COOKIE['dir_view']) && in_array($_COOKIE['dir_view'], array('grid', 'list')))
    ? $_COOKIE['dir_view']
    : ((isset($config['view_mode']) && $config['view_mode'] === 'grid') ? 'grid' : 'list');


// Page title
if (!empty($config['title'])) {
    $page_title = $config['title'];
} else {
    // Calculate relative path for title
    $relative_path = '';
    $current_dir_normalized = str_replace('\\', '/', $current_dir);
    if (stripos($current_dir_normalized, $lister_root) === 0) {
        $relative_path = substr($current_dir_normalized, strlen($lister_root));
        $relative_path = trim($relative_path, '/');
    }
    $path_display = $relative_path ? '/' . $relative_path : '/';
    $page_title = trim($config['title_prefix'] . ' ' . $path_display . ' ' . $config['title_suffix']);
}


// Brand Title (for H1)
$brand_title = !empty($config['title']) ? $config['title'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'FileLister');

// ============================================================================
// HANDLE THUMBNAILS
// ============================================================================

// ============================================================================
// CORE FUNCTIONS
// ============================================================================

if (isset($_GET['thumb'])) {
    // Legacy support or direct access if needed, 
    // but we are using direct links now. 
    // If we want to strictly remove it, we can just remove this block.
    // The requirement says "remove creating cache thumb".
    // So we remove the logic.
    http_response_code(404);
    exit;
}

// ============================================================================
// HANDLE FILE HASHING (API)
// ============================================================================
if (isset($_GET['hash'])) {
    $file_path = $_GET['hash'];
    $full_path = $lister_root . '/' . $file_path;

    // ── FIX VUL-01 (CRITICAL): Path Traversal Prevention ─────────────────────
    // Step 1: Use Windows-compatible resolver to handle encoding edge-cases.
    $win_path = resolve_windows_path($full_path);

    // Step 2: ALWAYS apply realpath() so that any remaining '../', symlinks,
    // or double-slash sequences are fully collapsed to the canonical path.
    // This prevents bypass via: /?hash=../../etc/passwd or unicode tricks.
    $resolved_path = realpath($win_path ?: $full_path);

    // Check if file was found
    if (!$resolved_path) {
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'File not found or access denied'));
        exit;
    }

    // Use the resolved path for security checks and hashing
    $full_path = $resolved_path;

    // FIX VUL-01: Strict containment check on the FULLY CANONICAL resolved path.
    // Append a separator to prevent prefix collision:
    //   e.g. $lister_root = '/var/www/html'
    //        a path '/var/www/html_backup/file' must NOT be allowed.
    $lister_root_norm = rtrim(str_replace('\\', '/', $lister_root), '/') . '/';
    $full_path_norm = str_replace('\\', '/', $full_path);

    if (strpos($full_path_norm . '/', $lister_root_norm) !== 0) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Access denied'));
        exit;
    }

    // Security check (standard is_allowed)
    if (!is_allowed(dirname($full_path), basename($full_path)) || is_dir($full_path)) {
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'File not found or access denied'));
        exit;
    }

    // Check max file size for hashing to prevent server timeout
    $max_hash_bytes = (int) $config['max_hash_size'] * 1024 * 1024;
    if (filesize($full_path) > $max_hash_bytes) {
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'File is too large to hash (Max ' . format_size($max_hash_bytes) . ')'));
        exit;
    }

    // Parse enabled hash types from config
    $enabled_hashes = array_map('trim', explode(',', strtoupper($config['enable_hashtype'])));

    // Check if a specific algorithm is requested
    $requested_algo = isset($_GET['algo']) ? strtoupper(trim($_GET['algo'])) : null;

    // Filter enabled hashes if a specific one is requested
    if ($requested_algo) {
        $req_norm = str_replace(array('-', '/', '_'), '', $requested_algo);
        $found = false;
        foreach ($enabled_hashes as $h) {
            if (str_replace(array('-', '/', '_'), '', strtoupper($h)) === $req_norm) {
                $enabled_hashes = array($h);
                $found = true;
                break;
            }
        }

        if (!$found) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'Hash algorithm not enabled'));
            exit;
        }
    }

    // Map of available hash algorithms
    $available_hashes = array(
        'MD2' => 'md2',
        'MD4' => 'md4',
        'MD5' => 'md5',
        'SHA1' => 'sha1',
        'SHA224' => 'sha224',
        'SHA256' => 'sha256',
        'SHA384' => 'sha384',
        'SHA512' => 'sha512',
        'SHA512224' => 'sha512/224',
        'SHA512256' => 'sha512/256',
        'SHA3224' => 'sha3-224',
        'SHA3256' => 'sha3-256',
        'SHA3384' => 'sha3-384',
        'SHA3512' => 'sha3-512',
        'RIPEMD128' => 'ripemd128',
        'RIPEMD160' => 'ripemd160',
        'RIPEMD256' => 'ripemd256',
        'RIPEMD320' => 'ripemd320',
        'TIGER192' => 'tiger192,3',
        'WHIRLPOOL' => 'whirlpool',
        'CRC32' => 'crc32b',
        'CRC32B' => 'crc32b',
        'CRC32C' => 'crc32c',
        'ADLER32' => 'adler32',
        'XXH32' => 'xxh32',
        'XXH64' => 'xxh64',
        'XXH3' => 'xxh3',
        'XXH128' => 'xxh128',
        'FNV132' => 'fnv132',
        'FNV1A32' => 'fnv1a32',
        'FNV164' => 'fnv164',
        'FNV1A64' => 'fnv1a64',
        'MURMUR3A' => 'murmur3a',
        'MURMUR3C' => 'murmur3c',
        'MURMUR3F' => 'murmur3f',
    );

    // Get list of supported algorithms on this PHP server
    $supported_algos = function_exists('hash_algos') ? hash_algos() : array();

    // ============================================================================
    // CACHE LOGIC (SMART CONTENT-BASED)
    // ============================================================================
    // Use system temp directory via sys_get_temp_dir()
    $cache_dir = sys_get_temp_dir() . '/FileLister/hashes';
    if (!is_dir($cache_dir)) {
        @mkdir($cache_dir, 0755, true);
    }

    $current_size = filesize($full_path);

    // Smart Cache Key: based on size + first 4KB of content
    // This allows identifying duplicates/renames/copies without rehashing
    $fp = @fopen($full_path, 'rb');
    $header = $fp ? fread($fp, 4096) : ''; // Read first 4KB
    if ($fp)
        fclose($fp);

    // Cache ID = MD5 of (Size + Header)
    $cache_id = md5($current_size . $header);
    $cache_file = $cache_dir . '/' . $cache_id . '.json';

    $cached_data = array();
    $cache_valid = false;
    $ttl = 7 * 24 * 60 * 60; // 7 Days TTL

    if (file_exists($cache_file)) {
        // Check TTL (Time To Live)
        if (time() - filemtime($cache_file) > $ttl) {
            @unlink($cache_file); // Expired
        } else {
            $json = @file_get_contents($cache_file);
            if ($json) {
                $data = json_decode($json, true);
                if (isset($data['hashes'])) {
                    $cached_data = $data['hashes'];
                    $cache_valid = true;
                }
            }
        }
    }

    $hashes = array();
    $cache_updated = false;

    foreach ($enabled_hashes as $hash_type) {
        // Clean up and force UPPERCASE for consistent lookup
        $lookup_type = str_replace(array('-', '/', '_'), '', strtoupper($hash_type));
        $api_key = strtolower($lookup_type);

        // Check if hash is already cached
        if ($cache_valid && isset($cached_data[$api_key])) {
            $hashes[$api_key] = $cached_data[$api_key];
            continue;
        }

        // If no specific algorithm is requested, WE DO NOT CALCULATE.
        // We only return what is already in the cache to ensure this request is INSTANT.
        // The frontend will see missing hashes and request them individually (progressive loading).
        if (!$requested_algo) {
            continue;
        }

        if (isset($available_hashes[$lookup_type])) {
            $algo = $available_hashes[$lookup_type];

            // SPECIAL CASE: CRC32
            if ($lookup_type === 'CRC32') {
                if (in_array('crc32b', $supported_algos)) {
                    $hash_value = hash_file('crc32b', $full_path);
                } else {
                    $hash_value = dechex(crc32(file_get_contents($full_path)));
                }
                $final_hash = $config['hash_uppercase'] ? strtoupper($hash_value) : strtolower($hash_value);
                $hashes['crc32'] = $final_hash;

                // Update cache array
                $cached_data['crc32'] = $final_hash;
                $cache_updated = true;
            }
            // Check if algorithm is supported by current PHP version
            elseif (in_array($algo, $supported_algos)) {
                $hash_value = hash_file($algo, $full_path);
                $final_hash = $config['hash_uppercase'] ? strtoupper($hash_value) : strtolower($hash_value);
                $hashes[$api_key] = $final_hash;

                // Update cache array
                $cached_data[$api_key] = $final_hash;
                $cache_updated = true;
            } else {
                // Not supported
                header('Content-Type: application/json');
                echo json_encode(array('error' => 'Not supported by this PHP version'));
                exit;
            }
        }
    }

    // Save updated cache keys (smart caching)
    if ($cache_updated) {
        // We only store hashes, no need for metadata since key implies identity
        $new_cache_data = array(
            'hashes' => $cached_data
        );
        @file_put_contents($cache_file, json_encode($new_cache_data));
    }

    header('Content-Type: application/json');
    echo json_encode($hashes);
    exit;
}

// ============================================================================
// HANDLE EXPORT (?export=json|csv|tsv|ndjson)
// ============================================================================
if (!empty($config['enable_export']) && isset($_GET['export'])) {
    $allowed_formats = array('json', 'csv', 'tsv', 'ndjson');
    $format = strtolower(trim($_GET['export']));

    if (!in_array($format, $allowed_formats, true)) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Invalid export format. Allowed: json, csv, tsv, ndjson'));
        exit;
    }

    // Calculate Base URL for absolute links
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['PHP_SELF'];
    $base_dir = rtrim(dirname($script), '/\\');
    $base_url = $protocol . $host . $base_dir;

    // Build export rows from file list (already resolved, filtered, sorted)
    $rows = array();
    foreach ($files as $f) {
        $rows[] = array(
            'name' => $f['name'],
            'type' => $f['is_dir'] ? 'folder' : 'file',
            'ext' => $f['ext'],
            'size' => $f['size'],
            'size_formatted' => $f['size_formatted'],
            'modified' => $f['modified'],
            'date' => $f['date_formatted'],
            'url' => $base_url . '/' . $f['url_raw'], // Full Absolute URL
        );
    }

    // ── Determine inline/download mode ────────────────────────────────────────
    // ?export=json          → Content-Disposition: inline  (clipboard via JS fetch)
    // ?export=json&download → Content-Disposition: attachment (browser download)
    $is_download = isset($_GET['download']);
    // Use basename to avoid path traversal or weird headers, default to 'root'
    $raw_dir = isset($_GET['dir']) ? basename($_GET['dir']) : 'root';
    $dir_slug = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $raw_dir);
    $dir_slug = trim(preg_replace('/_+/', '_', $dir_slug), '_') ?: 'root';
    $filename = 'filelist_' . $dir_slug . '.' . ($format === 'ndjson' ? 'ndjson' : $format);

    // ── Format output ─────────────────────────────────────────────────────────
    switch ($format) {
        case 'json':
            $output = json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $mime = 'application/json';
            break;

        case 'ndjson':
            $lines = array();
            foreach ($rows as $row) {
                $lines[] = json_encode($row, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
            $output = implode("\n", $lines);
            $mime = 'application/x-ndjson';
            break;

        case 'csv':
        case 'tsv':
            $sep = ($format === 'tsv') ? "\t" : ',';
            $fields = array('name', 'type', 'ext', 'size', 'size_formatted', 'modified', 'date', 'url');
            $csvRows = array();

            // Header row
            if ($format === 'csv') {
                $csvRows[] = implode($sep, array_map(function ($h) {
                    return '"' . $h . '"';
                }, $fields));
            } else {
                $csvRows[] = implode($sep, $fields);
            }

            foreach ($rows as $row) {
                $cells = array();
                foreach ($fields as $f) {
                    $val = isset($row[$f]) ? $row[$f] : '';
                    if ($format === 'csv') {
                        // RFC 4180: wrap in quotes, escape inner quotes by doubling
                        $cells[] = '"' . str_replace('"', '""', $val) . '"';
                    } else {
                        // TSV: replace tabs and newlines to avoid breaking format
                        $cells[] = str_replace(array("\t", "\n", "\r"), array(' ', ' ', ''), $val);
                    }
                }
                $csvRows[] = implode($sep, $cells);
            }
            $output = implode("\r\n", $csvRows);
            $mime = ($format === 'tsv') ? 'text/tab-separated-values' : 'text/csv';
            break;

        default:
            $output = '';
            $mime = 'text/plain';
    }

    // ── Send response ─────────────────────────────────────────────────────────
    header('Content-Type: ' . $mime . '; charset=UTF-8');
    if ($is_download) {
        header('Content-Disposition: attachment; filename="' . $filename . '"');
    } else {
        // Inline: allow JS fetch() from same origin (clipboard copy)
        header('Content-Disposition: inline');
        header('Cache-Control: no-store');
    }
    // CORS: Same-origin only — do NOT reflect arbitrary Origin headers (CORS reflection vulnerability)
    header('Access-Control-Allow-Origin: ' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost'));
    echo $output;
    exit;
}

// ============================================================================
// UI ICON HELPERS (SVG)
// ============================================================================

/**
 * Get internal UI SVG icon placeholder (to be filled by JS)
 */
function get_svg_icon($name, $class = '')
{
    $extra_class = $class ? ' ' . $class : '';
    return '<span class="icon' . $extra_class . '" data-icon="' . htmlspecialchars($name) . '"></span>';
}

// ============================================================================
// HTML OUTPUT
// ============================================================================
?>