 <!--body wrapper start-->
        <div class="wrapper" style="min-height:554px;">
            <div class="row states-info">
           
           
                
           
            <div class="col-md-12">
                
            
                <div class="panel green-bg">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                    <!--statistics start-->
                     <div class="row state-overview">
                         <div class="col-md-4 col-xs-12 col-sm-6">
                        <a href="<?php echo base_url().'apanel/Company'?>" style="color: #fff;">
                            <div class="panel blue">
                                <div class="symbol">
                                    <i class="fa fa-money"></i>
                                </div>
                                <div class="state-value">
                                    <div class="value"><?php echo $company; ?></div>
                                    <div class="title">Active Company</div>
                                </div>
                            </div>
                        </div>
                     
                        <div class="col-md-4 col-xs-12 col-sm-6">
                        <a href="<?php echo base_url().'apanel/product/1'?>" style="color: #fff;">
                            <div class="panel purple">
                                <div class="symbol">
                                    <i class="fa fa-plus"></i>
                                </div>
                                <div class="state-value">
                                   <div class="value"><?php echo $product; ?></div>
                                    <div class="title">Active Product</div>
                                </div>
                            </div>
                         </a>   
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-6">
                        <a href="<?php echo base_url().'apanel/Supplier'?>" style="color: #fff;">
                            <div class="panel red">
                                <div class="symbol">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="state-value">
                                    <div class="value"><?php echo $supplier; ?></div>
                                    <div class="title">Active Suppliers</div>
                                </div>
                            </div>
                         </a>   
                        </div>
                       <div class="col-md-4 col-xs-12 col-sm-6">
                        <a href="<?php echo base_url().'apanel/Retailer'?>" style="color: #fff;">
                            <div class="panel blue">
                                <div class="symbol">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="state-value">
                                    <div class="value"><?php echo $retailer; ?></div>
                                    <div class="title">Active App User (Retailer)</div>
                                </div>
                            </div>
                         </a>   
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-6">
                        <a href="<?php echo base_url().'apanel/Retailer'?>" style="color: #fff;">
                            <div class="panel purple">
                                <div class="symbol">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="state-value">
                                    <div class="value"><?php echo $app_supplier; ?></div>
                                    <div class="title">Active App User (Supplier)</div>
                                </div>
                            </div>
                         </a>   
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-6">
                        <a href="<?php echo base_url().'apanel/Retailer'?>" style="color: #fff;">
                            <div class="panel red">
                                <div class="symbol">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="state-value">
                                    <div class="value"><?php echo $app_other; ?></div>
                                    <div class="title">Active App User (Other)</div>
                                </div>
                            </div>
                         </a>   
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-6">
                        <a href="<?php echo base_url().'apanel/Retailer'?>" style="color: #fff;">
                            <div class="panel blue">
                                <div class="symbol">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="state-value">
                                    <div class="value"><?php echo ($app_company)?$app_company:0; ?></div>
                                    <div class="title">Active App User (Company)</div>
                                </div>
                            </div>
                         </a>   
                        </div>

                   
                     <!-- <div class="row state-overview"> -->
                       
                        
                    <!--statistics end-->
                <!-- </div> -->
                </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

            



                

            
        </div>
        <!--body wrapper end-->