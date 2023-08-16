<?php error_reporting(0);
if($this->uri->segment(2)!='product'){
  $this->load->library('session');
  $this->session->unset_userdata('per_page');
    //$this->session->set_userdata(array('per_page'=>$this->uri->segment(4)));
     }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>images/listappfav.png"/>

  <title><?php echo $title; ?></title>

  <!--icheck-->
  <!-- <link href="<?php echo base_url(); ?>js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>js/iCheck/skins/square/square.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>js/iCheck/skins/square/red.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>js/iCheck/skins/square/blue.css" rel="stylesheet"> -->

  <!--dashboard calendar-->
  <!-- <link href="<?php echo base_url(); ?>css/clndr.css" rel="stylesheet"> -->

  <!--Morris Chart CSS -->
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>js/morris-chart/morris.css"> -->


  <!--pickers css-->
  <!-- <link rel="stylesheet" type="text/css" href="<?php //echo base_url();?>js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="<?php //echo base_url();?>js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="<?php //echo base_url();?>js/bootstrap-datetimepicker/css/datetimepicker-custom.css" /> -->
  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
  <!-- <script src="<?php echo base_url();?>js/jquery/jquery-1.11.1.min.js"></script> -->
  <script src="<?php echo base_url();?>js/jquery/jquery-1.12.4.js"></script>
  <script src="<?php echo base_url();?>js/jquery/jquery-ui.js"></script>
  <script src="<?php echo base_url();?>js/jquery/jquery.validate.min.js"></script>
  <script src="<?php echo base_url();?>js/jquery/additional-methods.min.js"></script>
  
  <script type="text/javascript" src="<?php echo base_url();?>js/data-tables/jquery.dataTables.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>js/data-tables/DT_bootstrap.js"></script>

  
  <link href="<?php echo base_url();?>js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
   <link href="<?php echo base_url();?>js/ajax_dataTable_rn/jquery.dataTable.css" rel="stylesheet" />
  <link href="<?php echo base_url();?>js/advanced-datatable/css/demo_table.css" rel="stylesheet" />

  <script type="text/javascript" src="<?php echo base_url();?>js/ajax_dataTable_rn/jquery.dataTables.js"></script>

  <!-- <script src="<?php echo base_url();?>js/editable-table.js"></script> -->


  <!--common-->
  <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/style-responsive.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">


  <!-- timepicker addon files -->
  <!-- <script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-timepicker-addon.js"></script>
  <link href="<?php echo base_url();?>css/jquery-ui-timepicker-addon.css" rel="stylesheet" /> -->

  <script type="text/javascript" src="<?php echo base_url();?>js/jquery.timepicker.js"></script>
  <link href="<?php echo base_url();?>css/jquery.timepicker.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" /> -->
  <link href="<?php echo base_url();?>css/multiselect_box_r.css" rel="stylesheet" />

<!--  <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->
 <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.js"></script>
  <script type="text/javascript" src="https://cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>
  <script type="text/javascript" src="https://cdn.ckeditor.com/4.4.6/basic/adapters/jquery.js"></script> -->
    

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
   /* small.help-block {
  display: none !important;
}

small.help-block:first-of-type {
  display: block !important;
}*/
.nicescroll-rails
   {
      width:14px !important;
  }.nicescroll-rails > div
   {
      width:14px !important;
  }
  </style>

</head>

<body class="sticky-header">

<section>
<?php include('left_nav.php');?>
    
    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <div class="header-section">

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-bars"></i></a>
            <!--toggle button end-->

            <!--notification menu start -->
            <div class="menu-right">
                <ul class="notification-menu">
                   
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <!-- <img src="images/photos/user-avatar.png" alt="" /> -->
                            <?php echo ucfirst($this->session->userdata('admin_fname'))." ".ucfirst($this->session->userdata('admin_lname'));?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                            <li><a href="<?php echo base_url();?>apanel/profile"><i class="fa fa-user"></i>  Profile</a></li>
                            <!-- <li><a href="#"><i class="fa fa-cog"></i>  Settings</a></li> -->
                            <li><a data-toggle="modal" href="#myModal" ><i class="fa fa-gear"></i> Change Password</a></li>
                            <li><a href="<?php echo base_url();?>apanel/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->


        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Change Password</h4>
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
                  <div class="alert alert-block <?php echo $class;?> fade in" style="display:none; text-align: center;" id="succ_change">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                              <i class="fa fa-times"></i>
                          </button>      
                        <span>Password Changed Successfully</span>        
                  </div>


                    <form method="POST" id="myForm" name="changePasswordForm">
                      <div class="modal-body clearfix">
                          <span  style="display:none;"></span>
                          <!-- <p id="ret_t">Enter your e-mail address below to reset your password.</p> -->
                        <div class="form-group clearfix">
                                    <input type="password" name="new_pass" id="new_pass" placeholder="Password" autocomplete="off" class="form-control placeholder-no-fix" maxlength="15" required>
                                    <span class="help-block" style="color:red; display:none;" id="pass_error">Password must contain atleast one alphabet and one number. Password length must be minimum 6 and maximum 15 characters.</span>
                        </div>
                        
                          <div class="form-group clearfix">
                          <input type="password" name="confirm_pass" id="confirm_pass" placeholder="Re-type Password" autocomplete="off" class="form-control placeholder-no-fix" maxlength="15" required>
                          <span class="help-block" style="color:red; display:none;" id="error">Password is not matched</span> 
              </div>
                      </div>
                      <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                          <button class="btn btn-primary" type="button" onclick="validatePasswordForm()">Update</button>
                      </div>
                  </form>
                </div>
            </div>
        </div>
        <!-- modal -->

        <?php $changePass_url = base_url().'backend/login/ChangePassword'; ?>

        <script type="text/javascript">

            var changePass_url = "<?php echo $changePass_url ?>";

            $('#myModal').on('hidden.bs.modal', function () {
                $(this).find("input,textarea,select").val('').end();
                document.getElementById('succ_change').style.display = 'none'; 
                document.getElementById('pass_error').style.display = 'none';  
                document.getElementById('error').style.display = 'none'; 
              });
        </script>

         <?php
            // echo date_default_timezone_get();
            // echo date('d-m-Y h:i:s');
            // // echo ini_get('date.timezone');
          // echo "<pre>";
          $info = $_SERVER;
          // print_r($info);
          $st = $info['REQUEST_TIME'] ;//  a timestamp 
          // $dt = date('d-m-Y',$st);
          // echo $dt;
        ?>
        <input type="hidden" id="cur_time" value="<?php echo date("Y-m-d",$st); ?>">

  <?php
    $company_check_url = base_url().'apanel/company/check_company_name';
    $schedule_check_url = base_url().'apanel/Schedule/check_shedule_name';
    $product_check_url = base_url().'apanel/product/check_product_name';
    $retailer_check_url = base_url().'apanel/Retailer/check_emial_mobile';
  ?>
<script type="text/javascript">

var company_check_url = "<?php echo $company_check_url; ?>"; 
var schedule_check_url = "<?php echo $schedule_check_url; ?>"; 
var product_check_url = "<?php echo $product_check_url; ?>"; 
var retailer_check_url = "<?php echo $retailer_check_url; ?>"; 

</script>
<script type="text/javascript">
  $("#new_pass").keyup(function(){
            var value=$(this).val().trim();
           // $("#schedule_sug_box").hide();
            if(value.length >6){
              $('#pass_error').html('');
               // document.getElementById('succ_change').style.display = 'none'; 
               //  document.getElementById('pass_error').style.display = 'none';  
               //  document.getElementById('error').style.display = 'none'; 
                //alert(value);
             
            }
        });
   var forgot_url = "https://listapp.in/backend/login/forgot_password";
</script>