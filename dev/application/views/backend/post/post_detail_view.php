<style type="text/css">
    .panel-body{
        overflow-y: scroll;
        overflow: hidden;
    }
</style>
<section class="wrapper">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Post Details</h4>
</div>
<div class="row">  
        <div class="col-lg-12">
        <section class="panel">    
            <div class="panel-body">
                <form class="form-horizontal adminex-form" method="POST" name="myForm" id="myForm" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>User Name</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ucfirst($record['user_name']);?></label>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Contact Number</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ucfirst($record['phone']);?></label>
                        </div>
                    </div>                    
                    
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Product Name</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['product_name']; ?></label>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Description</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['post_description']; ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>MRP</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['mrp']; ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Offer Price</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['selling_price']; ?> / </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Margin % / <i class="fa fa-inr fa-sm" style="font-variant: 8px;"></i></b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['margin'];?> / <?php echo $record['mrp']-$record['selling_price'];?></label>
                        </div>
                    </div><div class="form-group">
                        <label class="col-sm-5 control-label"><b>Quantity</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['quantity'];?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Expiry Date</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo date('d-m-Y',strtotime($record['product_expire_date']));?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Contact Detail</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo$record['contact_detail']; ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Like Count</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['like_count'];?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>View Count</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo  $record['view_count'];?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Sold Status</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['sold_status'];?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Status</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['post_status'];?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Posted Date</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo date('d-m-Y h:i:s',strtotime($record['created_date']));?></label>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        
        </div>
        </div>

</section>

                    
                    