<?php 
$msg ="";
if($this->session->flashdata('succ'))
{
    $class = "alert-success";
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


    <!--body wrapper start-->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <!--breadcrumbs start -->

                <ul class="breadcrumb panel">
                 <li><a href="<?php echo base_url().'apanel/dashboard'?>"><i class="fa fa-home"></i> Dashboard</a></li>
                 <li>Slider image list</li>                 
             </ul>
             <!--breadcrumbs end -->
             
             <section class="panel">
                <header class="panel-heading">
                    Slider image list
                    <span class="tools pull-right">
                        <a href="<?php echo base_url(); ?>apanel/slider-add" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-plus"></i> Add </button></a>
                    </span>
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <table  class="display table table-bordered table-striped dynamic_data_table" id="sliderData">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Link</th>
                                    <th>Image</th>
                                    <th>Status</th>                          
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                           <?php
                            if(!empty($slider_list)){
                                $i = 1;
                                foreach ($slider_list as $slider_val) {
                                      ?>
                                <tr>
                                  <td><?php echo $i; ?></td>
                                  <td><?php echo(!empty($slider_val->link) ? $slider_val->link : ''); ?></td>
                                  <td><img src="<?php echo(!empty($slider_val->image_url) ? base_url().'uploads/slider/'.$slider_val->image_url : ''); ?>" width="100px"></td>
                                  <td><?php echo(!empty($slider_val->status) ? $slider_val->status : ''); ?></td>
                                  <td><a href="<?php echo base_url().'apanel/slider-edit/'.$slider_val->id; ?>" class="btn btn-info  btn-sm"><i class="fa fa-pencil-square-o"></i></a> | <a class='btn btn-info btn-sm' href='javascript:confirmDelete("<?php echo $slider_val->id; ?>")'> <i class='fa fa-trash-o'></i></a></td>
                                </tr>
                                <?php
                                }
                            }
                                ?>
                        </table>
                    </div>
                </div>
            </section>

            <!--body wrapper end-->
            <!-- Modal -->

<script type="text/javascript">
 
 // var postListingUrl =  BASEURL+"designation/designation_list";
  $('#sliderData').dataTable({
    "bPaginate": true,
    //"pageLength": 100,
    "lengthMenu": [50, 100, 200],
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "processing": false,
    "serverSide": false,
    "stateSave": false,
   
      });

</script>
<script>
    function confirmDelete(id) {
    var delUrl ="<?php echo base_url('apanel/slider-delete/') ?>";
      //var Id="<?php //echo ci_enc(id);?>";
     // alert(Id);
      if (confirm("Are you sure you want to delete this record?")) {
      document.location = delUrl+''+id;
    }
  }
</script>

            
