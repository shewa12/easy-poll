/**
 * Response management utility function
 * 
 * @since v1.0.0
 */
import toggle from "./toggle";

/**
 * Manage response after ajax request
 * 
 * Show & hide response message with the help of toggle
 * utility.
 * 
 * @see "../utilities/toggle";
 *
 * @param {*} response   ajax response, response obj
 * @param {*} selector elem where to show response message, css selector.
 * @param {*} successMsg success message text.
 * @param {*} failMsg failure message text.
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
export default manageResponse;