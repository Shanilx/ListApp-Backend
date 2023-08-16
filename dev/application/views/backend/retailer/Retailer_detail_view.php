<?php 
// echo "<pre>";
// print_r($record);
?>
<style type="text/css">
    .panel-body{
        overflow-y: scroll;
        overflow: hidden;
    }
</style>
<section class="wrapper">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Retailer Details</h4>
</div>
<div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <!-- <header class="panel-heading">
                Profile
            </header> -->
            <?php 
             
             $where = array('id' => $record['state']);
         $state_name=$this->Supplier_model->GetRecord('states',$where);
         // print_r($state_name);die;
          $where_city_id = array('id' => $record['city']);
         $city_name=$this->Supplier_model->GetRecord('cities',$where_city_id);
        // print_r($city_name);die;
        ?>

          
            <div class="panel-body">
                <form class="form-horizontal adminex-form" method="POST" name="myForm" id="myForm" action="" enctype="multipart/form-data">

                <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Firm Name</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ucfirst($record['shop_name']);?></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Name</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ucfirst($record['first_name']);?></label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Mobile Number</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['phone'];?></label>
                        </div>
                    </div>

                    
                   
                   <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Email</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['email'];?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Address</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ($record['address'])?$record['address']:"NA";?></label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>State</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ($state_name[0]['name'])?$state_name[0]['name']:"NA";?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>City</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ($city_name[0]['name'])?$city_name[0]['name']:"NA";?></label>
                        </div>
                    </div>
                    

                   
                   
                   <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Area</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ($record['landmark'])?$record['landmark']:"NA"; ?></label>
                        </div>
                    </div>

                    
                   
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>DL No</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ($record['dl_no'])?$record['dl_no']:"NA";?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>GSTIN No</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ($record['tin_no'])?$record['tin_no']:"NA";?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>ESTD Year</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ($record['estd_year'])?$record['estd_year']:"NA";?></label>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Contact Person</b> </label>
                        <div class="col-sm-6">
                            <label class="col-sm-12">                                    
                                    <?php 
                                     $contact_person= explode(',', trim($record['contact_person']));
                                     if(!empty($contact_person) && trim($record['contact_person'])!=''){
                                     $contact_person_mobile=explode(',', $record['contact_person_number']); 
                                     
                                     for ($i=0; $i < count($contact_person) ; $i++) { 
                                         $contact_person_mob=($contact_person_mobile[$i])?$contact_person_mobile[$i]:"NA";
                                       $both.=  $contact_person[$i].' <b>-</b> '.$contact_person_mob.",<br>";
                                      

                                     }
                                      echo rtrim($both,",<br>");
                                    }else{
                                        echo "NA";
                                    }
                                    ?>


                           </label>
                        </div>
                    </div>
                   <!--  <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Company Deal With</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php 
                            $company_i=explode(',', $record['company_deal']);
                           $company_name='';
                            if($company_i){
                                for ($i=0; $i <count($company_i); $i++) { 
                                    
                                
                                 $where_c = array('company_id' =>$company_i[$i]);
                                 $data=$this->Supplier_model->GetRecord('company',$where_c);
                                 $company_name.=$data[0]['company_name'].',<br>';
                             }
                             if ($company_name) {
                                 echo rtrim($company_name,",<br>");
                             }else{
                                echo"NA";
                             }

                            }


                                

                            ?></label>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Authenticated</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo ($record['authe_no_authe']=='Yes')?$record['authe_no_authe']:'No';?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>User Type</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php 
                                               if($record['role']==3){
                                $user_type="Retailer";
                              }
                              else if($record['role']==2){
                                $user_type="Supplier";
                              }
                              else if($record['role']==4){
                                $user_type="Other";
                              }else if($record['role']==5){
                                $user_type="Company";
                              }
                              echo $user_type;
                            ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Status</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['status'];?></label>
                        </div>
                    </div>
                     <!-- <div class="form-group">
                        <label class="col-sm-5 control-label">Contact Person Mobile</label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['contact_person_mobile'];?></label>
                        </div>
                    </div> -->

                  
                    
                </form>
            </div>
        </section>

        
        </div>
        </div>

</section>

<script type="text/javascript">
//     var Script = function () {

//     $().ready(function() {


//         //Set Email text as readonly
//         $('#email').prop("readonly", true);
//         $("#email").keypress(function(event) {
//             event.preventDefault();
//         });
        
//     });


// }();


</script>
                    
                    