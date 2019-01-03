<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
    <?php $this->load->view('admin/common/navbar'); ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
    <?php $this->load->view('admin/common/left_menubar'); ?>
    <!-- Page -->
	<style type="text/css">
		#radioBtn .notActive{
		color: #3276b1;
		background-color: #fff;
		}
		
		.alert-success {
		background-color: #e0f8ea!important;
		border-color: #bcf0d0!important;
		color: #229858!important;
		}.alert-warning {
		background-color: #fcf8e3!important;
		border-color: #fbeed5!important;
		color: #c09853!important;
		}
		.alert {
		padding: 8px 35px 8px 14px;
		margin-bottom: 24px;
		text-shadow: none;
		border: none;
		border-left: 5px solid #fbeed5;
		border-radius: 0;
		}
	</style>
    <div class="page">
        <!-- Alert message part -->
        <?php $this->load->view('admin/common/header_messages'); ?>
        <!-- End alert message part -->
        <!-- Contacts Content -->
        <div class="page-main">
            <div class="page-content">
                <div class="panel">
                    <!-- Contacts Content Header -->
                    <div class="panel-heading">
                        <h1 class="panel-title">View Invoice</h1>
                        <div class="page-header-actions">
                            <a href="<?php echo base_url('admin/invoice/create');?>"><button type="button" class="btn btn-block btn-primary">Add Invoice</button></a>
						</div>
					</div>
                    <div class="panel-body" id="printable">
						<?php 
                            $logo = getBusinessLogo($invoice_data['business_id']);
                            if($logo !=""):
						?>
						<img class="img-responsive" src="<?= base_url('images/staff/thumb/'.$logo); ?>" style="max-width: 150px;">
                        <?php endif ?>
                        <h2>
							<?php $business_name =  getBusinessNameById($invoice_data['business_id']);
								echo $business_name;
							?>
						</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="black">Invoice To : <a href="<?php echo base_url('admin/customer/detail/'.$invoice_data['customer_id']); ?>"><?= getCustomerNameById($invoice_data['customer_id']) ?></a></h4>
							</div>
                            <div class="col-md-6">
                                <h4 class="black">Tax Invoice #<?=$invoice_data['invoice_number'];?></h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <b class="black">Invoice Date</b><br>
                                        <?=date("D, d M Y",strtotime($invoice_data['date_created']));?>
									</div>
                                    <div class="col-md-6">
                                        <b class="black">Due date</b><br>
                                        <?=date("D, d M Y",strtotime($invoice_data['date_created']));?>
									</div>
								</div>
							</div>
						</div><br>
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <th><b class="black">Staff</b></th>
                                    <th class="text-center" ><b class="black">Type</b></th>
                                    <th class="text-right"><b class="black">Quantity</b></th>
                                    <th class="text-right"><b class="black">Unit price</b></th>
                                    <th class="text-right"><b class="black"><!-- Tax --></b></th>
                                    <th class="text-right"><b class="black">Total</b></th>
								</thead>
                                <tbody>
                                    <?php foreach ($invoice_services as $key => $value):
                                        if($value['pay_service_type'] !=8):
										//echo $value['pay_service_type']; 
										
									?>
                                    <tr>
                                        <td><span class="badge badge-round badge-dark">
                                            <?php if ($value['staff_id']>0) { ?>
                                               <?=getStaffName($value['staff_id'])?>
                                           <?php }
                                           else{
                                            echo "N/A";
                                           }
                                            ?>  
                                            </span></td>
                                        <td class="text-center"><?php 
											if($value['pay_service_type'] == 1){
												echo $payServiceTypeValue = payServiceType($value['pay_service_type']).' - '.getServiceNameByTiming($value['service_timing_id']).' '.$value['caption'];
											}

                                            elseif ($value['pay_service_type'] == 2 && $value['service_timing_id']>1) {
                                                 $payServiceTypeValue =  payServiceType($value['pay_service_type']);
                                                $ServiceName = getServiceNameByTiming($value['service_timing_id']).' '.$value['caption'];
                                                echo  $payServiceTypeValue.' - '.$ServiceName;
                                            } elseif ($value['pay_service_type'] == 3 ) {
                                                 $payServiceTypeValue =  payServiceType($value['pay_service_type']);
                                                $packageName = getPackageName($value['package_id']);
                                                echo  $payServiceTypeValue.' - '.$packageName;
                                            }elseif ($value['pay_service_type'] == 4 ) {
                                                 $payServiceTypeValue =  payServiceType($value['pay_service_type']);
                                                $ProductName = getProductName($value['product_id']);
                                                echo  $payServiceTypeValue.' - '.$ProductName;
                                            }else{
												echo $payServiceTypeValue =  payServiceType($value['pay_service_type']);
											} ?>
										<?php if($vouchar_details): ?>
										<a data-target="#VoucherModel" data-toggle="modal" href="javascript:void(0)">- (<?= $vouchar_details['voucher_code']?>)</a>
										<?php endif; ?>
                                        </td>
                                        <td class="text-right"><?=$value['service_qty']?></td>
                                        <td class="text-right"><?php echo ($value['pay_service_type']==7 or $value['pay_service_type']==8)?"-":""; ?>
										<?=number_format($value['service_unit_price'],2)?></td>
                                        <td class="text-right"><?=$value['tax_amount']?></td>
                                        <td class="text-right">
                                            <?php echo ($value['pay_service_type']==7 or $value['pay_service_type']==8)?"-":""; ?>
                                            <?=number_format($value['service_total_price'],2)?>
										</td>
									</tr>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-right" colspan="2"><b>Includes tax of</b></td>
                                        <td class="text-right"><b><?= number_format($invoice_data['tax_price'],2); ?></b></td>
									</tr>
                                    <tr>
                                        <td colspan="3" style="border:0px;"></td>
                                        <td class="text-right" colspan="2"><b>TOTAL</b></td>
                                        <!-- <td class="text-right"><b><?= $invoice_data['total_price']; ?></b></td> -->
                                        <td class="text-right"><b><?= number_format($invoice_data['total_price_without_voucher']-$invoice_data['discount_price'],2); ?></b></td>
									</tr>
                                    <?php if($invoice_data['used_voucher_id']!=""): ?>
									<tr>
                                        <td colspan="3" style="border:0px;"></td>
                                        <td class="text-right" colspan="2"><b>Voucher Applied</b></td>
                                        <td class="text-right" colspan="2"><b><?=getVoucherName($invoice_data['used_voucher_id']);?></b></td>
									</tr>   
                                    <?php endif; ?>
                                    <tr>
                                        <td colspan="3" style="border:0px;"></td>
                                        <td class="text-right" colspan="2"><b>Amount paid</b></td>
                                        <td class="text-right"><b><?= number_format($invoice_data['total_price']-$invoice_data['outstanding_invoice_amount'],2); ?></b></td>
									</tr>

                                    <?php if (isset($advance_total_price['total_price']) && $advance_total_price['total_price']>0 ) { ?>
                                    <tr>
                                        <td colspan="3" style="border:0px;"></td>
                                        <td class="text-right" colspan="2"><b>Advance Amount</b></td>
                                        <td class="text-right"><b><?=$advance_total_price['total_price'];?></b></td>
                                    </tr>                                       
                                   <?php } ?>
                                    <tr>
                                        <td colspan="3" style="border:0px;"></td>
                                        <td class="text-right" colspan="2"><b>Amount due</b></td>
                                        <td class="text-right"><b><?= ($invoice_data['outstanding_invoice_amount']>0)?number_format($invoice_data['outstanding_invoice_amount'],2):0; ?></b></td>
									</tr>
                                    <?php if($invoice_data['invoice_status']==3): ?>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td colspan="2" class="text-right"><b><span class="badge badge-round badge-success">Invoice paid in full</span></b></td>
									</tr>
                                    <?php endif ?>
								</tbody>
							</table>
						</div>
                        <div class="row">
                            <?php
								//  gs($invoice_payments);die;
								if(!empty($invoice_payments[0]['id'])):
							?>
                            <h3 class="black" style="width: 100%;">Payment</h3>
                            <ul>
                                <?php 
									
								foreach ($invoice_payments as $key => $value): ?>
                                <li class="black"><?=date("d M Y",strtotime($value['paid_date']));?>&nbsp;|&nbsp;<?=number_format($value['paid_amount'],2)?>&nbsp;|&nbsp;<?=getPayType($value['payment_type_id'])?></li>
                                <?php endforeach ?>

                                <?php if (isset($advance_total_price['total_price']) && $advance_total_price['total_price']>0) { ?>

                                  <li class="black"><?=date("d M Y",strtotime($advance_total_price['date_created']));?>&nbsp;|&nbsp;<?=number_format($advance_total_price['total_price'],2)?>&nbsp;|&nbsp;Advance</li>



                                <?php } ?>

							</ul>


                            <?php endif ?>
						</div>
                        <?php
							//gs($invoice_payments);die;
							if(!empty($refund_invoice_data[0]['id'])):
						?>
                        <div class="row">
                            <h3 class="black" style="width: 100%;">Refund</h3>
                            <ul>
                                <?php 
								foreach ($refund_invoice_data as $key1 => $value1): ?>
                                <li class="black"><?=date("d M Y",strtotime($value1['paid_date']));?>&nbsp;|&nbsp;<?=number_format($value1['paid_amount'],2)?>&nbsp;|&nbsp;<?=getPayType($value1['payment_type_id'])?></li>
                                <?php endforeach ?>
							</ul>
						</div>
						<?php endif ?>
                        <hr>
                        <div class="row">
                            <?php if($invoice_data['invoice_status']!=3 && $invoice_data['invoice_status']!=5): ?>
                            <div class="col-md-3">
                                <button class="btn btn-success btn-block" data-target="#exampleNiftyFadeScale" data-toggle="modal"><i class="icon md-badge-check"></i> Apply Manual Payment</button>
							</div>
                            <?php endif ?>
                            <div class="col-md-3">
                                <button data-target="#emailInvoice" data-toggle="modal"  class="btn btn-default btn-block"><i class="icon md-email"></i> Email Invoice</button>
							</div>
                            <div class="col-md-3">
                                <a target="_BLANK" href="<?php echo base_url('admin/invoice/invoice_pdf/'.$invoice_id) ?>" class="btn btn-default btn-block"><i class="icon md-print"></i> Print</a>
							</div>
							<?php if(!empty($invoice_data['booking_id'])){ ?>
							<div class="col-md-3">
                                <a href="<?php echo base_url('admin/service/calendar?&booking_id='.$invoice_data['booking_id']) ?>" class="btn btn-default btn-block"><i class="icon md-badge-check"></i> Re-Book</a>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- Modal -->
	
    <?php if($invoice_data['invoice_status']!=3): ?>
    <div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale" aria-hidden="true"
	aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-simple">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
                    <h4 class="modal-title"></h4>
				</div>
                <div class="modal-body">
                    <div class="alert dark alert-alt alert-info alert-dismissible" role="alert">
                        <h4>Invoice #<?=$invoice_data['invoice_number'];?></h4>
                        <p>The invoice total is <?=$invoice_data['total_price'] ?> and the amount outstanding is <?=$invoice_data['outstanding_invoice_amount'] ?></p>
					</div>
                    <form method="post"  onsubmit="return validateForm()">
                        <input type="hidden" name="action" value="save">
                        <input type="hidden" value="<?=$invoice_data['id'] ?>" name="invoice_id">
                        <input type="hidden" id="total_price" value="<?=$invoice_data['total_price'] ?>" name="total_price">
                        <input type="hidden" value="<?=$invoice_data['outstanding_invoice_amount'] ?>" name="outstanding_invoice_amount">
                        <input type="hidden" value="<?=$invoice_data['business_id'] ?>" name="business_id">
                        <input type="hidden" value="<?=$invoice_data['location_id'] ?>" name="location_id">
                        <input type="hidden" value="<?=$invoice_data['customer_id'] ?>" name="customer_id">
						<!--  <div class="form-group">
                            <label><b>Choose payment type</b></label>
                            <select required="required" name="payment_type_id" class="form-control">
							<option value="">Choose payment type</option>
							<?php foreach ($payment_types as $key => $value): ?>
							<option value="<?=$value['id']?>"><?=$value['name']?></option>
							<?php endforeach ?>
                            </select>
						</div> -->
						<div class="form-group">
							
							<div class="form-group">
								<label><b>Choose payment type</b></label>
								<div class="input-group">
									<div id="radioBtn" class="btn-group">
										<?php foreach ($payment_types as $key => $value) {
										?>
										
										<a class="btn btn-primary btn-sm notActive" data-toggle="payment_type_id" data-title="<?php echo $value['id'] ?>"><?php echo $value['name'] ?> </a>
										<?php  } ?>
									</div>
									<input type="hidden" name="payment_type_id" id="payment_type_id" readonly>
								</div>
								<div class="alert alert-danger payment_alert ">
									Please Choose payment type
								</div>

                            <div class="wallet_alert ">
                            <h4>  Your Wallet Amount is <?=getcustomerIdByCustomerWallet($invoice_data['customer_id']); ?> $ </h4>
                            </div>

							</div>
							
						</div>
						
						
                        <div class="form-group">
                            <label><b>Enter Amount</b></label>
                            <input type="text" class="form-control" value="<?=$invoice_data['outstanding_invoice_amount'] ?>" id="total_price" name="paid_amount">
						</div>
                        <div class="form-group">
                            <label><b>Payment processed by</b></label>
                            <select name="staff_id" id="staff_id" class="form-control" >
                                <option value="">Payment processed by</option>
                                <?php foreach ($staff_data as $key => $value): ?>
                                <option value="<?=$value['id']?>"><?= $value['first_name']." ".$value['last_name']; ?></option>
                                <?php endforeach ?>
							</select>
						</div>
                        <div class="form-group">
                            <label><b>Referances (Optional)</b></label>
                            <textarea class="form-control" name="notes" rows="3"></textarea>
						</div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <a data-dismiss="modal" class="btn btn-default btn-block">Cancel</a>
							</div>
                            <div class="col-md-3">
                                <button class="btn btn-success btn-block" id="submit" type="submit">Save</button>
							</div>
                            <div class="col-md-6"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    <?php endif ?>
    <?php if($vouchar_details && $voucher): ?>
    <div class="modal fade modal-fade-in-scale-up" id="VoucherModel" aria-hidden="true"
	aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-simple">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
                    <h4 class="modal-title"></h4>
				</div>
                <div class="modal-body">
                    <?php if($invoice_data['invoice_status']!=3): ?>
                    <div class="alert dark alert-alt alert-warning" role="alert">
                        <h4>Your gift voucher is not yet able to be used</h4>
                        <p>The gift voucher cannot be used until it is activated. Gift vouchers are activated when the associated invoice is fully paid. Apply a payment using the options below to finish activating this gift voucher.</p>
					</div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="col-sm-5 control-label big">Value</label>
                                <div class="col-md-7"><?=$vouchar_details['voucher_amount']?></div>
							</div>
                            <div class="form-group row">
                                <label class="col-sm-5 control-label big">Code</label>
                                <div class="col-md-7"><?=$vouchar_details['voucher_code']?></div>
							</div>
                            <div class="form-group row">
                                <label class="col-sm-5 control-label big">Status</label>
                                <div class="col-md-7"><span class="badge badge-warning">Not Paid</span></div>
							</div>
                            <div class="form-group row">
                                <label class="col-sm-5 control-label big">Invoice</label>
                                <div class="col-md-7">#<?=$invoice_data['invoice_number'];?></div>
							</div>
                            <div class="form-group row">
                                <label class="col-sm-5 control-label big">Expires</label>
                                <div class="col-md-7"><?=date("D, d M Y",strtotime($vouchar_details['expiry_date']))?></div>
							</div>
						</div>
                        <div class="col-md-7">
                            <div class="form-group row">
                                <label class="col-sm-5 control-label big">To</label>
                                <div class="col-md-7">
                                    <span><?=$voucher['voucher_to_name']?></span><br>
                                    <span><?=$voucher['voucher_to_email']?></span>
								</div>
							</div>
                            <div class="form-group row">
                                <label class="col-sm-5 control-label big">From</label>
                                <div class="col-md-7">
                                    <span><?=$voucher['voucher_from_name']?></span><br>
                                    <span><?=$voucher['voucher_from_email']?></span>
								</div>
							</div>
                            <div class="form-group row">
                                <label class="col-sm-5 control-label big">Message</label>
                                <div class="col-md-7">
                                    <span><?=$voucher['voucher_msg']?></span>
								</div>
							</div>
						</div>
					</div>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-success btn-block" data-target="#exampleNiftyFadeScale" data-dismiss="modal" data-toggle="modal"><i class="icon md-badge-check"></i> Apply Manual Payment</button>
						</div>
                        <div class="col-md-6">
                            <button data-dismiss="modal" class="btn btn-default btn-block"><i class="icon md-close"></i> Close</button>
						</div>
					</div>
                    <?php elseif($invoice_data['invoice_status']==3): ?>
                    <div class="row">
                        <input type="hidden" id="voucher_code" value="<?=$vouchar_details['voucher_code']?>" name="">
                        <input type="hidden" id="voucher_amount" value="<?=$vouchar_details['voucher_amount']?>" name="">
                        <div class="form-group row col-sm-12">
                            <label class="col-sm-3 control-label big">Initial value</label>
                            <div class="col-sm-2"><?=$vouchar_details['voucher_amount']?></div>
                            <label class="col-sm-3 control-label big">Status</label>
                            <div class="col-md-2"><span class="badge badge-success">Active</span></div>
						</div>
                        <div class="form-group row col-sm-12">
                            <label class="col-sm-3 control-label big">Code</label>
                            <div class="col-sm-2"><?=$vouchar_details['voucher_code']?></div>
                            <label class="col-sm-3 control-label big">Invoice</label>
                            <div class="col-md-2">#<?= $invoice_data['invoice_number'] ?></div>
						</div>
                        <div class="form-group row col-sm-12">
                            <label class="col-sm-3 control-label big">To</label>
                            <div class="col-md-6">
                                <input type="text" name="" id="voucher_to_name" value="<?=$voucher['voucher_to_name']?>" class="form-control">
							</div>
                            <div class="col-md-3">
                                <button type="button" onclick="sendVoucher(0)" class="btn btn-default">Send Email</button>
							</div>
						</div>
                        <div class="form-group row col-sm-12">
                            <label class="col-sm-3 control-label big">Recipient's email</label>
                            <div class="col-md-6">
                                <input type="email" name="" id="voucher_to_email" value="<?=$voucher['voucher_to_email']?>" class="form-control">
							</div>
                            <div class="col-md-3">
                                
							</div>
						</div>
                        <div class="form-group row col-sm-12">
                            <label class="col-sm-3 control-label big">From</label>
                            <div class="col-md-6">
                                <input type="text" name="" id="voucher_from_name" value="<?=$voucher['voucher_from_name']?>" class="form-control">
							</div>
                            <div class="col-md-3">
                                <button type="button" onclick="sendVoucher(1)" class="btn btn-default">Send Email</button>
							</div>
						</div>
                        <div class="form-group row col-sm-12">
                            <label class="col-sm-3 control-label big">Sender's email</label>
                            <div class="col-md-6">
                                <input type="email" readonly="readonly" name="" id="voucher_from_email" value="<?=$voucher['voucher_from_email']?>" class="form-control">
							</div>
                            <div class="col-md-3">
                                
							</div>
						</div>
                        <div class="form-group row col-sm-12">
                            <label class="col-sm-3 control-label big">Message</label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="message"></textarea>
							</div>
						</div>
					</div>
                    <?php endif ?>
                    
				</div>
			</div>
		</div>
	</div>
    <?php endif ?>
    <div class="modal fade modal-fade-in-scale-up" id="emailInvoice" aria-hidden="true"
	aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-simple">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
                    <h4 class="modal-title"></h4>
				</div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label big">Email address to send invoice to</label>
                        <input type="email" class="form-control" id="inv_email" name="">
					</div>
                    <div class="form-group">
                        <div class="btn-group" style="width: 100%;">
                            <div class="col-md-6">
                                <button data-dismiss="modal" class="btn btn-default btn-block">Cancel</button>
							</div>
                            <div class="col-md-6">
                                <button onclick="sendInvoiceEmail(<?=$invoice_id?>)" class="btn btn-success btn-block">Send</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- End Modal -->
    <style type="text/css">
		.dataTables_wrapper .row{
		margin-left:0 !important;
		margin-right:0 !important;
		}
		.page-content-actions {
		padding: 0 10px 10px;
		}
		.black{
		color: #000;
		font-weight: 500;
		}
		.big{
		font-size: 15px;
		color: #000;
		text-align: right;
		font-weight: 500;
		}
		.modal-header .close{
		padding: 0px 7px 0 0;
		}
	</style>
    <?php $this->load->view('admin/common/footer'); ?>
    <script type="text/javascript">
		$(document).ready( function() {
			$('#example').dataTable( {
				order: [],
				columnDefs: [ { orderable: false, targets: [0,-1] } ]
			});
		});
		function printThis(){
			/* var divToPrint=document.getElementById("printable");
				newWin= window.open("");
				newWin.document.write(divToPrint.innerHTML);
				newWin.print();
			newWin.close();*/
		}
		function sendVoucher(type){
			var voucher_to_name = $("#voucher_to_name").val();
			var voucher_to_email = $("#voucher_to_email").val();
			var voucher_from_name = $("#voucher_from_name").val();
			var voucher_from_email = $("#voucher_from_email").val();
			var message = $("#message").val();
			var voucher_code = $("#voucher_code").val();
			var voucher_amount = $("#voucher_amount").val();
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/invoice/sendVoucherEmail',
				data: {voucher_to_name:voucher_to_name,voucher_to_email:voucher_to_email,voucher_from_name:voucher_from_name,voucher_from_email:voucher_from_email,message:message,type:type,voucher_code:voucher_code,voucher_amount:voucher_amount},
				beforeSend:function(){
					swal({
						title: "",
						text: "",
						showCancelButton:false,
						showConfirmButton:false,
						imageUrl: site_url+'global/images/Rolling.gif'
					});
				},
				success:function(response){
					if(response=="true"){
						swal("Success!", "Email has been sent successfully", "success");
						}else{
						swal("Error!", "Email could not be sent, Please try again", "error");
					}
				},
				error:function(response){
					swal("Error!", "Unknown error accured, Please try again", "error");
				}
			})
		}
		
		function sendInvoiceEmail(invoice_id){
			var email = $("#inv_email").val();
			if(email!=""){
				$.ajax({
					type: 'POST',
					url: site_url + 'admin/invoice/invoice_pdf',
					data: {email:email,invoice_id:invoice_id},
					beforeSend:function(){
						swal({
							title: "",
							text: "",
							showCancelButton:false,
							showConfirmButton:false,
							imageUrl: site_url+'global/images/Rolling.gif'
						});
					},
					success:function(response){
						swal("Success!", "Email has been sent successfully", "success");
					},
					error:function(response){
						swal("Error!", "Unknown error accured, Please try again", "error");
					}
				});
				}else{
				return false;
			}
		}
	</script>
	
	<script>
        $('.wallet_alert').hide();
		$('#radioBtn a').on('click', function(){
			var sel = $(this).data('title');
			var tog = $(this).data('toggle');
			$('#'+tog).prop('value', sel);
			
			$('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
			$('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
            if (sel==9) {
      $('.wallet_alert').show();
    }
    else{
      $('.wallet_alert').hide();

    }
			
			$('#submit').show();
			$('.payment_alert').hide();
		});
	</script>
	
	<script type='text/javascript'>
		
		$(function(){
			$('.payment_alert').hide();
			$('#staff_id').change(function() {
				var payment_type_id = $('#payment_type_id').val();
				if (payment_type_id=='') {
					$('#submit').hide();
					$('.payment_alert').show();
					
				}
				else{
					$('.payment_alert').hide();
					$('#submit').show();
				}
			});
		});


       function validateForm(){
  var payment_type_id = $('#payment_type_id').val();
  var total_price = $('#total_price').val();  
   var paid_amount = $('#paid_amount').val();
   var wallet_row = <?php echo $wallet_row ?>;
   var wallet_amount= <?=getcustomerIdByCustomerWallet($invoice_data['customer_id'])?>;
  // alert(wallet_row);
   if (wallet_row>0 && paid_amount<total_price ) {
       swal("Error!", "There should be no outstanding while adding amount to wallet. ", "error");
     $('#submit').show();
      return false;
    }
  
    if (payment_type_id=='') {
      $('#submit').hide();
       $('.payment_alert').show();
      return false;
    }
    else{
      $('.payment_alert').hide();
      $('#submit').hide();
    }


    if (payment_type_id==9 && paid_amount>wallet_amount) {
      swal("Error!", "Your amount greater than wallet amount ", "error");
     $('#submit').show();
      return false;

    }
    
   
}
		
	</script>	