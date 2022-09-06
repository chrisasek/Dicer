(function ($) {
    'use_strict';

    $messagePoint = $('#mp_modal');
    // Messages module
    var Messaging = {
        showMessage: function ($title, $msg, $function) {
            $messagePoint.find('#mp_modal').text($title);
            $messagePoint.find('.modal-body').text($msg);
            return $messagePoint.modal('show').on('hidden.bs.modal', $function).promise();
        }
    }

    $('.slugit').slugit();

    function reload2home(time = 5000, to = null) {
        setTimeout(function () { // wait for 5 secs(2)
            to ? location.href = to :
                location.reload(); // then reload the page.(3)
        }, time);
    }

    function processHttpRequests(url, data, re) {
        if (url && data) {
            return $.ajax({
                url: url,
                data: data,
                cache: false,
                type: 'post',
                dataType: re
            }).promise();
        }
    }

    // Validate inputs
    $('form').validate({
        // Check focus
        onfocusout: function (element) {
            //console.log(this.element(element));
            !this.element(element) || !$(element).val() || $(element).val() == 'default' ? $(element).addClass('red-border') : $(element).addClass('input-no-error');

        },
        // Set rules
        rules: {
            first_name: required = true,
            last_name: required = true,
            agree: required = true,
            dayof: required = true,
            timeofday: required = true,
            accname: required = true,
            bankname: required = true,
            amount: {
                required: true,
                number: true,
            },
            address: {
                required: true,
                maxlength: 250
            },
            username: {
                required: true,
                maxlength: 50,
                minlength: 4
            },
            fullname: {
                required: true,
                minlength: 4,
                maxlength: 100,
                wordCount: ['2']
            },
            phone: {
                required: true,
                minlength: 11,
                maxlength: 14,
                number: true
            },
            password: {
                required: true,
                minlength: 6
            },
            password_again: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            },
            tandc: {
                required: true
            }
        },
        // Message for the rules
        messages: {
            first_name: "Please enter firstname",
            last_name: "please enter lastname",
            agree: "Please agree to this",
            dayof: "Must not be empty",
            timeofday: "Must not be empty",
            accname: "This is highly required",
            bankname: "This is highly required",
            username: {
                required: "Enter a username",
                maxlength: "Must not be longer than 100 characters",
                minlength: "Must consists of at least 4 characters"

            },
            address: {
                required: "Please provide your address",
                maxlength: "Address must not be longer than 250 characters."
            },
            fullname: {
                required: "Enter your full name starting with surname",
                minlength: "Must consists of al least 4 characters",
                maxlength: "Must not be longer than 100 characters",
                wordCount: 'Minimum of two words required'

            },
            phonenumber: {
                required: "Enter a phone number",
                minlength: 'This must be a valid phone number!',
                maxlength: "Must not be more than 14 digits",
                number: "Must not be a valid phone number"

            },
            password: {
                required: "Please provide password",
                minlength: "Password must be atleast 6 characters"
            },
            password_again: {
                required: "Confirm password is required",
                minlength: "confirm password must be atleast 6 characters",
                equalTo: "Please password must match"
            },
            tandc: {
                required: "Please accept our terms and conditions"
            },
            amount: {
                required: "Please this is required and must be filled out",
                number: "This field accepts only positive numbers",
                min: "Please select amount within your savings frequency. Daily(N500 above), Weekly(N1000 above) Monthly(N5000 above) "
            }
        }

    });

    $('.toggler').on('click', function (e) {
        e.preventDefault();
        if ($('#' + $(this).data('toggle')).is(':visible')) {
            $('#' + $(this).data('toggle')).removeClass('d-block').addClass('d-none');
        } else {
            $('#' + $(this).data('toggle')).removeClass('d-none').addClass('d-block');
        }
    });

    // tool tips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })



    // bsCustomFileInput.init()
})(jQuery);