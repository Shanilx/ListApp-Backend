<!DOCTYPE html>
<html lang="en">
<head>  
  <title>LIST APP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  body {
    font: 400 15px Lato, sans-serif;
    line-height: 1.8;
    color: #818181;
  }
  h2 {
    font-size: 24px;
    text-transform: uppercase;
    color: #303030;
    font-weight: 600;
    margin-bottom: 30px;
  }
  h4 {
    font-size: 19px;
    line-height: 1.375em;
    color: #303030;
    font-weight: 400;
    margin-bottom: 30px;
  }  
  .jumbotron {
    background-color: #1b1635;
    color: #fff;
    /*padding: 100px 25px;*/
    font-family: Montserrat, sans-serif;
    margin-bottom: 0px;
  }
  .container-fluid {
    padding: 60px 50px;
  }
  .bg-grey {
    background-color: #f6f6f6;
  }

  .thumbnail {
    padding: 0 0 15px 0;
    border: none;
    border-radius: 0;
  }
  .thumbnail img {
    width: 100%;
    height: 100%;
    margin-bottom: 10px;
  }

  .panel {
    border: 1px solid #f4511e; 
    border-radius:0 !important;
    transition: box-shadow 0.5s;
  }
  .panel:hover {
    box-shadow: 5px 0px 40px rgba(0,0,0, .2);
  }
  .panel-footer .btn:hover {
    border: 1px solid #f4511e;
    background-color: #fff !important;
    color: #f4511e;
  }
  .panel-heading {
    color: #fff !important;
    background-color: #f4511e !important;
    padding: 25px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
  }
  .panel-footer {
    background-color: white !important;
  }
  .panel-footer h3 {
    font-size: 32px;
  }
  .panel-footer h4 {
    color: #aaa;
    font-size: 14px;
  }
  .panel-footer .btn {
    margin: 15px 0;
    background-color: #f4511e;
    color: #fff;
  }
  .bord-bottom{
   width: 100%;
   height: 29px;
   background-color: #ffc107d1;
 }
 .navbar {
  margin-bottom: 0;
  background-color: #ffc107d1;
  /*z-index: 9999;*/
  border: 0;
  font-size: 12px !important;
  line-height: 1.42857143 !important;
  letter-spacing: 4px;
  border-radius: 0;
  font-family: Montserrat, sans-serif;
}
.navbar li a, .navbar .navbar-brand {
  color: #fff !important;
}
.navbar-nav li a:hover, .navbar-nav li.active a {
  color: #f4511e !important;
  background-color: #fff !important;
}
.navbar-default .navbar-toggle {
  border-color: transparent;
  color: #fff !important;
}
footer .glyphicon {
  font-size: 20px;
  margin-bottom: 20px;
  color: #f4511e;
}
.slideanim {visibility:hidden;}
.slide {
  animation-name: slide;
  -webkit-animation-name: slide;
  animation-duration: 1s;
  -webkit-animation-duration: 1s;
  visibility: visible;
}

@media screen and (max-width: 768px) {
  .col-sm-4 {
    text-align: center;
    margin: 25px 0;
  }
  .btn-lg {
    width: 100%;
    margin-bottom: 35px;
  }
}
@media screen and (max-width: 480px) {
  .logo {
    font-size: 150px;
  }
}
@media screen and (max-width: 1024px) {
  .resp_btn {
   text-align: center;
  }
}
.row{
  background: #a499da47;
} 
fieldset legend{
      border-bottom: 1px solid #000;
}
</style>
</head>
<body id="myPage" data-spy="scroll">
  <!-- <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60"> -->
    <div class="bord-bottom">    
      <a  href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.png" width="100"></a> 
      </div>  
    <div class="jumbotron text-center">
      <h1>LISTAPP</h1> 
      <p>The New Way Of Discovering <br> Companies, Products &amp; Suppliers</p>  
    </div>
    <div class="bord-bottom"></div>
    <div class="container-fluid bg-grey">    
    <!--   <h3 style=" padding: 20px;">Welcome to ListApp</h3>   -->
      <div class="row">
        <form name="guest" class="form">
          <fieldset>
           <legend class="text-center"><h1>Welcome to ListApp</h1></legend> 
          <div class="col-sm-5">
            <div class="col-sm-9">
            <label><h4>Please Select Your Profile :</h4></label>
           </div>
           <div class="col-sm-5 form-group resp_btn">
             <a  class="btn btn-success" href="http://bit.ly/List-Company" style="margin-bottom: 5%;margin-left: 2%;">Company</a>
             <a class="btn btn-success"  href="http://bit.ly/list-supplier" style="margin-bottom: 5%;margin-left: 2%;">Supplier</a>
           </div>            
          </div>
         <div class="col-sm-5 form-group">
           <div class="text-center" style="margin-bottom:15px; margin-top:10px; padding-bottom:15px;">
            <p style="color:red; font-size:16px; font-weight:bold;">Please Click Here to Download the ListApp</p>
            <a href="https://play.google.com/store/apps/details?id=com.listapp.in&hl=en" target="_blank"> <img src="<?php echo base_url(); ?>images/logo_android.png" alt="" /> </a>
            </div>
         </div>
         </fieldset>
       </form>
     </div>
   </div>
   <!-- Container (About Section) -->
   <div id="about" class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <h2 style="margin-bottom: 20px;">About Us</h2>      
        <p>Welcome to experience Best of its kind app for Pharmacy Retailers, Suppliers & Companies<br>
          ListApp is an Android based Supplier Search app for Pharmaceutical & Healthcare Industry bringing Pharmacy Retailers and Suppliers on one platform.<br>
          At Listapp, we understand the Pharmacy retail & wholesale needs and therefore, came up with an innovative product which makes Suppliers & Company Discovery an easy routine.  This reduces the prescription drop rate and results into more Happy Customers.<br>
          Through ListApp we aspire to revolutionize the healthcare industry with more innovative offerings making complete ordering process, Easy & Automated.<br>
          For Supplier Registration, Company Registration and other queries, please mail us your product folder on <a href="mailto:support@listapp.in">support@listapp.in</a> or Call/WhatsApp us at <a href="callto:+919977773388">+919977773388</a></p>
        </div>
    <!-- <div class="col-sm-4">
      <span class="glyphicon glyphicon-signal logo"></span>
    </div> -->
  </div>
</div>
<footer class="container-fluid text-center">
  <a href="#myPage" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
  <p>2017 &copy; ListApp</p>
</footer>

<script>
  $(document).ready(function(){
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){

        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
  
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
      if (pos < winTop + 600) {
        $(this).addClass("slide");
      }
    });
  });
})
</script>

</body>
</html>
