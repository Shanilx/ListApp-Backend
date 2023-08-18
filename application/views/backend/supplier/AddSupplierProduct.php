  <!--body wrapper start-->
  <style type="text/css">
      .btn_align {
          margin: 30px 50px 0px 433px;
      }

      .change_bg {
          background: pink !important;
      }
  </style>
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
                  <li><a href="<?php echo base_url();?>apanel/product/1">Manage Product</a></li>
                  <li class="active">Add Product</li>
              </ul>
              <!--breadcrumbs end -->
          </div>
      </div>


      <div class="row">

          <div class="col-sm-12">
              <section class="panel">
                  <header class="panel-heading">
                      Add Product

                      <span class="tools pull-right">
                          <span class="error" style="text-transform: lowercase;">all the fields marked with (*) are
                              mandatory</span>
                      </span>

                  </header>
                  <div class="panel-body">
                      <section class="panel">
                          <div class="panel-body">
                              <form action="" method="post" name="addProduct" id="addProduct"
                                  enctype="multipart/form-data">

                                  <input type="hidden" name="page_no"
                                      value="<?php echo $this->session->userdata('page_no'); ?>">
                                  <div class="col-md-12">
                                      <div class="form-group col-md-6">
                                          <label for="exampleInputEmail1">Product Name <span
                                                  class="error">*</span></label>
                                          <input type="text"  value="<?php echo $data[0]['product_name']; ?>" class="form-control" id="product_name" name="product_name"
                                              value="<?php echo $data['product_name']; ?>"
                                              placeholder="Product Name">
                                          <p id="form_product_error"></p>
                                      </div>

                                      <div class="form-group col-md-6">
                                          <label for="exampleInputPassword1">Company Name <span
                                                  class="error">*</span></label>
                                          <input type="text" class="form-control" id="company_name" name="company_name"
                                              placeholder="Company Name">
                                          <div id="company_sug_box"></div>
                                          <!-- <select class="form-control" id="company_name" name="company_name">
                                        <option value="">Select Company</option>
                                        <?php if(!empty($companies)){
                                          foreach ($companies as $company) { ?>
                                            <option value="<?php echo $company['id'];?>"><?php echo $company['company_name'];?></option>
                                         <?php } } ?>

                                       </select> -->
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                      <div class="form-group col-md-6">
                                          <label for="exampleInputPassword1">Drug Name </label>

                                          <input type="text" class="form-control" id="drug_name" name="drug_name"
                                              placeholder="Drug Name">
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="exampleInputEmail1">Form</label>
                                          <input type="text" class="form-control" id="form_p" name="form_p"
                                              placeholder="Form" value="">

                                          <div id="form_p_sug_box"></div>
                                          <p id="form_error"></p>
                                      </div>
                                  </div>
                                  <div class="col-md-12">


                                      <div class="form-group col-md-6">
                                          <label for="exampleInputPassword1">MRP </label>

                                          <input type="text" class="form-control" id="mrp" name="mrp" placeholder="MRP">
                                          <span class="error" id="mrp_err"></span>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="exampleInputPassword1">Rate</label>

                                          <input type="text" class="form-control" id="rate" name="rate"
                                              placeholder="Rate">
                                          <span class="error" id="rate_err"></span>
                                      </div>
                                  </div>

                                  <div class="col-md-12">
                                      <div class="form-group col-md-6">
                                          <label for="exampleInputEmail1">Packing Type </label>
                                          <input type="text" class="form-control" id="packing_type" name="packing_type"
                                              placeholder="Packing Type">
                                          <div id="packingtype_sug_box"></div>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="exampleInputEmail1">Pack Size</label>
                                          <input type="text" class="form-control" id="pack_size" name="pack_size"
                                              placeholder="Pack Size">
                                          <input type="hidden" id="hide_txt" name="hide_txt" />
                                          <div id="pack_size_sug_box"></div>
                                      </div>

                                  </div>
                                  <div class="col-md-12">

                                      <div class="form-group col-md-6">
                                          <label for="exampleInputPassword1">Schedule </label>

                                          <input type="text" class="form-control" id="schedule" name="schedule"
                                              placeholder="Schedule">
                                          <div id="schedule_sug_box"></div>
                                      </div>
                                  </div>




                                  <div class="col-md-12">
                                      <div class="form-group btn_align">
                                          <button type="submit" class="btn btn-primary add_product"
                                              id="add_product">Save</button>

                                          <button type="button" name="cancel" id="cancel"
                                              onClick="window.location.href='<?php echo base_url(); ?>apanel/product/1'"
                                              class="btn btn-primary" style="margin-left:10px;">Cancel</button>
                                      </div>
                                  </div>


                              </form>

                          </div>
                      </section>
                  </div>
              </section>
              <script type="text/javascript">
                  $(document).ready(function () {
                      $("body").on("keyup", "#rate", function () {
                          var rate_value = $("#rate").val();
                          var mrp_value = $("#mrp").val();

                          if (parseFloat(rate_value) > parseFloat(mrp_value)) {

                              $("#rate_err").html("Rate must be less than or equals to MRP");

                              $('#add_product').addClass("disabled");
                              return false;

                          } else if (parseFloat(rate_value) < 0 || parseFloat(mrp_value) < 0) {
                              if (parseFloat(rate_value) < 0) {
                                  $("#rate_err").html("Please enter positive value");
                              } else {
                                  $("#rate_err").html("");
                              }

                              $('#add_product').addClass("disabled");
                              return false;
                          } else {
                              $("#rate_err").html("");
                              $('#add_product').removeClass("disabled");
                              return true;
                          }

                      });
                      $("body").on("keyup", "#mrp", function () {
                          var rate_value = $("#rate").val();
                          var mrp_value = $("#mrp").val();
                          // alert(rate_value);
                          // alert(mrp_value);
                          if (parseFloat(rate_value) > parseFloat(mrp_value)) {

                              $("#mrp_err").html("Rate must be less than or equals to MRP");

                              $('#add_product').addClass("disabled");
                              return false;

                          } else if (parseFloat(rate_value) < 0 || parseFloat(mrp_value) < 0) {
                              if (parseFloat(mrp_value) < 0) {
                                  $("#mrp_err").html("Please enter positive value");
                              } else {
                                  $("#mrp_err").html("");
                              }

                              $('#add_product').addClass("disabled");
                              return false;
                          } else {
                              $("#mrp_err").html("");
                              $('#add_product').removeClass("disabled");
                              return true;
                          }

                      });
                  });
              </script>


              <script type="text/javascript">
                  $("#addProduct").validate({
                      ignore: [],
                      rules: {
                          product_name: {
                              required: true,
                              //lettersonlynspace: true,
                              //minlength : 3,
                              //maxlength : 30,
                              // remote: {
                              //       url: product_check_url,
                              //       type: "post",
                              //       data: {
                              //                 // form_p: $("#form_p").val(),
                              //                 // form_p: $("#form_p").val(),

                              //                 product_name: function() 
                              //                 {
                              //                  // return $("#form_p").val();
                              //                 return $("#product_name").val();

                              //                 }
                              //             }
                              //         }
                          },
                          company_name: {
                              required: true,
                              //lettersonlynspace: true,
                              //minlength : 3,
                              // maxlength : 30,
                          },
                          // drug_name: {
                          //      required: true,
                          //      //lettersonlynspace: true,
                          //      //minlength : 3,
                          //     // maxlength : 30,
                          // },
                          /*form_p: {
                           required: true,
                               //email: true,

                             },*/
                          // pack_size:
                          // {
                          //   number:true,
                          // },
                          mrp: {
                              // required: true,
                              number: true
                          },
                          rate: {
                              number: true,
                          },
                      },
                      messages: {

                          product_name: {
                              required: 'Please enter Product Name',
                              remote: "Product Name Already Exist."

                          },
                          company_name: {
                              required: 'Please enter Company Name',

                          },
                          // drug_name: {
                          //      required: 'Please Enter Drug Name',
                          //       //lettersonlynspace: true,
                          //       //minlength : 3,
                          //      // maxlength : 30,
                          //  },
                          form_p: {
                              required: 'Please enter Form ',

                          },
                          mrp: {
                              //required: 'Please Enter MRP',
                              number: 'Please Enter only number',
                          },
                          // pack_size: {
                          //     number: 'Please Enter only number',
                          // },
                          rate: {
                              number: 'Please enter only number',
                          },

                      }
                  });

                  $("#company_name").keyup(function (e) {
                      var value = $(this).val().trim();
                      if (e.keyCode == 40) { // down
                          var selected = $(".change_bg");
                          if (selected.next().length == 0) {
                              //selected.siblings().first().addClass("change_bg");

                          } else {
                              $("#company_sug_box li").removeClass("change_bg");
                              selected.next().addClass("change_bg");
                          }
                          return false;
                      }
                      if (e.keyCode == 38) { // up
                          var selected = $(".change_bg");
                          if (selected.prev().length == 0) {
                              // $("#company_sug_box li").removeClass("change_bg");
                              //selected.siblings().last().addClass("change_bg");
                          } else {
                              $("#company_sug_box li").removeClass("change_bg");
                              selected.prev().addClass("change_bg");
                          }
                          return false;
                      }
                      if (e.keyCode == 13) { // down
                          e.preventDefault();
                          selectCompany();
                          return false;
                      }
                      //alert(value);
                      $("#company_sug_box").hide();
                      if (value.length > 1) {
                          $.ajax({
                              url: "<?php echo base_url('apanel/product/getCompany')?>",
                              type: "POST",
                              data: {
                                  'c_name': value
                              },
                              success: function (data) {
                                  //alert(data);
                                  $("#company_sug_box").html(data);
                                  $("#company_sug_box").show();
                              }
                          })
                      }
                  });
                  $("body").on('click', '.sugg_company', function () {
                      //alert('hiii');
                      var company = $(this).children('a').attr('title');

                      $("#company_name").val(company);

                      $("#company_sug_box").hide();
                  });

                  $("#schedule").keyup(function (e) {
                      var value = $(this).val().trim();
                      if (e.keyCode == 40) { // down
                          var selected = $(".change_bg");
                          if (selected.next().length == 0) {
                              // selected.siblings().first().addClass("change_bg");
                          } else {
                              $("#schedule_sug_box li").removeClass("change_bg");
                              selected.next().addClass("change_bg");
                          }
                          return false;
                      }
                      if (e.keyCode == 38) { // up
                          var selected = $(".change_bg");
                          if (selected.prev().length == 0) {
                              // selected.siblings().last().addClass("change_bg");
                          } else {
                              $("#schedule_sug_box li").removeClass("change_bg");
                              selected.prev().addClass("change_bg");
                          }
                          return false;
                      }
                      if (e.keyCode == 13) { // down
                          e.preventDefault();
                          selectSchedule();
                          return false;
                      }
                      $("#schedule_sug_box").hide();
                      if (value.length > 1) {
                          //alert(value);
                          $.ajax({
                              url: "<?php echo base_url('apanel/product/getSchedule')?>",
                              type: "POST",
                              data: {
                                  's_name': value
                              },
                              success: function (data) {
                                  // alert(data);
                                  $("#schedule_sug_box").html(data);
                                  $("#schedule_sug_box").show();
                              }
                          })
                      }
                  });

                  $("body").on('click', '.sugg_schedule', function () {
                      //alert('hiii');
                      var schedule = $(this).children('a').attr('title');

                      $("#schedule").val(schedule);
                      $("#schedule_sug_box").hide();

                  });

                  $("#packing_type").keyup(function (e) {
                      var value = $(this).val().trim();
                      if (e.keyCode == 40) { // down
                          var selected = $(".change_bg");
                          if (selected.next().length == 0) {
                              // selected.siblings().first().addClass("change_bg");
                          } else {
                              $("#packingtype_sug_box li").removeClass("change_bg");
                              selected.next().addClass("change_bg");
                          }
                          return false;
                      }
                      if (e.keyCode == 38) { // up
                          var selected = $(".change_bg");
                          $("#packingtype_sug_box li").removeClass("change_bg");
                          if (selected.prev().length == 0) {
                              // selected.siblings().last().addClass("change_bg");
                          } else {
                              selected.prev().addClass("change_bg");
                          }
                          return false;
                      }
                      if (e.keyCode == 13) { // down
                          e.preventDefault();
                          selectPacking();
                          return false;
                      }
                      $("#packingtype_sug_box").hide();
                      if (value.length > 1) {
                          //alert(value);
                          $.ajax({
                              url: "<?php echo base_url('apanel/product/getPackingtype')?>",
                              type: "POST",
                              data: {
                                  'ptype_name': value
                              },
                              success: function (data) {
                                  //alert(data);
                                  $("#packingtype_sug_box").html(data);
                                  $("#packingtype_sug_box").show();
                              }
                          })
                      }
                  });

                  $("body").on('click', '.sugg_packingtype', function () {
                      //alert('hiii');
                      var packing_type = $(this).children('a').attr('title');

                      $("#packing_type").val(packing_type);
                      $("#packingtype_sug_box").hide();

                  });

                  $("#pack_size").keyup(function (e) {
                      var value = $(this).val().trim();
                      if (e.keyCode == 40) { // down
                          var selected = $(".change_bg");
                          if (selected.next().length == 0) {
                              //selected.siblings().first().addClass("change_bg");
                          } else {
                              $("#pack_size_sug_box li").removeClass("change_bg");
                              selected.next().addClass("change_bg");
                          }
                          return false;
                      }
                      if (e.keyCode == 38) { // up
                          var selected = $(".change_bg");
                          if (selected.prev().length == 0) {
                              // selected.siblings().last().addClass("change_bg");
                          } else {
                              $("#pack_size_sug_box li").removeClass("change_bg");
                              selected.prev().addClass("change_bg");
                          }
                          return false;
                      }
                      if (e.keyCode == 13) { // down
                          e.preventDefault();
                          selectPack_size();
                          return false;
                      }
                      $("#pack_size_sug_box").hide();
                      if (value.length > 1) {
                          //alert(value);
                          $.ajax({
                              url: "<?php echo base_url('apanel/product/getPackSize')?>",
                              type: "POST",
                              data: {
                                  'packS_name': value
                              },
                              success: function (data) {
                                  //alert(data);
                                  $("#pack_size_sug_box").html(data);
                                  $("#pack_size_sug_box").show();
                              }
                          })
                      }
                  });

                  $("body").on('click', '.sugg_packsize', function () {
                      //alert('hiii');
                      var pack_size = $(this).children('a').attr('title');

                      $("#pack_size").val(pack_size);
                      $("#pack_size_sug_box").hide();

                  });
                  $("#form_p").keyup(function (e) {
                      var value = $(this).val().trim();
                      if (e.keyCode == 40) { // down
                          var selected = $(".change_bg");
                          if (selected.next().length == 0) {
                              //selected.siblings().first().addClass("change_bg");
                          } else {
                              $("#form_p_sug_box li").removeClass("change_bg");
                              selected.next().addClass("change_bg");
                          }
                          return false;
                      }
                      if (e.keyCode == 38) { // up
                          var selected = $(".change_bg");
                          if (selected.prev().length == 0) {
                              // selected.siblings().last().addClass("change_bg");
                          } else {
                              $("#form_p_sug_box li").removeClass("change_bg");
                              selected.prev().addClass("change_bg");
                          }
                          return false;
                      }
                      if (e.keyCode == 13) { // down
                          e.preventDefault();
                          selectForm();
                          return false;
                      }

                      $("#form_p_sug_box").hide();
                      if (value.length > 1) {
                          // alert(value);
                          $.ajax({
                              url: "<?php echo base_url('apanel/product/getForm')?>",
                              type: "POST",
                              data: {
                                  'form_name': value
                              },
                              success: function (data) {
                                  //alert(data);
                                  $("#form_p_sug_box").html(data);
                                  $("#form_p_sug_box").show();
                              }
                          })
                      }
                  });

                  $("body").on('click', '.sugg_form_p', function () {
                      //alert('hiii');
                      var form_p = $(this).children('a').attr('title');

                      $("#form_p").val(form_p);
                      $("#form_p_sug_box").hide();

                  });
              </script>
              <script type="text/javascript">
                  $('#product_name').on('blur', function () {
                      var product_name = this.value;
                      var form_name = $('#form_p').val();
                      // alert(form_name);
                      // return false;
                      $.ajax({
                          type: "POST",
                          url: '<?php echo base_url();?>apanel/product/check_product_and_form_combination',
                          data: {
                              Product_Name: product_name,
                              Form_Name: form_name,
                          },
                          cache: false,
                          async: false,
                          success: function (response) {
                              // alert(response);
                              if (response == 'false') {
                                  // alert("already exist");
                                  $('#form_product_error').html(
                                      'This Product with this Form  Name Already Exist ');
                              } else {
                                  $('#form_product_error').html('');
                              }
                              // return false;
                              //write here any code needed for handling success         
                          },
                      });
                  });
              </script>
              <script type="text/javascript">
                  $('#form_p').on('blur', function () {
                      var form_name = this.value;
                      var product_name = $('#product_name').val();
                      // alert(form_name);
                      // return false;
                      $.ajax({
                          type: "POST",
                          url: '<?php echo base_url();?>apanel/product/check_product_and_form_combination',
                          data: {
                              Product_Name: product_name,
                              Form_Name: form_name,
                          },
                          cache: false,
                          async: false,
                          success: function (response) {
                              // alert(response);
                              if (response == 'false') {
                                  // alert("already exist");
                                  $('#form_error').html(
                                      'This Product with this Form  Name Already Exist ');
                              } else {
                                  $('#form_error').html('');
                              }
                              // return false;
                              //write here any code needed for handling success         
                          },
                      });
                  });
              </script>
              <script type="text/javascript">
                  // $('#form_error').html('');
                  $('#form_p').on('keyup', function () {
                      if ($(this).val().length == 0) {
                          // alert('length zero');
                          $('#form_error').html('');
                          $("#form_p_sug_box").hide();
                      }
                  });
                  $('#product_name').on('keyup', function () {
                      if ($(this).val().length == 0) {
                          $('#form_product_error').html('');

                      }
                  });
                  $('#company_name').on('keyup', function () {
                      if ($(this).val().length == 0) {
                          $('#company_sug_box').html('');

                      }
                  });
                  $('#packing_type').on('keyup', function () {
                      if ($(this).val().length == 0) {
                          $('#packingtype_sug_box').html('');

                      }
                  });
                  $('#schedule').on('keyup', function () {
                      if ($(this).val().length == 0) {
                          $('#schedule_sug_box').html('');

                      }
                  });
                  $('#pack_size').on('keyup', function () {
                      if ($(this).val().length == 0) {
                          $('#pack_size_sug_box').html('');

                      }
                  });

                  $('#addProduct').on('keyup keypress', function (e) {
                      var keyCode = e.keyCode || e.which;
                      if (keyCode === 13) {
                          e.preventDefault();
                          return false;
                      }
                  });
              </script>

              <style>
                  #form_product_error {
                      color: red;

                  }

                  #form_error {
                      color: red;
                  }
              </style>


              <script type="text/javascript">
                  $("#company_sug_box li").mouseover(function () {
                      $("#company_sug_box li").removeClass("change_bg");
                      $(this).addClass("change_bg");
                  }).click(function () {

                      selectOption();
                  });

                  function selectCompany() {
                      $("#company_name").val($("#company_sug_box .change_bg").children('a').attr('title'));
                      $("#company_sug_box").hide();
                  }
                  //==end company====
                  $("#form_p_sug_box li").mouseover(function () {
                      $("#form_p_sug_box li").removeClass("change_bg");
                      $(this).addClass("change_bg");
                  }).click(function () {

                      selectForm();
                  });

                  function selectForm() {
                      $("#form_p").val($("#form_p_sug_box .change_bg").children('a').attr('title'));
                      $("#form_p_sug_box").hide();
                  }
                  //==end form==== 
                  $("#schedule_sug_box li").mouseover(function () {
                      $("#schedule_sug_box li").removeClass("change_bg");
                      $(this).addClass("change_bg");
                  }).click(function () {

                      selectSchedule();
                  });

                  function selectSchedule() {
                      $("#schedule").val($("#schedule_sug_box .change_bg").children('a').attr('title'));
                      $("#schedule_sug_box").hide();
                  }
                  //==end schedule====  
                  $("#packingtype_sug_box li").mouseover(function () {
                      $("#packingtype_sug_box li").removeClass("change_bg");
                      $(this).addClass("change_bg");
                  }).click(function () {

                      selectPacking();
                  });

                  function selectPacking() {
                      $("#packing_type").val($("#packingtype_sug_box .change_bg").children('a').attr('title'));
                      $("#packingtype_sug_box").hide();
                  }
                  //==end packing type====     
                  $("#pack_size_sug_box li").mouseover(function () {
                      $("#pack_size_sug_box li").removeClass("change_bg");
                      $(this).addClass("change_bg");
                  }).click(function () {

                      selectPack_size();
                  });

                  function selectPack_size() {
                      $("#pack_size").val($("#pack_size_sug_box .change_bg").children('a').attr('title'));
                      $("#pack_size_sug_box").hide();
                  }
                  //==end pack size====     
              </script>