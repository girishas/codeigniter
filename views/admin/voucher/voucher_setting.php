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
  <!-- End alert message part -->
  
    <div class="page-header">
      <div class="page-header-actions">
        <a class="btn btn-info" href="<?php echo base_url('admin/voucher');?>"> All Vouchers </a>
        <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
      </div>
    </div>

    <div class="page-content container-fluid">

      <div class="row">
        <div class="col-md-12">
          <!-- Panel Static Labels -->
          

          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Voucher Code Settings </h3>
            </div>

              

            <div class="panel-body container-fluid">
              
              <form autocomplete="off" method="post" action="<?php echo base_url('admin/voucher/voucher_setting'); ?>" enctype="multipart/form-data">
                 
                <input type="hidden" name="action" value="save"> 
               <input type="hidden" name="id" value="<?php echo $setting['id'] ?>">

                <div class="form-group  row" data-plugin="formMaterial">
                 
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Code Settings</label>                
                    <select class="form-control" name="status">                   
            <option value="1" <?php if ($setting['status']==1) {echo "selected";} ?> >Auto</option>
             <option value="2" <?php if ($setting['status']==2) {echo "selected";} ?> >Custom</option>                
                    </select>

                     <!-- <option value="1" <?php if(isset($setting['status'])) { if($setting->$setting['status'] == '1') { echo "selected"; } } ?> >Auto</option>
                      <option value="2" <?php if(isset($setting->$setting['status'])) { if($setting->$setting['status'] == '2') { echo "selected"; } } ?> >Custom</option> -->
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
<script type="text/javascript">
  
</script>
