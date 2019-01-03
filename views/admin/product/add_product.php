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
			  <?php $this->load->view('admin/product/inventry_top'); ?>
			  <div class="page-header-actions"><h3 class="panel-title">Add New Product</h3></div>
			</div>
			  <div class="panel-body pt-0 container-fluid">
                <form autocomplete="off" action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="action" value="save"> 
                  <?php if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){?>
				  <div class="form-group  row" data-plugin="formMaterial">
                    <?php if($admin_session['role']=="owner"){?>
					<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Business*</label>                      
				    <select class="form-control" name="business_id" id="business_id" onChange="return get_business_category_brand_suppliers(this.value)">
					  <option value="">Select Business</option>
						   <?php if($all_business){?>
						   <?php foreach($all_business as $business){?>
						   <option value="<?php echo $business['id'];?>" <?php if(isset($business_id) && $business_id==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
						   <?php } } ?>
					</select>
					<div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                    </div>
					<?php } ?>
				  </div>
				  <?php } ?>
				  				  
				  	  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Bar Code*</label>
                      <input type="text" class="form-control" id="bar_code" name="bar_code" value="<?php if(isset($bar_code)) echo $bar_code;?>">
					  <div class="admin_content_error"><?php echo form_error('bar_code'); ?></div>
                    </div>
                    
					<div class="col-md-6">
                       <label class="form-control-label" for="inputGrid1">SKU</label>
                      <input type="text" class="form-control" id="sku" name="sku" value="<?php if(isset($sku)) echo $sku;?>">
					  <div class="admin_content_error"><?php echo form_error('sku'); ?></div>
				    </div>		
				  </div>		  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Product Name*</label>
                      <input type="text" class="form-control" id="product_name" name="product_name" value="<?php if(isset($product_name)) echo $product_name;?>">
					  <div class="admin_content_error"><?php echo form_error('product_name'); ?></div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Category*</label>
                       <div class="form-group">
						<span id="content_category_id">
						<select class="form-control" id="category_id" name="category_id">
						  <option value="">Select Category</option>
						 <?php if(isset($categories)){?>
						<?php foreach($categories as $cat){?>
							<option value="<?php echo $cat['id'];?>" <?php if(isset($category_id) && $category_id==$cat['id']) echo "selected"; ?>><?php echo $cat['category_name'];?></option>
						<?php } } ?>
						</select>
						<div class="admin_content_error"><?php echo form_error('category_id'); ?></div>
						</span>
					  </div>
                    </div>
                  </div>
				  
				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Main Brand</label>
                      <div class="form-group">
						<span id="content_brand_id">
						<select class="form-control" onchange="getBrandSubcategory(this.value)" name="brand_category_id" id="brand_category_id">
						  <option value="">Select Brand</option>
						  <?php if(isset($brands)){?>
						  <?php foreach($brands as $brand){?>
							<option value="<?php echo $brand['id'];?>"><?php echo $brand['brand_name'];?></option>
						  <?php } } ?>
						</select>
						</span>
					  </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Supplier Name*</label>
                      <div class="form-group">
						<span id="content_supplier_id">
						<select class="form-control" name="supplier_id" id="supplier_id">
						  <option value="">Select Supplier</option>
						  <?php if(isset($suppliers)){?>
						  <?php foreach($suppliers as $supplier){?>
							<option value="<?php echo $supplier['id'];?>" <?php if(isset($supplier_id) && $supplier_id==$supplier['id']) echo "selected"; ?>><?php echo $supplier['supplier_company_name'];?></option>
						  <?php } } ?>
						</select>
						<div class="admin_content_error"><?php echo form_error('supplier_id'); ?></div>
						</span>
					  </div>
                    </div>
                  </div>
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Sub Brand</label>
                      <div class="form-group">
						<span id="content_brand_id">
						<select class="form-control" name="brand_id" id="brand_id">
						  
						</select>
						</span>
					  </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Color Code</label>
                      <div class="form-group">
						<span id="content_supplier_id">
						<input type="text" value="<?php if(isset($color_code)) echo $color_code;?>" class="form-control" name="color_code">
						<div class="admin_content_error"><?php echo form_error('color_code'); ?></div>
						</span>
					  </div>
                    </div>
                  </div>


                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Scale</label>
                      <div class="form-group">
						<span id="content_brand_id">
						<select class="form-control" name="scale" id="scale">
							<option value=""> Select Scale</option>
						  <?php if(count((array)$product_scale)>0){?>
						  <?php foreach($product_scale as $scale){?>
							<option value="<?php echo $scale['id'];?>"><?php echo $scale['product_scale'];?></option>
						  <?php } } ?>
						</select>
						</span>
					  </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Weight</label>
                      <div class="form-group">
						<span id="content_supplier_id">
						<input type="text" value="<?php if(isset($weight)) echo $weight;?>" class="form-control" name="weight">
						<div class="admin_content_error"><?php echo form_error('weight'); ?></div>
						</span>
					  </div>
                    </div>
                  </div>

				  
				 <div class="form-group  row" data-plugin="formMaterial">
				 	<div class="col-md-6">
				  		<label class="form-control-label">Product Tax Type</label>
				  		<select class="form-control" name="product_tax_type">
				  			<option value="exclusive">Exclusive</option>
				  			<option value="inclusive">Inclusive</option>
				  			<option value="notax">No Tax</option>
				  		</select>
				  	</div>
                    <div class="col-md-6">
				  		<label class="form-control-label">Product Tax Amount (%)</label>
				  		<input type="text" name="product_tax" class="form-control">
				  	</div>
                  </div>
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Base Price*</label>
                      <input type="text" class="form-control" id="purchase_price" name="purchase_price" value="<?php if(isset($purchase_price)) echo $purchase_price;?>">
					  <div class="admin_content_error"><?php echo form_error('purchase_price'); ?></div>
                    </div>
                      <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Retail Price*</label>
                      <input type="text" class="form-control" name="retail_price" id="retail_price" placeholder="0.00" value="<?php if(isset($retail_price)) echo $retail_price;?>">
					  <div class="admin_content_error"><?php echo form_error('retail_price'); ?></div>
                    </div>
					
					
				  </div>			 
				  
				  <div class="form-group  row" data-plugin="formMaterial">
				   <!-- <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Special Price</label>
                      <input type="text" class="form-control" id="special_price" name="special_price" placeholder="0.00"/>
                    </div> -->
                 
					<div class="col-md-6">
                       <label class="form-control-label" for="inputGrid1">Alert Quantity (Branch Wise)*</label>
                      <input type="text" class="form-control" id="alert_quantity" name="alert_quantity" value="<?php if(isset($alert_quantity)) echo $alert_quantity;?>">
					  <div class="admin_content_error"><?php echo form_error('alert_quantity'); ?></div>
				    </div>	
				    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Image</label>
						<div class="input-group input-group-file" data-plugin="inputGroupFile">
						  <input type="text" class="form-control" readonly="">
						  <span class="input-group-append">
							<span class="btn btn-success btn-file">
							  <i class="icon md-upload" aria-hidden="true"></i>
							 <input type="file" name="image" multiple="">
							</span>
						  </span>
						</div>
				    </div>
					
                    
                  </div>
				  
				  
				  
				  <div class="form-group  row" data-plugin="formMaterial">
				  	<div class="col-md-6">
				  		<label class="form-control-label">Uses Type</label>
				  		<select class="form-control" name="uses_type">
				  			<option value="1">Retail</option>
				  			<option value="2">Internal Use</option>
				  			<option selected="selected" value="3">Both</option>
				  		</select>
				  	</div>
				  	<div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="3"><?php if(isset($description)) echo $description;?></textarea>
                    </div>
				  </div>
					<div class="form-group  row" data-plugin="formMaterial">
						<div class="col-md-12">	
								<div class="col-md-6">					
							<div class="checkbox-custom checkbox-info">
                          <input type="checkbox" id="is_product_box" name="is_product_box"  autocomplete="off">
                          <label for="is_product_box">Is Product Box</label>
                        </div>							
						  </div>
						</div>
						</div>

				   <div id="product_box_types">
				   <div class="form-group  row" data-plugin="formMaterial">
				  	<div class="col-md-6">
				  		<label class="form-control-label">Product Unit</label>	  		
				  				<select class="form-control" data-plugin="select2" data-placeholder="Select Product unit" id="product_box_id" name="product_box_id" >
				  					<option value=""></option>
				  			<?php 
				  			if($product) {
										
										$disabled=null;
				  			foreach ($product as $key => $value) { 				  				
				  				?>
				  				<option value="<?=$value['id']?>"><?=$value['product_name']?></option>
				  			<?php } } ?>			  			
				  		</select>
				  	</div>				  	
				  </div>

				 
				  <div class="form-group  row" data-plugin="formMaterial">
				  		<div class="col-md-12">
							<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
								<table class="table table-hover dataTable table-striped w-full" >
									<thead>
										<th>Product Unit</th>
										<th>QTY PER Unit</th>							
										<th>Action</th>
									</thead>
									<tbody class="field_wrapper ">
										<tr class="addmore_div">				
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<hr/>
					</div>

					<div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6"><h3 class="panel-title" style="padding:0;">Locations</h3></div>
				 </div>	  
				
				 <?php if($admin_session['role']=="business_owner"){?>
					  <?php if($locations){?>
						  <?php $i=1;foreach($locations as $loc){
						  	
						  	?>
							  <div class="form-group  row" data-plugin="formMaterial">
								<div class="col-md-6">
								  <label class="form-control-label" for="inputGrid1"><?php echo $loc['location_name'];?> / Opening Stock Quantity </label>
								  <input type="hidden" class="form-control small" id="location_<?php echo $i;?>" name="location_id[]" value="<?php echo $loc['id'];?>">
								  <input type="text" class="form-control" id="quantity_<?php echo $i;?>" name="quantity[]">
								</div>
							  </div>
						  <?php $i++; } ?>
					  <?php } ?>
				  <?php }else{ ?>
				  		<div class="form-group  row" data-plugin="formMaterial">
						<div class="col-md-6">
						  <label class="form-control-label" for="inputGrid1">Opening Stock Quantity </label>
						  <input type="hidden" class="form-control small" name="location_id[]" value="<?php echo $admin_session['location_id'];?>">
						  <input type="text" class="form-control" name="quantity[]">
						</div>
					  </div>
				  <?php } ?>

				  <span id="content_multiple_locations"></span>


				   <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6"><h3 class="panel-title" style="padding:0;">Warehouse</h3></div>
				 </div>	  
				
				 <?php if($admin_session['role']=="business_owner"|| $admin_session['role']=="owner"){?>
					  <?php if($warehouse){?>
						  <?php $i=1;foreach($warehouse as $loc){
						  	
						  	?>
							  <div class="form-group  row" data-plugin="formMaterial">
								<div class="col-md-6">
								  <label class="form-control-label" for="inputGrid1"><?php echo $loc['warehouse_name'];?> / Opening Stock Quantity </label>
								  <input type="hidden" class="form-control small" id="warehouse_<?php echo $i;?>" name="warehouse_id[]" value="<?php echo $loc['id'];?>">
								  <input type="text" class="form-control" id="warehouse_quantity_<?php echo $i;?>" name="warehouse_quantity[]">
								</div>
							  </div>
						  <?php $i++; } ?>
					  <?php } ?>
				  <?php } ?>

				 
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
<script type="text/javascript">
	function getBrandSubcategory(id){
			$.ajax({
				type:"GET",
				url:site_url+"admin/product/getBrandsByCategory/"+encodeURIComponent(id),
				success:function(response){
					$("#brand_id").html(response);
				}
			});
		}
</script>

<script>
$(document).ready(function(){
	$("#product_box_types").hide();
	 $('input[id^="is_product_box"]').click(function () {
        if ($(this).prop('checked')) {
             $("#product_box_types").show();
        }
        else {
             $("#product_box_types").hide();
        }
      });



	$("#product_box_id").change(function(){
		var id = $(this).val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url("admin/Operations/getSingleProductUnit/"); ?>'+id,
			datatype: 'json',
			success: function(data)
			{
				var arr = [];
				arr = JSON.parse(data);
				$.each(arr, function (index, value) {					
					$(".field_wrapper").html('<tr class="addmore_div" ><td class=" cap">'+value["product_name"]+'<input type="hidden" name="box_product_id" value="'+value["id"]+'"></td><td class=" s_name"><input class="form-control" type="text" name="box_product_unit" value=""></td><td class=""><a href="javascript:void(0);" class="remove_button" title="Remove fields" id='+value["id"]+'><span class="glyphicon glyphicon-minus">Remove</span></a></td></tr>');
					$("#product_box_id option[value="+value['id']+"]").prop('disabled', true);
					$('select').select2();
				});
			}
		});
		 $(".field_wrapper").on('click', '.remove_button', function(e){ 
		 	e.preventDefault();
		 	$(this).parents('.addmore_div').remove();			
		 	$("#product_box_id option[value="+this.id+"]").prop('disabled', false);
		 	$('select').select2();
		 	return false;
	 	});		
	});
	$(".field_wrapper").on('click', '.remove_button1', function(e){ 
		e.preventDefault();
		$(this).parents('.addmore_div').remove();
		$("#pack_item option[value="+this.id+"]").removeAttr('disabled');
		$('select').select2();
		return false;
	});
});
</script>