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
          <?php $this->load->view('admin/common/header_messages'); ?>
          <!-- Panel Static Labels -->
          <div class="panel">
            <div class="page-header">
              <?php $this->load->view('admin/product/inventry_top'); ?>
              <div class="page-header-actions"><h3 class="panel-title"></h3></div>
            </div>
            <div class="panel-body container-fluid" style="padding-top: 0px;">
              <form autocomplete="off" method="post" action="">
                <input type="hidden" name="action" value="save">
                <?php if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){?>
                <div class="form-group  row" data-plugin="formMaterial">
                  <?php if($admin_session['role']=="owner"){?>
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid1">Business*</label>
                    <select required="required" class="form-control" name="business_id" id="business_id">
                      <option value="">Select Business</option>
                      <?php if($all_business){?>
                      <?php foreach($all_business as $business){?>
                      <option value="<?php echo $business['id'];?>" <?php if(isset($business_id) && $business_id==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
                      <?php } } ?>
                    </select>
                    <div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                  </div>
                  <?php }else{ ?>
                  <input type="hidden" name="business_id" value="<?=$admin_session['business_id']?>">
                  <?php } ?>
                </div>
                <?php } ?>
                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid1">Brand Name</label>
                    <input required="required" type="text" name="brand_name" id="brand_name" class="form-control" value="<?php if(count((array)$category_data)>0) echo $category_data['brand_name'];?>">
                    <div class="admin_content_error"><?php echo form_error('brand_name'); ?></div>
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