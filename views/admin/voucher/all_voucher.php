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
		<div class="page-content">
			<div class="panel">
				<!-- Alert message part -->
				<?php $this->load->view('admin/common/header_messages'); ?>
				<!-- End alert message part -->
				
				<div class="page-header">
					<h1 class="page-title">All Vouchers</h1>
					<?php if($admin_session['role']=="owner" || $admin_session['role']=="business_owner"){ ?>
						<div class="page-header-actions">
							<a class="btn btn-info" href="<?php echo base_url('admin/voucher/add_voucher');?>">Add Vouchers </a>
							<!-- <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a> -->
						</div>
					<?php } ?>
				</div>
				
				<!-- Contacts Content -->
				<div class="page-main">
					<!-- Contacts Content Header -->
					<!-- <div class="page-header">
						
					</div> -->
					<!-- Contacts Content -->
					<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
						<?php if(isset($all_vouchers)){?>
							<!-- Actions -->
							<div class="page-content-actions">
								<!-- <div class="btn-group btn-group-flat" style="margin-left:5px;">
									<button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
								</div> -->
								<!-- <div class="btn-group btn-group-flat" style="margin-left:5px;">
									<a  href="<?php echo base_url('admin/voucher/export_to_csv');?>">
									<button type="button" class="btn btn-success waves-effect waves-classic">
									<i class="icon md-upload text" aria-hidden="true"></i><span class="text">Export to CSV</span></button></a>
								</div> -->
							</div>
							
							<input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
							<input type="hidden" name="search_width" id="search_width" value="232px">
							
							<!-- Contacts -->
							<table id="example" class="table table-hover table-striped w-full" >
								<thead>
									<tr>
										<!--  <th class=" dark-background-heading" scope="col">
											<span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
											<input type="checkbox" class="contacts-checkbox" id="select_all" />
											<label for="select_all"></label>
											</span>
										</th> -->
										
										<th class="cell-10 dark-background-heading" scope="col">Voucher Name</th>
										<th class="cell-10 dark-background-heading" scope="col">Amount</th>
										<th class="cell-10 dark-background-heading" scope="col">Total customer</th>
										<th class="cell-10 dark-background-heading" scope="col">status</th> 
										<th class="cell-10 dark-background-heading" scope="col">Actions</th>
										<th class="cell-10 dark-background-heading" scope="col"></th>
										<th class="cell-10 dark-background-heading" scope="col"></th>
									</tr>
								</thead>
								<tbody>
									
									<?php                    
										$counter = 1;foreach($all_vouchers as $row){?>
										<tr id="row_<?php echo $row['id']; ?>">
											
											<!-- <td>
												<span class="checkbox-custom checkbox-primary checkbox-lg">
												<input type="checkbox" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $row['id'];?>"/>
												<label for="contacts_1"></label>
												</span>
											</td> -->
											
											<!--   <a href="<?php echo base_url('admin/invoice/ViewInvoice/'.$value['id']) ?>"><?=$value['voucher_count'];?></a> -->
											
											<td><?php echo $row['vouchar_name'];?></td>
											<td><?php echo $row['voucher_amount'];?></td>
											<td>
												<?php if ($row['voucher_count']>0) {
													// echo $row['voucher_count'];
												?>
												<a href="<?php echo base_url('admin/voucher/voucher_customer/'.$row['id']) ?>"> <?php echo $row['voucher_count'];?> </a>
												<?php 
												}
												else{
													echo $row['voucher_count'];
												}
												?>
												
											</td>
											<td>
												<?php if($row['status'] == 1) { ?>
													<span class="badge badge-primary">Active</span>
												<?php } ?>
												<?php if($row['status'] == 2) { ?>
													<span class="badge badge-danger">Inactive</span>
												<?php } ?>
												<?php if($row['status'] == 3) { ?>
													<span class="badge badge-info">Assigned to Customer</span>
												<?php } ?>
												<?php if($row['status'] == 4) { ?>
													<span class="badge badge-warning">Used</span>
												<?php } ?>
												<?php if($row['status'] == 5) { ?>
													<span class="badge badge-warning">Issued</span>
												<?php } ?>
											</td>  
											
											<td>
												<div class="btn-group dropdown">
													<button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
													<div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
														<!-- <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-check" aria-hidden="true"></i>Active</a>
														<a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-pause" aria-hidden="true"></i>Inactive</a> -->
														<?php if($row['status'] == 1){ ?>
															<a class="dropdown-item" href="<?php echo base_url('admin/voucher/view_voucher/'.$row['id']);?>" role="menuitem"><i class="icon md-eye" aria-hidden="true"></i>View</a>
															<a class="dropdown-item" href="<?php echo base_url('admin/voucher/edit_voucher/'.$row['id']);?>" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
															<!--  <a class="dropdown-item" href="javascript:void(0)" onClick="operation_voucher('<?php echo $row['id']; ?>','delete')" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a> -->
															<?php }else{ ?>
															<a class="dropdown-item" href="<?php echo base_url('admin/voucher/view_voucher/'.$row['id']);?>" role="menuitem"><i class="icon md-eye" aria-hidden="true"></i>View</a>
															<a class="dropdown-item" href="<?php echo base_url('admin/voucher/edit_voucher/'.$row['id']);?>" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
															<!--  <a class="dropdown-item" href="javascript:void(0)" onClick="operation_voucher('<?php echo $row['id']; ?>','delete')" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a> -->
														<?php } ?>
													</div>
												</div>
											</td>
											<td>
												<?php if($row['status'] == 1) { ?>
													<button type="button" data-target="#exampleNiftyFadeScale_<?=$row['id']?>" data-toggle="modal" class="btn btn-info">Sell to Customer</button>
												<?php } ?>
											</td>
											<td>
												<button type="button" data-target="#sendtomultiBox<?=$row['id']?>" data-toggle="modal" class="btn btn-success"> <i class="icon md-upload" aria-hidden="true"></i></button>
												
											</td>
											
											
											
											
											
											
											
											
											<div class="modal fade modal-fade-in-scale-up" id="sendtomultiBox<?=$row['id']?>" aria-hidden="true"aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
												<div class="modal-dialog modal-simple">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">×</span>
															</button>
															<h4 class="modal-title">Bulk Send Giftcard</h4>
														</div>
														<form method="post" action="<?= base_url('admin/voucher'); ?>" enctype="multipart/form-data">
															<input type="hidden" name="action" value="save">
															<input type="hidden" name="type" value="voucher">
															<input type="hidden" name="v_type" value="M">
															<input type="hidden" name="id" value="<?=$row['id']?>">
															<input type="hidden" name="title" value="<?=$row['vouchar_name']?>">
															<input type="hidden" name="unit_price" value="<?=$row['voucher_amount']?>">
															<input type="hidden" name="vouchar_name" value="<?=$row['vouchar_name']?>">
															<input type="hidden" name="description" value="<?=$row['description']?>">
															<input type="hidden" name="vourchar_terms" value="<?=$row['vourchar_terms']?>">
															<input type="hidden" name="business_id" value="<?=$admin_session['business_id']?>">

															<input type="hidden" name="location_id" value="<?=$admin_session['location_id']?>">
															<input type="hidden" name="voucher_satus" value="<?=$row['status']?>">
															
															<div class="modal-body">
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>Name</b></div>
																	<div class="col-md-9">
																	<input type="text" class="form-control" disabled="disabled" value="<?=$row['vouchar_name']?>"></div>
																</div>
																
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>Amount</b></div>
																	<div class="col-md-9">
																	<input type="text" class="form-control" disabled="disabled" value="<?=$row['voucher_amount']?>"></div>
																</div>
																
																
																<!-- <div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>Voucher Code*</b></div>
																	<?php 
																		
																		
																		if ($voucher_setting->status==2) {
																		?>
																		<div class="col-md-9">
																			<input type="text" required="required" id="voucher_code" class="form-control" name="voucher_code">
																			<div class="admin_content_error alert alert-danger print-error-msg" style="display:none"><?php echo form_error('voucher_code'); ?></div>
																			<div class="alert alert-danger print-error-msg">This token already taken </div>
																		</div>
																	<?php } ?>
																	
																	<?php if ($voucher_setting->status==1) {
																	?>
																	<div class="col-md-9">
																		<input type="text" required="required" class="form-control" name="voucher_code" id="voucher_code" value="<?php echo $last_vouchers->id.''.$voucher_business_id ?>" readonly>
																		<div class="admin_content_error alert alert-danger print-error-msg" style="display:none"><?php echo form_error('voucher_code'); ?></div>
																		<div class="alert alert-danger print-error-msg">This token already taken</div>
																	</div>
																	<?php } ?>
																	
																	
																</div> -->
																
																
																
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>Upload CSV*</b></div>



<div class="input-group input-group-file col-md-5" data-plugin="inputGroupFile" style="width: 71%">
          						  <input type="text" class="form-control" readonly="">
          						  <span class="input-group-append">
          							<span class="btn btn-success btn-file waves-effect waves-classic">
          							  <i class="icon md-upload" aria-hidden="true"></i>
          							  <input type="file" name="stmfile" class="" required="required">
          							</span>
          						  </span>
                        <div class="admin_content_error"></div>
          						</div>






																
																	

																	<?php $baseUrl = base_url('uploads/customer/import_sample_file/customers_import_sample_voucher.csv');?>
																	<a href="<?php echo $baseUrl;?>" target="_blank" class="btn btn-primary waves-effect waves-classic" title="Sample File">Click here to download</a>
																</div>
																
																
																
																
																
																
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button>
																<button type="submit" id="save_changes" class="btn btn-primary">Save changes</button>
															</div>
														</form>
													</div>
												</div>
											</div>
											
											
											
											<div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale_<?=$row['id']?>" aria-hidden="true"aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
												<div class="modal-dialog modal-simple">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">×</span>
															</button>
															<h4 class="modal-title"> Send Giftcard</h4>
														</div>
														<form method="post" action="<?= base_url('admin/invoice/create'); ?>">
															<input type="hidden" name="action" value="save">
															<input type="hidden" name="type" value="voucher">
															<input type="hidden" name="v_type" value="S">
															<input type="hidden" name="id" value="<?=$row['id']?>">
															<input type="hidden" name="title" value="<?=$row['vouchar_name']?>">
															<input type="hidden" name="unit_price" value="<?=$row['voucher_amount']?>">
															<input type="hidden" name="vouchar_name" value="<?=$row['vouchar_name']?>">
															<input type="hidden" name="description" value="<?=$row['description']?>">
															<input type="hidden" name="vourchar_terms" value="<?=$row['vourchar_terms']?>">
															<input type="hidden" name="business_id" value="<?=$row['business_id']?>">
															
															<div class="modal-body">
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>Name</b></div>
																	<div class="col-md-9">
																	<input type="text" class="form-control" disabled="disabled" value="<?=$row['vouchar_name']?>"></div>
																</div>
																
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>Amount</b></div>
																	<div class="col-md-9">
																	<input type="text" class="form-control" disabled="disabled" value="<?=$row['voucher_amount']?>"></div>
																</div>
																
																
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>Voucher Code*</b></div>
																	<?php 
																		
																		
																		if ($voucher_setting->status==2) {
																		?>
																		<div class="col-md-9">
																			<input type="text" required="required" id="voucher_code" class="form-control" name="voucher_code">
																			<div class="admin_content_error alert alert-danger print-error-msg" style="display:none"><?php echo form_error('voucher_code'); ?></div>
																			<div class="alert alert-danger print-error-msg">This token already taken </div>
																		</div>
																	<?php } ?>
																	
																	<?php if ($voucher_setting->status==1) {
																	?>
																	<div class="col-md-9">
																		<input type="text" required="required" class="form-control" name="voucher_code" id="voucher_code" value="<?php echo $last_vouchers->id.''.$voucher_business_id ?>" readonly>
																		<div class="admin_content_error alert alert-danger print-error-msg" style="display:none"><?php echo form_error('voucher_code'); ?></div>
																		<div class="alert alert-danger print-error-msg">This token already taken</div>
																	</div>
																	<?php } ?>
																	
																	
																</div>
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>Expiry Date* </b></div>
																	<div class="col-md-9">
																		<input type="text"
																		data-date-today-highlight="true" data-date-format="dd/mm/yyyy" required="required" class="form-control" data-plugin="datepicker" id="expiry_date" autocomplete="off" name="expiry_date"  />
																	</div>
																</div>
																
																
																
																
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>To*</b></div>
																	<div class="col-md-9">
																	<input type="text" placeholder="Name of gift voucher recipient" required="required" class="form-control" name="voucher_to_name"></div>
																</div>
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>Recipient's email*</b></div>
																	<div class="col-md-9">
																	<input type="email" required="required" class="form-control" name="voucher_to_email"></div>
																</div>
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>From*</b></div>
																	<div class="col-md-9">
																	<input type="text" placeholder="Name of who gift voucher is from" required="required" class="form-control" name="voucher_from_name"></div>
																</div>
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>Sender's email*</b></div>
																	<div class="col-md-9">
																	<input type="email" required="required" class="form-control" name="voucher_from_email"></div>
																</div>
																<div class="form-group row">
																	<div class="col-md-3 text-right" style="padding-top: 7px;"><b>Message</b></div>
																	<div class="col-md-9">
																		<textarea class="form-control" name="message" rows="3"></textarea>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button>
																<button type="submit" id="save_changes" class="btn btn-primary">Save changes</button>
															</div>
														</form>
													</div>
												</div>
											</div>
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											
										</tr>
									<?php $counter++; } ?>
								</tbody>
							</table>
							<?php }else{?>
							<div style="width:100%;float:left;text-align:center;">No Voucher Found</div>
						<?php }?>
						<!--<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- End page -->
	<!-- Modal -->
	<div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale" aria-hidden="true"aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">Modal Title</h4>
				</div>
				<div class="modal-body">
					<form method="post">
						<div class="form-group row">
							<div class="col-md-4"><b>Name</b></div>
							<div class="col-md-8"><input type="text" name="voucher_name" value=""></div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	
    <script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
    <script language="javascript">
		
		
		function operation_voucher(id) {
			if (id != "") {
				swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this voucher!",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    confirmButtonText: 'Yes, delete it!',
                    closeOnConfirm: false
					//closeOnCancel: false
					}, function () {
					$.ajax({
						type: 'POST',
						url: site_url + 'admin/Operations/delete_voucher/' + encodeURIComponent(id),
						datatype: 'json',
						beforeSend: function() {},
						success: function(data) {
							data = JSON.parse(data);
							if (data.status == 'not_logged_in') {
								location.href = site_url + 'admin'
								} else if (data.status == 'success') {
								$("#row_" + id).hide().remove();
								} else {
								swal("Error!", "Something went wrong, please refresh page and try again", "error");
							}
						}
					});
					swal("Deleted!", "Voucher has been deleted!", "success");
				});
				} else {
				return false;
			}
		}
		
		function delete_selected() {
			swal({
				title: "Are you sure?",
				text: "Sure to delete all selected record!",
				type: "info",
				showCancelButton: true,
				confirmButtonClass: "btn-info",
				confirmButtonText: 'Yes, delete it!',
				closeOnConfirm: false
				//closeOnCancel: false
				}, function () {
				document.frm_customer.submit();
			});
		}
		
		
	</script>
    <script type="text/javascript">
		$(document).ready(function() {
			$("#m_id").val('');
			var abc = [];
			$('.checkbox1').click(function() {
				if ($(this).is(":checked")) {
					var id = $(this).val();
					abc.push(id);
					//alert(id);
				}
				//alert(abc);
				//return false;
				$.ajax({
					type: 'POST',
					url: site_url + 'admin/customer/marge_customers_id/' + encodeURIComponent(abc),
					datatype: 'json',
					data: {
						abc: abc
					},
					beforeSend: function() {},
					success: function(data) {
						$("#m_id").val(data);
						
					}
				});
			})
		});
	</script>
    <style type="text/css">
		.dataTables_wrapper .row{
		margin-left:0 !important;
		margin-right:0 !important;
		}
		.page-content-actions {
		padding: 0 10px 10px;
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
	</script>
	
	<script type="text/javascript">
		$(document).ready( function() {
			$(".print-error-msg").hide();
			$('#voucher_code').blur(function() {
				var voucher_code = $('#voucher_code').val(); 
				$.ajax({
					type: 'POST',
					url: site_url + 'admin/invoice/voucher_taken',
					datatype: 'json',
					data: {
						voucher_code: voucher_code
					},               
					success: function(data) {
						if (data>0) {
							$(".print-error-msg").show();
							$('#save_changes').hide();
						}
						else{
							$(".print-error-msg").hide();
							$('#save_changes').show();
						}
						
					}
				});
			})
			
			
		});
	</script>	