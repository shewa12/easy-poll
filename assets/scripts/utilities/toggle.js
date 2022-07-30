/**
 * Show & hide element
 * 
 * @since v1.0.0
 */

/**
 * Toggle element with the time interval
 * 
 * @since v1.0.0
 *
 * @param {*} selector  css selector that will be toggle.
 * @param {*} text  text to show on the elem.
 * @param {*} time time in milliseconds that this time elem will be hidden.
 * @param array add class to the elem, array of classes: ["a", "b"].
 * @param display css display prop default is block.
 * 
 */
function toggle(selector, text = '', time = 3000, addClass = [], display = 'block') {
    const elem = document.querySelector(selector);
    console.log(elem);
    if (elem) {
        elem.classList.add(...addClass);
        elem.innerHTML = text;
        elem.style.display = 'block';
        setTimeout(() => {
            elem.style.display = 'none'
        }, time);
    }
}
export default toggle;