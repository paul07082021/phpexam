$(document).ready(function() {
    $('#submitForm').click(function(e) {
        e.preventDefault();
        $('.form-control').removeClass('is-invalid');
        $('.toast').remove(); 
        if (!validateForm()) {
            return;
        }

        $.ajax({
            url: 'query.php',
            method: 'POST',
            data: $('#registrationForm').serialize(),
            success: function(response) {
                if (response === 'exists_email') {
                    $('#email').addClass('is-invalid');
                    showToast('error', 'Email address already exists.');
                } else if (response === 'exists_mobile') {
                    $('#mobileNumber').addClass('is-invalid');
                    showToast('error', 'Mobile number already exists.');
                } else if (response === 'success') {
                    showToast('success', 'Registration successful.');
                    $('#registrationForm')[0].reset(); 
                } else {
                    showToast('error', 'Failed to submit form. Please try again later.');
                }
            },
            error: function(xhr, status, error) {
                showToast('error', 'Failed to submit form. Please try again later.');
            }
        });
    });

    function validateForm() {
        var isValid = true;

        var fullName = $('#fullName').val().trim();
        var email = $('#email').val().trim();
        var mobileNumber = $('#mobileNumber').val().trim();
        var dob = $('#dob').val().trim();
        var gender = $('#gender').val();

        if (fullName === '') {
            $('#fullName').addClass('is-invalid');
            isValid = false;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            $('#email').addClass('is-invalid');
            isValid = false;
        }

        var mobileRegex = /^(09|\+639)\d{9}$/;
        if (!mobileRegex.test(mobileNumber)) {
            $('#mobileNumber').addClass('is-invalid');
            isValid = false;
        }

        if (dob === '') {
            $('#dob').addClass('is-invalid');
            isValid = false;
        }

        if (gender === '') {
            $('#gender').addClass('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            showToast('error', 'Please fill in all fields correctly.');
        }

        return isValid;
    }

    function showToast(type, message) {
        var toastClass = (type === 'success') ? 'bg-success text-white' : 'bg-danger text-white';

        var toast = $('<div class="toast ' + toastClass + '" role="alert" aria-live="assertive" aria-atomic="true">\
                          <div class="toast-header">\
                              <strong class="mr-auto">Notification</strong>\
                              <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">\
                                  <span aria-hidden="true">&times;</span>\
                              </button>\
                          </div>\
                          <div class="toast-body">' + message + '</div>\
                      </div>');

        toast.css({
            position: 'absolute',
            top: '20px',
            right: '20px',
            zIndex: 9999
        });

        $('.container').append(toast);
        toast.toast({ delay: 3000 });
        toast.toast('show');
    }
});
