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
        <!-- End alert message part -->
        <div class="page-header">
          <h1 class="page-title">Inventory Use Limit</h1>
          <div class="page-header-actions">
            <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
          </div>
        </div>
        <div class="page-content container-fluid">
          <div class="row">
            <div class="col-md-6">
              <!-- Panel Static Labels -->
              <form autocomplete="off" method="post" action="<?php echo base_url(); ?>admin/product/product_use_settings">
                <input type="hidden" name="action" value="save">
                 <input type="hidden" name="product_use_id" value="<?php echo $getSetting['id'] ?>">
  

                 <?php if ($admin_session['role']=="business_owner" || $admin_session['role']=="owner") { ?>

                    <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-12">
                    
                        
                    <label class="form-control-label" for="inputGrid2">Location</label>
                    <select class="form-control" name="location_id" id="location_id" onchange="getdata(this.value)" > 
                      <?php foreach ($location as $key => $value) { ?>
                      <option value="<?php echo $value['id'];?>" <?php if($select_location_id==$value['id']) echo "selected"; ?>><?php echo $value['location_name'];?></option>
                      <?php } ?>
                    </select>
                   
                    <div class="admin_content_error"><?php echo form_error('internal_use'); ?></div>
                  </div>
                </div>
                  
                <?php }  ?>


                <?php if ($admin_session['role']=="location_owner") { ?>

                  <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-12">
                    <label class="form-control-label" for="inputGrid1">Location</label>
                    <input type="hidden" class="form-control" id="location_id" name="location_id" value="<?php echo  $admin_session['location_id']  ?>">
                    <div class="admin_content_error"><?php echo form_error('location_id'); ?></div>
                  </div>
                </div>
               <?php  } ?>

                

              
                
                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-12">
                    <label class="form-control-label" for="inputGrid1">Used in Salon</label>
                    <input type="text" class="form-control" id="internal_use" name="internal_use" value="<?php echo $getSetting['internal_use'] ?>">
                    <div class="admin_content_error"><?php echo form_error('internal_use'); ?></div>
                  </div>
                </div>
                
                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-12">
                    <label class="form-control-label" for="inputGrid1">Use as Tester</label>
                    <input type="text" class="form-control" id="tester_use" name="tester_use" value="<?php echo $getSetting['tester_use'] ?>">
                    <div class="admin_content_error"><?php echo form_error('tester_use'); ?></div>
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
  <script type="text/javascript">
    function getdata(id){    
      window.location.href=site_url+"admin/product/product_use_settings/"+id;
    }
  </script>