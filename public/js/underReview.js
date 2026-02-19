let currentPermitId = null;

function openUnderReviewModal(permitId) {
    currentPermitId = permitId;
    var myModal = new bootstrap.Modal(document.getElementById('underReviewModal'));
    myModal.show();
}

document.getElementById('confirmUnderReview').addEventListener('click', function () {
    if (!currentPermitId) return;

    fetch("{{ route('candidate.applicants.under-review', ':id') }}".replace(':id', currentPermitId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        }
    })
    .catch(err => console.error(err));
});