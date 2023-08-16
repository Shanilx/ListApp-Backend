<section class="wrapper">

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
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Profile
            
                <!--  <div class="tools pull-right">
                <span class="message"><?php echo $this->session->flashdata('Register_error'); ?></span> <span><?php echo validation_errors(); ?></span> <span class="message" style="text-transform: lowercase; color:red;">Fields marked with * are required.</span>
                
            </div> -->

            </header>

           

            <div class="panel-body">
                <form class="form-horizontal adminex-form" method="POST" name="myForm_profile" id="myForm_profile" action="" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Profile Picture</label>
                        <div class="col-sm-5">

                            <div class="marginB15"> <img width="100" id="blah" src="<?php echo base_url();?>uploads/profile/<?php echo $rec['profile_pic'];?>" alt="your pic" /> </div>

                            <input type="file" class="form-control" name="userfile" id="userfile" onChange="readURL(this,this.value)">

                            <input type="hidden" value="<?php echo $rec['profile_pic']; ?>" name="prev_image">

                            <span style="display:none; color:#F00;" id="file_type_error">Please select only .jpg/.jpeg/.png </span>

                            <input type="hidden" id="hide_image" name="hide_image" value="0" />

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">First Name <span style="color:red">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="fname" id="fname" minlength="3" maxlength="30" value="<?php echo $rec['first_name'];?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Last Name <span style="color:red">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="lname" id="lname" minlength="3" maxlength="30" value="<?php echo $rec['last_name'];?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Email <span style="color:red">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="email" id="email" value="<?php echo $rec['email'];?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Address <span style="color:red">*</span></label>
                        <div class="col-sm-5">
                            <!-- <input type="text" class="form-control" name="address" id="address" value="<?php echo ucfirst($rec['address']);?>"> -->
                            <textarea class="form-control" name="address" id="address" minlength="8" maxlength="300"><?php echo ucfirst($rec['address']);?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Landmark <span style="color:red">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="landmark" id="landmark" minlength="8" maxlength="300" value="<?php echo ucfirst($rec['landmark']);?>">
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2" style="">
                            <input type="submit" value="Submit" class="btn btn-primary" style="margin-bottom:10px;">
                        </div>
                    </div>

                    
                </form>
            </div>
        </section>

        
        </div>
        </div>

</section>

<script type="text/javascript">
    var Script = function () {

    $().ready(function() {


        //Set Email text as readonly
        $('#email').prop("readonly", true);
        $("#email").keypress(function(event) {
            event.preventDefault();
        });
        
    });

// validate signup form on keyup and submit (Profile Page)
        $("#myForm_profile").validate({
            rules: {
                fname: {
                    required: true,
                    lettersonlynspace: true,
                },
                lname: {
                    required: true,
                    lettersonlynspace: true,
                },
                email: {
                    required: true,
                    email: true,

                },
                address: {
                    required: true,
                },
                landmark: {
                    required: true,

                },
                userfile: {
                    accept: "image/jpg,image/jpeg,image/png,image/gif,image/bmp",
                },
                
                
            },
            messages: {
                
                fname: {
                    required: "Please enter first name",
                    lettersonlynspace: "Please enter valid name",
                },
                lname: {
                    required: "Please enter last name",
                    lettersonlynspace: "Please enter valid name",
                },
                email: {
                            required: "Please enter email.",
                            email: "Please enter valid email",
                },
                address: {
                            required: "Please enter address",
                },
                landmark: {
                            required: "Please enter landmark",
                },
                userfile: {
                            accept: "Please select image(jpeg, jpg, gif and png) file format",
                },
            }
        });
       

}();


</script>