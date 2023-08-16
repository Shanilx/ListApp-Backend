  <!--body wrapper start-->
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
                <li><a href="<?php echo base_url();?>apanel/Notification">Manage Notification</a></li>
                <li class="active">Send Notification</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Notification

                    <span class="tools pull-right">
                     <span class="error" style="text-transform: lowercase;">all the fields marked with (*) are mandatory</span>
                 </span>

             </header>
             <div class="panel-body">
                <section class="panel">
                    <div class="panel-body">
                    <div class="col-md-12">
                       <form role="form" class="form-vertical" action="<?php echo base_url(); ?>apanel/Notification/Add_Notification" method="post" id="Add_Notification" name="Add_Notification">
                       <div class="col-md-12">
                        <div class="form-group col-md-2">
                          <label>Notification Type<span class="error"> *</span></label>
                        </div>
                        <div class="form-group col-md-6">
                          <select name="notification_type" id="notification_type" class="form-control">
                            <option value="">Select Notification Type</option>
                            <option value="1">General Notification</option>
                            <option value="2">Application Update Notification</option>
                          </select>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group col-md-2">
                          <label>Title<span class="error"> *</span></label>
                        </div>
                        <div class="form-group col-md-6">
                          <input type="text" name="notification_title" id="notification_title" class="form-control"/>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group col-md-2">
                          <label>Message<span class="error"> *</span></label>
                        </div>
                        <div class="form-group col-md-6">
                          <textarea name="message" id="message" style="resize: vertical;width: 455px;"></textarea>
                        </div>
                     </div>
                         



                        <div class="form-group col-md-4" style="text-align: right;">
                          <input class="btn btn-primary" type="submit" name="add_submit" value="Send">
                          <a href="<?php echo base_url();?>apanel/Notification" class="btn btn-primary">Cancel</a>
                        </div>       
                      </form>
                    </div>
                    </div>
            </section>
          </div>
            </section>
        </div>



<script type="text/javascript">
         
        $("#Add_Notification").validate({
            ignore: [],
            rules: {
                notification_title: {
                    required:true                    
                },
                message: {
                    required:true                    
                },
                notification_type: {
                    required:true                    
                },
                
        },
        messages:{
          notification_title:{            
            required: "Please Enter Title",
             },
           message:{            
            required: "Please Enter Message",
             },
          notification_type:{            
            required: "Please Select Notification Type",
             }
        }
    });
    </script>
    