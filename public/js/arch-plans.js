document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.modal').forEach(function (modalEl) {

        let interval = null;

        modalEl.addEventListener('show.bs.modal', function () {

            const permitId = this.id.replace('archivePlanModal', '');
            const countdownEl = this.querySelector(`.countdown[data-permit-id="${permitId}"]`);
            const confirmBtn = this.querySelector('.archive-btn');

            if (!countdownEl || !confirmBtn) return;

            let time = 15;

            confirmBtn.disabled = true;
            countdownEl.textContent = `You can archive in ${time} seconds...`;

            if (interval) clearInterval(interval);

            interval = setInterval(function () {
                time--;
                countdownEl.textContent = `You can archive in ${time} seconds...`;

                if (time <= 0) {
                    clearInterval(interval);
                    interval = null;

                    confirmBtn.disabled = false;
                    countdownEl.innerHTML = `<span class="text-success">You can now archive this plan ✓</span>`;
                }
            }, 1000);
        });

        modalEl.addEventListener('hidden.bs.modal', function () {

            if (interval) {
                clearInterval(interval);
                interval = null;
            }

            const countdownEl = this.querySelector('.countdown');
            const confirmBtn = this.querySelector('.archive-btn');

            if (countdownEl) countdownEl.textContent = 'You can archive in 15 seconds...';
            if (confirmBtn) confirmBtn.disabled = true;
        });
    });


    // ✅ AJAX submit
    document.querySelectorAll('.archive-form').forEach(function (form) {

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            let permitId = this.dataset.permitId;
            let formData = new FormData(this);
            let url = this.action;

            fetch(url, {
                method: 'POST', // safer for Laravel forms
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {

                    if (data.success) {

                        let modalEl = document.getElementById('archivePlanModal' + permitId);
                        let modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();

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

                        setTimeout(() => location.reload(), 1000);

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