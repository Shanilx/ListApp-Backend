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
    <h4 class="modal-title">Supplier Details</h4>
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
                            <label class="col-sm-12"><?php echo ucfirst($record['name']);?></label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Contact Number</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['mobile_number'];?></label>
                        </div>
                    </div>

                    
                   
                    
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>State</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $state_name[0]['name'];?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>City</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $city_name[0]['name'];?></label>
                        </div>
                    </div>
                    

                   
                   
                   <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Area</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['area']; ?></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Address</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['address'];?></label>
                        </div>
                    </div>
                   
                   <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Email</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['email'];?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>DL No</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['dln_no'];?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>GSTIN No</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['tln_no'];?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>ESTD Year</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['estd_no'];?></label>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Contact Person</b> </label>
                        <div class="col-sm-6">
                            <label class="col-sm-12">                                    
                                    <?php 
                                     $contact_person= explode(',', $record['contact_person']);
                                     $contact_person_mobile=explode(',', $record['contact_person_mobile']); 
                                     
                                     for ($i=0; $i < count($contact_person) ; $i++) { 
                                         $contact_person_mob=($contact_person_mobile[$i])?$contact_person_mobile[$i]:"NA";
                                       $both.=  $contact_person[$i].' <b>-</b> '.$contact_person_mob.",<br>";
                                      

                                     }
                                      echo rtrim($both,",<br>");

                                    ?>


                           </label>
                        </div>
                    </div>
                    <div class="form-group">
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
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Authenticated</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php echo $record['authe_no_authe'];?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label"><b>Status</b></label>
                        <div class="col-sm-6">
                            <label class="col-sm-12"><?php if($record['status'] == '1'){echo "Active";}else { echo "Inactive";}?></label>
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
                    
                    