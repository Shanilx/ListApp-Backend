<style type="text/css">
    .alert_new {
        display: none;
    }

    .progress,
    .alert {
        margin: 15px;
    }

    .alert {
        display: none;
    }

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

<div class="wrapper">
    <div class="alert alert-block fade in">
        <!-- Flash messages content here -->
    </div>

    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb panel">
                    <li><a href="<?php echo base_url().'apanel/dashboard'?>"><i class="fa fa-home"></i> Dashboard</a>
                    </li>
                    <li><a href="<?php echo base_url().'apanel/Supplier'?>">Manage Supplier</a></li>
                    <li>Bulk Products Upload </li>
                </ul>

                <section class="panel">
                    <header class="panel-heading">
                        Bulk Upload
                        <div class="upload-btn-wrapper">
                            <a href="<?php echo base_url('uploads');?>/xlsx_sample_file/sample_bulk_prodocts.xlsx"
                                style="padding: 0px;float:right;">
                                <button class="btn btn-success" type="button" download>Download Sample File</button>
                            </a>
                        </div>
                    </header>

                    <div class="panel-body">
                        <div class="form">
                            <form class="cmxform form-horizontal adminex-form" id="upload_csv_form" method="post"
                                action="<?php echo base_url().'apanel/Supplier/upload_bulk_product'?>"
                                name="upload_csv_form" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $SupplierId; ?>">

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Upload XLSX File<span
                                            class="require_class">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="upload-btn-wrapper">
                                            <button class="btn-upload">Select File</button>
                                            <input type="file" name="csv_file" id="csv_file" class="filenam" />
                                        </div>
                                        <br><span>Note: Please use Sample XLSX file for Bulk Product Upload</span>
                                        <p class="text-danger" id="valid_file"></p> <!-- Dynamic error message -->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-5">
                                        <p id="loder_upload" style="display:none;margin-left: 194px;">
                                            <i
                                                class='fa fa-spinner fa-pulse fa-3x fa-fw'></i><br><span>Uploading...</span>
                                        </p>
                                        <div id="output">
                                            <!-- error or success results -->
                                        </div>
                                        <div class="alert alert-success" role="alert">Loading completed!</div>
                                        <input name="submit" type="submit" value="Upload"
                                            class="btn btn-primary upload_csv_btn" id="csv" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Products that were not found</h3>
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
                                        <th>Action </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($dataWithFull as $index => $item): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $item['product_name']; ?></td>
                                        <td><?php echo $item['company_name']; ?></td>
                                        <td>
                                            <!-- Button to open the modal -->
                                            <button class="btn btn-link open-modal-btn" data-toggle="modal"
                                                data-target="#productModal" data-id="<?php echo $item['id']; ?>">
                                                Open Modal
                                            </button>
                                            <a href="<?php echo base_url('apanel/Supplier/Product/' . $item['id']); ?>">
                                                <button type="button" class="btn btn-success">
                                                    <i class="fa fa-plus"></i> Add Product
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                            <div class="modal fade" id="productModal" tabindex="-1" role="dialog"
                                aria-labelledby="productModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Replace with the content you want to display -->
                                            <p id="modal-content"></p>
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

<!-- body wrapper end -->
<script>
    $(document).ready(function () {
        $('#productModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id'); // Use the correct data attribute name 'data-id'

            // Here, you can make an AJAX request to fetch more information
            // based on the id, then populate the modal content
            // Example:
            // $.ajax({
            //     url: 'your_endpoint_url',
            //     method: 'GET',
            //     data: { id: id },
            //     success: function(response) {
            //         $('#modal-content').html(response);
            //     }
            // });

            // For demonstration purposes, we'll just populate a sample message
            var modal = $(this);
            modal.find('.modal-body #modal-content').text('ID: ' +
                id); // Use the correct variable name 'id'
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
                $("#loder_upload").hide();

                console.log(res); // Log the response to the browser console

                if (res != '') {
                    setTimeout(function () {
                        window.location.href = "<?php echo base_url();?>apanel/Supplier";
                    }, 1000);
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