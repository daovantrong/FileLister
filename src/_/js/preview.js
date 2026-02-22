/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * Begin preview.js
 */

/**
 * File Preview Module
 */


(function () {
    'use strict';

    const PreviewManager = {
        /**
         * Load preview based on file type
         */
        loadPreview(path, type, container) {
            switch (type) {
                case 'image':
                    this.previewImage(path, container);
                    break;
                case 'video':
                    this.previewVideo(path, container);
                    break;
                case 'audio':
                    this.previewAudio(path, container);
                    break;
                case 'pdf':
                    this.previewPDF(path, container);
                    break;
                case 'text':
                case 'markdown':
                case 'code':
                case 'javascript':
                case 'typescript':
                case 'php':
                case 'python':
                case 'ruby':
                case 'java':
                case 'cpp':
                case 'csharp':
                case 'swift':
                case 'go':
                case 'rust':
                case 'kotlin':
                case 'perl':
                case 'shell':
                case 'database':
                case 'config':
                    this.previewText(path, container);
                    break;
                default:
                    this.previewDefault(path, container);
            }
        },

        /**
         * Preview image
         */

        /**
         * Helper to render footer controls
         */
        renderFooterControls(path, extraButtons = []) {
            const footer = document.querySelector('#preview-modal .modal-footer');
            if (!footer) return;

            footer.innerHTML = '';

            // Appends extra buttons (like Zoom)
            extraButtons.forEach(btn => footer.appendChild(btn));

            // Helper to render buttons
            const createBtn = (text, onClick, className = 'btn btn-sm') => {
                const btn = document.createElement('button');
                btn.className = className;
                btn.innerHTML = text;
                btn.onclick = onClick;
                btn.style.marginRight = '5px';
                return btn;
            };

            // Download
            const downloadBtn = document.createElement('a');
            downloadBtn.href = path;
            downloadBtn.download = '';
            downloadBtn.className = 'btn btn-sm';
            downloadBtn.innerHTML = '📥 ' + (window.I18n ? window.I18n.t('actions.download') : 'Download');
            downloadBtn.style.marginRight = '5px';
            footer.appendChild(downloadBtn);

            // Share
            footer.appendChild(createBtn('🔗 ' + (window.I18n ? window.I18n.t('actions.share') : 'Share'), () => {
                window.DirectoryListingApp.shareFile(path);
            }));

            // Close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'btn';
            closeBtn.dataset.action = 'close-modal';
            closeBtn.innerText = window.I18n ? window.I18n.t('actions.close') : 'Close';
            closeBtn.style.marginLeft = 'auto';

            closeBtn.onclick = () => {
                const modal = document.getElementById('preview-modal');
                if (modal) {
                    modal.style.display = 'none';
                    const content = document.getElementById('preview-content');
                    if (content) content.innerHTML = '';
                }
            };

            footer.appendChild(closeBtn);
        },

        previewImage(path, container) {
            container.style.position = 'relative'; // Ensure nav buttons position correctly

            // Encode path to handle Unicode filenames
            const encodedPath = path.split('/').map(seg => {
                try { seg = decodeURIComponent(seg); } catch (e) { /* already raw */ }
                return encodeURIComponent(seg);
            }).join('/');

            const img = document.createElement('img');
            img.src = encodedPath;
            img.alt = 'Image preview';
            // Start with fit-to-screen styles
            img.style.maxWidth = '100%';
            img.style.maxHeight = '80vh';
            img.style.objectFit = 'contain';
            img.style.display = 'block';
            img.style.margin = '0 auto';
            img.style.transition = 'transform 0.2s ease';

            let currentZoom = 1;

            const updateZoom = () => {
                img.style.transform = `scale(${currentZoom})`;
            };

            // Mouse wheel zoom
            img.addEventListener('wheel', (e) => {
                e.preventDefault();
                if (e.deltaY < 0) {
                    currentZoom += 0.1;
                } else {
                    if (currentZoom > 0.2) currentZoom -= 0.1;
                }
                updateZoom();
            });

            // --- Navigation Logic ---
            // Get all visible file items that are images (not hidden by filter)
            const getVisibleImages = () => {
                return Array.from(document.querySelectorAll('.item')).filter(item => {
                    // Skip items hidden by filter or search
                    if (item.style.display === 'none') return false;
                    const p = item.dataset.path;
                    if (!p) return false;
                    const ext = p.split('.').pop().toLowerCase();
                    return ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'].includes(ext);
                });
            };

            const images = getVisibleImages();
            const currentIndex = images.findIndex(item => item.dataset.path === path);

            // Update title on navigation
            if (currentIndex !== -1) {
                const currentItem = images[currentIndex];
                const title = document.getElementById('preview-title');
                if (title && currentItem.dataset.name) {
                    const baseTitle = window.I18n ? window.I18n.t('actions.preview') : 'Preview';
                    title.textContent = `${baseTitle}: ${currentItem.dataset.name}`;
                    title.removeAttribute('data-i18n');
                }
            }

            // console.log('Nav Debug:', {\n            //     totalImages: images.length,\n            //     currentIndex: currentIndex,\n            //     currentPath: path,\n            //     firstImagePath: images[0] ? images[0].dataset.path : 'none'\n            // });

            // Cleanup previous keydown listener if exists
            if (this.navKeyListener) {
                document.removeEventListener('keydown', this.navKeyListener);
                this.navKeyListener = null;
            }

            img.onload = () => {
                container.innerHTML = '';
                container.appendChild(img);

                // Add Nav Buttons if we have multiple images
                if (images.length > 1 && currentIndex !== -1) {
                    const createNavBtn = (cls, text, offset) => {
                        const btn = document.createElement('button');
                        btn.className = `preview-nav ${cls}`;
                        btn.innerHTML = text;
                        btn.onclick = (e) => {
                            e.stopPropagation();
                            const newIndex = (currentIndex + offset + images.length) % images.length;
                            const newPath = images[newIndex].dataset.path;
                            this.previewImage(newPath, container);
                        };
                        return btn;
                    };

                    container.appendChild(createNavBtn('prev', '❮', -1));
                    container.appendChild(createNavBtn('next', '❯', 1));

                    // Keyboard Navigation
                    this.navKeyListener = (e) => {
                        // Only if modal is visible
                        if (document.getElementById('preview-modal').style.display === 'none') return;

                        if (e.key === 'ArrowLeft') {
                            const newIndex = (currentIndex - 1 + images.length) % images.length;
                            this.previewImage(images[newIndex].dataset.path, container);
                        } else if (e.key === 'ArrowRight') {
                            const newIndex = (currentIndex + 1) % images.length;
                            this.previewImage(images[newIndex].dataset.path, container);
                        }
                    };
                    document.addEventListener('keydown', this.navKeyListener);
                }

                // Create Zoom buttons
                const createBtn = (text, onClick, className = 'btn btn-sm') => {
                    const btn = document.createElement('button');
                    btn.className = className;
                    btn.innerHTML = text;
                    btn.onclick = onClick;
                    btn.style.marginRight = '5px';
                    return btn;
                };

                const zoomBtns = [
                    createBtn('🔍 +', () => { currentZoom += 0.2; updateZoom(); }),
                    createBtn('🔍 -', () => { if (currentZoom > 0.3) { currentZoom -= 0.2; updateZoom(); } }),
                    createBtn('🔍 Reset', () => { currentZoom = 1; updateZoom(); })
                ];

                this.renderFooterControls(path, zoomBtns);
            };

            img.onerror = () => {
                this.previewDefault(path, container);
            };
        },

        /**
         * Preview video
         */
        previewVideo(path, container) {
            const video = document.createElement('video');
            video.src = path;
            video.controls = true;
            video.style.maxWidth = '100%';
            video.style.height = 'auto';
            video.style.display = 'block';
            video.style.margin = '0 auto';

            video.onerror = () => {
                container.innerHTML = '<p style="text-align:center; color: var(--danger); padding: 2rem;">⚠️ ' + (window.I18n ? window.I18n.t('messages.error') : 'Failed to load video') + '</p>';
            };

            container.innerHTML = '';
            container.appendChild(video);

            this.renderFooterControls(path);
        },

        /**
         * Preview audio
         */
        previewAudio(path, container) {
            const audio = document.createElement('audio');
            audio.src = path;
            audio.controls = true;
            audio.style.width = '100%';

            audio.onerror = () => {
                container.innerHTML = '<p style="text-align:center; color: var(--danger); padding: 2rem;">⚠️ ' + (window.I18n ? window.I18n.t('messages.error') : 'Failed to load audio') + '</p>';
            };

            container.innerHTML = '';
            container.appendChild(audio);

            this.renderFooterControls(path);
        },

        /**
         * Preview PDF
         */
        previewPDF(path, container) {
            const iframe = document.createElement('iframe');
            iframe.src = path;
            iframe.style.width = '100%';
            iframe.style.height = '600px';
            iframe.style.border = 'none';

            container.innerHTML = '';
            container.appendChild(iframe);

            this.renderFooterControls(path);
        },

        /**
         * Preview text/code files
         */
        async previewText(path, container) {
            try {
                const response = await fetch(path);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                const text = await response.text();
                const ext = path.split('.').pop().toLowerCase();
                const isMarkdown = ['md', 'markdown', 'mdown', 'mkdn'].includes(ext);

                // Language mapping for Prism
                const langMap = {
                    'js': 'javascript',
                    'php': 'php',
                    'py': 'python',
                    'json': 'json',
                    'sql': 'sql',
                    'bash': 'bash',
                    'sh': 'bash',
                    'css': 'css',
                    'html': 'markup',
                    'xml': 'markup',
                    'md': 'markdown',
                    'au3': 'autoit',
                    'cpp': 'cpp',
                    'c': 'c',
                    'h': 'c',
                    'cs': 'csharp',
                    'pas': 'pascal'
                };
                const lang = langMap[ext] || (isMarkdown ? 'markdown' : 'none');

                container.innerHTML = '';

                // Wrapper for content
                const contentWrapper = document.createElement('div');
                contentWrapper.style.width = '100%';
                contentWrapper.style.height = '100%';
                contentWrapper.style.overflow = 'auto'; // Move overflow here
                container.appendChild(contentWrapper);

                // Source View (Default)
                const pre = document.createElement('pre');
                pre.style.padding = '1rem';
                pre.style.background = 'var(--bg-secondary)';
                pre.style.borderRadius = 'var(--border-radius)';
                pre.style.fontFamily = 'var(--font-mono)';
                pre.style.fontSize = '13px';
                pre.style.lineHeight = '1.5';
                pre.style.margin = '0'; // Reset margin
                pre.style.whiteSpace = 'pre-wrap'; // Wrap text

                const code = document.createElement('code');
                code.textContent = text;
                if (window.Prism && lang !== 'none') {
                    code.className = 'language-' + lang;
                }
                pre.appendChild(code);

                // Trigger highlighting
                if (window.Prism && lang !== 'none') {
                    setTimeout(() => {
                        window.Prism.highlightElement(code);
                    }, 0);
                }

                // Rendered View (Hidden by default)
                let renderedDiv = null;
                if (isMarkdown) {
                    renderedDiv = document.createElement('div');
                    renderedDiv.className = 'markdown-body';
                    renderedDiv.style.padding = '1rem';
                    renderedDiv.style.display = 'none';
                    renderedDiv.style.background = 'var(--bg-primary)'; // Ensure readable background
                    renderedDiv.style.color = 'var(--text-primary)';
                }

                // Append initial view
                contentWrapper.appendChild(pre);
                if (renderedDiv) {
                    contentWrapper.appendChild(renderedDiv);
                }

                // Buttons
                const extraBtns = [];

                // Markdown Toggle Button
                if (isMarkdown && window.marked) {
                    const viewBtn = document.createElement('button');
                    viewBtn.className = 'btn btn-sm';
                    const viewRenderedText = window.I18n ? window.I18n.t('actions.view_rendered') : '👁 View Rendered';
                    const viewSourceText = window.I18n ? window.I18n.t('actions.view_source') : '📝 View Source';

                    viewBtn.innerHTML = viewRenderedText;
                    viewBtn.style.marginRight = '5px';

                    viewBtn.onclick = () => {
                        if (renderedDiv.style.display === 'none') {
                            // Switch to Rendered
                            if (!renderedDiv.innerHTML) {
                                const rawHtml = window.marked.parse(text);
                                renderedDiv.innerHTML = this.sanitizeHTML(rawHtml);
                            }
                            pre.style.display = 'none';
                            renderedDiv.style.display = 'block';
                            viewBtn.innerHTML = viewSourceText;
                        } else {
                            // Switch to Source
                            renderedDiv.style.display = 'none';
                            pre.style.display = 'block';
                            viewBtn.innerHTML = viewRenderedText;
                        }
                    };
                    extraBtns.push(viewBtn);
                }

                // Copy Button
                const copyBtn = document.createElement('button');
                copyBtn.className = 'btn btn-sm';
                copyBtn.innerHTML = '📋 ' + (window.I18n ? window.I18n.t('actions.copy') : 'Copy');
                copyBtn.style.marginRight = '5px';
                copyBtn.onclick = () => {
                    navigator.clipboard.writeText(text);
                    const originalText = copyBtn.innerHTML;
                    copyBtn.innerHTML = '✅ ' + (window.I18n ? window.I18n.t('actions.copied') : 'Copied');
                    setTimeout(() => copyBtn.innerHTML = originalText, 2000);
                };
                extraBtns.push(copyBtn);

                this.renderFooterControls(path, extraBtns);

            } catch (error) {
                container.innerHTML = '<p style="color: var(--danger);">Failed to load file content</p>';
                console.error(error);
            }
        },

        /**
         * Default preview for unsupported types
         */
        previewDefault(path, container) {
            // Decode for display, then escape to prevent XSS
            const rawFilename = path.split('/').pop();
            let displayFilename;
            try { displayFilename = decodeURIComponent(rawFilename); } catch (e) { displayFilename = rawFilename; }
            const escHtml = s => s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
            const safeFilename = escHtml(displayFilename);

            const notAvailText = window.I18n ? window.I18n.t('actions.preview_not_available') : 'Preview not available for this file type';
            const downloadText = window.I18n ? window.I18n.t('actions.download') : 'Download';
            const previewAsTextText = window.I18n ? window.I18n.t('actions.preview_as_text') : 'Preview as text';

            container.innerHTML = `
                <div style="text-align: center; padding: 2rem;">
                    <p style="font-size: 48px; margin-bottom: 1rem;">📄</p>
                    <p style="margin-bottom: 1rem;"><strong>${safeFilename}</strong></p>
                    <p style="color: var(--text-secondary); margin-bottom: 2rem;">
                        ${escHtml(notAvailText)}
                    </p>
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <a href="${escHtml(path)}" download class="btn">
                            📥 ${escHtml(downloadText)}
                        </a>
                        <button class="btn" id="btn-preview-as-text">
                            📄 ${escHtml(previewAsTextText)}
                        </button>
                    </div>
                </div>
            `;

            // Attach event listener
            const btn = container.querySelector('#btn-preview-as-text');
            if (btn) {
                btn.onclick = () => this.previewText(path, container);
            }

            // Ensure footer is clear or has standard controls
            // Actually previewDefault usually clears container, so we should ALSO clear footer or set it to basic state
            this.renderFooterControls(path);
        },

        /**
         * Basic HTML Sanitization for Markdown
         */
        sanitizeHTML(html) {
            const div = document.createElement('div');
            div.innerHTML = html;

            // Remove potentially dangerous elements
            const dangerous = ['script', 'iframe', 'object', 'embed', 'form', 'base', 'meta', 'link'];
            Array.prototype.forEach.call(dangerous, tag => {
                const elements = div.getElementsByTagName(tag);
                while (elements.length > 0) {
                    elements[0].parentNode.removeChild(elements[0]);
                }
            });

            // Remove event handlers from all elements
            const all = div.getElementsByTagName('*');
            for (let i = 0; i < all.length; i++) {
                const attrs = all[i].attributes;
                for (let j = attrs.length - 1; j >= 0; j--) {
                    if (attrs[j].name.startsWith('on')) {
                        all[i].removeAttribute(attrs[j].name);
                    }
                }
            }

            return div.innerHTML;
        }
    };

    // Expose to window
    window.PreviewManager = PreviewManager;

})();

/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * End preview.js
 */
