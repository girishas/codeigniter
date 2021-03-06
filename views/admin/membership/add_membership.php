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
                <h3 class="panel-title">Add New Membership</h3>
				<div class="page-header-actions"><a href="<?php echo base_url('admin/membership');?>"><button type="button" class="btn btn-block btn-primary">All Memberships</button></a></div>
              </div>
              <div class="panel-body container-fluid">
                <form autocomplete="off">
                  
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Membership Name</label>
                      <input type="text" class="form-control" id="inputPlaceholder">
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Price</label>
                      <input type="text" class="form-control" id="inputGrid2" name="inputGrid2" placeholder="0.00" />
                    </div>
                  </div>
				  
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Number of Staff Allowed</label>
                      <input type="text" class="form-control" id="inputPlaceholder" >
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Number of Locations Allowed</label>
                      <input type="text" class="form-control" id="inputGrid2" name="inputGrid2"  />
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