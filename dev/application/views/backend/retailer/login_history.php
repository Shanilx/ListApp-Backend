<?php 
//print_r($record);die;
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
         <!-- <li><a href="<?php echo base_url().'apanel/Retailer'?>"><i class="fa fa-users"></i>Manage Retailer</a></li> -->
           <li>Login History</li>        
         </ul>
         <!--breadcrumbs end -->
         <section class="panel">
          <header class="panel-heading">
            Login History
               <div class="pull-right">
             <?php
                  //uri segment for active class
             $con = $this->uri->segment(2);
             $met = $this->uri->segment(4);
             //$met = $this->uri->segment(5);
             ?>
             <select id="history_menu" class="btn btn-primary ">
               <option value="today" <?php if($met=='today') { echo 'selected'; } ?> >Today</option>
               <option value="last_week" <?php if($met=='last_week') { echo 'selected'; } ?> >Last Week</option>
               <option value="last_month" <?php if($met=='last_month') { echo 'selected'; } ?> >Last Month</option>                      
             </select>
           </div>
           <div class="clearfix"></div>                   
          </header>
          <div class="panel-body">
           <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="dynamic-table">
            <thead>              
              <tr>
                <th>#</th>                           
                <th>User Name</th>
                <th>Contact Number</th>
                <th>Screens Visited</th>
                <th>Login Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($record)){
                $i=1;
                foreach ($record as $rec) {
              ?>
              <tr>
                <td><?php echo $i;?></td>                         
                <td><?php echo strtoupper($rec['user_name']);?></td>                         
                <td><?php echo $rec['phone'];?></td> 
                <td>
                  <?php 
                  if(!empty($rec['screen_visit'])){
                    $screen=explode(',', $rec['screen_visit']);
                    $count=count($screen);
                    if($count > 5){
                      echo str_replace(',',' -> ',substr($rec['screen_visit'],0,30)).'...';
                      //echo substr(str_replace(',',' -> ',$rec['screen_visit']),0,30).'...';
                    }else{
                      echo str_replace(',',' -> ',$rec['screen_visit']);
                    }
                  }else{
                      echo'-';
                    }
                  ?>
                    
                  </td>
                <td><?php echo date('d-m-Y h:i:s',(strtotime($rec['created_date'])));?></td>
                <td><a class='btn btn-default btn-sm' data-target='#screenModal' data-toggle='modal' href="<?php echo base_url();?>backend/Retailer/screen_detail/<?php echo ci_enc($rec['lh_id']);?>" title='View Retailer'><i class='fa fa-eye'></i></a></td>
              </tr>
              <?php  $i++; } }else{
              ?>
              <tr>
                <td colspan="3" align="center">No Record Found</td>
              </tr>
              <?php   }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
</div>
</div>
</div>

  <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="screenModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Screen Details</h4>
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
<style type="text/css">
  #dynamic-table_length{
    display: none !important;
  }
</style>

    <!--body wrapper end-->

    <script type="text/javascript">
      $("#history_menu").change(function(){   
       var value= $(this).val();
       if(value=="today"){
        window.location="<?php echo base_url().'apanel/login-history/today';?>";
      }
      else if(value=="last_week"){
       window.location="<?php echo base_url().'apanel/login-history/last_week';?>";
     }
     else if(value=="last_month"){
      window.location="<?php echo base_url().'apanel/login-history/last_month';?>";
    }


  });

      $('body').load(function () {
        $('#dynamic-table_length').css('display','none');
      })

</script>