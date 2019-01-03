<?php $this->load->view('admin/common/header'); ?>
 
<body class="animsition app-contacts page-aside-left">
<style type="text/css">
.modal-header .close{
	margin:0px;padding:0px;
}
.example-grid .example-col{
	margin-bottom: 5px;
}
</style>
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<div class="page">
		<?php $this->load->view('admin/common/header_messages'); ?>
		<!-- Contacts Content -->
		<div class="page-main">
			<div class="page-content">
				<!-- Panel Static Labels -->
				<div class="panel">
					<div class="page-header">
						<?php $this->load->view('admin/product/inventry_top'); ?>
						<div class="page-header-actions"><h3 class="panel-title">Add New Order</h3></div>
					</div>
					<div class="panel-body container-fluid" style="padding:0 30px;">
						
						<?php if($admin_session['role']=="owner"){?>
						<div class="form-group  row" data-plugin="formMaterial">
							<div class="col-md-6">
								<label class="form-control-label" for="inputGrid1">Business*</label>
								<select class="form-control" name="business_id" id="business_id" onChange="return get_business_supplier_locations(this.value)">
									<option value="">Select Business</option>
									<?php if($all_business){?>
									<?php foreach($all_business as $business){?>
									<option value="<?php echo $business['id'];?>" <?php if(isset($business_id) && $business_id==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
									<?php } } ?>
								</select>
								<div class="admin_content_error" id="error_business_id"><?php echo form_error('business_id'); ?></div>
							</div>
						</div>
						<?php } ?>
						
						<div class="form-group row" data-plugin="formMaterial">
							<div class="col-md-6">
								<label class="form-control-label" for="inputGrid1">Supplier Name*</label>
								<span id="content_supplier_id">
									<select class="form-control" name="supplier_id" id="supplier_id" onChange="get_supplier_data(this.value);">
										<option value="">Select Supplier</option>
										<?php if(isset($suppliers)){?>
										<?php foreach($suppliers as $supplier){?>
										<option value="<?php echo $supplier['id'];?>" <?php if(isset($supplier_id) && $supplier_id==$supplier['id']) echo "selected"; ?>><?php echo $supplier['first_name'].' '.$supplier['last_name'];?></option>
										<?php } } ?>
									</select>
								</span>
								<div class="admin_content_error" id="error_supplier_id"><?php echo form_error('supplier_id'); ?></div>
							</div>
							
							<div class="col-md-6">
								<label class="form-control-label" for="inputGrid1">Location*</label>
								<span id="content_location_id">
									
									<select class="form-control" name="location_id" id="location_id" onChange="fill_location_data(this.value);" >

								<?php if($admin_session['role']=="location_owner"){?>

								<?php $location_name = getLocationNameById($admin_session['location_id']); ?>
									
									<option value="<?php echo $admin_session['location_id'];?>" <?php echo "selected"; ?>><?php echo $location_name;?></option>
									
								
								<?php }else{ ?>
									
										<option value="">Select Location</option>
										<?php if(isset($locations)){?>
										<?php foreach($locations as $loc){?>
										<option value="<?php echo $loc['id'];?>" <?php if(isset($location_id) && $location_id==$loc['id']) echo "selected"; ?>><?php echo $loc['location_name'];?></option>
										<?php } } ?>
									
								<?php } ?>
								</select>
								</span>
								<div class="admin_content_error" id="error_location_id"><?php echo form_error('location_id'); ?></div>
							</div>
						</div>
						<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
							<!-- Actions -->
							<div class="input-group input-group-icon">
								<input class="form-control" name="product_search" id="product_search" placeholder="Search Product Name" type="text">
								<div class="input-group-append">
									<span class="input-group-text">
										<a href="<?php echo base_url('admin/product/add_product');?>" ><i class="icon md-plus-circle" aria-hidden="true"></i></a>
									</span>
									<span class="input-group-text">
										<a href="javascript:void(0);" data-target="#searchProducts" data-toggle="modal"><i class="icon md-search" aria-hidden="true"></i></a>
									</span>
								</div>
							</div><br>
							<form id="frm_records" name="frm_records" action="" method="post">
								<input type="hidden" name="action" id="action" value="1">
								<input type="hidden" name="product_counter" id="product_counter" value="0">
								<input type="hidden" name="total_quantity" id="total_quantity" value="0">
								<input type="hidden" name="sub_total" id="sub_total" value="0">
								
								<input type="hidden" name="supplier_id_val" id="supplier_id_val">
								<input type="hidden" name="location_id_val" id="location_id_val">
								<input type="hidden" name="business_id_val" id="business_id_val">
								<!-- Contacts -->
								<table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr" data-selectable="selectable" id="table_new_order">
									<thead>
										<tr>
											<th class="cell-100 dark-background-heading" scope="col">Product Name</th>
											<th class="cell-100 dark-background-heading" scope="col">Purchase Cost</th>
											<th class="cell-40 dark-background-heading" scope="col">Quantity</th>
											<th class="cell-40 dark-background-heading" scope="col">Product Tax</th>
											<th class="cell-30 dark-background-heading" scope="col">Sub Total</th>
											<th class="cell-50 dark-background-heading" scope="col">Delete</th>
										</tr>
									</thead>
									<tbody>
										<tr id="id_total" style="display:none;">
											<td class="cell-100" colspan="2">Total</td>
											<td class="cell-100 total_qty" id="total_qty">0</td>
											<td class="cell-40 total_tax" scope="col" id="total_tax">0.00</td>
											<td class="cell-50 total_subtotal" scope="col" id="total_subtotal">0.00</td>
											<td class="cell-50" scope="col"></td>
										</tr>
									</tbody>
								</table>
							</div>
							
							<div>
								<div class="form-group  row" data-plugin="formMaterial" id="id_note_section" style="display:none;">
									<div class="col-md-12">
										<label class="form-control-label" for="inputGrid1">Note</label>
										<textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
									</div>
								</div>
								
								<div class="form-group  row" data-plugin="formMaterial" id="id_submit_section" style="display:none;">
									<div class="col-md-6">
										<a href="javascript:void(0);" onClick="return submit_order('save');" class="btn btn-primary"> Save and Process  Now</a>
										&nbsp;&nbsp;
										<a href="javascript:void(0);" onClick="return submit_order('draft');" class="btn btn-success"> Save and Process Later 
</a>
									</div>
								</div>
							</div><br>
							
						</form>
					</div>
				</div>
				<!-- End Panel Static Labels -->
			</div>
		</div>
	</div>
	<!-- Contacts Content -->
	
</div>
</div>

<div class="modal fade" id="searchProducts" aria-hidden="true" aria-labelledby="searchProducts"
  role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		<h4 class="modal-title">Select Product</h4>
	  </div>
	  <div class="modal-body">
		<div class="example-grid">
		 <div  class="row">
		  <div class="col-xl-12 form-group">
			<input type="text" class="form-control" name="search_product" id="search_product" placeholder="Search Any Item" onkeydown="javascript:suggestProducts();" />
		  </div>		  </div>		  
		  <div  class="row" id="products_listing">
		  <?php foreach($all_products as $product){?>
		  <div class="col-lg-6" id="product-<?php echo $product['id']; ?>">		  
			  <a href="javascript:void(0);" onclick="javascript:add_product_in_order('<?php echo $product['product_name']; ?>');" style ="text-decoration:none;">
				<div class="example-col"><?php echo $product['product_name'];?></div>
			  </a>		  	  
		  </div>
		  <?php } ?>
		  </div>
		  
		</div>
	  </div>
	</div>
  </div>
</div>

	
<!-- End page -->
<script language="javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.js');?>"></script>
<script language="javascript" src="<?php echo base_url('assets/js/jquery.suggestion.product.js');?>"></script>
<script language="javascript">
var $jq = jQuery.noConflict();
$jq(document).ready(function(){

	var loc_id = $("#location_id").val();
	var sup_id = $("#supplier_id").val();
	$('#location_id_val').val(loc_id);
	$('#supplier_id_val').val(sup_id);

	<?php if($admin_session['role']=="owner"):?>
		var bus_id = $("#business_id").val();
		$("#business_id_val").val(bus_id);
	<?php endif ?>	

	//var supplier_id = $('#supplier_id').val();
	if($jq('#product_search').length)
	{
		$jq("#product_search").suggestion({
			url:base_url + "admin/Operations/suggestion_product?chars=",
			minChars:2,
			width:200,
		});
	}
		
});

function suggestProducts(){
	var chars = $('#search_product').val();
	if($.trim(chars).length >1){
		alert(chars);
		$.ajax({
			type: 'GET',
			url: site_url + 'admin/Operations/suggestion_product',
			data: 'chars='+chars,
			datatype: 'json',
			success: function(data){
				//alert(data);
				data = JSON.parse(data);			 
				//alert(JSON.stringify(data));
				var product_html = '';
				for(i=0;i< data.length; i++){
					product_html +='<div class="col-lg-6" id="product-'+i+'"><a href="javascript:void(0);" onclick="javascript:add_product_in_order(\''+$.trim(data[i])+'\');" style="text-decoration:none;"><div class="example-col">'+$.trim(data[i])+'</div></a></div>';
				}
				$('#products_listing').html(product_html);
			}
		});	
	}else{
		var product_html = '';
		<?php foreach($all_products as $product){?>
			product_html +='<div class="col-lg-6" id="product-<?php echo $product['id']; ?>"><a href="javascript:void(0);" onclick="javascript:add_product_in_order(\'<?php echo $product['product_name']; ?>\');" style="text-decoration:none;"><div class="example-col"><?php echo $product['product_name']; ?></div></a></div>';
		<?php } ?>
		$('#products_listing').html(product_html);	
	}
}

function add_product_in_order(product_val){
	$('#product_search').val(product_val);
	add_product_order_list();
}

function add_product_order_list() {
	
	var product_name = $('#product_search').val();
	if(product_name=='')
		return false;
	
	$.ajax({
		type: 'POST',
		url: site_url + 'admin/Operations/add_product_order_list',
		data: 'product_name='+encodeURIComponent(product_name),
		datatype: 'json',
		success: function(data)
		{
			//alert(data);
		data = JSON.parse(data);
			if (data.status == 'not_logged_in') {
				location.href= site_url + 'admin'
			}else if(data.status == 'success') {
				
				$('#product_search').val('');
				$("#table_new_order tbody").prepend(data.copyright_product_html);
				$('#product_counter').val(parseInt($('#product_counter').val()) + 1);
				
				var qty_count=0;
				var item_qty = document.getElementsByClassName('cls_qty');
				for (var i = 0; i < item_qty.length; i++){
					qty_count = parseInt(qty_count) + parseInt(item_qty[i].value);
				}
				if(qty_count>0){
					$("#id_total").show();
					$("#id_submit_section").show();
					$("#id_note_section").show();
				}else{
					$("#id_total").hide();
					$("#id_submit_section").hide();
					$("#id_note_section").hide();
				}
				
				$('#total_quantity').val(parseInt($('#total_quantity').val()) + 1);
				$('#total_qty').html(parseInt($('#total_quantity').val()));
				if(data.price!=''){
					$('#sub_total').val(parseInt($('#sub_total').val()) + parseInt(data.price));
					$('#total_subtotal').html(parseInt($('#sub_total').val()));
				}
				if(data.product_tax!=''){
					$('.total_tax').html(data.product_tax);
					
				}
				
			}
			change_price_data(1,data.product_id);			
			$('#searchProducts').modal('hide');
		}
	});
	
}
/*function change_price_data(qty_val,product_id){
	if(qty_val=='' || !$.isNumeric(qty_val))
		return false;
	
	var qty_count = 0;
	var gross_subtotal = 0;
	var item_qty = document.getElementsByClassName('cls_qty');
	var item_price = document.getElementsByClassName('cls_price');
	
for (var i = 0; i < item_qty.length; i++){
qty_count = parseInt(qty_count) + parseInt(item_qty[i].value);
		subtotal = parseInt(item_qty[i].value) * parseFloat(item_price[i].value);
		gross_subtotal = gross_subtotal + subtotal;
	}
	$('#product_price_'+product_id).html(parseInt(qty_val) * parseFloat($('#purchase_price_'+product_id).val()));
		$('#total_quantity').val(qty_count);
	$('#total_qty').html($('#total_quantity').val());
		$('#total_subtotal').html(gross_subtotal);
	
	if(qty_count>0){
		$("#id_submit_section").show();
		$("#id_note_section").show();
	}else{
		$("#id_submit_section").hide();
		$("#id_note_section").hide();
	}
	
}*/
function change_price_data(qty_val,product_id){
	if(qty_val=='' || !$.isNumeric(qty_val))
		return false;
	var item_qty = document.getElementsByClassName('cls_qty');
	var cls_tax = document.getElementsByClassName('cls_tax');
	var cls_subtotal = document.getElementsByClassName('cls_subtotal');
	var total_quantity = 0;
	var purchase_price = $("#purchase_price_"+product_id).val();
	var tax_type = $("#tax_type_"+product_id).val();
	var product_tax = $("#product_tax_"+product_id).val();
	//Calculate Product tax
	if(tax_type=="exclusive")
	{
		var total_purchase_price = purchase_price*qty_val;
		var total_tax_amount = (total_purchase_price*product_tax)/100;
		var subtotal = total_purchase_price+total_tax_amount;
	}else if(tax_type=="inclusive"){
		var total_purchase_price = purchase_price*qty_val;
		var total_tax_amount = (total_purchase_price*product_tax)/100;
		var subtotal = total_purchase_price+total_tax_amount;
	}else{
		var total_purchase_price = purchase_price*qty_val;
		var total_tax_amount = 0;
		var subtotal = total_purchase_price+total_tax_amount;
	}
	$(".product_tax_"+product_id).html(total_tax_amount);
	$("#purchase_tax_amt_"+product_id).val(total_tax_amount);
	$("#cls_subtotal_"+product_id).val(subtotal);
	$(".product_price_"+product_id).html(subtotal);
	var qty_count = 0;
	var tax_cal = 0;
	var sub_cal = 0;
	for (var i = 0; i < item_qty.length; i++){
	qty_count = parseInt(qty_count) + parseInt(item_qty[i].value);
	}
	for (var i = 0; i < cls_tax.length; i++){
	tax_cal = parseFloat(tax_cal) + parseFloat(cls_tax[i].value);
	}
	for (var i = 0; i < cls_subtotal.length; i++){
	sub_cal = parseFloat(sub_cal) + parseFloat(cls_subtotal[i].value);
	}
	$(".total_qty").html(qty_count);
	$(".total_tax").html(tax_cal);
	$(".total_subtotal").html(sub_cal);
	
}
function delete_row(product_id){
	$("#row_"+product_id).hide().remove();
	var qty_count = 0;
	var gross_subtotal = 0;
	var item_qty = document.getElementsByClassName('cls_qty');
	var item_price = document.getElementsByClassName('cls_price');
	
for (var i = 0; i < item_qty.length; i++){
qty_count = parseInt(qty_count) + parseInt(item_qty[i].value);
		subtotal = parseInt(item_qty[i].value) * parseFloat(item_price[i].value);
		gross_subtotal = gross_subtotal + subtotal;
	}
	//$('#product_price_'+product_id).html(parseInt(qty_val) * parseFloat($('#purchase_price_'+product_id).val()));
		$('#total_quantity').val(qty_count);
	$('#total_qty').html($('#total_quantity').val());
		$('#total_subtotal').html(gross_subtotal);
	
	if(qty_count>0){
		$("#id_total").show();
		$("#id_submit_section").show();
		$("#id_note_section").show();
	}else{
		$("#id_total").hide();
		$("#id_submit_section").hide();
		$("#id_note_section").hide();
	}
	
	change_price_data(1,product_id);
}
function submit_order(actionVal){
	
	if($('#business_id').length)
	{
		var business_id = $("#business_id").val();
		if(business_id==''){
			$('#error_business_id').html('Please select a business');
			return false;
		}else{
			$('#error_business_id').html('');
				}
	}
	
	var supplier_id = $("#supplier_id").val();
	if(supplier_id==''){
		$('#error_supplier_id').html('Please select supplier');
		return false;
	}else{
		$('#error_supplier_id').html('');
	}
	
	var location_id = $("#location_id").val();
	if(location_id==''){
		$('#error_location_id').html('Please select location');
		return false;
	}else{
		$('#error_location_id').html('');
	}
	$('#action').val(actionVal);
	document.frm_records.submit();
}

function get_supplier_data(supplier_id){
	if(supplier_id!=''){
		$('#error_supplier_id').html('');
	}
	$('#supplier_id_val').val(supplier_id);
}

function fill_location_data(location_id){
	$('#location_id_val').val(location_id);
}

function get_business_data(business_id){
	$('#business_id_val').val(business_id);
}

function get_business_supplier_locations(business_id) {
	
	if(business_id=='')
		return false;
	
	$('#business_id_val').val(business_id);
		
	$.ajax({
		type: 'POST',
		url: site_url + 'admin/Operations/get_business_supplier_locations/' + encodeURIComponent(business_id),
		datatype: 'json',
		success: function(data)
		{
		data = JSON.parse(data);
			if (data.status == 'not_logged_in') {
				location.href= site_url + 'admin'
			}else if(data.status == 'success') {
				$('#content_location_id').html(data.copyright_location_html);
				$('#content_supplier_id').html(data.copyright_supplier_html);
			}else {
				//alert('Something went wrong, please refresh page and try again');
			}
		}
	});	
}

</script>
<?php $this->load->view('admin/common/footer'); ?>