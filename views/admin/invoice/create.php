<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<link rel="stylesheet" href="<?php echo base_url('assets/selectbox_isd_code/build/css/intlTelInput.css');?>">
	<style>
		.new_appoint{
		font-size: 24px;
		text-transform: capitalize;
		font-weight: 300;
		color: #fff; 
		text-align:center;
		background-color: #00B3F0;
		margin: 0px;
		padding: 10px 0px;
		} 
		.close {
		position: absolute;
		right: 32px;
		color: #fff;
		top: 10px;
		width: 32px;
		height: 32px;
		opacity: 0.3;
		}
		.close:hover {
		opacity: 1;
		}
		.close:before, .close:after {
		position: absolute;
		left: 15px;
		content: ' ';
		height: 28px;
		width: 2px;
		background-color: #333;
		}
		.close:before {
		transform: rotate(45deg);
		}
		.close:after {
		transform: rotate(-45deg);
		}
		.no-color{
		color: inherit;
		text-decoration: none;
		}
		.no-color:hover{
		color: inherit;
		text-decoration: none;
		}
		.hr{
		padding: 0px;
		margin-top: 10px;
		margin-bottom: 0px;
		}
		.full-border{
		border:1px solid #000;
		border-radius: 50%;
		width: 25px;
		height: 25px;
		display:inline-block;
		}
		.circle{
		text-align: center;
		margin: 25px;
		}
		.form-control-label{
		font-family: Roboto,sans-serif;
		font-weight: 400;
		}
		.glassicon {
		box-sizing: border-box;
		border: 1px solid #ccc;
		border-radius: 4px;
		font-size: 16px;
		background-color: white;
		background-image: url('../../uploads/searchicon.png');
		background-position: 10px 10px;
		background-repeat: no-repeat;
		padding: 12px 20px 12px 40px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
		background-size: 30px 30px;
		margin-top: 15px;
		margin-left: 18%;
		width: 80%;
		}
		.glassicon:focus {
		width: 80%;
		}
		.button {
		border: none;
		color: white;
		padding: 10px 24px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 14px;
		margin: 3px 4px;
		cursor: pointer;
		border-radius: 25px;
		float: right;
		}
		.button1 {
		border: none;
		color: white;
		padding: 10px 24px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 14px;
		margin: 3px 15px;
		cursor: pointer;
		border-radius: 25px;
		float: right;
		}
		.intl-tel-input{
		display:block;
		}
		.avl_error{
		background-color: #EBF5FD;
		color: #00B3F0;
		border:1px solid #00B3F0;
		border-radius: 2px;
		padding-left: 10px;
		}
		.service_row{
		border: 1px solid #F7F7F8;
		padding: 24px 24px  10px 24px;
		border-radius: 3px;
		box-shadow: 0 2px 5px 0 #DEE3E7;
		margin-bottom: 20px;
		}
		.remove_row{
		position: absolute;
		right: 18px;
		margin-top: -18px;
		color: maroon;
		font-size: 17px;
		cursor: pointer;
		}
		.add-more{
		padding: 10px;
		box-shadow: 0 2px 5px 0 #DEE3E7;
		cursor: pointer;
		text-align: center;
		margin-bottom: 15px;
		font-size: 18px;
		color: #333;
		text-transform: capitalize;
		border-bottom: 2px solid #00B3F0;
		}
		.extra_time_before{
		margin-bottom: 15px;
		font-size: 18px;
		color: #00B3F0;
		}
		.create_client{
		color: grey;  
		}
		.create_client:hover{
		text-decoration: none;
		color: #00B3F0;
		}
		.total{
		margin-top: 27px;
		}
		.client_details .dropdown{
		display: none;
		}
	</style>
	<style type="text/css">
		.popover-body{padding:20px 10px; }
		.voucher-error{color: maroon;}
	</style>
	<div class="page">
		<div class="page-content container-fluid">
			<div class="row">
				<div class="col-md-12">
					<!-- Panel Static Labels -->
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Create New Invoice</h3>
							<div class="page-header-actions"><a href="<?php echo base_url('admin/invoice');?>"><button type="button" class="btn btn-block btn-primary">All Invoices</button></a></div>
						</div>
						
						<div class="clientform" style="display:none; margin-top:0px;">
							<div class="row">
								<p style="width: 100%;text-align: center;margin-top: 15px;font-size: 18px;">Client Detail</p>
							</div>
							<div class="row" style="margin-left: 100px; margin-right: 100px;">
								<div class="col-md-12" style="background-color: #c9d5da54;box-shadow: 0 0 4px #DEE3E7;padding: 15px 15px 15px 15px;">
									<div class="row" style="float: right;">
										<a href="javascript:void(0);" onclick="closeclientdetail();" style="color: #000;"><i class="fa fa-close" style="font-size:24px;    margin-right: 10px;"></i></a>
									</div>
									<form id="client_form" onsubmit="return addNewClient()">
										<div class="row" style="padding-top: 25px;">
											<div class="col-md-6">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid2">First Name*</label>
													<input type="text" required="required" class="form-control" name="first_name" autocomplete="off">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid2">Last Name*</label>
													<input type="text" required="required" name="last_name" class="form-control" autocomplete="off">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid2">Email*</label>
													<input type="email" required="required" class="form-control" name="email" autocomplete="off">
												</div>
											</div>
											<div class="col-md-6">
												<label class="form-control-label" for="inputGrid1">Mobile Number*</label>
												<div><input id="demo" type="text" required="required" class="form-control" value="" name="mobile">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="float col-md-12">
												<button class="button"  type="submit" style="background-color: #26C6DA; ">Save</button>
												<button class="button" onclick="closeclientdetail()">Cancel</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						
						
						<form method="post" action="<?= base_url('admin/invoice/save_invoice/'.$booking_id) ?>">
							<input type="hidden" name="action" value="save">
							<div class="panel-body container-fluid">
								<div class="form-group  row">
									<input type="hidden" name="business_id" value="<?= $admin_session['business_id']; ?>">
									<div class="col-md-6">
										<label>Choose Location</label>
										
										<?php $admin_session = $this->session->userdata('admin_logged_in');
											if ($admin_session['role']=='location_owner' ) {
											?>
											<input type="text" class="form-control"  value="<?= getLocationNameById($admin_session['location_id'])?>" readonly>
											<input type="hidden" class="form-control" name="location_id" id="location_id" value="<?php echo $admin_session['location_id'] ?>">
											
											<?php }
											else{
											?>
											<select data-plugin="select2" required="required" class="form-control" name="location_id" id="location_id">
												<!-- <option value="">Select Location</option> -->
												<?php if(isset($locations)){?>
													<?php foreach($locations as $loc){?>
														<option value="<?php echo $loc['id'];?>" <?php if(isset($location_id) && $location_id==$loc['id']) echo "selected"; ?>><?php echo $loc['location_name'];?></option>
													<?php } } ?>
											</select>
											
										<?php }?>
										
										
										
										
									</div>
									
									<div class="col-md-2" style="margin-top: 2%;">
										<a href="javascript:void(0);" class="create_client" onclick="client_form();"><strong><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Create new Client</strong></a>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-6 customber_invoice">
										<label>Invoice To</label>
										
										<select  class="form-control customer_id" onchange="selectCustomer(this.value)" data-placeholder="Choose Customer" data-plugin="select2" name="customer_id" id="customer_id">
											<option value=""></option>
											
											<?php foreach ($customers as $key => $value):
												$selected = ($customer==$value['id'])?"selected":"";
											?>
											<?php if ($value['country_code']!='') {
												$mobile_number='+'.$value['country_code'].' '.$value['mobile_number'];
											}
											else{
												$mobile_number= $value['mobile_number'];
											}
											
											?>
											<option <?=$selected?> value="<?=$value['id'];?>"><?= $value['first_name']." ".$value['last_name']." ( ".$mobile_number." )"; ?></option>
											<?php endforeach ?>
										</select>
										<span class="text-danger customer-error"></span>
										<div class="admin_content_error"><?php echo form_error('customer_id'); ?></div>
									</div>
									<div class="col-md-12">
										<div class="client_details"></div>
									</div>
									<div class="col-md-3">
										<label>Invoice date</label>
										<input type="text" class="form-control datep" name="" value="<?= date("m/d/Y")?>">
									</div>
									<div class="col-md-3">
										<label>Due date</label>
										<input type="text" class="form-control datep" name="" value="<?= date("m/d/Y")?>">
									</div>
								</div>
								<table class="table">
									<thead>
										<th><b>Item/Description</b></th>
										<th width="200"><b>Staff</b></th>
										<th width="100"><b>Quantity</b></th>
										<th width="120"><b>Unit Price</b></th>
										<th><b>Tax</b></th>
										<th width="120"><b>Total</b></th>
										<th width="50"></th>
									</thead>
									<tbody>
										<?php
											$i=0;
											if(isset($_SESSION['invoice'])):
											foreach ($_SESSION['invoice'] as $key => $value):
											if(isset($value['tax_price'])){
												$tax_price = $value['tax_price'];
												$total_price = $value['total_price'];
												}else{
												$tax_price = 0;
												$total_price = $value['unit_price'];
											}
										?>
										<tr class="remove_<?=$i;?>">
											<td><?= $value['type']." / ".$value['title']; ?>
												<input type="hidden" name="<?=$value['type']?>[<?=$i?>][id]" value="<?=$value['id']?>">
											</td>
											<td>
												<select name="<?=$value['type']?>[<?=$i?>][staff]" data-plugin="select2" class="form-control" required="required">
													<option value="">Choose a Staff...</option>
													<?php foreach ($staff_data as $kkey => $vvalue): ?>
													<option value="<?= $vvalue['id']; ?>"><?= $vvalue['first_name']." ".$vvalue['last_name']; ?></option>
													<?php endforeach ?>
												</select>
											</td>
											<td>1.0<input type="hidden" class="quantity_<?=$i?>" min="1" name="<?=$value['type']?>[<?=$i?>][qty]" value="1" class="form-control"></td>
											<td><input onchange="changeUnitPrice(this.value,<?=$i?>)" type="text" class="form-control" name="<?=$value['type']?>[<?=$i?>][unit_price]" value="<?=$value['unit_price']?>"></td>
											<td>
												<?php 
													if(isset($value['is_gst']) && $value['is_gst']==1){
														$gst = 1;
														echo "GST";
														}else{
														echo "NA";
														$gst = 0;
													}
												?>
												<input type="hidden" class="is_service_tax_<?=$i?>" name="<?=$value['type']?>[<?=$i?>][is_service_tax]" value="<?=$gst?>">
												<input type="hidden" name="<?=$value['type']?>[<?=$i?>][tax_price]" value="<?=$tax_price?>" class="tax_price_<?=$i?> total_tax_price">
											</td>
											<td>
												<input  onchange="calculateTotalPrice()" value="<?=$total_price?>" type="text" class="form-control total_amount total_price_<?=$i?>" name="<?=$value['type']?>[<?=$i?>][total_price]">
											</td>
											<td><button type="button" onclick="removeThis(<?=$i?>,'<?=$key?>')" class="btn btn-icon btn-danger waves-effect waves-classic"><i class="icon md-delete"></i></button></td>
										</tr>
										<?php 
											$i++;
											endforeach;
											endif; 
										?>
										<?php if ($advance==1) { ?>
											<tr class="remove_0">
												<input type="hidden" name="advance" class="form-control" placeholder="Wallet Description" value="<?=$advance?>">
												<td><input type="text" name="wallet[0][title]" class="form-control" placeholder="Wallet Description" value="Wallet Deposit"></td>
												<td>
													N/A
												</td>
												<td>N/A</td>
												<td>N/A </td>
												<td>N/A</td>
												<td><input type="text" onchange="calculateTotalPrice()" name="wallet[0][total_price]" class="form-control total_price_0 total_amount" value="1"></td>
												
												<td><button type="button" onclick="removeThis(0)" class="btn btn-icon btn-danger waves-effect waves-classic"><i class="icon md-delete"></i></button></td>
											</tr>
											
										<?php } ?>
										
										
										<?php if(isset($booking_id) and $booking_id!="" and $advance!=1 ): ?>
										<?php 
											//gs($booking_services);
											$i=0;
											foreach ($booking_services as $key => $value): 
											$main_service_id = getmainServiceId($value['service_timing_id']);
											$is_service_tax = is_service_tax($main_service_id);
											$service_price = serviceprice($value['service_timing_id']);
											$tax_amt = getServiceTax($service_price,$business_details['tax_service_percent'],$business_details['tax_service_method']);
											if($business_details['tax_service_method']=="inclusive"){
												$total_price = number_format($service_price,2);
												$service_price = $service_price-$tax_amt;
												}else{
												$total_price = number_format($service_price+$tax_amt,2);
											}
										?>
										<tr class="remove_<?=$i;?>">
											<td>
												<?php echo getServiceNameByTiming($value['service_timing_id']).' - '.getCaptionName($value['service_timing_id']);?>                         
												<input type="hidden" name="service[<?=$i?>][service_id]" value="<?=$main_service_id?>" class="service_id_<?=$i?>">
												<input type="hidden" name="service[<?=$i?>][service_timing_id]" value="<?=$value['service_timing_id']?>" class="service_id_<?=$i?>">
											</td>
											<td>
												<select name="service[<?=$i?>][staff]" class="form-control select" data-plugin="select2" required="required">
													<option value="">Choose a Staff...</option>
													<?php foreach ($staff_data as $kkey => $vvalue): 
														$selected = ($vvalue['id']==$value['staff_id'])?"selected":"";
													?>
													<option <?=$selected;?> value="<?= $vvalue['id']; ?>"><?= $vvalue['first_name']." ".$vvalue['last_name']; ?></option>
													<?php endforeach ?>
												</select> 
											</td>
											<td>1.0<input type="hidden" min="1" name="service[<?=$i?>][qty]" value="1" class="form-control quantity_<?=$i?>">
												
											</td>
											<td>
												<input type="text" onchange="changeUnitPrice(this.value,<?=$i?>)" class="form-control unit_price_<?=$i?>" min="0" name="service[<?=$i?>][unit_price]" value="<?=$service_price?>">
												<input type="hidden" value="<?=$service_price?>" class="original_price_<?=$i?>">
											</td>
											<td><!-- <span class="is_service_tax_<?=$i?>">N/A</span> -->
												<input type="hidden" class="is_service_tax_<?=$i?>" value="<?=$is_service_tax?>" name="service[<?=$i?>][is_service_tax]">
												<?php if($is_service_tax==0): ?>
												<input type="text" disabled="disabled" name="service[<?=$i?>][tax_price]" value="0" class="tax_price_<?=$i?> total_tax_price form-control" style="width: 100px;">
												<?php else: ?>
												<input type="text" disabled="disabled" name="service[<?=$i?>][tax_price]" value="<?=$tax_amt?>" class="tax_price_<?=$i?> total_tax_price form-control" style="width: 100px;">  
												<?php endif; ?>  
												<input type="hidden" name="service[<?=$i?>][is_freebypackage]" value="0" class="is_freebypackage_<?=$i?>">
												<input type="hidden" name="service[<?=$i?>][invoice_package_services_id]" value="" class="invoice_package_services_id_<?=$i?>">
											</td>
											<td><input type="text" onchange="calculateTotalPrice()" name="service[<?=$i?>][total_price]" class="form-control total_price_<?=$i?> total_amount" value="<?=$total_price?>" name="total_price"></td>
											<td>
												
												<div class="btn-group">
													
													<button type="button" onclick="removeThis(<?=$i?>)" class="btn btn-icon btn-danger waves-effect waves-classic"><i class="icon md-delete"></i></button>&nbsp;
												<button type="button" style="display: none;" title="Available packages" class="btn btn-icon btn-info waves-effect waves-classic avail_package_btn_<?=$i;?>" data-toggle="popover" data-title="Redeem package" data-content=""><i class="icon md-dropbox"></i></button></div>
											</td>
										</tr>
										<?php $i++; endforeach ?>
										<?php endif; ?>                    
									</tbody>
									<tbody class="new_data">
										
									</tbody>
									<tbody>
										<tr>
											<td colspan="4"><div class="btn-group">
												<button type="button" onclick="addRow('product')" class="btn btn-sm btn-primary is_disable"><i class="fa fa-plus"></i>&nbsp;Product</button>
												<button type="button" onclick="addRow('service')" class="btn btn-sm btn-primary is_disable"><i class="fa fa-plus"></i>&nbsp;Service</button>
												<button type="button" onclick="addRow('package')" class="btn btn-sm btn-primary is_disable"><i class="fa fa-plus"></i>&nbsp;Package</button>
												<button type="button" onclick="addRow('class')" class="btn btn-sm btn-primary is_disable"><i class="fa fa-plus"></i>&nbsp;Class</button>
												<button type="button" onclick="addRow('service_group')" class="btn btn-sm btn-primary is_disable"><i class="fa fa-plus"></i>&nbsp;Service Group</button>
												
												<button type="button" onclick="addRow('wallet')" class="btn btn-sm btn-primary is_disable"><i class="fa fa-plus"></i>&nbsp;Wallet</button>
												
												<!-- <button type="button" onclick="addRow('credit')" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp;Credit</button> -->
											</div></td>
											<td style="vertical-align: middle;"><b>Includes tax of:</b></td>
											<td style="vertical-align: middle;"><b><span style="display: none;" class="full_total_tax">0</span></b>
												<input type="text" value="0" class="form-control full_total_tax" name="full_total_tax">
											</td>
											<input type="hidden" value="0" class="form-control full_total_price" name="full_total_price">
											<input type="hidden" value="0" class="form-control full_total_price_without_voucher" name="full_total_price_without_voucher">
											
										</tr>
										<?php if (isset($advance_total_amount) && $advance_total_amount>0 ) { ?>
											<tr> 
												<td colspan="4"></td>
												<td  style="vertical-align: middle;"><b>Advance Payment:</b></td>
												<td style="vertical-align: middle;">
													<input type="text" class="form-control advance_payment" name="advance_payment" value="<?=isset($advance_total_amount)?$advance_total_amount:0?>" readonly>
												</td>
											</tr>
										<?php } ?>
										
										
										
										
										<tr>
											<td colspan="4">
												<textarea placeholder="Notes Regarding this Invoice..." name="notes" class="form-control" rows="2"></textarea>
											</td>
											<td style="vertical-align: middle;"><b>Total : </b></td>
											<td colspan="2" style="vertical-align: middle;" colspan="3"><b><span class="full_total_price">0</span>&nbsp;</b>
												<button style="display: none;" onclick="addRow('discount')" type="button" data-toggle="tooltip" title="Apply a Discount" class="btn btn-icon btn-info waves-effect waves-classic discount-btn"><i class="icon md-scissors"></i></button>
												
												
												
												<button type="button" data-toggle="tooltip" title="Apply a Gift Voucher" class="btn btn-icon btn-info waves-effect waves-classic discount-btn">
													
													<i class="icon md-card-giftcard" data-toggle="popover" data-title="Apply a Gift Voucher" data-content='<div><div class="form-group control-group-value"><div class="controls"><label class="control-label">Gift voucher code</label><input class="form-control input-small gift-voucher-code-value form-control" type="text" value=""><div class="voucher-error"></div></div></div><div class="btn btn-group" style="padding:5px 0px;"><button onclick="closePopover()" type="button" id="close-btn" class="btn btn-sm bln-close"><i class="fa fa-times"></i> Cancel</button>&nbsp;&nbsp;&nbsp;<button onclick="getVoucher()" type="button" class="btn btn-primary btn-small apply-gift-voucher hide"><i class="fa fa-check"></i> Apply gift voucher</div></div>'>
														
													</i></button>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="row">
									<div class="col-md-8"></div>
									<div class="col-md-2">
										<a href="<?=base_url('/admin/invoice')?>" class="btn btn-default btn-block">Cancel</a>
									</div>
									<div class="col-md-2">
										<button type="submit" id="formSave" onclick="return submitInvoice()" class="btn btn-success btn-block is_disable_btn">Save</button>
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
	<!-- End Page -->
	<script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
	<script type="text/javascript">
		var currentDate = new Date();
		$(document).ready(function(){
			
			
			//var full_total_price  = $(".full_total_price").val();
			// var total_price = parseFloat(parseFloat(full_total_price)-parseFloat(advance_payment)).toFixed(2);
			//   $(".full_total_price").val(total_price);
			
			
			
			
			$(".from_submit").hide();
			//$(".is_disable_btn").attr("disabled","disabled")
			
			var numItems = $('.md-delete').length;
			
			if(numItems>0){
				$(".is_disable_btn").removeAttr("disabled");
				}else{
				$(".is_disable_btn").attr("disabled","disabled");
			}
			
			selectCustomer(<?=$customer?>);
			// calculateTotalPrice();
			//calculateTotalTax();
			$("[data-toggle=popover]").popover({html: true});
			$('.datep').datepicker({
				todayHighlight:true,
				format:"dd/mm/yyyy"
			});
		})
		
		setTimeout(function(){
			var numItems = $('.md-delete').length;
			if(numItems>0){
				$(".is_disable_btn").removeAttr("disabled");
				}else{
				$(".is_disable_btn").attr("disabled","disabled");
			}
		}, 3000);
		
		var x = $('.md-delete').length;
		
		var tax_percentage = <?php echo $tax_percentage ?>;
		var global_tax_type = "<?php echo $tax_type ?>";
		
		function removeThis(id,key){  
			//alert(id+''+key);
			//var numItems = $('.md-delete').length;   
			
			//alert(numItems);
			// alert(x);
			Pace.restart();
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/invoice/remove_session_item/' + encodeURIComponent(key),
				datatype: 'json',
				beforeSend: function() {},
				success: function(data) {
					$(".remove_"+id).remove();
					calculateTotalPrice();
					calculateTotalTax();
					$('[data-toggle="tooltip"]').tooltip();
					var numItems = $('.md-delete').length;
					if(numItems>0){
						$(".is_disable_btn").removeAttr("disabled");
						}else{
						$(".is_disable_btn").attr("disabled","disabled");
					}
					// alert(numItems);
				}
			}); 
		}
		
		function addRow(type){
			var z = $('.md-delete').length;
			var sum = parseInt(x)+parseInt(z);
			// alert(sum);
			Pace.restart();
			var location_id = $("#location_id").val();
			//alert(x);
			if(type!=""){
				$.ajax({
					type: 'POST',
					url: site_url + 'admin/invoice/add_invoice_item/' + encodeURIComponent(type)+'/'+encodeURIComponent(sum)+'/'+encodeURIComponent(location_id),
					datatype: 'json',
					beforeSend: function() {},
					success: function(data) {
						//alert(data);
						$(".new_data").append(data);
						$('.select').select2();
						calculateTotalPrice();
						
						calculateTotalTax();
						$('[data-toggle="tooltip"]').tooltip(); 
						var numItems = $('.md-delete').length;
						if(numItems>0){
							$(".is_disable_btn").removeAttr("disabled");
							}else{
							$(".is_disable_btn").attr("disabled","disabled");
						}
						//alert(numItems);
					}
				}); 
			}
			x++;
		}
		
		function getProductData(product_id,count){
			// alert(count);
			Pace.restart();
			var is_gst = "";
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/invoice/get_product_data/' + encodeURIComponent(product_id),
				datatype: 'json',
				beforeSend: function() {},
				success: function(data) {
					data = JSON.parse(data)
					if(data.is_service_tax==1){
						is_gst = "GST";
						}else{
						is_gst = "N/A";
					}
					if(data.is_service_tax==1 && data.tax_percentage > 0 && data.tax_type=="exclusive"){
						var tax_percentage = data.tax_percentage;
						var total_tax = parseFloat((data.retail_price*tax_percentage)/100).toFixed(2);
						var unit_price = data.retail_price
						var total_price = parseFloat(parseFloat(total_tax)+parseFloat(data.retail_price)).toFixed(2);
					}
					else if(data.is_service_tax==1 && data.tax_percentage > 0 && data.tax_type=="inclusive"){
						/*var tax_percentage = data.tax_percentage;
							var total_tax = (data.retail_price*tax_percentage)/100;
							var unit_price = parseFloat(data.retail_price)-parseFloat(total_tax);
						var total_price = parseFloat(total_tax)+parseFloat(unit_price);*/
						var tax_percentage = data.tax_percentage;
						var dvd = parseFloat(tax_percentage)+100;
						var unit_price = parseFloat((data.retail_price/dvd)*100).toFixed(2);
						var total_tax = parseFloat(data.retail_price-unit_price).toFixed(2);
						var total_price = parseFloat(parseFloat(total_tax)+parseFloat(unit_price)).toFixed(2);
						
						}else{
						var total_price = data.retail_price;
						var unit_price = data.retail_price;
						total_tax = 0;
					}
					$(".unit_price_"+count).val(unit_price);
					$(".original_price_"+count).val(data.retail_price);
					$(".tax_price_"+count).val(total_tax);
					$(".total_price_"+count).val(total_price);
					$(".is_service_tax_"+count).html(is_gst);
					$(".is_service_tax_"+count).val(data.is_service_tax);
					$(".tax_type_"+count).val(data.tax_type);
					calculateTotalPrice();
					calculateTotalTax();
					//$("[data-toggle=popover]").popover({html: true});
				}
			}); 
		}
		
		function getServiceData(service_timing_id,count){
			//alert(count);
			Pace.restart();
			var is_gst = "";
			var customer_id = $(".customer_id").val();
			//alert(customer_id);
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/invoice/get_service_data/' + encodeURIComponent(service_timing_id)+'/'+ encodeURIComponent(customer_id)+'/'+encodeURIComponent(count),
				datatype: 'json',
				beforeSend: function() {},
				success: function(data) {
					data = JSON.parse(data)
					if(data.is_service_tax==1){
						is_gst = "GST";
						}else{
						is_gst = "N/A";
					}
					if(data.is_service_tax==1 && data.tax_percentage > 0 && global_tax_type=="exclusive"){
						var tax_percentage = data.tax_percentage;
						var total_tax = parseFloat((data.special_price*tax_percentage)/100).toFixed(2);
						var unit_price = data.special_price;
						var total_price = parseFloat(parseFloat(total_tax)+parseFloat(data.special_price)).toFixed(2);
					}
					else if(data.is_service_tax==1 && data.tax_percentage > 0 && global_tax_type=="inclusive"){
						/*var tax_percentage = data.tax_percentage;
							var total_tax = (data.special_price*tax_percentage)/100;
							var unit_price = parseFloat(data.special_price)-parseFloat(total_tax);
						var total_price = parseFloat(total_tax)+parseFloat(unit_price);*/
						var tax_percentage = data.tax_percentage;
						var dvd = parseFloat(tax_percentage)+100;
						var unit_price = parseFloat((data.special_price/dvd)*100).toFixed(2);
						var total_tax = parseFloat(data.special_price-unit_price).toFixed(2);
						var total_price = parseFloat(parseFloat(total_tax)+parseFloat(unit_price)).toFixed(2);
					}
					else{
						
						var total_price = data.special_price;
						var unit_price = data.special_price;
						total_tax = 0;
					}
					$(".unit_price_"+count).val(unit_price);
					$(".original_price_"+count).val(data.special_price);
					$(".tax_price_"+count).val(total_tax);
					$(".total_price_"+count).val(total_price);
					$(".is_service_tax_"+count).html(is_gst);
					$(".is_service_tax_"+count).val(data.is_service_tax);
					$(".service_id_"+count).val(data.service_id);
					if(data.purchased_package_status=="available"){
						$(".avail_package_btn_"+count).show();
						$(".avail_package_btn_"+count).attr("data-content",data.content);
						$("[data-toggle=popover]").popover({html: true});
						}else{
						$(".avail_package_btn_"+count).hide();
					}
					if(data.free_for_customer==1){
						$(".free_service_btn_"+count).show();
						$(".free_service_btn_"+count).attr("data-content","<p>This customer can get "+data.percent+" % off on this service.</p><div class='btn btn-group'><button type='button' onclick='availFreeService("+count+","+data.percent+")' class='btn btn-primary'>Apply</button>&nbsp;<button type='button' onclick='closePopover()' class='btn btn-primary'>Cancel</button></div>");
						$("[data-toggle=popover]").popover({html: true});
						}else{
						$(".free_service_btn_"+count).hide();
					}
					$(".invoice_package_services_id_"+count).val("");
					$(".is_freebypackage_"+count).val(0);
					calculateTotalPrice();
					calculateTotalTax();
				}
			}); 
		}
		
		function availPackage(count){
			
			var invoice_package_services_id = $('input[name=invoice_package_services_id_'+count+']:checked').val();
			$(".invoice_package_services_id_"+count).val(invoice_package_services_id);
			$(".is_freebypackage_"+count).val(1);
			$(".unit_price_"+count).val(0);
			$(".total_price_"+count).val(0);
			$(".tax_price_"+count).val(0);
			calculateTotalPrice();
			calculateTotalTax();
			$("[data-toggle='popover']").popover('hide');
		}
		
		function availFreeService(count,percent){
			$(".is_freebypackage_"+count).val(2);
			var original_price = $(".original_price_"+count).val(); 
			var discount_amount = (original_price*parseFloat(percent))/100; 
			$(".unit_price_"+count).val(original_price-discount_amount);
			changeUnitPrice(original_price-discount_amount,count);
			calculateTotalPrice();
			calculateTotalTax();
			$("[data-toggle='popover']").popover('hide');
		}
		
		function getPackageData(package_id,count){
			Pace.restart();
			var is_gst = "";
			getPackageWiseServiceData(package_id,count);
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/invoice/get_package_data/' + encodeURIComponent(package_id),
				datatype: 'json',
				beforeSend: function() {},
				success: function(data) {
					data = JSON.parse(data)
					if(data.is_gst_tax==1){
						is_gst = "GST";
						}else{
						is_gst = "N/A";
					}
					if(data.is_gst_tax==1 && data.tax_percentage > 0 && global_tax_type=="exclusive"){
						var tax_percentage = data.tax_percentage;
						var total_tax = parseFloat((data.discounted_price*tax_percentage)/100).toFixed(2);
						var unit_price = data.discounted_price;
						var total_price = parseFloat(parseFloat(total_tax)+parseFloat(data.discounted_price)).toFixed(2);
					}
					else if(data.is_gst_tax==1 && data.tax_percentage > 0 && global_tax_type=="inclusive")
					{
						/*var tax_percentage = data.tax_percentage;
							var total_tax = (data.discounted_price*tax_percentage)/100;
							var unit_price = parseFloat(data.discounted_price)-parseFloat(total_tax);
						var total_price = parseFloat(total_tax)+parseFloat(unit_price);*/
						var tax_percentage = data.tax_percentage;
						var dvd = parseFloat(tax_percentage)+100;
						var unit_price = parseFloat((data.discounted_price/dvd)*100).toFixed(2);
						var total_tax = parseFloat(data.discounted_price-unit_price).toFixed(2);
						var total_price = parseFloat(parseFloat(total_tax)+parseFloat(unit_price)).toFixed(2);
						
					}
					else{
						var total_price = data.discounted_price;
						var unit_price = data.discounted_price;
						total_tax = 0;
					}
					$(".unit_price_"+count).val(unit_price);
					$(".tax_price_"+count).val(total_tax);
					$(".total_price_"+count).val(total_price);
					$(".is_service_tax_"+count).html(is_gst);
					$(".is_service_tax_"+count).val(data.is_gst_tax);
					calculateTotalPrice();
					calculateTotalTax();
				}
			}); 
		}
		
		function getClassData(class_id,count){
			Pace.restart();
			var is_gst = "";
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/invoice/get_class_data/' + encodeURIComponent(class_id),
				datatype: 'json',
				beforeSend: function() {},
				success: function(data) {
					data = JSON.parse(data)
					if(data.is_service_tax==1){
						is_gst = "GST";
						}else{
						is_gst = "N/A";
					}
					if(data.is_service_tax==1 && data.tax_percentage > 0 && global_tax_type=="exclusive"){
						var tax_percentage = data.tax_percentage;
						var total_tax = parseFloat((data.special_price*tax_percentage)/100).toFixed(2);
						var unit_price = data.special_price;
						var total_price = parseFloat(parseFloat(total_tax)+parseFloat(data.special_price)).toFixed(2);
					}
					else if(data.is_service_tax==1 && data.tax_percentage > 0 && global_tax_type=="inclusive"){
						/*var tax_percentage = data.tax_percentage;
							var total_tax = (data.special_price*tax_percentage)/100;
							var unit_price = parseFloat(data.special_price)-parseFloat(total_tax);
						var total_price = parseFloat(total_tax)+parseFloat(unit_price);*/
						
						var tax_percentage = data.tax_percentage;
						var dvd = parseFloat(tax_percentage)+100;
						var unit_price = parseFloat((data.special_price/dvd)*100).toFixed(2);
						var total_tax = parseFloat(data.special_price-unit_price).toFixed(2);
						var total_price = parseFloat(parseFloat(total_tax)+parseFloat(unit_price)).toFixed(2);
					}
					else{
						var total_price = data.special_price;
						total_tax = 0;
					}
					$(".unit_price_"+count).val(unit_price);
					$(".tax_price_"+count).val(total_tax);
					$(".total_price_"+count).val(total_price);
					$(".is_service_tax_"+count).html(is_gst);
					$(".is_service_tax_"+count).val(data.is_service_tax);
					$(".service_timing_id_"+count).val(data.id);
					calculateTotalPrice();
					calculateTotalTax();
				}
			}); 
		}
		
		function getDiscountData(discount_id,count){
			Pace.restart();
			var total_amount = $(".full_total_price").val();
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/invoice/get_discount_data/' + encodeURIComponent(discount_id)+'/'+encodeURIComponent(total_amount),
				datatype: 'json',
				beforeSend: function() {},
				success: function(data) {
					data = JSON.parse(data)
					$(".unit_price_"+count).val(parseFloat(data.calculated_discount_amount).toFixed(2));
					$(".total_price_"+count).val(parseFloat(data.calculated_discount_amount).toFixed(2));
					calculateTotalPrice();
				}
			}); 
		}
		
		function changeProductQty(qty,count){
			var is_service_tax = $(".is_service_tax_"+count).val();
			var unit_price = $(".unit_price_"+count).val();
			var total_price = unit_price*qty;
			if(is_service_tax==1 && global_tax_type=="exclusive"){
				var tax_amount = (total_price*tax_percentage)/100;
				var final_price = parseFloat(total_price)+parseFloat(tax_amount);
				$(".tax_price_"+count).val(tax_amount);
			}
			else if(is_service_tax==1 && global_tax_type=="inclusive"){
				// alert();
				/* var unit_price = $(".original_price_"+count).val();
					var total_price = unit_price*qty;
					var tax_amount = (total_price*tax_percentage)/100;
					var final_price = parseFloat(total_price);
				$(".tax_price_"+count).val(tax_amount);*/
				var uprice = $(".original_price_"+count).val();
				uprice  = uprice*qty;
				var dvd = parseFloat(tax_percentage)+100;
				var unit_price = parseFloat((uprice/dvd)*100).toFixed(2);
				var total_tax = parseFloat(uprice-unit_price).toFixed(2);
				var total_price = parseFloat(parseFloat(total_tax)+parseFloat(unit_price)).toFixed(2);
				$(".tax_price_"+count).val(total_tax);
				final_price = total_price;
			}
			else{
				final_price = total_price;
			}
			$(".total_price_"+count).val(final_price);
			calculateTotalPrice();
			calculateTotalTax();
		}
		
		function changeUnitPrice(price,count){
			var is_service_tax = $(".is_service_tax_"+count).val();
			var qty = $(".quantity_"+count).val();
			var total_price = qty*price;
			if(is_service_tax==1 && global_tax_type=="exclusive"){
				var tax_amount = (total_price*tax_percentage)/100;
				var final_price = parseFloat(parseFloat(total_price)+parseFloat(tax_amount)).toFixed(2);
				$(".tax_price_"+count).val(tax_amount);
			}
			else if(is_service_tax==1 && global_tax_type=="inclusive"){
				/*var tax_amount = 0;
					var final_price = parseFloat(total_price)+parseFloat(tax_amount);
				$(".tax_price_"+count).val(tax_amount);*/
				//uprice  = uprice*qty;
				var dvd = parseFloat(tax_percentage)+100;
				var unit_price = parseFloat((total_price/dvd)*100).toFixed(2);
				var total_tax = parseFloat(total_price-unit_price).toFixed(2);
				var total_price = parseFloat(parseFloat(total_tax)+parseFloat(unit_price)).toFixed(2);
				$(".tax_price_"+count).val(total_tax);
				final_price = total_price;
			}
			else{
				final_price = total_price;
			}
			$(".total_price_"+count).val(final_price);
			calculateTotalPrice();
			calculateTotalTax();
		}
		
		function calculateTotalPrice(){  
			//alert("hi");        
			var total = 0;
			var ftotal = 0;
			var total_amount_array = document.getElementsByClassName('total_amount');
			for (var i = 0; i < total_amount_array.length; i++){
				total = parseFloat(total) + parseFloat(total_amount_array[i].value);
				
				if (i== 0) {
					var advance_payment  = $(".advance_payment").val();
					var booking_total_amount  = <?=$booking_total_amount?>;
					var advance  = <?=$advance?>;  
					if (advance==1 && booking_total_amount<total) {
						swal("Error","Your advance payment greater than booking payment","error");
						return false;
					}
					if (advance_payment>0) {
						
						total = parseFloat(total)-parseFloat(advance_payment);
					}         
					
				}
				
				//alert(total);
			}
			for (var i = 0; i < total_amount_array.length; i++){
				if(total_amount_array[i].value > 0){
					// alert(total_amount_array[i].value);
					ftotal = parseFloat(ftotal) + parseFloat(total_amount_array[i].value);
					//alert(ftotal);
				}
			}
			
			
			
			var full_total_price = parseFloat(total).toFixed(2);
			if(full_total_price<0){
				full_total_price = 0;
			}
			$(".full_total_price").html(full_total_price);
			$(".full_total_price").val(full_total_price);
			$(".full_total_price_without_voucher").val(ftotal);
			if(total>0){
				$(".discount-btn").show();
				// $(".from_submit").show();
				}else{
				$(".discount-btn").hide();
				//$(".from_submit").hide();
			}
			
			
			
			
		}
		
		function calculateTotalTax(){
			
			// alert();
			var total_tax = 0;
			var total_tax_array = document.getElementsByClassName('total_tax_price');
			//console.log(total_tax_array);
			for (var i = 0; i < total_tax_array.length; i++){
				total_tax = parseFloat(total_tax) + parseFloat(total_tax_array[i].value);
			}
			$(".full_total_tax").html(parseFloat(total_tax).toFixed(2));
			$(".full_total_tax").val(parseFloat(total_tax).toFixed(2));
		}
		
		function closePopover(){
			$("[data-toggle='popover']").popover('hide');
		} 
		
		function getVoucher(){
		alert("here");
			Pace.restart();
			var success = true;
			$(".voucher-error").text("");
			var code = $(".gift-voucher-code-value").val();
			if(code==""){
				$(".voucher-error").text("The field could not be empty");
				}else{
				$.ajax({
					type: 'POST',
					url: site_url + 'admin/invoice/get_voucher_data/' + encodeURIComponent(code)+'/'+encodeURIComponent(x),
					datatype: 'json',
					beforeSend: function() {},
					success: function(data) {
						data = JSON.parse(data)
						if(data.type=="success"){
							var voucher_id_array = document.getElementsByClassName('voucher_ids');
							for (var i = 0; i < voucher_id_array.length; i++){
								if(data.voucher_id==voucher_id_array[i].value){
									success = false;
									break;
								}
							}
							if(success==true){
								$("[data-toggle='popover']").popover('hide');
								$(".new_data").append(data.data);
								x++;
								}else{
								$(".voucher-error").text("Gift voucher already applied to this invoice.");
							}
							}else{
							$(".voucher-error").text("No Voucher Found");
						}
						calculateTotalPrice();
						$('.select').select2();
					}
				}); 
			}
		}
		
		function submitInvoice(){
			// $("#formSave").attr('disabled','disabled');
			
			var full_total_price = $(".full_total_price").val();
			var service = $(".selectd_item").val();
			var staff = $(".selectd_staff").val();
			var customer_id = $(".customer_id").val();
			// alert(staff);
			if(full_total_price<0){
				swal("Error!", "Total cannot be less than zero", "error");
				return false;
			}
			if(service==''){
				swal("Error!", "Please choose any one Item", "error");
				$("#formSave").show();
				return false;
				}if(staff==''){
				$("#formSave").show();
				swal("Error!", "Please choose Staff", "error");
				
				return false;
			}
			
			if(customer_id=='' || customer_id<0){
				
				swal("Error!", "Please choose customer", "error");
				$("#formSave").show();
				return false;
			}
			
			$(".is_disable_btn").hide();
		}
		
		function selectCustomer(customer_id){
			if(!customer_id){
				$(".is_disable").attr("disabled","disabled")
				$(".customer-error").text("First select a customer to create invoice");
				}else{
				$(".is_disable").removeAttr("disabled")
				$(".customer-error").text("");
			}
			$(".new_data").html("");
			calculateTotalPrice();
			calculateTotalTax();
		}
		
		function client_form(){
			$('.clientform').css('display', 'block');
		}
		
		function closeclientdetail(){
			$('.clientform').css('display', 'none');
		}
		
		function addNewClient(){
			//Pace.restart(); 
			var location_id = $("#location_id").val(); 
			var formData = {
				'first_name'      : $('input[name=first_name]').val(),
				'last_name'       : $('input[name=last_name]').val(),
				'email'           : $('input[name=email]').val(),
				'mobile'          : $('input[name=mobile]').val()
			};
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/invoice/addNewClient/',
				data:{
					formData:formData,location_id:location_id
				},
				success: function(data)
				{
					closeclientdetail();          
					$('.customber_invoice').remove();
					$(".is_disable").removeAttr("disabled");
					
					$('input[name=first_name]').val('');
					$('input[name=last_name]').val('');
					$('input[name=email]').val('');
					$('input[name=mobile]').val('');
					$(".client_details").html(data);
					},error:function(){
					swal("Error","Could not add client, Please choose a location first","error");
				}
			});
			return false;
		}
		
		function getPackageWiseServiceData(package_id,count){
			$(".remove_"+count).remove();
			var count= count+1;
			var location_id = $("#location_id").val();
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/invoice/get_package_wise_service_data/' + encodeURIComponent(package_id)+'/'+encodeURIComponent(count)+'/'+encodeURIComponent(location_id),
				datatype: 'json',
				beforeSend: function() {},
				success: function(data) {
					$(".new_data").append(data);
					$('.select').select2();           
					calculateTotalPrice();
					calculateTotalTax();
				}
			}); 
		}
		
	</script>
	<?php $this->load->view('admin/common/footer'); ?>
	<script src="<?php echo base_url('assets/selectbox_isd_code/build/js/intlTelInput.js');?>"></script>
	<script>
		$("#demo").intlTelInput();
		// Get the extension part of the current number
		var extension = $("#demo").intlTelInput("getExtension");
		// Get the current number in the given format
		var intlNumber = $("#demo").intlTelInput("getNumber");
		// Get the type (fixed-line/mobile/toll-free etc) of the current number.
		var numberType = $("#demo").intlTelInput("getNumberType");
		// Get the country data for the currently selected flag.
		var countryData = $("#demo").intlTelInput("getSelectedCountryData");
		// Vali<a href="https://www.jqueryscript.net/time-clock/">date</a> the current number
		var isValid = $("#demo").intlTelInput("isValidNumber");
		// Load the utils.js script (included in the lib directory) to enable formatting/validation etc.
		$("#demo").intlTelInput("loadUtils", "<?php echo base_url('assets/selectbox_isd_code/build/js/utils.js');?>");
		// Change the country selection
		$("#demo").intlTelInput("selectCountry", "AU");
		// Insert a number, and update the selected flag accordingly.
		$("#demo").intlTelInput("setNumber", "+61 ");
	</script>
	<!-- <script type="text/javascript">
		$(function(){
		$('#formSave').one('click', function() {  
		$(this).attr('disabled','disabled');
		});
		});
	</script> -->	