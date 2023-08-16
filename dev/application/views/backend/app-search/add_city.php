  <!--body wrapper start-->
  <div class="wrapper">

    <?php 

    $msg ="";
    if($this->session->flashdata('succ'))
    {
      $class = "alert alert-success";
      $msg .= $this->session->flashdata('succ');
    }
    else{
      $class = "alert alert-danger";
      $msg .= validation_errors('<h5>','</h5>');
    }
    if($msg!="")
    {
      ?>
      <div class="alert alert-block <?php echo $class;?> fade in" style="text-align: center;">
        <button data-dismiss="alert" class="close close-sm" type="button"> <i class="fa fa-times"></i> </button>
        <?php echo $msg;?> 
      </div>

      <?php } ?>




      <div class="row">
        <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb panel">
            <li><a href="<?php echo base_url();?>apanel/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url();?>apanel/city-search/city-list">Manage City Search</a></li>
            <li class="active">Add City</li>
          </ul>
          <!--breadcrumbs end -->
        </div>
      </div>


      <div class="row">

        <div class="col-sm-12 col-md-12">
          <section class="panel">
            <header class="panel-heading">
              Add City

              <span class="tools pull-right">
               <span class="error" style="text-transform: lowercase;">all the fields marked with (*) are mandatory</span>
             </span>

           </header>
           <div class="panel-body">
            <section class="panel">
              <div class="panel-body">
                <div class="col-md-12">
                 <form role="form" class="form-vertical" action="<?php echo base_url(); ?>apanel/city-search/add_city" method="post" id="add_city" name="add_city">
                  <div class="form-group col-md-12">
                    <div class="col-md-3">
                      <label>State<span class="error">*</span></label>
                    </div>
                    <div class="col-md-6">
                      <select name="state_id" id="state_id" class="form-control" >
                        <option value="">Select State</option>
                        <?php if(!empty($states)){ 
                         foreach ($states as $value) { ?>
                         <option value="<?php  echo $value['id']; ?>"><?php  echo $value['name']; ?></option>

                         <?php  } } ?>
                       </select>
                     </div>
                   </div>

                   <div class="clearfix"></div>            
                   <div class="form-group col-md-12">
                    <div class="col-md-3">
                      <label>City<span class="error">*</span></label>                      
                    </div>
                    <div class="col-md-6">
                      <select name="city_id" id="city_id" class="form-control">
                        <option value="">Select City</option>
                      <?php /*if(!empty($cities)){ 
                       foreach ($cities as $value) { ?>
                       <option value="<?php  echo $value['id']; ?>"><?php  echo $value['name']; ?></option>
                       <?php  } } */?>
                     </select>
                   </div>
                 </div>
                 <div class="form-group col-md-12">
                  <div class="col-md-3"></div>
                  <div class="col-md-6">
                    <input class="btn btn-primary" type="submit" name="add_submit" value="Save">
                    <a href="<?php echo base_url();?>apanel/city-search/city-list" class="btn btn-primary">Cancel</a>
                  </div>
                </div>       
              </form>
            </div>
          </div>
        </section>
      </div>
    </section>
  </div>

  <script type="text/javascript">
   $(document).ready(function () {
    $("body").on('change','#state_id',function(){
      var state_id=$("#state_id").val();
        //alert(state_id);
        $.ajax({
         url:"<?php echo base_url('apanel/Retailer/getAllcities');?>",
         type:"POST",
         data:{'state_id':state_id },
         success : function(data){
                        //alert(data);
                        if(data){
                          $("#city_id").html(data);
                        }
                      }
                    });
        
      });
    
  });
</script>

<script type="text/javascript">
var check_city_url="<?php echo base_url();?>apanel/city-search/check-city";
//alert(check_city_url);
  $("#add_city").validate({
    ignore: [],
    rules: {
      city_id: {
        required:true,
        remote: {
          url: check_city_url,
          type: "post",
          data: {
            city_id: function() 
            {
              return $("#city_id").val();
            }
          }
        } 
      },
      state_id:{
        required:true
      }

    },
    messages:{
      'city_id':{            
        required: "Please Select City",
        remote:"City Already Selected"

      },
      'state_id':{            
        required: "Please Select State"   
      }
    }
  });
</script>
