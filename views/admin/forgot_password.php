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
        <link rel="stylesheet" href="<?php echo base_url('assets/examples/css/pages/login-v3.css');?>">
    
    
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
  <body class="animsition page-login-v3 layout-full">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


    <!-- Page -->
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
      <div class="page-content vertical-align-middle">
        <div class="panel">
          <div class="panel-body">
            <div class="brand">
              <img class="brand-img" src="<?php echo base_url('assets/images/logo.png');?>" alt="..." width="90%">
              <h2 class="brand-text font-size-18">Reset Password</h2>
            </div>
           	<div class="fl_left" style="width:100%;color:#008DBD;">
				<?php if($this->session->flashdata('success_msg')) {
							echo $this->session->flashdata('success_msg');
              ?>
            </div>
              <div class="fl_left" style="width:100%;color:red;">
				<?php }else if($this->session->flashdata('error_msg')) {
							echo $this->session->flashdata('error_msg');
				}
				?>
      </div>
				
			<form method="post" action="" autocomplete="off">
          <input type="hidden" name="action" value="save">
              <div class="form-group form-material floating" data-plugin="formMaterial">
                <input required="required" type="email" class="form-control" name="email" id="email" />
				<div class="error"> <?php echo form_error('email'); ?> </div>
                <label class="floating-label">Email</label>
              </div>
              <button type="submit" class="btn btn-primary btn-block btn-lg mt-40">Send New Password</button><br><br>
              <a href="<?php echo base_url('/admin'); ?>" style="float: right;">Login Instead!</a>
            </form>
            <!-- <p>Still no account? Please go to <a href="javascript:void(0);">Sign up</a></p> -->
          </div>
        </div>

        <footer class="page-copyright page-copyright-inverse">
          <p>© 2018 Bookinintime.com</p>
          <!-- <div class="social">
            <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-twitter" aria-hidden="true"></i>
          </a>
            <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-facebook" aria-hidden="true"></i>
          </a>
            <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-google-plus" aria-hidden="true"></i>
          </a>
          </div> -->
        </footer>
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
