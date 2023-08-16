<style type="text/css">

    button.dropify-clear {

    display: none !important;

}

</style>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">

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

                 <li>Edit Slider edit</li>                 

             </ul>

             <!--breadcrumbs end -->

             

             <section class="panel">

                <header class="panel-heading">

                    Edit Slider Image

                    <span class="tools pull-right">

                        <a href="<?php echo base_url(); ?>apanel/slider-list" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-plus"></i> Back </button></a>

                    </span>

                </header>

                <div class="panel-body">

                    <div class="adv-table">

                        <form method="post" action="<?php echo base_url('apanel/slider-update/'.$slider_info->id); ?>" data-parsley-validate="" enctype="multipart/form-data" class="image_doc_upload_aadhar">

                         <div class="card-body">

                            <div class="row clearfix">

                                <div class="col-lg-12 col-md-12 col-sm-12">

                                  <label for="aadhaar_card">Link *</label>

                                  <div class="form-group border border-secondary aadhaar_card">

                                        <input type="url" name="link" class="form-control" required="" value="<?php echo(!empty($slider_info->link) ? $slider_info->link : ''); ?>">

                                        <input type="hidden" name="old_img" value="<?php echo $slider_info->image_url; ?>">

                                  </div>

                               </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <label for="aadhaar_card">Image *</label>

                                    <div class="form-group border border-secondary aadhaar_card">

                                        

                                        

                                         <input type="file" name="image_url" id="" class="dropify" data-height="100" data-allowed-file-extensions="jpg jpeg png gif"  data-default-file="<?php echo(!empty($slider_info->image_url) ? base_url().'uploads/slider/'.$slider_info->image_url : ''); ?>" data-max-file-size="4M">

                                    </div>

                                </div>

                               <div class="col-12">

                                  <button type="submit" class="btn btn-primary">Submit</button>

                               </div>

                            </div>

                         </div>

                      </form>

                    </div>

                </div>

            </section>



            <!--body wrapper end-->

            <!-- Modal -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

<script type="text/javascript">

    $('.dropify').dropify();

</script>



