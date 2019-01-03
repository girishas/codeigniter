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
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Setting</h3>
                <div class="page-header-actions">
                  <!-- <a href="<?php echo base_url('admin/resource');?>"><button type="button" class="btn btn-block btn-primary">All Resources</button></a> -->
                  <!-- <a class="btn btn-primary" href="<?php echo base_url('admin/membership');?>">All Memberships </a> -->
                  <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a> 
                </div>
              </div>
              <div class="panel-body container-fluid">
                
                <form autocomplete="off" method="post" action="<?php echo base_url('admin/setting');?>" enctype="multipart/form-data">
                  
                  <input type="hidden" name="action" value="save"> 
                  
                  <?php if(isset($all_records)) { 
                    foreach ($all_records as $key=>$value) { 
                      if($value['type'] == 'text') { ?>


                        <div class="form-group  row" data-plugin="formMaterial">
                          <div class="col-md-6">
                            <label class="form-control-label" for="inputGrid1"><?= $value['label'];?> *</label>
                            <input type="text" class="form-control" name="<?= $value['slug'];?>" id="<?= $value['slug'];?>" value="<?= $value['value'];?>">
                            <?= $value['description'];?>
                            <div class="admin_content_error"><?php echo form_error($value['slug']); ?></div>
                          </div>
                          
                        </div>
                  
                  <?php }  ?>
                  <?php if($value['type'] == 'img') { ?>
                        <div class="form-group  row" data-plugin="formMaterial">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label" for="inputGrid1"><?= $value['label'];?> </label>
                              <div class="input-group input-group-file" data-plugin="inputGroupFile">
                                <input type="text" class="form-control" placeholder="">
                                <span class="input-group-append">
                                <span class="btn btn-success btn-file waves-effect waves-classic">
                                  <i class="icon md-upload" aria-hidden="true"></i>
                                  <input type="file" name="<?= $value['slug'];?>" id="<?= $value['slug'];?>" class="">
                                </span>
                                </span>
                              </div>
                              <?= $value['description'];?>
                            </div>
                            <div class="image" style="border-style: dotted;width: 106px;">
                              <img src="<?= base_url('assets/images/website_logo.jpg') ?>" style="width: 100px;height: 50px;">
                            </div>
                          </div>
                        </div>

                  <?php } } } ?>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <button class="btn btn-primary" data-dismiss="modal" type="submit">Update</button>
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

