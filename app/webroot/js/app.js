/**
 *
 *
 * @author Zubin Khavarian <zubin.khavarian@gmail.com>
 */

$(document).ready(function() {
    // Handle all form field focus and blur, styling and animation
    var inputFields = $('#contactForm :input[type=text], #contactForm :input[type=password]');

    inputFields.focus(function() {
        $(this).animate({
            marginLeft: 5
        }, 100);

        $(this).addClass('mark-field-focused');
    });

    inputFields.blur(function() {
        $(this).animate({
            marginLeft: 0
        }, 100);

        $(this).removeClass('mark-field-focused');
    });


    //Handle sign-up form submission
    $(document.contactForm).submit(function() {
        //If validation is successfull
        //if(MyCake.validation.client.all()) {
        if(true) {
            $.ajax({
                url: 'contacts/ajax_signup_service/service:default',
                context: document.body,

                data: $('#contactForm').serializeArray(),
                type: 'POST',

                dataType: 'html',

                success: function(data) {
                    $('#result-div').html("<pre>" + data + "<pre>");
                }
            });
        }

        //If validation fails
        else {

        }

        return false; //prevent browser's default behavior
    });


    
    //Using jQuery's change event so validation checks are done only if the field value has changed and not on blur
    $('#ContactEmail').change(function() {
        var emailField = $(this);
        var messageDiv = $('#ContactEmailMsg');

        MyCake.styling.cleanupEmail();

        //Do the client and server validation if there is something entered in the field, not when it's empty
        if(emailField.val() !== "") {
            if(MyCake.validation.client.isValidEmail(emailField.val())) {
                //Client-side validation passes, send to server for availablity check
                MyCake.validation.server.checkUniqueEmail();
            }
            else {
                //Client-side validation fails
                emailField.addClass('mark-field-invalid');
                messageDiv.addClass('frm-msg-fail');
                messageDiv.attr('title', 'Invalid email format');
            }
        }
    });
});


//Namespacing used to encapsulate all of the application's client-side funtionality
var MyCake = {
    styling: {
        /**
         * Clean-up all field markings and messages associated with the email field
         */
        cleanupEmail: function() {
            var emailField = $('#ContactEmail');
            var messageDiv = $('#ContactEmailMsg');

            emailField.removeClass('mark-field-valid');
            emailField.removeClass('mark-field-invalid');
            messageDiv.removeClass('frm-msg-success');
            messageDiv.removeClass('frm-msg-fail');
        }
    },

    validation: {
        client: {
            /**
             * Run through all client-side validation rules
             */
            all: function() {
                if(
                    MyCake.validation.client.isValidEmail($('#ContactEmail').val()) &&
                    MyCake.validation.client.emailsMatch() &&
                    MyCake.validation.client.passwordsMatch() &&
                    !MyCake.validation.client.isEmpty($('#ContactFirstName').val()) &&
                    !MyCake.validation.client.isEmpty($('#ContactLastName').val())
                ) {
                    return true;
                }
                else {
                    MyCake.validation.client.markAll();
                    return false;
                }
            },

            /**
             * Mark fields and update messages after checking all fields for client-side validation
             */
            markAll: function() {
                if(!MyCake.validation.client.isValidEmail($('#ContactEmail').val())) {
                    console.log('email is invalid');
                }

                if(MyCake.validation.client.isEmpty($('#ContactFirstName').val())) {
                    var firstNameField = $('#ContactFirstName');
                    firstNameField.addClass('mark-field-invalid');
                    firstNameField.attr('title', 'Cannot be empty');
                }

                if(MyCake.validation.client.isEmpty($('#ContactLastName').val())) {
                    var lastNameField = $('#ContactLastName');
                    lastNameField.addClass('mark-field-invalid');
                    lastNameField.attr('title', 'Cannot be empty');
                }

                if(!MyCake.validation.client.passwordsMatch()) {
                    var passwordField = $('#ContactPassword');
                    var confirmPasswordField = $('#ContactConfirmPassword');

                    passwordField.addClass('mark-field-invalid');
                    passwordField.attr('title', 'Passwords don\'t match');

                    confirmPasswordField.addClass('mark-field-invalid');
                    confirmPasswordField.attr('title', 'Passwords don\'t match');
                }

                if(!MyCake.validation.client.emailsMatch()) {
                    var confirmEmailField = $('#ContactConfirmEmail');
                    confirmEmailField.addClass('mark-field-invalid');
                    confirmEmailField.attr('title', 'Emails don\'t match');
                }
            },

            /**
             * Validate matching of password fields
             */
            passwordsMatch: function() {
                return ($('#ContactPassword').val() === $('#ContactConfirmPassword').val());
            },

            /**
             * Validate email field for proper format
             */
            isValidEmail: function(emailAddress) {
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[(2([0-4]\d|5[0-5])|1?\d{1,2})(\.(2([0-4]\d|5[0-5])|1?\d{1,2})){3} \])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                return re.test(emailAddress);
            },

            /**
             * Validate matching of email fields
             */
            emailsMatch: function() {
                return ($('#ContactEmail').val() === $('#ContactConfirmEmail').val());
            },

            /**
             * Return if a given field is empty or not
             */
            isEmpty: function(field) {
                return (field === "");
            }
        },

        server: {
            /**
             * Make a server request for checking availablity of the email being used
             */
            checkUniqueEmail: function() {
                $.ajax({
                    url: 'contacts/ajax_signup_service/service:login_unique',
                    context: document.body,

                    data: {
                        'data[Contact][email]': $('#ContactEmail').val()
                    },
                    type: 'POST',

                    dataType: 'json',

                    success: function(data) {
                        var emailField = $('#ContactEmail');
                        var messageDiv = $('#ContactEmailMsg');

                       MyCake.styling.cleanupEmail();

                        messageDiv.attr('title', data.message);

                        if(data.success === true) {
                            emailField.addClass('mark-field-valid');
                            messageDiv.addClass('frm-msg-success');
                        }
                        else {
                            emailField.addClass('mark-field-invalid');
                            messageDiv.addClass('frm-msg-fail');
                        }
                    }
                });

                return false;
            }
        }
    }
};
