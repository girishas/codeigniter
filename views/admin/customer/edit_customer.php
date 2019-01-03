<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>  
<link rel="stylesheet" href="<?php echo base_url('assets/selectbox_isd_code/build/css/intlTelInput.css');?>">
  <!-- Page -->
 <!-- Page -->
    <div class="page">
       <?php $this->load->view('admin/common/header_messages'); ?>
	  <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Edit Customer</h3>
				 <div class="page-header-actions">
				 	<a href="<?php echo base_url('admin/customer/detail/'.$customer_detail[0]['id']);?>"><button type="button" class="btn btn-primary">View Details</button></a>
				 	<a href="<?php echo base_url('admin/customer');?>"><button type="button" class="btn btn-primary">All Customers</button></a>
				 </div>
              </div>
              <div class="panel-body container-fluid">
                <form autocomplete="off" action="" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="action" value="save"> 
                   <?php
                   //print_r($admin_session); 
                    if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){?>				  
				  <?php $business_id_value = (isset($business_id) && $business_id!='')?$business_id:$customer_detail[0]['business_id'];?>				  
				  <div class="form-group  row" data-plugin="formMaterial">
				  	<?php if ($admin_session['role']!="business_owner") { ?>
				  <!-- 	<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Business*</label>                      
				    <select class="form-control" name="business_id" id="business_id" onChange="return get_business_locations(this.value)" disabled>
					  <option value="">Select Business</option>
						   <?php if($all_business){?>
						   <?php foreach($all_business as $business){?>
						   <option value="<?php echo $business['id'];?>" <?php if(isset($business_id_value) && $business_id_value==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
						   <?php } } ?>
					</select>
					 <div class="admin_content_error"><?php echo form_error('business_id'); ?></div> 
                    </div> -->
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Business*</label>                
                    <input  class="form-control" type="text" value="<?php echo $customer_detail[0]['business_name'] ?>" name="business_id" id="business_id" readonly>
				  	
				  		<input  class="form-control" type="hidden" value="<?php echo $customer_detail[0]['business_id'] ?>" name="business_id" id="business_id">
				  	</div>
				  	<?php } ?>
					

					
                    <div class="col-md-6" id="location_section">
                       <?php $location_id_value = (isset($location_id) && $location_id!='')?$location_id:$customer_detail[0]['location_id']; ?>
					  <label class="form-control-label" for="inputGrid2">Location*</label>
                       <span id="content_location_id">
					   <select class="form-control" name="location_id" id="location_id">
					   	<option value="">Select Location</option>
						<?php if(isset($locations)){?>


						<?php foreach($locations as $loc){?>
							<option value="<?php echo $loc['id'];?>" <?php if(isset($location_id_value) && $location_id_value==$loc['id']) echo "selected"; ?>><?php echo $loc['location_name'];?></option>
						<?php } } ?>
					   </select>
					  </span>
					  <div class="admin_content_error"><?php echo form_error('location_id'); ?></div>
                    </div>
                  </div>
				  <?php }else{ 
				  	$business_id_value = (isset($business_id) && $business_id!='')?$business_id:$customer_detail[0]['business_id'];
				  	$location_id_value = (isset($location_id) && $location_id!='')?$location_id:$customer_detail[0]['location_id'];
				  	?>
				  	<input type="hidden" value="<?=$business_id_value?>" name="business_id">
				  	<input type="hidden" value="<?=$location_id_value?>" name="location_id">
				  <?php } ?>


                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $first_name_value = (isset($first_name) && $first_name!='')?$first_name:$customer_detail[0]['first_name'];?>
					  <label class="form-control-label" for="inputGrid1">First Name*</label>
                      <input type="text" class="form-control" name="first_name" id="first_name" value="<?php if(isset($first_name_value)) echo $first_name_value;?>">
					  <div class="admin_content_error"><?php echo form_error('first_name'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <?php $last_name_value = (isset($last_name) && $last_name!='')?$last_name:$customer_detail[0]['last_name'];?>
					  <label class="form-control-label" for="inputGrid2">Last Name</label>
                      <input type="text" class="form-control" id="last_name" name="last_name" value="<?php if(isset($last_name_value)) echo $last_name_value;?>" />
                    </div>
                  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $email_value = (isset($email) && $email!='')?$email:$customer_detail[0]['email'];?>
					  <label class="form-control-label" for="inputGrid1">Email*</label>
                      <input type="text" class="form-control" id="email" name="email" value="<?php if(isset($email_value)) echo $email_value;?>">
					  <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>
                     <div class="col-md-6">
                         <label class="form-control-label" for="inputGrid2">Mobile Number*</label>
                        <div class="form-group row">
                            <div class="col-md-12">
                        <?php $mobile_number_value = (isset($mobile_number) && $mobile_number!='')?$mobile_number:$customer_detail[0]['mobile_number'];?>					 
                      <input id="demo" type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php if(isset($mobile_number_value)) echo $mobile_number_value;?>" />
					  <div class="admin_content_error"><?php echo form_error('mobile_number'); ?></div>
                         <!--         <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php if(isset($mobile_number)) echo $mobile_number;?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  />
                      <div class="admin_content_error"><?php echo form_error('mobile_number'); ?></div> -->
                            </div>




                          </div>  
                        
                    </div>


                  </div>
                    <!-- <div class="col-md-6">
                      <?php $mobile_number_value = (isset($mobile_number) && $mobile_number!='')?$mobile_number:$customer_detail[0]['mobile_number'];?>
					  <label class="form-control-label" for="inputGrid2">Mobile Number*</label>
                      <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php if(isset($mobile_number_value)) echo $mobile_number_value;?>" />
					  <div class="admin_content_error"><?php echo form_error('mobile_number'); ?></div>
                    </div>
                  </div> -->


                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $customer_number = (isset($customer_number) && $customer_number!='')?$customer_number:$customer_detail[0]['customer_number'];?>
					  <label class="form-control-label" for="inputGrid1">Customer Number</label>
                      <input type="text" disabled="disabled" class="form-control" name="customer_number" value="<?php if(isset($customer_number)) echo $customer_number;?>">
					  <div class="admin_content_error"><?php echo form_error('customer_number'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <?php $occupation_value = (isset($occupation) && $occupation!='')?$occupation:$customer_detail[0]['occupation'];?>
                      <label class="form-control-label" for="inputGrid1">Occupation</label>
                      <input type="text" class="form-control" id="occupation" name="occupation" value="<?php if(isset($occupation_value)) echo $occupation_value;?>">
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                  	 <div class="col-md-6">
                  	 	<?php if (!empty($dob) || !empty($customer_detail[0]['dob'])){ 
							$dob = (isset($dob) && $dob!='')?$dob:$customer_detail[0]['dob'];
							//echo date("F", strtotime('00-9-01'));
							$dob=explode('-', $dob);
						}else{
							$dob[0] = 1;
							$dob[1] = 1;
						}
                  	 	?>

                             <label class="form-control-label" for="inputGrid2">Date Of Birthday</label>
                      <div class="form-group">
            <div class="input-group input-group-file" data-plugin="inputGroupFile">
                <select name="day" class="form-control">
                  <?php for ($i=1; $i <32 ; $i++) { ?>
                    <option value="<?php echo $i ?>" <?php if($dob[0]==$i) echo "selected";?>><?php echo $i ?></option>
                  <?php } ?>              
              </select>  
              <select name="month" class="form-control">
                <option value="1" <?php if($dob[1]==1) echo "selected";?>>January</option>
                <option value="2" <?php if($dob[1]==2) echo "selected";?>>Febuary</option>
                <option value="3" <?php if($dob[1]==3) echo "selected";?> >March</option>
                <option value="4" <?php if($dob[1]==4) echo "selected";?> >April</option>
                <option value="5" <?php if($dob[1]==5) echo "selected";?> >May</option>
                <option value="6" <?php if($dob[1]==6) echo "selected";?> >June</option>
                <option value="7" <?php if($dob[1]==7) echo "selected";?> >July</option>
                <option value="8" <?php if($dob[1]==8) echo "selected";?> >August</option>
                <option value="9" <?php if($dob[1]==9) echo "selected";?> >September</option>
                <option value="10" <?php if($dob[1]==10) echo "selected";?> >October</option>
                <option value="11" <?php if($dob[1]==11) echo "selected";?> >November</option>
                <option value="12" <?php if($dob[1]==12) echo "selected";?> >December</option>
			 </select>
            </div>
            </div>
                      
                    </div>
                    <div class="col-md-6">
                      <?php $is_vip = (isset($is_vip) && $is_vip!='')?$is_vip:$customer_detail[0]['is_vip'];?>
					  <label class="form-control-label" for="inputGrid1">Vip Status</label>
						<select class="form-control" name="is_vip" id="is_vip">
						  <option value="1" <?php if(isset($is_vip) && $is_vip=="1") echo "selected";?>>Yes</option>
						  <option value="0" <?php if(isset($is_vip) && $is_vip=="0") echo "selected";?>>No</option>
						</select>
                  </div>
				  	</div>
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                     <?php $address1_value = (isset($address1) && $address1!='')?$address1:$customer_detail[0]['address1'];?>
					  <label class="form-control-label" for="inputGrid1">Street/area</label>
                      <input type="text" class="form-control" id="address1" name="address1" value="<?php if(isset($address1_value)) echo $address1_value;?>">
                    </div>
                    <div class="col-md-6">
                      <?php $city_value = (isset($city) && $city!='')?$city:$customer_detail[0]['city'];?>
					  <label class="form-control-label" for="inputGrid2">City</label>
                      <input type="text" class="form-control" id="city" name="city" value="<?php if(isset($city_value)) echo $city_value;?>" />
					  <div class="admin_content_error"><?php echo form_error('city'); ?></div>
                    </div>
                  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $state_value = (isset($state) && $state!='')?$state:$customer_detail[0]['state'];?>
					  <label class="form-control-label" for="inputGrid1">State</label>
                      <input type="text" class="form-control" id="state" name="state" value="<?php if(isset($state_value)) echo $state_value;?>">
                    </div>
                    <div class="col-md-6">
                      <?php $postcode_value = (isset($postcode) && $postcode!='')?$postcode:$customer_detail[0]['postcode'];?>
					  <label class="form-control-label" for="inputGrid1">Post Code*</label>
                      <input type="text" class="form-control" id="postcode" name="postcode" value="<?php if(isset($postcode_value)) echo $postcode_value;?>">
					  <div class="admin_content_error"><?php echo form_error('postcode'); ?></div>
					</div>
                  </div>
				 
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $gender_value = (isset($gender) && $gender!='')?$gender:$customer_detail[0]['gender'];?>
					  <label class="form-control-label" for="inputGrid1">Gender</label>
                       <div class="form-group">
						<select class="form-control" name="gender" id="gender">
						<option value="Female" <?php if(isset($gender_value) && $gender_value=="Female") echo "selected";?>>Female</option>
						 <option value="Male" <?php if(isset($gender_value) && $gender_value=="Male") echo "selected";?>>Male</option>
						</select>
					  </div>
                    </div>
                    <div class="col-md-6">
                      <?php $referred_by = (isset($referred_by) && $referred_by!='')?$referred_by:$customer_detail[0]['referred_by'];?>
					  <label class="form-control-label" for="inputGrid1">Referred By</label>
                      <input type="text" class="form-control" name="referred_by" value="<?php if(isset($referred_by)) echo $referred_by;?>">
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
						<?php if(!empty($customer_detail[0]['photo'])){?>
							<img id="img_1" src="<?php echo base_url('images/customer/thumb/'.$customer_detail[0]['photo']); ?>" width="50px;" style="margin-top:2px;" />
						  <?php }else{?>
						  <img id="img_1" class="img-fluid" src="<?php echo base_url('global/product/no-product-image.jpg');?>" width="50px;" style="margin-top:2px;">
						  <?php }?>
					  </div>
                    </div>
                  </div>




				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $notification_value = (isset($notification) && $notification!='')?$notification:$customer_detail[0]['notification'];?>
					  <label class="form-control-label" for="inputGrid1">Notification</label>                      
					  <div class="form-group">
						<ul class="list-unstyled list-inline">
						 <li class="list-inline-item">
						  <div class="checkbox-custom">&nbsp;&nbsp;</div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom checkbox-info">
							<input type="checkbox" name="notification[]" value="email" id="notification_email" <?php if(isset($notification_value) && ($notification_value=="email" || $notification_value=="both")) echo "checked"; ?> />
							<label>Email</label>
						  </div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom"></div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom checkbox-warning">
							<input type="checkbox" name="notification[]" value="sms" id="notification_sms" <?php if(isset($notification_value) && ($notification_value=="sms" || $notification_value=="both")) echo "checked"; ?> />
							<label>SMS </label>
						  </div>
						</li>
					   </ul>
					  </div>
					
					</div>
                    
					<div class="col-md-6">
                      <?php $reminders_value = (isset($reminders) && $reminders!='')?$reminders:$customer_detail[0]['reminders'];?>
					  <label class="form-control-label" for="inputGrid2">Reminder</label>
                      <div class="form-group">
						<ul class="list-unstyled list-inline">
						<li class="list-inline-item">
						  <div class="checkbox-custom">&nbsp;&nbsp;</div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom checkbox-info">
							<input type="checkbox" name="reminders[]" value="email" id="reminders_email" <?php if(isset($reminders_value) && ($reminders_value=="email" || $reminders_value=="both")) echo "checked"; ?> />
							<label>Email</label>
						  </div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom"></div>
						</li>
						<li class="list-inline-item">
						  <div class="checkbox-custom checkbox-warning">
							<input type="checkbox" name="reminders[]" value="sms" id="reminders_sms" <?php if(isset($reminders_value) && ($reminders_value=="sms" || $reminders_value=="both")) echo "checked"; ?> />
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
$("#demo").intlTelInput("setNumber", "<?php echo ($mobile_number_value=="")?'+61 ':$mobile_number_value; ?>");

</script>