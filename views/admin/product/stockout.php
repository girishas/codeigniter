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
      <?php $this->load->view('admin/common/header_messages'); ?>
	  <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="page-header">
			  <ul class="nav nav-tabs" role="tablist">
				  <li class="nav-item" role="presentation"><a class="nav-link active" href="<?php echo base_url('admin/product');?>" role="tab">Products</a></li>
				  <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/product/orders');?>" >Orders</a></li>
				  <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/product/brands');?>" >Brands</a></li>
				  <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/product/categories');?>">Categories</a></li>
				   <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/product/all_suppliers');?>">Suppliers</a></li>
			  </ul>
			  <div class="page-header-actions"><h3 class="panel-title">Stock Out</h3></div>
			</div>
              <div class="panel-body pt-0 container-fluid">
                <form autocomplete="off" action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="action" value="save"> 
                  <?php if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){?>
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php if($admin_session['role']=="owner"){?>
					<div class="col-md-6">
                     <?php $business_id_value = (isset($business_id) && $business_id!='')?$business_id:$product_detail[0]['business_id'];?>
					  <label class="form-control-label" for="inputGrid1">Business*</label>                      
				    <select class="form-control" name="business_id" id="business_id" onChange="return get_business_locations(this.value)">
					  <option value="">Select Business</option>
						   <?php if($all_business){?>
						   <?php foreach($all_business as $business){?>
						   <option value="<?php echo $business['id'];?>" <?php if(isset($business_id_value) && $business_id_value==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
						   <?php } } ?>
					</select>
					<div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                    </div>
					<?php } ?>
					
                  </div>
				  <?php } ?>
				  
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $bar_code_value = (isset($bar_code) && $bar_code!='')?$bar_code:$product_detail[0]['bar_code'];?>
					  <label class="form-control-label" for="inputGrid1">Bar Code</label>
                      <input type="text" class="form-control" id="bar_code" name="bar_code" value="<?php if(isset($bar_code_value)) echo $bar_code_value;?>" disabled>
					  <div class="admin_content_error"><?php echo form_error('bar_code'); ?></div>
                    </div>
                    
					<div class="col-md-6">
                      <?php $sku_value = (isset($sku) && $sku!='')?$sku:$product_detail[0]['sku'];?>
					  <label class="form-control-label" for="inputGrid1">SKU</label>
                      <input type="text" class="form-control" id="sku" name="sku" value="<?php if(isset($sku_value)) echo $sku_value;?>" disabled>
					  <div class="admin_content_error"><?php echo form_error('sku'); ?></div>
				    </div>		
				  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php $product_name_value = (isset($product_name) && $product_name!='')?$product_name:$product_detail[0]['product_name'];?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Product Name*</label>
                      <input type="text" class="form-control" id="product_name" name="product_name" value="<?php if(isset($product_name_value)) echo $product_name_value;?>">
					  <div class="admin_content_error"><?php echo form_error('product_name'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <?php $category_id_value = (isset($category_id) && $category_id!='')?$category_id:$product_detail[0]['category_id'];?>
					  <label class="form-control-label" for="inputGrid2">Category*</label>
                       <div class="form-group">
						<span id="content_category_id">
						<select class="form-control" id="category_id" name="category_id">
						  <option value="">Select Category</option>
						 <?php if(isset($categories)){?>
						<?php foreach($categories as $cat){?>
							<option value="<?php echo $cat['id'];?>" <?php if(isset($category_id_value) && $category_id_value==$cat['id']) echo "selected"; ?>><?php echo $cat['category_name'];?></option>
						<?php } } ?>
						</select>
						<div class="admin_content_error"><?php echo form_error('category_id'); ?></div>
						</span>
					  </div>
                    </div>
                  </div>
				  
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <?php $brand_id_value = (isset($brand_id) && $brand_id!='')?$brand_id:$product_detail[0]['brand_id'];?>
					  <label class="form-control-label" for="inputGrid1">Brand</label>
                      <div class="form-group">
						<span id="content_brand_id">
						<select class="form-control" name="brand_id" id="brand_id">
						  <option value="">Select Brand</option>
						  <?php if(isset($brands)){?>
						  <?php foreach($brands as $brand){?>
							<option value="<?php echo $brand['id'];?>" <?php if(isset($brand_id_value) && $brand_id_value==$brand['id']) echo "selected"; ?>><?php echo $brand['brand_name'];?></option>
						  <?php } } ?>
						</select>
						</span>
					  </div>
                    </div>
                    <div class="col-md-6">
                      <?php $supplier_id_value = (isset($supplier_id) && $supplier_id!='')?$supplier_id:$product_detail[0]['supplier_id'];?>
					  <label class="form-control-label" for="inputGrid2">Supplier Name*</label>
                      <div class="form-group">
						<span id="content_supplier_id">
						<select class="form-control" name="supplier_id" id="supplier_id">
						  <option value="">Select Supplier</option>
						  <?php if(isset($suppliers)){?>
						  <?php foreach($suppliers as $supplier){?>
							<option value="<?php echo $supplier['id'];?>" <?php if(isset($supplier_id_value) && $supplier_id_value==$supplier['id']) echo "selected"; ?>><?php echo $supplier['first_name'].' '.$supplier['last_name'];?></option>
						  <?php } } ?>
						</select>
						<div class="admin_content_error"><?php echo form_error('supplier_id'); ?></div>
						</span>
					  </div>
                    </div>
                  </div>
				  
				    <div class="form-group  row" data-plugin="formMaterial">
				    <div class="col-md-6">
				  		 <?php $product_tax_type = (isset($product_tax_type) && $product_tax_type!='')?$product_tax_type:$product_detail[0]['product_tax_type'];?>
				  		 <label class="form-control-label">Product Tax Type</label>
				  		<select class="form-control" name="product_tax_type">
				  			<option <?php if($product_tax_type=="exclusive"){echo "selected";} ?> value="exclusive">Exclusive</option>
				  			<option <?php if($product_tax_type=="inclusive"){echo "selected";} ?> value="inclusive">Inclusive</option>
				  			<option <?php if($product_tax_type=="notax"){echo "selected";} ?> value="inclusive">No Tax</option>
				  		</select>
				  	</div>	
                   <div class="col-md-6">
				  		 <?php $product_tax = (isset($product_tax) && $product_tax!='')?$product_tax:$product_detail[0]['product_tax'];?>
				  		<label class="form-control-label">Product Tax (%)</label>
				  		<input type="text" name="product_tax"  value="<?php if(isset($product_tax)) echo $product_tax;?>" class="form-control">
				  	</div>
					
                  </div>
				 
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                     <?php $purchase_price_value = (isset($purchase_price) && $purchase_price!='')?$purchase_price:$product_detail[0]['purchase_price'];?>
					  <label class="form-control-label" for="inputGrid1">Base Price*</label>
                      <input type="text" class="form-control" id="purchase_price" name="purchase_price" value="<?php if(isset($purchase_price_value)) echo $purchase_price_value;?>">
					  <div class="admin_content_error"><?php echo form_error('purchase_price'); ?></div>
                    </div>
                     <div class="col-md-6">
                      <?php $retail_price_value = (isset($retail_price) && $retail_price!='')?$retail_price:$product_detail[0]['retail_price'];?>
					  <label class="form-control-label" for="inputGrid1">Retail Price*</label>
                      <input type="text" class="form-control" name="retail_price" id="retail_price" placeholder="0.00" value="<?php if(isset($retail_price_value)) echo $retail_price_value;?>">
					  <div class="admin_content_error"><?php echo form_error('retail_price'); ?></div>
                    </div>
						
				  </div>			 
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                   
                   <!--  <div class="col-md-6">
                      <?php //$special_price_value = (isset($special_price) && $special_price!='')?$special_price:$product_detail[0]['special_price'];?>
					  <label class="form-control-label" for="inputGrid2">Special Price</label>
                      <input type="text" class="form-control" id="special_price" name="special_price" placeholder="0.00" value="<?php// if(isset($special_price_value)) echo $special_price_value;?>" />
                    </div> -->
					<div class="col-md-6">
                       <?php $alert_quantity_value = (isset($alert_quantity) && $alert_quantity!='')?$alert_quantity:$product_detail[0]['alert_quantity'];?>
					   <label class="form-control-label" for="inputGrid1">Alert Quantity (Branch wise)</label>
                      <input type="text" class="form-control" id="alert_quantity" name="alert_quantity" value="<?php if(isset($alert_quantity_value)) echo $alert_quantity_value;?>">
					  <div class="admin_content_error"><?php echo form_error('alert_quantity'); ?></div>
				    </div>	
				    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Image</label>
                      <div class="form-group">
						<div class="input-group input-group-file" data-plugin="inputGroupFile">
						  <input type="text" class="form-control" readonly="">
						  <span class="input-group-append">
							<span class="btn btn-success btn-file">
							  <i class="icon md-upload" aria-hidden="true"></i>
							  <input type="file" name="image" multiple="">
							</span>
						  </span>
						</div>
						<?php if(!empty($product_detail[0]['photo'])){?>
							<img id="img_1" src="<?php echo base_url('images/product/thumb/'.$product_detail[0]['photo']); ?>" width="50px;" style="margin-top:2px;" />
						  <?php }else{?>
						  <img id="img_1" class="img-fluid" src="<?php echo base_url('global/product/no-product-image.jpg');?>" width="50px;" style="margin-top:2px;">
						  <?php }?>
					  </div>
					 
                    </div>
                  </div>
				  
				  
				  <div class="form-group  row" data-plugin="formMaterial">

				  	 <div class="col-md-6">
                      <?php $description_value = (isset($description) && $description!='')?$description:$product_detail[0]['description'];?>
					  <label class="form-control-label" for="inputGrid1">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="3"><?php if(isset($description_value)) echo $description_value;?></textarea>
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