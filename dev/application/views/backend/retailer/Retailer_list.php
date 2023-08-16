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
                 <li>Manage Retailer</li>
             </ul>
             <!--breadcrumbs end -->
             <section class="panel">
                <header class="panel-heading">
                    Retailer List
                    <span class="tools pull-right">
                      <a href="<?php echo base_url().'backend/Retailer/export_retailer'?>" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Retailer</button></a>
                      <a href="<?php echo base_url().'apanel/Retailer/Import'?>" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Import Retailer</button></a>
                        <a href="<?php echo base_url(); ?>apanel/Retailer/Showretailer" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-plus"></i> Add Retailer </button></a>

                        <!-- <a class="btn btn-primary" href="<?php echo base_url(); ?>apanel/Showretailer">Add Retailer</a> -->
                    </span>
                </header>
                <div class="panel-body">
                 <div class="adv-table">
                  <table  class="display table table-bordered table-striped" id="ajaxDataTableRetailer" style="
    display: block; overflow-x: auto;">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>User Type</th>
                            <th>Firm Name</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <!-- <th>Role</th> -->
                            <!-- <th>Email</th> -->
                            <th>Address</th>
                            <th>State</th>
                            <th>City</th>
                            <!-- <th>Area</th> -->
                            <!-- <th>DL No </th> -->
                            <!-- <th>GSTIN No</th> -->
                            <!-- <th>ESTD Year</th> -->
                            <!-- <th>Contact Person</th> -->
                            <!-- <th>Contact Number</th> -->
                            <!-- <th>Authentication</th> -->
                            <th>Registered</th>
                            <th>Status</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                   
                        </table>
                    </div>
                </div>
            </section>

            <!--body wrapper end-->

             <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="retailerModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Retailer Details</h4>
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
    var delUrl ="<?php echo base_url('apanel/Retailer/Deleteretailer/') ?>";
    
      if (confirm("Are you sure you want to delete this record?")) {
      document.location = delUrl+''+id;
    }
  }


</script>
<script type="text/javascript">

//   $(document.body).on('hidden.bs.modal', function () {
//     $('#patientModal').removeData('bs.modal')
// });
//Edit SL: more universal
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
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

        $('#ajaxDataTableRetailer').dataTable({
            //'processing': true,
            //'serverSide': true,
             'bProcessing': true,          
                  'oLanguage': {
              'sProcessing': '<div style="background:#FFFFFF;width:100%;margin-top:15px;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="margin-left:0%;margin-top:10px;font-size:30px;"></i></div>'
          },
            "ajax": "<?php echo base_url('apanel/Retailer/ajaxDataTableRetailer')?>",
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
        }).fnFilterClear();
});
</script>
<script type="text/javascript">

$("body").on("click",".retailer_changeStatus",function(){
        // alert("helllo");return false;

       var temp  =  $(this).attr('id');

       // alert(temp);
       var temp2 = temp.split("_");
       var action = temp2[0];
       var actionid = temp2[1];
       // alert(actionid);return false;
      if(confirm("Are you sure  to "+action+" this Retailer ?"))
       {
         $.post("<?php echo base_url('apanel/Retailer/retailer_changeStatus');?>",{ac:action,acid:actionid},function(response){
          // alert(response);return false;
          if(response == 'ok'){
             if(action == 'deactivate'){
              // $("#statuscell_"+actionid).html("<span class='label label-danger'>deactivateed</span>");
               $("#"+temp).attr("title","Activate this Retailer");
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
                        $("#"+temp).attr("title","deactivate this Retailer");
                        $("#"+temp).attr("id","deactivate_"+actionid);
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