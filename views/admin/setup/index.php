<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>  
 <!-- Page -->
    <div class="page">
      <?php $this->load->view('admin/common/header_messages'); ?>

      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
             	
			  <div class="panel-body container-fluid">
                	  <h1 class="page-title" style="margin-bottom:15px;">Setup</h1>
					 <div class="row">
					  	<?php if($admin_session['role']=="business_owner"){ ?>	
					  	<div class="form-group col-md-4">					 
								<a href="<?php echo base_url('admin/business/company_detail');?>">
									<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
									<!-- <i class="icon md-wrench" aria-hidden="true"></i> --><span class="text">Company Details</span></button></a>
								
							</div>
						<?php } ?>

						   <div class=" form-group col-md-4">
						   	<a href="<?php echo base_url('admin/user/change_password');?>">
									<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
									<!-- <i class="icon md-lock" aria-hidden="true"></i> --><span class="text">Change Password</span></button></a>
						</div>
						<?php 
						if($admin_session['role'] == 'owner' or $admin_session['role'] == 'business_owner') { ?>
						 <div class="form-group col-md-4">


					  		<a  href="<?php echo base_url('admin/business/locations');?>">
					  			<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
									<span class="text">Branches/Locations</span></button>
					  			</a>
					  	</div>
					  
						<?php } ?>
						
						
						<div class="form-group col-md-4">
							
						  <a href="<?php echo base_url('admin/resource');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="text">Company Resources</span>
						
						  </button>
						  </a>
						</div>

						  <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){?>
						  <div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/discount');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="text">Discounts</span>
						  	
						  </button>
						  </a>
						  </div>
						  <div class="form-group col-md-4">
												   
						   <a  href="<?php echo base_url('admin/service/calendar_settings');?>">
						   	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="text">Calendar Settings</span>
							</button>
						  </a>
						
					</div>
				
				
					<div class="form-group col-md-4">
							
						   	<a  href="<?php echo base_url('admin/business/taxes');?>">
						   		<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="text">Taxes</span>
							
						</button>
						</a>
					</div>

							  <!-- <a class="list-group-item" href="<?php echo base_url('admin/voucher/voucher_setting');?>">
							<span class="list-group-item-content">Voucher Code Settings</span>
							</a> -->
							
							
							<?php } ?>
							<div class="form-group col-md-4">
							
							<a  href="<?php echo base_url('admin/product/product_use_settings');?>">
								<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="text">Inventory Use Settings</span>
							
							</button>
							</a>
						</div>
							<!-- only if admin or role is owner -->
							<?php 
							if($admin_session['role'] == 'owner') { ?>
							<div class="form-group col-md-4">
							
								<a  href="<?php echo base_url('admin/emailtemplate');?>">
									<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
								<span class="text">Email Template</span>
								
							</button>
							</a>
						</div>
							<?php } ?>
						
							<!-- only if admin or role is owner -->
							
							
							<?php if($admin_session['role']=="business_owner" ){ ?>					  
						 <div class="form-group col-md-4">
							
						   <a  href="<?php echo base_url('admin/notification');?>">
						   	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="text">Dashboard Notification</span>
						
						</button>
						  </a> 
					</div>
						<?php } ?> 
						<?php if($admin_session['role']=="business_owner" ){ ?>					  
						 <div class="form-group col-md-4">
							
						   <a href="<?php echo base_url('admin/voucher/terms');?>">
						   	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="text">Voucher Terms & Conditions</span>
						  
						</button>
						</a> 
					</div>
						<?php } ?> 
						<?php if($admin_session['role'] == 'business_owner') { ?>
						<div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/service/booking_confirmation_slot');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="text">Booking Confirmation Slot</span>
							</button>
						  </a> 
						  
						  </div> 
						<?php   }?>
						<?php if($admin_session['role'] == 'business_owner') { ?>
						<div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/service/client_notification');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="text">Client Notification Templates</span>
						 
						  </button>
						   </a>
						  </div>  
						<?php }?>

						 <!--  <div class="form-group col-md-4">					  
						   <a  href="<?php echo base_url('admin/service/service_groups');?>">
						   	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">All Service Groups</span>
							</button>
						  </a> 
						</div> -->
				 		  <?php $admin_session = $this->session->userdata('admin_logged_in');
							if($admin_session['role'] == 'owner') { ?>
							<div class="form-group col-md-4">
							
						   		<a  href="<?php echo base_url('admin/business/categories');?>">
						   			<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
						   		 <span class="list-group-item-content">Business Categories</span> 
						   	</button>
						   	</a>
						   </div>
							<?php } ?>
							<?php 
							if($admin_session['role'] == 'owner') { ?>
							<div class="form-group col-md-4">
							
						  <a href="<?php echo base_url('admin/membership');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">Membership Plans</span>
						  
						</button>
						</a> 
					</div>

					<div class="form-group col-md-4">
							

						  <a  href="<?php echo base_url('admin/setting');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">Setting</span>
						 
						</button>
						 </a>
					</div>
						  <?php } ?>
						  <?php if($admin_session['role'] == 'business_owner') { ?>
						  <div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/service/active_membership');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">Active Membership</span>
						 
						  </button>
						   </a> 
						  </div> 
						  <?php } ?>


						<?php if($admin_session['role'] == 'business_owner') { ?>
						  <div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/service/free_services');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">Customer Loyality Program</span>
						 
						  </button>
						   </a> 
						  </div> 
						<?php } ?>

						<?php if($admin_session['role'] == 'business_owner' or $admin_session['role'] == 'location_owner') { ?>
						  <div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/staff/default_staff');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">Invoice</span>
						 
						  </button>
						   </a> 
						  </div> 
						<?php } ?>

						<?php if($admin_session['role'] == 'owner') { ?>
						  <div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/service/twilio_accounts/');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">Twilio SMS Accounts Settings</span>
						 
						  </button>
						   </a> 
						  </div> 
						<?php } ?>

						<?php if($admin_session['role'] == 'business_owner') { ?>
						  <div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/setup/security/');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">Security</span> 
						  </button>
						   </a> 
						  </div> 
						<?php } ?>


						<?php if($admin_session['role'] == 'business_owner') { ?>
						  <div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/product/pre_gst_settings');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">Pre Gst Settings</span> 
						  </button>
						   </a> 
						  </div> 
						<?php } ?>

						<?php if($admin_session['role'] == 'business_owner') { ?>
						  <div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/product/gst_ato_settings');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content"> Gst Ato Settings</span> 
						  </button>
						   </a> 
						  </div> 
						<?php } ?>

						<?php if($admin_session['role'] == 'business_owner' or $admin_session['role'] == 'owner') { ?>
						  <div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/business/all_warehouse');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">Warehouse</span>
						 
						  </button>
						   </a> 
						  </div> 
						<?php } ?>

					<?php /*	<!-- <?php if($admin_session['role'] == 'business_owner' or $admin_session['role'] == 'owner') { ?>
						  <div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/product/product_unit_setting');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">Product Unit Setting</span>
						 
						  </button>
						   </a> 
						  </div> 
						<?php } ?> --> */ ?>

						<?php if($admin_session['role'] == 'business_owner' or $admin_session['role'] == 'owner') { ?>
						  <div class="form-group col-md-4">
							
						  <a  href="<?php echo base_url('admin/product/product_weight_scale_setting');?>">
						  	<button type="button" class="btn btn-block btn-info waves-effect waves-classic">
							<span class="list-group-item-content">Product Weight Scale Setting</span>
						 
						  </button>
						   </a> 
						  </div> 
						<?php } ?>


						




					  </div>
				</div>
			</div>
            <!-- End Panel Static Labels -->
          </div>

		  
		<!--   <div class="col-md-12">
           
             <div class="panel"> 
			  <div class="panel-body container-fluid"> 
					  <div class="list-group">	
					
					  </div>
				</div>
			</div>
                
          </div>  -->

         
        </div>
      </div>
    </div>
    <!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>