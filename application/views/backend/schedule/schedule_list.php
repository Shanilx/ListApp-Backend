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
                 <li>Manage Schedule</li>
                 
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
                <div class="clearfix"></div>
                <header class="panel-heading">
                    Schedule List
                    <span class="tools pull-right">
                        <a href="<?php echo base_url(); ?>apanel/Schedule/add" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-plus"></i> Add Schedule </button></a>

                        <!-- <a class="btn btn-primary" href="<?php echo base_url(); ?>apanel/Showsupplier">Add Supplier</a> -->
                    </span>
                </header>
                <div class="panel-body">
                 <div class="adv-table">
                  <table  class="display table table-bordered table-striped" id="ajaxDataTableSchedule">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Schedule Name</th>
                            <th>Date</th>
                            <th>Status</th> 
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    
                        </table>
                    </div>
                </div>
            </section>

            <!--body wrapper end-->
    
<script>
   

  function confirmDelete(id) {
    var delUrl ="<?php echo base_url('apanel/Schedule/DeleteSchedule/') ?>";
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

$("body").on("click",".schedule_changeStatus",function(){
        // alert("helllo");return false;

       var temp  =  $(this).attr('id');

       // alert(temp);
       var temp2 = temp.split("_");
       var action = temp2[0];
       var actionid = temp2[1];
       // alert(actionid);return false;
      if(confirm("Do you really want to "+action+" this Schedule ?"))
       {
         $.post("<?php echo base_url('apanel/Schedule/Schedule_changeStatus');?>",{ac:action,acid:actionid},function(response){
          // alert(response);return false;
          if(response == 'ok'){
             if(action == 'block'){
              // $("#statuscell_"+actionid).html("<span class='label label-danger'>Blocked</span>");
               $("#"+temp).attr("title","Activate this Schedule");
               $("#"+temp).attr("id","activate_"+actionid);
               $("#icon_"+actionid).removeClass("fa-ban");
               $("#icon_"+actionid).addClass("fa-check");
                location.reload();
             }
             else
             {          
                        // $("#statuscell_"+actionid).html("<span class='label label-success'>Active</span>");
                        $("#"+temp).attr("title","Block this Schedule");
                        $("#"+temp).attr("id","block_"+actionid);
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


        $('#ajaxDataTableSchedule').dataTable({
            //'processing': true,
            //'serverSide': true,
             'bProcessing': true,          
                  'oLanguage': {
              'sProcessing': '<div style="background:#FFFFFF;width:100%;margin-top:15px;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="margin-left:0%;margin-top:10px;font-size:30px;"></i></div>'
          },
            "ajax": "<?php echo base_url('apanel/Schedule/ajaxDataTableSchedule')?>",
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