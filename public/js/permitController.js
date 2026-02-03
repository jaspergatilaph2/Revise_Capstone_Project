// function setRedirect(url) {
//     document.getElementById('redirect_to').value = url;
// }

$(document).ready(function () {
    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle buttons click
    $('button[type="button"]').click(function () {
        var redirectUrl = $(this).data('redirect'); // may be empty
        var saveUrl = $('#permitForm').data('save-session-url'); // get URL from data attribute
        var formData = $('#permitForm').serialize(); // serialize all inputs

        $.ajax({
            url: saveUrl, // now dynamic from data attribute
            type: "POST",
            data: formData,
            success: function (response) {
                if (redirectUrl) {
                    window.location.href = redirectUrl; // redirect if URL is set
                } else {
                    alert('Form data saved successfully!');
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText); // log exact error
                alert('Failed to save session. Please try again.');
            }
        });
    });
});
