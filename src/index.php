<?php 
require_once 'core.php'; 
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<!-- Standard version
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_| 
 * FileListe by TRONG.PRO 
-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="<?= htmlspecialchars(!empty($config['meta_description']) ? $config['meta_description'] : 'FileLister - A modern, feature-rich PHP directory listing script with a beautiful interface. Simple to install, easy to use, and highly customizable.') ?>">
    <meta name="keywords"
        content="<?= htmlspecialchars(!empty($config['meta_keywords']) ? $config['meta_keywords'] : 'php, directory listing, file browser, filelister, file manager, modern ui, responsive, file sharing') ?>">
    <meta name="author"
        content="<?= htmlspecialchars(!empty($config['author']) ? $config['author'] : 'Dao Van Trong - TRONG.PRO') ?>">
    <meta property="og:title"
        content="<?= htmlspecialchars(!empty($config['og_title']) ? $config['og_title'] : $page_title) ?>">
    <meta property="og:description"
        content="<?= htmlspecialchars(!empty($config['og_description']) ? $config['og_description'] : (!empty($config['meta_description']) ? $config['meta_description'] : 'A beautiful and lightweight file browser for your server.')) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url"
        content="<?= htmlspecialchars((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>">
    <!-- Theme Color Flash Mitigation -->
    <?php
    $theme_bg_colors = array(
        'light' => '#ffffff',
        'dark' => '#0d1117',
        'ocean' => '#0f172a',
        'forest' => '#064e3b',
        'dracula' => '#282a36',
        'nord' => '#eceff4',
        'high-contrast' => '#000000',
        'cute' => '#fff5f7'
    );
    $current_theme = isset($config['theme']) ? $config['theme'] : 'light';
    $bg_color = isset($theme_bg_colors[$current_theme]) ? $theme_bg_colors[$current_theme] : '#ffffff';
    ?>
    <style>
        html,
        body {
            background-color:
                <?= $bg_color ?>
            ;
        }

        <?php if ($current_theme === 'dark' || $current_theme === 'ocean' || $current_theme === 'forest' || $current_theme === 'dracula' || $current_theme === 'high-contrast'): ?>
            body {
                color: #ffffff;
            }

        <?php endif; ?>
    </style>

    <title><?= htmlspecialchars($page_title) ?></title>

    <!-- Favicon -->
    <?= get_favicon_html() ?>

    <!-- Google Fonts Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts for Language Support (Optimized) -->
    <?php
    function get_google_font_url($lang)
    {
        // Base URL
        $base = "https://fonts.googleapis.com/css2?display=swap";

        // Define font mappings based on style.css
        $fonts = array(
            'vi' => '&family=Be+Vietnam+Pro:wght@400;500;600;700',
            'zh' => '&family=Noto+Sans+SC:wght@400;500;600;700',
            'zh-CN' => '&family=Noto+Sans+SC:wght@400;500;600;700',
            'zh-TW' => '&family=Noto+Sans+TC:wght@400;500;600;700',
            'zh-HK' => '&family=Noto+Sans+TC:wght@400;500;600;700',
            'ja' => '&family=Noto+Sans+JP:wght@400;500;600;700',
            'ko' => '&family=Noto+Sans+KR:wght@400;500;600;700',
            'kr' => '&family=Noto+Sans+KR:wght@400;500;600;700',
            'ar' => '&family=Noto+Sans+Arabic:wght@400;500;600;700',
            'he' => '&family=Noto+Sans+Hebrew:wght@400;500;600;700'
        );

        // Return specific font URL if defined, otherwise return null (use system fonts)
        return isset($fonts[$lang]) ? $base . $fonts[$lang] : null;
    }

    $font_url = get_google_font_url($lang);
    ?>
    <?php if ($font_url): ?>
        <link href="<?= $font_url ?>" rel="stylesheet" id="main-font">
    <?php endif; ?>

    <?= get_html_hook('head_end') ?>
</head>

<body class="lang-<?= $lang ?>" data-theme="<?= htmlspecialchars($theme_mode) ?>" data-view="<?= $view_mode ?>"
    data-lang="<?= $lang ?>">

    <?= get_html_hook('body_start') ?>


    <!-- Header -->
    <header class="header">
        <?= get_html_hook('header_start') ?>
        <div class="header-top">
            <h1 class="title">
                <a href="?">
                    <span class="icon"><?= get_svg_icon('folder') ?></span>
                    <span><?= htmlspecialchars($brand_title) ?></span>
                </a>
            </h1>
            <div class="controls">
                <?php if ($config['enable_search']): ?>
                    <input type="search" id="search" class="search-input" placeholder="<?= t('search') ?>"
                        aria-label="<?= t('search') ?>" data-i18n-placeholder="search" data-i18n-aria-label="search">
                <?php endif; ?>
            </div>
            <button id="help-toggle" class="btn-icon" title="<?= t('help') ?>" aria-label="<?= t('help') ?>"
                data-i18n-title="help" data-i18n-aria-label="help">
                <span class="icon">
                    <?= get_svg_icon('help') ?>
                </span>
            </button>
        </div>

        <!-- Stats -->
        <div class="stats">
            <span class="stat-item">
                <span class="icon"><?= get_svg_icon('stats') ?></span>
                <span><?= $total_items ?> <span data-i18n="stats.items"><?= t('stats.items') ?></span></span>
            </span>
            <span class="stat-item">
                <span class="icon"><?= get_svg_icon('folder') ?></span>
                <span><?= $total_folders ?> <span data-i18n="stats.folders"><?= t('stats.folders') ?></span></span>
            </span>
            <span class="stat-item">
                <span class="icon"><?= get_svg_icon('file') ?></span>
                <span><?= $total_files ?> <span data-i18n="stats.files"><?= t('stats.files') ?></span></span>
            </span>
            <?php if ($config['show_folder_size']): ?>
                <span class="stat-item">
                    <span class="icon"><?= get_svg_icon('storage') ?></span>
                    <span><?= format_size($total_size) ?></span>
                </span>
            <?php endif; ?>
            <span class="stat-item" id="window-size-stat" style="cursor: help;" title="Window Size">
                <span class="icon"><?= get_svg_icon('monitor') ?></span>
                <span id="window-size-value">...</span>
            </span>
        </div>
        <?= get_html_hook('header_end') ?>
    </header>

    <!-- Breadcrumb -->
    <?php if ($config['show_breadcrumb'] && !empty($breadcrumb)): ?>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="?" class="breadcrumb-item">
                <span class="icon"><?= get_svg_icon('home') ?></span>
                <span data-i18n="general.home">Home</span>
            </a>
            <?php foreach ($breadcrumb as $item): ?>
                <span class="breadcrumb-separator">/</span>
                <a href="<?= $item['url'] ?>" class="breadcrumb-item">
                    <?= htmlspecialchars($item['name']) ?>
                </a>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-section">
            <span class="toolbar-label" data-i18n="toolbar.view"><?= t('toolbar.view') ?></span>
            <div class="btn-group">
                <button class="btn btn-sm" data-view="grid" data-action="change-view" title="<?= t('view.grid') ?>"
                    data-i18n-title="view.grid">
                    <span class="icon"><?= get_svg_icon('grid') ?></span>
                    <span class="text" data-i18n="view.grid"><?= t('view.grid') ?></span>
                </button>
                <button class="btn btn-sm" data-view="list" data-action="change-view" title="<?= t('view.list') ?>"
                    data-i18n-title="view.list">
                    <span class="icon"><?= get_svg_icon('list') ?></span>
                    <span class="text" data-i18n="view.list"><?= t('view.list') ?></span>
                </button>
            </div>
        </div>

        <div class="toolbar-section">
            <span class="toolbar-label" data-i18n="toolbar.sort"><?= t('toolbar.sort') ?></span>
            <select id="sort-select" class="select-sm">
                <option value="name_asc" data-i18n="sort_options.name_asc"><?= t('sort_options.name_asc') ?></option>
                <option value="name_desc" data-i18n="sort_options.name_desc"><?= t('sort_options.name_desc') ?></option>
                <option value="size_asc" data-i18n="sort_options.size_asc"><?= t('sort_options.size_asc') ?></option>
                <option value="size_desc" data-i18n="sort_options.size_desc"><?= t('sort_options.size_desc') ?></option>
                <option value="date_asc" data-i18n="sort_options.date_asc"><?= t('sort_options.date_asc') ?></option>
                <option value="date_desc" data-i18n="sort_options.date_desc"><?= t('sort_options.date_desc') ?></option>
                <option value="type_asc" data-i18n="sort_options.type_asc"><?= t('sort_options.type_asc') ?></option>
                <option value="type_desc" data-i18n="sort_options.type_desc"><?= t('sort_options.type_desc') ?></option>
            </select>
        </div>

        <div class="toolbar-section">
            <span class="toolbar-label" data-i18n="toolbar.filter"><?= t('toolbar.filter') ?></span>
            <select id="filter-select" class="select-sm">
                <option value="all" data-i18n="filter_options.all"><?= t('filter_options.all') ?></option>
                <option value="folder" data-i18n="filter_options.folder"><?= t('filter_options.folder') ?></option>
                <option value="image" data-i18n="filter_options.image"><?= t('filter_options.image') ?></option>
                <option value="video" data-i18n="filter_options.video"><?= t('filter_options.video') ?></option>
                <option value="audio" data-i18n="filter_options.audio"><?= t('filter_options.audio') ?></option>
                <option value="document" data-i18n="filter_options.document"><?= t('filter_options.document') ?>
                </option>
                <option value="archive" data-i18n="filter_options.archive"><?= t('filter_options.archive') ?></option>
                <option value="code" data-i18n="filter_options.code"><?= t('filter_options.code') ?></option>
            </select>
        </div>

    </div>



    <!-- Main Content -->
    <?= get_html_hook('main_before') ?>
    <main class="main-content">
        <?= get_html_hook('main_start') ?>
        <!-- File Grid/List -->
        <div class="items view-<?= $view_mode ?>" id="file-items" role="list">
            <?php if (empty($files)): ?>
                <div class="empty-state">
                    <span class="icon"><?= get_svg_icon('empty') ?></span>
                    <p data-i18n="messages.empty"><?= t('messages.empty') ?></p>
                </div>
            <?php else: ?>
                <?php foreach ($files as $file): ?>
                    <div class="item" data-name="<?= htmlspecialchars($file['name']) ?>"
                        data-path="<?= htmlspecialchars($file['url_raw']) ?>" data-type="<?= $file['icon'] ?>"
                        data-is-dir="<?= $file['is_dir'] ? '1' : '0' ?>" data-ext="<?= htmlspecialchars($file['ext']) ?>"
                        data-size="<?= $file['size'] ?>" data-size-fmt="<?= htmlspecialchars($file['size_formatted']) ?>"
                        data-date="<?= $file['modified'] ?>" data-date-fmt="<?= htmlspecialchars($file['date_formatted']) ?>"
                        data-url="<?= htmlspecialchars($file['url']) ?>" role="listitem">

                        <div class="item-icon">
                            <a href="<?= htmlspecialchars($file['url']) ?>" class="icon-link" <?php if ($config['enable_preview'] && !$file['is_dir']): ?> data-action="preview"
                                    data-path="<?= htmlspecialchars($file['url_raw']) ?>" data-type="<?= $file['icon'] ?>" <?php endif; ?>>
                                <!-- File Icon -->
                                <div class="file-icon js-file-icon" data-ext="<?= htmlspecialchars($file['ext']) ?>"
                                    data-icon="<?= htmlspecialchars($file['icon']) ?>">
                                    <?php if ($file['thumb']): ?>
                                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                            data-thumb="<?= htmlspecialchars($file['thumb']) ?>"
                                            alt="<?= htmlspecialchars($file['name']) ?>" class="item-thumbnail"
                                            data-ext="<?= htmlspecialchars($file['ext']) ?>">
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>

                        <div class="item-content">
                            <a href="<?= htmlspecialchars($file['url']) ?>" class="item-name" <?php if ($config['enable_preview'] && !$file['is_dir']): ?> data-action="preview"
                                    data-path="<?= htmlspecialchars($file['url_raw']) ?>" data-type="<?= $file['icon'] ?>" <?php endif; ?>         <?php if ($file['icon'] === 'image'): ?>
                                    data-thumb="<?= htmlspecialchars($file['url']) ?>" <?php endif; ?>>
                                <?= htmlspecialchars($file['name']) ?>
                            </a>

                            <div class="item-meta">
                                <?php if ($config['show_size']): ?>
                                    <span class="item-size"><?= htmlspecialchars($file['size_formatted']) ?></span>
                                <?php endif; ?>

                                <?php if ($config['show_date']): ?>
                                    <span class="item-date"><?= htmlspecialchars($file['date_formatted']) ?></span>
                                <?php endif; ?>

                                <?php if ($config['show_type']): ?>
                                    <span class="item-type"><?= htmlspecialchars($file['type']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ($config['enable_download'] || $config['enable_share']): ?>
                            <div class="item-actions">
                                <?php if ($config['enable_download'] && !$file['is_dir']): ?>
                                    <a href="<?= htmlspecialchars($file['url']) ?>" download class="btn-action" title="Download">
                                        <span><?= get_svg_icon('download') ?></span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($config['enable_share']): ?>
                                    <button class="btn-action" data-action="share" data-path="<?= htmlspecialchars($file['url_raw']) ?>"
                                        title="Share">
                                        <span><?= get_svg_icon('share') ?></span>
                                    </button>
                                <?php endif; ?>

                                <!-- Info/Hash Button -->
                                <?php if (!$file['is_dir']): ?>
                                    <button class="btn-action" data-action="hash" data-path="<?= htmlspecialchars($file['url_raw']) ?>"
                                        title="Info & Verify">
                                        <span><?= get_svg_icon('info') ?></span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?= get_html_hook('main_end') ?>
    </main>
    <?= get_html_hook('main_after') ?>

    <!-- Readme Container -->
    <div id="readme-container" class="readme-container custom-markdown" style="display: none;">
        <div class="readme-header">
            <span class="icon"><?= get_svg_icon('readme') ?></span> README
        </div>
        <div id="readme-content" class="markdown-body"></div>
    </div>

    <!-- Bottom Controls & Export -->
    <div class="toolbar toolbar-bottom">
        <div class="toolbar-section">
            <?php if (isset($config['show_language_selector']) && $config['show_language_selector']): ?>
                <span class="icon-text"><?= get_svg_icon('globe') ?></span>
                <select id="lang-select" class="select-sm" aria-label="<?= t('language') ?>" title="<?= t('language') ?>">
                    <?php
                    foreach ($allowed_langs_config as $l => $name) {
                        $selected = ($lang === $l) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($l) . '" ' . $selected . '>' . htmlspecialchars($name) . '</option>';
                    }
                    ?>
                </select>
            <?php endif; ?>

            <?php if (!isset($config['show_theme_selector']) || $config['show_theme_selector']): ?>
                <button id="theme-toggle" class="btn-icon" title="<?= t('theme') ?>" aria-label="<?= t('theme') ?>"
                    data-i18n-title="theme" data-i18n-aria-label="theme">
                    <span class="icon">
                        <?php
                        $theme_icons = array(
                            'light' => 'sun',
                            'dark' => 'moon',
                            'ocean' => 'ocean',
                            'forest' => 'forest',
                            'dracula' => 'dracula',
                            'nord' => 'nord',
                            'high-contrast' => 'high-contrast',
                            'cute' => 'cute',
                            'auto' => 'auto'
                        );
                        $t_icon = isset($theme_icons[$theme_mode]) ? $theme_icons[$theme_mode] : 'auto';
                        echo get_svg_icon($t_icon);
                        ?>
                    </span>
                </button>
            <?php endif; ?>


        </div>

        <?php if (!empty($config['enable_export'])): ?>
            <div class="toolbar-section toolbar-section--export">
                <div class="export-group">
                    <button id="copy-list-btn" class="btn btn-sm" data-action="copy-list"
                        title="<?= t('actions.copy_list') ?>" aria-label="<?= t('actions.copy_list') ?>">
                        <span class="icon"><?= get_svg_icon('copy') ?></span>
                        <span class="text" data-i18n="actions.copy_list"><?= t('actions.copy_list') ?></span>
                    </button>
                    <select id="export-format-select" class="select-sm" title="Export format" aria-label="Export format">
                        <option value="json" selected>JSON</option>
                        <option value="csv">CSV</option>
                        <option value="tsv">TSV</option>
                        <option value="ndjson">NDJSON</option>
                    </select>
                    <a id="download-list-btn" class="btn btn-sm" data-action="download-list" title="Download file list"
                        aria-label="Download file list" href="#" style="text-decoration:none;">
                        <span class="icon"><?= get_svg_icon('download') ?></span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?= get_html_hook('footer_before') ?>
    <?php if ($config['show_footer']): ?>
        <footer class="footer">
            <?= get_html_hook('footer_start') ?>
            <div class="footer-content">
                <div class="footer-copyright">
                    <?php if (!empty($config['show_copyright'])): ?>
                        <strong><a href="https://github.com/daovantrong/filelister" target="_blank">FileLister
                                v<?= APP_VERSION ?></a></strong> |
                        <span data-i18n="footer.powered_by"><?= t('footer.powered_by') ?></span> <a href="https://trong.pro"
                            target="_blank">TRONG.PRO</a> &copy; <?= date('Y') ?>
                    <?php endif; ?>
                </div>
                <div id="ip-display" class="footer-ip" style="display: none; margin-top: var(--spacing-xs);">
                    <span data-i18n="footer.your_ipv4"><?= t('footer.your_ipv4') ?></span> <strong
                        id="ipv4"><?= t('footer.checking') ?></strong>
                    <span id="ipv6-wrapper" style="display: none;"> | <span
                            data-i18n="footer.your_ipv6"><?= t('footer.your_ipv6') ?></span> <strong id="ipv6"></strong>
                    </span>
                </div>
            </div>
            <?= get_html_hook('footer_end') ?>
        </footer>
    <?php endif; ?>
    <?= get_html_hook('footer_after') ?>

    <!-- Preview Modal -->
    <?php if ($config['enable_preview']): ?>
        <div id="preview-modal" class="modal" role="dialog" aria-modal="true" aria-labelledby="preview-title"
            style="display: none;">
            <div class="modal-overlay" data-action="close-modal"></div>
            <div class="modal-content preview-content">
                <div class="modal-header">
                    <h2 id="preview-title" class="modal-title" data-i18n="actions.preview">Preview</h2>
                    <button class="modal-close" data-action="close-modal" data-i18n-aria-label="actions.close"
                        aria-label="Close">×</button>
                </div>
                <div class="modal-body" id="preview-content">
                    <!-- Preview content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button class="btn" data-action="close-modal" data-i18n="actions.close">Close</button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Share Modal -->
    <div id="share-modal" class="modal" style="display: none;">
        <div class="modal-content share-content">
            <div class="modal-header">
                <h3 class="modal-title" data-i18n="actions.share" style="margin: 0 auto;"><?= t('actions.share') ?></h3>
                <button class="close-btn">&times;</button>
            </div>
            <div class="modal-body">
                <div class="share-link-group">
                    <input type="text" id="share-input" class="form-control" readonly>
                    <button class="btn" id="copy-share-btn" data-i18n="actions.copy"><?= t('actions.copy') ?></button>
                </div>
                <div id="qrcode-container"></div>
            </div>
        </div>
    </div>

    <!-- Hash Modal -->
    <div id="hash-modal" class="modal" style="display: none;">
        <div class="modal-content hash-content">
            <div class="modal-header">
                <h3 class="modal-title" data-i18n="actions.file_hashes">File Hashes</h3>
                <button class="close-btn"><?= get_svg_icon('close') ?></button>
            </div>
            <div class="modal-body">
                <div id="hash-loading" style="text-align: center; padding: 20px;">
                    <span class="icon spin"><?= get_svg_icon('reload') ?></span> <span
                        data-i18n="messages.loading">Loading...</span>
                </div>
                <div id="hash-results" style="display: none;">
                    <div class="hash-grid" id="hash-grid">
                        <!-- Hash values will be dynamically inserted here -->
                    </div>
                </div>
                <div id="hash-error"
                    style="display: none; color: var(--danger-color); text-align: center; padding: 10px;"></div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script nonce="<?= htmlspecialchars($csp_nonce, ENT_QUOTES, 'UTF-8') ?>">
        <?php
        // Detect Readme
        $readme_content = '';
        if (!isset($config['enable_readme']) || $config['enable_readme'] !== false) {
            $priority_readmes = !empty($config['readme_files']) ? $config['readme_files'] : array('README.md', 'readme.md', 'Readme.md', 'ReadMe.md', 'README.txt', 'readme.txt', 'Readme.txt', 'ReadMe.txt', 'README', 'readme', 'Readme', 'ReadMe');
            foreach ($priority_readmes as $rf) {
                if (is_file($current_dir . '/' . $rf)) {
                    $readme_content = file_get_contents($current_dir . '/' . $rf);
                    break;
                }
            }
        }
        ?>
        // Configuration for JavaScript
        window.dirListingConfig = <?php echo json_encode(array(
            'version' => APP_VERSION,
            'assetVersion' => $asset_version,
            'enablePreview' => $config['enable_preview'],
            'enableSearch' => $config['enable_search'],
            'enableShare' => $config['enable_share'],
            'enableQrcode' => $config['enable_qrcode'],
            'enableShortcuts' => $config['enable_shortcuts'],
            'enableExport' => !empty($config['enable_export']),
            'enableReadme' => isset($config['enable_readme']) ? (bool) $config['enable_readme'] : true,
            'language' => $lang,
            'allowedLangs' => isset($config['allowed_langs']) ? array_keys($config['allowed_langs']) : array('en', 'vi', 'zh', 'ja', 'kr', 'es', 'fr', 'de', 'it', 'nl', 'sv', 'no', 'da', 'fi', 'he', 'ar', 'ru'),
            'theme' => $config['theme'],
            'allowedThemes' => array('light', 'dark', 'ocean', 'forest', 'dracula', 'nord', 'high-contrast', 'cute', 'auto'),
            'viewMode' => $view_mode,
            'assetsPath' => $assets_path,
            'hashUppercase' => $config['hash_uppercase'],
            'enabledHashTypes' => array_map(function ($h) {
                return strtolower(str_replace(array('-', '/', '_'), '', trim($h)));
            }, explode(',', $config['enable_hashtype'])),
            'readme' => $readme_content,
            'themeSettings' => $config['theme_settings'],
            // FIX VUL-04: Expose nonce so dynamic script injection (if any) can be authorized
            'cspNonce' => $csp_nonce,
            'currentDir' => isset($_GET['dir']) ? $_GET['dir'] : '',
            'showLanguageSelector' => isset($config['show_language_selector']) ? (bool) $config['show_language_selector'] : true,
            'useEmbedded' => false,
        ), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    </script>



    <!-- Styles -->
    <?php if ($assets_path !== 'embedded'): ?>
        <link rel="stylesheet"
            href="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/css/style.css?v=<?= $asset_version ?>">
        <?php
        $allowed_themes = isset($config['allowed_themes']) ? $config['allowed_themes'] : array('light', 'dark', 'ocean', 'forest', 'dracula', 'nord', 'high-contrast', 'auto');
        $safe_theme = in_array($config['theme'], $allowed_themes, true) ? $config['theme'] : 'light';
        ?>
        <?php if ($config['theme'] !== 'auto'): ?>
            <link rel="stylesheet"
                href="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/css/themes/<?= $safe_theme ?>.css?v=<?= $asset_version ?>"
                id="theme-css">
        <?php else: ?>
            <link rel="stylesheet"
                href="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/css/themes/light.css?v=<?= $asset_version ?>"
                id="theme-css">
        <?php endif; ?>
        <link rel="stylesheet"
            href="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/css/prism.css?v=<?= $asset_version ?>">
    <?php else: ?>
        <!-- Embedded CSS (if any) -->
    <?php endif; ?>
    
    <?php if (!empty($config['custom_css'])): ?>
        <link rel="stylesheet"
            href="<?= htmlspecialchars($config['custom_css'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>

    <?php if ($assets_path !== 'embedded'): ?>
        <script
            src="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/js/marked.js?v=<?= $asset_version ?>"></script>
        <script src="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/js/app.js?v=<?= $asset_version ?>"></script>
        <script
            src="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/js/i18n.js?v=<?= $asset_version ?>"></script>
        <?php if ($config['enable_preview']): ?>
            <script
                src="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/js/prism.js?v=<?= $asset_version ?>"></script>
            <script
                src="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/js/preview.js?v=<?= $asset_version ?>"></script>
        <?php endif; ?>
        <?php if ($config['enable_search']): ?>
            <script
                src="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/js/search.js?v=<?= $asset_version ?>"></script>
        <?php endif; ?>
        <?php if ($config['enable_qrcode']): ?>
            <script
                src="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/js/qrcode.lib.js?v=<?= $asset_version ?>"></script>
            <script
                src="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/js/qrcode.js?v=<?= $asset_version ?>"></script>
        <?php endif; ?>
        <?php if ($config['enable_shortcuts']): ?>
            <script
                src="<?= htmlspecialchars($assets_path, ENT_QUOTES, 'UTF-8') ?>/js/shortcuts.js?v=<?= $asset_version ?>"></script>
        <?php endif; ?>
    <?php else: ?>
        <!-- Embedded JavaScript -->
        <script nonce="<?= htmlspecialchars($csp_nonce, ENT_QUOTES, 'UTF-8') ?>">
            // Basic functionality when no external JS available
            console.log('FileLister v<?= APP_VERSION ?> - Embedded mode');
        </script>
    <?php endif; ?>

    <?php if (!empty($config['custom_js'])): ?>
        <script src="<?= htmlspecialchars($config['custom_js'], ENT_QUOTES, 'UTF-8') ?>"></script>
    <?php endif; ?>

    <!-- IP Detection Script -->
    <script nonce="<?= htmlspecialchars($csp_nonce, ENT_QUOTES, 'UTF-8') ?>">
        (function () {
            const TTL = 1000 * 60 * 10; // 10 minutes

            async function fetchIP(url) {
                try {
                    const res = await fetch(url, { cache: "no-store" });
                    const text = await res.text();
                    return text || null;
                } catch {
                    return null;
                }
            }

            function getCache(key) {
                const value = localStorage.getItem(key);
                const time = localStorage.getItem(key + "_time");

                if (!value || !time) return null;
                if (Date.now() - parseInt(time) > TTL) return null;

                return value;
            }

            function setCache(key, value) {
                localStorage.setItem(key, value);
                localStorage.setItem(key + "_time", Date.now());
            }

            function isPrivateIP(ip) {
                if (!ip) return true;

                // Check for localhost
                if (ip === '127.0.0.1' || ip === '::1' || ip === 'localhost') return true;

                // Check for private IPv4 ranges
                // 10.0.0.0/8
                if (ip.startsWith('10.')) return true;

                // 192.168.0.0/16
                if (ip.startsWith('192.168.')) return true;

                // 172.16.0.0/12 (172.16.x.x - 172.31.x.x)
                // FIX VUL-06: Correct regex for 172.x private range
                const is172Private = /^172\.(1[6-9]|2[0-9]|3[0-1])\./;
                if (is172Private.test(ip)) return true;

                // Check for link-local
                if (ip.startsWith('169.254.') || ip.startsWith('fe80:')) return true;

                return false;
            }

            async function resolve() {
                const ipDisplay = document.getElementById('ip-display');
                const ipv4Element = document.getElementById('ipv4');
                const ipv6Element = document.getElementById('ipv6');
                const ipv6Wrapper = document.getElementById('ipv6-wrapper');

                // ===== IPv4 =====
                let ipv4 = getCache("ipv4");

                if (!ipv4) {
                    ipv4 = await fetchIP("https://api.ipify.org");
                    if (ipv4 && !isPrivateIP(ipv4)) {
                        setCache("ipv4", ipv4);
                    } else {
                        ipv4 = null;
                    }
                }

                if (ipv4Element) {
                    if (ipv4) {
                        ipv4Element.textContent = ipv4;
                        if (ipDisplay) ipDisplay.style.display = 'block';
                    } else {
                        // Hide IP display if we're on localhost and can't get public IP
                        if (ipDisplay) ipDisplay.style.display = 'none';
                        return;
                    }
                }

                // ===== IPv6 =====
                let ipv6 = getCache("ipv6");

                if (!ipv6) {
                    ipv6 = await fetchIP("https://api64.ipify.org");
                    if (ipv6 && ipv6.includes(":") && !isPrivateIP(ipv6)) {
                        setCache("ipv6", ipv6);
                    } else {
                        ipv6 = null;
                    }
                }

                if (ipv6Element && ipv6Wrapper) {
                    if (ipv6) {
                        ipv6Element.textContent = ipv6;
                        ipv6Wrapper.style.display = 'inline';
                    }
                }
            }

            // Run when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', resolve);
            } else {
                resolve();
            }
        })();
    </script>

    <!-- UI Event Handlers (FIX VUL-04: CSP Compliance) -->
    <script nonce="<?= htmlspecialchars($csp_nonce, ENT_QUOTES, 'UTF-8') ?>">
        (function () {
            document.addEventListener('DOMContentLoaded', function () {
                // 1. Language switcher
                const langSelect = document.getElementById('lang-select');
                if (langSelect) {
                    langSelect.addEventListener('change', function () {
                        if (window.I18n && typeof window.I18n.changeLang === 'function') {
                            window.I18n.changeLang(this.value);
                        }
                    });
                }

                // 2. Share input select
                const shareInput = document.getElementById('share-input');
                if (shareInput) {
                    shareInput.addEventListener('click', function () {
                        this.select();
                    });
                }

                // 3. Lazy thumb error handling (Global listener for error events on images)
                document.addEventListener('error', function (e) {
                    if (e.target && e.target.nodeName === 'IMG' && e.target.classList.contains('item-thumbnail')) {
                        const img = e.target;
                        const ext = img.dataset.ext || 'file';

                        // Fallback to SVG if DirectoryListingApp is available
                        const app = window.DirectoryListingApp || window.DirectoryListingApp; // Standard global name
                        if (app && typeof app.getSVGIcon === 'function') {
                            const svg = app.getSVGIcon(ext);
                            if (!img.nextElementSibling || !img.nextElementSibling.classList.contains('ui-icon')) {
                                img.insertAdjacentHTML('afterend', svg);
                            }
                            img.style.display = 'none'; // Hide instead of remove to avoid DOM shifting if re-rendered
                        } else {
                            // Basic fallback if app isn't ready
                            img.style.display = 'none';
                        }
                    }
                }, true); // Use capture phase to catch non-bubbling 'error' events
            });
        })();
    </script>
    <?= get_html_hook('body_end') ?>
</body>
<?= get_html_hook('html_end') ?>

</html>
<?php
/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * End index.php
 */
?>