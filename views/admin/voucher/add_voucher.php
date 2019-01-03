<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <?php $this->load->view('admin/common/left_menubar'); ?>
  <!-- Page -->
  <div class="page">
    
    <!-- Alert message part -->
    <?php $this->load->view('admin/common/header_messages'); ?>
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-md-12">
          <!-- Panel Static Labels -->
          
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Add Vouchers</h3>
               <div class="page-header-actions">
                <a class="btn btn-info" href="<?php echo base_url('admin/voucher');?>"> All Vouchers </a>
                <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
              </div>
            </div>
            <div class="panel-body container-fluid">
              
              <form autocomplete="off" method="post" action="<?php echo  base_url('admin/voucher/add_voucher'); ?>" enctype="multipart/form-data">
                
                <input type="hidden" name="action" value="save">
                <?php
                $admin_session = $this->session->userdata('admin_logged_in');
                if($admin_session['role'] == 'owner') { ?>
                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid1">Business*</label>
                    <select class="form-control" name="business_id">
                      <option value="">Select Business</option>
                      <?php if($all_business){?>
                      <?php foreach($all_business as $business){?>
                      <option value="<?php echo $business['id'];?>" <?php if(isset($business_id)){ if($business_id==$business['id']) { echo "selected"; }  }?>><?php echo $business['name'];?></option>
                      <?php } } ?>
                    </select>
                    <div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                  </div>
                   <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Vouchar Name*</label>
                    <input type="text" required="required" class="form-control" id="vouchar_name" name="vouchar_name" value="<?php if(isset($vouchar_name)) { echo $vouchar_name; }?>" />
                    <div class="admin_content_error"><?php echo form_error('vouchar_name'); ?></div>
                  </div>
                  
                </div>
                <?php } else { ?>
                <div class="form-group  row" data-plugin="formMaterial">
                   <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Vouchar Name*</label>
                    <input type="text"  required="required" class="form-control" id="vouchar_name" name="vouchar_name" value="<?php if(isset($vouchar_name)) { echo $vouchar_name; }?>" />
                    <div class="admin_content_error"><?php echo form_error('vouchar_name'); ?></div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Voucher Amount*</label>
                    <input type="number" required="required" class="form-control" id="voucher_amount" name="voucher_amount" value="<?php if(isset($voucher_amount)) { echo $voucher_amount; }?>" />
                    <div class="admin_content_error"><?php echo form_error('voucher_amount'); ?></div> 
                  </div>
                </div>
                <?php } ?>
                <div class="form-group  row" data-plugin="formMaterial">
                 
                  
                </div>
				
				<?php
                $admin_session = $this->session->userdata('admin_logged_in');
                if($admin_session['role'] == 'owner') { ?>
				<div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Voucher Amount*</label>
                    <input type="text" required="required" class="form-control" id="voucher_amount" name="voucher_amount" value="<?php if(isset($voucher_amount)) { echo $voucher_amount; }?>" />
                    <div class="admin_content_error"><?php echo form_error('voucher_amount'); ?></div>
                  </div>
                  <div class="col-md-6">
                    
                  </div>
                </div>
				<?php } ?>
				
                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-12">
                    <label class="form-control-label" for="inputGrid2">description*</label>
                    <textarea class="form-control" id="description" required="required" name="description" rows="3"><?php if(isset($description)) { echo $description; }?></textarea>
                    <div class="admin_content_error"><?php echo form_error('description'); ?></div>
                  </div>
                </div>
                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-12">
                    <label class="form-control-label" for="inputGrid2">Vourchar Terms</label>
                    <textarea class="form-control" id="vourchar_terms" name="vourchar_terms" rows="3"><?php if(isset($vourchar_terms)) { echo $vourchar_terms; }?></textarea>
                    <!-- <div class="admin_content_error"><?php echo form_error('vourchar_terms'); ?> -->
                  </div>
                </div>
                  <div class="form-group  row" data-plugin="formMaterial">
                 <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Status *</label>
                    <select class="form-control" name="status" required="required">
                      <option value="">Select Status</option>
                      <option value="1" <?php if(isset($status)) { if($status == '1') { echo "selected"; } } ?> >Active</option>
                      <option value="2" <?php if(isset($status)) { if($status == '2') { echo "selected"; } } ?> >Deactive</option>
                    <!--   <option value="3" <?php if(isset($status)) { if($status == '3') { echo "selected"; } } ?> >Used</option> -->
                    </select>
                  </div>
                   </div>
                
                
                
                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-6">
                    <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
                  </div>
                  <div class="col-md-6">
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
 <style type="text/css">
 .datepicker{z-index: 999999 !important};
   
 </style>