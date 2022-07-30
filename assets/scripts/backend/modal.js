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

});