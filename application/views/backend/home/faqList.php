<?php //echo "<pre>"; print_r($record);
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
            
    if($msg!=""){?>
        <div class="alert alert-block <?php echo $class;?> fade in" style="text-align: center;">
            <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
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
                   <li>Manage FAQ</li>
                </ul>
            <!--breadcrumbs end -->

             <section class="panel">
                <header class="panel-heading">
                    FAQ List
                    <span class="tools pull-right">
                        <a href="<?php echo base_url().'apanel/home/addfaq'?>" style="padding: 0px;"><button class="btn btn-primary __web-inspector-hide-shortcut__" type="button"><i class="fa fa-plus"></i> FAQ </button></a>
                     </span> 
                </header>
                <div class="panel-body">
                   <div class="adv-table">
                      <table  class="display table table-bordered table-striped" <?php if(!empty($record)) { ?> id="dynamic-table" <?php } ?> >
                   <thead>
                        <tr>
                            <th class="numeric">#</th>
                            <th class="numeric">Question</th>
                            <th class="numeric">Answer</th>
                            <th class="numeric">Status</th>
                            <th class="numeric">Action</th>
                       </tr>
                    </thead>
                    <tbody>       

                        <?php
                        if(!empty($record))
                        {   
                            $i=0;
                            foreach ($record as $rec) 
                            {   
                                $i++;
                        ?>
                        <tr>

                            <td><?php echo $i;?></td>
                            <td><?php echo substr($rec['question'],0,30); ?>...</td>
                            <td><?php echo substr($rec['answer'],0,30); ?>...</td>
                            <td>
                                <?php
                                //echo $rec['status'];
                                    if($rec['status']=='1'){  ?>
                                    <span id="span_active_<?php echo $rec['faq_id']; ?>" class="label label-success">Active</span> 
                                    <span id="span_block_<?php echo $rec['faq_id']; ?>" class="label label-danger" style="display:none;">Deactive</span>
                                    <?php }else{?>
                                    <span id="span_active_<?php echo $rec['faq_id']; ?>" class="label label-success"  style="display:none;">Active</span> 
                                    <span id="span_block_<?php echo $rec['faq_id']; ?>" class="label label-danger">Deactive</span>
                                <?php }?>
                            </td>
                            <td>
                                <a class="btn btn-default btn-sm" data-target='#faqModal' data-toggle="modal" href="<?php echo base_url();?>apanel/home/detail/<?php echo $rec['faq_id']; ?>" title="View"><i class="fa fa-eye"></i></a>
                                &nbsp;&nbsp;
                                <a class="btn btn-default btn-sm" href="<?php echo base_url();?>apanel/home/editfaq/<?php echo ci_enc($rec['faq_id']); ?>" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                &nbsp;&nbsp;

                                <?php if($rec['status']==1){

                                    ?>
                                 <a href="javascript:void(0)" id="block_<?php echo $rec['faq_id']; ?>" title="Deactive" class="changeStatus btn btn-default" onclick="block_status('<?php echo $rec['faq_id'] ?>','<?php echo $rec['status']; ?>')"><i class="fa fa-ban fa-lg" id="icon_<?php echo $rec['faq_id']; ?>"></i></a>

                                <a href="javascript:void(0)" id="active_<?php echo $rec['faq_id']; ?>" title="Active" class="changeStatus btn btn-default" onclick="active_status('<?php echo $rec['faq_id'] ?>','<?php echo $rec['status']; ?>')" style="display:none;"><i class="fa fa-check fa-lg" id="icon_<?php echo $rec['faq_id']; ?>"></i></a>

                                <?php } else{?>

                                <a href="javascript:void(0)" id="active_<?php echo $rec['faq_id']; ?>" title="Active" class="changeStatus btn btn-default" onclick="active_status('<?php echo $rec['faq_id'] ?>','<?php echo $rec['status']; ?>')"><i class="fa fa-check fa-lg" id="icon_<?php echo $rec['faq_id']; ?>"></i></a>

                                <a href="javascript:void(0)" id="block_<?php echo $rec['faq_id']; ?>" title="Deactive" class="changeStatus btn btn-default" onclick="block_status('<?php echo $rec['faq_id']; ?>','<?php echo $rec['status']; ?>')" style="display:none;"><i class="fa fa-ban fa-lg" id="icon_<?php echo $rec['faq_id']; ?>"></i></a>

                                <?php } ?>

                            </td>
                         </tr>

                        <?php
                                }
                            }  else {  
                        ?>

                        <tr>
                            <td colspan="6" align="center">No Record Found</td>
                        </tr>
                        <?php
                            }
                        ?>
                    
                    </tbody>
         
        </table>
        </div>
        </div>
        </section>

         <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="faqModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Details</h4>
                    </div>
                    <div class="modal-body">
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
    $('#faqModal').removeData('bs.modal')
});

//Edit SL: more universal
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});
</script>

<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    var url_path = base_url+'backend/home/update_faq_status';
</script>

