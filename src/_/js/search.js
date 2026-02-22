/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * Begin search.js
 */

/**
 * Search Module
 */


(function () {
    'use strict';

    const SearchManager = {
        searchInput: null,
        items: [],
        debounceTimer: null,

        /**
         * Initialize search
         */
        init() {
            this.searchInput = document.getElementById('search');
            if (!this.searchInput) return;

            // Cache items
            this.cacheItems();

            // Setup event listener
            this.searchInput.addEventListener('input', (e) => {
                this.handleSearch(e.target.value);
            });

            // Clear search on escape
            this.searchInput.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.clearSearch();
                }
            });
        },

        /**
         * Cache all file items
         */
        cacheItems() {
            const itemElements = document.querySelectorAll('.item');
            this.items = Array.from(itemElements).map(el => ({
                element: el,
                name: el.getAttribute('data-name') || '',
                type: el.getAttribute('data-type') || '',
            }));
        },

        /**
         * Handle search with debounce
         */
        handleSearch(query) {
            clearTimeout(this.debounceTimer);

            this.debounceTimer = setTimeout(() => {
                this.performSearch(query);
            }, 200);
        },

        /**
         * Perform the actual search
         */
        performSearch(query) {
            query = query.trim().toLowerCase();

            if (!query) {
                // Show all items
                this.items.forEach(item => {
                    item.element.style.display = '';
                    this.unhighlightItem(item.element);
                });
                return;
            }

            // Filter and highlight items
            let matchCount = 0;

            this.items.forEach(item => {
                const matches = item.name.toLowerCase().includes(query);

                if (matches) {
                    item.element.style.display = '';
                    this.highlightItem(item.element, query);
                    matchCount++;
                } else {
                    item.element.style.display = 'none';
                    this.unhighlightItem(item.element);
                }
            });

            // Update search result count
            this.updateResultCount(matchCount, this.items.length);
        },

        /**
         * Highlight matching text
         */
        highlightItem(element, query) {
            const nameElement = element.querySelector('.item-name');
            if (!nameElement) return;

            const originalText = nameElement.textContent;
            const escapedQuery = this.escapeRegex(query);
            const regex = new RegExp(`(${escapedQuery})`, 'gi');

            // First, escape the original text to prevent XSS
            const escapedText = this.escapeHTML(originalText);

            // Then apply highlighting to the escaped text
            const highlightedText = escapedText.replace(regex, '<mark style="background: var(--accent-light); padding: 0 2px; border-radius: 2px;">$1</mark>');

            nameElement.innerHTML = highlightedText;
        },

        /**
         * Escape HTML to prevent XSS
         */
        escapeHTML(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        },

        /**
         * Remove highlighting
         */
        unhighlightItem(element) {
            const nameElement = element.querySelector('.item-name');
            if (!nameElement) return;

            const originalText = element.getAttribute('data-name');
            if (originalText) {
                nameElement.textContent = originalText;
            }
        },

        /**
         * Update result count (optional UI feedback)
         */
        updateResultCount(matchCount, totalCount) {
            // You can implement a UI element to show "X of Y results"
            console.log(`Search results: ${matchCount} of ${totalCount}`);
        },

        /**
         * Clear search
         */
        clearSearch() {
            if (this.searchInput) {
                this.searchInput.value = '';
                this.performSearch('');
            }
        },

        /**
         * Escape special regex characters
         */
        escapeRegex(str) {
            return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => SearchManager.init());
    } else {
        SearchManager.init();
    }

    // Expose to window
    window.SearchManager = SearchManager;

})();

/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * End search.js
 */
