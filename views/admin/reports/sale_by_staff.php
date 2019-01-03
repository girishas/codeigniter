<?php $this->load->view('admin/common/header'); ?>

<body class="animsition app-contacts page-aside-left">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
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
						<h1 class="panel-title">Reports</h1>
						
					</div>
					<!-- Contacts Content -->
					<?php $admin_session = $this->session->userdata('admin_logged_in'); ?>
					
					<div class="page-header">
						<?php $this->load->view('admin/common/report_menu'); ?>
						
					</div>
					<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
						
						<form autocomplete="false" method="post" action="">
							<div class="row mb-10" style="margin-left:5px;">
								
								<div class="col-sm-3">
									<?php 
										$last = $this->uri->total_segments();
										$r_select = $this->uri->segment($last);
									?>
									
									<label class="form-control-label" for="inputGrid2">Choose a report</label>
									<select  data-placeholder="Select Report" class="form-control form-control" data-plugin=" " name="select_report" id="select_report">
										<option value="">Select Report</option>
										<option value="admin/reports" <?php if(!empty($r_select)){ if($r_select == 'reports') { echo "selected"; }} ?> >Daily Sales</option>
										<option value="admin/reports/sale_by_staff" <?php if(!empty($r_select)){ if($r_select == 'sale_by_staff') { echo "selected"; }} ?> >Sale by Staff</option>
										
										<option value="admin/reports/sale_by_day" <?php if(!empty($r_select)){ if($r_select == 'sale_by_day') { echo "selected"; }} ?> >Sale by Day</option>
										<option value="admin/reports/sale_by_month" <?php if(!empty($r_select)){ if($r_select == 'sale_by_month') { echo "selected"; }} ?> >Sale by month</option>
									</select>
								</div>
								<?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" ){?> 
									
									<div class="col-sm-2">
										<label class="form-control-label" for="inputGrid2">Location</label>
										
										<!--  <select data-placeholder="Select Location" class="form-control form-control-sm" data-plugin="select2" name="location_id" id="location_id">
										</select> -->
										<?php $alllocaton_data= getAllLocationData(); ?>
										<select name="location_id" id="location_id" class="form-control form-control" >
											<option value="">All Location</option>
											<?php
												foreach ($alllocaton_data as $key => $value) {?>
												<?php $location_id=isset($location_id)?$location_id:0;?>
												
												<option value="<?php echo  $value['id'] ?>"<?php if ($location_id ==$value['id']) {echo 'selected'; } ?>  ><?php echo $value['location_name'] ?></option>
												
											<?php } ?>
										</select>
										
									</div>
								<?php } ?>
								
								<div class="col-sm-2">
									<label class="form-control-label" for="inputGrid2">From Date</label>
									<input type="text" class="form-control" name="from_date" id="from_date" data-date-today-highlight="true" data-plugin="datepicker" autocomplete="off" data-date-format="dd-mm-yyyy" value="<?php echo(isset($from_date)?$from_date:'' ) ?>">
								</div>
								
								<div class="col-sm-2">
									<label class="form-control-label" for="inputGrid2">To Date</label>
									<input type="text" class="form-control" name="to_date" id="to_date" data-date-today-highlight="true" data-plugin="datepicker" autocomplete="off" data-date-format="dd-mm-yyyy" value="<?php echo (isset($to_date) ?$to_date:'' ) ?>">
								</div>
								
								<div class="col-sm-2">
									<div class="mt-25">                  
										<button class="btn btn-primary " name="search_filter" value="search_filter" type="submit" id="viewReportBtn">Search</button>
									</div> 
									
								</div>
								
							</div>
						</form>
						
						<!-- Contacts -->
						
						<div class ="table-responsive"> 
							<form id="frm_customer" name="frm_customer" action="" method="post">
								<table id="example" class="table table-hover  table-striped w-full" data-plugin="">
									
									<thead>
										
										<tr>
											<th class="dark-background-heading">STAFF</th>
											<th class="dark-background-heading"> QTY</th>
											<th class="dark-background-heading">Services</th>
											<th class="dark-background-heading">Product</th>
											<th class="dark-background-heading">GROSS</th>                     
											<th class="dark-background-heading">DISCOUNT </th>
											<th class="dark-background-heading">REFUND </th>
											<th class="dark-background-heading">SALE </th>
											<th class="dark-background-heading">VOUCHER </th>
											<th class="dark-background-heading">TOTAL</th>
											<th class="dark-background-heading">GTAX </th>
											<th class="dark-background-heading">NET</th>
										</tr>
									</thead>
									<tbody>        <?php  $all_total= 0;
										$all_qty=0;
										$all_discount=0;
										$all_refund=0;
                                        $all_net=0;
                                        $all_tax=0;
                                        $all_final_total=0;
                                        $all_total_voucher_applied=0;
                                        $all_exact_net=0;
                                        $productAmount=0;
                                        $all_productAmount=0;
										$all_ServiceAmount=0;
										
										foreach ($invoice_services as $key => $value):
										$to_date= isset($to_date) ?$to_date:'';
										$from_date= isset($from_date)?$from_date:'';
										$RefundAmount= getStaffbyRefundAmount($value['staff_id'],$from_date,$to_date);
										if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
											$productAmount= getStaffProductAmount($admin_session['business_id'],$location_id,$value['staff_id'],$from_date,$to_date);
										}
										if ($admin_session['role']=='location_owner') {
											$productAmount= getStaffProductAmount($admin_session['business_id'],$admin_session['location_id'],$value['staff_id'],$from_date,$to_date); 
										}
										
									    if ($RefundAmount>0) {
											$RefundAmount=$RefundAmount;
											}else{
											$RefundAmount=0;
										}  
										$tax_percent = getBusinessTax($admin_session['business_id']);
										$tax_type = getBusinessTaxType($admin_session['business_id']);
										$total_voucher_applied=  $value['total_voucher_applied'];
										$total_service_total_price=  $value['total_service_total_price']-$value['total_voucher_applied']; 
										
										//echo $total_service_total_price;
										$service_amount=$total_service_total_price-$productAmount;                                 
									    $all_ServiceAmount+=$service_amount;
										$all_productAmount+=$productAmount;                                
										
										$all_total+=$total_service_total_price;
										$all_total_voucher_applied+=$total_voucher_applied;
										$all_qty+=$value['total_service_qty'];
										$all_discount+=$value['total_service_discount_price'];
										$all_refund+=$RefundAmount;
										$netamount=$total_service_total_price-$value['total_service_discount_price']-$RefundAmount;
										$exactnetamount = $netamount - $total_voucher_applied;
										$total_tax_amount = getServiceTaxAmount($exactnetamount,$tax_percent,$tax_type);
										
										//echo $final_total.'</br>';
										$final_total=$exactnetamount-$total_tax_amount;
										$all_net+= $netamount;
										$all_exact_net+= $exactnetamount;
										$all_tax+= $total_tax_amount;
										$all_final_total+= $final_total;
									?>
                                    <tr>
                                        <td>
											<!-- <?=$value['staff_id']; ?> -->
											<a href="#" data-target="#exampleFillIn_<?php echo $value['staff_id']; ?>" data-toggle="modal" onclick="getPieChart(<?=$value['staff_id']?>,'<?= getStaffName($value['staff_id']); ?>','<?=round($service_amount,2)?>','<?=round($RefundAmount ,2)?>','<?=round($value['total_service_discount_price'],2)?>','<?=round($total_voucher_applied,2)?>','<?=round($productAmount,2)?>' )" >
											<?= getStaffName($value['staff_id']); ?></a>
											
										</td>
                                        <td><?=$value['total_service_qty']?></td>
                                        <td><?=number_format($service_amount,2)?></td>
                                        <td><?=number_format($productAmount,2)?></td>
                                        <td><?=number_format($total_service_total_price,2)?></td>
                                        <td>-<?=number_format($value['total_service_discount_price'],2)?></td>
                                        <td>-<?=number_format($RefundAmount,2)?></td>
										<td><?=number_format($netamount,2)?></td>
										<td>-<?=number_format($total_voucher_applied,2)?></td>
                                        <td><?=number_format($exactnetamount,2)?></td>
										<td><?=round($total_tax_amount,2)?></td>
										<td><?=number_format($final_total,2)?></td>
									</tr>
									<?php endforeach; ?>   
									</tbody>
									
									<tfoot>
										<tr>
											<th><b>Total </b></th>
											<th><b><?php echo $all_qty ?>  </b></th>
											
											<th><b><?php echo number_format($all_ServiceAmount,2); ?> </b></th>
											<th><b><?php echo number_format($all_productAmount,2); ?> </b></th>
											
											<th><b><?php echo number_format($all_total,2); ?> </b></th>
											<!--   <th><b><?php echo number_format($all_total,2); ?> </b></th>
											<th><b><?php echo number_format($all_total,2); ?> </b></th> -->
											<th><b>-<?php echo number_format($all_discount,2); ?> </b></th>
											<th><b>-<?php echo number_format($all_refund,2); ?> </b></th>
											<th><b><?php echo number_format($all_net,2); ?> </b></th>
											<th><b>-<?php echo number_format($all_total_voucher_applied,2); ?> </b></th>
											<th><b><?php echo number_format($all_exact_net,2); ?> </b></th>
											<th><b><?php echo number_format($all_tax,2); ?> </b></th>
											<th><b><?php echo number_format($all_final_total,2); ?> </b></th>
										</tr> 
									</tfoot>
								</table>
							</form>
						</div>
						<!--<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php foreach ($invoice_services as $key => $value) {?>
		<div  class="modal fade modal-fade-in-scale-up" id="exampleFillIn_<?=$value['staff_id'];?>" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
			<div class="modal-dialog modal-simple">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Sale by <?= getStaffName($value['staff_id']); ?></h4> 
					</div>
					<form method="post" action="<?= base_url()?>admin/product/stockin">
						<div class="modal-body" id="canvas-holder" style="text-align:center;position: relative;">
							<canvas style="position: relative; height:40vh; width:80vw" id="chartContainer_<?=$value['staff_id'];?>" width="300" height="300"/>
						</div>
						
						<div class="modal-footer">
							<!--  <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button> -->
							<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
							<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php } ?>
	
	
	<!-- End page -->
	<script language="javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.js');?>"></script>
	<script language="javascript" src="<?php echo base_url('assets/js/jquery.suggestion.js');?>"></script>
	
	
	<style type="text/css">
        .dataTables_wrapper .row{
		margin-left:0 !important;
		margin-right:0 !important;
        }
        .page-content-actions {
        padding: 0 10px 10px;
        }
        .datepicker{z-index: 999999 !important};
		
        div.dataTables_wrapper div.dataTables_info {
		padding: .85em !important;
		
		}
		.page-header+.page-content {    
		overflow-x: hidden !important;
		}
		div.dt-buttons {
		float: right;
		}
	</style>
	
	<?php $this->load->view('admin/common/footer'); ?>
	<script>
		$(document).ready(function(){
			// select report
			
			$("#select_report").change(function(){
				
				if($(this).val() != ''){
					//alert('<?php //echo base_url(); ?>'+$(this).val());
					window.location.replace('<?php echo base_url(); ?>'+$(this).val());
				}
			});
			
		});  // end of document.ready
	</script>
	
	<script type="text/javascript">
		$(document).ready( function() {
			$('#example').dataTable({
				"searching": false,
				"paging": false,
				'iDisplayLength': -1,
				
				dom: 'Bfrtip',
				/*   buttons: [
					'print', 'csv', 'excel', 'pdf', 
				],*/
				
				buttons: [          
				{
					extend: 'collection',
					text: 'Export',
					buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
					]
				}
				],
				
				
			});
			
			
			
			
			
			
		});
		function getPieChart (staff_id,staff_name,service_amount,RefundAmount,discount,voucher,productAmount) {
		
			var pieData = [
			{
				value: service_amount,
				color:"#F7464A",
				highlight: "#FF5A5E",
				label: "Service"
			},
			{
				value: RefundAmount,
				color: "#46BFBD",
				highlight: "#5AD3D1",
				label: "Refund"
			},
			{
				value: discount,
				color: "#FDB45C",
				highlight: "#FFC870",
				label: "Discount"
			},
			{
				value: voucher,
				color: "#949FB1",
				highlight: "#A8B3C5",
				label: "Voucher"
			},
			{
				value: productAmount,
				color: "#4D5360",
				highlight: "#616774",
				label: "Product"
			}
			
			];
			
			var ctx = document.getElementById("chartContainer_"+staff_id).getContext("2d");
			myPie = new Chart(ctx).Pie(pieData);
			
			
		};
	</script>
	
	<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	
	<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	
	<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	
	
	
	
	
	
	
	
