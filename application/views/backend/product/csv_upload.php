 <style type="text/css">


.alert_new {
    display: none;
}
  .progress, .alert {
    margin: 15px;
}

.alert {
    display: none;
}
</style>
 <style>
.form-wrap{
    max-width: 500px;
    padding: 30px;
    background: #f1f1f1;
    margin: 20px auto;
    border-radius: 4px;
  text-align: center;
}
.form-wrap form{
  border-bottom: 1px dotted #ddd;
  padding: 10px;
}
.form-wrap #output{
    margin: 10px 0;
}
.form-wrap .error{
    color: #d60000;
}
.form-wrap .images {
    width: 100%;
    display: block;
    border: 1px solid #e8e8e8;
    padding: 5px;
    margin: 5px 0;
}
.form-wrap .thumbnails {
    width: 32%;
    display: inline-block;
    margin: 3px;
}

/* progress bar */
#progress-wrp {
    border: 1px solid #9E9E9E;
    padding: 1px;
    position: relative;
    margin-left: 15px;
    border-radius: 3px;
    margin: 10px;
    text-align: left;
    background: #fff;
    box-shadow: inset 1px 3px 6px rgba(0, 0, 0, 0.12);
}
#progress-wrp .progress-bar{
  height: 20px;
    border-radius: 3px;
    /*background-color: #5cb85c;*/
    /*background-color: #f39ac7;*/
    width: 0;
    box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
}
.Bar_color_none{
background-color: #fff !important;
}
.Bar_color_succ{
background-color: #5cb85c !important;
}
#progress-wrp .status{
  top:3px;
  left:50%;
  position:absolute;
  display:inline-block;
  color: #000000;
}
#valid_file{
  color:red;
  margin-top: 10px;

}
#csv{
      margin-top: 20px;
    margin-left: 181px;
}
</style>

 <!-- page heading start -->
        <div class="page-heading">
            <h3>
              <!--  Bulk Upload  -->
            </h3>
            
        </div>
        <!-- page heading end-->


        <!--body wrapper start-->
        <div class="wrapper">
        <?php 
                $msg ="";
                  if($this->session->flashdata('succ'))
                  {
                    $class = "alert alert-success fade in";
                    $msg .= $this->session->flashdata('succ');
                  }elseif($this->session->flashdata('err'))
                  {
                    $class = "alert alert-block alert-danger fade in";
                    $msg .= $this->session->flashdata('err');
                  }else
                  {
                    $class = "alert alert-block alert-danger fade in";
                    $msg .= validation_errors();
                  } 
                  if($msg!=""){
                ?>
                <div class="alert alert-block <?php echo $class;?> fade in">
                  <button data-dismiss="alert" class="close close-sm" type="button">
                      <i class="fa fa-times"></i>
                  </button>
                 <?php echo $msg;?>                                                          
              </div>
            <?php 
              }
        ?>
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <ul class="breadcrumb panel">
                   <li><a href="<?php echo base_url().'apanel/dashboard'?>"><i class="fa fa-home"></i> Dashboard</li></a>
                   <li><a href="<?php echo base_url().'apanel/product/1'?>">Manage Product</li></a>
                   <li>Bulk Upload</li>
                </ul>
        <section class="panel">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                             Bulk Upload
                             <a href="<?php echo base_url('uploads');?>/xlsx_sample_file/Sample ListApp File.xlsx" style="padding: 0px;float:right;"><button class="btn btn-success __web-inspector-hide-shortcut__" type="button" download>Download Sample File</button></a>
                            
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <form class="cmxform form-horizontal adminex-form" id="upload_csv_form" method="post" action="<?php echo base_url().'apanel/product/upload_file_in_db'?>" name="upload_csv_form" enctype="multipart/form-data">
                                <div class="succ_msg"></div>
                                <div class="error_msg"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Upload XLSX File<span class="require_class">*</span></label>
                                            <!-- <div class="col-lg-6"> -->
                                            <div class="col-sm-8">
                                            
                                                
                                                <input type="file" class="form-control" name="csv_file" id="csv_file" class="filenam"  />
                                                <br><span>Note : Please use Sample XLSX file for Bulk Product Upload</span>

                                            </div>
                                            
                                    </div>
                                      <!-- <img src="" style="display:none"> -->
                                      <div class="form-group" >
                                         <div class="col-md-2" ></div>
                                         <!-- <div id="progress-wrp" class="col-sm-5" style="display:none;" >
                                             <div class="progress-bar Bar_color_none" ></div>
                                              <div class="status">0%</div>
                                             

                                         </div> -->
                                         <div class="col-sm-5" >
                                         <p  id="loder_upload" style="display:none;margin-left: 194px;"><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i><br><span>Uploading...</span></p>
                                           <div id="output"><!-- error or success results --></div> 
                                           <div class="alert alert-success" role="alert">Loading completed!</div>
                                            <p id="valid_file" ></p>
                                            </div>

                                               

                                     </div>
                                 </div>

                                     


                               <!--  <div id="progress-wrp" class="col-sm-8 ">
                                   <div id="progress-bar" >10%</div>
                                   <div id="myBar" class="form-control progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" >10%</div>
                                </div>  -->
                                    
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-6">
                                            <!-- <button class="btn btn-primary" type="submit" id="csv" >Submit</button> -->
                                           <input name="submit" type="submit" value="Upload" class="btn btn-primary upload_csv_btn" id="csv"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            </section>
            </div>
            </div>
            </div>

        <!-- body wrapper end -->

        <script type="text/javascript">
   
$("#upload_csv_form").validate({
            ignore: [],
            rules: {
                csv_file: {
                    required: true,
                     extension: "xlsx"
                   
                },
                
            },
            messages: {
                
                csv_file: {
                    required: 'Please Select XLSX File',
                    extension:"Please Select Valid XLSX File and Try Again"
                    
                },
                
                
            }
        });

$('#upload_csv_form input').on('keyup blur', function () { // fires on every keyup & blur
        if ($('#upload_csv_form').valid()) {                   // checks form for validity
            $('.upload_csv_btn').prop('disabled', false);        // enables button
        } else {
            $('.upload_csv_btn').prop('disabled', 'disabled');   // disables button
        }
    });

</script>


<script src="<?php echo base_url(); ?>js/jquery.form.min.js"></script>

<script type="text/javascript">
  //configuration

var result_output       = '#output'; //ID of an element for response output
var my_form_id        = '#upload_csv_form'; //ID of an element for response output
var progress_bar_id     = '#progress-wrp'; //ID of an element for response output
var total_files_allowed   = 1; //Number files allowed to upload

  // /on form submit
$(my_form_id).on( "submit", function(event) { 
  event.preventDefault();
  var proceed = true; //set proceed flag
  var error = []; //errors
  var total_files_size = 0;
  //reset progressbar
  $(progress_bar_id +" .progress-bar").css("width", "0%");
  $(progress_bar_id +" .progress-bar").removeClass("Bar_color_none"); 
  $(progress_bar_id +" .progress-bar").addClass("Bar_color_succ"); 
  $(progress_bar_id + " .status").text("0%");

  if(!window.File && window.FileReader && window.FileList && window.Blob){ //if browser doesn't supports File API
    error.push("Your browser does not support new File API! Please upgrade."); //push error text
  }
  else
  {
    // var fileExt = sender.value;

    $(this.elements['csv_file'].files).each(function(i, ifile){
      if(ifile.value !== ""){ //continue only if file(s) are selected

       

        total_files_size = total_files_size + ifile.size; //add file size to total size
      }
    });
   
  
   var submit_btn  = $(this).find("input[type=submit]"); //form submit button 

   //if everything looks good, proceed with jQuery Ajax
   if(proceed){
      //submit_btn.val("Please Wait...").prop( "disabled", true); //disable submit button
      var form_data = new FormData(this); //Creates new FormData object
      var post_url = $(this).attr("action"); //get action URL of form
     $("#loder_upload").show();
      //jQuery Ajax to Post form data
$.ajax({
  url : post_url,
  type: "POST",
  data : form_data,
  contentType: false,
  cache: false,
  processData:false,
  /*xhr: function(){
    //upload Progress
    var xhr = $.ajaxSettings.xhr();
    if (xhr.upload) {
      xhr.upload.addEventListener('progress', function(event) {
        var percent = 0;
        var position = event.loaded || event.position;
        var total = event.total;
        if (event.lengthComputable) {
          percent = Math.ceil(position / total * 100);
        }
       
        $(progress_bar_id +" .progress-bar").css("width", + percent +"%");

        $(progress_bar_id + " .status").text(percent +"%");
      }, true);
    }
    return xhr;
  },*/
  mimeType:"multipart/form-data"
}).done(function(res){ //
//alert(res);
//console.log(res);
 //return false;
  $("#loder_upload").hide();
  if(res!='')
  {
    if(res=='1')
    {
      
                            setTimeout(function() {
                                window.location.href = "<?php echo base_url();?>apanel/product/1";
                            }, 1000);
    }
    else if(res=='2'|| res=='21')
    {
       
       setTimeout(function() {
                                window.location.href = "<?php echo base_url();?>apanel/product/1";
                            }, 1000);
    }
    else if(res=='3')
    {
     
       setTimeout(function() {
                                window.location.href = "<?php echo base_url();?>apanel/product/1";
                            }, 1000);
    }
   else if(res=='4' )
    {
       
       setTimeout(function() {
                                window.location.href = "<?php echo base_url();?>apanel/product/1";
                            }, 1000);
    }
 else{
  setTimeout(function() {
                                window.location.href = "<?php echo base_url();?>apanel/product/1";
                            }, 1000);
 }

    //window.location.href = "<?php echo base_url();?>apanel/product/1";
  }
  $(my_form_id)[0].reset(); //reset form
 
  submit_btn.val("Upload").prop( "disabled", false); //enable submit button once ajax is done
});
      
    }

  }
  $(result_output).html(""); //reset output 
  $(error).each(function(i){ //output any error to output element
    $(result_output).append('<div class="error">'+error[i]+"</div>");
  });
    
});
    

</script>


    <script type="text/javascript" src="<?php echo base_url();?>js/dropzone.js"></script>
        
<script>
// $(document).ready(function () {
$('input[type=file]').change(function () {
var val = $(this).val().toLowerCase();
// alert(val);
// return false;
var regex = new RegExp("(.*?)\.(xls|xlsx)$");
 if(!(regex.test(val))) {
$(this).val('');
 // error.push( "<b>"+ val + "</b> is unsupported file type!"); //push error text
// alert('Please select correct file format');
$('#valid_file').html('Please Select Correct File Format');
$('#csv').prop("disabled",true);
} 
else
{
  $('#valid_file').html('');
  $('#csv').prop("disabled",false);
   // $('#progress-wrp').show();
}


}); 
 // });
</script> 
<script type="">
$(document).ready(function(){
  $("#csv").prop("disabled",true);

});

  
</script>
<script type="">

 $("#csv").click(function(){
  $("#progress-wrp").show();

 });



  
</script>





