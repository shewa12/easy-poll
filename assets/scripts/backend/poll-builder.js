
/**
 * Poll field single/multiple choice, input/text area
 * form submit handler.
 *
 * @since v1.0.0
 */

import ajaxRequest from "../utilities/ajax-request";
import manageResponse from "../utilities/manage-response";

const {__} = wp.i18n;

// Handle single/multiple choice question
const saveButtons = document.querySelectorAll('.ep-choice-question-save');
saveButtons.forEach((button) => {
    button.onclick = async (event) => {
        event.preventDefault();
        const formData = new FormData(event.target.closest('form'));
        const response = await ajaxRequest(formData, true, event.target);
        const notifyElem = '#ep-single-multiple-snackbar';

        // If operation success then reset form.
        if (response.success) {
            event.target.closest('form').reset();
        }

        // If it is save & close button then close the modal.
        if (button.classList.contains('ep-save-and-close')) {
            const modal = event.target.closest('.ep-modal-wrapper');
            if (modal && modal.classList.contains('opened')) {
                modal.classList.remove('opened');
            }
        } else {
            const successMsg = __('Question created success fully', 'easy-poll');
            const failMsg = __('Question created failed! Please try again', 'easy-poll');
            manageResponse(response, notifyElem, successMsg, failMsg);
        }
    }
});


// Handle input/textarea type question
const inputTextareaSaveButton = document.querySelector('.ep-input-textarea-question-save');
if (inputTextareaSaveButton) {
    inputTextareaSaveButton.onclick = async (event) => {
        event.preventDefault();
        const formData = new FormData(event.target.closest('form'));
        const response = await ajaxRequest(formData, true, event.target);
        const notifyElem = '#ep-input-textarea-snackbar';

        // If operation success then reset form.
        if (response.success) {
            event.target.closest('form').reset();
        }
        const successMsg = __('Question created success fully', 'easy-poll');
        const failMsg = __('Question created failed! Please try again', 'easy-poll');
        manageResponse(response, notifyElem, successMsg, failMsg);
    }
}


