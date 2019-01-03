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
										 
									</div>
									 
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
													$all_sub_total = ($total_qty*$item['purchase_price']);

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


													$sub_total = $all_sub_total-$product_disount-$product_free_goods;
													$gross_total = $gross_total + $sub_total;
													$total_tax = $total_tax+ $product_tax_amount;
													$pre_gst = $gross_total+$shipping;
													$grand_total = $gross_total+$total_tax+$shipping;
												?>
												<tr>
													<?php $tax_class = "product_tax_".$item['id']; ?>
													  
													<td ><?php echo getProductName($item['product_id']); ?></td>
													<td><span><?php echo $item['purchase_price']; ?></span></td>
													<td  ><?php
															if($item['quantity']!=0)
															{
																$quantity = $item['quantity'];
															}else{
																$quantity = $item['ordered_qty'];
															}
														?>
														<?php echo $quantity;?></td>
													<td scope="col">
														<?php
															if($item['quantity']!=0)
															{
																$quantity = $item['quantity'];
															}else{
																$quantity = $item['ordered_qty'];
															}
														?>
														<?php echo $quantity;?>
													</td>
													<td scope="col">
														<?php
														if (isset($item['product_disount'])) {
															$discount_amount = $item['product_disount'];
														}
														else{
															$discount_amount =0;
														}


															
															$discount_percentage = $dump_data['discount'][$i];
														?>
														<?= $discount_percentage?$discount_percentage:'0.00'; ?> 
														 
													</td>
													<td scope="col">
														<?php
														if (isset($item['product_free_goods'])) {
															$free_goods = $item['product_free_goods'];
														}
														else{
															$free_goods ='0.00';
														}
															
														?>
														<?= $free_goods?$free_goods:'0.00'; ?>
														
													</td>
													<td  scope="col">
														  
														<span class="total_<?= $item['id'] ?>"><?php
														if($item['quantity']>0)
															{
																$sub_quantity = $item['quantity'];
															}else{
																$sub_quantity = $item['ordered_qty'];
															}

														$subtotal=$sub_quantity*$item['purchase_price']; 
														echo $subtotal; ?></span>
													</td>
													<td  scope="col">&nbsp;</td>
												</tr>
												<?php $i++;}?>
												<tr>
													<td  colspan="2">Total</td>
													<td  ><?php echo $total_qty; ?></td>
													<td   scope="col"></td>
													<td   scope="col"></td>
													<td scope="col">Sub Total</td>
													<td scope="col">
														  <?php echo $gross_total;?> </td>
														  <td  scope="col">&nbsp;</td>
													</tr>
													<?php }?>
													<tr>
														<td  colspan="5">&nbsp;</td>
														<td  scope="col">Shipping</td>
														<td  ><?= $shipping; ?></td>
														<td   scope="col"></td>
														
													</tr>
													<tr>
														<td  colspan="5">&nbsp;</td>
														<td  scope="col">Pre GST</td>
														<td><?= $gross_total+$shipping;?></td>
														<td   scope="col"></td>
														
													</tr>
													<tr>
														<td  colspan="5">&nbsp;</td>
														<td  scope="col">Total GST (USD)</td>
														<td><?= $total_tax; ?></td>
														<td  scope="col"></td>
														
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
										
										<div class="form-group  row" data-plugin="formMaterial" id="id_note_section" style="margin-left:30px;">
											<label class="form-control-label" for="inputGrid1">Note</label>
											<textarea class="form-control" id="notes" name="notes" rows="3" readonly="readonly"> <?php echo $order[0]['notes']; ?></textarea>
											 
										</div>
										<?php if ($order[0]['status']==1) { ?>
										<div class="form-group  row" data-plugin="formMaterial">
											<div style="margin:25px;"><a href="<?php echo base_url('admin/product/order_received/'.$data[0]['order_id']);?>"><button type="button" class="btn btn-block btn-primary">Order Received</button></a></div>
										</div>
											
										 <?php } ?>

										 <?php if ($order[0]['status']==0) { ?>
										<div class="form-group  row" data-plugin="formMaterial">
											<div style="margin:25px;"><a href="<?php echo base_url('admin/product/edit_order/'.$data[0]['order_id']);?>"><button type="button" class="btn btn-block btn-primary">Edit Order</button></a></div>
										</div>
											
										 <?php } ?>
																						
									
																			
									 
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
		
		<?php $this->load->view('admin/common/footer'); ?>