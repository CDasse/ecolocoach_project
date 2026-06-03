/*--------------------------------------------------------------------------------*/
/*------------------------------- BURGER MENU ------------------------------------*/
/*--------------------------------------------------------------------------------*/

/**
 * Controls the mobile burger menu lifecycle using native browser APIs.
 */
document.addEventListener('DOMContentLoaded', () => {
    const openButton = document.querySelector('.open-menu-button');
    const exitButton = document.querySelector('.exit-menu-button');
    const dialogBalise = document.getElementById('dialog-burger-menu');

    if (openButton && exitButton && dialogBalise) {
        openButton.addEventListener('click', () => {
            dialogBalise.showModal();
        });

        exitButton.addEventListener('click', () => {
            dialogBalise.close();
        });
    }
});

/*--------------------------------------------------------------------------------*/
/*------------------------ INTERACTIVE QUIZ IN LESSON ----------------------------*/
/*--------------------------------------------------------------------------------*/

/**
 * Handles quiz answer selection.
 * * This script listens for click events on answer buttons, toggles the 'active'
 * visual state, stores the selected value in a hidden form input, and enables
 * the validation button once a choice has been made.
 */
document.addEventListener('DOMContentLoaded', () => {
    const answerButtons = document.querySelectorAll('.btn-answer');
    const hiddenInput = document.getElementById('selected-answer-input');
    const validateBtn = document.getElementById('btn-validate');

    answerButtons.forEach(button => {
        button.addEventListener('click', () => {
            answerButtons.forEach(btn => btn.classList.remove('active'));

            this.classList.add('active');

            hiddenInput.value = this.dataset.value;

            validateBtn.classList.remove('btn-validation-disabled');
            validateBtn.disabled = false;
        });
    });
});


/*--------------------------------------------------------------------------------*/
/*----------------------------- POP-UP CHALLENGE ---------------------------------*/
/*--------------------------------------------------------------------------------*/

/**
 * This function load and display full information inside a popup
 * when a user actively selects and clicks on a specific challenge card.
 */
document.addEventListener('DOMContentLoaded', () => {
    const dialog = document.getElementById('challenge-dialog');
    const openButtons = document.querySelectorAll('.btn-read-more');

    if (!dialog || openButtons.length === 0) return;

    openButtons.forEach(button => {
        button.addEventListener('click', async (event) => {
            const url = event.currentTarget.dataset.url;

            if (!url) return;

            dialog.innerHTML = '<div style="padding: 20px; text-align: center;">Chargement en cours...</div>';
            dialog.showModal();

            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error("Erreur lors de la récupération du défi.");
                }

                dialog.innerHTML = await response.text();
            } catch {
                dialog.innerHTML = '<p style="text-align:center;">Impossible de charger les détails.</p>';
            }
        });
    });

    /**
     * Once the user is done reading or accepting a challenge, this dismisses the modal
     * overlay and restores focus back to the primary navigation timeline context.
     * It also allows users to naturally close the challenge popup by tapping anywhere outside the
     * text content, preventing them from being forced to hunt down the close cross button.
     */

    dialog.addEventListener('click', (event) => {

        if (event.target.closest('.popup-close-btn')) {
            dialog.close();
            return;
        }

        if (event.target === dialog) {
            dialog.close();
        }
    });
});

/*--------------------------------------------------------------------------------*/
/*---------------------------- FLASH MESSAGE MODAL -------------------------------*/

/*--------------------------------------------------------------------------------*/

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
    if (overlay) {
        overlay.addEventListener('click', function (event) {
            if (event.target === overlay) {
                closePopup();
            }
        });
    }
});


/**
 * It allows users to naturally close the modal popup by tapping anywhere outside the
 * text content, preventing them from being forced to hunt down the close cross button.
 */
document.addEventListener('DOMContentLoaded', () => {
    const flashOverlay = document.getElementById('flash-overlay-popup');
    const flashCloseBtn = document.getElementById('flash-close-btn');

    if (flashOverlay) {
        if (flashCloseBtn) {
            flashCloseBtn.addEventListener('click', () => {
                flashOverlay.classList.add('hidden');
            });
        }

        flashOverlay.addEventListener('click', (event) => {
            if (event.target === flashOverlay) {
                flashOverlay.classList.add('hidden');
            }
        });
    }
});


/*--------------------------------------------------------------------------------*/
/*-------------------------- PROTECTION DOUBLE CLICK -----------------------------*/
/*--------------------------------------------------------------------------------*/

/**
 * Anti-double-click protection: Disables submit buttons as soon as
 * a form is submitted to prevent duplicate requests.
 */
document.addEventListener('submit', (event) => {
    const form = event.target;
    const submitButtons = form.querySelectorAll('button[type="submit"]');

    submitButtons.forEach(button => {
        button.disabled = true;

        button.style.opacity = '0.6';
        button.style.cursor = 'not-allowed';
    });
});
