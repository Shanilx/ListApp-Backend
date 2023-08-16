<script src="<?php echo base_url(); ?>js/bootstrap_formvalidation.js"></script>

<script src="<?php echo base_url(); ?>js/front-validation-init.js"></script>



<footer>

        <div class="container">

            <div class="col-md-2 col-sm-3">

                <div class="footer_logo">

                    <a href="<?php echo base_url(); ?>front/home" ><img src="<?php echo base_url().$this->config->item('front_images'); ?>/footerlogo.png" alt="logo" class="img-responsive"></a>

                </div>

            </div>

            <div class="col-md-5 col-sm-4">

                <div class="footer_links">

                    <ul>

                        <li><a href="<?php echo base_url(); ?>front/home">Home</a></li>

                        <li><a href="<?php echo base_url(); ?>front/page/AboutUs">About Us</a></li>

                        <li><a href="<?php echo base_url(); ?>front/page/HowItWorks">How It Works</a></li>

                        <!-- <li><a href="<?php echo base_url(); ?>doctor">Our Doctors</a></li> -->

                        <li><a href="<?php echo base_url(); ?>front/faq">FAQs</a></li>

                        <li><a href="<?php echo base_url(); ?>user/feedback">Feedback</a></li>

                    </ul>

                </div>

            </div>

            <div class="col-md-5 col-sm-5">

                <div class="footer_contact">

                    <h2>Contact Details</h2>

                    <ul>

                        <li><a href="tel:0755123456">(07) 5512 3456</a></li>

                        <li><a href="#">1234/56 Lorem ipsum dolor sit<br> 

Consectetur, QLD 4000</a></li>

                        <li><a href="mailto:lorem@ipsum.com.au">lorem@ipsum.com.au</a></li>

                    </ul>

                </div>

            </div>

        </div>

        

    </footer>

    <div class="copy_sec">

        <div class="container">

        <p><span>Copyright © <?php echo date('Y'); ?> LIST APP</span><a href="<?php echo base_url(); ?>front/page/PrivacyPolicy">Privacy Policy</a> <a>|</a><a href="<?php echo base_url(); ?>front/page/Termsnconditions">Terms & Conditions</a></p>

        </div>

    </div>

    <script type="text/javascript">

//         var $video  = $('video'),

//     $window = $(window); 



// $(window).resize(function(){

//     var height = $window.height();

//     $video.css('height', height);



//     var videoWidth = $video.width(),

//         windowWidth = $window.width(),

//     marginLeftAdjust =   (windowWidth - videoWidth) / 2;



//     $video.css({

//         'height': height, 

//         'marginLeft' : marginLeftAdjust

//     });

// }).resize();

    </script>

</body>

<script type="text/javascript">
    // 
var ajax_call = function() {
    get_noti();
};

var interval = 1000 * 60 * 1; // where X is your every X minutes

setInterval(ajax_call, interval);

function get_noti()
{ 
    var cur_time = '<?php echo date("Y-m-d"); ?>';
    var url = '<?php echo base_url() ?>doctor/get_noti';
    $.ajax({
        type: "POST", 
        url: url,
        data: {app_id:0},
        success: function(resp) {
            $('.not_number').text(resp);
        }
    });
}
</script>

<!-- ..................Notification Modal............. -->
<div class="modal fade" id="notificationModal" role="dialog">
    <div class="modal-dialog">    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Notifications</h4>
            </div>
            <div class="modal-body">
                <p>test not 1</p>
                <p>test not 2</p>
                <p>test not 3</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
      </div>
    </div>
</div>
<!-- ..................Notification Modal............. -->

</html>