
/**
 * Poll field single/multiple choice, input/text area
 * form submit handler.
 *
 * @since v1.0.0
 */

import toggle from "../utilities/toggle";
import ajaxRequest from "../utilities/ajax-request";

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

/**
 * Manage response after ajax request
 * 
 * Show & hide response message with the help of toggle
 * utility.
 * 
 * @see "../utilities/toggle";
 *
 * @param {*} response   ajax response, response obj
 * @param {*} selector elem to show response message, css selector.
 */
function manageResponse(response,selector, successMsg, failMsg) {
    if (response.success) {
        toggle(
            selector,
            successMsg,
            3000,
            ["ep-alert-success"]
        );
    } else {
        toggle(
            selector,
            failMsg,
            3000,
            ["ep-alert-success"]
        );
    }
}
