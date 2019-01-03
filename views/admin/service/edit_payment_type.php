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
                <h3 class="panel-title">Edit Payment Type</h3>
				<div class="page-header-actions"><a href="<?php echo base_url('admin/service/all_payment_types');?>"><button type="button" class="btn btn-block btn-primary">All Payment Types</button></a></div>
              </div>
              <div class="panel-body container-fluid">
                <form name="paymentTypeEdit" id="paymentTypeEdit" autocomplete="off" method="post" action="<?php echo base_url('admin/service/update_payment_type');?>/<?php echo $getPaymentTypes[0]['id']; ?>">
                 <input type="hidden" name="action" value="save"> 
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Name</label>
                      <input type="text" name="name" id="name" class="form-control" value="<?php echo $getPaymentTypes[0]['name']; ?>" />
                    </div>
                  </div>
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Status</label>
                       <div class="form-group">
						<select class="form-control" name="status" id="status">
						  <option value="active" <?php if($getPaymentTypes[0]['status'] == 'active') echo "selected"; ?>>Active</option>
						  <option value="inactive" <?php if($getPaymentTypes[0]['status'] == 'inactive') echo "selected"; ?>>Inactive</option>
						</select>
					  </div>
                    </div>
                  </div>
                  <input type="hidden" name="busniess_id" value="<?php echo $getPaymentTypes[0]['busniess_id']; ?>" />
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