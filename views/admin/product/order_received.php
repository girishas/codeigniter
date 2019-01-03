<?php
$this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
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
				<!-- Contacts Content Header -->
				<div class="row">
					<div class="col-md-12">
						<!-- Panel Static Labels -->
						<div class="panel">
							<div class="page-header">
								<?php $this->load->view('admin/product/inventry_top'); ?>
								<div class="page-header-actions"><h3 class="panel-title">Order detail #<?php echo $data[0]['order_id'];?></h3></div>
							</div>
							<div class="panel-body container-fluid" style="padding:0 30px;">
								
								<div class="form-group row" data-plugin="formMaterial">
									<div class="col-md-6">
										<label class="form-control-label" for="inputGrid1" style="text-align:left;display:block;"><big>Supplier Detail</big></label>
										<span  style="float:left;text-align:left;">
											<?php 

											if (!empty($supplier_detail[0])) {
												echo '<strong> Supplier Name: </strong>'.$supplier_detail[0]['first_name'].' '.$supplier_detail[0]['last_name'];
												if(!empty($supplier_detail[0]['email'])){
													echo '<br/><strong>Email: </strong>'.$supplier_detail[0]['email'] ;
												}
												if(!empty($supplier_detail[0]['mobile_number'])){
													echo '<br/><strong>Mobile Number:</strong>'.$supplier_detail[0]['mobile_number'] ;
												}
													if(!empty($supplier_detail[0]['address1'])){
													echo '<br/><strong>Street/area:</strong>'.$supplier_detail[0]['address1'] ;
												}
													if(!empty($supplier_detail[0]['city'])){
													echo '<br/><strong>City:</strong>'.$supplier_detail[0]['city'] ;
												}
													if(!empty($supplier_detail[0]['state'])){
													echo '<br/><strong>State:</strong>'.$supplier_detail[0]['state'] ;
												}
													if(!empty($supplier_detail[0]['country_id'])){
													echo '<br/><strong>Country:</strong>'.$supplier_detail[0]['country_id'] ;
												}

											}
											



											elseif (!empty($warehouse_detail[0])) {
												echo '<strong> Warehouse Name:</strong>'.$warehouse_detail[0]['warehouse_name'];
												if(!empty($warehouse_detail[0]['phone_number'])){
													echo '<br/><strong>Phone Number:</strong>'.$warehouse_detail[0]['phone_number'] ;
												}
													if(!empty($warehouse_detail[0]['address1'])){
													echo '<br/><strong>Street/area:</strong>'.$warehouse_detail[0]['address1'] ;
												}
													if(!empty($warehouse_detail[0]['city'])){
													echo '<br/><strong>City:</strong>'.$warehouse_detail[0]['city'] ;
												}
													if(!empty($warehouse_detail[0]['state'])){
													echo '<br/><strong>State:</strong>'.$warehouse_detail[0]['state'] ;
												}
													if(!empty($warehouse_detail[0]['postcode'])){
													echo '<br/><strong>PostCode:</strong>'.$warehouse_detail[0]['postcode'] ;
												}
											}

											else{
												
											$location= getLocationData($order_location[0]['location_id']);

											echo '<strong> Location Name:</strong>'.$location['location_name'];
												if(!empty($location['phone_number'])){
													echo '<br/><strong>Phone Number:</strong>'.$location['phone_number'] ;
												}
													if(!empty($location['address1'])){
													echo '<br/><strong>Street/area:</strong>'.$location['address1'] ;
												}
													if(!empty($location['city'])){
													echo '<br/><strong>City:</strong>'.$location['city'] ;
												}
													if(!empty($location['state'])){
													echo '<br/><strong>State:</strong>'.$location['state'] ;
												}
													if(!empty($location['postcode'])){
													echo '<br/><strong>PostCode:</strong>'.$location['postcode'] ;
												}


											/*echo '<strong> Name: </strong>'. $location['location_name'];*/	

											}

												
											?>
										</span>
									</div>
									
									<div class="col-md-6">
										
											<?php 
											if (isset($location_detail[0])) {
												echo '<label class="form-control-label" for="inputGrid1" style="text-align:left;display:block;"><big>Recepient Detail</big></label>
										<span  style="float:left;text-align:left;">';

												echo '<strong> Location Name:</strong>'.$location_detail[0]['location_name'];
												if(!empty($location_detail[0]['phone_number'])){
													echo '<br/><strong>Phone Number:</strong>'.$location_detail[0]['phone_number'] ;
												}
													if(!empty($location_detail[0]['address1'])){
													echo '<br/><strong>Street/area:</strong>'.$location_detail[0]['address1'] ;
												}
													if(!empty($location_detail[0]['city'])){
													echo '<br/><strong>City:</strong>'.$location_detail[0]['city'] ;
												}
													if(!empty($location_detail[0]['state'])){
													echo '<br/><strong>State:</strong>'.$location_detail[0]['state'] ;
												}
													if(!empty($location_detail[0]['postcode'])){
													echo '<br/><strong>PostCode:</strong>'.$location_detail[0]['postcode'] ;
												}
											}

										elseif (!isset($location_detail[0]) && isset($warehouse_detail[0]) ) {
											echo '<label class="form-control-label" for="inputGrid1" style="text-align:left;display:block;"><big>Recepient  Detail</big></label>
										<span  style="float:left;text-align:left;">';

											echo '<strong> Warehouse Name:</strong>'.$warehouse_detail[0]['warehouse_name'];
												if(!empty($warehouse_detail[0]['phone_number'])){
													echo '<br/><strong>Phone Number:</strong>'.$warehouse_detail[0]['phone_number'] ;
												}
													if(!empty($warehouse_detail[0]['address1'])){
													echo '<br/><strong>Street/area:</strong>'.$warehouse_detail[0]['address1'] ;
												}
													if(!empty($warehouse_detail[0]['city'])){
													echo '<br/><strong>City:</strong>'.$warehouse_detail[0]['city'] ;
												}
													if(!empty($warehouse_detail[0]['state'])){
													echo '<br/><strong>State:</strong>'.$warehouse_detail[0]['state'] ;
												}
													if(!empty($warehouse_detail[0]['postcode'])){
													echo '<br/><strong>PostCode:</strong>'.$warehouse_detail[0]['postcode'] ;
												}



												
											}
											
											?>
										</span>
									</div>
								</div>
								<form id="frm_recordsss" name="frm_records" action="" method="post" enctype="multipart/form-data">
									<input type="hidden" name="action" id="action" value="1">
									<div class="form-group row" data-plugin="formMaterial">
										<div class="col-md-6">
											<label class="form-control-label" for="inputGrid1" style="text-align:left;display:block;">Received Order Ref No.</label>
											<input type="text" required="required" value="<?= $order[0]['order_ref_number'];?>" class="form-control" id="order_ref_number" name="order_ref_number">
										</div>
										<div class="col-md-6">
											<label class="form-control-label" for="inputGrid1" style="text-align:left;display:block;">Order Status</label>
											<select class="form-control" name="order_status" id="order_status" style="width:140px;display:inline;height;35px;">
												<!--   <option value="">Status</option>
												<option value="ordered" <?php //if($data[0]['status']=="ordered") echo "selected";?>>Ordered</option> -->
												<option value="3" <?php if($order[0]['status']=="2") echo "selected";?>>Received</option>
												<option value="2" <?php if($order[0]['status']=="3") echo "selected";?>>Partial Received</option>
											</select>
											<button class="btn btn-primary" type="button" onclick="getConfirm()">Save Order</button>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<br>
												<label class="control-label">Upload Document</label>
												<div class="input-group input-group-file" data-plugin="inputGroupFile">
													<input class="form-control" readonly="" type="text">
													<span class="input-group-append">
														<span class="btn btn-success btn-file waves-effect waves-classic">
															<i class="icon md-upload" aria-hidden="true"></i>
															<input name="document" type="file">
														</span>
													</span>
												</div>
											</div>
										</div>
									</div>
									<p style="font-size: 12px;color: #993535;">Note: You can modify product tax (Inclusive/Exclusive and Percentage) from product section. Here orders are calculating on the based of exclusive type.</p>
									<div id="contactsContent" class="page-content page-content-table">
										<!-- Contacts -->
										<table class="table is-indent" >
											<thead>
												<tr>
													<th class="cell-300 dark-background-heading" scope="col">Product Name</th>
													<th class="cell-50 dark-background-heading" scope="col">Purchase Cost</th>
													<th class="cell-50 dark-background-heading" scope="col">Ordered Qty</th>
													<th class="cell-50 dark-background-heading" scope="col">Received Qty </th>
													<th class="cell-50 dark-background-heading" scope="col">Discount (%)</th>
													<th class="cell-50 dark-background-heading" scope="col">Free Product</th>
													<th class="cell-50 dark-background-heading" scope="col">Sub Total</th>
													<th class="cell-50 dark-background-heading" scope="col">&nbsp;</th>
												</tr>
											</thead>
											<tbody>
												<?php if($data){?>
												<?php
												$dump_data = json_decode($order[0]['var_dump_received'],true);
												$total_qty = 0;
												$gross_total = 0;
												$total_tax = 0;
												$shipping = ($order[0]['shipping_cost'])?$order[0]['shipping_cost']:0;
												$i=0;
													foreach($data as $item){
													if($item['quantity']!=0)
												{
												$total_qty += $item['quantity'];
												}else{
												$total_qty += $item['ordered_qty'];
												}
													$sub_total = ($total_qty*$item['purchase_price']);

													if (isset($item['product_disount'])) {
														$product_disount=$item['product_disount'];
													}
													else{
														$product_disount=0;
													}

													if (isset($item['product_free_goods'])) {
														$product_free_goods=$item['product_free_goods'];
													}
													else{
														$product_free_goods=0;
													}

													if (isset($item['product_tax_amount'])) {
														$product_tax_amount=$item['product_tax_amount'];
													}
													else{
														$product_tax_amount=0;
													}

													$sub_total = $sub_total-$product_disount-$product_free_goods;
													$gross_total = $gross_total + $sub_total;
													$total_tax = $total_tax+ $product_tax_amount;
													$pre_gst = $gross_total+$shipping;
													$grand_total = $gross_total+$total_tax+$shipping;
												?>
												<tr>
													<?php $tax_class = "product_tax_".$item['id']; ?>
													<input type="hidden" value="<?php echo $item['id'] ?>" name="product_locationwise_id[]">
													<input type="hidden" class="<?php echo $tax_class; ?>" value="<?php echo $item['product_tax'] ?>" name="">
													<td ><?php echo getProductName($item['product_id']); ?></td>
													<td><input type="hidden" class="purchase_cost_<?= $item['id'] ?>" value="<?php echo $item['purchase_price']; ?>" name="purchase_cost[]">
													<span><?php echo $item['purchase_price']; ?></td></span>
													<td  ><?php
															if($item['quantity']!=0)
															{
																echo $quantity = $item['quantity'];
															}else{
																echo $quantity = $item['ordered_qty'];
															}
														?></td>
													<td scope="col">
														<?php
															if($item['quantity']!=0)
															{
																$quantity = $item['quantity'];
															}else{
																$quantity = $item['ordered_qty'];
															}
														?>
														<input  maxlength="4" class="quantity_<?php echo $item['id'];?>" onKeyUp="changePrice(<?= $item['id'] ?>)" value="<?php echo $quantity;?>" type="text" name="quantity[]" style="width:50px;">
													</td>
													<td scope="col">
														<?php
														if (isset($item['product_disount'])) {
															$product_disount=$item['product_disount'];
														}
														else{
															$product_disount=0;
														}

															$discount_amount = $product_disount;
															$discount_percentage = $dump_data['discount'][$i];
														?>
														<input  maxlength="4" onkeyup="changePrice(<?= $item['id'] ?>)" type="text" class="discount_<?php echo $item['id'];?>" name="discount[]" style="width:50px;" value="<?= $discount_percentage; ?>" placeholder="0.00">
														<input type="hidden" value="<?= $discount_amount; ?>" name="discount_amount[]" class="discount_amount_<?php echo $item['id'];?>">
													</td>
													<td scope="col">
														<?php

														if (isset($item['product_free_goods'])) {
															$product_free_goods=$item['product_free_goods'];
														}
															$free_goods = $product_free_goods;
														?>
														<input  maxlength="4" onkeyup="changePrice(<?= $item['id'] ?>)" value="<?= $free_goods; ?>" type="text" class="free_<?php echo $item['id'];?>" name="free[]" style="width:50px;" placeholder="0.00">
													</td>
													<td  scope="col">
														<input type="hidden"  class="totalcost_<?= $item['id'] ?> totalcost" value="<?= $sub_total; ?>" name="total_cost[]">
														<input type="hidden" class="tax_amount_<?= $item['id'] ?> total_tax_amount"
														value="<?= $item['product_tax_amount'] ?>" name="tax_amount[]">
														<span class="total_<?= $item['id'] ?>"><?php echo $sub_total;?></span>
													</td>
													<td>&nbsp;</td>
												</tr>
												<?php $i++;}?>
												<tr>
													<td  colspan="2">Total</td>
													<td  ><?php echo $total_qty; ?></td>
													<td   scope="col"></td>
													<td   scope="col"></td>
													<td scope="col">Sub Total</td>
													<td scope="col">
														<input type="hidden" class="sub_total" value="<?php echo $gross_total;?>" name="gross_total">
														<span id="sub_total_val"><?php echo $gross_total;?></span></td>
														<td>&nbsp;</td>
													</tr>
													<?php }?>
													<tr>
														<td  colspan="5">&nbsp;</td>
														<td  scope="col">Shipping</td>
														<td  ><input type="text" onkeyup="changeShipping(this.value)" with="50" name="shipping" value="<?= $shipping; ?>" placeholder="0.00" id="shipping"></td>
														<td   scope="col"></td>
														
													</tr>
													<tr>
														<td  colspan="5">&nbsp;</td>
														<td  scope="col">Pre GST</td>
														<td><input type="hidden" value="<?= $gross_total+$shipping;;?>" class="pre_gst" name="pre_gst"><span class="pgst"><?= $gross_total+$shipping;?></span></td>
														<td   scope="col"></td>
														
													</tr>
													<tr>
														<td  colspan="5">&nbsp;</td>
														<td  scope="col">Total GST (USD)</td>
														<td><input type="text" onkeyup="changeGst(this.value)" class="ttax" value="<?= $total_tax; ?>" with="50" name="total_tax" id="ttax"></td>
														<td   scope="col"></td>
														
													</tr>
													<tr>
														<td colspan="5">&nbsp;</td>
														<td scope="col">Grand Total</td>
														<td><input type="hidden" value="<?= $grand_total;?>" class="pmtotal" name="grand_total"><span class="pmtotall"><?= $grand_total;?></span></td>
														<td   scope="col"></td>
														
													</tr>
												</tbody>
											</table>
											
										</div>
										<div class="form-group  row" data-plugin="formMaterial" id="id_note_section">
											<label class="form-control-label" for="inputGrid1">Note</label>
											<textarea class="form-control" id="notes" name="notes" rows="3"><?php echo $dump_data['notes'] ?></textarea>
										</div>
										<br>
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
		<!-- End page -->
		<script language="javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.js');?>"></script>
		<script language="javascript" src="<?php echo base_url('assets/js/jquery.suggestion.product.js');?>"></script>
		<script language="javascript">
		function changePrice(product_id){
			var stotal = 0;
			var total_tax = 0;
			var sub_totall = document.getElementsByClassName('totalcost');
			var total_tax_amt = document.getElementsByClassName('total_tax_amount');
			var qty = $(".quantity_"+product_id).val();
			var discount = $(".discount_"+product_id).val();
			var free = $(".free_"+product_id).val();
			var tax = $(".product_tax_"+product_id).val();
			var purchase_price = $(".purchase_cost_"+product_id).val();
			var shipping = parseInt($("#shipping").val());
			var purchase_total = purchase_price*qty;
			var discount_amt = (purchase_total*discount)/100;
			var actual_price = purchase_total-discount_amt-free;
			var ctamt = (actual_price*tax)/100;
			$(".discount_amount_"+product_id).val(discount_amt);
			$(".tax_amount_"+product_id).val(ctamt);
			$(".total_"+product_id).text(actual_price);
			$(".totalcost_"+product_id).val(actual_price);
			for (var i = 0; i < sub_totall.length; i++){
			stotal = parseInt(stotal) + parseInt(sub_totall[i].value);
			}
			for (var i = 0; i < total_tax_amt.length; i++){
			total_tax = parseInt(total_tax) + parseInt(total_tax_amt[i].value);
			}
			var pre_gst = parseInt(stotal+shipping);
			$(".sub_total").val(stotal);
			$("#sub_total_val").text(stotal);
			$(".ttax").val(total_tax);
			$(".pgst").text(pre_gst);
			$(".pre_gst").val(pre_gst);
			var ttax = parseInt($(".ttax").val());
			var grand_total = parseInt(pre_gst+ttax);
			$(".pmtotall").text(grand_total);
			$(".pmtotal").val(grand_total);
			}
		function changeShipping(val){
			var sstotal = parseInt($(".sub_total").val());
			var pre_gst = parseInt(sstotal)+parseInt(val);
			$(".pgst").text(pre_gst);
			$(".pre_gst").val(pre_gst);
			var cttax = parseInt($(".ttax").val());
			var gt = parseInt(pre_gst)+parseInt(cttax);
			$(".pmtotall").text(gt);
			$(".pmtotal").val(gt);
		}
		function changeGst(val){
			var ppgst = $(".pre_gst").val();
			var grtotal = parseInt(ppgst)+parseInt(val);
			$(".pmtotall").text(grtotal);
			$(".pmtotal").val(grtotal);
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
						
					}
				}
			});
			
		}
		function change_price_data(qty_val,product_id){
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
			
			
		}
		function submit_order(){
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

		function getConfirm(){
			swal({
			title: "Are you sure?",
			text: "You want to save this order!",
			type: "info",
			showCancelButton: true,
			confirmButtonClass: "btn-info",
			confirmButtonText: 'Yes, Save it!',
			closeOnConfirm: false
			//closeOnCancel: false
			}, function () {
				/*swal({
					title: "Please Wait",
					text: "Process is going on...!",
					type: "success",
					showCancelButton: false,
					showConfirmButton: false,
					confirmButtonClass: "btn-info",
					confirmButtonText: 'Yes, Save it!',
					closeOnConfirm: false
				});*/
				$("#frm_recordsss").submit();
		});

		}
		</script>
		<?php $this->load->view('admin/common/footer'); ?>