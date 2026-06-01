/*--------------------------------------------------------------------------------*/
/*--------------------------------BURGER MENU-------------------------------------*/
/*--------------------------------------------------------------------------------*/

/**
 * Controls the mobile burger menu lifecycle using native browser APIs.
 */
function OpenOrExitBurgerMenu() {
    const openButton = document.querySelector('.open-menu-button');
    const exitButton = document.querySelector('.exit-menu-button');
    const dialogBalise = document.getElementById('dialog-burger-menu');

    if (openButton && exitButton && dialogBalise) {
        openButton.addEventListener('click', function() {
            dialogBalise.showModal();
        });

        exitButton.addEventListener('click', function() {
            dialogBalise.close();
        });
    }
}

/**
 * Initializes the burger menu logic.
 */
document.addEventListener('DOMContentLoaded', () => {
    OpenOrExitBurgerMenu();
});


/*--------------------------------------------------------------------------------*/
/*-------------------------INTERACTIVE QUIZ IN LESSON-----------------------------*/
/*--------------------------------------------------------------------------------*/

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

            validateBtn.classList.remove('btn-validation-disabled');
            validateBtn.disabled = false;
        });
    });
});


/*--------------------------------------------------------------------------------*/
/*------------------------------POP-UP CHALLENGE----------------------------------*/
/*--------------------------------------------------------------------------------*/

/**
 * This function triggers an AJAX request to load and display full information inside a popup
 * when a user actively selects and clicks on a specific challenge card.
 */
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


/**
Once the user is done reading or accepting a challenge, this dismisses the modal
 * overlay and restores focus back to the primary navigation timeline context.
 */
function closePopup() {
    const overlay = document.getElementById('overlay-popup');
    overlay.classList.add('hidden');
}


/**
 * It allows users to naturally close the challenge popup by tapping anywhere outside the
 * text content, preventing them from being forced to hunt down the close cross button.
 */
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
