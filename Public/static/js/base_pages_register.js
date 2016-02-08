/*
 *  Document   : base_pages_register.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Register Page
 */


$(document).ready(function () {
    $("#thanksyousubmit").click(function () {

        if ($('.js-validation-register').valid()) {

            $.ajax({
                type: "POST",
                url: '/user/checkusernameexistQuiz',
                //dataType: 'post',
                data: {
                    user_emailQuiz: $('#emailQuiz').val(),
					WholeQuizID:$('#WholeQuizID').val()
                },
                success: function (data) {
                    if (data == true) {
                        registerUser();
                        $("#AlreadyPlayedError").html('');
                    } else {

                        $("#AlreadyPlayedError").html('Already Played. Please come back for the next round.')
                        return false;

                    }
                }

            });

        }

    });
	
	
	$("#country_list").change(function(){
	
		var value = $('select#country_list option:selected').val();
		
		$.ajax({
                type: "POST",
                url: '/user/findISDcode',
                //dataType: 'post',
                data: {
                    country_value : value,
					
                },
                success: function (data) {
                    if(data)
					{
						$("#isd").val(data);
					}
					
				}

            });
	});
	
	
});

var BasePagesRegister = function () {
    // Init Register Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationRegister = function () {
        jQuery('.js-validation-register').validate({
            errorClass: 'help-block text-right animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function (error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function (e) {
                jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            success: function (e) {
                jQuery(e).closest('.form-group').removeClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            rules: {
                'Name': {
                    required: true,
                    minlength: 1
                },
               'Mobile': {
                    required: true,
                    minlength: 9,
                    maxlength: 15,
					number: true,
                },
                'Email': {
                    required: true,
                    email: true,
                    //remote: {url: "/user/checkusernameexist", type: "post"}
                },
                'user_emailQuiz': {
                    required: true,
                    email: true,
                },
                'register-password': {
                    required: true,
                    minlength: 5
                },
                'register-password2': {
                    required: true,
					 minlength: 6
                   // equalTo: '#register-password'
                },
                'register-terms': {
                    required: true
                }
            },
            messages: {
                'Name': {
                    required: 'Please enter Name',
                    minlength: 'Your First Name must consist of at least 1 characters'
                },
                'register-Lname': {
                    required: 'Please enter Last Name',
                    minlength: 'Your username must consist of at least 1 characters'
                },
                'country_list': {
                    required: 'Please select a Country',
                    minlength: 'Your username must consist of at least 1 characters'
                },
                'mobile': {
                    required: 'Please enter  Mobile No.',
                    minlength: 'Your mobile number is invalid.'
                },
                'user_email': {
                    required: 'Please enter a valid email address',
                    remote: 'Email Id already registered'
                },
                'user_emailQuiz': {
                    required: 'Please enter a valid email address',
                },
                'register-password': {
                    required: 'Please provide a password',
                    minlength: 'Your password must be at least 5 characters long'
                },
                'register-password2': {
                    required: 'Please provide a password',
                    minlength: 'Your password must be at least 6 characters long',
                    equalTo: 'Your password must be at least 6 characters long'
                },
                'register-terms': 'You must agree to the Terms &#38; Conditions!'
            }
        });
    };

    return {
        init: function () {
            // Init Register Form Validation
            initValidationRegister();
        }
    };
}();

function registerUser() {

    var email = $("#emailQuiz").val();

    $.ajax({
        url: "/user/checkusernameexist/",
        type: 'POST',
        data: 'user_email=' + email,
        dataType: "json",
        beforeSend: function (msg) {
            // block_screen();
        },
        success: function (resp) {
            if ($('.js-validation-register').valid()) {
                if (resp == true) {

                    var firstnamequiztaker = $("#firstnamequiztaker").val();

                    var lastnamequiztaker = $("#lastnamequiztaker").val();

                    var country_listquiztaker = $("#country_listquiztaker").val();

                    var mobilequiztaker = $("#mobilequiztaker").val();

                    $.ajax({
                        url: "/user/saveUserFomQuizPage/",
                        type: 'POST',
                        data: 'email=' + email + '&&firstnamequiztaker=' + firstnamequiztaker + '&&lastnamequiztaker=' + lastnamequiztaker + '&&country_listquiztaker=' + country_listquiztaker + '&&mobilequiztaker=' + mobilequiztaker,
                        dataType: "json",
                        beforeSend: function (msg) {

                        },
                        success: function (resp) {

                            if (resp.error == 0) {

                                $(".js-validation-register").submit();

                            }

                        }
                    });

                } else {

                    $(".js-validation-register").submit();

                }
            }

        }
    });

    /*   var firstnamequiztaker = $("#firstnamequiztaker").val();
     
     var lastnamequiztaker = $("#lastnamequiztaker").val();
     
     var country_listquiztaker = $("#country_listquiztaker").val();
     
     var mobilequiztaker = $("#mobilequiztaker").val();
     
     $.ajax({
     
     url: "/user/saveUserFomQuizPage/",
     type: 'POST',
     data: 'email=' + email + '&&firstnamequiztaker=' + firstnamequiztaker + '&&lastnamequiztaker=' + lastnamequiztaker + '&&country_listquiztaker=' + country_listquiztaker + '&&mobilequiztaker=' + mobilequiztaker,
     dataType: "json",
     beforeSend: function (msg) {
     
     },
     success: function (resp) {
     
     
     
     }
     }); */
}

// Initialize when page loads
jQuery(function () {
    BasePagesRegister.init();
});
