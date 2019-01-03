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
</head>

<body class="home2-body">
    <div id="preloader"></div>
   
    
    
    <!-- blog-hero-start -->
    <div class="blog" style="height:90px; background-color:#2C2C2A; opaque:0.5%;"> <!-- h2-header-start -->
	<?php $this->load->view('elements/header'); ?> 
    </div>
    <!-- blog-hero-end -->
	
	<!-- contact-area-start -->
    <div class="contact-area">
        <div class="container">
            <div class="row">
			
				<div class="col-md-3">
                </div>
                <div class="col-md-6">
				<!-- Alert message part -->
	 <?php $this->load->view('admin/common/header_messages'); ?>
	<!-- End alert message part -->
	
                    <div class="contact-form-area">
                        <center><h4 class="contact-title2">Sign up your business today for 15 days free trial</h4></center>
                        <div class="contact-form">
                            <div class="cf-msg"></div>
                            <form autocomplete="off" method="post"  action="<?php echo base_url('sign_up'); ?>" enctype="multipart/form-data">
							<input type="hidden" name="action" value="save"> 

							
							 <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Email*</label>
                      <input type="text" name="email" id="email" class="form-control" value="<?php if(isset($email)) { echo $email; } ?>" >
                      <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Password*</label>
                      <input type="password" name="passwd" id="passwd" class="form-control"  />
                      <div class="admin_content_error"><?php echo form_error('passwd'); ?></div>
                    </div>
                  </div>
							
							
					 <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Business Name*</label>
                      <input type="text" name="name" id="name" class="form-control" value="<?php if(isset($name)) { echo $name; } ?>" >
                       <div class="admin_content_error"><?php echo form_error('name'); ?></div>
                    </div>
                    
                  </div>		
							
					 <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Phone Number</label>
                      <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php if(isset($phone_number)) { echo $phone_number; } ?>" />
                    </div>
                   <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Website</label>
                      <input type="text" class="form-control" id="website" name="website" value="<?php if(isset($website)) { echo $website; } ?>" />
                    </div>
                  </div>		
							
					 <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Owner First Name*</label>
                      <input type="text" class="form-control" id="owner_first_name" name="owner_first_name" value="<?php if(isset($owner_first_name)) { echo $owner_first_name; } ?>" >
                      <div class="admin_content_error"><?php echo form_error('owner_first_name'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Owner Last Name</label>
                      <input type="text" class="form-control" id="owner_last_name" name="owner_last_name" value="<?php if(isset($owner_last_name)) { echo $owner_last_name; } ?>" />
                    </div>
                  </div>
<div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Street/area*</label>
                      <input type="text" name="address1" id="address1" class="form-control" value="<?php if(isset($address1)) { echo $address1; } ?>" >
                      <div class="admin_content_error"><?php echo form_error('address1'); ?></div>
                    </div>
                    <div class="col-md-6">
                       <label class="form-control-label" for="inputGrid2">City*</label>
                      <input type="text" name="city" id="city" class="form-control" value="<?php if(isset($city)) { echo $city; } ?>"  maxlength="100"  />
                      <div class="admin_content_error"><?php echo form_error('city'); ?></div>
                    </div>
                  </div>
 <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">State</label>
                      <input type="text" name="state" id="state" class="form-control" value="<?php if(isset($state)) { echo $state; } ?>"  maxlength="100">
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Post Code</label>
                      <input type="text" name="post_code" id="post_code" class="form-control" value="<?php if(isset($post_code)) { echo $post_code; } ?>" >
                    </div>
                  </div>				  
					 <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Description</label>
                      <textarea class="form-control" name="description" id="description" value="<?php if(isset($description)) { echo $description; } ?>"  rows="3"></textarea>
                    </div>
                    
                  </div>		
                                <div class="row"> 
                                    <p class="col-md-12 cf-input-box cf-ib-submit">
                                        <input id="submit" class="cont-submit btn-contact" name="submit" type="submit" value="Submit">
                                    </p>
                                </div>
                            </form>
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
    <script>
        $(document).ready(function(){
            $('.home').on('click', function() {  
                $('html, body').animate({scrollTop: $(this.hash).offset().top - 50},2000);
                return false;
            });
            $('.about-us').on('click', function() {  
                $('html, body').animate({scrollTop: $(this.hash).offset().top - 170},2000);
                return false;
            });
            $('.contact').on('click', function() {  
                $('html, body').animate({scrollTop: $(this.hash).offset().top - 88},2000);
                return false;
            });
            $('.services').on('click', function() {  
                $('html, body').animate({scrollTop: $(this.hash).offset().top - 89},2000);
                return false;
            });
            $('.pricing').on('click', function() {  
                $('html, body').animate({scrollTop: $(this.hash).offset().top - 89},2000);
                return false;
            });
        });
    </script>
</body>

</html>