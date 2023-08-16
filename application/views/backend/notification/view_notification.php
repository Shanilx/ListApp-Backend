<style type="text/css">
  label.col-sm-12 {
    margin-top: 10px;
}
</style>

<section class="wrapper">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Notification Details</h4>
</div>

<div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <!-- <header class="panel-heading">
                Profile
            </header> -->

           

            <div class="panel-body">
                <form class="form-horizontal adminex-form" method="POST" name="myForm" id="myForm" action="" enctype="multipart/form-data">
                   <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Notification Type</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><span>
                            <?php 
                             if($record['notification_type']== 1)
                             {
                                echo "General Notification";
                             } 
                             else if ($record['notification_type']== 2 )
                             {
                                 echo "Application Update Notification";
                             }
                             ?>
                                
                            </span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>User  Group</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><span>
                            <?php echo $record['user_group'];                          
                             ?>
                                
                            </span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Title</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><span><?php echo ucfirst($record['title']);?></span></label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Message</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ucfirst($record['message']);?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Date</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['create_date'];?></label>
                        </div>
                    </div>
                   
                    <!-- <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Status</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php if($record['status']==1){echo "Active"; }else{echo "Inactive";}?></label>
                        </div>
                    </div> -->

                    

                    
                    <!-- <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2" style="">
                            <input type="submit" value="Submit" class="btn btn-primary" style="margin-bottom:10px;">
                        </div>
                    </div> -->

                    
                </form>
            </div>
        </section>

        
        </div>
        </div>

</section>

<script type="text/javascript">
    var Script = function () {

    $().ready(function() {


        //Set Email text as readonly
        $('#email').prop("readonly", true);
        $("#email").keypress(function(event) {
            event.preventDefault();
        });
        
    });


}();


</script>