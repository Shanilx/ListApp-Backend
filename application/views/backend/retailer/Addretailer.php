  <!--body wrapper start-->
  <style type="text/css">
  .btn_align{
        margin: 30px 150px 0px 438px;
  }
</style>
  <link href="<?php echo base_url();?>css/multiselect_box_r.css" rel="stylesheet" />
  <div class="wrapper">

    <?php 

    $msg ="";
    if($this->session->flashdata('succ'))
    {
        $class = "alert alert-success";
        $msg .= $this->session->flashdata('succ');
    }
    else{
        $class = "alert alert-danger";
        $msg .= validation_errors('<h5>','</h5>');
    }
    if($msg!="")
    {
        ?>
        <div class="alert alert-block <?php echo $class;?> fade in" style="text-align: center;">
          <button data-dismiss="alert" class="close close-sm" type="button"> <i class="fa fa-times"></i> </button>
          <?php echo $msg;?> 
      </div>

      <?php } ?>




      <div class="row">
        <div class="col-md-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb panel">
                <li><a href="<?php echo base_url();?>apanel/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?php echo base_url();?>apanel/Retailer">Manage Retailer</a></li>
                <li class="active">Add Retailer</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Retailer 

                    <span class="tools pull-right">
                     <span class="error" style="text-transform: lowercase;">All the fields marked with (*) are mandatory</span>
                 </span>


             </header>
             <div class="panel-body">
                <section class="panel">
                    <div class="panel-body">
                        <div class="col-md-12">
                         <form role="form" class="form-vertical add_retailer" action="<?php echo base_url(); ?>apanel/Retailer/Addretailer" method="post" id="add_retailer" name="add_retailer">
                            <div class="form-group col-md-6">
                               <label>Firm Name<span class="error"> *</span></label>
                               <input type="text" name="shop_name" id="shop_name" class="form-control"  placeholder="Firm Name" autocomplete="off" />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Retailer Name<span class="error"> </span></label>
                                <input placeholder="Retailer Name" type="text" name="name" id="name" class="form-control" autocomplete="off" />
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-md-6">
                               <label>Mobile Number<span class="error"> *</span></label>
                               <input placeholder="Mobile Number" type="text"   name="mobile_number_R" id="mobile_number_R" class="form-control contact_person_mobile" autocomplete="off" />
                               <span class="error"></span>
                            </div>
            <!-- <div class="form-group">
                <label>Role</label>
                <input type="text" name="role" id="role" class="form-control"/>
            </div> -->
            <div class="form-group col-md-6">
                <label>Password<span class="error"> *</span></label>
                <input placeholder="Password" type="password" name="password" id="password" class="form-control" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" style="cursor: default;" />
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-6">
                <label>Address<span class="error"> </span></label>
                <textarea placeholder="Address" name="address" id="address" class="form-control"  autocomplete="off" style="resize: vertical;"></textarea>
            </div>
            <div class="form-group col-md-6">
                <label>State<span class="error"> </span></label>
                <select name="state_select" id="state_select" class="form-control" >
                    <!-- <option value="">Select State</option> -->
                    <?php if(!empty($records)){ 
                     foreach ($records as $value) { ?>
                        <option value="<?php  echo $value['id']; ?>"><?php  echo $value['name']; ?></option>
                        
                        <?php  } } ?>
                    </select>
                </div>
            
            <div class="clearfix"></div>            
                <div class="form-group col-md-6">
                    <label>City<span class="error"> </span></label>
                    <select name="city" id="city_id" class="form-control">
                        <!-- <option value="">Select City</option>  -->
                        <option value="2229">Indore</option>
                       <!--  <option disabled>Note : Please Select State First </option> -->
                    </select>
                </div>
                <div class="form-group col-md-6">
                
                <label>Area<span class="error"> </span></label>
                <textarea type="text" name="area" id="area" class="form-control" placeholder="Area" onfocus="geolocate()" style="resize: vertical;" /></textarea>
            </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>Email<span class="error"> </span></label>
                    <input placeholder="Email" name="email" id="email" type="text" class="form-control" autocomplete="off" />
                </div>
                <div class="form-group col-md-6">
                    <label>DL Number<span class="error"> </span></label>
                    <input placeholder="DL Number" type="text" name="dln_no" id="dln_no" class="form-control" autocomplete="off">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label>GSTIN Number<span class="error"> </span></label>
                    <input placeholder="GSTIN Number" type="text" name="tln_no" id="tln_no" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-6">
                    <label>ESTD. Year<span class="error"> </span></label>
                    <!-- <input type="text" name="estd_no" id="estd_no" class="form-control"> -->
                    <select name="estd_no" id="estd_no" class="form-control">
                     <option value="">Select Year</option>    
                    <?php 
                     $year=date('Y');
                    for($i=1951; $i<=$year; $i++){?>
                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="clearfix"></div>

            <!-- <div class="form-group col-md-6">
                <label>Contact Person</label>
                <input name="contact_person" id="contact_person" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <label>Companies Deal With</label>
                <input name="company_deal" id="company_deal" type="text" class="form-control"/>
            </div> -->
            <!-- add multifield start -->
            <div class="row">
                <div class="field_wrapper form-group col-md-6" >
                    
                    <div class="form-group col-md-5">
                        <label>Contact Person<span class="error"> </span></label>
                        <input placeholder="Contact Person Name" type="text" name="contact_person[]" value="" id="contact_person"  class="form-control contact_person" autocomplete="off" />                    
                    </div>
                    <div class="form-group col-md-5">
                        <label>Contact Number<span class="error"> </span></label>
                        <input placeholder="Contact Number" type="text" name="contact_person_mobile[]" value="" id="contact_person_mobile"  class="form-control contact_person_mobile" autocomplete="off"/>  
                        <span class="error"></span>                  
                    </div>
                    <div class="form-group col-md-1" style="padding-left: 0px;"><a style="margin-top: 24px; href="javascript:void(0);" class="add_button btn btn-primary" title="Add field"><i class="fa fa-plus"></i></a></div>
                </div>
                <!-- <div class="field_wrapper2 form-group col-md-6"  >
                 
                 <label>Companies Deal With <span style="font-size:12px;color:#8c8cc1;">(If desired company is not found then please use below link of Add Company to add the desired company)</span></label><br/>
                 <select data-placeholder="Select Company" multiple id="company_deal" style="width: 96%;height:auto;" name="company_deal[]" class="form-control company_deal">

                     <?php
                     if(!empty($companies)){
                        foreach ($companies as $company) {
                           echo '<option value="'.$company['company_id'].'">'.$company['company_name'].'</option>';
                        }
                     }

                     ?>
                </select>
                <a id="add_new_company" href="javascript:void(0)" class="btn btn-link" style="float:right;margin-right: 9px;margin-bottom: 10px;margin-top: 2px;">Add Company</a>
                <div id="add_new_company_div"></div>
         </div> -->        
         <!-- add multifield end -->
         <div class="form-group col-md-6">
            <label>Authenticated/Not Authenticated<span class="error"> </span></label>
            <select name="authe_no_authe" id="authe_no_authe" class="form-control">
                <option value="">Select Authentication</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        </div>
         
        <div class="form-group col-md-6">
            <label>User Type<span class="error"> *</span></label>
            <select name="role" id="role" class="form-control">
                <option value="">Select User Type</option>
                <option value="3">Retailer</option>
                <option value="2">Supplier</option>
                <option value="5">Company</option>
                <option value="4">Other</option>
            </select>
        </div>
        <div class="form-group col-md-12 btn_align">
            <!-- <button class="btn btn-primary">Submit</button> -->
            <input class="btn btn-primary add_retailer_btn" type="submit" name="add_submit" value="Save" id="add_retailer_btn">
             <a style="margin-left:10px;" href="<?php echo base_url('apanel/Retailer');?>"  class="btn btn-primary">Cancel</a>
        </div>
    </form>
</div>

</div>
</section>
</div>
</section>
</div>

<script type="text/javascript">
 $(document).ready(function(){
    var maxField = 5; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div class="clearfix"></div><div><div class="form-group col-md-5"><input type="text" name="contact_person[]" value="" id="contact_person"  class="form-control contact_person" placeholder="Contact Person Name " /></div><div class="form-group col-md-5"><input type="text" name="contact_person_mobile[]" value="" id="contact_person_mobile"  class="form-control contact_person_mobile" placeholder="Contact Number" /> </div><a href="javascript:void(0);"  class="remove_button btn btn-primary col-md-1" title="Remove field"><i class="fa fa-minus" style="font-size:15px;"></i></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }else{
          alert('Maximum 5 Contact Persons can be Added');
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
       var val=$(this).parent('div').children('div').children("input[id*='contact_person']").val().trim();
       if(val.length > 0){
       if(confirm("Do you really want to delete this Contact Details ?")){
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter

       }
     }
     else{

        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
       }
    });

});
</script>

<script type="text/javascript">
   $(document).ready(function () {
    $("body").on('change','#state_select',function(){
        var state_id=$("#state_select").val();
        //alert(state_id);
        $.ajax({
         url:"<?php echo base_url('apanel/Retailer/getAllcities');?>",
         type:"POST",
         data:{'state_id':state_id },
         success : function(data){
                        //alert(data);
                        if(data){
                            $("#city_id").html(data);
                        }
                    }
                });
        
    });
    
});


</script>

    <script>
      var placeSearch, autocomplete;
      var componentForm = {
        //street_number: 'short_name',
        //route: 'long_name',
        //locality: 'long_name',
        //administrative_area_level_1: 'short_name',
       // country: 'long_name',
        //postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('area')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeiQAKHG6pyQGsDTmdvYGHp9iB88A3gJQ&libraries=places&callback=initAutocomplete"
        async defer></script>
    <script type="text/javascript">
        $("#add_new_company").click(function () {
         $("#add_new_company_div").append('<div class="form-group"><input placeholder="Company Name" type="text" name="company_deal_new[]" value="" id="company_deal"  class="form-control company_deal" autocomplete="off" style="width:85%;"/><a href="javascript:void(0);" style="float: right;margin-top: -34px;margin-right: 18px;"  class="remove_input btn btn-primary " title="Remove field"><i class="fa fa-minus" style="font-size:11px;"></i></a></div>');
        });
        $('#add_new_company_div').on('click', '.remove_input', function(e){ //Once remove button is clicked
        e.preventDefault();        
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    </script>

  
    

<script type="text/javascript">
         
        $("#add_retailer").validate({
            ignore: [],
            rules: {
          mobile_number_R: {
            digits: true,
            minlength : 10,
            maxlength : 10,
                   remote: {
                          url: retailer_check_url,
                          type: "post",
                          data: {
                                    mobile_number: function() 
                                    {
                                    return $("#mobile_number_R").val();
                                    }
                                }
                            } 
                },
                email: {
                    remote: {
                          url: retailer_check_url,
                          type: "post",
                          data: {
                                    email: function() 
                                    {
                                    return $("#email").val();
                                    }
                                }
                            } 
                },
               
        },
        messages:{
          'mobile_number_R':{         
            minlength:"Please enter 10 digit mobile number",
            maxlength:"Please enter 10 digit mobile number",
            remote:"Mobile Number already exist",
            digits:"Please enter valid mobile number",

          },
         
          'email':{
            remote:"Email Already Exist"

          }
        }
    });
  $('.add_retailer input').on('keyup blur', function () { // fires on every keyup & blur
        if ($('.add_retailer').valid()) {                   // checks form for validity
            $('.add_retailer_btn').prop('disabled', false);        // enables button
        } else {
            $('.add_retailer_btn').prop('disabled', 'disabled');   // disables button
        }
    });

        /*prevent key after a length*/
   $('#mobile_number_R').on('keydown keyup', function(e){
    if ($(this).val().length >= 10 
        && e.keyCode != 46 // delete
        && e.keyCode != 8 // backspace
       ) {
       e.preventDefault();
       $(this).val();
    }
    
});  
   $('#password').on('keydown keyup', function(e){
    if ($(this).val().length >= 15 
        && e.keyCode != 46 // delete
        && e.keyCode != 8 // backspace
       ) {
       e.preventDefault();
       $(this).val();
    }
    
});
   /*prevent key after a length ends*/
    </script>
