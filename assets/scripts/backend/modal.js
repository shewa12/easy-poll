// $('.openmodale').click(function (e) {
//     e.preventDefault();
//     $('.modale').addClass('opened');
// });
// $('.closemodale').click(function (e) {
//     e.preventDefault();
//     $('.modale').removeClass('opened');
// });

document.addEventListener('DOMContentLoaded', function() {
    const openModal = document.querySelector('.ep-modal-opener');
    const closeModal = document.querySelector('.ep-close-modal');
    if (openModal) {
        openModal.onclick = () => {
            console.log('hello')
            const modal = document.querySelector('.ep-modal-wrapper');
            modal.classList.add('opened');
        }
    }
    if (closeModal) {
        closeModal.onclick = () => {
            const modal = document.querySelector('.ep-modal-wrapper');
            modal.classList.remove('opened');
        }
    }
});