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
                <h3 class="panel-title">Add Currency</h3>
				 <div class="page-header-actions"><a href="<?php echo base_url('admin/currency');?>"><button type="button" class="btn btn-block btn-primary">All Currencies</button></a></div>
              </div>
              <div class="panel-body container-fluid">
                <form autocomplete="off" method="post" action="">
                 <input type="hidden" name="action" value="save"> 
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Currency Name</label>
                      <input type="text" name="category_name" class="form-control" id="inputPlaceholder">
                    </div>
					<div class="col-md-6">
                       <label class="form-control-label" for="inputGrid1">Currency Code</label>
                      <input type="text" name="category_name" class="form-control" id="inputPlaceholder">
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