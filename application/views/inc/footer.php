
<!--footer section start-->
<footer style="position:fixed;">
	<?php echo date('Y');?> &copy; ListApp
</footer>
<!--footer section end-->
<?php 
$con = $this->uri->segment(2);
if($con=='Retailer') { $validation_name ="Retailer"; }else{$validation_name="Supplier";}
 ?>


</div>
<!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->

<script src="<?php echo base_url(); ?>js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/modernizr.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.nicescroll.js"></script>


<!--common scripts for all pages-->
<script src="<?php echo base_url(); ?>js/scripts.js"></script>
<script src="<?php echo base_url(); ?>js/validation-init.js"></script>
<script src="<?php echo base_url(); ?>js/dynamic_table_init.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap_formvalidation.js"></script>
<script src="<?php echo base_url(); ?>js/additional-methods.min.js"></script>

<script src="<?php echo base_url(); ?>js/ext.js"></script>


<!-- valid number -->
<script src="<?php echo base_url(); ?>js/intlTelInput.js"></script>
<script type="text/javascript" src="<?php  echo base_url(); ?>js/select2.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->



<!--gritter script-->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>js/gritter/js/jquery.gritter.js"></script>
	<script src="<?php echo base_url(); ?>js/gritter/js/gritter-init.js" type="text/javascript"></script> -->


	<!--easy pie chart-->
<!-- <script src="<?php echo base_url(); ?>js/easypiechart/jquery.easypiechart.js"></script>
	<script src="<?php echo base_url(); ?>js/easypiechart/easypiechart-init.js"></script> -->

	<!--Sparkline Chart-->
<!-- <script src="<?php echo base_url(); ?>js/sparkline/jquery.sparkline.js"></script>
	<script src="<?php echo base_url(); ?>js/sparkline/sparkline-init.js"></script> -->

	<!--icheck -->
<!-- <script src="<?php echo base_url(); ?>js/iCheck/jquery.icheck.js"></script>
	<script src="<?php echo base_url(); ?>js/icheck-init.js"></script> -->

	<!-- jQuery Flot Chart-->
<!-- <script src="<?php echo base_url(); ?>js/flot-chart/jquery.flot.js"></script>
<script src="<?php echo base_url(); ?>js/flot-chart/jquery.flot.tooltip.js"></script>
<script src="<?php echo base_url(); ?>js/flot-chart/jquery.flot.resize.js"></script> -->


<!--Morris Chart-->
<!-- <script src="<?php echo base_url(); ?>js/morris-chart/morris.js"></script>
	<script src="<?php echo base_url(); ?>js/morris-chart/raphael-min.js"></script> -->

	<!--Calendar-->
<!-- <script src="<?php echo base_url(); ?>js/calendar/clndr.js"></script>
<script src="<?php echo base_url(); ?>js/calendar/evnt.calendar.init.js"></script>
<script src="<?php echo base_url(); ?>js/calendar/moment-2.2.1.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script> -->



<!--Dashboard Charts-->
<!-- <script src="<?php echo base_url(); ?>js/dashboard-chart-init.js"></script> -->


<script type="text/javascript">

	/*=======bootstrap validatin start===========*/

var validation_name="<?php echo $validation_name;?>";

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
        				message: 'Please Enter '+validation_name+' Name'
        			},
        			/*regexp: {
        				regexp: /^[a-zA-Z_ _-]*$/,
        				message: 'Please Enter Characters only'
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
        	'mobile_number': {
                validators: {
                    notEmpty: {
                        message: "Please Enter Contact Number"
                    },
                    stringLength: {
                        min:8,
                        max: 14,
                        message: 'Please enter a value between 8 to 14 numbers'
                    },
                    numeric: {
                        message: 'Please enter numbers only',
                    }
                }
            },
            'mobile_number_R': {
        		validators: {
        			notEmpty: {
        				message: "Please Enter Mobile Number"
        			},
                    // stringLength: {
                    //     min:10,
                    //     max: 10,
                    //     message: 'Please enter a value between 8 to 14 numbers'
                    // },
                    // numeric: {
                    //     message: 'Please enter numbers only',
                    // }
        		}
        	},
        	'password': {
        		validators: {
        			notEmpty: {
        				message: "Please Enter Password"
        			},
                    stringLength: {
                        min:6,
                        max: 15,
                        message: 'Password must be between 6 to 15 Characters'
                    },
                }
            },
            'shop_name': {
            	validators: {
            		notEmpty: {
            			message: 'Please Enter Firm Name'
            		},
                }
            },
      //here route is area id
            'area': {
            	validators: {
            		notEmpty: {
            			message: 'Please Enter Area'
            		},
            	}
            },
            'address': {
            	validators: {
            		notEmpty: {
            			message: 'Please Enter Address'
            		},
            		stringLength: {
            			message: "Address must be in between 2-150 Characters",
            			min: function (value, validator, $field) {
            				return (value.match(/\r/g) || []).length-2;
            			},
            			max: function (value, validator, $field) {
            				return 150 - (value.match(/\r/g) || []).length;
            			}
            		},
            	}
            },
            'state_select': {
            	validators: {
            		notEmpty: {
            			message: 'Please Select State'
            		}
            	}
            },
            'city': {
            	validators: {
            		notEmpty: {
            			message: "Please Select City"
            		}
            	}
            },
            
            'email': {
            	validators: {
            		notEmpty: {
            			message: 'Please Enter Email'
            		},
            		regexp: {
                        regexp: /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/,
                        message: "Please Enter Valid Email"
                    },
            	}
            },
            'dln_no': {
            	validators: {
            		notEmpty: {
            			message: "Please Enter DL Number"
            		}
            	}
            },
            'tln_no': {
            	validators: {
            		notEmpty: {
            			message: "Please Enter GSTIN Number"
            		}
            	}
            },
            'estd_no': {
            	validators: {
            		notEmpty: {
            			message: "Please Select ESTD. Year"
            		}
            	}
            },
            'contact_person[]': {
                validators: {
                    notEmpty: {
                        message: "Please Enter Name"
                    },/*regexp: {
                        regexp: /^[a-zA-Z_ _-]*$/,
                        message: "Please Enter Character Only"
                    },*/
                }
            },
            'contact_person_mobile[]': {
            	validators: {
            		notEmpty: {
            			message: "Please Enter Contact Number"
            		},
                    stringLength: {
                        min:8,
                        max: 14,
                        message: 'Please enter a value between 8 to 14 numbers'
                    },
                    numeric: {
                        message: 'Please enter numbers only',
                    }
            	}
            },
            'company_deal[]': {
            	validators: {
            		/*notEmpty: {
            			message: "Please Select Company Deal With"
            		},*/
                    // regexp: {
                    //     regexp: /^[a-zA-Z_ _-]*$/,
                    //     message: "Please Enter Character Only"
                    // },
            	}
            }, 
            'authe_no_authe': {
            	validators: {
            		notEmpty: {
            			message: "Please Select Authentication Status"
            		}
            	}
            },                      
        }
    }).on('click', '.add_button', function() {
        $option   = $('.field_wrapper').find('[name="contact_person[]"]');
        $('#add_supplier').formValidation('addField', $option);
      
    }).on('click', '.add_button', function() {
        $option   = $('.field_wrapper').find('[name="contact_person_mobile[]"]');
        $('#add_supplier').formValidation('addField', $option);
      
    }).on('click', '.remove_button', function() {
        $option   = $('.field_wrapper').find('[name="contact_person[]"]');
        $('#add_supplier').formValidation('removeField', $option);
    }).on('click', '.remove_button', function() {
    	$option   = $('.field_wrapper').find('[name="contact_person_mobile[]"]');
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
    .on('err.validator.fv', function(e, data) {
        data.element
            .data('fv.messages')
            .find('.help-block[data-fv-for="' + data.field + '"]').hide()
            .filter('[data-fv-validator="' + data.validator + '"]').show();
    })
    .on('success.field.fv', function(e, data) {
    	if (data.fv.getSubmitButton()) {
    		data.fv.disableSubmitButtons(false);
    	}
    })
         .on('change', '[name="mobile_number"]', function(e) {
            $('#add_supplier').formValidation('revalidateField', 'mobile_number');
        });
      
      /*prevent key after a length*/
   $('.contact_person_mobile').on('keydown keyup', function(e){
    if ($(this).val().length >= 14 
        && e.keyCode != 46 // delete
        && e.keyCode != 8 // backspace
       ) {
       e.preventDefault();
       $(this).val();
    }
    
});
   /*prevent key after a length ends*/

 

</script>

<!-- validation for company -->
<script type="text/javascript">

    /*=======bootstrap validatin start===========*/

    $('#add_company').formValidation({
            //excluded: [':disabled'],
            framework: 'bootstrap',
       
        fields: {
            'company_name': {
                validators: {
                    notEmpty: {
                        message: 'Please Enter Company Name'

                    },
                    // regexp: {
                    //     regexp: /^[a-zA-Z_ _-]*$/,
                    //     message: 'Please Enter Characters only'
                    // },
                }
            },            
        }
    }).on('err.field.fv', function(e, data) {
        if (data.fv.getSubmitButton()) {
            data.fv.disableSubmitButtons(false);
        }
    })
    .on('success.field.fv', function(e, data) {
        if (data.fv.getSubmitButton()) {
            data.fv.disableSubmitButtons(false);
        }
    });
         
    /*prevent key after a length ends*/  
      $('body').on('keydown keyup','.contact_person_mobile', function(e){
    if ($(this).val().length >= 14 
        && e.keyCode != 46 // delete
        && e.keyCode != 8 // backspace
       ) {
       e.preventDefault();
       $(this).val();
    }
     
});
   /*prevent key after a length ends*/

 

</script>
<!-- validation for company -->





<script type="text/javascript">
    
    $(".company_deal").select2();
  
$("#checkbox").click(function(){
    if($("#checkbox").is(':checked') ){
        $(".company_deal > option").prop("selected","selected");
        $(".company_deal").trigger("change");
    }else{
        $(".company_deal > option").removeAttr("selected");
         $(".company_deal").trigger("change");
     }
});

/*$("#button").click(function(){
       alert($(".company_deal").val());
});*/


</script>
<script type="text/javascript">
  $("#sub_menu").change(function(){
     var value= $(this).val();
     //alert(value);
    if(value=="company"){
      window.location="<?php echo base_url().'apanel/Company'?>";
    }
    else if(value=="Form"){
     window.location="<?php echo base_url().'apanel/Form'?>";
    }
    else if(value=="Packing Type"){
      window.location="<?php echo base_url().'apanel/Packingtype'?>";
    }
    else if(value=="Pack Size"){
      window.location="<?php echo base_url().'apanel/Packsize'?>";
    } 
    else if(value=="Schedule"){
      window.location="<?php echo base_url().'apanel/Schedule'?>";
    }

  });

</script>

<script type="text/javascript">
//     $('body').on('keypress','.contact_person_mobile',function(){
//     var contact_number=$(this).val();
//     if(contact_number.length>8){
//         if(/^\d+$/.test(contact_number)){
//         $(this).next().html("");
//         $(".add_supplier_btn").prop('disabled',false);
//     }else{
//         $(this).next().html("Please Enter Valid Contact Number");
//         $(this).next().next().next().css('display','none');
//         $(".add_supplier_btn").prop('disabled',true);
//     }
//     }else{
//         $(this).next().html("");
//         $(".add_supplier_btn").prop('disabled',false);

//     }
    
    

// });

</script>
<!-- SHOW DEFAULT VALUE OF AJAX DATA TABLE -->
<!-- validation For Retailer Starts -->
<script type="text/javascript">
    var validation_name="<?php echo $validation_name;?>";

    $('#add_retailer').formValidation({
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
                    // notEmpty: {
                    //     message: 'Please Enter '+validation_name+' Name'
                    // },
                    /*regexp: {
                        regexp: /^[a-zA-Z_ _-]*$/,
                        message: 'Please Enter Characters only'
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
            'mobile_number_R': {
                validators: {
                    notEmpty: {
                        message: "Please Enter Mobile Number"
                    },
                    // stringLength: {
                    //     min:10,
                    //     max: 10,
                    //     message: 'Please enter a value between 8 to 14 numbers'
                    // },
                    // numeric: {
                    //     message: 'Please enter numbers only',
                    // }
                }
            },
            'password': {
                validators: {
                    notEmpty: {
                        message: "Please Enter Password"
                    },
                    stringLength: {
                        min:6,
                        max: 15,
                        message: 'Password must be between 6 to 15 Characters'
                    },
                }
            },
            'shop_name': {
                validators: {
                    notEmpty: {
                        message: 'Please Enter Firm Name'
                    },
                }
            },
      //here route is area id
            'area': {
                validators: {
                    // notEmpty: {
                    //     message: 'Please Enter Area'
                    // },
                }
            },
            'address': {
                validators: {
                    // notEmpty: {
                    //     message: 'Please Enter Address'
                    // },
                    stringLength: {
                        message: "Address must be in between 3 Characters",
                        min:3
                       
                        // max: function (value, validator, $field) {
                        //     return 150 - (value.match(/\r/g) || []).length;
                        // }
                    },
                }
            },
            'state_select': {
                validators: {
                    // notEmpty: {
                    //     message: 'Please Select State'
                    // }
                }
            },
            'city': {
                validators: {
                    // notEmpty: {
                    //     message: "Please Select City"
                    // }
                }
            },
            
            'email': {
                validators: {
                    // notEmpty: {
                    //     message: 'Please Enter Email'
                    // },
                    regexp: {
                        regexp: /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/,
                        message: "Please Enter Valid Email"
                    },
                }
            },
            'dln_no': {
                validators: {
                    /*notEmpty: {
                        message: "Please Enter DL Number"
                    }*/
                }
            },
            'tln_no': {
                validators: {
                   /* notEmpty: {
                        message: "Please Enter GSTIN Number"
                    }*/
                }
            },
            'estd_no': {
                validators: {
                    /*notEmpty: {
                        message: "Please Select ESTD. Year"
                    }*/
                }
            },
            'contact_person[]': {
                validators: {
                   /* notEmpty: {
                        message: "Please Enter Name"
                    },*//*regexp: {
                        regexp: /^[a-zA-Z_ _-]*$/,
                        message: "Please Enter Character Only"
                    },*/
                }
            },
            'contact_person_mobile[]': {
                validators: {
                    /*notEmpty: {
                        message: "Please Enter Contact Number"
                    },*/
                    stringLength: {
                        min:8,
                        max: 14,
                        message: 'Please enter a value between 8 to 14 numbers'
                    },
                    numeric: {
                        message: 'Please enter numbers only',
                    }
                }
            },
            'company_deal[]': {
                validators: {
                    /*notEmpty: {
                        message: "Please Select Company Deal With"
                    },*/
                    // regexp: {
                    //     regexp: /^[a-zA-Z_ _-]*$/,
                    //     message: "Please Enter Character Only"
                    // },
                }
            }, 
            'authe_no_authe': {
                validators: {
                    /*notEmpty: {
                        message: "Please Select Authentication Status"
                    }*/
                }
            },
            'role': {
                validators: {
                    notEmpty: {
                        message: "Please select User Type"
                    }
                }
            },                      
        },
    }).on('click', '.add_button', function() {
        $option   = $('.field_wrapper').find('[name="contact_person[]"]');
        $('#add_retailer').formValidation('addField', $option);
      
    }).on('click', '.add_button', function() {
        $option   = $('.field_wrapper').find('[name="contact_person_mobile[]"]');
        $('#add_retailer').formValidation('addField', $option);
      
    }).on('click', '.remove_button', function() {
        $option   = $('.field_wrapper').find('[name="contact_person[]"]');
        $('#add_retailer').formValidation('removeField', $option);
    }).on('click', '.remove_button', function() {
        $option   = $('.field_wrapper').find('[name="contact_person_mobile[]"]');
        $('#add_retailer').formValidation('removeField', $option);
    })
    .on('click', '.add_button2', function() {
        $option   = $('.field_wrapper2').find('[name="company_deal[]"]');
        $('#add_retailer').formValidation('addField', $option);
    })
    
    .on('click', '.remove_button1', function() {
        $option   = $('.field_wrapper2').find('[name="company_deal[]"]');
        $('#add_retailer').formValidation('removeField', $option);
    })
    .on('err.field.fv', function(e, data) {
        if (data.fv.getSubmitButton()) {
            data.fv.disableSubmitButtons(false);
        }

    })
    .on('err.validator.fv', function(e, data) {
        data.element
            .data('fv.messages')
            .find('.help-block[data-fv-for="' + data.field + '"]').hide()
            .filter('[data-fv-validator="' + data.validator + '"]').show();
    })
    .on('success.field.fv', function(e, data) {
        if (data.fv.getSubmitButton()) {
            data.fv.disableSubmitButtons(false);
        }
    })
         .on('change', '[name="mobile_number_R"]', function(e) {
            $('#add_retailer').formValidation('revalidateField', 'mobile_number_R');
        });
      
      /*prevent key after a length*/
   $('.contact_person_mobile').on('keydown keyup', function(e){
    if ($(this).val().length >= 14 
        && e.keyCode != 46 // delete
        && e.keyCode != 8 // backspace
       ) {
       e.preventDefault();
       $(this).val();
    }
    
});
</script>
<!-- validation For Retailer Ends -->
<script type="text/javascript">
    $(document).ready(function(){
       $(".dataTables_filter>label>input").val('');
       $(".dataTables_length>label>select option:first-child").attr("selected", "selected");
    });
</script>

<?php //clearstatcache();?>
</body>
</html>