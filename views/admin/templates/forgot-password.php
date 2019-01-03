<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap material admin template">
    <meta name="author" content="">
    
    <title>Reset Password | Booking in Time</title>
    
    <link rel="apple-touch-icon" href="<?php echo base_url('assets/images/apple-touch-icon.png');?>">
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico');?>">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url('global/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/css/bootstrap-extend.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/site.min.css');?>">
    
    <!-- Plugins -->
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/animsition/animsition.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/asscrollable/asScrollable.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/switchery/switchery.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/intro-js/introjs.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/slidepanel/slidePanel.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/flag-icon-css/flag-icon.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/waves/waves.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/examples/css/pages/email.css');?>">
    
    
    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo base_url('global/fonts/material-design/material-design.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/fonts/brand-icons/brand-icons.min.css');?>">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('global/vendor/html5shiv/html5shiv.min.js');?>"></script>
    <![endif]-->
    
    <!--[if lt IE 10]>
    <script src="<?php echo base_url('global/vendor/media-match/media.match.min.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/respond/respond.min.js');?>"></script>
    <![endif]-->
    
    <!-- Scripts -->
    <script src="<?php echo base_url('global/vendor/breakpoints/breakpoints.js');?>"></script>
    <script>
      Breakpoints();
    </script>
  </head>
  <body class="animsition page-email page-email-welcome">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

 <!-- Page -->
    <div class="page">
      <div class="page-content">
        <!-- Panel -->
        <div class="panel">
          <div class="panel-body container-fluid" style="text-align: center;">
            <div class="email-title">
              <img class="brand-img" src="<?php echo base_url('assets/images/logo.png');?>" style="max-width: 600px;" alt="..." >
            </div>
            <div class="card welcome-content">
              <div class="card-block pl-40 pr-40  mt-30 mb-30">
               <h2>Hi <?php echo isset($name)?$name:""; ?></h2>
               <p>Here is your new Pas sword : <?php echo isset($password)?$password:""; ?><b></b></p>
              </div>
            </div>
            <!-- <div class="email-more">
              <p>You are currently signed up to Company’s newsletters as: youremail@gmail.com
                to <a class="email-unsubscribe" href="javascript:void(0)">unsubscribe</a></p>
              <div class="email-more-social">
                <a href="javascript:void(0)"><i class="icon bd-twitter" aria-hidden="true"></i></a>
                <a href="javascript:void(0)"><i class="icon bd-facebook" aria-hidden="true"></i></a>
                <a href="javascript:void(0)"><i class="icon bd-linkedin" aria-hidden="true"></i></a>
                <a href="javascript:void(0)"><i class="icon bd-pinterest" aria-hidden="true"></i></a>
              </div>
            </div> -->
          </div>
        </div>
        <!-- End Panel -->
      </div>
    </div>
    <!-- End Page -->

    <!-- Core  -->
    <script src="<?php echo base_url('global/vendor/babel-external-helpers/babel-external-helpers.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/popper-js/umd/popper.min.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/bootstrap/bootstrap.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/animsition/animsition.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/mousewheel/jquery.mousewheel.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/asscrollbar/jquery-asScrollbar.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/asscrollable/jquery-asScrollable.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/ashoverscroll/jquery-asHoverScroll.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/waves/waves.js');?>"></script>
    
    <!-- Plugins -->
    <script src="<?php echo base_url('global/vendor/switchery/switchery.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/intro-js/intro.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/screenfull/screenfull.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/slidepanel/jquery-slidePanel.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/jquery-placeholder/jquery.placeholder.js');?>"></script>
    
    <!-- Scripts -->
    <script src="<?php echo base_url('global/js/Component.js');?>"></script>
    <script src="<?php echo base_url('global/js/Plugin.js');?>"></script>
    <script src="<?php echo base_url('global/js/Base.js');?>"></script>
    <script src="<?php echo base_url('global/js/Config.js');?>"></script>
    
    <script src="<?php echo base_url('assets/js/Section/Menubar.js');?>"></script>
    <script src="<?php echo base_url('assets/js/Section/GridMenu.js');?>"></script>
    <script src="<?php echo base_url('assets/js/Section/Sidebar.js');?>"></script>
    <script src="<?php echo base_url('assets/js/Section/PageAside.js');?>"></script>
    <script src="<?php echo base_url('assets/js/Plugin/menu.js');?>"></script>
    
    <script src="<?php echo base_url('global/js/config/colors.js');?>"></script>
    <script src="<?php echo base_url('assets/js/config/tour.js');?>"></script>
    
    <!-- Page -->
    <script src="<?php echo base_url('assets/js/Site.js');?>"></script>
    <script src="<?php echo base_url('global/js/Plugin/asscrollable.js');?>"></script>
    <script src="<?php echo base_url('global/js/Plugin/slidepanel.js');?>"></script>
    <script src="<?php echo base_url('global/js/Plugin/switchery.js');?>"></script>
	<script src="<?php echo base_url('global/js/Plugin/jquery-placeholder.js');?>"></script>
	<script src="<?php echo base_url('global/js/Plugin/material.js');?>"></script>
    
    <script>
      (function(document, window, $){
        'use strict';
    
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);
    </script>
    
  </body>
</html>
