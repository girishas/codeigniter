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
    
    <!-- Alert message part -->
    <?php $this->load->view('admin/common/header_messages'); ?>
    <!-- End alert message part -->
    <div class="page-content">
      <div class="panel">
    <div class="page-header">
      <h1 class="page-title"></h1>
      <div class="page-header-actions">
        <a href="<?php echo base_url('admin/setup');?>"><button type="button" class="btn btn-block btn-primary">Setup</button></a>  </div>
      </div>
      
      <div class="page-content container-fluid">
        
        <div class="row">
          <div class="col-md-6">
            <!-- Panel Static Labels -->
            <form autocomplete="off" method="post" action="<?php echo base_url(); ?>admin/business/taxes">
              <input type="hidden" name="invoice_tax" value="invoice_tax">
              <h1 class="page-title" style="margin-bottom:15px;">Tax on Service and Invoicing</h1>
              <div class="list-group">
                <?php $admin_session = $this->session->userdata('admin_logged_in');
                if($admin_session['role'] == 'owner') { ?>
                <!-- <div class="col-md-12"> -->
                <label class="form-control-label" for="inputGrid2">Select Business</label>
                <?php if(isset($business_details)) {?>
                <?php $business_id1 = (isset($business_id1) && $business_id1!='')?$business_id1:$business_details[0]['id'];?>
                <?php } else { ?>
                <?php $business_id1 = (isset($business_id1) && $business_id1!='')?$business_id1:'';?>
                <?php } ?>
                <select class="form-control" name="business_id1">
                  <option value="">Select Business</option>
                  <?php if($all_business){?>
                  <?php foreach($all_business as $bus){?>
                  <option value="<?php echo $bus['id'];?>" <?php if($business_id1) { if($business_id1==$bus['id']) { echo "selected"; } } ?>><?php echo $bus['name'];?></option>
                  <?php } } ?>
                </select>
                <div class="admin_content_error" style="width: 100%;"><?php echo form_error('business_id1'); ?></div>
                <!-- </div>  -->
                <?php } ?>
                <!-- <div class="col-md-12"> -->
                <?php if(isset($business_details)) {?>
                <?php $tax_service_percent = (isset($tax_service_percent) && $tax_service_percent!='')?$tax_service_percent:$business_details[0]['tax_service_percent'];?>
                <?php } else { ?>
                <?php $tax_service_percent = (isset($tax_service_percent) && $tax_service_percent!='')?$tax_service_percent:'';?>
                <?php } ?>
                
                <label class="form-control-label" for="inputGrid2">Tax Percentage </label>
                <input type="text" class="form-control" id="tax_service_percent" name="tax_service_percent" value="<?php if(isset($tax_service_percent)) echo $tax_service_percent;?>" />
                <div class="admin_content_error" style="width: 100%;"><?php echo form_error('tax_service_percent'); ?></div>
                <!-- </div> -->
                <!-- <div class="col-md-12"> -->
                <?php if(isset($business_details)) {?>
                <?php $tax_service_method = (isset($tax_service_method) && $tax_service_method!='')?$tax_service_method:$business_details[0]['tax_service_method'];?>
                <?php } else { ?>
                <?php $tax_service_method = (isset($tax_service_method) && $tax_service_method!='')?$tax_service_method:'';?>
                <?php } ?>
                <label class="form-control-label" for="inputGrid1">Method</label>
                <select class="form-control" name="tax_service_method" id="tax_service_method">
                  <option value="">Select Tax Method</option>
                  <option value="inclusive" <?php if($tax_service_method == 'inclusive') echo "selected";?> >Inclusive</option>
                  <option value="exclusive" <?php if($tax_service_method == 'exclusive') echo "selected";?>>Exclusive</option>
                </select>
                <div class="admin_content_error" style="width: 100%;"><?php echo form_error('tax_service_method'); ?></div>
                <!-- </div> -->
                <!-- <div class="col-md-12 pt-20"> -->
                  <div class="form-group">
                    <br>
                <button class="btn btn-primary waves-effect waves-classic" data-dismiss="modal" type="submit" style="width: 15%;">Save</button>
              </div>
                <!-- </div>  -->
              </div>
            </form>
            <!-- End Panel Static Labels -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
  <!-- End Page -->
  <!-- End page -->
  <?php $this->load->view('admin/common/footer'); ?>