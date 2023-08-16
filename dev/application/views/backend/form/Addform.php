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
                <li><a href="<?php echo base_url();?>apanel/Form">Manage Form</a></li>
                <li class="active">Add Form</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Form

                    <span class="tools pull-right">
                     <span class="error" style="text-transform: lowercase;">all the fields marked with (*) are mandatory</span>
                 </span>

             </header>
             <div class="panel-body">
                <section class="panel">
                    <div class="panel-body">
                    <div class="col-md-12">
                       <form role="form" class="form-vertical" action="<?php echo base_url(); ?>apanel/Form/Add_Form" method="post" id="Add_Form" name="Add_Form">
                        <div class="form-group col-md-2">
                          <label>Form Name<span class="error"> *</span></label>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" name="Form_name" id="Form_name" class="form-control"/>
                        </div>
                        <div class="form-group col-md-4">
                          <input class="btn btn-primary" type="submit" name="add_submit" value="Save">
                           <a href="<?php echo base_url();?>apanel/Form" class="btn btn-primary">Cancel</a>
                        </div>       
                      </form>
                    </div>
                    </div>
            </section>
          </div>
            </section>
        </div>
        <script type="text/javascript">
        var url="<?php echo base_url('apanel/Form/checkName');?>"; 
        $("#Add_Form").validate({
            ignore: [],
            rules: {
                Form_name: {
                    required: true,
                    remote: {
                          url: url,
                          type: "post",
                          data: {
                                    Form_name: function() 
                                    {
                                    return $("#Form_name").val();
                                    }
                                }
                            }
                },
                
        },
        messages:{
          'Form_name':{
            required:'Please Enter Form Name',
            remote:'Form Name Already Exist'
          }
        }
    });
    </script>



