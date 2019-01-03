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
                <h3 class="panel-title">Edit Business Category</h3>
				<div class="page-header-actions"><a href="<?php echo base_url('admin/business/categories');?>"><button type="button" class="btn btn-block btn-primary">All Categories</button></a></div>
              </div>
             		  
			  <div class="panel-body container-fluid">
                <form autocomplete="off" method="post" action="">
                 <input type="hidden" name="action" value="save"> 
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $category_name_value = (isset($category_name) && $category_name!='')?$category_name:$category_detail[0]['name'];?>
					  <label class="form-control-label" for="inputGrid1">Category Name</label>
                      <input type="text" name="category_name" id="category_name" class="form-control" value="<?php if(isset($category_name_value)) echo $category_name_value; ?>" maxlength="200" >
					  <div class="admin_content_error">
							<?php echo form_error('category_name'); ?>
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