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
          <div class="col-md-6">
            <!-- Panel Static Labels -->
            <div class="panel">
              
              <div class="panel-heading">
                <h3 class="panel-title">Edit  <?php echo ($staff_detail[0]['staff_type']==0)?"Staff":"Location Owner" ?></h3>
                <!-- <div class="page-header-actions"><a href="<?php echo base_url('admin/staff');?>"><button type="button" class="btn btn-block btn-primary">Show All</button></a></div> -->
              </div>

              <div class="panel-body container-fluid">
                
                <form autocomplete="off" method="post" action="" enctype="multipart/form-data">    

                  <input type="hidden" name="action" value="save"> 

                  

                  <?php if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){?>
                  
                  
                    <?php if($admin_session['role']=="owner"){?>
                    <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Business*</label>  
                      <?php $business_id_value = (isset($business_id) && $business_id!='')?$business_id:$staff_detail[0]['business_id'];?>                      
                      <select class="form-control" name="business_id" id="business_id" onChange="return get_business_locations(this.value)">
                        <option value="">Select Business</option>
                           <?php if($all_business){?>
                           <?php foreach($all_business as $business){?>
                           <option value="<?php echo $business['id'];?>" <?php if(isset($business_id_value) && $business_id_value==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
                           <?php } } ?>
                      </select>
                       <div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                    </div>
                    </div>
                   <?php } ?>
                    
                    <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12" id="location_section">
                      <label class="form-control-label" for="inputGrid2">Location*</label>
                      <?php $location_id_value = (isset($location_id) && $location_id!='')?$location_id:$staff_detail[0]['location_id'];?>
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

                  <?php } ?>
                  
                  <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">First Name*</label>
                      <?php $first_name_value = (isset($first_name) && $first_name!='')?$first_name:$staff_detail[0]['first_name'];?>
                      <input type="text" class="form-control" name="first_name" id="first_name" value="<?php if(isset($first_name_value)) echo $first_name_value;?>">
                      <div class="admin_content_error"><?php echo form_error('first_name'); ?></div>
                    </div>
                  </div>
                  <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid2">Last Name</label>
                      <?php $last_name_value = (isset($last_name) && $last_name!='')?$last_name:$staff_detail[0]['last_name'];?>
                      <input type="text" class="form-control" name="last_name" id="last_name" value="<?php if(isset($last_name_value)) echo $last_name_value;?>"  />
                    </div>
                  </div>
          
                  <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Email*</label>
                      <?php $email_value = (isset($email) && $email!='')?$email:$staff_detail[0]['email'];?>
                      <input type="text" class="form-control" name="email" id="email" value="<?php if(isset($email_value)) echo $email_value;?>">
                      <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>
                  </div>
                  <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid2">Mobile Number*</label>
                      <?php $mobile_number_value = (isset($mobile_number) && $mobile_number!='')?$mobile_number:$staff_detail[0]['mobile_number'];?>
                      <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php if(isset($mobile_number_value)) echo $mobile_number_value;?>" />
                      <div class="admin_content_error"><?php echo form_error('mobile_number'); ?></div>
                    </div>
                  </div>
                  <!-- <div class="form-group" data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Password*</label>
                      <input type="password" class="form-control" name="password">
                      <div class="admin_content_error"><?php echo form_error('password'); ?></div>
                    </div>
                  </div> -->
                    <!-- <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Service Commission (%)*</label>
                      <input type="text" class="form-control" name="service_commission">
                      <div class="admin_content_error"><?php echo form_error('service_commission'); ?></div>
                    </div> -->
                  <!-- </div> -->
                  <!-- <div class="form-group  row" data-plugin="formMaterial"> -->
                    <!-- <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Product Commission (%)*</label>
                      <input type="text" class="form-control" name="product_commission">
                      <div class="admin_content_error"><?php echo form_error('product_commission'); ?></div>
                    </div> -->
                    <!-- <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Vouchar Commission(%)*</label>
                      <input type="text" class="form-control" name="vouchar_commission">
                      <div class="admin_content_error"><?php echo form_error('vouchar_commission'); ?></div>
                    </div> -->
                  <!-- </div> -->

                  <!-- <div class="form-group  row" data-plugin="formMaterial"> -->
                    <!-- <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Street/area</label>
                      <input type="text" class="form-control" name="address1" id="address1" value="<?php if(isset($address1)) echo $address1;?>">
                    </div>
                    <div class="col-md-12">
                     <label class="form-control-label" for="inputGrid2">City*</label>
                      <input type="text" class="form-control" id="city" name="city" value="<?php if(isset($city)) echo $city;?>" />
                      <div class="admin_content_error"><?php echo form_error('city'); ?></div>
                    </div> -->
                  <!-- </div> -->
                
                  <!-- <div class="form-group  row" data-plugin="formMaterial"> -->
                    <!-- <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">State</label>
                      <input type="text" class="form-control" name="state" id="state" value="<?php if(isset($state)) echo $state;?>">
                    </div>
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid2">Country*</label>
                      <div class="form-group">
                        <select class="form-control" name="country_id" id="country_id">
                          <option value="">Select Country</option>
                          <?php if($all_countries){?>
                          <?php foreach($all_countries as $country){?>
                           <option value="<?php echo $country['iso_code'];?>" <?php if(isset($country_id) && $country_id==$country['iso_code']) echo "selected";?>><?php echo $country['name'];?></option>
                          <?php } } ?>
                        </select>
                        <div class="admin_content_error"><?php echo form_error('country_id'); ?></div>
                      </div>
                    </div> -->
                  <!-- </div> -->
                  <!-- <div class="form-group  row" data-plugin="formMaterial"> -->
                    <!-- <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Post Code</label>
                      <input type="text" class="form-control" id="post_code" name="post_code" value="<?php if(isset($post_code)) echo $post_code;?>">
                    </div> -->
                    <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid2">Job Title</label>
                      <?php $job_title_value = (isset($job_title) && $job_title!='')?$job_title:$staff_detail[0]['job_title'];?>
                      <div class="form-group">
                          <input type="text" name="job_title" class="form-control" value="<?php if(isset($job_title_value)) echo $job_title_value;?>">
                          <div class="admin_content_error"><?php echo form_error('job_title'); ?></div>
                        </div>
                    </div>
                  </div>          
          
                  <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid2">Employment Start Date*</label>
                      <?php $employment_start_date_value = (isset($employment_start_date) && $employment_start_date!='')?$employment_start_date:$staff_detail[0]['employment_start_date'];
            $employment_start_date_value = !empty($employment_start_date_value)?date("m/d/Y",strtotime($employment_start_date_value)):"" ; 
            ?>
                      <input type="text" class="form-control" name="employment_start_date" id="employment_start_date" data-date-format="dd/mm/yyyy" data-plugin="datepicker" data-date-today-highlight="true" value="<?php if(isset($employment_start_date_value)) echo $employment_start_date_value;?>">
                      <div class="admin_content_error"><?php echo form_error('employment_start_date'); ?></div>
                    </div>
                  </div>
                  <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid2">Employment End Date</label>
                      <?php $employment_end_date_value = (isset($employment_end_date) && $employment_end_date!='')?$employment_end_date:$staff_detail[0]['employment_end_date'];
            $employment_end_date_value = !empty($employment_end_date_value)?date("m/d/Y",strtotime($employment_end_date_value)):"" ; 
            ?>
                      <input type="text" data-date-format="dd/mm/yyyy" class="form-control" name="employment_end_date" id="employment_end_date" data-date-today-highlight="true" data-plugin="datepicker" value="<?php if(isset($employment_end_date_value)) echo $employment_end_date_value;?>">
                    </div>
                  </div>
          
                  <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid2">Profile Picture</label>
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
                        <?php if(!empty($staff_detail[0]['picture'])){?>
                          <img id="img_1" src="<?php echo base_url('images/staff/thumb/'.$staff_detail[0]['picture']); ?>" width="50px;" style="margin-top:2px;" />
                          <?php }else{?>
                          <img id="img_1" class="img-fluid" src="<?php echo base_url('global/product/no-product-image.jpg');?>" width="50px;" style="margin-top:2px;">
                        <?php }?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Notes</label>
                      <?php $notes_value = (isset($notes) && $notes!='')?$notes:$staff_detail[0]['notes']; ?>
                      <textarea class="form-control" name="notes" id="notes" rows="3"><?php if(isset($notes_value)) echo $notes_value;?></textarea>
                    </div>
                  </div>
          
                  <div class="form-group  " data-plugin="formMaterial">
                    <div class="col-md-12">
                      <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
                    </div>
                  </div>
          
               <!--  </form> -->
              </div>
            </div>
            <!-- End Panel Static Labels -->
          </div>

         
          <!-- </div> -->

<!-- row 2 ********************** -->
<!-- <div class="row"> -->
          <div class="col-md-6">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Commission </h3>
                <div class="page-header-actions"><a href="<?php echo base_url('admin/staff');?>"><button type="button" class="btn btn-block btn-primary">Show All</button></a></div>
              </div>
              <div class="panel-body container-fluid">
              <!--  <form autocomplete="off" method="post" action="" enctype="multipart/form-data">   -->  
                   <!-- <input type="hidden" name="action" value="save">  -->
                  
         
                    <div class="form-group  row" data-plugin="formMaterial">
                      <div class="col-md-6">
                        <?php $service_commission = (isset($service_commission) && $service_commission!='')?$service_commission:$staff_detail[0]['service_commission'];?>
                        <label class="form-control-label" for="inputGrid1">Service Commission (%)*</label>
                        <input type="text" value="<?= $service_commission; ?>" class="form-control" name="service_commission">
                        <div class="admin_content_error"><?php echo form_error('service_commission'); ?></div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-control-label" for="inputGrid1">Target Service Value</label>
                        <?php $target_service_value = (isset($target_service_value) && $target_service_value!='')?$target_service_value:$staff_detail[0]['target_service_value'];?>
                        <input type="text" class="form-control" name="target_service_value"  value="<?= $target_service_value; ?>">
                        <div class="admin_content_error"><?php echo form_error('target_service_value'); ?></div>
                      </div>
                      
                    </div>

                    <div class="form-group  row" data-plugin="formMaterial">
                      <div class="col-md-6">
                        <label class="form-control-label" for="inputGrid1">Product Commission (%)*</label>
                        <?php $product_commission = (isset($product_commission) && $product_commission!='')?$product_commission:$staff_detail[0]['product_commission'];?>
                        <input type="text" class="form-control" name="product_commission" value="<?= $product_commission; ?>">
                        <div class="admin_content_error"><?php echo form_error('product_commission'); ?></div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-control-label" for="inputGrid1">Target Product Value</label>
                        <?php $target_product_value = (isset($target_product_value) && $target_product_value!='')?$target_product_value:$staff_detail[0]['target_product_value'];?>
                        <input type="text" class="form-control" name="target_product_value" value="<?= $target_product_value; ?>">
                        <div class="admin_content_error"><?php echo form_error('target_product_value'); ?></div>
                      </div>
                      
                      
                    </div>

                    <div class="form-group  row" data-plugin="formMaterial">
                      <div class="col-md-6">
                        <?php $vouchar_commission = (isset($vouchar_commission) && $vouchar_commission!='')?$vouchar_commission:$staff_detail[0]['vouchar_commission'];?>
                        <label class="form-control-label" for="inputGrid1">Vouchar Commission(%)*</label>
                        <input type="text" value="<?= $vouchar_commission; ?>" class="form-control" name="vouchar_commission">
                        <div class="admin_content_error"><?php echo form_error('vouchar_commission'); ?></div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-control-label" for="inputGrid1">Target Voucher Value</label>
                        <?php $target_voucher_value = (isset($target_voucher_value) && $target_voucher_value!='')?$target_voucher_value:$staff_detail[0]['target_voucher_value'];?>
                        <input type="text" class="form-control" name="target_voucher_value" value="<?= $target_voucher_value; ?>">
                        <div class="admin_content_error"><?php echo form_error('target_voucher_value'); ?></div>
                      </div>
                    </div>

                    <h3 class="panel-title">Address</h3>

                    <div class="form-group  " data-plugin="formMaterial">
                      <div class="col-md-12">
                        <label class="form-control-label" for="inputGrid1">Street/area</label>
                        <?php $address1_value = (isset($address1) && $address1!='')?$address1:$staff_detail[0]['address1'];?>
                        <input type="text" class="form-control" name="address1" id="address1" value="<?php if(isset($address1_value)) echo $address1_value;?>">
                      </div>
                    </div>
                    <div class="form-group  " data-plugin="formMaterial">
                      <div class="col-md-12">
                       <label class="form-control-label" for="inputGrid2">City*</label>
                       <?php $city_value = (isset($city) && $city!='')?$city:$staff_detail[0]['city'];?>
                        <input type="text" class="form-control" id="city" name="city" value="<?php if(isset($city_value)) echo $city_value;?>" />
                        <div class="admin_content_error"><?php echo form_error('city'); ?></div>
                      </div>
                    </div>
                    <div class="form-group  " data-plugin="formMaterial">
                      <div class="col-md-12">
                        <label class="form-control-label" for="inputGrid1">State</label>
                        <?php $state_value = (isset($state) && $state!='')?$state:$staff_detail[0]['state'];?>
                        <input type="text" class="form-control" name="state" id="state" value="<?php if(isset($state_value)) echo $state_value;?>">
                      </div>
                    </div>
                    <div class="form-group  " data-plugin="formMaterial">
                      <div class="col-md-12">
                        <label class="form-control-label" for="inputGrid2">Country*</label>
                        <?php $country_id_value = (isset($country_id) && $country_id!='')?$country_id:$staff_detail[0]['country_id'];?>
                        <div class="form-group">
                          <select class="form-control" name="country_id" id="country_id">
                            <option value="">Select Country</option>
                            <?php if($all_countries){?>
                            <?php foreach($all_countries as $country){?>
                             <option value="<?php echo $country['iso_code'];?>" <?php if(isset($country_id_value) && $country_id_value==$country['iso_code']) echo "selected";?>><?php echo $country['name'];?></option>
                            <?php } } ?>
                          </select>
                          <div class="admin_content_error"><?php echo form_error('country_id'); ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group  " data-plugin="formMaterial">
                      <div class="col-md-12">
                        <label class="form-control-label" for="inputGrid1">Post Code</label>
                        <?php $post_code_value = (isset($post_code) && $post_code!='')?$post_code:$staff_detail[0]['post_code'];?>
                        <input type="text" class="form-control" id="post_code" name="post_code" value="<?php if(isset($post_code_value)) echo $post_code_value;?>">
                      </div>
                    </div>     

                    <h3 class="panel-title"></h3>

                  <div class="form-group  row" data-plugin="formMaterial">
                      <div class="col-md-8" style="margin-left: 15px;">
                        <?php $calendor_bookable_staff = (isset($calendor_bookable_staff) && $calendor_bookable_staff!='')?$calendor_bookable_staff:$staff_detail[0]['calendor_bookable_staff'];?>
                        <p><strong>Calendar Bookable Staff</strong></p>
                      </div>
                      <div class="col-md-2">
                        <label class="switch">
                          <input type="checkbox" name="calendor_bookable_staff" <?php if(isset($calendor_bookable_staff)) { if($calendor_bookable_staff == 1) {echo "checked"; } } ?> />
                          <span class="slider round"></span>
                        </label>
                      </div>
                      <div class="col-md-2">
                        
                      </div>
                  
                </div>
                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-8" style="margin-left: 15px;">
                    <?php $roaster_staff = (isset($roaster_staff) && $roaster_staff!='')?$roaster_staff:$staff_detail[0]['roaster_staff'];?>
                    <p><strong>Rostered Staff</strong></p>
                  </div>
                  <div class="col-md-2">
                    <label class="switch">
                       <input type="checkbox" name="roaster_staff" <?php if(isset($roaster_staff)) { if($roaster_staff == 1) {echo "checked"; } } ?> /> 
                      <!-- <input type="checkbox" name="roaster_staff"> -->
                      <span class="slider round"></span>
                    </label>
                  </div>
                  <div class="col-md-2">
                    
                  </div>
                  
                </div>    

                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-8" style="margin-left: 15px;">
                    <?php $applocation_access = (isset($applocation_access) && $applocation_access!='')?$applocation_access:$staff_detail[0]['applocation_access'];?>
                    <p><strong>Application Access</strong></p>
                  </div>
                  <div class="col-md-2">
                    <label class="switch">
                     <input type="checkbox" name="applocation_access" <?php if(isset($applocation_access)) { if($applocation_access == 1) {echo "checked"; } } ?> />
                      <span class="slider round"></span>
                    </label>
                  </div>
                  <div class="col-md-2">
                    
                  </div>
                  
                </div>     

          
                
              </div>
            </div>
            <!-- End Panel Static Labels -->
          </div>

         
          </div>
          </form>
<!-- row 2 ********************** -->


        </div>


      </div>
    </div>
    <!-- End Page -->
  <!-- End page -->
  <style type="text/css">
    .admin_content_error{
      width: 100% !important;
    }
  </style>

<?php $this->load->view('admin/common/footer'); ?>