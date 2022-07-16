/**
 * Append/remove form fields
 * 
 * @since v2.0.0
 */
 import ajaxRequest from "./ajax-request";

 const {__} = wp.i18n;
 
 /**
  * Add field anywhere needed
  *
  * @since v2.0.0
  *
  * @param field   html field to add
  * @param appendAbleElement  selector where it should append.
  * CSS Selector like: '.class #id' or html tag that is valid.
  *
  * @return void
  */
 export default function addDynamicField(field, appendAbleElement) {
     document.querySelector(appendAbleElement)
     .insertAdjacentHTML('beforeend', field);
 }
 
 /**
  * A global remove-able function to remove field from 
  * anywhere. Just use class ep-remove-able, it will remove the closest div
  * of having class ep-remove-able-wrapper
  * 
  * If field should make ajax request before removing element then add
  * attr like: data-tp-ajax={action: 'abc'}
  * 
  * So data-tp-ajax should contain valid object as value.
  *
  * Note: for dynamically added element it will not work.
  * In that we can just removeElement function and pass
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