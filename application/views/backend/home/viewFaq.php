<section class="wrapper">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Details</h4>
</div>

<div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <!-- <header class="panel-heading">
                Profile
            </header> -->

            <div class="panel-body">
                <form class="form-horizontal adminex-form" method="POST" name="myForm" id="myForm" action="" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Question: </label>
                        <div class="col-sm-5">

                            <div class="marginB15"> <?php echo $rec['question']; ?> </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label">Answer: </label>
                        <div class="col-sm-5">

                            <div class="marginB15"> <?php echo $rec['answer']; ?> </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        
        </div>
        </div>

</section>

