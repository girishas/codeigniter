<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <?php $this->load->view('admin/common/left_menubar'); ?>
  <!-- Page -->
  <!-- Page -->
  <div class="page">
    
    
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="panel">
          <!-- Panel Static Labels -->
          <div class="panel-heading">
            <h3 class="panel-title">Add New Location</h3>
            <div class="page-header-actions"> <a class="btn btn-info" href="<?php echo base_url('admin/business/locations');?>"> All Locations </a>  <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
          </div>
        </div>
        <div class="panel-body container-fluid">
          <form autocomplete="off" method="post" action="">
            <input type="hidden" name="action" value="save">
            <?php if($admin_session['role']=="owner"){?>
            <div class="form-group  row" data-plugin="formMaterial">
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">Business*</label>
                <select class="form-control" name="business_id" id="business_id">
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
            <div class="form-group  row" data-plugin="formMaterial">
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">Location Name*</label>
                <input type="text" class="form-control" id="location_name" name="location_name" value="<?php if(isset($location_name)) echo $location_name;?>">
                <div class="admin_content_error"><?php echo form_error('location_name'); ?></div>
              </div>
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid2">Phone Number*</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php if(isset($phone_number)) echo $phone_number;?>" />
                <div class="admin_content_error"><?php echo form_error('phone_number'); ?></div>
              </div>
            </div>
            
            <div class="form-group  row" data-plugin="formMaterial">
               <div class="col-md-6">
                <label class="form-control-label" for="inputGrid2">Email*</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php if(isset($email)) echo $email;?>" />
                <div class="admin_content_error"><?php echo form_error('email'); ?></div>
              </div>
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">Address1</label>
                <input type="text" class="form-control" id="address1" name="address1" value="<?php if(isset($address1)) echo $address1;?>">
              </div>
              
            </div>
            
            <div class="form-group  row" data-plugin="formMaterial">
              <!-- <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">Subrub</label>
                <input type="text" class="form-control" id="suburb" name="suburb" value="<?php if(isset($suburb)) echo $suburb;?>">
              </div> -->
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid2">Address2</label>
                <input type="text" class="form-control" id="address2" name="address2" value="<?php if(isset($address2)) echo $address2;?>" />
              </div>
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid2">City*</label>
                <input type="text" class="form-control" id="city" name="city" value="<?php if(isset($city)) echo $city;?>" />
                <div class="admin_content_error"><?php echo form_error('city'); ?></div>
              </div>
              
            </div>
            
            <div class="form-group  row" data-plugin="formMaterial">
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">State</label>
                <input type="text" class="form-control" id="state" name="state" value="<?php if(isset($state)) echo $state;?>">
              </div>
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">Post Code</label>
                <input type="text" class="form-control" id="postcode" name="postcode" value="<?php if(isset($postcode)) echo $postcode;?>">
              </div>
            </div>
            <div class="form-group  row" data-plugin="formMaterial">
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">Timezone</label>
                <select class="form-control select2" data-plugin="select2"   name="timezone_id">
                  <?php foreach ($timezones as $key => $value): ?>
                    <option value="<?=$value['id']?>"><?=$value['name']?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
              <?php $weekdaya= array(
                0=>'Sunday',
                1=>'Monday',
                2=>'Tuesday',
                3=>'Wednesday',
                4=>'Thursday',
                5=>'Friday',
                6=>'Saturday',                
                )?>
            <h5 class="panel-title ">Week Day Wise Start Time And End Time Setting</h5>
              <div class="form-group  row" data-plugin="formMaterial">
                <div class="col-md-6">
            <label class="form-control-label" for="inputGrid1">Day</label>
          </div>
          <div class="col-md-3">
            <label class="form-control-label" for="inputGrid1">Start Time*</label>
          </div>
           <div class="col-md-3">
            <label class="form-control-label" for="inputGrid1">End Time* </label>
          </div>
        </div>
            <?php
           // print_r($weekdaya); 
              foreach ($weekdaya as $key => $value) { ?>
              <div class="form-group  row" data-plugin="formMaterial">
              <div class="col-md-6">                
                <input type="text" class="form-control" id="<?php echo $value  ?>" name="day[]" value="<?php echo $value ?>" readonly>

                 <input type="hidden" class="form-control" id="<?php echo $value  ?>" name="weekday[]" value="<?php echo $key ?>" readonly>
              </div>
              <div class="col-md-3">
                <select class="form-control" required="required" name="start_time[]">
                        <?php
                        $loop =get_hours_range_fifteen();
                        foreach ($loop as $key => $value): ?>                     
                         <option <?= ($key=="09:00:00")?"selected":""; ?> value="<?=$key?>"><?= $value; ?></option>                       
                        <?php endforeach ?>
                      </select>
              </div>

              <div class="col-md-3">
                <select class="form-control" required="required" name="end_time[]">
                        <?php
                        $loop =get_hours_range_fifteen();
                        foreach ($loop as $key => $value): ?>                       
                         <option <?= ($key=="17:00:00")?"selected":""; ?> value="<?=$key?>"><?= $value; ?></option>
                        <?php endforeach ?>
                      </select>
              </div>
            </div>
             <?php }?>
             <div class="form-group row" data-plugin="formMaterial">
              <div class="col-md-6">
                <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
              </div>
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
<!-- End Page -->
<!-- End page -->
<?php $this->load->view('admin/common/footer'); ?>