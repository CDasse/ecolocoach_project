/**
 * Handles quiz answer selection.
 * * This script listens for click events on answer buttons, toggles the 'active'
 * visual state, stores the selected value in a hidden form input, and enables
 * the validation button once a choice has been made.
 */
document.addEventListener('DOMContentLoaded', function () {
    const answerButtons = document.querySelectorAll('.btn-answer');
    const hiddenInput = document.getElementById('selected-answer-input');
    const validateBtn = document.getElementById('btn-validate');

    answerButtons.forEach(button => {
        button.addEventListener('click', function () {
            answerButtons.forEach(btn => btn.classList.remove('active'));

            this.classList.add('active');

            hiddenInput.value = this.dataset.value;

            validateBtn.disabled = false;
        });
    });
});


function openPopup(url) {
    const overlay = document.getElementById('overlay-popup');
    const content = document.getElementById('content-popup');

    content.innerHTML = '<p style="text-align:center; padding: 20px;">Chargement...</p>';
    overlay.classList.remove('hidden');

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error("Erreur serveur");
            return response.text();
        })
        .then(html => {
            content.innerHTML = html;
        })
        .catch(_ => {
            content.innerHTML = '<p style="text-align:center;">Impossible de charger les détails.</p>';
        });
}

function closePopup() {
    const overlay = document.getElementById('overlay-popup');
    overlay.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('overlay-popup');
    if(overlay) {
        overlay.addEventListener('click', function(event) {
            if (event.target === overlay) {
                closePopup();
            }
        });
    }
});
