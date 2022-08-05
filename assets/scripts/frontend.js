
/**
 * Contains frontend scripts
 * 
 * @since v1.0.0
 */
import ajaxRequest from './utilities/ajax-request';

window.addEventListener('DOMContentLoaded', function() {
    // Handle user's poll submission
    const pollForm = document.getElementById('ep-poll-form');
    
    pollForm.onsubmit = async (e) => {
        const submitBtn = pollForm.querySelector('.ep-btn');
        console.log(submitBtn);
        e.preventDefault();
        const formData = new FormData(pollForm);
        formData.set('action', 'ep_poll_submit');
        const response = await ajaxRequest(formData, true, submitBtn);
        console.log(response);
    }
});