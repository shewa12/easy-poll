/**
 * Collapse elem
 * 
 * to make an elem collapsable need to use class ep-collapse
 * with target attr (data-target= #12)
 * 
 * Collapse utility will just toggle utility class ep-hidden to make elem
 * collapsable
 * 
 * @since v1.0.0
 */
window.addEventListener('DOMContentLoaded', function() {
    const elems = document.querySelectorAll('.ep-collapse');
    const iconSelector = 'dashicons';
    const toggleIcon1 = 'dashicons-arrow-down-alt2';
    const toggleIcon2 = 'dashicons-arrow-up-alt2';
    elems.forEach((elem) => {
        elem.onclick = (e) => {
            const target = e.target;
            let dataTarget = null;
            if (target.tagName === 'H4' || target.tagName === 'I') {
                let closestCollapse = target.closest('.ep-collapse');
                dataTarget = closestCollapse ? closestCollapse.dataset.target : null;
            } else {
                dataTarget = e.target.dataset.target;
            }
            
            if (dataTarget) {
                const collapseElem = document.querySelector(dataTarget);
                if (collapseElem) {
                    collapseElem.classList.toggle('ep-hidden');
                }
            }

            // Check icon & toggle it
            const toggleIcon = e.currentTarget.querySelector(`.${iconSelector}`);
            if (toggleIcon) {
                if (toggleIcon.classList.contains(toggleIcon1)) {
                    toggleIcon.classList.remove(toggleIcon1);
                    toggleIcon.classList.add(toggleIcon2);
                } else {
                    toggleIcon.classList.remove(toggleIcon2);
                    toggleIcon.classList.add(toggleIcon1);
                }
            }
        }
    });
});