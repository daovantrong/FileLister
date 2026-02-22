<?php
/**
 * Builder Script for FileLister Standalone Version
 * Bundles index.php and all assets into a single Standalone.php file.
 * Strategy: "Defuse" PHP tags in JS/CSS using hex escapes or splitting, keeping code visible.
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("403 Forbidden: This script must be run from the command line only.\n");
}

$coreFile = __DIR__ . '/core.php';
$indexFile = __DIR__ . '/index.php';
$outputFile = __DIR__ . '/Standalone.php';
$assetsDir = __DIR__ . '/_';

if (!file_exists($coreFile))
    die("ERROR: core.php not found.\n");
if (!file_exists($indexFile))
    die("ERROR: index.php not found.\n");
if (!is_dir($assetsDir))
    die("ERROR: assets directory not found.\n");

echo "Building Standalone.php...\n";

// ── 1. Read core.php and index.php ─────────────────────────────────────────
$coreSource = file_get_contents($coreFile);
$indexSource = file_get_contents($indexFile);

// Remove the require_once line from index.php
$indexSource = preg_replace('/<\?php\s+(require|include)(_once)?\s*[\'"]core\.php[\'"]\s*;\s*\?>\s*/i', '', $indexSource);

// Combine them
$source = $coreSource . "\n" . $indexSource;

// ── 2. Set 'use_embedded' => true ─────────────────────────────────────────
if (strpos($source, "'use_embedded' => false") !== false) {
    $source = str_replace("'use_embedded' => false", "'use_embedded' => true", $source);
} else {
    echo "WARNING: Could not find 'use_embedded' => false in index.php. Standalone mode might not activate.\n";
}

// ── 2.5. Set 'useEmbedded' => true in JavaScript config ───────────────────────
if (strpos($source, "'useEmbedded' => false") !== false) {
    $source = str_replace("'useEmbedded' => false", "'useEmbedded' => true", $source);
    echo "Added 'useEmbedded' => true to JavaScript config.\n";
} else {
    echo "WARNING: Could not find 'useEmbedded' => false in JavaScript config.\n";
}

// ── 2.6. Embed default custom files and clear default config ───────────────────
// Embed default custom.css and custom.js, then clear their default config values
// This allows users to set custom paths later and still load from outside

// Embed default custom.css
$customCss = $assetsDir . '/css/custom.css';
if (file_exists($customCss)) {
    echo "Embedding default custom.css\n";
    // Will be embedded in CSS processing section
} else {
    echo "Default custom.css not found\n";
}

// Embed default custom.js  
$customJs = $assetsDir . '/js/custom.js';
if (file_exists($customJs)) {
    echo "Embedding default custom.js\n";
    // Will be embedded in JS processing section
} else {
    echo "Default custom.js not found\n";
}

// Clear default config values (only if they are default)
$source = str_replace("'custom_css' => '_/css/custom.css'", "'custom_css' => ''", $source);
$source = str_replace("'custom_js' => '_/js/custom.js'", "'custom_js' => ''", $source);
echo "Cleared default custom_css and custom_js config values\n";

// ── 3. Prepare CSS ─────────────────────────────────────────────────────────
echo "Processing CSS...\n";
$fullCss = "";

$tokensCss = $assetsDir . '/css/tokens.css';
if (file_exists($tokensCss)) {
    $fullCss .= "/* Tokens CSS */\n" . file_get_contents($tokensCss) . "\n";
}

$mainCss = $assetsDir . '/css/style.css';
if (file_exists($mainCss)) {
    $c = file_get_contents($mainCss);
    // Remove @imports as we bundle them
    $c = preg_replace('/@import\s+url\([\'"]?(tokens\.css|themes\/.*?)[\'"]?\);\s*/i', '', $c);
    $fullCss .= "/* Main CSS */\n" . $c;
}

$themes = glob($assetsDir . '/css/themes/*.css');
foreach ((array) $themes as $t) {
    if ($t) {
        $themeName = basename($t, '.css');
        $fullCss .= "\n/* Theme: $themeName */\n" . file_get_contents($t);
    }
}

$prismCss = $assetsDir . '/css/prism.css';
if (file_exists($prismCss))
    $fullCss .= "\n/* Prism CSS */\n" . file_get_contents($prismCss);

$customCss = $assetsDir . '/css/custom.css';
if (file_exists($customCss))
    $fullCss .= "\n/* Custom CSS */\n" . file_get_contents($customCss);

// Embed images in CSS as Base64
$fullCss = preg_replace_callback('/url\(\s*[\'"]?(.*?)[\'"]?\s*\)/i', function ($m) use ($assetsDir) {
    $url = $m[1];
    if (strpos($url, 'data:') === 0 || strpos($url, 'http') === 0 || empty($url))
        return $m[0];

    // Resolve path
    $cands = array(
        $assetsDir . '/css/themes/' . $url,
        $assetsDir . '/css/' . $url,
        $assetsDir . '/' . $url
    );
    foreach ($cands as $c) {
        if (file_exists($c)) {
            $type = pathinfo($c, PATHINFO_EXTENSION);
            $mime = ($type == 'svg' ? 'svg+xml' : $type);
            return 'url("data:image/' . $mime . ';base64,' . base64_encode(file_get_contents($c)) . '")';
        }
    }
    return $m[0];
}, $fullCss);

// ── 4. Prepare JS ──────────────────────────────────────────────────────────
echo "Processing JS...\n";
$transData = array();
$tranFiles = glob($assetsDir . '/lang/*.json');
foreach ((array) $tranFiles as $tf) {
    if ($tf)
        $transData[basename($tf, '.json')] = json_decode(file_get_contents($tf), true);
}

$iconData = array();
$iconFiles = glob($assetsDir . '/icons/*.svg');
foreach ((array) $iconFiles as $if) {
    if ($if) {
        $ic = file_get_contents($if);
        $ic = preg_replace('/<\?xml.*?\?>/i', '', $ic);
        if (preg_match('/viewBox="([^"]+)"/i', $ic, $mv)) {
            if ($mv[1] === '0 0 32 32' && preg_match('/^<svg[^>]*><path[^>]*d="([^"]+)"[^>]*><\/svg>$/i', $ic, $mp)) {
                $iconData[basename($if, '.svg')] = $mp[1];
                continue;
            }
        }
        $iconData[basename($if, '.svg')] = $ic;
    }
}

$fullJs = "window.translations = " . json_encode($transData) . ";\n";
$fullJs .= "window.uiIcons = " . json_encode($iconData) . ";\n";

$jsFiles = array('i18n.js', 'marked.js', 'prism.js', 'preview.js', 'search.js', 'qrcode.lib.js', 'qrcode.js', 'shortcuts.js', 'app.js', 'custom.js');
foreach ($jsFiles as $jf) {
    $p = $assetsDir . '/js/' . $jf;
    if (file_exists($p)) {
        $fullJs .= "\n/* JS: $jf */\n" . file_get_contents($p);
    }
}

// DEFUSE PHP TAGS IN JS (INLINED)
// Use hex escapes \x3c? and ?\x3e 
// Construct PHP tags using concatenation to avoid parser confusion in THIS script
$fullJs = str_replace(
    array('<' . '?', '?' . '>'),
    array('\x3c?', '?\x3e'),
    $fullJs
);

// ── 5. Inject Favicon ──────────────────────────────────────────────────────
$favPath = $assetsDir . '/icons/folder.svg';
if (file_exists($favPath)) {
    $fav = trim(preg_replace('/<\?xml.*?\?>|<!--.*?-->/s', '', file_get_contents($favPath)));

    // Defuse tags inside SVG (INLINED)
    $fav = str_replace(
        array('<' . '?', '?' . '>'),
        array('\x3c?', '?\x3e'),
        $fav
    );

    $source = str_replace('$embedded_favicon_svg = null;', '$embedded_favicon_svg = \'' . str_replace("'", "\\'", $fav) . '\';', $source);
}

// ── 6. Injection Logic ─────────────────────────────────────────────────────

// CSS Injection
$cssTag = '<style>' . "\n" . $fullCss . "\n" . '</style>';

if (strpos($source, '<!-- Embedded CSS (if any) -->') !== false) {
    // Replace FIRST occurrence using callback to prevent backslash interpretation
    $source = preg_replace_callback('/<!-- Embedded CSS \(if any\) -->/', function ($m) use ($cssTag) {
        return $cssTag;
    }, $source, 1);
    // Remove subsequent
    $source = str_replace('<!-- Embedded CSS (if any) -->', '', $source);
} else {
    // Fallback
    echo "  NOTE: CSS placeholder not found, injecting before </head>.\n";
    $source = str_replace('</head>', $cssTag . "\n</head>", $source);
}

// JS Injection
$phpOpen = '<' . '?=';
$phpClose = '?' . '>';
$nonceAttr = 'nonce="' . $phpOpen . ' htmlspecialchars(isset($csp_nonce)?$csp_nonce:\'\', ENT_QUOTES, \'UTF-8\') ' . $phpClose . '"';

$jsTag = '<!-- Embedded JavaScript -->' . "\n";
$jsTag .= '<script ' . $nonceAttr . '>' . "\n";
$jsTag .= $fullJs . "\n";
$jsTag .= '</script>';

if (strpos($source, '<!-- Embedded JavaScript -->') !== false) {
    // Replace placeholder
    $source = preg_replace_callback('/<!-- Embedded JavaScript -->.*?<\/script>/s', function ($m) use ($jsTag) {
        return $jsTag;
    }, $source, 1);
} else {
    // Fallback
    echo "  NOTE: JS placeholder not found, injecting before </body>.\n";
    $source = str_replace('</body>', $jsTag . "\n</body>", $source);
}

// ── 7. Write Output ────────────────────────────────────────────────────────
echo "Writing Standalone.php...\n";
if (file_put_contents($outputFile, $source) === false) {
    die("ERROR: Failed to write to $outputFile\n");
}

echo "Done! Standalone.php created (" . round(filesize($outputFile) / 1024, 2) . " KB).\n";
