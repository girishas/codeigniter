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
                <h3 class="panel-title"><?php echo $staff_name; ?>  >> Assigned Services</h3>
				<div class="page-header-actions"><a href="<?php echo base_url('admin/staff/assigned_services?staff='.$staff_name);?>"><button type="button" class="btn btn-block btn-primary">All Assigned Services</button></a></div>
              </div>
              <div class="panel-body container-fluid">
                <form autocomplete="off" method="post" action="">
                 <input type="hidden" name="action" value="save"> 
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Service Name</label>
                       <div class="form-group">
						<select class="form-control">
						  <option>Select Service</option>
						  <option>Hair Cut</option>
						  <option>Hair Color</option>
						  <option>Hair Textures</option>
						  <option>Hair Blowouts</option>
						  <option>Hair Styling</option>
						  <option>Waxing</option>
						  <option>Boay Facial</option>
						</select>
					  </div>
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