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
                 <li>Manage Logs</li>                 
             </ul>
             <!--breadcrumbs end -->
             
             <section class="panel">
                <header class="panel-heading">
                    Log data List
                    <span class="tools pull-right">
                        <!-- <a href="<?php echo base_url(); ?>apanel/Log-data/Add" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-plus"></i> Send Log-data </button></a> -->

                        <!-- <a class="btn btn-primary" href="<?php echo base_url(); ?>apanel/Showsupplier">Add Supplier</a> -->
                    </span>
                </header>
                <div class="panel-body">
                 <div class="adv-table">
                  <table  class="display table table-bordered table-striped dynamic_data_table" id="ajaxDataTableLog-data">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Keyword</th>
                            <th>Log Count</th>
                           <!--  <th>Date</th>  -->                           
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                   
                        </table>
                    </div>
                </div>
            </section>

            <!--body wrapper end-->
            <!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="Log-dataModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Logs Details</h4>
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
    var delUrl ="<?php echo base_url('apanel/Log-data/Delete/') ?>";
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
        $('#ajaxDataTableLog-data').dataTable({
            //'processing': true,
            //'serverSide': true,    
             'bProcessing': true,          
                  'oLanguage': {
              'sProcessing': '<div style="background:#FFFFFF;width:100%;margin-top:15px;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="margin-left:0%;margin-top:10px;font-size:30px;"></i></div>'
          },       
            "ajax": "<?php echo base_url('apanel/Log-data/ajaxDataTableLog')?>",
            "pageLength":100,
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