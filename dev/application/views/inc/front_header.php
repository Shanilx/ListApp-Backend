<?php //print_r($manage_pages);die; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">



<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?php echo $title; ?></title>

    <link rel="shortcut icon" type="image/png" href="LA"/>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <link href="<?php echo base_url(); ?>css/front/bootstrap/bootstrap.min.css" rel="stylesheet" />

    <link href="<?php echo base_url(); ?>css/front/font-awesome.css" rel="stylesheet" />

    <link href="<?php echo base_url(); ?>css/front/responsive-calendar.css" rel="stylesheet">

    <!-- owl css -->

    <link rel="stylesheet" href="<?php echo base_url(); ?>css/front/owl.carousel.min.css">

    <link href="<?php echo base_url(); ?>css/front/style.css" rel="stylesheet" />

    

    <script src="<?php echo base_url(); ?>js/front/jquery.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>js/jquery/jquery-ui.js"></script>

    <script src="<?php echo base_url();?>js/jquery/jquery.validate.min.js"></script>

    <script src="<?php echo base_url();?>js/jquery/additional-methods.min.js"></script>



   <!-- datepicker addon files -->

  <!-- <script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-timepicker-addon.js"></script>

  <link href="<?php echo base_url();?>css/jquery-ui-timepicker-addon.css" rel="stylesheet" /> -->



  <script type="text/javascript" src="<?php echo base_url();?>js/jquery.timepicker.js"></script>

  <link href="<?php echo base_url();?>css/jquery.timepicker.css" rel="stylesheet" />

  

  <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/dash.css" rel="stylesheet">


  <!-- <link href="<?php echo base_url(); ?>css/front/chat/dashboard.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/front/chat/dialogs.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/front/chat/login.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/front/chat/main.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/front/chat/style.css" rel="stylesheet"> -->



  <script src="<?php echo base_url(); ?>js/front/bootstrap.min.js" type="text/javascript"></script>

  <script src="<?php echo base_url(); ?>js/fusioncharts.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>js/themes/fusioncharts.theme.ocean.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>js/themes/fusioncharts.theme.carbon.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>js/themes/fusioncharts.theme.fint.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>js/themes/fusioncharts.theme.zune.js" type="text/javascript"></script>



  <script src="<?php echo base_url(); ?>js/front/main.js" type="text/javascript"></script>

  <script src="<?php echo base_url(); ?>js/front/responsive-calendar.js"></script>\

  
  


  <script type="text/javascript">

    $(document).ready(function() {

        $(".responsive-calendar").responsiveCalendar({

            time: '2013-05',

            events: {

                "2013-04-30": {

                    "number": 5,

                    "url": "http://w3widgets.com/responsive-slider"

                },

                "2013-04-26": {

                    "number": 1,

                    "url": "http://w3widgets.com"

                },

                "2013-05-03": {

                    "number": 1

                },

                "2013-06-12": {}

            }

        });

    });

  </script>

 </head>



<body>

    <div class="main_container">

        <!--background texture-->

        <header>

            <!--nav section start-->

            <nav class="navbar navbar-default" role="navigation">

                <div class="container-fluid">

                    <!-- Brand and toggle get grouped for better mobile display -->

                    <div class="navbar-header">

                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>

                        <a class="navbar-brand" href="<?php echo base_url(); ?>front/home"><img src="<?php echo base_url().$this->config->item('front_images'); ?>/logo.png" alt="logo" /></a>

                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                        <ul class="nav navbar-nav">

                        <?php $uri_1 = $this->uri->segment(1); $uri_2 = $this->uri->segment(2); $uri_3 = $this->uri->segment(3); ?>

                            <!-- <li <?php if($uri_2 == 'home') { echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>front/home">Home</a></li>

                            <li <?php if($uri_3 == 'AboutUs') { echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>front/page/AboutUs">About Us</a></li>

                            <li <?php if($uri_2 == 'browse_doctors') { echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>front/browse_doctors">Browse Doctors</a></li>

                            <li <?php if($uri_2 == 'news' || $uri_2 == 'news_detail') { echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>front/news">In the News</a></li>

                            <li <?php if($uri_3 == 'HowItWorks') { echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>front/page/HowItWorks">How It Works</a></li>

                            <li <?php if($uri_2 == 'faq') { echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>front/faq">FAQs</a></li> -->
                      <!-- add dynamic pages -->
                          <li <?php if($uri_2 == 'home') { echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>front/home">Home</a></li>

                           <li <?php if($uri_2 == 'browse_doctors') { echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>front/browse_doctors">Browse Doctors</a></li>

                            <li <?php if($uri_2 == 'news' || $uri_2 == 'news_detail') { echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>front/news">In the News</a></li>

                            <li <?php if($uri_2 == 'resources' || $uri_2 == 'resources_detail') { echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>front/resources">Resources</a></li>

                             

                       <?php  if(!empty($manage_pages))
                       {
                            foreach ($manage_pages as $key_ca => $value_ca) 

                            {
                           
                          
                             ?> 
                                 <li><a href="<?php echo base_url()?>front/page/<?php echo $value_ca['page_name']; ?>"><?php echo $value_ca['page_name']; ?></a></li>

                               <?php
                            }

                       } ?>
                       <li <?php if($uri_2 == 'faq') { echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?>front/faq">FAQs</a></li>
                      <!-- add dynamic pages -->

                        </ul>

                        <ul class="nav navbar-nav navbar-right">

                            <li><a href="callto:9871234567">Helpline : <span class="header_con">1-800-652-5580</span></a></li>

                            <?php $uri_2 = $this->uri->segment(2);

                            if($this->session->userdata('user_id')!='')

                            {

                                if($this->session->userdata('member_role')==2)   //doctor

                                {

                                    $profile_url = 'doctor/profile';

                                }

                                elseif($this->session->userdata('member_role')==3)  //patient

                                {

                                    $profile_url = 'patient/profile';

                                }

                                ?>

                                <li <?php if($uri_2 == 'profile' || $uri_2 == 'doctor_dashboard') { echo 'class="active"'; } ?>><a href="<?php echo base_url().''.$profile_url; ?>">| Dashboard</a></li>

                                <li><a href="<?php echo base_url().'user/logout'; ?>">| Logout</a></li>
                                <li><a href="javascript:void(0)" data-toggle="modal" data-target="#notificationModal" class="notify_box">
                                <i fa class="fa fa-bell"></i><span>22</span></a></li> 

                                <?php

                            }

                            else

                            {

                                if($uri_2=='signinas' || $uri_2=='signin')

                                {

                                    echo '<li><a href="'.base_url().'user/signupas">| Sign Up</a></li>';

                                }

                                else/*if($uri_2=='signupas' || $uri_2=='signup')*/

                                {

                                    echo '<li><a href="'.base_url().'user/signinas">| Sign In</a></li>';

                                } 

                            }

                            

                            ?>

                            

                        </ul>

                    </div>

                    <!-- /.navbar-collapse -->

                </div>

                <!-- /.container-fluid -->

            </nav>

            <!--nav section end-->

        </header>



         <?php

            // echo date_default_timezone_get();

            // echo date('d-m-Y h:i:s');

            // // echo ini_get('date.timezone');

          // echo "<pre>";

          $info = $_SERVER;

          // print_r($info);

          $st = $info['REQUEST_TIME'] ;//  a timestamp 

          // $dt = date('d-m-Y',$st);

          // echo $dt;

        ?>

        <input type="hidden" id="cur_time" value="<?php echo date("Y-m-d H:i:s",$st); ?>">

        <!-- .............Quickblox chat sessions.............. -->

        <input type="hidden" name="qb_id" id="chat_qb_id" value="<?php echo $this->session->userdata('qb_id');?>">
        <input type="hidden" name="qb_login" id="chat_qb_login" value="<?php echo $this->session->userdata('qb_login'); ?>">

        <input type="hidden" name="qb_password" id="chat_qb_password" value="<?php echo $this->session->userdata('qb_password'); ?>">

        <input type="hidden" name="full_name" id="chat_full_name" value="<?php echo $this->session->userdata('member_name'); ?>">
        <!-- .............Quickblox chat sessions.............. -->
