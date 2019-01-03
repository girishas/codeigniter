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
            <div class="panel-heading">
              <h3 class="panel-title">Edit Profile</h3>
            </div>
            <div class="panel-body container-fluid">
              <form autocomplete="off" method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save">
                <div class="form-group  row" data-plugin="formMaterial">
                  <?php $admin_name = (isset($admin_name) && $admin_name!='')?$admin_name:$data['admin_name'];?>
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid1">Name*</label>
                    <input type="text" class="form-control" name="admin_name" id="admin_name" value="<?php if(isset($admin_name)) echo $admin_name;?>">
                    <div class="admin_content_error"><?php echo form_error('admin_name'); ?></div>
                  </div>
                </div>
                
                <div class="form-group  row" data-plugin="formMaterial">
                  <?php $email_value = (isset($email) && $email!='')?$email:$data['email'];?>
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid1">Email*</label>
                    <input type="text" class="form-control" name="email" id="email" value="<?php if(isset($email_value)) echo $email_value;?>">
                    <div class="admin_content_error"><?php echo form_error('email'); ?></div>
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