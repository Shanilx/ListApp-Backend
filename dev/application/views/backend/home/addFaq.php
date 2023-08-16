<?php

?><!--body wrapper start-->
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
        <div class="alert alert-block <?php echo $class;?> fade in container" style="text-align: center;">
            <button data-dismiss="alert" class="close close-sm" type="button"> <i class="fa fa-times"></i> </button>
            <?php echo $msg;?> 
        </div>

        <?php } ?>

        <?php 
          if(!empty($records)) { $act = 'Edit'; }
          else { $act = 'Add'; } 
        ?>

         <div class="row">
            <div class="col-md-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb panel">
                    <li><a href="<?php echo base_url().'/apanel/dashboard'?>"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li><a href="<?php echo base_url().'apanel/faq'?>">Manage FAQ</a></li>
                    <li class="active"><?php echo $act; ?> FAQ</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>


        <div class="row">

        <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
            FAQ Details
                      <span class="tools pull-right">
                           <span class="error" style="text-transform: lowercase;"><?php echo ucfirst("all the fields marked with (*) are mandatory");?></span>
                         </span>
            </header>
            <div class="panel-body">
                <section class="panel">
                    <div class="panel-body">
                        <form  action="" method="post" name="addFaq" id="addFaq" enctype="multipart/form-data">

                             <div class="col-md-12">
                                <div class="form-group col-md-3">
                                    <label for="exampleInputPassword1">Question <span class="error">*</span></label>
                                </div>
                                <div class="form-group col-md-6" >

                                    <input type="text" class="form-control dpd1 " id="question" name="question" minlength="5" maxlength="200" placeholder="Question" value="<?php if(!empty($records)) { echo $records[0]['question']; } ?>">
                                </div>
                            </div>
                             <div class="col-md-12">
                                <div class="form-group col-md-3" >
                                    <label for="exampleInputLocation">Answer <span class="error">*</span></label>
                                </div>
                                <div class="form-group col-md-6" >
                                     <textarea class="form-control" name="answer" id="answer" minlength="5" maxlength="1000" placeholder="Answer"><?php if(!empty($records)) { echo $records[0]['answer']; } ?></textarea>

                                </div>
                            </div>
                            
                            <div class="clearfix"></div>
                            
                            <div class="col-md-12">
                                <div class="form-group col-md-3"  >
                                </div>
                                <div class="form-group col-md-6" >
                                   <button type="submit" class="btn btn-primary">Submit</button>
                                   <button type="button" name="cancel" id="cancel" onClick="window.location.href='<?php echo base_url(); ?>apanel/home/faq'" class="btn btn-primary">Cancel</button>
                                </div>
                            </div>

                            
                        </form>

                    </div>
                </section>
            </div>
        </section>
