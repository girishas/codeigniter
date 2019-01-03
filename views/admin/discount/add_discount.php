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
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Add Resource</h3>
                <div class="page-header-actions">
                  <!-- <a href="<?php echo base_url('admin/resource');?>"><button type="button" class="btn btn-block btn-primary">All Resources</button></a> -->
                  <a class="btn btn-info" href="<?php echo base_url('admin/discount');?>">All Discounts </a>
                  <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
                </div>
              </div>
              <div class="panel-body container-fluid">
                
                <form autocomplete="off" method="post" action="<?php echo base_url('admin/discount/add_discount/'.$this->uri->segment('4'));?>">
                  
                  <input type="hidden" name="action" value="save"> 
                  
                  <?php 
                  $admin_session = $this->session->userdata('admin_logged_in');
                  if($admin_session['role'] == 'owner') { ?>

                  <div class=" row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Business*</label>
                      <?php  if(isset($details)) { $business_id = (isset($business_id) && $business_id!='')?$business_id:$details[0]['business_id']; }else{ $business_id = (isset($business_id) && $business_id!='')?$business_id:''; } ?>
                      <div class="form-group">
                        <select class="form-control" name="business_id" id="business_id">
                          <option value="">Select Business</option>
                          <?php if($all_business){?>
                           <?php foreach($all_business as $business){?>
                           <option value="<?php echo $business['id'];?>" <?php if(isset($business_id)){ if($business_id==$business['id']) { echo "selected"; }  }?>><?php echo $business['name'];?></option>
                           <?php } } ?>
                        </select>
                        <div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>

                  

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Discount Name*</label>
                      <?php  if(isset($details)) { $discount_name = (isset($discount_name) && $discount_name!='')?$discount_name:$details[0]['discount_name']; }else{ $discount_name = (isset($discount_name) && $discount_name!='')?$discount_name:''; } ?>
                      <input type="text" name="discount_name" class="form-control" id="discount_name" value="<?php if(isset($discount_name)){ echo $discount_name; }?>">
                      <div class="admin_content_error"><?php echo form_error('discount_name'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Discount Type*</label>
                      <?php  if(isset($details)) { $discount_type = (isset($discount_type) && $discount_type!='')?$discount_type:$details[0]['discount_type']; }else{ $discount_type = (isset($discount_type) && $discount_type!='')?$discount_type:''; } ?>
                        <select class="form-control" name="discount_type" id="discount_type">
                          <option value="" >Select Type</option>
                          <option value="1" <?php if(isset($discount_type)){ if($discount_type == '1'){ echo "selected"; }; }?> >Fix Amount</option>
                          <option value="2" <?php if(isset($discount_type)){ if($discount_type == '2'){ echo "selected"; }; }?> >Percentage (%)</option>
                        </select>
                      <!-- <input type="text" name="discount_type" class="form-control" id="discount_type" value="<?php if(isset($discount_type)){ echo $discount_type; }?>"> -->
                      <div class="admin_content_error"><?php echo form_error('discount_type'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Discount Price*</label>
                      <?php  if(isset($details)) { $discount_price = (isset($discount_price) && $discount_price!='')?$discount_price:$details[0]['discount_price']; }else{ $discount_price = (isset($discount_price) && $discount_price!='')?$discount_price:''; } ?>
                      <input type="text" name="discount_price" class="form-control" id="discount_price" value="<?php if(isset($discount_price)){ echo $discount_price; }?>">
                      <div class="admin_content_error"><?php echo form_error('discount_price'); ?></div>
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

