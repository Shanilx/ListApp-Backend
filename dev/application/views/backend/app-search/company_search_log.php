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
                 <li>Manage Company Search</li>                 
             </ul>
             <!--breadcrumbs end -->
             
             <section class="panel">
                <header class="panel-heading">
                    Company Search List
                     <div class="pull-right">
                       <?php
                            //uri segment for active class
                       $con = $this->uri->segment(2);                       
                       $met = $this->uri->segment(3);
                       ?>
                       <select id="history_menu" class="btn btn-primary ">
                         <option value="product" <?php if($met=='product') { echo 'selected'; } ?> >Product</option>
                         <option value="company" <?php if($met=='company') { echo 'selected'; } ?> >Company</option>
                         <option value="supplier" <?php if($met=='supplier') { echo 'selected'; } ?> >Supplier</option>                      
                       </select>
                     </div>
                     <div class="clearfix"></div> 
                </header>
                <div class="panel-body">
                 <div class="adv-table">
                  <table  class="display table table-bordered table-striped dynamic_data_table" id="product_search-log">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Contact Number</th>
                            <th>Search Keyword</th>
                            <th>Company Name</th>
                            <th>Search Count</th>   
                            <th>Search date</th>   
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
  //   function confirmDelete(id) {
  //   var delUrl ="<?php //echo base_url('apanel/Log-data/Delete/') ?>";
  //     //var Id="<?php //echo ci_enc(id);?>";
  //    // alert(Id);
  //     if (confirm("Are you sure you want to delete this record?")) {
  //     document.location = delUrl+''+id;
  //   }
  // }


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
        $('#product_search-log').dataTable({
            //'processing': true,
            //'serverSide': true,    
             'bProcessing': true,          
                  'oLanguage': {
              'sProcessing': '<div style="background:#FFFFFF;width:100%;margin-top:15px;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="margin-left:0%;margin-top:10px;font-size:30px;"></i></div>'
          },       
            "ajax": "<?php echo base_url('backend/App_search_history/c_search_log')?>",
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
<script type="text/javascript">
      $("#history_menu").change(function(){   
       var value= $(this).val();
       //alert(value);
       if(value=="product"){
        window.location="<?php echo base_url().'apanel/app-search/product';?>";
      }
      else if(value=="company"){
       window.location="<?php echo base_url().'apanel/app-search/company';?>";
     }
     else if(value=="supplier"){
      window.location="<?php echo base_url().'apanel/app-search/supplier';?>";
    }


  });
</script>