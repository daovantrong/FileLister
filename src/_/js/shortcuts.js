/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * Begin shortcuts.js
 */

/**
 * Keyboard Shortcuts Module
 */


(function () {
    'use strict';

    const ShortcutsManager = {
        shortcuts: {
            '/': 'focusSearch',
            'Escape': 'closeModal',
            'g+h': 'goHome',
            'g+u': 'goUp',
            '?': 'showHelp',
            'ArrowUp': 'navigateUp',
            'ArrowDown': 'navigateDown',
            'Enter': 'openSelected',
        },

        currentIndex: -1,
        items: [],
        sequenceKeys: [],
        sequenceTimer: null,

        /**
         * Initialize shortcuts
         */
        init() {
            document.addEventListener('keydown', (e) => {
                this.handleKeydown(e);
            });

            this.cacheItems();
        },

        /**
         * Cache all file items
         */
        cacheItems() {
            this.items = Array.from(document.querySelectorAll('.item'));
        },

        /**
         * Handle keydown event
         */
        handleKeydown(e) {
            // Ignore if typing in input/textarea
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                if (e.key !== 'Escape') return;
            }

            // Handle key sequences (like "g+h")
            if (this.sequenceKeys.length > 0) {
                this.sequenceKeys.push(e.key);
                const sequence = this.sequenceKeys.join('+');

                if (this.shortcuts[sequence]) {
                    e.preventDefault();
                    this.executeAction(this.shortcuts[sequence]);
                    this.resetSequence();
                    return;
                }

                // Reset if sequence is getting too long
                if (this.sequenceKeys.length > 2) {
                    this.resetSequence();
                }
                return;
            }

            // Check for sequence start (like "g")
            if (e.key === 'g') {
                e.preventDefault();
                this.sequenceKeys.push('g');
                this.startSequenceTimer();
                return;
            }

            // Handle single key shortcuts
            const key = e.key;
            if (this.shortcuts[key]) {
                if (key !== 'ArrowUp' && key !== 'ArrowDown') {
                    e.preventDefault();
                }
                this.executeAction(this.shortcuts[key]);
            }

            // Ctrl/Cmd combinations
            if (e.ctrlKey || e.metaKey) {
                if (e.key === 'f') {
                    e.preventDefault();
                    this.executeAction('focusSearch');
                } else if (e.key === 'a') {
                    e.preventDefault();
                    this.executeAction('selectAll');
                }
            }
        },

        /**
         * Execute action
         */
        executeAction(action) {
            switch (action) {
                case 'focusSearch':
                    this.focusSearch();
                    break;
                case 'closeModal':
                    this.closeModal();
                    break;
                case 'goHome':
                    this.goHome();
                    break;
                case 'goUp':
                    this.goUp();
                    break;
                case 'showHelp':
                    this.showHelp();
                    break;
                case 'navigateUp':
                    this.navigateUp();
                    break;
                case 'navigateDown':
                    this.navigateDown();
                    break;
                case 'openSelected':
                    this.openSelected();
                    break;
                case 'selectAll':
                    this.selectAll();
                    break;
            }
        },

        /**
         * Focus search input
         */
        focusSearch() {
            const searchInput = document.getElementById('search');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        },

        /**
         * Close modal
         */
        closeModal() {
            const modal = document.getElementById('preview-modal');
            if (modal && modal.style.display !== 'none') {
                modal.style.display = 'none';
            } else {
                // Blur search if focused
                const searchInput = document.getElementById('search');
                if (searchInput && document.activeElement === searchInput) {
                    searchInput.blur();
                }
            }
        },

        /**
         * Go to home directory
         */
        goHome() {
            window.location.href = window.location.pathname;
        },

        /**
         * Go up one level
         */
        goUp() {
            const breadcrumb = document.querySelectorAll('.breadcrumb-item');
            if (breadcrumb.length > 1) {
                breadcrumb[breadcrumb.length - 2].click();
            } else {
                this.goHome();
            }
        },

        /**
         * Show keyboard shortcuts help
         */
        showHelp() {
            const config = window.dirListingConfig || {};
            const lang = config.language || 'en';

            // Try to get translations if I18n is available
            const i18n = window.I18n || { translations: {} };
            const t = (key) => {
                const parts = key.split('.');
                let current = i18n.translations[lang] || {};
                for (const part of parts) {
                    if (current[part] === undefined) return key;
                    current = current[part];
                }
                return current;
            };

            let helpContent = `
                <div style="max-width: 600px;">
                    <h4 style="margin: 0 0 0.5rem 0;">${t('shortcuts.keyboard_title')}</h4>
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 2rem;">
                        <tbody>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>/</kbd> or <kbd>Ctrl+F</kbd></td>
                                <td style="padding: 0.5rem;">${t('shortcuts.search')}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>Esc</kbd></td>
                                <td style="padding: 0.5rem;">${t('shortcuts.escape')}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>↑</kbd> <kbd>↓</kbd></td>
                                <td style="padding: 0.5rem;">${t('shortcuts.arrows')}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>Enter</kbd></td>
                                <td style="padding: 0.5rem;">${t('shortcuts.enter')}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>g</kbd> <kbd>h</kbd></td>
                                <td style="padding: 0.5rem;">${t('shortcuts.go_home')}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>g</kbd> <kbd>u</kbd></td>
                                <td style="padding: 0.5rem;">${t('shortcuts.go_up')}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>?</kbd></td>
                                <td style="padding: 0.5rem;">${t('shortcuts.show_help')}</td>
                            </tr>
                        </tbody>
                    </table>
            `;

            if (config.enableExport) {
                helpContent += `
                    <h4 style="margin: 1.5rem 0 0.5rem 0;">${t('shortcuts.export_title')}</h4>
                    <p style="margin-bottom: 1rem; color: var(--text-muted); font-size: 0.9rem;">${t('shortcuts.export_desc')}</p>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>?export=json</kbd></td>
                                <td style="padding: 0.5rem;">${t('shortcuts.format_json')}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>?export=csv</kbd></td>
                                <td style="padding: 0.5rem;">${t('shortcuts.format_csv')}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>?export=tsv</kbd></td>
                                <td style="padding: 0.5rem;">${t('shortcuts.format_tsv')}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 0.5rem; font-family: var(--font-mono); font-weight: 600;"><kbd>?export=ndjson</kbd></td>
                                <td style="padding: 0.5rem;">${t('shortcuts.format_ndjson')}</td>
                            </tr>
                        </tbody>
                    </table>
                `;
            }

            helpContent += `</div>`;

            const modal = document.getElementById('preview-modal');
            const content = document.getElementById('preview-content');
            const title = document.getElementById('preview-title');

            if (modal && content) {
                title.textContent = t('shortcuts.title');
                content.innerHTML = helpContent;
                
                // Clear footer and add close button
                const footer = modal.querySelector('.modal-footer');
                if (footer) {
                    footer.innerHTML = '';
                    const closeBtn = document.createElement('button');
                    closeBtn.className = 'btn';
                    closeBtn.dataset.action = 'close-modal';
                    closeBtn.innerText = t('actions.close') || 'Close';
                    closeBtn.onclick = () => {
                        modal.style.display = 'none';
                        content.innerHTML = '';
                    };
                    footer.appendChild(closeBtn);
                }
                
                modal.style.display = 'flex';
            }
        },

        /**
         * Navigate up in item list
         */
        navigateUp() {
            if (this.items.length === 0) return;

            this.currentIndex = Math.max(0, this.currentIndex - 1);
            this.highlightItem(this.currentIndex);
        },

        /**
         * Navigate down in item list
         */
        navigateDown() {
            if (this.items.length === 0) return;

            this.currentIndex = Math.min(this.items.length - 1, this.currentIndex + 1);
            this.highlightItem(this.currentIndex);
        },

        /**
         * Highlight item at index
         */
        highlightItem(index) {
            // Remove previous highlight
            this.items.forEach(item => {
                item.style.outline = '';
                item.style.outlineOffset = '';
            });

            // Add highlight to current
            if (this.items[index]) {
                this.items[index].style.outline = '2px solid var(--accent-primary)';
                this.items[index].style.outlineOffset = '2px';
                this.items[index].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        },

        /**
         * Open selected item
         */
        openSelected() {
            if (this.currentIndex >= 0 && this.items[this.currentIndex]) {
                const link = this.items[this.currentIndex].querySelector('a');
                if (link) {
                    link.click();
                }
            }
        },

        /**
         * Select all items (stub for future implementation)
         */
        selectAll() {
            // console.log('Select all - not implemented yet');
        },

        /**
         * Start sequence timer
         */
        startSequenceTimer() {
            clearTimeout(this.sequenceTimer);
            this.sequenceTimer = setTimeout(() => {
                this.resetSequence();
            }, 1000);
        },

        /**
         * Reset key sequence
         */
        resetSequence() {
            this.sequenceKeys = [];
            clearTimeout(this.sequenceTimer);
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            const config = window.dirListingConfig || {};
            if (config.enableShortcuts !== false) {
                ShortcutsManager.init();
            }
        });
    } else {
        const config = window.dirListingConfig || {};
        if (config.enableShortcuts !== false) {
            ShortcutsManager.init();
        }
    }

    // Expose to window
    window.ShortcutsManager = ShortcutsManager;

})();

/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * End shortcuts.js
 */
