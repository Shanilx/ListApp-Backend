<?php 
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
  <div class="wrapper">
    <div class="row">
      <div class="col-sm-12">
        <!--breadcrumbs start -->

        <ul class="breadcrumb panel">
         <li><a href="<?php echo base_url().'apanel/dashboard'?>"><i class="fa fa-home"></i> Dashboard</a></li>
         <li>Manage Company</li>
         <div class="pull-right" >
           <?php
                  //uri segment for active class
           $con = $this->uri->segment(2);
           $met = $this->uri->segment(3);
           ?>
           <select id="sub_menu" class="btn btn-primary ">
             <option value="company" <?php if($con=='Company') { echo 'selected'; } ?> >Company name</option>
             <option value="Form" <?php if($con=='Form') { echo 'selected'; } ?> >Form</option>
             <option value="Packing Type" <?php if($con=='Packingtype') { echo 'selected'; } ?> >Packing Type</option>
             <option value="Pack Size" <?php if($con=='Packsize') { echo 'selected'; } ?> >Pack Size</option>
             <option value="Schedule" <?php if($con=='Schedule') { echo 'selected'; } ?>>Schedule</option>
           </select>
         </div>
         <div class="clearfix"></div>
       </ul>
       <!--breadcrumbs end -->

       <section class="panel">
        <header class="panel-heading">
          Company List
          <span class="tools pull-right">
            <a href="<?php echo base_url(); ?>apanel/Company/add" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-plus"></i> Add Company </button></a>

            <!-- <a class="btn btn-primary" href="<?php echo base_url(); ?>apanel/Showsupplier">Add Supplier</a> -->
          </span>
        </header>
        <div class="panel-body">
         <div class="adv-table">
          <table  class="display table table-bordered table-striped dynamic_data_table" id="ajaxDataTableCompany">
           <thead>
            <tr>
              <th>#</th>
              <th>Company Name</th>
              <!-- <th>Number of Products</th> -->
              <th>Date Added</th>
              <th>Status</th> 
              <th>Action</th>

            </tr>
          </thead>
          <tbody>
            <?php 
            if(!empty($records)){
              $sn=1;
              foreach ($records as $key => $value) {
                ?>
                <tr>
                  <td><?php echo$sn;?></td>
                  <td><?php echo $value['company_name'];?></td>
                  <td><?php echo date('d-m-Y h:i:s',strtotime($value['date_added']));?></td>
                  <td><?php if($value['status']=='1'){
                    echo '<span id="span_active_'.$value['company_id'].'" class="label label-success">Active</span> <span style="display:none;" id="span_deactivate_'.$value['company_id'].'" class="label label-danger" >Deactive</span>';
                  }else{
                    echo '<span id="span_deactivate_'.$value['company_id'].'" class="label label-danger" >Deactive</span><span style="display:none;" id="span_active_'.$value['company_id'].'" class="label label-success">Active</span>';
                  }
                  ?></td>
                  <td> <?php
                  echo $view_link="<a class='btn btn-default btn-sm' data-target='#CompanyModal' data-toggle='modal' href='". base_url()."backend/Company/view_company/".ci_enc($value['company_id'])."' title='View Company'><i class='fa fa-eye'></i></a>";                    
                  echo $edit_link="<a class='btn btn-default btn-sm' href='".base_url()."apanel/Company/Editcompany/" . ci_enc($value['company_id'])."'> <i class='fa fa-pencil-square-o'></i></a>";
                  echo $delete_link="<a style='padding: 5px 11.2px;' class='btn btn-default btn-sm' href='javascript:confirmDelete(".$value['company_id'].")'> <i class='fa fa-trash-o'></i></a>";
                  if($value['status']==1){                
                   echo $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="Company_changeStatus btn btn-default btn-sm" id="block_'.$value['company_id'].'" title="Block this Company ?" ><i class="fa fa-ban fa-lg" id="icon_'.$value['company_id'].'"></i></a>';

                     }
                    else{
                    echo  $changeStatus='<a style="padding: 5px 9px;" href="javascript:void(0)" class="Company_changeStatus btn btn-default btn-sm" id="activate_'.$value['company_id'].'" title="Activate this Company ?"><i class="fa fa-check fa-lg" id="icon_'.$value['company_id'].'"></i></a>';
                    }
                  ?></td>
                  </tr>
                  <?php $sn++;} } else{?>
                  <tr><td colspan="5" align="center">No record found</td></tr>
                  <?php }?>
                </tbody>

              </table>
            </div>
          </div>
        </section>

        <!--body wrapper end-->
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="CompanyModal" role="dialog" tabindex="-1" id="CompanyModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Company Details</h4>
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

      <script>
        function confirmDelete(id) {
          var delUrl ="<?php echo base_url('apanel/company/Deletecompany/') ?>";
      //var Id="<?php //echo ci_enc(id);?>";
     // alert(Id);
     if (confirm("Are you sure you want to delete this record?")) {
      document.location = delUrl+''+id;
    }
  }


</script>
<script type="text/javascript">
  $(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
  });
</script>
<script type="text/javascript">

  $("body").on("click",".Company_changeStatus",function(){
        // alert("helllo");return false;

        var temp  =  $(this).attr('id');

       // alert(temp);
       var temp2 = temp.split("_");
       var action = temp2[0];
       var actionid = temp2[1];
       // alert(actionid);return false;
       if(confirm("Do you really want to "+action+" this Company ?"))
       {
         $.post("<?php echo base_url('apanel/Company/Company_changeStatus');?>",{ac:action,acid:actionid},function(response){
          // alert(response);return false;
          if(response == 'ok'){
           if(action == 'block'){
              // $("#statuscell_"+actionid).html("<span class='label label-danger'>Blocked</span>");
              $("#"+temp).attr("title","Activate this Company");
              $("#"+temp).attr("id","activate_"+actionid);
              $("#icon_"+actionid).removeClass("fa-ban");
              $("#icon_"+actionid).addClass("fa-check");
              $("#span_active_"+actionid).css('display','none');
              $("#span_deactivate_"+actionid).css('display','inline-block');
              //location.reload();
            }
            else
            {          
                        // $("#statuscell_"+actionid).html("<span class='label label-success'>Active</span>");
                        $("#"+temp).attr("title","Block this Company");
                        $("#"+temp).attr("id","block_"+actionid);
                        $("#icon_"+actionid).removeClass("fa-check");
                        $("#icon_"+actionid).addClass("fa-ban");
                        $("#span_deactivate_"+actionid).css('display','none');
                        $("#span_active_"+actionid).css('display','inline-block');
                        //location.reload();
                      }
                    }
                  });
       }


     });
   </script>
   <script>

    $(document).ready(function() {
      jQuery.fn.dataTableExt.oApi.fnFilterClear  = function ( oSettings )
      {
        var i, iLen;

        /* Remove global filter */
        oSettings.oPreviousSearch.sSearch = "";

        /* Remove the text of the global filter in the input boxes */
        if ( typeof oSettings.aanFeatures.f != 'undefined' )
        {
          var n = oSettings.aanFeatures.f;
          for ( i=0, iLen=n.length ; i<iLen ; i++ )
          {
            $('input', n[i]).val( '' );
          }
        }

            /* Remove the search text for the column filters - NOTE - if you have input boxes for these
             * filters, these will need to be reset
             */
             for ( i=0, iLen=oSettings.aoPreSearchCols.length ; i<iLen ; i++ )
             {
              oSettings.aoPreSearchCols[i].sSearch = "";
            }

            /* Redraw */
            oSettings.oApi._fnReDraw( oSettings );
          };
          $('#ajaxDataTableCompany').dataTable({
          //"sDom": 'tiplr',  
          //"bDeferRender": true,
         // 'bProcessing': true,          
         //  'oLanguage': {
         //    'sProcessing': '<div style="background:#FFFFFF;width:100%;margin-top:15px;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="margin-left:0%;margin-top:10px;font-size:30px;"></i></div>'
         //  },
            //"serverSide": true,
            //"processing": true,
          //"bProcessing": true,
           "paging": true,
            "pageLength":100,
           "ajax": "<?php echo base_url('apanel/Company/ajaxDataTableCompany');?>",
            "deferLoading":<?php echo $deffer_load_count;?>,           
            //"bDeferRender": true,
            "order": [[ 0, "asc" ]],
            "aoColumnDefs": [
            { "bVisible": true, "aTargets": [0] },
            {
              "bSortable": true,
              "aTargets": ["no-sort"]  
            }],
            //"dom": 'T<"clear">lfrtip',
            tableTools: {
             "sSwfPath": ""
           }
         }).fnFilterClear();

        });
      </script>