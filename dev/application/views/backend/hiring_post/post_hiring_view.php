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
                            <label class="col-sm-12"><?php echo $record['phone']; ?></label>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Hiring Title</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['title']; ?></label>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Description</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['description']; ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>No Of Post</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['no_of_jobs']; ?></label>
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
                        <label class="col-sm-5 control-label"><b>Hiring Status</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['hire_status'];?></label>
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

                    
                    