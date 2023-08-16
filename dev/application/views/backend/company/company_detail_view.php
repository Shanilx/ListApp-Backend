<style type="text/css">
    .panel-body{
        overflow-y: scroll;
        overflow: hidden;
    }
</style>
<section class="wrapper">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Company Details</h4>
</div>
<div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <form class="form-horizontal adminex-form" method="POST" name="myForm" id="myForm" action="" enctype="multipart/form-data">

                <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Company Name</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ucfirst($record[0]['company_name']);?></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>No Of Product</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ucfirst($no_of_product);?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>No Of Supplier</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $no_of_supplier;?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Date Added</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo Date('d-m-Y h:i:s',strtotime($record[0]['date_added']));?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Status</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12">
                              <?php 
                              switch ($record[0]['status']) {
                                case 1:
                                 $st="Active";
                                  break;                                
                                default:
                                 $st="Deactive";
                                  break;
                              }
                              echo $st;
                              ?>                              
                            </label>
                        </div>
                    </div>
                    
                </form>
            </div>
        </section>

        
        </div>
        </div>

</section>

                    
                    