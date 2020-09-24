/*
 *  Document   : formsValidation.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Forms Validation page
 */

var FormsValidation = function() {

    return {
        init: function() {
            /*
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */

            /* Initialize Form Validation */
            $('#form-validation').validate({
                errorClass: 'help-block animation-pullUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); // e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    'val-fullname': {
                        required: true,
                        minlength: 3
                    },
                    'val-code': {
                        required: true,
                        minlength: 4,
                        maxlength: 4
                    },
                    'val-username': {
                        required: true,
                        minlength: 3
                    },
                    'val-email': {
                        required: true,
                        email: true
                    },
                    'val-password': {
                        required: true,
                        minlength: 5
                    },
                    'val-confirm-password': {
                        required: true,
                        equalTo: '#val-password'
                    },
                    'val-suggestions': {
                        required: true,
                        minlength: 5
                    },
                    'val-skill': {
                        required: true
                    },
                    'val-website': {
                        required: true,
                        url: true
                    },
                    'val-digits': {
                        required: true,
                        digits: true,
						minlength: 12
                    },
                    'val-number': {
                        required: true,
                        number: true
                    },
                    'val-range': {
                        required: true,
                        range: [1, 5]
                    },
                    'val-terms': {
                        required: true
                    },
                    'val-widerruf': {
                        required: true
                    }
                },
                messages: {
                    'val-fullname': {
                        required: 'Bitte tragen Sie Ihren Namen ein.',
                        minlength: 'Ihr Name muss min. 3 Zeichen haben.'
                    },
                    'val-code': {
                        required: 'Bitte tragen Sie die 4-stellige PIN ein.',
                        minlength: 'Die PIN muss 6 Zeichen haben',
                        maxlength: 'Die PIN muss 6 Zeichen haben'
                    },
                    'val-username': {
                        required: 'Please enter a username',
                        minlength: 'Your username must consist of at least 3 characters'
                    },
                    'val-email': 'Bitte tragen Sie eine gültige E-Mail-Adresse ein.',
                    'val-password': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long'
                    },
                    'val-confirm-password': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long',
                        equalTo: 'Please enter the same password as above'
                    },
                    'val-suggestions': 'What can we do to become better?',
                    'val-skill': 'Please select a skill!',
                    'val-website': 'Please enter your website!',
                    'val-digits': 'Bitte nur Ziffern ohne Sonderzeichen eintragen.',
                    'val-number': 'Please enter a number!',
                    'val-range': 'Please enter a number between 1 and 5!',
                    'val-terms': 'Sie müssen der Datschutzerklärung zustimmen.',
                    'val-widerruf': 'Sie müssen der Widerrufsbelehrung zustimmen.'
                }
            });
            $('#form-validation input').on('keyup blur', function () {
		        if ($('#form-validation').valid()) {
		            $('.submit-button').prop('disabled', false);
		        } else {
		            $('.submit-button').prop('disabled', 'disabled');
		        }
		    });
        }
    };
}();