
/**
 * Contains frontend scripts
 * 
 * @since v1.0.0
 */
import ajaxRequest from './utilities/ajax-request';

const {__} = wp.i18n;

window.addEventListener('DOMContentLoaded', function() {
    // Handle user's poll submission
    const pollForm = document.getElementById('ep-poll-form');
    const pollWrapper = document.querySelector('.ep-poll-wrapper');
    if ( !pollForm) {
        return;
    }
    pollForm.onsubmit = async (e) => {
        e.preventDefault();
        let warningMsg = __('Do you want to submit it? This cannot be reverted!', 'easy-poll');
        if (confirm(warningMsg)) {
            const submitBtn = pollForm.querySelector('.ep-btn');
            const formData = new FormData(pollForm);
            formData.set('action', 'ep_poll_submit');
            const response = await ajaxRequest(formData, true, submitBtn);
            const { success, data } = response;

            let width = `${epData.poll_template_width}%`;
            if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                width = '92%';
            }
            if (success) {
                if (data.show_poll_summary) {
                    location.reload();
                } else {
                    if (pollWrapper) {
                        pollWrapper.innerHTML = `
                            <div class="ep-alert ep-alert-success" style="width: ${width}; margin: auto;">
                                <p>
                                    ${epData.success_msg}
                                </p>
                            </div>
                        `;
                    }
                }
            } else {
                alert( __( 'Something went wrong, please try again.', 'easy-poll') )
            }
        }
    }
});