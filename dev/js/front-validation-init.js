var Script = function () {

    /*$.validator.setDefaults({
        submitHandler: function() { alert("submitted!"); }
    });*/

    $().ready(function() {

        //common validation messages
        var uname_msg = "Please enter name";
        var uname_valid_msg = "Please enter valid name";
        var uname_min_msg = "Please enter at least 30 characters";
        var uname_max_msg = "Please enter no more than 40 characters";

        var fname_msg = "Please enter first name";
        var fname_valid_msg = "Please enter valid first name";
        var fname_min_msg = "Please enter at least 3 characters";
        var fname_max_msg = "Please enter no more than 30 characters";
        var first_name_limits = 'First name must be between 3 and 30 characters';

        var lname_msg = "Please enter last name";
        var lname_valid_msg = "Please enter valid last name";
        var lname_min_msg = "Please enter at least 3 characters";
        var lname_max_msg = "Please enter no more than 30 characters";
        var last_name_limits = 'Last name must be between 3 and 30 characters';

        var medical_license_no_msg = "Please enter medical license number";
        var medical_license_no_limits = 'Medical license number must be between 2 and 20 characters';

        var email_msg = "Please enter email id";
        var email_valid_msg = "Please enter valid email id";
        var email_remote_msg = "This email id already exists";

        var mobile_msg = "Please enter mobile number";
        var mobile_valid_msg = "Please enter valid mobile number";
        var mobile_min_msg = "Please enter at least 8 digits";
        var mobile_max_msg = "Please enter no more than 15 digits";

        var gender_msg = "Please select gender";
        var language_msg = "Please select language";

        var alt_mobile_msg = "Please enter alternate mobile number";
        var alt_mobile_valid_msg = "Please enter valid alternate mobile number";

        var zip_msg = "Please enter zipcode";
        var zip_valid_msg = "Please enter valid zipcode";
        //var zip_min_msg = "Please enter at least 4 characters"; 
        var zip_min_msg = "Please enter value between 4 and 7 characters long";
        var zip_max_msg = "Please enter no more than 7 characters";
        var zipcode_limits = 'Please enter value between 4 and 7 characters long';
        
        var password_msg = "Please enter password";
        var con_password_msg = "Please enter confirm password";
        var pass_mismatch = "Password and confirm password do no match";
        var password_min_msg = "Please enter at least 6 characters";
        var password_max_msg = "Please enter no more than 15 characters";

        var address_msg = "Please enter street";
        var address_min_msg = "Please enter at least 8 characters";
        var address_max_msg = "Please enter no more than 300 characters";
        var address_limits = 'Please enter value between 8 and 300 characters long';

        var landmark_msg = "Please enter landmark";
        var landmark_min_msg = "Please enter at least 8 characters";
        var landmark_max_msg = "Please enter no more than 300 characters";
        var landmark_limits = 'Please enter value between 8 and 300 characters long';

        var school_msg = "Please enter undergraduate school name";

        var university_msg = "Please enter graduate school name";

        var qualification_msg = "Please enter qualification";

        var specialization_msg = "Please enter specialization";

        var country_msg = "Please select country";

        var state_msg = "Please select state";

        var city_msg = "Please select city";

        var dob_msg = "Please enter DOB";

        var userfile_profile_msg = "Please select image(jpeg, jpg, gif and png) file format";
        var userfile_msg = "Please select pdf or image(jpeg, jpg, gif and png) file format, upto 40 MB size";

        var medical_msg = "Please upload medical license";

        var board_msg = "Please upload board certification";

        var drivers_msg = "Please upload drivers license";

        var liability_msg = "Please upload proof of liability insurance";

        var list_of_experiences_msg = "Please enter list of experiences";
        var title_msg = "Please enter title";
        var desc_min_msg = "Please enter at least 8 characters";
        var desc_max_msg = "Please enter no more than 300 characters";
        var desc_msg = "Please enter description";

        var digits = "Please enter only numeric value";
        
        jQuery.validator.addMethod("lettersonly", function(value, element) 
        {
            return this.optional(element) || /^[a-zA-Z]+$/i.test(value);
        }, "Letters only please");

        jQuery.validator.addMethod("lettersonlynspace", function(value, element) 
        {
            return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
        }, "Letters only please"); 

        jQuery.validator.addMethod("lettersndigitsnspace", function(value, element) 
        {
            return this.optional(element) || /^[a-zA-Z0-9 ]+$/i.test(value);
        }, "Only letters, digits and spaces are allowed");

        jQuery.validator.addMethod("alphaNumeric", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9!@#$%^&*()_=\[\]{};:"\\|,.<>\/?+-]+$/.test(value);
    }, "password must contain atleast one number and one character and  special characters"); 
    
        $.validator.addMethod("pwcheckspechars", function (value) {
            return /[!@#$%^&*()_=\[\]{};:"\\|,.<>\/?+-]/.test(value)
        }, "The password must contain at least one special character");
        
         $.validator.addMethod("pwchecknumber", function (value) {
            return /\d/.test(value) // has a digit
        }, "The password must contain at least one number");
        
        $.validator.addMethod("pwchecklowercase", function (value) {
            return /[a-zA-Z]/.test(value) // has a lowercase letter
        }, "The password must contain at least one letter");


        //Login page for user
        $("#signin_user").validate({ 
            rules: {
            
                email: { 
                    required: true,
                    email: true,
              },
               password: { 
                    required: true,
              },
                
            },
             messages: {
                        
                        email: {
                            required:email_msg,
                            email:email_valid_msg
                        },
                        password: password_msg,
                        },
         });

        //forgot pwd page for user
        $("#forgot_pwd_form").validate({ 
            rules: {
            
                forgot_email: { 
                    required: true,
                    email: true,
              },
            },
            messages: {
                        
                        forgot_email: {
                            required:email_msg,
                            email:email_valid_msg,
                        },
                    },
         });

        //type email for social login/signup page for patient
        $("#typeemail_form").validate({ 
            rules: {
            
                email: { 
                    required: true,
                    email: true,
              },
            },
             messages: {
                        
                        email: {
                            required:email_msg,
                            email:email_valid_msg
                        },
                    },
         });
          //type email for social login/signup page for patient
        $("#otp_user").validate({ 
            rules: {
                 otp: {
                    required: true,
                    digits : true,
                },
            },
             messages: {
                    otp: {
                    required: 'Please enter OTP',
                    digits: 'Please enter numbers only',
                },
            },
         });

        //Login page for user
        $("#reset_pwd").validate({ 
            rules: {
                password: { 
                    required: true,
                    minlength : 6,
                    maxlength : 15,
                    pwchecknumber : true,
                    pwchecklowercase : true,
              },
                con_password: { 
                    required: true,
                    equalTo : "#password",
              },
                
            },
             messages: {
                        
                        password: { 
                            required: password_msg, 
                        },
                        con_password: { 
                            required: con_password_msg, minlength: password_min_msg,
                            maxlength: password_max_msg, equalTo: pass_mismatch,  
                        },

                },
                        
         });

        // validate addPatient form on keyup and submit (Patient Page)
        $("#addPatientForm").validate({
            ignore: [],
            rules: {
                first_name: {
                    required: true,
                    lettersonlynspace: true,
                    maxlength : 30,
                },
                last_name: {
                    required: true,
                    lettersonlynspace: true,
                    maxlength : 30,
                },
                email: {
                    required: true,
                    email: true,

                },
                DOB: {
                    required: true,
                },
                gender: {
                    required: true,
                },
                language: {
                    required: true,
                },
                phone: {
                    required: true,
                    minlength : 8,
                    maxlength : 15,
                    digits : true,
                },
                alternate_no: {
                    required: true,
                    minlength : 8,
                    maxlength : 15,
                    digits : true,
                },
                country: {
                    required: true,
                    
                },
                state: {
                    required: true,
                },
                city: {
                    required: true,

                },
                 zipcode: {
                    required: true,
                    lettersndigitsnspace: true,
                    //digits: true,
                    minlength : 4,
                    maxlength : 7,

                },
                 address: {
                    required: true,
                    minlength : 8,
                    maxlength : 300,
                },
                 landmark: {
                    required: true,
                    minlength : 8,
                    maxlength : 300,
                },
                 password: {
                    required: true,
                    minlength : 6,
                    maxlength : 15,
                    pwchecknumber : true,
                    pwchecklowercase : true,    

                },
                 cpassword: {
                    required: true,
                    minlength : 6,
                    maxlength : 15,
                    equalTo : "#password"

                },
                userfile: {
                    accept: "image/jpg,image/jpeg,image/png,image/gif,image/bmp",
                    //filesize: 2048*1024,
                },
                
                
            },
            messages: {
                
                first_name: {
                    required: fname_msg,
                    lettersonlynspace: fname_valid_msg,
                    maxlength: fname_max_msg,
                },
                last_name: {
                    required: lname_msg,
                    lettersonlynspace: lname_valid_msg,
                    maxlength: lname_max_msg,
                },
                email: {
                    required: email_msg,
                    email: email_valid_msg,
                },
                 DOB: {
                    required: dob_msg,
                },
                gender: {
                   required: gender_msg,
                },
                language: {
                   required: language_msg,
                },
                phone: {
                    required: mobile_msg,
                    digits: mobile_valid_msg,
                    minlength: mobile_min_msg,
                    maxlength: mobile_max_msg,
                },
                alternate_no: {
                    required: alt_mobile_msg,
                    digits: alt_mobile_valid_msg,
                    minlength: mobile_min_msg,
                    maxlength: mobile_max_msg,
                },
                country: {
                    required: country_msg,
                    
                },
                state: {
                   required: state_msg,
                },
                city: {
                   required: city_msg,

                },
                 zipcode: {
                   required: zip_msg,
                   //digits: zip_valid_msg,
                   minlength: zip_min_msg,
                   maxlength: zip_max_msg,
                },
                 address: {
                   required: address_msg,
                   minlength: address_min_msg,
                   maxlength: address_max_msg,
                },
                 landmark: {
                   required: landmark_msg,
                   minlength: landmark_min_msg,
                   maxlength: landmark_max_msg,
                },
                 password: {
                   required: password_msg,
                   minlength: password_min_msg,
                   maxlength: password_max_msg,
                },
                 cpassword: {
                   required: con_password_msg,
                   equalTo: pass_mismatch,
                },
                userfile: {
                            accept: userfile_profile_msg,
                },
            }
        });

        // validate add schedule form on keyup and submit
        $("#addScheduleForm").validate({
            rules: {
                doctor: {
                    required: true,
                },
                patient: {
                    required: true,
                },
                location: {
                    required: true,
                },
                sch_time: {
                    required: true,
                },
                sch_Time: {
                    required: true,
                },
                sch_purpose: {
                    required: true,
                },
                sch_special_note: {
                    required: true,
                },
                sch_date: {
                  required: true,  
                },
                
            },
            messages: {
                
                doctor: {
                    required: "Please select doctor name",
                },
                patient: {
                    required: "Please select patient name",
                },
                location: {
                    required: "Please select location",
                },
                sch_time: {
                    required: "Please select date and time",
                },
                sch_purpose: {
                    required: "Please enter purpose",
                },
                sch_special_note: {
                    required: "Please enter special note",
                },
                sch_date: {
                    required: "Please select date",
                },
                sch_Time: {
                    required: "Please select time",
                }
               
            }
        });


        //Validation for appointment reschedule form
        $("#rescheduleForm").validate({
            rules: {
                location: {
                    required: true,
                },
                sch_time: {
                    required: true,
                },
                sch_purpose: {
                    required: true,
                },
                sch_special_note: {
                    required: true,
                },
                sch_date: {
                  required: true,  
                },
                
            },
            messages: {
                
                location: {
                    required: "Please select location",
                },
                sch_time: {
                    required: "Please select date and time",
                },
                sch_purpose: {
                    required: "Please enter purpose",
                },
                sch_special_note: {
                    required: "Please enter special note",
                },
                sch_date: {
                    required: "Please select date",
                },
               
            }
        });

        // validate add availability form on keyup and submit
        $("#addAvailabilityForm").validate({
            rules: {
                location: {
                    required: true,
                },
                sch_date_from: {
                    required: true,
                },
                sch_date_to: {
                    required: true,
                },
                sch_time_from: {
                    required: true,
                },
                sch_time_to: {
                    required: true,
                },
                user_limit: {
                    required: true,
                    digits: true,
                    min: 1,
                },
                repeat: {
                    required: true,
                },
                "day_of_week[]": {
                    required: true,
                },
                
            },
            messages: {
                
                location: {
                    required: "Please select Location.",
                },
                sch_date_from: {
                    required: "Please select Start Date.",
                },
                sch_date_to: {
                    required: "Please select End Date.",
                },
                sch_time_from: {
                    required: "Please select Start Time.",
                },
                sch_time_to: {
                    required: "Please select End Time.",
                },
                user_limit: {
                    required: "Please select User Limit.",
                    digits: digits,
                },
                repeat: {
                    required: "Please select Repeat Type.",
                },
                day_of_week: {
                    required: "Please select Day(s).",
                },
               
            }
        });

         //Edit doctor form
        $('#editDoctorForm').formValidation({
        framework: 'bootstrap',
        //excluded: [':disabled'],
        // icon: {
        //     valid: 'glyphicon glyphicon-ok',
        //     invalid: 'glyphicon glyphicon-remove',
        //     validating: 'glyphicon glyphicon-refresh'
        // },
        fields: {
            'first_name': {
                validators: {
                    notEmpty: {
                        message: fname_msg
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: fname_valid_msg
                    },
                    stringLength: {
                        message: first_name_limits,
                        min: function (value, validator, $field) {
                            return (value.match(/\r/g) || []).length-3;
                        },
                        max: function (value, validator, $field) {
                            return 30 - (value.match(/\r/g) || []).length;
                        }
                    },
                }
            },
            'last_name': {
                validators: {
                    notEmpty: {
                        message: lname_msg
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: lname_valid_msg
                    },
                    stringLength: {
                        message: last_name_limits,
                        min: function (value, validator, $field) {
                            return (value.match(/\r/g) || []).length-3;
                        },
                        max: function (value, validator, $field) {
                            return 30 - (value.match(/\r/g) || []).length;
                        }
                    },
                }
            },
            'medical_license_no': {
                validators: {
                    notEmpty: {
                        message: medical_license_no_msg
                    },
                    stringLength: {
                        message: medical_license_no_limits,
                        min: function (value, validator, $field) {
                            return (value.match(/\r/g) || []).length-2;
                        },
                        max: function (value, validator, $field) {
                            return 20 - (value.match(/\r/g) || []).length;
                        }
                    },
               }
            },
             'email': {
                validators: {
                    notEmpty: {
                        message: email_msg
                    },
                    emailAddress: {
                        message: email_valid_msg
                    }
                }
            },
            
            'DOB': {
                validators: {
                    notEmpty: {
                        message: dob_msg
                    }
                }
            },
            'specialization': {
                validators: {
                    notEmpty: {
                        message: specialization_msg
                    }
                }
            },
            'qualification': {
                validators: {
                    notEmpty: {
                        message: qualification_msg
                    }
                }
            },
            'scl_clz': {
                validators: {
                    notEmpty: {
                        message: school_msg
                    }
                }
            },
            'university': {
                validators: {
                    notEmpty: {
                        message: university_msg
                    }
                }
            },
            'gender': {
                validators: {
                    notEmpty: {
                        message: gender_msg
                    }
                }
            },
            'language': {
                validators: {
                    notEmpty: {
                        message: language_msg
                    }
                }
            },
            'list_of_experiences': {
                validators: {
                    notEmpty: {
                        message: list_of_experiences_msg
                    }
                }
            },
            'phone': {
                validators: {
                    notEmpty: {
                        message: mobile_msg
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: mobile_valid_msg
                    }
                }
            },
            'alternate_no': {
                validators: {
                    notEmpty: {
                        message: alt_mobile_msg
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: alt_mobile_valid_msg
                    }
                }
            },
            'country[]': {
                validators: {
                    notEmpty: {
                        message: country_msg
                    }
                }
            },
            'city[]': {
                validators: {
                    notEmpty: {
                        message: city_msg
                    }
                }
            },
            'state[]': {
                validators: {
                    notEmpty: {
                        message: state_msg
                    }
                }
            },
            'zipcode[]': {
                validators: {
                    notEmpty: {
                        message: zip_msg
                    },
                    regexp: {
                        regexp: /^[0-9a-zA-Z ]+$/,
                        message: zip_valid_msg
                    },
                    stringLength: {
                        message: zipcode_limits,
                        max: function (value, validator, $field) {
                            return 7 - (value.match(/\r/g) || []).length;
                        },
                        min: function (value, validator, $field) {
                            return (value.match(/\r/g) || []).length-4;
                        }
                        
                    },
                }
            },
            'address[]': {
                validators: {
                    notEmpty: {
                        message: address_msg
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9 !@#$%^&*()_=\[\]{};:"\\|,.<>\/?+-]+$/,
                        message: address_max_msg
                    },
                    stringLength: {
                        message: address_limits,
                        max: function (value, validator, $field) {
                            return 300 - (value.match(/\r/g) || []).length;
                        },
                        min: function (value, validator, $field) {
                            return (value.match(/\r/g) || []).length-8;
                        },
                        
                    },
                }
            },
            'landmark[]': {
                validators: {
                    notEmpty: {
                        message: landmark_msg
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9 !@#$%^&*()_=\[\]{};:"\\|,.<>\/?+-]+$/,
                        message: landmark_max_msg
                    },
                     stringLength: {
                        message: landmark_limits,
                        max: function (value, validator, $field) {
                            return 300 - (value.match(/\r/g) || []).length;
                        },
                        min: function (value, validator, $field) {
                            return (value.match(/\r/g) || []).length-8;
                        },
                        
                    },
                }
            },
            'userfile': {
                validators: {
                    
                    file: {
                        extension: 'jpeg,jpg,png,gif,bmp',
                        type: 'image/jpeg,image/png,image/gif,image/bmp',
                        //maxSize: 2097152,   // 2048 * 1024
                        message: userfile_profile_msg
                    }
                }
            },
            'identity_file': {
                validators: {
                    
                    file: {
                        extension: 'jpeg,jpg,png,pdf,gif,bmp',
                        type: 'image/jpeg,image/png,image/gif,image/bmp,application/pdf',
                        //maxSize: 2097152,   // 2048 * 1024
                        maxSize: 40960*1024,   // 40 * 1024 * 1024
                        message: userfile_msg
                    }
                }
            },
            'board_cert_file': {
                validators: {
                    
                    file: {
                        extension: 'jpeg,jpg,png,pdf,gif,bmp',
                        type: 'image/jpeg,image/png,image/gif,image/bmp,application/pdf',
                        //maxSize: 2097152,   // 2048 * 1024
                        maxSize: 40960*1024,   // 40 * 1024 * 1024
                        message: userfile_msg
                    }
                }
            },
            'drivers_lic_file': {
                validators: {
                    
                    file: {
                        extension: 'jpeg,jpg,png,pdf,gif,bmp',
                        type: 'image/jpeg,image/png,image/gif,image/bmp,application/pdf',
                        //maxSize: 2097152,   // 2048 * 1024
                        maxSize: 40960*1024,   // 40 * 1024 * 1024
                        message: userfile_msg
                    }
                }
            },
            'liability_ins_file': {
                validators: {
                    
                    file: {
                        extension: 'jpeg,jpg,png,pdf,gif,bmp',
                        type: 'image/jpeg,image/png,image/gif,image/bmp,application/pdf',
                        //maxSize: 2097152,   // 2048 * 1024
                        maxSize: 40960*1024,   // 40 * 1024 * 1024
                        message: userfile_msg
                    }
                }
            },
                             
        }
    }).on('click', '.add_button', function() {
            $option   = $('.new_fields').find('[name="country[]"]');
            $('#editDoctorForm').formValidation('addField', $option);
        })
      
        .on('click', '.removeButton', function() {
            $option   = $('.new_fields').find('[name="country[]"]');
            $('#editDoctorForm').formValidation('removeField', $option);
        })
        .on('click', '.add_button', function() {
            $option   = $('.new_fields').find('[name="state[]"]');
            $('#editDoctorForm').formValidation('addField', $option);
        })
      
        .on('click', '.removeButton', function() {
            $option   = $('.new_fields').find('[name="state[]"]');
            $('#editDoctorForm').formValidation('removeField', $option);
        })
        .on('click', '.add_button', function() {
            $option   = $('.new_fields').find('[name="city[]"]');
            $('#editDoctorForm').formValidation('addField', $option);
        })
      
        .on('click', '.removeButton', function() {
            $option   = $('.new_fields').find('[name="city[]"]');
            $('#editDoctorForm').formValidation('removeField', $option);
        })
        .on('click', '.add_button', function() {
            $option   = $('.new_fields').find('[name="zipcode[]"]');
            $('#editDoctorForm').formValidation('addField', $option);
        })
      
        .on('click', '.removeButton', function() {
            $option   = $('.new_fields').find('[name="zipcode[]"]');
            $('#editDoctorForm').formValidation('removeField', $option);
        })
        .on('click', '.add_button', function() {
            $option   = $('.new_fields').find('[name="address[]"]');
            $('#editDoctorForm').formValidation('addField', $option);
        })
      
        .on('click', '.removeButton', function() {
            $option   = $('.new_fields').find('[name="address[]"]');
            $('#editDoctorForm').formValidation('removeField', $option);
        })
         .on('click', '.add_button', function() {
            $option   = $('.new_fields').find('[name="landmark[]"]');
            $('#editDoctorForm').formValidation('addField', $option);
        })
      
        .on('click', '.removeButton', function() {
            $option   = $('.new_fields').find('[name="landmark[]"]');
            $('#editDoctorForm').formValidation('removeField', $option);
        })
        .on('err.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                data.fv.disableSubmitButtons(false);
            }
        })
        .on('success.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                data.fv.disableSubmitButtons(false);
            }
        }); 


        //validating landing home page
        /*$("#landing_home").validate({
            rules: {
                first_name: {
                    required: true,
                    lettersonly: true,
                    maxlength : 30,
                },
                last_name: {
                    required: true,
                    lettersonly: true,
                    maxlength : 30,
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                    url: check_user_email,
                    type: "post",
                    data: {
                      email: function() {
                        return $( "#email" ).val();
                      }
                    }
                  },

                },
                mobile: {
                    required: true,
                    digits: true,
                    minlength : 8,
                    maxlength : 15,
                },
            },
            messages: {
                
                first_name: {
                            required: fname_msg,
                            lettersonly: fname_valid_msg,
                            maxlength : fname_max_msg,
                },
                last_name: {
                            required: lname_msg,
                            lettersonly: lname_valid_msg,
                            maxlength : lname_max_msg,
                },
                email: {
                            required: email_msg,
                            email: email_valid_msg,
                            remote: email_remote_msg,
                },
                mobile: {
                            required: mobile_msg,
                            digits: mobile_valid_msg,
                            minlength: mobile_min_msg,
                            maxlength: mobile_max_msg,
                },
            },

        });*/
        

        
        // validate signup form on keyup and submit (Profile Page)
        $("#signup_user").validate({
            rules: {
                first_name: {
                    required: true,
                    lettersonlynspace: true,
                    maxlength : 30,
                },
                last_name: {
                    required: true,
                    lettersonlynspace: true,
                    maxlength : 30,
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                    url: check_user_email,
                    type: "post",
                    data: {
                      email: function() {
                        return $( "#email" ).val();
                      }
                    }
                  },

                },
                mobile: {
                    required: true,
                    digits: true,
                    minlength : 8,
                    maxlength : 15,
                },
                password: {
                    required: true,
                    minlength : 6,
                    maxlength : 15,
                    pwchecknumber : true,
                    pwchecklowercase : true,

                },
                is_physician: {
                    required: true
                },
                agree_check:{
                    required:true
                },
                specialization:{
                    required:true
                }
            },
            errorPlacement: function(error, element) {
              if (element.attr("name") == "agree_check") {
                 error.insertAfter(".agree_checkbox");
              } else {
                 error.insertAfter(element);
              }
            },
            messages: {
                
                first_name: {
                            required: fname_msg,
                            lettersonlynspace: fname_valid_msg,
                            maxlength : fname_max_msg,
                },
                last_name: {
                            required: lname_msg,
                            lettersonlynspace: lname_valid_msg,
                            maxlength : lname_max_msg,
                },
                email: {
                            required: email_msg,
                            email: email_valid_msg,
                            remote: email_remote_msg,
                },
                mobile: {
                            required: mobile_msg,
                            digits: mobile_valid_msg,
                            minlength: mobile_min_msg,
                            maxlength: mobile_max_msg,
                },
                password: {
                            required: password_msg,
                            minlength: password_min_msg,
                            maxlength: password_max_msg,
                },
                is_physician: {
                    required: "Please select one option.",
                },
                agree_check :{
                    required:"You must agree with the terms and conditions.",
                },
                specialization: {
                    required: "Please select specialization.",
                }
            },

            /*errorPlacement: function(error, element) {
                element.attr("placeholder", error.text());
            }

            errorPlacement : function(error, element) {
                error.insertAfter(element);
            }*/

           /* errorPlacement: function(error, element) 
            {
                //alert(error.text());
                 if (error.text()=='Please enter name' || error.text()=='Please enter email' || error.text()=='Please enter mobile number' || error.text()=='Please enter password') 
                 {
                     
                     element.attr("placeholder", error.text());
                 } 
                 else
                 {
                     error.insertAfter(element);
                 }

                 // if(element.attr('name') == 'uname')
                 // {
                 //    element.attr("placeholder", error.text());
                 // }
            }*/

        });
     
    });


}();


$(document).ready(function(){

    var x = $('#cur_time').val();

    $("#sch_time").keypress(function(event) {event.preventDefault();});
    $("#sch_time_from").keypress(function(event) {event.preventDefault();});
    $("#sch_time_to").keypress(function(event) {event.preventDefault();});

     //Disable cut copy paste
    $('#password').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("#password").on("contextmenu",function(e){
        return false;
    });

    //Disable cut copy paste
    $('#con_password').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("#con_password").on("contextmenu",function(e){
        return false;
    });

    

    $( function() {
    $( "#date_of_birth1" ).datepicker({
        'changeMonth':true,
        'changeYear' : true,
        'dateFormat' : 'mm-dd-yy',
        //'minDate': new Date(1930, 1 - 1, 1),
        //'maxDate': new Date(2016, 1 - 1, 1),
        maxDate: 0,
        yearRange: "-100:+0",
    });

    $("#sch_date_from").datepicker({
           minDate: new Date(x),
           // minDate: x,
           dateFormat : 'mm-dd-yy', 
           changeMonth: true,
           changeYear : true,
           yearRange: "+0:+10",
           onSelect: function(dateText, inst){ 

            // Capture the Date from User Selection
            //var oldDate = new Date(dateText);
            var from = dateText.split("-");
            var oldDate = new Date(from[2], from[0] - 1, from[1]);
            
            // Set the Widget Properties
            $("#sch_date_to").datepicker('option', 'minDate', oldDate);
            
            }
      });
        
        // alert(x);
     $("#sch_date_to").datepicker({
          // minDate: x,
          minDate: new Date(x),
          dateFormat : 'mm-dd-yy',
          changeMonth: true,
          changeYear : true,
          yearRange: "+0:+10",
          onSelect: function(dateText, inst){ 

            // Capture the Date from User Selection
            //var endDate = new Date(dateText);
            var to = dateText.split("-");
            var endDate = new Date(to[2], to[0] - 1, to[1]);
            
            // Set the Widget Properties
            $("#sch_date_from").datepicker('option', 'maxDate', endDate);

            }

      });


        $('#sch_time_from').timepicker({
            'timeFormat' : 'h:i A',
            'step': '5',
            'minTime': '12:00 AM',
            'maxTime': '11:55 PM'
            /*onSelect: function() 
            {   //alert($(this).val());
                var cur = $(this).val();
                $('#sch_time_to').timepicker('option', 'minTime', cur);
            }*/
        });

        $('#sch_time_to').timepicker({
            'timeFormat' : 'h:i A', 
            'step': '5',
            'minTime': '12:05 AM',
            'maxTime': '12:00 AM'
            /*onSelect: function() 
            {   //alert($(this).val());
                var cur = $(this).val();
                $('#sch_time_from').timepicker('option', 'maxTime', cur); 
            }*/
        });

        //To change the time to range as per the selected time from
        $('#sch_time_from').on('changeTime', function() {
            //$('#redim_time_to').text($(this).val());
            $("#sch_time_to").attr("readonly", false);

            var time_from = $('#sch_time_from').timepicker('getTime');
            //alert(time_from);
            time_from.setTime(time_from.getTime()); 
            //time_from.setHours(time_from.getHours()+1);
            time_from.setMinutes(time_from.getMinutes()+5);
            //alert(time_from);
            $('#sch_time_to').timepicker('setTime', null);
            $('#sch_time_to').timepicker('option', 'minTime', time_from);
        });

        //Fetch the doctor meetings timings from the page
        var timeFrom = $("#timeFrom").val();
        var timeTo = $("#timeTo").val();
        var sch_date = $("#sch_date").val();
        var curr_date = $("#current_date").val();
        var curr_time = $("#current_time").val();

         $('#sch_time').timepicker({
            /*'changeMonth':true,
            'changeYear' : true,
            'dateFormat' : 'mm-dd-yy',*/
            'timeFormat' : 'h:i A',
            'step': '5'
            //'minTime': '2:00 pm',
            //'maxTime': '11:30 pm',
            //'minTime': timeFrom,
            //'maxTime': timeTo,
            /*'minDate': new Date(),
            yearRange: "-+0:+10"*/
          
        });

        if(sch_date==curr_date)
        { 
            var cur_hour = curr_time.substring(0,2);
            var cur_minute = curr_time.substring(3,5);
            var remain = cur_minute%5;
            var add_remain = 5-remain; 
            if(add_remain!=5 && add_remain!=0)
            {
                var curr_time = test_time(curr_time, 0, add_remain);
            }

            var stt = new Date("November 13, 2013 " + curr_time);
            stt = stt.getTime();

            var endt = new Date("November 13, 2013 " + timeFrom);
            endt = endt.getTime();

            if(stt >= endt) 
            {
                var new_time = curr_time;
            }
            else
            {
                var new_time = timeFrom;
            }
            
           //Fetch the doctor meetings timings from the page
            $("#sch_time").timepicker( "option", "minTime", new_time );
            $("#sch_time").timepicker( "option", "maxTime", timeTo ); 
        }
        else
        {
            //Fetch the doctor meetings timings from the page
            $("#sch_time").timepicker( "option", "minTime", timeFrom );
            $("#sch_time").timepicker( "option", "maxTime", timeTo );
        }

  });
    
    //Call the country dropdown on load
    $("#country").change();
});

function addTimeToString(timeString, addHours, addMinutes) {
  // The third argument is optional.
  if (addMinutes === undefined) {
    addMinutes = 0;
  }
  // Parse the time string. Extract hours, minutes, and am/pm.
  var match = /(\d+):(\d+)\s+(\w+)/.exec(timeString),
      hours = parseInt(match[1], 10) % 12,
      minutes = parseInt(match[2], 10),
      modifier = match[3].toLowerCase();
  // Convert the given time into minutes. Add the desired amount.
  if (modifier[0] == 'p') {
    hours += 12;
  }
  var newMinutes = (hours + addHours) * 60 + minutes + addMinutes,
      newHours = Math.floor(newMinutes / 60) % 24;
  // Now figure out the components of the new date string.
  newMinutes %= 60;
  var newModifier = (newHours < 12 ? 'AM' : 'PM'),
      hours12 = (newHours < 12 ? newHours : newHours % 12);
  if (hours12 == 0) {
    hours12 = 12;
  }
  // Glue it all together.
  var minuteString = (newMinutes >= 10 ? '' : '0') + newMinutes;
  return hours12 + ':' + minuteString + ' ' + newModifier;
}

function test_time(timeString, addHours, addMinutes) {
return addTimeToString(timeString, addHours, addMinutes);
}


//Check Unique Email
function check_email()
{   
    //alert('called');
    $.ajax({
         type: "POST", 
         url: check_emailVal,
         data: {email_id:$("#email").val()},
         success: function(data) {
            if(data==1)
            {
                document.getElementById('email_error').style.display = 'block';  
                document.getElementById('hide_txt').value = '1';  
            }
            else
            {
                document.getElementById('email_error').style.display = 'none';  
                document.getElementById('hide_txt').value = '0';  
            }
         }
     });
}

//Country state and city checks
//$(function() {

    $("#country").change( function() {
        //Blank the value for state dropdown
        var state = document.getElementById('state');
        for(var i=state.options.length-1;i>=0;i--)
        {
            state.remove(i);
        }

        //Blank the value for city dropdown
        var city = document.getElementById('city');
        for(var i=city.options.length-1;i>=0;i--)
        {
            city.remove(i);
        }
         
         //To change state dropdown
         $.ajax({
             type: "POST", 
             url: get_state,
             data: {country_id:$("#country").val(), hide_state:$("#hide_state").val()},
             success: function(html) {
                 //alert('stateid = '+html);
                 $("#state").html(html);

                //To change city dropdown        
                 $("#state").change();
             }
         });
         
     }); 

     //To change city dropdown   
    $("#state").change( function() {

        //Blank the value for city dropdown
        var city = document.getElementById('city');
        for(var i=city.options.length-1;i>=0;i--)
        {
            city.remove(i);
        }


        //To change city dropdown
         $.ajax({
             type: "POST", 
             url: get_city,
             data: {state_id:$("#state").val(), hide_city:$("#hide_city").val()},
             success: function(html) {
                //alert(html);
                $("#city").html(html);
             }
         });

    });

    //Form validation for petient form
function validatePatientForm()
{
    if(document.myForm.hide_txt.value=="1")
    {
        document.getElementById('email_error').style.display = 'block';  
        return(false);  
    }
    else
    {
        document.getElementById('email_error').style.display = 'none'; 
    }

}


function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    var lat = position.coords.latitude;
    var long = position.coords.longitude;
    $.ajax({
         type: "POST", 
         url: set_cook_url,
         data: {latitude: lat, longitude: long},
         success: function(res) {
           console.log(res);
         }
     });
}

//----Image related checks------------
function readURL(input,item) 
{  
   var ext = $("#userfile").val().split('.').pop();
    if(ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif')
    { 
         if (input.files[0]) {   
            document.getElementById('blah').style.display = "block";
            //document.getElementById('blah9').style.display = "none";
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    else
    { 
        
    }
}

function readIdentityURL(input,item) 
{   
    var ext = $("#identity_file").val().split('.').pop();
    if(ext == 'pdf')
    {
        document.getElementById('blah_identity_pdf').style.display = "inline-block";
        document.getElementById('blah_identity').style.display = "none";
        document.getElementById('blah_identity_default').style.display = "none";
    }
    else if(ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif')
    {
        document.getElementById('blah_identity_pdf').style.display = "none";
        document.getElementById('blah_identity').style.display = "inline-block";
        document.getElementById('blah_identity_default').style.display = "none";
    }
    else
    {
        document.getElementById('blah_identity_pdf').style.display = "none";
        document.getElementById('blah_identity').style.display = "none";
        document.getElementById('blah_identity_default').style.display = "inline-block";
    }

     if (input.files[0]) {   
            //document.getElementById('blah_identity').style.display = "block";
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah_identity')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    
}

function readboard_certURL(input,item) 
{   
    var ext = $("#board_cert_file").val().split('.').pop();
    if(ext == 'pdf')
    {
        document.getElementById('blah_board_cert_pdf').style.display = "inline-block";
        document.getElementById('blah_board_cert').style.display = "none";
        document.getElementById('blah_board_cert_default').style.display = "none";
    }
    else if(ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif')
    {
        document.getElementById('blah_board_cert_pdf').style.display = "none";
        document.getElementById('blah_board_cert').style.display = "inline-block";
        document.getElementById('blah_board_cert_default').style.display = "none";
    }
    else
    {
        document.getElementById('blah_board_cert_pdf').style.display = "none";
        document.getElementById('blah_board_cert').style.display = "none";
        document.getElementById('blah_board_cert_default').style.display = "inline-block";
    }

   if (input.files[0]) {   
            //document.getElementById('blah_board_cert').style.display = "block";
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah_board_cert')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
}

function readdrivers_licURL(input,item) 
{   
    var ext = $("#drivers_lic_file").val().split('.').pop();
    if(ext == 'pdf')
    {
        document.getElementById('blah_drivers_lic_pdf').style.display = "inline-block";
        document.getElementById('blah_drivers_lic').style.display = "none";
        document.getElementById('blah_drivers_lic_default').style.display = "none";
    }
    else if(ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif')
    {
        document.getElementById('blah_drivers_lic_pdf').style.display = "none";
        document.getElementById('blah_drivers_lic').style.display = "inline-block";
        document.getElementById('blah_drivers_lic_default').style.display = "none";
    }
    else
    {
        document.getElementById('blah_drivers_lic_pdf').style.display = "none";
        document.getElementById('blah_drivers_lic').style.display = "none";
        document.getElementById('blah_drivers_lic_default').style.display = "inline-block";
    }

   if (input.files[0]) {   
            //document.getElementById('blah_drivers_lic').style.display = "block";
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah_drivers_lic')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
}

function readliability_insURL(input,item) 
{   
    var ext = $("#liability_ins_file").val().split('.').pop();
    if(ext == 'pdf')
    {
        document.getElementById('blah_liability_ins_pdf').style.display = "inline-block";
        document.getElementById('blah_liability_ins').style.display = "none";
        document.getElementById('blah_liability_ins_default').style.display = "none";
    }
    else if(ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif')
    {
        document.getElementById('blah_liability_ins_pdf').style.display = "none";
        document.getElementById('blah_liability_ins').style.display = "inline-block";
        document.getElementById('blah_liability_ins_default').style.display = "none";
    }
    else
    {
        document.getElementById('blah_liability_ins_pdf').style.display = "none";
        document.getElementById('blah_liability_ins').style.display = "none";
        document.getElementById('blah_liability_ins_default').style.display = "inline-block";
    }

   if (input.files[0]) {   
            //document.getElementById('blah_liability_ins').style.display = "block";
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah_liability_ins')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
}

function test()
{
    alert('hjfjsdgh');
}

//for news image
function readNewsURL(input,item) 
{  
    var ext = $("#news_image").val().split('.').pop();
    if(ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif')
    { 
         if (input.files[0]) {   
            document.getElementById('blah_news').style.display = "block";
            //document.getElementById('blah9').style.display = "none";
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah_news')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    else
    { 
        
    }
}


//for news image
function readResoucesURL(input,item) 
{  
    var ext = $("#resources_image").val().split('.').pop();
    if(ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif')
    { 
         if (input.files[0]) {   
            document.getElementById('resources_img_div').style.display = "block";
            //document.getElementById('blah9').style.display = "none";
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#resources_img_div')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    else
    { 
        
    }
}
