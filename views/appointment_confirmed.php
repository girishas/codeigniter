<!DOCTYPE html>
<html lang="en">
  <head>
    <!--- Basic Page Needs  -->
    <meta charset="utf-8">
    <title>Booking in time</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Meta  -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/fonts/raleway.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/fonts/roboto.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/fonts/workSans.css');?>">
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/icofont.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/jquery-ui.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/nivo-slider.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/owl.carousel.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/animate.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/jquery.fancybox.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/meanmenu.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/typography.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/style.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/responsive.css');?>">
    <!-- Favicon -->
    <link rel="shortcut icon"  type="image/png" href="<?php echo base_url('global/frontend/css/icons/favicon.ico');?>">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--  [if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif] -->
    <style type="text/css">
      .thank-outer{
        width: 100%;
        padding: 50px;
        box-shadow: 0 0 3px #333;
      }
    </style>
  </head>
  <body class="home2-body">
    <div id="preloader"></div>
    
    
    
    <!-- blog-hero-start -->
    <div class="blog" style="height:90px; background-color:#e0e0e0; opaque:0.5%;"> <!-- h2-header-start -->
    <?php $this->load->view('elements/header'); ?>
  </div>
  <!-- blog-hero-end -->
  
  <!-- contact-area-start -->
  <div class="contact-area" style="height: 510px;">
    <div class="container">
      <div class="row">
        
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div class="thank-outer">
                <div class="alert alert-success">
                    <h4>Your appointment has been confirmed successfully.</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
        </div>
      </div>
    </div>
  </div>
  <?php $this->load->view('elements/footer'); ?>
  
  <!-- Scripts -->
  <script src="<?php echo base_url('global/frontend/js/jquery-3.2.0.min.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/jquery-ui.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/owl.carousel.min.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/jquery.nivo.slider.pack.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/jquery.counterup.min.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/countdown.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/jquery.fancybox.min.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/jquery.meanmenu.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/jquery.scrollUp.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/jquery.mixitup.min.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/jquery.waypoints.min.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/jquery.scrollTo.min.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/bootstrap.min.js');?>"></script>
  <script src="<?php echo base_url('global/frontend/js/theme.js');?>"></script>
</body>
</html>