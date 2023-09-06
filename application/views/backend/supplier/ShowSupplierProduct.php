
<style>
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
    }

    .btn-upload {
        border: 2px solid gray;
        color: gray;
        background-color: white;
        border-radius: 8px;
        padding: 8px 20px;
        border-color: #008CBA;
        cursor: pointer;
    }

    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
    }
</style>

<div class="page-heading">
    <h3>Bulk Upload</h3>
</div>
<!-- body wrapper end -->
<div class="wrapper">

    <!-- Page Content Wrapper -->
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <!-- Breadcrumbs -->
                <ul class="breadcrumb panel">
                    <li><a href="<?php echo base_url().'apanel/dashboard'?>"><i class="fa fa-home"></i> Dashboard</a>
                    </li>
                    <li><a href="<?php echo base_url().'apanel/Supplier'?>">Manage Supplier</a></li>
                    <li>List of Supplier Products  </li>
                </ul>
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
                    
                <!-- Products Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Supplier Products List</h3>
                                <div class="pull-right">
                                    <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter"
                                        data-container="body">
                                        <i class="glyphicon glyphicon-filter"></i>
                                    </span>
                                </div>
                            </div>

                            <table class="table table-hover" id="task-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Company Name</th>
                                        <th>Drug Name</th>
                                        <th>Form</th>
                                        <th>Pack Size</th>
                                        <th>Packing Type</th>
                                        <th>MRP</th>
                                        <th>Rate</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <!-- Product Table Rows -->
                                    <?php foreach ($dataWithFull as $index => $item): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $item['product_name']; ?></td>
                                        <td><?php echo $item['company_name']; ?></td>
                                        <td><?php echo !empty($item['drug_name']) ? $item['drug_name'] : 'NULL'; ?></td>
                                        <td><?php echo !empty($item['form']) ? $item['form'] : 'NULL'; ?></td>
                                        <td><?php echo !empty($item['pack_size']) ? $item['pack_size'] : 'NULL'; ?></td>
                                        <td><?php echo !empty($item['packing_type']) ? $item['packing_type'] : 'NULL'; ?></td>
                                        <td><?php echo $item['mrp']; ?></td>
                                        <td><?php echo $item['rate']; ?></td>

                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <!-- Product Details Modal -->
                            <div class="modal fade" id="productModal" tabindex="-1" role="dialog"
                                aria-labelledby="productModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="productModalLabel">Map Existing Product</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $("#product_name").keydown(function (e) {
    var value = $(this).val().trim();
    if (e.keyCode == 40) { // down
        var selected = $(".change_bg");
        if (selected.next().length == 0) {
            // selected.siblings().first().addClass("change_bg");
        } else {
            $("#product_name_sug_box li").removeClass("change_bg");
            selected.next().addClass("change_bg");
        }
        e.preventDefault(); // Prevent the default behavior
        return false;
    }
    if (e.keyCode == 38) { // up
        var selected = $(".change_bg");
        $("#product_name_sug_box li").removeClass("change_bg");
        if (selected.prev().length == 0) {
            // selected.siblings().last().addClass("change_bg");
        } else {
            selected.prev().addClass("change_bg");
        }
        e.preventDefault(); // Prevent the default behavior
        return false;
    }
    if (e.keyCode == 13) { // down
        e.preventDefault();
        selectPacking();
        return false;
    }
    $("#product_name_sug_box").hide();
    if (value.length > 1) {
        $.ajax({
            url: "<?php echo base_url('apanel/Supplier/getProduct')?>",
            type: "POST",
            data: {
                'ptype_name': value
            },
            success: function (data) {
                $("#product_name_sug_box").html(data);
                $("#product_name_sug_box").show();
            }
        });
    }
});


    $("body").on('click', '.sugg_packingtype', function () {
        var product_name = $(this).children('a').attr('title');
        $("#product_name").val(product_name);
        $("#product_name_sug_box").hide();
    });

    $(document).ready(function () {
        $('#productModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #modal-content').text('Product Name: ' + id);
            $('#synonym_product_name').val(id);
        });
    });

    // jQuery validation for the upload form
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
                extension: "Please Select Valid XLSX File and Try Again"
            },
        }
    });

    // Enable/disable upload button based on form validity
    $('#upload_csv_form input').on('keyup blur', function () {
        if ($('#upload_csv_form').valid()) {
            $('.upload_csv_btn').prop('disabled', false);
        } else {
            $('.upload_csv_btn').prop('disabled', true);
        }
    });

    // Configuration
    var result_output = '#output';
    var my_form_id = '#upload_csv_form';
    var progress_bar_id = '#progress-wrp';

    // Form submit event
    $(my_form_id).on("submit", function (event) {
        event.preventDefault();
        var proceed = true;
        var error = [];
        var total_files_size = 0;

        $(this.elements['csv_file'].files).each(function (i, ifile) {
            if (ifile.value !== "") {
                total_files_size = total_files_size + ifile.size;
            }
        });

        var submit_btn = $(this).find("input[type=submit]");

        if (proceed) {
            var form_data = new FormData(this);
            var post_url = $(this).attr("action");
            $("#loder_upload").show();

            $.ajax({
                url: post_url,
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                mimeType: "multipart/form-data"
            }).done(function (res) {

                // Parse the JSON string into a JavaScript object
                var responseObject = JSON.parse(res);
                // Now you can access the data like this
                var supplierId = responseObject.supplier_id;
                var response = responseObject.response;
                $("#loder_upload").hide();
                if (res != '') {
                    if (response == '1') {
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url();?>apanel/Supplier/AddBulkProduct/" + supplierId;

                        }, 10000000);
                    } else if (response == '2' || res == '21') {
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url();?>apanel/Supplier/AddBulkProduct/" + supplierId;
                                                }, 10000000);
                    } else if (response == '3') {
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url();?>apanel/Supplier/AddBulkProduct/" + supplierId;
                        }, 10000000);
                    } else if (response == '4') {
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url();?>apanel/Supplier/AddBulkProduct/" + supplierId;
                        }, 10000000);
                    } else {
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url();?>apanel/Supplier/AddBulkProduct/" + supplierId;
                        }, 10000000);
                    }
                } else {
                    setTimeout(function () {
                        window.location.href = "<?php echo base_url();?>apanel/Supplier/AddBulkProduct/" + supplierId;
                    }, 10000000);
                }

                $(my_form_id)[0].reset();
                submit_btn.val("Upload").prop("disabled", false);
            });
        }

        $(result_output).html("");
        $(error).each(function (i) {
            $(result_output).append('<div class="error">' + error[i] + "</div>");
        });
    });

    // Code for handling file format selection
    $('input[type=file]').change(function () {
        var val = $(this).val().toLowerCase();
        var regex = new RegExp("(.*?)\.(xls|xlsx)$");

        if (!(regex.test(val))) {
            $(this).val('');
            $('#valid_file').html('Please Select Correct File Format');
            $('#csv').prop("disabled", true);
        } else {
            $('#valid_file').html('');
            $('#csv').prop("disabled", false);
        }
    });

    // Disabling the "Upload" button initially
    $(document).ready(function () {
        $("#csv").prop("disabled", true);
    });

    // Show progress bar on button click
    $("#csv").click(function () {
        $("#progress-wrp").show();
    });
</script>