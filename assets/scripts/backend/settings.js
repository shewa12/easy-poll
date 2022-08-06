/**
 * Settings scripts
 * 
 * @since v1.0.0
 */

import ajaxRequest from "../utilities/ajax-request";

const { __ } = wp.i18n;
window.addEventListener('DOMContentLoaded', function() {
    const settingForm = document.getElementById('ep-setting-form');
    if (settingForm) {
        settingForm.onsubmit = async (e) => {
            e.preventDefault();
            const updateBtn = settingForm.querySelector('.button.button-primary');
            const formData = new FormData(settingForm);
            const response = await ajaxRequest(formData, true, updateBtn);
            if (!response.success) {
                alert( __('Settings has not been changed!', 'easy-poll') );
            }
        }
    }
});

