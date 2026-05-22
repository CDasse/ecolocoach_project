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
