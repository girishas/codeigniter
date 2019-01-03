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
	 <?php if($this->session->flashdata('success_msg')) {?>
	   <div class="alert dark alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
		<?php echo $this->session->flashdata('success_msg');?>
	  </div>
	  <?php }else if($this->session->flashdata('error_msg')) { ?>
	  <div class="alert alert-danger alert-dismissible" role="alert">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
	   <?php echo $this->session->flashdata('error_msg');?>
       </div>
	<?php  }?>
	<!-- End alert message part -->
	
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
               <h3 class="panel-title ">Edit Plan </h3>
				<div class="page-header-actions"><a href="<?php echo base_url('admin/business/assign_plan');?>"><button type="button" class="btn btn-block btn-primary">All Plan</button></a></div>
              </div>
              <div class="panel-body container-fluid">
                <form autocomplete="off" method="post" action="" enctype="multipart/form-data">
                  <input type="hidden" name="action" value="save"> 

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                     
                      <label class="form-control-label" for="inputGrid1">Plan Name*</label>
                      <input type="text" name="name" id="name" class="form-control" value="<?php if(isset($plans['name'])) echo $plans['name']; ?>"  >
                      <div class="admin_content_error"><?php echo form_error('name'); ?></div>
                    </div>

                    <div class="col-md-6">                     
                      <label class="form-control-label" for="inputGrid1">Plan Price*</label>
                      <input type="number" name="plan_price" id="plan_price" class="form-control" value="<?php if(isset($plans['plan_price'])) echo $plans['plan_price']; ?>" readonly>
                      <div class="admin_content_error"><?php echo form_error('plan_price'); ?></div>
                    </div>
                  </div> 

                   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                     
                      <label class="form-control-label" for="inputGrid1">Staff Allowed*</label>
                      <input type="number" name="staff_allowed" id="staff_allowed" class="form-control" value="<?php if(isset($plans['staff_allowed'])) echo $plans['staff_allowed']; ?>"  >
                      <div class="admin_content_error"><?php echo form_error('staff_allowed'); ?></div>
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