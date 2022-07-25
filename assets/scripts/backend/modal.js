import ajaxRequest from "../utilities/ajax-request";

/**
 * Handle model open & close
 *
 * @since v1.0.0
 */
document.addEventListener('DOMContentLoaded', function() {
    const openButtons = document.querySelectorAll('.ep-modal-opener');
    const closeButtons = document.querySelectorAll('.ep-close-modal');
 
    if (openButtons.length) {
        openButtons.forEach( (button) => {
            button.onclick = () => {
                const target = button.getAttribute('data-target');
                const targetModal = document.querySelector(target);
                targetModal.classList.add('opened');
            }
        });
    }
    if (closeButtons.length) {
        closeButtons.forEach((button) => {
            button.onclick = () => {
                const modals = document.querySelectorAll('.ep-modal-wrapper');
                modals.forEach((modal) => {
                    modal.classList.remove('opened');
                });
            }
        });
    }
    
    /**
     * Poll field single/multiple choice, input/text area
     * form submit handler.
     *
     * @since v1.0.0
     */
    // const modalForms = document.querySelectorAll('.ep-field-save');
    // modalForms.forEach((form) => {
    //     if (form.hasAttribute('ep-ajax-modal')) {
    //         form.onsubmit = async (event) => {

    //             event.preventDefault();
    //             console.log(                event.target);
    //             return;
    //             const formData = new FormData(form);
    //             const response = await ajaxRequest(formData, true, event.target);
    //             console.log(response);
    //         }
    //     }
    // });
    const saveButtons = document.querySelectorAll('.ep-field-save');
    saveButtons.forEach((button) => {
        button.onclick = async (event) => {
            event.preventDefault();
            const formData = new FormData(event.target.closest('form'));
            const response = await ajaxRequest(formData, true, event.target);
            console.log(response);
        }
    });
});