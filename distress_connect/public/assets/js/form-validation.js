jQuery.validator.addMethod("landphone", function(value, element) {
    return this.optional(element) || /^([0-9]{4}[\-]{1}[0-9]{7})$/i.test(value);
}, "");
//}, "plz enter 4-digits std code and 7 digitd number");


jQuery.validator.addMethod("mobileorlandphone", function(value, element) {
    return this.optional(element) ||
            ( /^-?\d+$/.test(value) && value.length == 10 ) ||
            ( /^([0-9]{4}[\-]{1}[0-9]{7})$/i.test(value) || /^([0-9]{4}[\-]{1}[0-9]{6})$/i.test(value) );
}, "");
//}, "Either enter mobile or land line number");


jQuery.validator.addMethod("cusinteger", function(value, element) {
    return this.optional(element) ||
            ( /^\d+$/.test(value) )
}, "");
//}, "Not a valid whole number(e.g. 40)");

jQuery.validator.addMethod("integer_decimal", function(value, element) {
	regexp = /^[0-9]+([,.][0-9]+)?$/g;
	return this.optional(element) ||
		(regexp.test(value))
}, "Only numbers and floating point.");

jQuery.validator.addMethod("notEqualTo", function(value, element, param) {
    return this.optional(element) || value != $(param).val();
}, "This has to be different...");


jQuery.validator.addMethod("hhid", function(value, element) {
    return this.optional(element) ||
            ( /^-?\d+$/.test(value) && value.length == 12 );
}, "Enter 12 digit HH ID number");

var FormValidation = function () {
    // Login form validation
	var login_form = function() {
        var eLoginForm = $('#login_form');
        eLoginForm.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: true,
            ignore: "",
            rules: {
                username: { required: true },
                password: { required: true }
            },
            //display error alert on form submit
            invalidHandler: function (event, validator) { },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.help-inline').removeClass('ok'); // display OK icon
                $(element)
                    .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group

            },

            submitHandler: function (form) {
                form.submit();
            }
        });
    }

    var change_password_form = function() {
        var change_password_form = $('#change_password_form');
        change_password_form.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: true,
            ignore: "",
            rules: {
                new_password: { required: true },
                cnf_password: { required: true, equalTo: '#new_password' }
            },

            invalidHandler: function (event, validator) {},

            // hightlight error inputs
            highlight: function (element) {
                $(element)
                    .closest('.help-inline').removeClass('ok'); // display OK icon
                $(element)
                    .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group

            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            submitHandler: function (form, element) {
                form.submit();
            }
        });
    }

    var new_user_form = function() {
        var new_user_form = $('#new_user_form');
        new_user_form.validate({
            errorElement: 'span',
            errorClass: 'help-inline',
            focusInvalid: true,
            ignore: "",
            rules: {
                fullname: { required: true },
                email: { required: true, email: true },
                phone: { required: true, cusinteger:true },
                //status: { required: true },
                role: { required: true},
            },

            invalidHandler: function (event, validator) {},

            // hightlight error inputs
            highlight: function (element) {
                $(element)
                    .closest('.help-inline').removeClass('ok'); // display OK icon
                $(element)
                    .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group

            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            submitHandler: function (form) {
                form.submit();
            }
        });
    }



    return {
        //main function to initiate the module
        init: function () {
            login_form();
            change_password_form();
            new_user_form();
        },

	// wrapper function to scroll to an element
        scrollTo: function (el, offeset) {
            pos = el ? el.offset().top : 0;
            jQuery('html,body').animate({
                    scrollTop: pos + (offeset ? offeset : 0)
                }, 'slow');
        }
    };
}();
