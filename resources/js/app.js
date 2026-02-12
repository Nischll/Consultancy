import './bootstrap';

import Alpine from 'alpinejs';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';

window.Alpine = Alpine;

Alpine.start();

/**
 * Initialize searchable dropdowns (Tom Select) on all select elements.
 * Call this on DOMContentLoaded and optionally when new content is added (e.g. modals).
 */
function initSearchableSelects() {
    document.querySelectorAll('select').forEach((el) => {
        if (el.tomselect) return;
        if (el.disabled) return;
        try {
            new TomSelect(el, {
                plugins: ['dropdown_input'],
                allowEmptyOption: true,
                placeholder: el.getAttribute('placeholder') || (el.querySelector('option[value=""]')?.textContent?.trim()) || 'Type to search...',
                maxOptions: null,
                hideSelected: true,
                closeAfterSelect: !el.multiple,
            });
        } catch (e) {
            console.warn('Tom Select init failed for', el.name || el.id, e);
        }
    });
}

document.addEventListener('DOMContentLoaded', initSearchableSelects);

window.initSearchableSelects = initSearchableSelects;
