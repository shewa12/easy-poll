/**
 * Ajax request for global use
 *
 * @param {*} formData | form data for post request
 * @returns json response on success or false
 */
 export default async function ajaxRequest(formData, jsonResponse = true) {

    const post = await fetch(epData.url, {
        method: 'POST',
        body: formData,
    });

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