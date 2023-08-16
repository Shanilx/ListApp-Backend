  <!--body wrapper start-->
<style type="text/css">
.btn_align{
      margin: 30px 150px 0px 438px;
}

/*.select2-results__option[aria-selected="true"] {
    display: none;
}*/
</style>
  
  
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
                <li><a href="<?php echo base_url();?>apanel/changestatus">Change Status</a></li>
             
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    Change Status

                    <span class="tools pull-right">
                   <!--   <span class="error" style="text-transform: lowercase;">All the fields marked with (*) are mandatory</span> -->
                 </span>


             </header>
             <div class="panel-body">
                <section class="panel">
                    <div class="panel-body">
                        <div class="col-md-12">
                           <form role="form" class="form-vertical" action="<?php echo base_url(); ?>apanel/changestatus" method="post" id="changestatus" name="changestatus">
          
            <div class="form-group col-md-12">
                <label>Mobile Numbers<span class="error"> *</span></label>
                <textarea placeholder="Mobile Numbers" name="mobile_number" id="mobile_number" class="form-control" style="height: 300px" autocomplete="off"></textarea>
            </div>           
            
         <div class="form-group col-md-12">
            <label>Status<span class="error"> *</span></label>
            <select name="status" id="status" class="form-control">
                <option value="">Select Status</option>
                <option value="Active">Active</option>
                <option value="Deactive">Deactive</option>
            </select>
        </div>
        <div class="form-group col-md-12">
            <!-- <button class="btn btn-primary">Submit</button> -->
            <input class="btn btn-primary add_supplier_btn" type="submit" name="add_submit" value="Update" id="add_supplier_btn">
             
        </div>
    </form>
</div>

</div>
</section>
</div>
</section>
</div>




