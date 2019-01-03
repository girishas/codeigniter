<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
<?php $this->load->view('admin/common/left_menubar'); ?>  
  <!-- Page -->
 <!-- Page -->
    <div class="page">
	 <?php $this->load->view('admin/common/header_messages');
  ?>
	 <div class="page-main">
      <div class="page-content">
        <div class="panel">
	 
	  <div class="page-header"> 
      <!-- <ul class="nav nav-tabs" role="tablist">
              
               <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense');?>">Open Register</a></li>
               <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_class');?>">Today Position</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/expense/close_register');?>">Close Register</a></li> 
              <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab" href="<?php echo base_url('admin/expense/all_expenses');?>">Expense</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_pos_category');?>">Pos Category</a></li>
             <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_vendors');?>">Vendor</a></li>
              
      </ul> -->
      <?php $this->load->view('admin/common/expense_menu'); ?>
          <div class="page-header-actions">  <a class="btn btn-primary" href="<?php echo base_url('admin/expense/all_expenses');?>"> All Expenses </a>  
		       </div>
    </div>
	 
	 
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Add Expense</h3> 
              </div>
			 			  
              <div class="panel-body container-fluid">
                <form autocomplete="off" action="" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="action" value="save"> 
                   <div class="row">

                 <?php if($admin_session['role']=="owner"){ ?>


					<div class="col-md-6">
						<div class="form-group" data-plugin="formMaterial">
                      <label class="form-control-label" for="inputGrid1">Business*</label>
            <?php if(isset($pos_expense_details)) { $business_id = (isset($business_id) && $business_id!='')?$business_id:$pos_expense_details[0]['business_id']; } else { $business_id = (isset($business_id) && $business_id!='')?$business_id:''; }?>

				    <select class="form-control" name="business_id" id="business_id" onChange="return get_business_locations(this.value)">
					  <option value="">Select Business</option>
						   <?php if($all_business){?>
						   <?php foreach($all_business as $business){?>
						   <option value="<?php echo $business['id'];?>" <?php if(isset($business_id) && $business_id==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
						   <?php } } ?>
					</select>
					<div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                    </div>
                </div>
					<?php } ?> 
					<?php if($admin_session['role']=="business_owner" or $admin_session['role']=="owner"){?>
                    <div class="col-md-6" id="location_section">
                    	<div class="form-group" data-plugin="formMaterial">
                      <label class="form-control-label" for="inputGrid2">Location*</label>
                       <?php if(isset($pos_expense_details)) { $location_id = (isset($location_id) && $location_id!='')?$location_id:$pos_expense_details[0]['location_id']; } else { $location_id = (isset($location_id) && $location_id!='')?$location_id:''; }?>
                       <span id="content_location_id">
					   <select class="form-control" name="location_id" id="location_id">
					   	<option value="">Select Location</option>
						<?php if(isset($locations)){?>
						<?php foreach($locations as $loc){?>
							<option value="<?php echo $loc['id'];?>" <?php if(isset($location_id) && $location_id==$loc['id']) echo "selected"; ?>><?php echo $loc['location_name'];?></option>
						<?php } } ?>
					   </select>
					  </span>
					  <div class="admin_content_error"><?php echo form_error('location_id'); ?></div>
                    </div>
                </div>
				  <?php } ?>
				</div>
				<div class="form-group  row" data-plugin="formMaterial">
                   
                    
                    <div class="col-md-6">
                  		<label class="form-control-label" for="inputGrid1">Date*</label>
                      <?php if(isset($pos_expense_details)) { $paid_date = (isset($paid_date) && $paid_date!='')?$paid_date:$pos_expense_details[0]['paid_date']; } else { $paid_date = (isset($paid_date) && $paid_date!='')?$paid_date:''; }?>
                      <input type="text" class="form-control datep" name="paid_date" value="<?php if(isset($paid_date)) echo $paid_date; ?>">
                  		<!-- <input type="text" class="form-control" id="email" name="paid_date" value="<?php if(isset($paid_date)) echo $paid_date; ?>"> -->
                  		<div class="admin_content_error"><?php echo form_error('paid_date'); ?></div>
                  	</div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Reference</label>
                      <?php if(isset($pos_expense_details)) { $reference = (isset($reference) && $reference!='')?$reference:$pos_expense_details[0]['reference']; } else { $reference = (isset($reference) && $reference!='')?$reference:''; }?>
                      <input type="text" class="form-control" id="mobile_number" name="reference" value="<?php if(isset($reference)) echo $reference;?>" />
					  <div class="admin_content_error"><?php echo form_error('reference'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                   <!--  <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Category*</label>
                      <select class="form-control" name="category_id" id="category_id" onChange="">
                        <option value="0">Select Category</option>
                        <option value="1">1</option>
                      </select>
                    </div> -->
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Category*</label>
                       <?php if(isset($pos_expense_details)) { $category_id = (isset($category_id) && $category_id!='')?$category_id:$pos_expense_details[0]['pos_expcategory_id']; } else { $category_id = (isset($category_id) && $category_id!='')?$category_id:''; }?>
                       <div class="form-group">
                          <span id="content_category_id">
                          <select class="form-control" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                           <?php if(isset($all_pos_category)){ ?>
                          <?php foreach($all_pos_category as $cat){?>
                            <option value="<?php echo $cat['id'];?>" <?php if(isset($category_id) && $category_id==$cat['id']) echo "selected"; ?>><?php echo $cat['name'];?></option>
                          <?php } } ?>
                          </select>
                          <div class="admin_content_error"><?php echo form_error('category_id'); ?></div>
                          </span>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Warehouse*</label>
                      <?php if(isset($pos_expense_details)) { $vendor_id = (isset($vendor_id) && $vendor_id!='')?$vendor_id:$pos_expense_details[0]['vendor_id'];  } else { $vendor_id = (isset($vendor_id) && $vendor_id!='')?$vendor_id:''; }?>
                     

                       <div class="form-group">
                          <span id="content_category_id">
                          <select class="form-control" id="vendor_id" name="vendor_id">
                            <option value="">Select Warehouse</option>
                           <?php if(isset($all_vendor)){ ?>
                          <?php foreach($all_vendor as $cat){  ?>
                            <option value="<?php echo $cat['id'];?>" <?php if(isset($vendor_id) && $vendor_id==$cat['id']) echo "selected"; ?>><?php echo $cat['vendro_name'];?></option>
                          <?php } } ?>
                          </select>
                          <div class="admin_content_error"><?php echo form_error('vendor_id'); ?></div>
                          </span>
                      </div>
                    </div>
                    
                  </div>
				  

                  <div class="form-group row"  data-plugin="formMaterial">
                  	
            <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Amount* </label>
                      <?php if(isset($pos_expense_details)) { $amount = (isset($amount) && $amount!='')?$amount:$pos_expense_details[0]['amount'];  } else { $amount = (isset($amount) && $amount!='')?$amount:''; }?>

                      <input type="text" class="form-control" id="email" name="amount" value="<?php if(isset($amount)) echo $amount;?>">
					  <div class="admin_content_error"><?php echo form_error('amount'); ?></div>
                    </div>

                     <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Medium*</label>
                      <?php if(isset($pos_expense_details)) { $medium = (isset($medium) && $medium!='')?$medium:$pos_expense_details[0]['medium'];  } else { $medium = (isset($description) && $medium!='')?$medium:''; }?>

                       <div class="form-group">
                          <span id="content_category_id">
                          <select class="form-control" id="medium" name="medium">
                            <option value="">Select Medium</option>
                           <?php if(isset($all_medium)){ ?>
                          <?php foreach($all_medium as $cat){?>
                            <option value="<?php echo $cat['id'];?>" <?php if(isset($all_medium) && $medium==$cat['id']) echo "selected"; ?>><?php echo $cat['name'];?></option>
                          <?php } } ?>
                          </select>
                          <div class="admin_content_error"><?php echo form_error('medium'); ?></div>
                          </span>
                      </div>
                    </div>
                  </div> 
				  			  				  
				  <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-12">
                    <label class="form-control-label" for="inputGrid2">description*</label>
                    <?php if(isset($pos_expense_details)) { $description = (isset($description) && $description!='')?$description:$pos_expense_details[0]['description'];  } else { $description = (isset($description) && $description!='')?$description:''; }?>

                    <textarea class="form-control" id="description" name="description" rows="3"><?php if(isset($description)) echo $description;?></textarea>
                   <div class="admin_content_error"><?php echo form_error('description'); ?></div>
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
<style type="text/css">
	.admin_content_error{padding: 0px;}
   .datepicker{z-index: 999999 !important};
</style>
<script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.datep').datepicker({
        todayHighlight:true
      });
    })
</script>
<?php $this->load->view('admin/common/footer'); ?>
