// Read finish time from data attribute
let countdownElem = document.getElementById('countdown');
let finishTimeStr = countdownElem.getAttribute('data-finish');
let finishTime = finishTimeStr ? new Date(finishTimeStr) : null;

function updateCountdown() {
    if (!finishTime) return;

    const now = new Date();
    const diff = finishTime - now;

    if (diff <= 0) {
        countdownElem.innerText = "Development Finished!";
    } else {
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        countdownElem.innerText = `${hours}h ${minutes}m ${seconds}s`;
    }
}

setInterval(updateCountdown, 1000);
updateCountdown();