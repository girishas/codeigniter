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
	 <?php $this->load->view('admin/common/header_messages'); ?>
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Import Customers</h3> 
              </div>
              
              <div class="panel-body container-fluid">
                
                <form autocomplete="off" action="<?php echo base_url('admin/customer/import_to_csv');?>" method="post" enctype="multipart/form-data">
                   
                  <input type="hidden" name="action" value="save"> 
                  
                  <?php $admin_session = $this->session->userdata('admin_logged_in');
                  if($admin_session['role'] == 'owner') { ?>

                  <div class="form-group  row" data-plugin="formMaterial">        
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Business*</label>                   
                        <select class="form-control" name="business_id" id="business_id">
                          <option value="">Select Business</option>
                          <?php if($all_business) { ?>
                            <?php foreach($all_business as $business) { ?>
                              <option value="<?php echo $business['id'];?>" <?php if(isset($business_id) && $business_id==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
                          <?php } } ?>
                        </select>
                        <div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Location*</label>                   
                        <select class="form-control" name="location_id" id="location_id">
                          <option value="">Select Location</option>
                          <?php if($all_location) { ?>
                            <?php foreach($all_location as $location) { ?>
                              <option value="<?php echo $location['id'];?>" <?php if(isset($location_id) && $location_id==$location['id']) echo "selected"; ?>><?php echo $location['location_name'];?></option>
                          <?php } } ?>
                        </select>
                        <div class="admin_content_error"><?php echo form_error('location_id'); ?></div>
                    </div>
                  </div>
                  <?php } ?>

                  <?php $admin_session = $this->session->userdata('admin_logged_in');
                  if($admin_session['role'] == 'business_owner') { ?>

                  <div class="form-group  row" data-plugin="formMaterial">        
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Location*</label>                   
                        <select class="form-control" name="location_id" id="location_id">
                          <option value="">Select Location</option>
                          <?php if($all_location) { ?>
                            <?php foreach($all_location as $location) { ?>
                              <option value="<?php echo $location['id'];?>" <?php if(isset($location_id) && $location_id==$location['id']) echo "selected"; ?>><?php echo $location['location_name'];?></option>
                          <?php } } ?>
                        </select>
                        <div class="admin_content_error"><?php echo form_error('location_id'); ?></div>
                    </div>
                  </div>
                  <?php } ?>
                  
 
				          <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Upload CSV file*</label>
                      <div class="form-group">
          						<div class="input-group input-group-file" data-plugin="inputGroupFile">
          						  <input type="text" class="form-control" readonly="">
          						  <span class="input-group-append">
          							<span class="btn btn-success btn-file">
          							  <i class="icon md-upload" aria-hidden="true"></i>
          							  <input type="file" name="file">
          							</span>
          						  </span>
                        <div class="admin_content_error"><?php echo form_error('file'); ?></div>
          						</div>
          					  </div>
                    </div>

                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Sample File</label>
                      <div class="form-group">
                        <a href="<?php echo base_url('uploads/customer/import_sample_file/customers_import_sample.csv'); ?>" target="_blank" class="btn btn-primary" title="Sample File">Click here to download</a>
                      </div>
                    </div>
                    
                  </div>
				  
				          <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <button class="btn btn-primary" data-dismiss="modal" type="submit">Upload</button>
                    </div>
                    <div class="col-md-6">
                    </div>
                  </div>
				  
                </form>
              </div>

              <?php if(!empty($csv_data) && count((array)$csv_data) > 1) { print_r($csv_data);die;//echo count((array)$csv_data)."**********";?>
              
              <div class="panel-body container-fluid">
                <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
                <form autocomplete="off" action="<?php echo base_url('admin/customer/insert_csv_data'); ?>" method="post" enctype="multipart/form-data">
                  
                  <!-- <input type="hidden" name="" value="save"> -->
                  <!-- <?php foreach($csv_data as $value) { ?>
                    <input type="text" name="result[]" value="<?php print_r($value); ?>">
                  <?php } ?> -->

                  <input type="hidden" name="b_id" value="<?php if(!empty($b_id)) { echo $b_id; } ?>"> 
                  <input type="hidden" name="l_id" value="<?php if(!empty($l_id)) { echo $l_id; } ?>"> 
                  <input type="hidden" name="file_path" value="<?php if(!empty($file_name)) { echo $file_name; } ?>"> 

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-12">

                      <table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr" data-selectable="selectable">
                        <thead>
                          <th class="pre-cell dark-background-heading"></th>
                          <th class="pre-100 dark-background-heading" scope="col">Cust Number</th>
                          <th class="pre-100 dark-background-heading" scope="col">First Name</th>
                          <th class="pre-100 dark-background-heading" scope="col">Last Name</th>
                          <th class="pre-100 dark-background-heading" scope="col">Email</th>
                          <th class="pre-100 dark-background-heading" scope="col">Mobile Number</th>
                          <th class="pre-100 dark-background-heading" scope="col">Street</th>
                          <th class="pre-100 dark-background-heading" scope="col">City</th>
                          <th class="pre-100 dark-background-heading" scope="col">State</th>
                          <th class="pre-100 dark-background-heading" scope="col">Post Code</th>
                          <th class="pre-100 dark-background-heading" scope="col">Gender</th>
                          <th class="pre-100 dark-background-heading" scope="col">Occupation</th>
                          <th class="pre-cell dark-background-heading"></th>
                        </thead>
                        <tbody>
                          <?php foreach ($csv_data as $value) { ?>
                          <tr>
                            <td ></td>
                            <td ><?php echo $value['customer_number']; ?></td>
                            <td ><?php echo $value['first_name']; ?></td>
                            <td ><?php echo $value['last_name']; ?></td>
                            <td ><?php echo $value['email']; ?></td>
                            <td ><?php echo $value['mobile_number']; ?></td>
                            <td ><?php echo $value['address1']; ?></td>
                            <td ><?php echo $value['city']; ?></td>
                            <td ><?php echo $value['state']; ?></td>
                            <td ><?php echo $value['postcode']; ?></td>
                            <td ><?php echo $value['gender']; ?></td>
                            <td ><?php echo $value['occupation']; ?></td>
                            <td ></td>
                          </tr>
                          <?php  } ?>
                        </tbody>  
                      </table>


                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <button class="btn btn-primary" data-dismiss="modal" type="submit">Insert into Database</button>
                    </div>
                    <div class="col-md-6">
                    </div>
                  </div>

                </form>
                </div>
              </div>
              <?php } ?>

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