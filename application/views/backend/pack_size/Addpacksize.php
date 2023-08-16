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
                <li><a href="<?php echo base_url();?>apanel/Packsize">Manage Pack Size</a></li>
                <li class="active">Add Pack Size</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Pack Size

                    <span class="tools pull-right">
                     <span class="error" style="text-transform: lowercase;">all the fields marked with (*) are mandatory</span>
                 </span>

             </header>
             <div class="panel-body">
                <section class="panel">
                    <div class="panel-body">
                    <div class="col-md-12">
                       <form role="form" class="form-vertical" action="<?php echo base_url(); ?>apanel/Packsize/Add_pack_size" method="post" id="Add_packsize" name="Add_packsize">
                        <div class="form-group col-md-2">
                          <label>Pack Size<span class="error"> *</span></label>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" name="Pack_size" id="Pack_size" class="form-control"/>
                        </div>
                        <div class="form-group col-md-4">
                          <input class="btn btn-primary" type="submit" name="add_submit" value="Save">
                           <a href="<?php echo base_url();?>apanel/Packsize" class="btn btn-primary">Cancel</a>
                        </div>       
                      </form>
                    </div>
                    </div>
            </section>
          </div>
            </section>
        </div>
        <script type="text/javascript">
         var url="<?php echo base_url('apanel/Packsize/checkName');?>";
        $("#Add_packsize").validate({
            ignore: [],
            rules: {
                Pack_size: {
                    required: true,
                    // number:true,
                    remote: {
                          url: url,
                          type: "post",
                          data: {
                                    Pack_size: function() 
                                    {
                                    return $("#Pack_size").val();
                                    }
                                }
                            }
                },
                
        },
        messages:{
          'Pack_size':{
            required:'Please Enter Pack Size',
            // number:'Pack Size should be Number only',
            remote:'Pack Size Already Exist',
          }
        }
    });
    </script>



