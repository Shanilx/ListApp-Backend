<style type="text/css">
  label.col-sm-12 {
    margin-top: 10px;
}
</style>

<section class="wrapper">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Product Details</h4>
</div>

<div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <!-- <header class="panel-heading">
                Profile
            </header> -->

           <?php 
           
           $where=array('company_id'=>$record['company_name']);
                  $company_name= $this->product_model->GetRecord('company', $where);
                  $new_company_name=$company_name[0]['company_name'];
                  if(empty($new_company_name))
                  {
                    $new_company_name='NA';
                  }

                  if(!empty($record['form']))
                  {
                     $where_form_id=array('form_id'=>$record['form']);
                  $form_name= $this->product_model->GetRecord('form', $where_form_id);
                      if(!empty($form_name))
                      {

                      $new_form_name=$form_name[0]['Form']; 
                      }
                      else
                      {
                      // print_r($form_name);
                      $new_form_name='NA';
                        
                      }

                  }
                  else
                {
                    $new_form_name='NA';
                }


                if($record['mrp']!=0)
                {
                     $mrp=$record['mrp'];
                }
                else
                {
                    $mrp='NA';
                }

                // packing type..
                if(!empty($record['packing_type']))
                {
                    $where_pack_type_id=array('packing_type_id'=>$record['packing_type']);
                  $pack_type_name= $this->product_model->GetRecord('packing_type', $where_pack_type_id);
                  if(!empty($pack_type_name))
                  {

                  $new_pack_type_name=$pack_type_name[0]['packingtype_name']; 
                  }
                  else
                  {
                  // print_r($form_name);
                  $new_pack_type_name='NA';
                    
                  }
                }
                else
                {
                     $new_pack_type_name='NA';
                }
                //End packing type..
                if(!empty($record['pack_size']))
                {
                     $where_pack_size_id=array('pack_size_id'=>$record['pack_size']);
                  $pack_size_name= $this->product_model->GetRecord('packsize', $where_pack_size_id);
                  if(!empty($pack_size_name))
                  {

                  $new_pack_size_name=$pack_size_name[0]['Pack_size']; 
                  }
                  else
                  {
                  // print_r($form_name);
                  $new_pack_size_name='NA';
                    
                  }
                }
                else
                {
                      $new_pack_size_name='NA';
                }

                 if($record['rate']!=0)
                {
                     $rate=$record['rate'];
                }
                else
                {
                    $rate='NA';
                }

                if(!empty($record['schedule']))
                {
                    $where_schedule_id=array('schedule_id'=>$record['schedule']);
                  $schedule_name= $this->product_model->GetRecord('schedule', $where_schedule_id);
                  if(!empty($schedule_name))
                  {

                  $new_schedule_name=$schedule_name[0]['schedule_name']; 
                  }
                  else
                  {
                  // print_r($form_name);
                  $new_schedule_name='NA';
                    
                  }
                }
                else
                {
                    $new_schedule_name='NA';
                }
                 

                  ?>

            <div class="panel-body">
                <form class="form-horizontal adminex-form" method="POST" name="myForm" id="myForm" action="" enctype="multipart/form-data">
                   <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Product Name</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><span><?php echo ucfirst($record['product_name']);?></span></label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Company Name</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $new_company_name;?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Drug Name</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ($record['drug_name'])?ucfirst($record['drug_name']):'NA';?></label>
                        </div>
                    </div>

                   <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Form</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $new_form_name;?></label>
                        </div>
                    </div>
                    

                   <div class="form-group">
                        <label class="col-sm-5 control-label"><b>MRP</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $mrp;?></label>
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Packing Type</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $new_pack_type_name;?></label>
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Pack Size</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $new_pack_size_name; ?></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Rate</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $rate;?></label>
                        </div>
                    </div>
                   
                    



                   <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Schedule</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $new_schedule_name ;?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Status</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php if($record['status']==1){echo "Active"; }else{echo "Inactive";}?></label>
                        </div>
                    </div>

                    

                    
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