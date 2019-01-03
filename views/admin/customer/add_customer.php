<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>  
<link rel="stylesheet" href="<?php echo base_url('assets/selectbox_isd_code/build/css/intlTelInput.css');?>">
<style type="text/css">
    .intl-tel-input{
        width: 100%;
    }
</style>
  <!-- Page -->
 <!-- Page -->
    <div class="page">
	 <?php $this->load->view('admin/common/header_messages');
  ?>
	 
	 
	  <div class="page-header"> 
          <div class="page-header-actions">  <a class="btn btn-primary" href="<?php echo base_url('admin/customer');?>"> All Customers </a>  
		  </div>
        </div>
	 
	 
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Add Customer</h3> 
              </div>
			  
			  
			  
              <div class="panel-body container-fluid">
                <form autocomplete="off" action="" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="action" value="save"> 
                   <div class="row">
                  <?php if($admin_session['role']=="owner"){?>
					<div class="col-md-6">
						<div class="form-group" data-plugin="formMaterial">
                      <label class="form-control-label" for="inputGrid1">Business*</label>                      
				    <select class="form-control" name="business_id" id="business_id" onChange="return get_business_locations(this.value)">
					  <option value="">Select Business</option>
						   <?php if($all_business){?>
						   <?php foreach($all_business as $business){?>
						   <option value="<?php echo $business['id'];?>" <?php if(isset($business_id) && $business_id==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
						   <?php } } ?>
					</select>
					<div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                    </div>
                </div>
					<?php } ?>
					<?php if($admin_session['role']=="business_owner" or $admin_session['role']=="owner"){ ?>
                    <div class="col-md-6" id="location_section">
                    	<div class="form-group" data-plugin="formMaterial">
                      <label class="form-control-label" for="inputGrid2">Location*</label>
                       <span id="content_location_id">
					   <select class="form-control" name="location_id" id="location_id">
					   	<option value="">Select Location</option>
						<?php if(isset($locations)){ ?>
						<?php foreach($locations as $loc){?>
							<option value="<?php echo $loc['id'];?>" <?php if(isset($location_id) && $location_id==$loc['id']) echo "selected"; ?>><?php echo $loc['location_name'];?></option>
						<?php } } ?>
					   </select>
					  </span>
					  <div class="admin_content_error"><?php echo form_error('location_id'); ?></div>
                    </div>
                </div>
				  <?php } ?>
				</div>
				<div class="form-group  row" data-plugin="formMaterial">
                   

                    <!-- <div class="col-md-6">
                  		<label class="form-control-label" for="inputGrid1">Customer Number*</label>
                  		<input type="text" class="form-control" id="email" name="customer_number" value="<?php echo  isset($customer_number)?$customer_number:generateCustID($admin_session['business_id']);?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                  		<div class="admin_content_error"><?php echo form_error('customer_number'); ?></div>
                  	</div> -->

                    <div class="col-md-6">
                        <label class="form-control-label" for="inputGrid1">Customer Number*</label>
                        <!-- <input type="text" class="form-control" id="email" name="customer_number" value="<?php echo $customer_last_id  ?>"> -->
                        <input type="text" class="form-control" id="email" disabled="disabled" name="customer_number" value="Auto generated by system">
                        <div class="admin_content_error"><?php echo form_error('customer_number'); ?></div>
                    </div>

                    <div class="col-md-6">
                         <label class="form-control-label" for="inputGrid2">Mobile Number*</label>
                        <div class="form-group row">
                            <div class="col-md-12">
                                 <input id="demo" type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php if(isset($mobile_number)) echo $mobile_number;?>"/>
                                <div class="admin_content_error"><?php echo form_error('mobile_number'); ?></div>
                            </div>
                        </div>  
                        
                    </div>


                  </div>
                  <!--   <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Mobile Number*</label>
                       <div class="form-group">
           
                      

                    </div>
                  </div>
                  </div>
                  </div>
                      <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php if(isset($mobile_number)) echo $mobile_number;?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  />
					  <div class="admin_content_error"><?php echo form_error('mobile_number'); ?></div> -->

                   

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">First Name*</label>
                      <input type="text" class="form-control" name="first_name" id="first_name" value="<?php if(isset($first_name)) echo $first_name;?>">
					  <div class="admin_content_error"><?php echo form_error('first_name'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Last Name</label>
                      <input type="text" class="form-control" id="last_name" name="last_name" value="<?php if(isset($last_name)) echo $last_name;?>" />
                    </div>
                  </div>
				  

                  <div class="form-group row"  data-plugin="formMaterial">
                  	
 <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Email </label>
                      <input type="text" class="form-control" id="email" name="email" value="<?php if(isset($email)) echo $email;?>">
					  <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>

                  	<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Occupation</label>
                      <input type="text" class="form-control" id="occupation" name="occupation" value="<?php if(isset($occupation)) echo $occupation;?>">
                    </div>
                  </div>
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                             <label class="form-control-label" for="inputGrid2">Date Of Birthday</label>
                      <div class="form-group">
            <div class="input-group input-group-file" data-plugin="inputGroupFile">
                <select name="day" class="form-control">
                  <?php for ($i=1; $i <32 ; $i++) { ?>
                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                  <?php } ?>              
              </select>

             
              <select name="month" class="form-control">
                <option value="1">January</option>
                <option value="2">Febuary</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
           
        <!--   <select name="year" class="form-control">
             <?php

              for ($i=1970; $i <= date('Y') ; $i++) { ?>
                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                  <?php } ?>
           
          </select> -->

            </div>
            </div>
                      
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Vip Status</label>
                     <div class="form-group">
						<select class="form-control" name="is_vip">
						  <option value="1">Yes</option>
						  <option value="0">No</option>
						</select>
					  </div>
					  <div class="admin_content_error"><?php echo form_error('is_vip'); ?></div>
                    </div>
                  </div>
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Street/area</label>
                      <input type="text" class="form-control" id="address1" name="address1" value="<?php if(isset($address1)) echo $address1;?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">City</label>
                      <input type="text" class="form-control" id="city" name="city" value="<?php if(isset($city)) echo $city;?>" />
					 
                    </div>
                  </div>
				  				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">State</label>
                      <input type="text" class="form-control" id="state" name="state" value="<?php if(isset($state)) echo $state;?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Post Code*</label>
                      <input type="text" class="form-control" id="postcode" name="postcode" value="<?php if(isset($postcode)) echo $postcode;?>">
						 <div class="admin_content_error"><?php echo form_error('postcode'); ?></div>
					</div>
                  </div>
				 
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Gender</label>
                       <div class="form-group">
						<select class="form-control" name="gender" id="gender">
						  <option value="Female">Female</option>
						  <option value="Male">Male</option>
						</select>
					  </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Referred By</label>
                      <input type="text" class="form-control" id="email" name="referred_by" value="<?php if(isset($email)) echo $email;?>">
            <div class="admin_content_error"><?php echo form_error('referred_by'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Photo</label>
                      <div class="form-group">
            <div class="input-group input-group-file" data-plugin="inputGroupFile">
              <input type="text" class="form-control" readonly="">
              <span class="input-group-append">
              <span class="btn btn-success btn-file">
                <i class="icon md-upload" aria-hidden="true"></i>
                <input type="file" name="image" multiple="">
              </span>
              </span>
            </div>
            </div>
                    </div>
                  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Notification at the time of booking</label>                      
					  <div class="form-group">
						<ul class="list-unstyled list-inline">
						 <li class="list-inline-item">
						  <div class="checkbox-custom">&nbsp;&nbsp;</div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom checkbox-info">
							<input type="checkbox" name="notification[]" value="email" id="notification_email" <?php if(isset($notification) && ($notification=="email" || $notification=="both")) echo "checked"; else echo "checked";?> />
							<label>Email</label>
						  </div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom"></div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom checkbox-warning">
							<input type="checkbox" name="notification[]" value="sms" id="notification_sms" <?php if(isset($reminders) && ($reminders=="sms" || $reminders=="both")) echo "checked"; else echo "";?> />
							<label>SMS </label>
						  </div>
						</li>
					   </ul>
					  </div>
					
					</div>
                    
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Reminder 24hours before</label>
                      <div class="form-group">
						<ul class="list-unstyled list-inline">
						<li class="list-inline-item">
						  <div class="checkbox-custom">&nbsp;&nbsp;</div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom checkbox-info">
							<input type="checkbox" name="reminders[]" value="email" id="reminders_email" checked />
							<label>Email</label>
						  </div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom"></div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom checkbox-warning">
							<input type="checkbox" name="reminders[]" value="sms" id="reminders_sms" checked />
							<label>SMS </label>
						  </div>
						</li>
					   </ul>
					  </div>
                    </div>
                  </div>
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
                    </div>
                    
                  </div>
				  
                </form>
              </div>
            </div>
            <!-- End Panel Static Labels -->
          </div>

         
          </div>
        </div>
      </div>
    </div>
    <!-- End Page -->
  <!-- End page -->
<style type="text/css">
	.admin_content_error{padding: 0px;}
</style>
<?php $this->load->view('admin/common/footer'); ?>
<script src="<?php echo base_url('assets/selectbox_isd_code/build/js/intlTelInput.js');?>"></script>
<script type="text/javascript">
$("#demo").intlTelInput();
// Get the extension part of the current number
var extension = $("#demo").intlTelInput("getExtension");
// Get the current number in the given format
var intlNumber = $("#demo").intlTelInput("getNumber");
// Get the type (fixed-line/mobile/toll-free etc) of the current number.
var numberType = $("#demo").intlTelInput("getNumberType");
// Get the country data for the currently selected flag.
var countryData = $("#demo").intlTelInput("getSelectedCountryData");
// Vali<a href="https://www.jqueryscript.net/time-clock/">date</a> the current number
var isValid = $("#demo").intlTelInput("isValidNumber");
// Load the utils.js script (included in the lib directory) to enable formatting/validation etc.
$("#demo").intlTelInput("loadUtils", "<?php echo base_url('assets/selectbox_isd_code/build/js/utils.js');?>");
// Change the country selection
$("#demo").intlTelInput("selectCountry", "AU");
// Insert a number, and update the selected flag accordingly.
$("#demo").intlTelInput("setNumber", "+61 ");

</script>