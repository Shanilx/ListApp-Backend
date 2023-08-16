<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/pagination.css">
<link href="<?php echo base_url();?>css/multiselect_box_r.css" rel="stylesheet" />
<?php 
if($this->uri->segment(3)){
 $this->session->set_userdata(array('page_no'=>$this->uri->segment(3).'?'.$_SERVER['QUERY_STRING']));  
 
}
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
    <style type="text/css">
        .tbl_scroll{

            display: block; 
            overflow-x: auto;
        }
    </style>
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb panel">
                   <li><a href="<?php echo base_url().'apanel/dashboard'?>"><i class="fa fa-home"></i> Dashboard</a></li>
                   <li>Manage Product</li>
               </ul>
               <!--breadcrumbs end -->
               <section class="panel">
                <header class="panel-heading">
                    Product List
                    <span class="tools pull-right">
                        <a href="<?php echo base_url().'apanel/product/csv_upload_form' ;?>" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-plus"></i> Bulk Upload</button></a>
                        

                        <!-- <a href="<?php echo base_url().'apanel/product/export_product_detail'?>" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-plus"></i> Export Product</button></a>-->


                        <a href="<?php echo base_url().'apanel/product/add'?>" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-plus"></i> Product </button></a>

                    </span>
                </header>
                <div class="panel-body">
                   <div class="adv-table">
                       <form method="get" id="search_form" name="search_form" action="<?php echo base_url('apanel/product/1')?>">
                           
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-2"><label class="form-label">Search </label></div>
                                <div class="col-sm-1" style="float: right; width: 156px;"><label class="form-label">Records Per Page</label></div>
                            </div>
                            <div class="form-group col-md-12" style="float:left">
                             <div class="form-group col-md-5" style="float:left">
                              <input type="text" name="product_name" placeholder="Product Name" value="<?php if(!empty($search_by)){ echo $search_by['product_name'];}?>" title="Type in a Product Name" class="form-control" >
                          </div>
                          <div class="col-md-2">
                              <input type="hidden" name="advanced_search_val" value='<?php if(!empty($advanced_search_val)){ echo "1";}else{echo "0";}?>' id="advanced_search_val">
                              <input type="hidden" name="search_first_time" value='1' id="search_first_time">
                              <a href="javascript:void(0)" id="advance_search_open" class="btn btn-primary"><?php if(!empty($advanced_search_val)){ echo "Advanced Search Hide";}else{echo "Advanced Search Show";}?></a>
                          </div>
                          <div class="col-md-2" style="margin-left: 20px;"> 
                             <input type="submit" name="search" value="Search" class="btn btn-primary"><br><br>
                         </div>
                         <div class="form-group col-md-1" style="padding-left: 0px; float: right; margin-right: 52px;">
                            
                            <select style="width: 123px;" class="form-control" id="records_per_page" name="per_page_re">
                                <option <?php if($rpp == 100){echo "selected='selected'";} ?> value="100">100</option>
                                <option <?php if($rpp == 200){echo "selected='selected'";} ?>  value="200">200</option>
                                <option <?php if($rpp == 300){echo "selected='selected'";} ?>  value="300">300</option>
                                <option <?php if($rpp == 400){echo "selected='selected'";} ?>  value="400">400</option>
                                <option <?php if($rpp == 500){echo "selected='selected'";} ?>  value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                      <div class="col-md-12" id="advance_search_enable" style="<?php if(!empty($advanced_search_val)){ echo "display:block;";}else{echo "display:none;";}?>">
                         <div class="form-group col-md-4" style="padding-left: 0px; padding-right: 7px;">
                           <label class="form-label">Company Name </label>
                           <select data-placeholder="Select Company" multiple id="company_name" style="width: 96%;height:auto;padding: 0px 12px;" name="company_name[]" class="form-control company_deal">
                              
                             <?php
                             //$where = array('status' => 1);
                             $companies=$this->product_model->GetRecord('company','','company_name','asc');

                             if(!empty($companies)){
                                foreach ($companies as $company) {?>
                                   <option value="<?php echo $company['company_id']; ?>" <?php if(in_array($company['company_id'], $company_name)){echo"selected";} ?>> <?php echo $company['company_name']; ?></option>
                                   <?php  }
                               }

                               ?>
                           </select>
                       </div>
                       <div class="form-group col-md-4" style="padding-left: 0px; padding-right: 7px;">
                           <label class="form-label">Drug Name </label>
                           <input type="text" name="drug_name" placeholder="Drug Name" id='drug_name' class="form-control" value="<?php if(!empty($search_by['drug_name']) ){ echo $search_by['drug_name'];}else if($_GET['drug_name']){ echo $_GET['drug_name']; }?>" >
                       </div>
                       <div class="form-group col-md-4" style="padding-left: 0px; padding-right: 7px;">
                           <label class="form-label">Form</label>
                           <input type="text" name="form_name" placeholder="Form" id='form_name' class="form-control" value="<?php if(!empty($form_name)){ echo $form_name;}?>" >
                           <div id="form_p_sug_box" ></div>
                       </div>
                   </div>
                 <!-- <div class="col-md-12"> 
                   <input type="submit" name="search" value="Search" class="btn btn-primary"><br><br>
               </div> -->
           </div>
       </div>
   </form>
<?php 
$deletebysearch=$_SERVER['QUERY_STRING'];
$deleteConfirmMsg="Are You sure You want delete all (".$this->session->userdata('total_record').") Product(s)?";
if($deletebysearch && !empty($record))
{
  $deleteConfirmMsg="Are You sure You want delete all (".$this->session->userdata('total_record').") Product(s)?";
  $display="block";
}else if (!empty($record)){
       $display="block";
}else{
  $display="none";
}


?>
<?php if (!empty($record)){ ?>
   <a href="javascript:void(0)" title="Delete"><input type="submit"  class="deleteMultiple btn btn-primary" id='deleteMultiple' value="Delete" style="margin:10px 0px 10px 0px"></a>

    <a <?php if($display=="none"){ echo 'title="No Data"'; } else{echo'title="Delete All"';}?>" href="javascript:void(0)" id='deletebyFilter' class="btn btn-primary deletebyFilter" style="margin:10px 0px 10px 20px"> Delete All</a>
   <?php }?>
   <table  class="display table table-bordered table-striped tbl_scroll dynamic_data_table" id="myTable">
       <thead>
        <tr>
            <th class="numeric"><input type="checkbox" name="selct_All" class="select_all" id='select_all' <?php if (empty($record)){echo 'disabled'; }?>> </th>
            <th class="numeric">#</th>
            <th class="numeric">Product Name</th>
            <th class="numeric">Company Name</th>
            <th class="numeric">Drug Name</th>
            <th class="numeric">Form</th>
            <th class="numeric">Pack Size</th>
            <th class="numeric">Packing Type</th>
            <th class="numeric">MRP</th>
            <th class="numeric">Schedule</th>
            <th class="numeric">Rate</th>
            <th class="numeric">Date</th>
            <th class="numeric">Status</th>
            <th class="numeric">Action</th>
            
        </tr>
    </thead>
    <tbody>       

        <?php
        if(!empty($record))
        {   
            if($this->uri->segment(3) > 1){
             $sn1 = $this->uri->segment(3)-1;
                   //$sn=$sn*($this->session->userdata('per_page'))?$this->session->userdata('per_page'):100; 
             if($this->session->userdata('per_page'))
             {
                 $sn=$sn1*$this->session->userdata('per_page');
                 if($sn > $this->session->userdata('total_record')){
                  $sn=$sn1*100;
                 }

             }else{
                $sn=$sn1*100;
            }
        }else{
            $sn=0;
        }
        
        $first_index=$sn+1;
        foreach ($record as $rec) 
        {   
            $sn++;
            ?>
            <tr>

                <td><input type="checkbox" class="deleetChecked" value="<?php echo $rec['product_id'];?>"></td>
                <td><?php echo $sn;?></td>
                <td><?php echo $rec['product_name'];?></td>
                <td><?php $c_id= $rec['company_name'];
                 $where = array('Company_id' => $c_id);
                 $data=$this->product_model->GetRecord('company', $where);
                 if(!empty($data)){
                   echo  $data[0]['company_name'];
               }else{
                echo "NA";
            }
            
            ?></td>                            
            <td>
                <?php 
                if(!empty($rec['drug_name']))
                {
                    echo $rec['drug_name'];
                }
                else { echo "NA" ;} ?></td>


                            <td><?php //echo $rec['form'];
                                $form_id= $rec['form'];
                                $where = array('Form_id' => $form_id);
                                $data=$this->product_model->GetRecord('form', $where);
                                if(!empty($data)){
                                   echo  $data[0]['Form'];
                               }else{
                                echo "NA";
                            }
                            ?></td>
                            <td><?php //echo $rec['pack_size'];

                              $pack_size_id= $rec['pack_size'];
                              $where = array('Pack_size_id' => $pack_size_id);
                              $data=$this->product_model->GetRecord('packsize', $where);
                              if(!empty($data)){
                               echo  $data[0]['Pack_size'];
                           }else{
                            echo "NA";
                        }


                        ?></td>
                        <td><?php 
                           $ptype_id= $rec['packing_type'];
                           $where = array('Packing_type_id' => $ptype_id);
                           $data=$this->product_model->GetRecord('packing_type', $where);
                           if(!empty($data)){
                               echo  $data[0]['packingtype_name'];
                           }else{
                            echo "NA";
                        }

                        ?>
                        

                    </td>
                    <td><?php 
                        if(!empty($rec['mrp']))
                        {
                            echo $rec['mrp'];
                        }
                        else
                        {
                            echo "NA";
                        }?>

                    </td>
                    <td><?php 
                       $schedule_id= $rec['schedule'];
                       $where = array('
                        schedule_id' => $schedule_id);
                       $data=$this->product_model->GetRecord('schedule', $where);
                       if(!empty($data)){
                           echo  $data[0]['schedule_name'];
                       }else{
                        echo "NA";
                    }

                    ?></td>
                    <td>
                        <?php
                        if(!empty($rec['rate']))
                        {

                         echo $rec['rate'];
                     }
                     else
                     {
                        echo "NA";
                    }
                    ?>
                </td>
                <td><?php echo date('d-m-Y h:i:s',strtotime($rec['add_date'])); ?>

                    <td>
                        <?php
                        if($rec['status']=='1'){  ?>
                            <span id="span_active_<?php echo $rec['product_id']; ?>" class="label label-success">Active</span> 
                            <span id="span_deactivate_<?php echo $rec['product_id']; ?>" class="label label-danger" style="display:none;">Deactive</span>
                            <?php }else{?>
                                <span id="span_active_<?php echo $rec['product_id']; ?>" class="label label-success"  style="display:none;">Active</span> 
                                <span id="span_deactivate_<?php echo $rec['product_id']; ?>" class="label label-danger">Deactive</span>
                                <?php }?>
                            </td>
                            
                            <td style="width:240px;">
                                <!-- <a class="btn btn-default btn-sm" data-target='#patientModal' data-toggle="modal" href="<?php echo base_url();?>apanel/product/detail<?php echo ci_enc($rec['user_id']); ?>" title="View Profile"><i class="fa fa-eye"></i></a>
                                &nbsp;&nbsp; -->
                                <a class="btn btn-default btn-sm" href="<?php echo base_url();?>apanel/product/edit/<?php echo ci_enc($rec['product_id']); ?>" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                &nbsp;&nbsp;
                                <!--delete-->
                                <a style="padding: 5px 11.2px;" class="btn btn-default btn-sm" href="javascript:confirmDelete('<?php echo base_url();?>apanel/product/delete/<?php echo ci_enc($rec['product_id']); ?>')" title="Delete"><i class="fa fa-trash-o"></i></a>

<a class="btn btn-default btn-sm" data-target='#productModal' data-toggle='modal' href='<?php echo base_url();?>apanel/product/product_detail/<?php echo ci_enc($rec['product_id']); ?>' title="View Product"><i class='fa fa-eye'></i></a>


<?php if($rec['status']== 1){?>        
    <a style="padding: 5px 9px;" href="javascript:void(0)" class="product_changeStatus btn btn-default btn-sm" id='<?php echo 'deactivate_'.$rec['product_id']; ?>' title="deactivate this Product ?" ><i class="fa fa-ban fa-lg" id="icon_<?php echo $rec['product_id'];?>"></i></a>   <?php   
} else {
    ?>    
    <a style="padding: 5px 9px;" href="javascript:void(0)" class="product_changeStatus btn btn-default btn-sm" id='<?php echo 'activate_'.$rec['product_id']; ?>' title="Activate this Product ?"><i class="fa fa-check fa-lg" id="icon_<?php echo $rec['product_id'];?>"></i></a>    
    <?php
} ?>
</td>

</tr>

<?php
} }  else {  
    ?>

    <tr>
        <td colspan="13s" align="center">No matching records found</td>
    </tr>
    <?php } ?>
    
</tbody>
</table>
<div id="pagination">
<span>Showing <?php echo ($first_index)?$first_index.' to '.$sn:0; ?> of <?php echo $this->session->userdata('total_record') ; ?> entries</span>
    <ul class="tsc_pagination">
        
        <!-- Show pagination links -->
        <?php foreach ($links as $link) {
            echo "<li class='pagination_click'>". $link."</li>";
        } ?>
    </div>
</div>
</div>
</section>






<!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="productModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Product Details</h4>
            </div>
            <div class="modal-body row">

             Loading...

         </div>
         <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
        </div>
    </div>
</div>
</div>
<!-- modal -->

<script type="text/javascript">
  $(document.body).on('hidden.bs.modal', function () {
    $('#patientModal').removeData('bs.modal');
});

//Edit SL: more universal
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});
</script>

<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    var url_path = base_url+'backend/doctor/update_user_status';
</script>

<script>
    /*function confirmDelete(delUrl) {
      if (confirm("Are you sure you want to delete this record?")) {
      document.location = delUrl;
  }
}*/
function confirmDelete(id) {
    var delUrl ="<?php echo base_url('apanel/product/delete/') ?>";
      //var Id="<?php //echo ci_enc(id);?>";
     // alert(Id);
     if (confirm("Are you sure you want to delete this record?")) {
      document.location =id;
  }
}



</script>

<script type="text/javascript">

    $("body").on("click",'.product_changeStatus',function(){
        // alert("helllo");return false;

        var temp  =  $(this).attr('id');

        //alert(temp);
       var temp2 = temp.split("_");
       var action = temp2[0];
       var actionid = temp2[1];
       // alert(actionid);return false;
       if(confirm("Are you sure  to "+action+" this Product ?"))
       {
         $.post("<?php echo base_url('apanel/product/product_changeStatus');?>",{ac:action,acid:actionid},function(response){
          // alert(response);return false;
          if(response == 'ok'){
             if(action == 'deactivate'){
              // $("#statuscell_"+actionid).html("<span class='label label-danger'>deactivateed</span>");
              $("#"+temp).attr("title","Activate this Product");
              $("#"+temp).attr("id","activate_"+actionid);
              $("#icon_"+actionid).removeClass("fa-ban");
              $("#icon_"+actionid).addClass("fa-check");
              location.reload();
          }
          else
          {          
                        // $("#statuscell_"+actionid).html("<span class='label label-success'>Active</span>");
                        $("#"+temp).attr("title","deactivate this Product");
                        $("#"+temp).attr("id","deactivate_"+actionid);
                        $("#icon_"+actionid).removeClass("fa-check");
                        $("#icon_"+actionid).addClass("fa-ban");
                        location.reload();
                    }
                }
            });
     }
     
     
 });
</script>

<script>
    $(document).ready(function() {
        $('#ajaxDataTable').dataTable({
            'processing': true,
            'ServerSide': true,
            "ajax": "<?php echo base_url('apanel/product/ajaxDataTable')?>",
            //"pageLength":100,
            
            "order": [[ 0, "asc" ]],
            "aoColumnDefs": [
            { "bVisible": true, "aTargets": [0] },
            {
                "bSortable": true,
                "aTargets": ["no-sort"]  
            }],
            //"dom": 'T<"clear">lfrtip',
            tableTools: {
               "sSwfPath": "<?php echo base_url("plugins/data_tables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"); ?>"
           }
       });
    });
</script>

<script>

    $("#myInput").on("keyup", function () {
        var value = $(this).val().toUpperCase();
        if (value.length){
            $("table tr").each(function (index) {
                if (index != 0) {
                    $row = $(this);
                    $row.find("td").each(function () {
                        var cell = $(this).text().toUpperCase();
                        if (cell.indexOf(value) < 0) {
                            $row.hide();
                        } else {
                            $row.show();
                        return false; //Once it's shown you don't want to hide it on the next cell
                    }
                });
                }
            });
        }
        else{
        //if empty search text, show all rows
        $("table tr").show();
    }
});


    $('#records_per_page').change(function(){
        var url = '<?php echo base_url()."apanel/product/".$this->uri->segment(3); ?>';
        var rec_url = url+'/'+$(this).val()+'?<?php echo $_SERVER['QUERY_STRING'];  ?>';
        window.location = rec_url;
    });



    $("#advance_search_open").click(function(){
     var advance_text =$(this).text();
 //alert(advance_text);
 if(advance_text=="Advanced Search Show"){
    $("#advance_search_enable").css("display", 'block');
    $(this).text('Advanced Search Hide');
    $("#advanced_search_val").val('1');
}else{
    $("#advance_search_enable").css("display", 'none');
    $(this).text('Advanced Search Show');
    $("#drug_name").val('');
    $("#advanced_search_val").val('0');
    $("#form_name").val('');
    $(".company_deal > option").removeAttr("selected");
    $(".company_deal").trigger("change");
    
}
});

</script>
<script type="text/javascript">

    $("#form_name").keyup(function(){
        var value=$(this).val().trim();
        $("#form_p_sug_box").hide();
        if(value.length > 1){
                       // alert(value);
                       $.ajax({
                        url:"<?php echo base_url('apanel/product/getForm')?>",
                        type:"POST",
                        data:{'form_name':value},
                        success:function(data){
                              //alert(data);
                              $("#form_p_sug_box").html(data);
                              $("#form_p_sug_box").show();
                          }
                      })
                   }
               });

    $("body").on('click','.sugg_form_p',function(){
              //alert('hiii');
              var form_p =$(this).children('a').attr('title');
              
              $("#form_name").val(form_p);
              $("#form_p_sug_box").hide();

          });


    $(".pagination_click").click(function(){

                    //alert(543545);
                    $("#search_form").submit();
                    //alert(543545);
                    //return false;
                });
//     $(function(){
//     $("input[name=product_name]")[0].oninvalid = function () {
//         this.setCustomValidity("Please enter valid characters.");
//         this.setCustomValidity("");
//     };


            </script>

            <script type="text/javascript">

             $("#deleteMultiple").click(function()
         {
                var multiple_ids=[];
                $(".deleetChecked").each(function(i) 
                {
                   if($(this).is(':checked'))
                   {
                    multiple_ids[i]=$(this).val();
                   }
              });

                if(multiple_ids.length==0){
               
                  alert('Please select at least one record to delete');
                return false;
                }



                var msg='Are you sure you want to delete this record ?';
                var msg2='Product has not been Deleted. Please Try Again';
                if(multiple_ids.length > 1){
                   msg='Are you sure you want to delete this records ?';
                   msg2='Products has not been Deleted. Please Try Again';
                }
                

                if(multiple_ids!='' && confirm(msg))
                {
                  $.ajax({
                        url:'<?php echo base_url('apanel/product/deleteMultiple')?>',
                        type:"POST",
                        data:{'product_ids':multiple_ids},
                        success:function(data){
                          //alert(data);
                          if(data =='1')
                          {
                          window.location.reload();
                          }
                          else
                          {
                            alert(msg2);
                          }
                        }
                        });
                }
                
              
            });

              $("#select_all").click(function(){
               if($(this).is(':checked'))
               {
                $(".deleetChecked").prop('checked',true);
               }
               else
               {
                $(".deleetChecked").prop('checked',false);
               }
              });

        $(".deleetChecked").click(function(){
            var at_leastone=0;
                $(".deleetChecked").each(function(i) 
                {
                   if($(this).is(':checked'))
                   {
                    
                   }else{
                    at_leastone=1;
                   }
              });
                if(at_leastone==1){
                  $("#select_all").prop('checked',false);
                }
                else{
                  $("#select_all").prop('checked',true);
                }
        });

        $("#deletebyFilter").click(function(){
         var Chek =$(this).attr('title');
         if(Chek!='No Data')
         {          
         
            if(confirm("<?php echo $deleteConfirmMsg;?>"))
            {
              window.location="<?php echo base_url('apanel/product/deletebyfilter')."?".$_SERVER['QUERY_STRING']; ?>"
              return true;
            }else
            {
              return false;
            }
          }else
          {
           alert('No record for delete');
           return false;
          }

        });

            </script>
            <script>
            $(document).ready(function() {
  $('th').each(function(col) {
  
    $(this).hover(
    function() { $(this).addClass('focus'); },
    function() { $(this).removeClass('focus'); }
  );
    $(this).click(function() {
      if ($(this).is('.asc')) {
        $(this).removeClass('asc');
        $(this).addClass('desc selected');
        sortOrder = -1;
      }
      else {
        $(this).addClass('asc selected');
        $(this).removeClass('desc');
        sortOrder = 1;
      }
      $(this).siblings().removeClass('asc selected');
      $(this).siblings().removeClass('desc selected');
      var arrData = $('table').find('tbody >tr:has(td)').get();
      arrData.sort(function(a, b) {
        var val1 = $(a).children('td').eq(col).text().toUpperCase();
        var val2 = $(b).children('td').eq(col).text().toUpperCase();
        if($.isNumeric(val1) && $.isNumeric(val2))
        return sortOrder == 1 ? val1-val2 : val2-val1;
        else
           return (val1 < val2) ? -sortOrder : (val1 > val2) ? sortOrder : 0;
      });
      $.each(arrData, function(index, row) {
        $('tbody').append(row);
      });
    });
  });
});

            </script>