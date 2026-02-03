 let countdown = 10;
    let countdownInterval = null;

    const modal = document.getElementById('downloadModal');
    const proceedBtn = document.getElementById('proceedBtn');

    modal.addEventListener('shown.bs.modal', () => {
        // 🔴 Stop any previous timer first
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }

        countdown = 10;
        proceedBtn.disabled = true;
        proceedBtn.textContent = `Proceed to Download (${countdown})`;

        countdownInterval = setInterval(() => {
            countdown--;

            if (countdown > 0) {
                proceedBtn.textContent = `Proceed to Download (${countdown})`;
            } else {
                clearInterval(countdownInterval);
                countdownInterval = null;
                proceedBtn.textContent = 'Proceed to Download';
                proceedBtn.disabled = false;
            }
        }, 1000);
    });

    modal.addEventListener('hidden.bs.modal', () => {
        if (countdownInterval) {
            clearInterval(countdownInterval);
            countdownInterval = null;
        }
    });