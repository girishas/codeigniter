<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <?php $this->load->view('admin/common/left_menubar'); ?>
  <!-- Page -->
  <div class="page">
    <div class="page-content">
      <div class="panel">
        <?php $this->load->view('admin/common/header_messages'); ?>
        <!-- Alert message part -->

        <?php if($this->session->flashdata('success_msg')) {?>
        <div class="alert dark alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
        </div>
        
        <?php } ?>
        <?php if($this->session->flashdata('error_msg')) {?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
        </div>
        
        <?php } ?>
        <!-- End alert message part -->
        <div class="page-header">
          <h1 class="page-title">Change Password</h1>
          <div class="page-header-actions">
            <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
          </div>
        </div>
        <div class="page-content container-fluid">
          <div class="row">
            <div class="col-md-6">
              <!-- Panel Static Labels -->
              <form autocomplete="off" method="post" action="<?php echo base_url(); ?>admin/user/change_password">
                <input type="hidden" name="action" value="save">
                
                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-12">
                    <label class="form-control-label" for="inputGrid1">Choose a new password</label>
                    <input type="password" class="form-control" id="password" name="password" value="">
                    <div class="admin_content_error"><?php echo form_error('password'); ?></div>
                  </div>
                </div>
                
                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-12">
                    <label class="form-control-label" for="inputGrid1">Verify your new password</label>
                    <input type="password" class="form-control" id="admin_retype_password" name="admin_retype_password" value="">
                    <div class="admin_content_error"><?php echo form_error('admin_retype_password'); ?></div>
                  </div>
                </div>
                
                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-6">
                    <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
                  </div>
                </div>
                
              </form>
              <!-- End Panel Static Labels -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Page -->
  <?php $this->load->view('admin/common/footer'); ?>