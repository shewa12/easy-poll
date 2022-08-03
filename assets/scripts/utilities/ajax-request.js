/**
 * Ajax request for global use
 *
 * @param {*} formData | form data for post request
 * @returns json response on success or false
 */
 const { __ } = wp.i18n; 
 export default async function ajaxRequest(formData, jsonResponse = true, target = false) {

    let loadingMessage = __('Loading', 'easy-poll');
    let prevHtml = '';
    if (target) {
        prevHtml = target.innerHTML;
    }
    // Disabled target button.
    target.setAttribute('disabled', true);
    // Show loading message.
    target.innerHTML = loadingMessage;

    const post = await fetch(epData.url, {
        method: 'POST',
        body: formData,
    });

    // Reset button to the prev state.
    target.innerHTML = prevHtml;
    target.removeAttribute('disabled');
    if (post.ok) {
        if (jsonResponse) {
            return await post.json();
        } else {
            return await post.text();
        }
    } else {
        return false;
    }
}