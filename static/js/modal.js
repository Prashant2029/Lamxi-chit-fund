document.addEventListener("DOMContentLoaded", function () {
    const trigger = document.getElementById('messageTrigger');
    const message = trigger.getAttribute('data-message');
    const type = trigger.getAttribute('data-type');

    if (message) {
        showMessage(message, type);
    }
});

function showMessage(message, type) {
    const modalBody = document.querySelector('#messageModal .modal-body');
    modalBody.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
    const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
    messageModal.show();
}