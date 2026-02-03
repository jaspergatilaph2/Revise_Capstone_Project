document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('unifiedPermitForm');
    const modalSummary = document.getElementById('modalSummary');
    const submitBtn = document.getElementById('modalSubmitBtn');
    const nextBtn = document.getElementById('nextBtn'); // <a> link
    const confirmModal = document.getElementById('confirmModal'); // bootstrap modal

    // Initially hide the Next button
    nextBtn.style.display = 'none';

    function getCheckedValues(name) {
        return Array.from(document.querySelectorAll(`input[name="${name}[]"]:checked`))
            .map(el => el.value)
            .join(', ') || '—';
    }

    function getValue(name) {
        const el = form.querySelector(`[name="${name}"]`);
        return el && el.value ? el.value : '—';
    }

    // Populate modal when user clicks "Submit →"
    document.querySelector('[data-bs-target="#confirmModal"]').addEventListener('click', function () {
        modalSummary.innerHTML = `
            <div class="row">
                <div class="col-md-6"><strong>Application Type:</strong> ${getCheckedValues('application_type')}</div>
                <div class="col-md-6"><strong>For:</strong> ${getCheckedValues('for_type')}</div>
            </div>
            <hr>

            <h6 class="fw-bold">Owner Information</h6>
            <p><strong>Name:</strong> ${getValue('owner_lastname')}, ${getValue('owner_firstname')} ${getValue('owner_mi')}</p>
            <p><strong>TIN:</strong> ${getValue('owner_tin')}</p>
            <p><strong>Address:</strong> ${getValue('owner_address')}, ${getValue('owner_city')}</p>
            <p><strong>Contact:</strong> ${getValue('owner_contact')}</p>

            <hr>
            <h6 class="fw-bold">Construction Details</h6>
            <p><strong>Character of Construction:</strong> ${getCheckedValues('construction')}</p>
            <p><strong>Occupancy:</strong> ${getCheckedValues('occupancy')}</p>
            <p><strong>Floor Area:</strong> ${getValue('floor_area')} sqm</p>
            <p><strong>Lot Area:</strong> ${getValue('lot_area')} sqm</p>
            <p><strong>Estimated Cost:</strong> ₱${getValue('estimated_cost')}</p>

            <hr>
            <h6 class="fw-bold">Engineer / Inspector</h6>
            <p><strong>Inspector:</strong> ${getValue('inspector_name')}</p>
            <p><strong>Engineer:</strong> ${getValue('engineer_name')}</p>
            <p><strong>PRC No:</strong> ${getValue('prc_no')}</p>

            <hr>
            <h6 class="fw-bold">Applicant</h6>
            <p><strong>Signature:</strong> ${getValue('applicant_signature')}</p>
            <p><strong>Date:</strong> ${getValue('applicant_date')}</p>
        `;
    });

    // Submit via AJAX when modal confirm button is clicked
    submitBtn.addEventListener('click', function () {
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close the modal automatically
                    const bsModal = bootstrap.Modal.getInstance(confirmModal);
                    if (bsModal) bsModal.hide();

                    // Show success alert
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
                    alertDiv.role = 'alert';
                    alertDiv.innerHTML = `
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                    form.prepend(alertDiv);
                    alertDiv.scrollIntoView({ behavior: 'smooth' });

                    // Show Next button
                    nextBtn.style.display = 'inline-block';
                    sessionStorage.setItem('formSubmitted', 'true');

                } else {
                    alert(data.message || 'Failed to submit form.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred while submitting the form.');
            });
    });

    // Handle page reload/back: hide Next button if form is not submitted
    function updateNextButton() {
        if (!sessionStorage.getItem('formSubmitted')) {
            nextBtn.style.display = 'none';
        } else {
            nextBtn.style.display = 'inline-block';
            nextBtn.classList.remove('btn-primary'); // remove default blue
            nextBtn.classList.add('btn-success');    // make it green
        }
    }

    // Initial check
    updateNextButton();

    // Listen for storage changes
    window.addEventListener('storage', updateNextButton);

    // Optional interval check
    // setInterval(updateNextButton, 1000);

});
