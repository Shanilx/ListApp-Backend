
<div class="container">
<div class="text-center" style="margin-bottom:15px; margin-top:30px; padding-bottom:15px; border-bottom:solid 1px #FFF;">
<p style="color:#FFF; font-size:16px; font-weight:bold;">Please Click Here to Download the ListApp</p>
<a href="https://play.google.com/store/apps/details?id=com.listapp.in&hl=en" target="_blank"> <img src="<?php echo base_url(); ?>images/logo_android.png" alt="" /> </a>
</div>

    <form class="form-signin" method="POST" action="" id="loginForm" name="loginForm">
        <div class="form-signin-heading text-center">
            <h1 class="sign-title">Sign In</h1>
            <img src="<?php echo base_url(); ?>images/logo.png" alt="" style="width: 120px;"/> 
            <!-- <h2 style="color:black;">List App</h2> -->
        </div>

        <?php 
        $msg ="";
        if($this->session->flashdata('succ'))
        {
            $class = "alert-danger-suc";
            $msg .= $this->session->flashdata('succ');
        }elseif($this->session->flashdata('err'))
        {
            $class = "alert-danger";
            $msg .= $this->session->flashdata('err');
        }
        else
        {
            $class = "alert-danger";
            $msg .= validation_errors('<h5>','</h5>');
        }
        
        if($this->session->flashdata('counter_err'))
        {
            $class = "alert-danger";
            $msg .= $this->session->flashdata('counter_err');
        }
        
        if($msg!="")
        {  
            ?>
            <div class="alert alert-block <?php echo $class;?> fade in" style="text-align: center;">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="fa fa-times"></i>
                </button>
                <?php echo $msg; ?>
            </div>
            
            <?php } ?>

            <div class="login-wrap">
                <input type="text" class="form-control" placeholder="E-Mail" id="email" name="email" value="<?php if(isset($_COOKIE['a_name'])) {echo $this->input->cookie('a_name');} elseif($this->session->flashdata('posted_email')){echo $this->session->flashdata('posted_email');} ?>" autofocus >

                <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?php echo $this->input->cookie('a_password');?>">

                <button class="btn btn-lg btn-login btn-block" type="submit">
                    <i class="fa fa-check"></i>
                </button>
<!-- 
            <div class="registration">
                Not a member yet?
                <a class="" href="<?php echo base_url();?>register">
                    Signup
                </a>
            </div> -->
            <label class="checkbox">
                <input type="checkbox" value="remember-me" name="remember_me" id="remember_me"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label>

        </div>
    </form>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Forgot Password ?</h4>
                </div>
                <?php $msg ="";
                if($this->session->flashdata('succ'))
                {
                  $class = "alert alert-success";
                  $msg .= $this->session->flashdata('succ');
              }elseif($this->session->flashdata('succ'))
              {
                  $class = "alert alert-danger";
                  $msg .= $this->session->flashdata('err');
              }else
              {
                  $class = "alert-success";
                  $msg .= validation_errors();
              }
              ?> 
              <form action="" method="POST" name="admin_forgot_pwd_form" id="admin_forgot_pwd_form">
                <div class="modal-body">

                    <div class="alert alert-block <?php echo $class;?> fade in " style="display:none; text-align: center;" id="succ_change">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                          <i class="fa fa-times"></i>
                      </button>      
                      <span>Email Sent Successfully</span>        
                  </div>

                  <div class="alert alert-danger <?php echo $class;?> fade in " style="display:none; text-align:center;" id="error">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                      <i class="fa fa-times"></i>
                  </button>      
                  <span id="error_msg">Email Not Sent</span>        
              </div>

              <span  style="display:none;"></span>
              <p id="ret_t">Enter your e-mail address below to reset your password.</p>
              <p id="not_t"></p>
              <p id="succ_t"></p>
              <input type="text" name="member_email" id="member_email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
            <button class="btn btn-primary forgot" name="forgot_submit" id="forgot_submit" type="button" onclick="forgot_pwd_validate()">Submit</button>
        </div>
    </form>
</div>
</div>
</div>
<!-- modal -->

<!--   </form> -->

</div>

<?php $forgot_url = base_url().'backend/login/forgot_password'; ?>

<script type="text/javascript">
   /* $('#myModal').on('hidden.bs.modal', function () {
        $(this).find("input,textarea,select").val('').end();
        $("#succ_t").hide(); 
    });*/
    $('#myModal').on('hidden.bs.modal', function () 
    {
        $("#member_email").val('');
        document.getElementById('succ_change').style.display = 'none'; 
        document.getElementById('error').style.display = 'none'; 
    });
</script>


<script src="<?php echo base_url(); ?>js/validation-init.js"></script>

<script type="text/javascript">
   var forgot_url = "<?php echo $forgot_url; ?>";
   
   function forgot_pwd_validate()
   { 
    var valid = $('#admin_forgot_pwd_form').validate().form();
    var member_email = $("#member_email").val();
    if(valid==true)
    {
     $.ajax({
         type: "POST", 
         url: forgot_url,
         data: {member_email: member_email},
         dataType: "html",
         success: function(resp) 
         { 
            if(resp=='done')
            {
                document.getElementById('succ_change').style.display = 'block'; 
                document.getElementById('error').style.display = 'none'; 
            }
            else
            {
                document.getElementById('succ_change').style.display = 'none'; 
                $("#error_msg").text(resp);
                document.getElementById('error').style.display = 'block'; 
            }
            
            
            setTimeout(function(){ 
                $('#myModal').modal('hide'); 
                    //window.location.href="<?php echo base_url() ?>user/test_reset_password";
                }, 1000);
        }
    });
 }
 else
 {
     
 }
}

$('#member_email').keypress(function(e) { 
    if (e.keyCode == $.ui.keyCode.ENTER) {
       return false;
   }
});

</script>