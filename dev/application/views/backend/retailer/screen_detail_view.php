<style type="text/css">
    .panel-body{
        overflow-y: scroll;
        overflow: hidden;
    }
</style>
<section class="wrapper">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Screen Details</h4>
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
                        <label class="col-sm-5 control-label"><b>Screens Visited</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12">
                              <?php  
                              if(!empty($record['screen_visit'])){
                                $screen=explode(',', $record['screen_visit']);
                                $snc=0;
                                foreach ($screen as $value) {
                                  $snc++;
                                  echo $snc.' - '.$value.'<br>';
                                }
                              }else{
                                echo "-";
                              }
                              ?>
                                
                              </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Login Date</b></label>
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

                    
                    