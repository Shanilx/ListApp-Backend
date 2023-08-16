    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo" style="padding-left: 40px;">
            <a href="<?php echo base_url(); ?>apanel/dashboard"><img src="<?php echo base_url(); ?>images/logo.png" alt="LA" style="width:80px;"></a>
            <!-- <h3 style="text-align: center;margin:0px;color: #fff;font-size:30px">ListApp</h3> -->
            <!-- <h3 style="text-align: center;margin-top: 30px;color: #fff;font-size:30px">ListApp</h3> -->
        </div>

        <div class="logo-icon text-center">
             <a href="<?php echo base_url(); ?>apanel/dashboard"><img src="<?php echo base_url(); ?>images/logo.png" style="width:40px; height:40px;" alt="LA"></a> 
           
        </div>
        <!--logo and iconic logo end-->

        <div class="left-side-inner">

            <!-- visible to small devices only -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <!-- <div class="media logged-user">
                    <img alt="" src="<?php echo base_url(); ?>images/photos/user-avatar.png" class="media-object">
                    <div class="media-body">
                        <h4><a href="#">John Doe</a></h4>
                        <span>"Hello There..."</span>
                    </div>
                </div> -->

                <h5 class="left-nav-title">Account Information</h5>
                <ul class="nav nav-pills nav-stacked custom-nav">
                  <li><a href="#"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                  <li><a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
                  <li><a href="#"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
                </ul>
            </div>

            <?php
            //uri segment for active class
            $con = $this->uri->segment(2);
            $met = $this->uri->segment(3);
            ?>
            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav" style="margin-top: 89px;">

                <li <?php if($con=='dashboard') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/dashboard'?>"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                <li <?php if($con=='Company') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/Company'?>"><i class="fa fa-building-o"></i><span>Manage Basic Information</span></a></li>
                <li <?php if($con=='product') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/product/1'?>"><i class="fa fa-align-justify"></i> <span>Manage Product</span></a></li>
                <li <?php if($con=='Supplier') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/Supplier'?>"><i class="fa fa-users"></i> <span>Manage Supplier</span></a></li>
                <li <?php if($con=='Retailer') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/Retailer'?>"><i class="fa fa-users"></i> <span>Manage Retailer</span></a></li>
                <li <?php if($con=='Notification') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/Notification'?>"><i class="fa fa-bell-o"></i> <span>Manage Notification</span></a></li>
                 <li <?php if($con=='Log-data') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/Log-data'?>"><i class="fa fa-edit"></i> <span>Manage Logs</span></a></li>
                 <li <?php if($con=='app-search') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/app-search/product'?>"><i class="fa fa-search-plus"></i> <span>Manage App Search</span></a></li>
                 <li <?php if($con=='post') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/post'?>"><i class="fa fa-buysellads"></i> <span>Manage Sell Post</span></a></li> 
                  <li <?php if($con=='hiring-post') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/hiring-post'?>"><i class="fa fa-envelope-open"></i> <span>Manage Hiring Post</span></a></li>
                  <li <?php if($con=='login-history') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/login-history/today'?>"><i class="fa fa-history"></i> <span>Manage App History</span></a></li>

                  <li <?php if($con=='city-search') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'apanel/city-search/city-list'?>"><i class="fa fa-map-marker"></i> <span>Manage City Search</span></a></li>
            </ul>
            <!--sidebar nav end-->

        </div>
    </div>
    <!-- left side end-->