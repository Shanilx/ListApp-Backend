$('#add_supplier').formValidation({
            //excluded: [':disabled'],
        framework: 'bootstrap',
        /*icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Please Enter Name'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'Please Enter Characters only'
                    },
                    stringLength: {
                        message: "Advertiser Name must be between 2-30 Characters",
                        min: function (value, validator, $field) {
                            return (value.match(/\r/g) || []).length-3;
                        },
                        max: function (value, validator, $field) {
                            return 30 - (value.match(/\r/g) || []).length;
                        }
                    },
                }
            },
            'mobile_number': {
                validators: {
                    notEmpty: {
                        message: "Please Enter Contact Name"
                    },
                    regexp: {
                        regexp: /^[0-9 ]+$/,
                        message: "Please Enter Number only"
                    },
                     stringLength: {
                        message: "Contact Number must be between 8-14 digit",
                        min: function (value, validator, $field) {
                            return (value.match(/\r/g) || []).length-8;
                        },
                        max: function (value, validator, $field) {
                            return 14 - (value.match(/\r/g) || []).length;
                        }
                    },
                }
            },
            'password': {
                validators: {
                    notEmpty: {
                        message: "Please Enter Password"
                    },
                    /*identical: {
                        field: 'confirmPassword',
                        message: pass_mismatch
                    },*/
                    regexp: {
                        regexp: /^[a-zA-Z0-9!@#$%^&*()_=\[\]{};:"\\|,.<>\/?+-]+$/,
                        message: "Password must contain alphanumeric"
                    }
                }
            },
             'shop_name': {
                validators: {
                    notEmpty: {
                        message: 'Please Enter Shop Name'
                    },
                    /*regexp: {
                        regexp: /^[a-zA-Z0-9 ]+$/,
                        message: 'Please Enter a'
                    },*/
                    /*stringLength: {
                        message: "Advertiser Name must be between 2-30 Characters",
                        min: function (value, validator, $field) {
                            return (value.match(/\r/g) || []).length-3;
                        },
                        max: function (value, validator, $field) {
                            return 30 - (value.match(/\r/g) || []).length;
                        }
                    },*/
                }
            },

              'area': {
                validators: {
                    notEmpty: {
                        message: 'Please Enter Area'
                    },
                    /*regexp: {
                        regexp: /^[a-zA-Z0-9 ]+$/,
                        message: 'Please Enter a'
                    },*/
                    /*stringLength: {
                        message: "Advertiser Name must be between 2-30 Characters",
                        min: function (value, validator, $field) {
                            return (value.match(/\r/g) || []).length-3;
                        },
                        max: function (value, validator, $field) {
                            return 30 - (value.match(/\r/g) || []).length;
                        }
                    },*/
                }
            },
            'address': {
                validators: {
                    notEmpty: {
                        message: 'Please Enter Area'
                    },
                    /*regexp: {
                        regexp: /^[a-zA-Z0-9 ]+$/,
                        message: 'Please Enter a'
                    },*/
                    stringLength: {
                        message: "Address Name must be between 2-150 Characters",
                        min: function (value, validator, $field) {
                            return (value.match(/\r/g) || []).length-2;
                        },
                        max: function (value, validator, $field) {
                            return 150 - (value.match(/\r/g) || []).length;
                        }
                    },
                }
            },
            'city': {
                validators: {
                    notEmpty: {
                        message: "Please Select City"
                    }
                }
            },
            'state': {
                validators: {
                    notEmpty: {
                        message: 'Please Select State'
                    }
                }
            },
             'email': {
                validators: {
                    notEmpty: {
                        message: 'Please Enter email'
                    },
                    emailAddress: {
                        message: 'Please enter valid email'
                    }
                }
            },
            'dln_no': {
                 validators: {
                    notEmpty: {
                        message: "Please Eneter DL No"
                    }
                }
            },
            'tln_no': {
                 validators: {
                    notEmpty: {
                        message: "Please Eneter TLN No"
                    }
                }
            },
            'estd_no': {
                 validators: {
                    notEmpty: {
                        message: "Please Eneter ESTD No"
                    }
                }
            },
            'contact_person[]': {
                validators: {
                    notEmpty: {
                       message: "Please Eneter conatct person"
                    }
                }
            },
            'company_deal[]': {
                validators: {
                    notEmpty: {
                       message: "Please Eneter Company deal"
                    }
                }
            },                      
        }
    }).on('click', '.add_button', function() {
            $option   = $('.field_wrapper').find('[name="contact_person[]"]');
            $('#add_supplier').formValidation('addField', $option);
        })
      
        .on('click', '.remove_button', function() {
            $option   = $('.field_wrapper').find('[name="contact_person[]"]');
            $('#add_supplier').formValidation('removeField', $option);
        })
        .on('click', '.add_button2', function() {
            $option   = $('.field_wrapper2').find('[name="company_deal[]"]');
            $('#add_supplier').formValidation('addField', $option);
        })
      
        .on('click', '.remove_button1', function() {
            $option   = $('.field_wrapper2').find('[name="company_deal[]"]');
            $('#add_supplier').formValidation('removeField', $option);
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