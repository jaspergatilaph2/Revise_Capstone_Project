document.addEventListener('DOMContentLoaded', function () {
    // Countdown timer for archive buttons
    document.querySelectorAll('.archive-btn').forEach(function (button) {
        let permitId = button.id.split('-')[1];
        let countdownEl = document.querySelector('.countdown[data-permit-id="' + permitId + '"]');
        let time = 15; // seconds

        let interval = setInterval(function () {
            time--;
            countdownEl.textContent = `You can archive in ${time} seconds...`;
            if (time <= 0) {
                button.disabled = false;
                countdownEl.textContent = 'You can now archive this plan.';
                clearInterval(interval);
            }
        }, 1000);
    });

    // AJAX submit for archive forms
    document.querySelectorAll('.archive-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            let permitId = this.dataset.permitId;
            let formData = new FormData(this);
            let url = this.action;

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        // Close modal
                        let modalEl = document.getElementById('archivePlanModal' + permitId);
                        let modal = bootstrap.Modal.getInstance(modalEl);
                        modal.hide();

                        // Remove permit
                        let permitItem = document.querySelector(`.permit-item[data-permit-id="${permitId}"]`);

                        if (permitItem) {
                            let wrapper = permitItem.closest('.permit-wrapper');
                            permitItem.remove();

                            if (wrapper && wrapper.children.length === 0) {
                                let userId = wrapper.dataset.userId;
                                let userRow = document.getElementById('permitRow-' + userId);
                                if (userRow) userRow.remove();
                            }
                        }

                        // ✅ RELOAD AFTER 1 SECOND
                        setTimeout(() => {
                            location.reload();
                        }, 1000);

                    } else {
                        alert(data.message || 'Something went wrong!');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('An error occurred!');
                });
        });
    }); 
});