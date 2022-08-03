/**
 * Append/remove form fields
 * 
 * @since v2.0.0
 */

 /**
  * Add HTML elem anywhere needed
  *
  * @since v1.0.0
  *
  * @param elem   html element to add
  * @param appendAbleElement  selector where it should append.
  * CSS Selector like: '.class #id' or html tag that is valid.
  *
  * @return void
  */
 export default function addDynamicField(elem, appendAbleElement) {
     document.querySelector(appendAbleElement)
     .insertAdjacentHTML('beforeend', elem);
 }
 
 /**
  * A global remove-able function to remove field from 
  * anywhere. Just use class ep-remove-able, it will remove the closest div
  * of having class ep-remove-able-wrapper
  *
  * Note: for dynamically added element it will not work.
  * In that case we can just use removeElement function and pass
  * HTML element like below:
  *
  * const a = document.querySelector('.b);
  * removeElement(a);
  *
  * @return void
  */
 const removeAbles = document.querySelectorAll('.ep-remove-able');
 removeAbles.forEach((elem) => {
     elem.onclick = async (event) => {
         event.preventDefault();
         // if has data attr make ajax request
         removeElement();
     }
 });
 
 export function removeElement(elem) {
    if (elem) {
        elem.closest('.ep-remove-able-wrapper').remove();
    }
 }