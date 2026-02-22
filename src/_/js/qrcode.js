/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * Begin qrcode.js
 */

/**
 * QR Code Generator Module
 * Offline QR code generation using QRCode.js library
 */


(function () {
    'use strict';

    const QRCodeGenerator = {
        /**
         * Render QR code into an element
         * @param {HTMLElement} container 
         * @param {string} text 
         * @param {int} size 
         */
        render(container, text, size = 200) {
            if (!container) return;

            // Clear previous
            container.innerHTML = '';

            // Use QRCode.js library (must be loaded)
            if (typeof QRCode !== 'undefined') {
                try {
                    new QRCode(container, {
                        text: text,
                        width: size,
                        height: size,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });
                } catch (e) {
                    console.error('QRCode generation failed:', e);
                    container.textContent = 'Error generating QR code';
                }
            } else {
                container.textContent = 'Error: QRCode library not loaded.';
            }
        }
    };

    // Expose to window
    window.QRCodeGenerator = QRCodeGenerator;

})();

/**
 *  ___ _ _     _    _    _           
 * | __(_) |___| |  (_)__| |_ ___ _ _ 
 * | _|| | / -_) |__| (_-<  _/ -_) '_|
 * |_| |_|_\___|____|_/__/\__\___|_|  
 * End qrcode.js
 */
