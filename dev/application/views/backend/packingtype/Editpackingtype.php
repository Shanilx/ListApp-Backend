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
                <li><a href="<?php echo base_url();?>apanel/Packingtype">Manage Packing Type</a></li>
                <li class="active">Edit Packing Type</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    Edit Packing Type
                    <span class="tools pull-right">
                     <span class="error" style="text-transform: lowercase;">all the fields marked with (*) are mandatory</span>
                 </span>

             </header>
             <div class="panel-body">
                <section class="panel">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <?php 
                           //print_r($edit_Packingtype);
                            $id = $edit_Packingtype[0]['packing_type_id']; ?>
                           <form role="form" class="form-vertical" action="<?php echo base_url(); ?>apanel/Packingtype/EditData/<?php echo ci_enc($id); ?>" method="post" id="add_Packingtype" name="add_Packingtype">
                            <div class="form-group col-md-2">
                               <label style="width:150px;">Packing Type Name<span class="error"> *</span></label>
                            </div>
                            <div class="form-group col-md-4">
                               <input type="text" name="Packingtype_name" id="Packingtype_name" value="<?php echo $edit_Packingtype[0]['packingtype_name']; ?>" class="form-control"/>
                            </div>
                            <div class="form-group col-md-4">
                              <input class="btn btn-primary" type="submit" name="add_submit" value="Save">
                              <a href="<?php echo base_url();?>apanel/Packingtype" class="btn btn-primary">Cancel</a>
                            </div>

          <!-- <div class="form-group col-md-12">
            
              <input class="btn btn-primary" type="submit" name="add_submit" value="Save">
          </div> -->
        </form>
</div>

</div>
</section>
</div>
</section>
</div>
<script type="text/javascript">
             var url="<?php echo base_url('apanel/Packingtype/checkName');?>";
        
        $("#add_Packingtype").validate({
            ignore: [],
            rules: {
                Packingtype_name: {
                    required: true,
                    remote: {
                          url: url,
                          type: "post",
                          data: {
                                    Packingtype_name: function() 
                                    {
                                    return $("#Packingtype_name").val();
                                    }
                                }
                            }
                   
                },
                
        },
        messages:{
          'Packingtype_name':{
            required:'Please Enter Packing Type',
            remote:"Packing Type Already Exist"
          
          }
        }
    });
    </script>

    



