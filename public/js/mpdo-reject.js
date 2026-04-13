document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.approve-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            // Disable related buttons immediately
            const permitItem = form.closest('.permit-item');
            if (permitItem) {
                const underReviewBtn = permitItem.querySelector('.under-review-btn');
                const rejectBtn = permitItem.querySelector('.reject-btn');
                if (underReviewBtn) underReviewBtn.disabled = true;
                if (rejectBtn) rejectBtn.disabled = true;
            }
        });
    });
});