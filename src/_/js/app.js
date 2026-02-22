/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * Begin app.js
 */

/**
 * FileLister - Main Application
 */


(function () {
    'use strict';

    // Application state
    const App = {
        config: window.dirListingConfig || {},
        currentView: 'grid',
        currentTheme: 'auto',
        currentLang: 'en',
        currentSort: 'name_asc',
        currentFilter: 'all',
        themeSettings: {}, // Theme-specific settings
        items: [],

        // SVG Icon Cache (will be loaded on-demand)
        icons: {},
        pendingIcons: {}, // Track icons being loaded to avoid multiple requests

        // Emoji placeholders for progressive loading
        emojiMap: {
            'home': '🏠', 'folder': '📁', 'file': '📄', 'stats': '📊', 'storage': '💾',
            'monitor': '🖥️', 'download': '📥', 'share': '📤', 'info': 'ℹ️', 'help': '❓',
            'sun': '☀️', 'moon': '🌙', 'auto': '🌓', 'readme': '📖', 'empty': '📂',
            'reload': '🔄', 'close': '❌', 'search': '🔍', 'globe': '🌐', 'check': '✅',
            'copy': '📋', 'ocean': '🌊', 'forest': '🌲', 'dracula': '🧛', 'nord': '❄️',
            'high-contrast': '🌗', 'cute': '✨', 'image': '🖼️', 'video': '🎥', 'audio': '🎵',
            'pdf': '📕', 'word': '📘', 'excel': '📗', 'powerpoint': '📙', 'text': '📄', 'csv': '📊',
            'markdown': '📝', 'archive': '📦', 'code': '💻', 'config': '⚙️', 'database': '🗄️',
            'font': '🔤', 'executable': '🚀', 'book': '📚', 'php': '🐘', 'python': '🐍',
            'javascript': '📜', 'typescript': '📘', 'rust': '⚙️', 'go': '🐹', 'java': '☕',
            'cpp': '➕', 'ruby': '💎', 'swift': '🐦', 'csharp': '♯', 'kotlin': '🎯',
            'shell': '🐚', 'perl': '🐪'
        },

        // Icon Config Mappings
        iconMap: {
            'jpg': 'image', 'jpeg': 'image', 'png': 'image', 'gif': 'image', 'bmp': 'image', 'svg': 'image', 'webp': 'image', 'ico': 'image',
            'mp4': 'video', 'mkv': 'video', 'avi': 'video', 'mov': 'video', 'wmv': 'video', 'flv': 'video', 'webm': 'video',
            'mp3': 'audio', 'wav': 'audio', 'ogg': 'audio', 'flac': 'audio', 'aac': 'audio', 'm4a': 'audio',
            'pdf': 'pdf',
            'doc': 'word', 'docx': 'word', 'odt': 'word', 'rtf': 'word',
            'xls': 'excel', 'xlsx': 'excel', 'ods': 'excel', 'csv': 'csv',
            'ppt': 'powerpoint', 'pptx': 'powerpoint', 'odp': 'powerpoint',
            'txt': 'text', 'log': 'text', 'ini': 'text', 'conf': 'text', 'md': 'markdown',
            'zip': 'archive', 'rar': 'archive', '7z': 'archive', 'tar': 'archive', 'gz': 'archive', 'bz2': 'archive',
            'php': 'php', 'py': 'python', 'js': 'javascript', 'ts': 'typescript', 'rs': 'rust', 'go': 'go', 'java': 'java', 'cpp': 'cpp', 'c': 'cpp', 'h': 'cpp', 'cs': 'csharp', 'kt': 'kotlin', 'sh': 'shell', 'pl': 'perl', 'rb': 'ruby', 'swift': 'swift',
            'sql': 'database', 'db': 'database', 'sqlite': 'database',
            'json': 'code', 'xml': 'code', 'html': 'code', 'css': 'code', 'scss': 'code', 'yml': 'config', 'yaml': 'config',
            'exe': 'executable', 'msi': 'executable', 'bin': 'executable', 'app': 'executable',
            'ttf': 'font', 'otf': 'font', 'woff': 'font', 'woff2': 'font',
            'epub': 'book', 'mobi': 'book'
        },

        /**
         * Initialize the application
         */
        init() {
            const version = this.config.version || '1.5';
            console.log(
                `%c FileLister v${version} %c by TRONG.PRO `,
                'background: #3b82f6; color: white; padding: 4px; border-radius: 4px 0 0 4px; font-weight: bold;',
                'background: #1e293b; color: white; padding: 4px; border-radius: 0 4px 4px 0; font-weight: bold;'
            );
            // console.log(`FileLister initialized`);

            // Debug: Log initial config
            // console.log('Initial Config:', this.config);

            // Load saved preferences
            this.loadPreferences();

            // Cache DOM elements
            this.cacheElements();

            // Setup event listeners
            this.setupEventListeners();

            // Initialize view
            this.setView(this.currentView);

            // Initialize theme from server-rendered attribute (priority)
            const serverTheme = document.body.getAttribute('data-theme');
            if (serverTheme) {
                this.currentTheme = serverTheme;
                // console.log('Theme initialized from server:', serverTheme);
            }

            // Initialize theme
            this.setTheme(this.currentTheme);

            // Cache all items
            this.cacheItems();

            // Initialize Lazy Thumbs
            this.initLazyThumbs();

            // Sync I18n with loaded preference
            if (window.I18n && this.currentLang && window.I18n.currentLang !== this.currentLang) {
                // console.log('Syncing I18n language to:', this.currentLang);
                window.I18n.changeLang(this.currentLang);
            }

            // Sync dropdown UI to current language
            if (this.elements.langSelect && this.currentLang) {
                this.elements.langSelect.value = this.currentLang;
            }

            // Load bundled icons if available (Standalone build)
            if (window.uiIcons) {
                this.icons = Object.assign({}, this.icons, window.uiIcons);
            }

            // Load theme settings from config
            if (this.config.themeSettings) {
                this.themeSettings = this.config.themeSettings;
            }

            // Inject SVG Icons
            this.injectIcons();

            // Auto theme detection
            if (this.currentTheme === 'auto') {
                this.setupAutoTheme();
            }

            // Render Readme
            if (this.config.enableReadme && this.config.readme && window.marked) {
                this.renderReadme(this.config.readme);
            }

            // Initialize Export Manager
            if (this.config.enableExport) {
                window.ExportManager.init();
            }
        },

        /**
         * Get SVG Icon Markup
         */
        getSVGIcon(name, className = '') {
            // Resolve extension to icon type if needed
            let iconKey = name.toLowerCase();
            if (this.iconMap[iconKey]) iconKey = this.iconMap[iconKey];

            const cls = className ? ' ' + className : '';

            // If already loaded/cached
            if (this.icons[iconKey]) {
                const iconData = this.icons[iconKey];

                // If it's a legacy path (just string of M...), wrap it in a default 32x32 viewBox
                if (iconData.indexOf('<svg') === -1) {
                    return `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="ui-icon${cls}" width="1.2em" height="1.2em" fill="currentColor"><path d="${iconData}" /></svg>`;
                }

                // If it's a full SVG, ensure class is injected and size is controlled
                // Also ensure it has xmlns for compatibility if missing
                let finalSvg = iconData;
                if (finalSvg.indexOf('xmlns=') === -1) {
                    finalSvg = finalSvg.replace('<svg', '<svg xmlns="http://www.w3.org/2000/svg"');
                }
                return finalSvg.replace('<svg', `<svg class="ui-icon${cls}" width="1.2em" height="1.2em"`);
            }

            // Otherwise, return placeholder and trigger async load
            const placeholderId = `icon-pl-${iconKey}-${Math.random().toString(36).substr(2, 5)}`;
            this.loadIcon(iconKey, placeholderId, className);

            const emoji = this.emojiMap[iconKey] || '📄';
            return `<span id="${placeholderId}" class="ui-icon-placeholder${cls}" style="display:inline-flex; width:1em; height:1em; align-items:center; justify-content:center; font-style:normal; font-size: 0.9em; opacity: 0.7;">${emoji}</span>`;
        },

        /**
         * Load Icon Data Asynchronously
         */
        async loadIcon(iconKey, placeholderId, className) {
            // If already in bundle (Standalone) or pre-cached, use it
            if (this.icons[iconKey]) {
                this.updatePlaceholder(placeholderId, this.icons[iconKey], className);
                return;
            }

            // Check if already loading this icon to avoid duplicate requests
            if (this.pendingIcons[iconKey]) {
                this.pendingIcons[iconKey].push({ id: placeholderId, className });
                return;
            }

            this.pendingIcons[iconKey] = [{ id: placeholderId, className }];

            if (this.config.useEmbedded) return;

            try {
                // Determine icon path
                const assetsPath = this.config.assetsPath === 'embedded' ? '' : this.config.assetsPath;
                let iconPathsToCheck = [];

                // 1. Theme specific icon (if configured)
                if (this.currentTheme && this.themeSettings && this.themeSettings[this.currentTheme]) {
                    const themeConfig = this.themeSettings[this.currentTheme];
                    if (themeConfig.icon_set) {
                        iconPathsToCheck.push(`${assetsPath}/icons/${themeConfig.icon_set}/${iconKey}.svg`);
                    }
                }

                // 2. Default icon
                iconPathsToCheck.push(`${assetsPath}/icons/${iconKey}.svg`);

                let response = null;
                let loadedPath = '';

                // Try paths in order
                for (const path of iconPathsToCheck) {
                    try {
                        const res = await fetch(path);
                        if (res.ok) {
                            response = res;
                            loadedPath = path;
                            break;
                        }
                    } catch (e) {
                        // Continue to next path
                    }
                }

                if (!response || !response.ok) {
                    // Final fallback to generic file icon if not already trying it
                    if (iconKey !== 'file') {
                        delete this.pendingIcons[iconKey]; // Clear pending state for this failed key
                        return this.loadIcon('file', placeholderId, className);
                    }
                    throw new Error(`Icon ${iconKey} not found in [${iconPathsToCheck.join(', ')}]`);
                }

                let svgText = await response.text();

                // Normalization: Remove xml header, doctype, and width/height from <svg>
                // This makes it responsive and inject-friendly
                svgText = svgText.replace(/<\?xml.*?\?>/i, '')
                    .replace(/<!DOCTYPE.*?>/i, '')
                    .replace(/<!--.*?-->/sg, '')
                    .replace(/<svg\s+/i, '<svg ') // Normalize space
                    .replace(/width="[^"]*"/i, '')
                    .replace(/height="[^"]*"/i, '')
                    .trim();

                if (svgText) {
                    // Always store the full normalized SVG to preserve viewBox and other attributes
                    this.icons[iconKey] = svgText;

                    // Update all placeholders for this icon type
                    const pendingList = this.pendingIcons[iconKey];
                    pendingList.forEach(item => this.updatePlaceholder(item.id, svgText, item.className));
                }
            } catch (error) {
                // console.warn('Failed to load icon:', iconKey, error);
            } finally {
                delete this.pendingIcons[iconKey];
            }
        },

        /**
         * Update Placeholder with Icon
         */
        updatePlaceholder(placeholderId, iconData, className) {
            const el = document.getElementById(placeholderId);
            if (el) {
                const cls = className ? ' ' + className : '';
                let finalContent = '';

                if (iconData.indexOf('<svg') === -1) {
                    finalContent = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="ui-icon${cls}" width="1.2em" height="1.2em" fill="currentColor" style="animation: iconFadeIn 0.3s ease-out;"><path d="${iconData}" /></svg>`;
                } else {
                    let finalSvg = iconData;
                    if (finalSvg.indexOf('xmlns=') === -1) {
                        finalSvg = finalSvg.replace('<svg', '<svg xmlns="http://www.w3.org/2000/svg"');
                    }
                    finalContent = finalSvg.replace('<svg', `<svg class="ui-icon${cls}" width="1.2em" height="1.2em" style="animation: iconFadeIn 0.3s ease-out;"`);
                }
                el.outerHTML = finalContent;
            }
        },

        /**
         * Inject Icons into UI
         */
        injectIcons() {
            // 1. Inject into static elements (with data-icon)
            document.querySelectorAll('[data-icon]:not(.js-file-icon)').forEach(el => {
                const iconName = el.getAttribute('data-icon');
                el.innerHTML = this.getSVGIcon(iconName);
            });

            // 2. Inject into file items
            document.querySelectorAll('.js-file-icon').forEach(el => {
                const iconName = el.getAttribute('data-icon') || el.getAttribute('data-ext') || 'file';
                const svg = this.getSVGIcon(iconName);

                // Do not overwrite existing img tags (thumbnails) — SVG fallback is
                // handled by the img onerror handler in initLazyThumbs(), not here.
                if (!el.querySelector('img')) {
                    el.innerHTML = svg;
                }
            });

            // 3. Special: Theme Toggle (Dynamic)
            this.updateThemeIcon();
        },



        /**
         * Update Theme Icon
         */
        updateThemeIcon() {
            if (this.elements.themeToggle) {
                const iconContainer = this.elements.themeToggle.querySelector('.icon');
                if (iconContainer) {
                    const icons = {
                        'light': 'sun', 'dark': 'moon', 'ocean': 'ocean', 'forest': 'forest',
                        'dracula': 'dracula', 'nord': 'nord', 'high-contrast': 'high-contrast',
                        'cute': 'cute', 'auto': 'auto'
                    };
                    iconContainer.innerHTML = this.getSVGIcon(icons[this.currentTheme] || 'auto');
                }
            }
        },

        /**
         * Render Readme
         */
        renderReadme(content) {
            const container = document.getElementById('readme-container');
            const body = document.getElementById('readme-content');

            if (container && body) {
                try {
                    // Parse Markdown
                    const rawHtml = marked.parse(content);

                    // Sanitize HTML (Similar logic to preview.js)
                    const template = document.createElement('template');
                    template.innerHTML = rawHtml;
                    const sanitizedContent = template.content;

                    // 1. Remove dangerous elements
                    const dangerousElements = ['script', 'iframe', 'object', 'embed', 'form', 'base', 'meta', 'link', 'style', 'canvas', 'svg', 'math'];
                    dangerousElements.forEach(tag => {
                        sanitizedContent.querySelectorAll(tag).forEach(el => el.remove());
                    });

                    // 2. Clean attributes
                    sanitizedContent.querySelectorAll('*').forEach(el => {
                        for (let i = el.attributes.length - 1; i >= 0; i--) {
                            const attrName = el.attributes[i].name.toLowerCase();
                            if (attrName.startsWith('on')) {
                                el.removeAttribute(attrName);
                            }
                            else if (['href', 'src', 'data', 'cite', 'poster', 'action', 'formaction'].includes(attrName)) {
                                const val = el.attributes[i].value.toLowerCase().trim();
                                if (val.includes('javascript:') || val.includes('vbscript:')) {
                                    el.removeAttribute(attrName);
                                }
                            }
                        }
                    });

                    const div = document.createElement('div');
                    div.appendChild(sanitizedContent.cloneNode(true));

                    body.innerHTML = div.innerHTML;
                    container.style.display = 'block';

                    // Highlight code blocks if highlight.js is present (optional)
                    if (window.hljs) {
                        body.querySelectorAll('pre code').forEach((block) => {
                            hljs.highlightElement(block);
                        });
                    }
                } catch (e) {
                    console.error('Failed to render readme', e);
                }
            }
        },

        /**
         * Cache DOM elements
         */
        cacheElements() {
            this.elements = {
                body: document.body,
                fileItems: document.getElementById('file-items'),
                searchInput: document.getElementById('search'),
                sortSelect: document.getElementById('sort-select'),
                filterSelect: document.getElementById('filter-select'),
                themeToggle: document.getElementById('theme-toggle'),
                langSelect: document.getElementById('lang-select'),
                helpToggle: document.getElementById('help-toggle'),
                viewButtons: document.querySelectorAll('[data-action="change-view"]'),
            };
        },

        /**
         * Setup event listeners
         */
        setupEventListeners() {
            const { elements } = this;

            // View change buttons
            elements.viewButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const view = e.currentTarget.getAttribute('data-view');
                    this.setView(view);
                });
            });

            // Theme toggle (Delegated for persistence)
            document.addEventListener('click', (e) => {
                if (e.target.closest('#theme-toggle')) {
                    this.toggleTheme();
                }
            });

            // Language select handle (CSP compliant)
            if (elements.langSelect) {
                elements.langSelect.addEventListener('change', (e) => {
                    this.changeLanguage(e.target.value);
                });
            }

            // Help toggle (Delegated for persistence since .stats is replaced during AJAX nav)
            document.addEventListener('click', (e) => {
                if (e.target.closest('#help-toggle')) {
                    this.showHelp();
                }
            });

            // Sort select
            if (elements.sortSelect) {
                elements.sortSelect.addEventListener('change', (e) => {
                    this.sortItems(e.target.value);
                });
            }

            // Filter select
            if (elements.filterSelect) {
                elements.filterSelect.addEventListener('change', (e) => {
                    this.filterItems(e.target.value);
                });
            }

            // Close modal on overlay click
            document.querySelectorAll('[data-action="close-modal"]').forEach(el => {
                el.addEventListener('click', () => {
                    this.closeModal();
                });
            });

            // Preview links
            document.querySelectorAll('[data-action="preview"]').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const path = e.currentTarget.getAttribute('data-path');
                    const type = e.currentTarget.getAttribute('data-type');
                    // Get filename from item
                    const item = e.currentTarget.closest('.item');
                    const name = item ? item.getAttribute('data-name') : '';
                    this.showPreview(path, type, name);
                });
            });

            // Share buttons
            document.querySelectorAll('[data-action="share"]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const path = e.currentTarget.getAttribute('data-path');
                    this.shareFile(path);
                });
            });

            // Hash buttons
            document.querySelectorAll('[data-action="hash"]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const path = e.currentTarget.getAttribute('data-path');
                    const item = e.currentTarget.closest('.item');
                    const name = item ? item.getAttribute('data-name') : '';
                    this.showFileHash(path, name);
                });
            });

            // Escape key to close modal
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.closeModal();
                }
            });

            // Resize listener for Smart Background & Window Size
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                this.updateWindowSize(); // Realtime update for numbers
                resizeTimer = setTimeout(() => {
                    // Debounced update for heavy tasks
                    // this.updateBackgroundSizing(); // Removed as we use CSS now
                }, 100);
            });

            // Initial call
            this.updateWindowSize();

            // AJAX Navigation: Breadcrumb and Folder links
            document.addEventListener('click', (e) => {
                const link = e.target.closest('a');
                if (!link) return;

                const url = link.getAttribute('href');
                if (!url || url.startsWith('http') || url.startsWith('//') || url.startsWith('#')) return;

                // Check if it's a directory link (contains ?dir= or is root ?)
                const isDirLink = url === '?' || url.startsWith('?') || url === '.';
                const isPreview = link.hasAttribute('data-action') && link.getAttribute('data-action') === 'preview';

                if (isDirLink && !isPreview) {
                    e.preventDefault();
                    this.navigateTo(url);
                }
            });

            // Handle browser Back/Forward
            window.addEventListener('popstate', (e) => {
                this.navigateTo(window.location.search || '?', false);
            });
        },

        /**
         * AJAX Navigation
         */
        async navigateTo(url, pushState = true) {
            try {
                // Show loading state (optional: add a progress bar or spinner)
                const itemsContainer = this.elements.fileItems;
                if (itemsContainer) itemsContainer.style.opacity = '0.5';

                const response = await fetch(url);
                if (!response.ok) throw new Error('Network response was not ok');

                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // 1. Update Title
                document.title = doc.title;

                // 2. Update Stats
                const newStats = doc.querySelector('.stats');
                const oldStats = document.querySelector('.stats');
                if (newStats && oldStats) oldStats.innerHTML = newStats.innerHTML;

                // 3. Update Breadcrumb
                const newBreadcrumb = doc.querySelector('.breadcrumb');
                const oldBreadcrumb = document.querySelector('.breadcrumb');
                if (newBreadcrumb && oldBreadcrumb) {
                    oldBreadcrumb.innerHTML = newBreadcrumb.innerHTML;
                    oldBreadcrumb.style.display = '';
                } else if (newBreadcrumb && !oldBreadcrumb) {
                    // Breadcrumb appeared
                    const header = document.querySelector('header');
                    if (header) header.after(newBreadcrumb);
                } else if (!newBreadcrumb && oldBreadcrumb) {
                    // Breadcrumb disappeared (root)
                    oldBreadcrumb.style.display = 'none';
                }

                // 4. Update Main Content
                const newItems = doc.querySelector('#file-items');
                if (newItems && itemsContainer) {
                    itemsContainer.innerHTML = newItems.innerHTML;
                    itemsContainer.className = newItems.className;
                    itemsContainer.style.opacity = '1';
                }

                // 5. Update Readme
                const readmeContainer = document.getElementById('readme-container');
                const newReadmeContainer = doc.querySelector('#readme-container');
                if (newReadmeContainer && readmeContainer) {
                    readmeContainer.innerHTML = newReadmeContainer.innerHTML;
                    readmeContainer.style.display = newReadmeContainer.style.display;
                } else if (readmeContainer) {
                    readmeContainer.style.display = 'none';
                }

                // 6. Update window.dirListingConfig
                // Find the script that sets window.dirListingConfig
                const scripts = doc.querySelectorAll('script');
                scripts.forEach(script => {
                    if (script.textContent.includes('window.dirListingConfig =')) {
                        try {
                            // Use regex to reliably extract the JSON object
                            const match = script.textContent.match(/window\.dirListingConfig\s*=\s*(\{[\s\S]*?\});/);
                            if (match && match[1]) {
                                window.dirListingConfig = JSON.parse(match[1]);
                            }
                        } catch (e) {
                            console.error('Failed to update config during navigation', e);
                        }
                    }
                });

                // 7. Update state and push history
                if (pushState) {
                    window.history.pushState({}, '', url);
                }

                // 8. Re-initialize dynamic components
                this.cacheItems();
                this.initLazyThumbs();
                this.injectIcons();
                this.updateWindowSize();

                // Re-render Readme if updated config has it
                if (window.dirListingConfig.enableReadme && window.dirListingConfig.readme && window.marked) {
                    this.renderReadme(window.dirListingConfig.readme);
                }

                // Scroll to top
                window.scrollTo(0, 0);

                // Re-bind preview links (since they were replaced)
                this.rebindDynamicEvents();

                // Re-init ExportManager if enabled
                if (window.dirListingConfig.enableExport && window.ExportManager) {
                    window.ExportManager.init();
                }

            } catch (error) {
                console.error('Navigation failed:', error);
                window.location.href = url; // Fallback to full reload
            }
        },

        /**
         * Re-bind events for dynamically loaded content
         */
        rebindDynamicEvents() {
            // Preview links
            document.querySelectorAll('[data-action="preview"]').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const path = e.currentTarget.getAttribute('data-path');
                    const type = e.currentTarget.getAttribute('data-type');
                    const item = e.currentTarget.closest('.item');
                    const name = item ? item.getAttribute('data-name') : '';
                    this.showPreview(path, type, name);
                });
            });

            // Share buttons
            document.querySelectorAll('[data-action="share"]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const path = e.currentTarget.getAttribute('data-path');
                    this.shareFile(path);
                });
            });

            // Hash buttons
            document.querySelectorAll('[data-action="hash"]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const path = e.currentTarget.getAttribute('data-path');
                    const item = e.currentTarget.closest('.item');
                    const name = item ? item.getAttribute('data-name') : '';
                    this.showFileHash(path, name);
                });
            });

            // 4. Initialize Lazy Thumbs for new content
            this.initLazyThumbs();
        },

        /**
         * Update Window Size Display
         */
        updateWindowSize() {
            const el = document.getElementById('window-size-value');
            if (el) {
                el.textContent = `${window.innerWidth} x ${window.innerHeight}`;
            }
        },

        /**
         * Initialize Lazy Scroll Thumbnails (IntersectionObserver)
         */
        initLazyThumbs() {
            const lazyImages = document.querySelectorAll('.item-thumbnail');
            // console.log(`Lazy Loading: Found ${lazyImages.length} images to observe.`);

            if (!('IntersectionObserver' in window)) {
                lazyImages.forEach(img => {
                    if (img.dataset.thumb) img.src = img.dataset.thumb;
                });
                return;
            }

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        // console.log('Intersection detected:', img.alt);
                        if (img.dataset.thumb) {
                            img.classList.add('loading');
                            img.onload = () => {
                                img.classList.remove('loading');
                                img.classList.add('loaded');
                                // Remove data-thumb after successful load
                                img.removeAttribute('data-thumb');
                            };
                            img.onerror = () => {
                                img.classList.remove('loading');
                                // Trigger global error handler or handle here
                                const ext = img.dataset.ext || 'file';
                                if (window.DirectoryListingApp) {
                                    const svg = window.DirectoryListingApp.getSVGIcon(ext);
                                    if (!img.nextElementSibling || !img.nextElementSibling.classList.contains('ui-icon')) {
                                        img.insertAdjacentHTML('afterend', svg);
                                    }
                                    img.style.display = 'none';
                                }
                            };
                            img.src = img.dataset.thumb;
                            observer.unobserve(img);
                        }
                    }
                });
            }, {
                rootMargin: '100px 0px',
                threshold: 0.01
            });

            lazyImages.forEach(img => {
                observer.observe(img);
            });
        },

        /**
         * Cache all file items
         */
        cacheItems() {
            const itemElements = document.querySelectorAll('.item');
            this.items = Array.from(itemElements).map(el => ({
                element: el,
                name: el.getAttribute('data-name'),
                type: el.getAttribute('data-type'),
                size: parseInt(el.getAttribute('data-size')) || 0,
                date: parseInt(el.getAttribute('data-date')) || 0,
            }));
        },

        /**
         * Set view mode
         */
        setView(view) {
            if (!['grid', 'list', 'details'].includes(view)) {
                view = 'grid';
            }

            this.currentView = view;

            // Update body attribute
            this.elements.body.setAttribute('data-view', view);

            // Update items container class
            if (this.elements.fileItems) {
                this.elements.fileItems.className = `items view-${view}`;
            }

            // Update active button
            this.elements.viewButtons.forEach(btn => {
                if (btn.getAttribute('data-view') === view) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Save preference
            this.savePreference('viewMode', view);
            const secure = window.location.protocol === 'https:' ? '; Secure' : '';
            document.cookie = `dir_view=${view}; path=/; max-age=31536000; SameSite=Lax${secure}`;
        },

        /**
         * Set theme
         */
        setTheme(theme) {
            const allowedThemes = this.config.allowedThemes || ['light', 'dark', 'ocean', 'forest', 'dracula', 'nord', 'high-contrast', 'cute', 'auto'];
            if (!allowedThemes.includes(theme)) {
                theme = 'auto';
            }

            this.currentTheme = theme;

            // Apply theme
            if (theme === 'auto') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                this.elements.body.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
            } else {
                this.elements.body.setAttribute('data-theme', theme);
            }

            // Save preference
            this.savePreference('theme', theme);
            const secure = window.location.protocol === 'https:' ? '; Secure' : '';
            document.cookie = `dir_theme=${theme}; path=/; max-age=31536000; SameSite=Lax${secure}`;
            // console.log('Theme saved:', theme);

            // Update theme toggle icon
            this.updateThemeIcon();

            // Update external CSS link if in multi-file mode
            const themeLink = document.getElementById('theme-css');
            if (themeLink && this.config.assetsPath !== 'embedded') {
                const themeToLoad = theme === 'auto' ? 'light' : theme;
                themeLink.href = `${this.config.assetsPath}/css/themes/${themeToLoad}.css?v=${this.config.version}`;
            }
        },

        /**
         * Toggle theme
         */
        toggleTheme() {
            const themes = this.config.allowedThemes || ['light', 'dark', 'ocean', 'forest', 'dracula', 'nord', 'high-contrast', 'cute', 'auto'];
            const currentActualTheme = this.currentTheme === 'auto' ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') : this.currentTheme;
            const currentIndex = themes.indexOf(currentActualTheme);
            const nextIndex = (currentIndex + 1) % themes.length;
            this.setTheme(themes[nextIndex]);
        },

        /**
         * Setup auto theme detection
         */
        setupAutoTheme() {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', (e) => {
                if (this.currentTheme === 'auto') {
                    this.elements.body.setAttribute('data-theme', e.matches ? 'dark' : 'light');
                }
            });
        },

        /**
         * Sort items (Windows style: folders first, sorted separately)
         */
        sortItems(sortValue) {
            const [sortBy, order] = sortValue.split('_');
            this.currentSort = sortValue;

            // Separate folders and files
            const folders = this.items.filter(item => item.type === 'folder');
            const files = this.items.filter(item => item.type !== 'folder');

            // Sort comparison function
            const compare = (a, b) => {
                let result = 0;

                switch (sortBy) {
                    case 'name':
                        result = a.name.localeCompare(b.name);
                        break;
                    case 'size':
                        result = a.size - b.size;
                        break;
                    case 'date':
                        result = a.date - b.date;
                        break;
                    case 'type':
                        result = a.type.localeCompare(b.type);
                        break;
                }

                return order === 'desc' ? -result : result;
            };

            // Sort folders and files separately
            folders.sort(compare);
            files.sort(compare);

            // Merge: folders first, then files
            this.items = [...folders, ...files];

            // Re-render items
            this.renderItems();

            // Save preference
            this.savePreference('sortBy', sortValue);
        },



        /**
         * Filter items
         */
        filterItems(filterValue) {
            this.currentFilter = filterValue;

            this.items.forEach(item => {
                const show = filterValue === 'all' || item.type === filterValue;
                item.element.style.display = show ? '' : 'none';
            });

            // Save preference
            this.savePreference('filter', filterValue);
        },

        /**
         * Render items (re-order in DOM)
         */
        renderItems() {
            const container = this.elements.fileItems;
            if (!container) return;

            // Append items in new order
            this.items.forEach(item => {
                container.appendChild(item.element);
            });
        },

        /**
         * Show preview modal
         */
        showPreview(path, type, name) {
            const modal = document.getElementById('preview-modal');
            const content = document.getElementById('preview-content');
            const title = document.getElementById('preview-title');

            if (!modal || !content) return;

            // Update title
            if (title) {
                const baseTitle = window.I18n ? window.I18n.t('actions.preview') : 'Preview';
                if (name) {
                    title.textContent = `${baseTitle}: ${name}`;
                    title.removeAttribute('data-i18n'); // Prevent overwriting by translation updates
                } else {
                    title.textContent = baseTitle;
                    title.setAttribute('data-i18n', 'actions.preview');
                }
            }

            // Clear previous content
            content.innerHTML = '<p data-i18n="messages.loading">Loading preview...</p>';
            if (window.I18n) {
                const loadingP = content.querySelector('p');
                if (loadingP) loadingP.textContent = window.I18n.t('messages.loading');
            }

            // Show modal
            modal.style.display = 'flex';

            // Load preview based on type
            if (window.PreviewManager) {
                window.PreviewManager.loadPreview(path, type, content);
            } else {
                content.innerHTML = '<p data-i18n="actions.preview_not_available">Preview not available</p>';
                if (window.I18n) {
                    const p = content.querySelector('p');
                    if (p) p.textContent = window.I18n.t('actions.preview_not_available');
                }
            }
        },

        /**
         * Close modal
         */
        closeModal() {
            const modal = document.getElementById('preview-modal');
            if (modal) {
                modal.style.display = 'none';
            }
        },

        /**
         * Change language
         */
        changeLanguage(langCode) {
            this.currentLang = langCode;
            this.savePreference('language', langCode);

            // Update i18n if available
            if (window.I18n) {
                window.I18n.changeLang(langCode);
            }

            // Show notification
            const langNames = {
                'en': 'English',
                'vi': 'Tiếng Việt',
                'zh': '中文',
                'es': 'Español',
                'fr': 'Français',
                'de': 'Deutsch',
                'ja': '日本語',
                'ko': '한국어',
                'kr': '한국어',
                'it': 'Italiano',
                'nl': 'Nederlands',
                'sv': 'Svenska',
                'no': 'Norsk',
                'da': 'Dansk',
                'fi': 'Suomi',
                'he': 'עברית',
                'ar': 'العربية',
                'ru': 'Русский',
            };

            this.showNotification(`Language changed to ${langNames[langCode] || langCode}`);
        },

        /**
         * Show help and shortcuts
         */
        showHelp() {
            // Use shortcuts manager if available
            if (window.ShortcutsManager && window.ShortcutsManager.showHelp) {
                window.ShortcutsManager.showHelp();
            } else {
                // Fallback help content
                const helpContent = `
                    <div style="max-width: 600px;">
                        <h3 style="margin-bottom: 1rem;">Keyboard Shortcuts</h3>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tbody>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>/</kbd> or <kbd>Ctrl+F</kbd></td>
                                    <td style="padding: 0.5rem;">Focus search</td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>Esc</kbd></td>
                                    <td style="padding: 0.5rem;">Close modal / Unfocus search</td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>↑</kbd> <kbd>↓</kbd></td>
                                    <td style="padding: 0.5rem;">Navigate items</td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>Enter</kbd></td>
                                    <td style="padding: 0.5rem;">Open selected item</td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>g</kbd> <kbd>h</kbd></td>
                                    <td style="padding: 0.5rem;">Go to home</td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>g</kbd> <kbd>u</kbd></td>
                                    <td style="padding: 0.5rem;">Go up one level</td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>?</kbd></td>
                                    <td style="padding: 0.5rem;">Show this help</td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 style="margin-top: 2rem; margin-bottom: 1rem;">Features</h3>
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 0.5rem 0;">🔍 <strong>Search:</strong> Real-time file search</li>
                            <li style="padding: 0.5rem 0;">👁️ <strong>Preview:</strong> View images, videos, text, PDF</li>
                            <li style="padding: 0.5rem 0;">📱 <strong>Share:</strong> Get links and QR codes</li>
                            <li style="padding: 0.5rem 0;">🎨 <strong>Themes:</strong> Light, Dark, Ocean, Forest</li>
                            <li style="padding: 0.5rem 0;">🌍 <strong>Languages:</strong> 18 languages supported</li>
                            <li style="padding: 0.5rem 0;">📊 <strong>Views:</strong> Grid, List, Details</li>
                        </ul>
                    </div>
                `;

                const modal = document.getElementById('preview-modal');
                const content = document.getElementById('preview-content');
                const title = document.getElementById('preview-title');

                if (modal && content && title) {
                    title.textContent = window.I18n ? window.I18n.t('help') : 'Help & Shortcuts';
                    title.setAttribute('data-i18n', 'help');
                    content.innerHTML = helpContent;
                    
                    // Clear footer and add close button
                    const footer = modal.querySelector('.modal-footer');
                    if (footer) {
                        footer.innerHTML = '';
                        const closeBtn = document.createElement('button');
                        closeBtn.className = 'btn';
                        closeBtn.dataset.action = 'close-modal';
                        closeBtn.innerText = window.I18n ? window.I18n.t('actions.close') : 'Close';
                        closeBtn.onclick = () => {
                            modal.style.display = 'none';
                            content.innerHTML = '';
                        };
                        footer.appendChild(closeBtn);
                    }
                    
                    modal.style.display = 'flex';
                }
            }
        },

        /**
         * Show notification (toast message)
         */
        showNotification(message, duration = 3000) {
            // Remove existing notification
            const existing = document.getElementById('notification-toast');
            if (existing) {
                existing.remove();
            }

            // Create notification
            const notification = document.createElement('div');
            notification.id = 'notification-toast';
            notification.textContent = message;
            document.body.appendChild(notification);

            // Remove after duration
            setTimeout(() => {
                notification.style.animation = 'slideOutDown 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, duration);
        },

        /**
         * Share file
         */
        async shareFile(path) {
            // Encode each path segment to handle Unicode filenames correctly
            const encodedPath = path.split('/').map(seg => {
                try { seg = decodeURIComponent(seg); } catch (e) { /* already raw */ }
                return encodeURIComponent(seg);
            }).join('/');
            const url = window.location.origin + window.location.pathname + encodedPath;

            // Populate Modal
            const input = document.getElementById('share-input');
            const qrContainer = document.getElementById('qrcode-container');

            if (input) input.value = url;

            if (qrContainer && window.QRCodeGenerator) {
                window.QRCodeGenerator.render(qrContainer, url);
            }

            // Show Modal
            this.openShareModal();

            // Setup Copy Button
            const copyBtn = document.getElementById('copy-share-btn');
            if (copyBtn) {
                copyBtn.onclick = async () => {
                    try {
                        await navigator.clipboard.writeText(url);
                        const originalText = copyBtn.textContent;
                        copyBtn.textContent = '✅'; // Copied feedback
                        setTimeout(() => copyBtn.textContent = originalText, 2000);
                    } catch (err) {
                        console.error('Failed to copy', err);
                        input.select();
                        document.execCommand('copy');
                    }
                };
            }
        },

        openShareModal() {
            const modal = document.getElementById('share-modal');
            if (modal) {
                modal.style.display = 'flex'; // Use flex to center

                // Bind close button if not already
                const closeBtn = modal.querySelector('.close-btn');
                if (closeBtn) {
                    closeBtn.onclick = () => this.closeShareModal();
                }

                // Bind close on click outside
                modal.onclick = (e) => {
                    if (e.target === modal) this.closeShareModal();
                };
            }
        },

        closeShareModal() {
            const modal = document.getElementById('share-modal');
            if (modal) modal.style.display = 'none';
        },

        /**
         * Show File Hash
         */
        /**
         * Show File Hash (Progressive Loading)
         */
        async showFileHash(path, name) {
            const modal = document.getElementById('hash-modal');
            const loading = document.getElementById('hash-loading');
            const results = document.getElementById('hash-results');
            const error = document.getElementById('hash-error');
            const hashGrid = document.getElementById('hash-grid');

            if (!modal) return;

            // Reset state
            modal.style.display = 'flex';
            loading.style.display = 'none'; // We don't use global loading anymore
            results.style.display = 'block'; // Show grid immediately
            error.style.display = 'none';
            hashGrid.innerHTML = ''; // Clear previous

            // Set title
            const title = modal.querySelector('.modal-title');
            if (title) {
                const baseTitle = window.I18n ? window.I18n.t('actions.file_hashes') : 'File Hashes';
                if (name) {
                    title.textContent = `${baseTitle}: ${name}`;
                    title.removeAttribute('data-i18n');
                } else {
                    title.textContent = baseTitle;
                    title.setAttribute('data-i18n', 'actions.file_hashes');
                }
            }

            // Bind close
            const closeBtn = modal.querySelector('.close-btn');
            if (closeBtn) closeBtn.onclick = () => modal.style.display = 'none';
            modal.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; };

            // Define friendly names for hash types
            const hashLabels = {
                // MD Family
                'md2': 'MD2', 'md4': 'MD4', 'md5': 'MD5',

                // SHA-1
                'sha1': 'SHA-1',

                // SHA-2 Family
                'sha224': 'SHA-224', 'sha256': 'SHA-256', 'sha384': 'SHA-384', 'sha512': 'SHA-512',
                'sha512224': 'SHA-512/224', 'sha512256': 'SHA-512/256',

                // SHA-3 Family
                'sha3224': 'SHA3-224', 'sha3256': 'SHA3-256', 'sha3384': 'SHA3-384', 'sha3512': 'SHA3-512',

                // RIPEMD Family
                'ripemd128': 'RIPEMD-128', 'ripemd160': 'RIPEMD-160', 'ripemd256': 'RIPEMD-256', 'ripemd320': 'RIPEMD-320',

                // Tiger
                'tiger192': 'TIGER-192',

                // Others
                'whirlpool': 'WHIRLPOOL',

                // CRC Family
                'crc32': 'CRC32', 'crc32b': 'CRC32B', 'crc32c': 'CRC32C',

                // Adler
                'adler32': 'ADLER32',

                // XXHash Family
                'xxh32': 'XXH32', 'xxh64': 'XXH64', 'xxh3': 'XXH3', 'xxh128': 'XXH128',

                // FNV Family
                'fnv132': 'FNV1-32', 'fnv1a32': 'FNV1A-32', 'fnv164': 'FNV1-64', 'fnv1a64': 'FNV1A-64',

                // MurmurHash Family
                'murmur3a': 'MURMUR3A', 'murmur3c': 'MURMUR3C', 'murmur3f': 'MURMUR3F',
            };

            // Get enabled hash types from config (default to md5, sha1, sha256 only if undefined)
            const enabledHashes = this.config.enabledHashTypes || ['md5', 'sha1', 'sha256'];

            // 1. Create UI for all hashes first (Loading state)
            enabledHashes.forEach(hashType => {
                const row = document.createElement('div');
                row.className = 'hash-row';
                row.setAttribute('data-hash', hashType); // Mark row for update

                const labelContainer = document.createElement('div');
                labelContainer.className = 'hash-label';

                const labelText = document.createElement('span');
                labelText.textContent = hashLabels[hashType] || hashType.toUpperCase();

                const copyBtn = document.createElement('button');
                copyBtn.className = 'copy-hash-btn';
                copyBtn.title = 'Copy ' + (hashLabels[hashType] || hashType.toUpperCase());
                copyBtn.innerHTML = this.getSVGIcon('copy', 'icon');
                copyBtn.disabled = true; // Disable until loaded
                copyBtn.style.opacity = '0.3';

                labelContainer.appendChild(labelText);
                labelContainer.appendChild(copyBtn);

                const value = document.createElement('div');
                value.className = 'hash-value';

                // Spinner for this specific hash
                value.innerHTML = `${this.getSVGIcon('reload', 'icon spin')} <span style="font-size: 12px; color: var(--text-muted);">Calculating...</span>`;

                row.appendChild(labelContainer);
                row.appendChild(value);
                hashGrid.appendChild(row);
            });

            // 2. Fetch hashes (Hybrid Strategy: Bulk Check -> Progressive Fill)

            // Step A: Attempt to get cached hashes in one go
            let cachedHashes = {};
            try {
                const response = await fetch(`?hash=${encodeURIComponent(path)}`);
                const data = await response.json();
                if (!data.error) {
                    cachedHashes = data;
                }
            } catch (e) {
                console.error('Failed to check cache', e);
            }

            // Step B: Update UI for any cached hashes found
            const loadedAlgos = [];
            enabledHashes.forEach(hashType => {
                // Normalize keys for case-insensitive matching
                // The API returns lower-case keys (md5, sha1, etc)
                // config.enabledHashTypes might be mixed case
                const key = hashType.toLowerCase();

                if (cachedHashes[key]) {
                    const row = hashGrid.querySelector(`[data-hash="${hashType}"]`);
                    const valueContainer = row.querySelector('.hash-value');
                    const copyBtn = row.querySelector('.copy-hash-btn');

                    const hashValue = cachedHashes[key];
                    this.updateHashRow(row, valueContainer, copyBtn, hashValue);
                    loadedAlgos.push(hashType);
                }
            });

            // Step C: Fetch missing hashes individually (Progressive Loading)
            const missingAlgos = enabledHashes.filter(algo => !loadedAlgos.includes(algo));

            missingAlgos.forEach(async (hashType) => {
                const row = hashGrid.querySelector(`[data-hash="${hashType}"]`);
                const valueContainer = row.querySelector('.hash-value');
                const copyBtn = row.querySelector('.copy-hash-btn');

                try {
                    // Fetch individual hash
                    const response = await fetch(`?hash=${encodeURIComponent(path)}&algo=${hashType}`);
                    const data = await response.json();

                    if (data.error) {
                        // FIX: Use textContent (not innerHTML) to prevent XSS from server error messages
                        const errSpan = document.createElement('span');
                        errSpan.style.cssText = 'color: var(--danger-color); font-size: 12px;';
                        errSpan.textContent = 'Error: ' + data.error;
                        valueContainer.innerHTML = '';
                        valueContainer.appendChild(errSpan);
                    } else if (data[hashType]) {
                        // Update UI with result
                        this.updateHashRow(row, valueContainer, copyBtn, data[hashType]);
                    }
                } catch (err) {
                    const errSpan = document.createElement('span');
                    errSpan.style.cssText = 'color: var(--danger-color); font-size: 12px;';
                    errSpan.textContent = 'Failed';
                    valueContainer.innerHTML = '';
                    valueContainer.appendChild(errSpan);
                }
            });
        },

        /**
         * Helper to update hash row UI
         */
        updateHashRow(row, valueContainer, copyBtn, hashValue) {
            valueContainer.innerHTML = '';

            const code = document.createElement('code');
            code.textContent = hashValue;
            code.style.cssText = 'word-break: break-all; cursor: pointer;';
            code.title = 'Click to copy';

            const copyFunction = () => {
                navigator.clipboard.writeText(hashValue).then(() => {
                    const originalHTML = copyBtn.innerHTML;
                    copyBtn.innerHTML = this.getSVGIcon('check', 'icon');
                    copyBtn.classList.add('copied');
                    setTimeout(() => {
                        copyBtn.innerHTML = originalHTML;
                        copyBtn.classList.remove('copied');
                    }, 2000);
                });
            };

            code.onclick = copyFunction;
            copyBtn.onclick = copyFunction;
            copyBtn.disabled = false;
            copyBtn.style.opacity = '1';

            valueContainer.appendChild(code);
        },

        /**
         * Copy text to clipboard
         */
        copyToClipboard(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    this.showNotification(window.I18n ? window.I18n.t('actions.copied') : 'Copied!');
                }).catch(err => {
                    console.error('Failed to copy:', err);
                    this.fallbackCopyToClipboard(text);
                });
            } else {
                this.fallbackCopyToClipboard(text);
            }
        },

        /**
         * Fallback copy to clipboard
         */
        fallbackCopyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                this.showNotification(window.I18n ? window.I18n.t('actions.copied') : 'Copied!');
            } catch (err) {
                console.error('Failed to copy:', err);
                this.showNotification(window.I18n ? window.I18n.t('messages.error') : 'Copy failed');
            }
            document.body.removeChild(textarea);
        },

        /**
         * Save preference to localStorage
         */
        savePreference(key, value) {
            try {
                localStorage.setItem('dirListing_' + key, value);
            } catch (e) {
                console.error('Failed to save preference:', e);
            }
        },

        /**
         * Load preferences
         */
        loadPreferences() {
            // Load view mode (priority: cookie > localStorage > default)
            // Note: Cookie is handled by PHP for initial render, but we sync JS here too
            const viewCookie = document.cookie.split('; ').find(row => row.startsWith('dir_view='));
            const view = viewCookie ? viewCookie.split('=')[1] : localStorage.getItem('dirListing_viewMode');

            if (view && ['grid', 'list'].includes(view)) {
                this.currentView = view;
            } else if (this.config.viewMode && ['grid', 'list'].includes(this.config.viewMode)) {
                // Fallback to server/config default if no preference found
                this.currentView = this.config.viewMode;
            }

            // Load theme
            // (Theme is handled in init via cookie, but we can sync here if needed)
            const theme = localStorage.getItem('dirListing_theme');
            const allowedThemesForPref = this.config.allowedThemes || ['light', 'dark', 'ocean', 'forest', 'dracula', 'nord', 'high-contrast', 'cute', 'auto'];
            if (theme && allowedThemesForPref.includes(theme)) {
                this.currentTheme = theme;
            }

            // Load sort
            const sort = localStorage.getItem('dir_sort');
            if (sort) this.currentSort = sort;

            // Load filter
            const filter = localStorage.getItem('dir_filter');
            if (filter) this.currentFilter = filter;

            // Load language
            const lang = localStorage.getItem('dir_lang');
            if (lang) {
                this.currentLang = lang;
            } else if (this.config.language) {
                this.currentLang = this.config.language;
            }

            // console.log('Preferences Loaded:', {
            //     view: this.currentView,
            //     theme: this.currentTheme,
            //     lang: this.currentLang,
            //     sort: this.currentSort,
            //     filter: this.currentFilter
            // });
        }
    };

    // Initialize app when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => App.init());
    } else {
        App.init();
    }

    // Expose App to window for external access
    window.DirectoryListingApp = App;

    // ========================================================================
    // EXPORT MANAGER
    // Handles "Copy List" button, format dropdown, download link, and ?export= URL.
    // ========================================================================
    const ExportManager = {
        /** Supported formats and their MIME types */
        FORMATS: {
            json: 'application/json',
            csv: 'text/csv',
            tsv: 'text/tab-separated-values',
            ndjson: 'application/x-ndjson',
        },

        /** CSV/TSV column order */
        FIELDS: ['name', 'type', 'ext', 'size', 'sizeFmt', 'modified', 'date', 'url'],

        init() {
            const copyBtn = document.getElementById('copy-list-btn');
            const formatSel = document.getElementById('export-format-select');
            const downloadBtn = document.getElementById('download-list-btn');

            if (!copyBtn || !formatSel) return;

            // ── Copy to clipboard ────────────────────────────────────────────
            copyBtn.addEventListener('click', async () => {
                const format = formatSel.value;
                const text = this.buildOutput(format);
                if (!text) return;

                try {
                    await navigator.clipboard.writeText(text);
                    this._feedback(copyBtn, true);
                } catch {
                    // Fallback for browsers without clipboard API
                    this._fallbackCopy(text);
                    this._feedback(copyBtn, true);
                }
            });

            // ── Download link ─────────────────────────────────────────────────
            if (downloadBtn) {
                // Update href whenever format changes
                const updateDownloadHref = () => {
                    const format = formatSel.value;
                    const config = window.dirListingConfig || {};
                    const dir = encodeURIComponent(config.currentDir || '');
                    downloadBtn.href = `?${dir ? 'dir=' + dir + '&' : ''}export=${format}&download`;
                };
                formatSel.addEventListener('change', updateDownloadHref);
                updateDownloadHref(); // set initial href
            }

            // ── Handle ?export= URL parameter ────────────────────────────────
            // If user lands on ?export=csv (no &download), JS copies to clipboard
            // automatically (the PHP handler already sent the download response for
            // ?export=csv&download; this branch handles clipboard-only requests).
            const params = new URLSearchParams(window.location.search);
            const autoFormat = params.get('export');
            if (autoFormat && this.FORMATS[autoFormat] && !params.has('download')) {
                // Small delay so DOM items are rendered
                setTimeout(() => {
                    const text = this.buildOutput(autoFormat);
                    if (text && navigator.clipboard) {
                        navigator.clipboard.writeText(text).then(() => {
                            if (window.DirectoryListingApp && window.DirectoryListingApp.showNotification) {
                                window.DirectoryListingApp.showNotification(
                                    `Copied ${autoFormat.toUpperCase()} list to clipboard`
                                );
                            }
                        });
                    }
                }, 200);
            }
        },

        // ── Core: read visible items from DOM ────────────────────────────────
        /**
         * Collect all currently VISIBLE .item elements and extract their data.
         * "Visible" means not hidden by the filter (style.display !== 'none').
         * @returns {Array<Object>}
         */
        collectItems() {
            const items = document.querySelectorAll('#file-items .item');
            const rows = [];

            items.forEach(el => {
                // Skip hidden items (filtered out)
                if (el.style.display === 'none') return;

                rows.push({
                    name: el.getAttribute('data-name') || '',
                    type: el.getAttribute('data-is-dir') === '1' ? 'folder' : 'file',
                    ext: el.getAttribute('data-ext') || '',
                    size: el.getAttribute('data-size') || '0',
                    sizeFmt: el.getAttribute('data-size-fmt') || '',
                    modified: el.getAttribute('data-date') || '',
                    date: el.getAttribute('data-date-fmt') || '',
                    // Prefer raw path (data-path) and resolve to absolute URL
                    url: (function () {
                        const path = el.getAttribute('data-path') || el.getAttribute('data-url') || '';
                        if (!path) return '';
                        // Resolve against current location (stripping query string)
                        try {
                            // Ensure base ends with slash if it's a directory, but here pathname is script or dir
                            // If index.php is in URL, dirname is needed. If pretty URL, might be different.
                            // SAFEST: window.location.origin + window.location.pathname (minus script name if present?)
                            // Actually, data-path is relative to lister root.
                            // index.php usually sits at root or subdirectory. 
                            // Let's assume window.location.href is the base.
                            const base = window.location.origin + window.location.pathname;
                            // Remove filename (index.php) from base if present
                            const cleanBase = base.substring(0, base.lastIndexOf('/') + 1);
                            return new URL(path, cleanBase).href;
                        } catch (e) { return path; }
                    })(),
                });
            });

            return rows;
        },

        // ── Format builders ───────────────────────────────────────────────────
        buildOutput(format) {
            const rows = this.collectItems();
            if (!rows.length) return '';

            switch (format) {
                case 'json': return this._toJSON(rows);
                case 'csv': return this._toDelimited(rows, ',');
                case 'tsv': return this._toDelimited(rows, '\t');
                case 'ndjson': return this._toNDJSON(rows);
                default: return this._toJSON(rows);
            }
        },

        _toJSON(rows) {
            return JSON.stringify(rows, null, 2);
        },

        _toNDJSON(rows) {
            return rows.map(r => JSON.stringify(r)).join('\n');
        },

        /**
         * RFC 4180-compliant CSV / TSV serializer.
         * - CSV: all values double-quoted; inner quotes doubled.
         * - TSV: values unquoted; tabs and newlines stripped.
         */
        _toDelimited(rows, sep) {
            const isCSV = sep === ',';
            const headers = ['name', 'type', 'ext', 'size', 'size_formatted',
                'modified', 'date', 'url'];

            const escape = (val) => {
                const str = String(val ?? '');
                if (isCSV) {
                    return '"' + str.replace(/"/g, '""') + '"';
                }
                return str.replace(/[\t\n\r]/g, ' ');
            };

            const headerRow = isCSV
                ? headers.map(h => '"' + h + '"').join(sep)
                : headers.join(sep);

            const dataRows = rows.map(r => [
                escape(r.name),
                escape(r.type),
                escape(r.ext),
                escape(r.size),
                escape(r.sizeFmt),
                escape(r.modified),
                escape(r.date),
                escape(r.url),
            ].join(sep));

            return [headerRow, ...dataRows].join('\r\n');
        },

        // ── UI helpers ────────────────────────────────────────────────────────
        /**
         * Briefly animate the copy button to confirm success or failure.
         */
        _feedback(btn, success) {
            const originalHTML = btn.innerHTML;
            const icon = window.DirectoryListingApp
                ? window.DirectoryListingApp.getSVGIcon(success ? 'check' : 'close', 'icon')
                : (success ? '✅' : '❌');

            const i18n = window.I18n || { t: (k) => k };
            const copiedText = i18n.t('actions.copied');
            const failedText = i18n.t('messages.error') || 'Failed';

            btn.innerHTML = icon + '<span class="text"> ' + (success ? copiedText : failedText) + '</span>';
            btn.disabled = true;
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }, 2000);
        },

        /**
         * execCommand fallback for browsers without navigator.clipboard.
         */
        _fallbackCopy(text) {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.cssText = 'position:fixed;top:-9999px;left:-9999px;opacity:0;';
            document.body.appendChild(ta);
            ta.focus();
            ta.select();
            try { document.execCommand('copy'); } catch { }
            document.body.removeChild(ta);
        },
    };

    window.ExportManager = ExportManager;

})();

/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * End app.js
 */
