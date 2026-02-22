/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * Begin i18n.js
 */

/**
 * Internationalization (i18n) Module
 */


(function () {
    'use strict';

    const I18n = {
        currentLang: 'en',
        translations: {},

        /**
         * Initialize i18n
         */
        init(lang) {
            this.currentLang = lang || 'en';

            const config = window.dirListingConfig || {};

            // Allow override of allowed languages from central config
            if (config.allowedLangs && Array.isArray(config.allowedLangs)) {
                this.allowedLangs = config.allowedLangs;
            }

            // Clear saved preferences if selector is hidden
            if (config.showLanguageSelector === false) {
                try {
                    localStorage.removeItem('dir_lang');
                    localStorage.removeItem('dirListing_language');
                } catch (e) { }
            }

            this.loadTranslations();
        },

        /**
         * Allowlist of supported language codes.
         * Must match server-side $allowed_langs in index.php.
         */
        allowedLangs: [],

        /**
         * Validate a language code against the allowlist.
         */
        isValidLang(lang) {
            return typeof lang === 'string' && this.allowedLangs.indexOf(lang) !== -1;
        },

        /**
         * Load translations from JSON file
         */
        async loadTranslations() {
            try {
                // FIX: Validate lang code before using it in a URL to prevent path traversal
                const safeLang = this.isValidLang(this.currentLang) ? this.currentLang : 'en';
                if (safeLang !== this.currentLang) {
                    console.warn('i18n: Invalid language code, falling back to en');
                    this.currentLang = 'en';
                }

                // If translations for this language are already loaded, just update UI
                if (this.translations[this.currentLang]) {
                    this.updateUI();
                    return;
                }

                const config = window.dirListingConfig || {};
                const assetsPath = config.assetsPath || './assets';

                if (assetsPath === 'embedded' || window.translations) {
                    // Use embedded translations if available
                    const embedded = window.translations || {};
                    if (embedded[this.currentLang]) {
                        this.translations[this.currentLang] = embedded[this.currentLang];
                    } else if (embedded['en']) {
                        // Fallback to embedded English if specific lang not found
                        this.translations[this.currentLang] = embedded['en'];
                    }
                } else {
                    // Load from JSON file
                    const response = await fetch(`${assetsPath}/lang/${safeLang}.json?v=${Date.now()}`);
                    if (!response.ok) throw new Error('HTTP ' + response.status);
                    this.translations[safeLang] = await response.json();
                }

                // Update UI with translations
                this.updateUI();
            } catch (error) {
                console.error('Failed to load translations:', error);
            }
        },

        /**
         * Get translation by key
         */
        t(key, lang) {
            lang = lang || this.currentLang;
            const translation = this.translations[lang];

            if (!translation) return key;

            // Support nested keys (e.g., "common.search")
            const keys = key.split('.');
            let value = translation;

            for (const k of keys) {
                if (value && typeof value === 'object' && k in value) {
                    value = value[k];
                } else {
                    return key;
                }
            }

            return value || key;
        },

        /**
         * Change language
         */
        async changeLang(lang) {
            // FIX: Reject invalid language codes to prevent open-redirect or path traversal
            if (!this.isValidLang(lang)) {
                console.warn('i18n: Attempted to change to invalid language:', lang);
                return;
            }
            if (lang === this.currentLang) return;

            this.currentLang = lang;

            // Load new translations
            await this.loadTranslations();

            // Load appropriate font
            this.loadFont(lang);

            // Save preference
            const config = window.dirListingConfig || {};
            if (config.showLanguageSelector !== false) {
                try {
                    localStorage.setItem('dirListing_language', lang);
                    // Save to cookie and local storage
                    document.cookie = `dir_lang=${lang}; path=/; max-age=31536000; SameSite=Lax`;
                    localStorage.setItem('dir_lang', lang);

                    console.log('Language changed to:', lang);
                } catch (e) {
                    console.error('Failed to save language preference:', e);
                }
            }

            // Update document lang attribute
            document.documentElement.setAttribute('lang', lang);
            document.body.setAttribute('data-lang', lang);
        },

        /**
         * Load font for specific language
         */
        loadFont(lang) {
            const fonts = {
                'vi': '&family=Be+Vietnam+Pro:wght@400;500;600;700',
                'zh': '&family=Noto+Sans+SC:wght@400;500;600;700',
                'zh-CN': '&family=Noto+Sans+SC:wght@400;500;600;700',
                'zh-TW': '&family=Noto+Sans+TC:wght@400;500;600;700',
                'zh-HK': '&family=Noto+Sans+TC:wght@400;500;600;700',
                'ja': '&family=Noto+Sans+JP:wght@400;500;600;700',
                'ko': '&family=Noto+Sans+KR:wght@400;500;600;700',
                'kr': '&family=Noto+Sans+KR:wght@400;500;600;700',
                'ar': '&family=Noto+Sans+Arabic:wght@400;500;600;700',
                'he': '&family=Noto+Sans+Hebrew:wght@400;500;600;700'
            };

            const base = "https://fonts.googleapis.com/css2?display=swap";
            let link = document.getElementById('main-font');

            if (fonts[lang]) {
                const url = base + fonts[lang];
                if (!link) {
                    link = document.createElement('link');
                    link.id = 'main-font';
                    link.rel = 'stylesheet';
                    document.head.appendChild(link);
                }
                link.href = url;
            } else {
                // If language uses system fonts (en, fr, de, etc.), remove the link if it exists
                if (link) {
                    link.remove();
                }
            }
        },

        /**
         * Update UI elements with translations
         */
        updateUI() {
            // Update elements with data-i18n attribute
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                const translation = this.t(key);

                // Only update if translation is different from key (i.e., translation exists)
                if (translation !== key) {
                    if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                        if (el.getAttribute('placeholder')) {
                            el.setAttribute('placeholder', translation);
                        } else {
                            el.value = translation;
                        }
                    } else {
                        el.textContent = translation;
                    }
                }
            });

            // Update elements with data-i18n-placeholder attribute
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                const translation = this.t(key);
                if (translation !== key) {
                    el.setAttribute('placeholder', translation);
                }
            });

            // Update elements with data-i18n-title attribute
            document.querySelectorAll('[data-i18n-title]').forEach(el => {
                const key = el.getAttribute('data-i18n-title');
                const translation = this.t(key);
                if (translation !== key) {
                    el.setAttribute('title', translation);
                }
            });

            // Update elements with data-i18n-aria-label attribute
            document.querySelectorAll('[data-i18n-aria-label]').forEach(el => {
                const key = el.getAttribute('data-i18n-aria-label');
                const translation = this.t(key);
                if (translation !== key) {
                    el.setAttribute('aria-label', translation);
                }
            });
        }
    };

    // Initialize
    const config = window.dirListingConfig || {};
    I18n.init(config.language || 'en');

    // Expose to window
    window.I18n = I18n;

})();

/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * End i18n.js
 */
