<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
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
					<div class="page-header">
						<ul class="nav nav-tabs" role="tablist">
							
							<li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab" >Services</a></li>
							<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_service_category');?>" >Service Categories</a></li>
							<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_service_group');?>" >Service Group</a></li>
							<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_packages');?>" >Packages</a></li>
							<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_class');?>" >Class</a></li>
							<li class="nav-item" role="presentation"><a class="nav-link ""  href="<?php echo base_url('admin/service/all_class_category');?>" >Class Categories</a></li>
							
						</ul>
						<?php if($admin_session['role']=='owner' or $admin_session['role']=='business_owner'){ ?>
						<div class="page-header-actions">
							<a class="btn btn-info" href="<?php echo base_url('admin/service/add_service');?>">Add Service </a>
						</div>
						<?php } ?>
					</div>
					
					<!-- Contacts Content -->
					<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
							<!-- Actions -->
							<!-- <div class="page-content-actions">
								<div class="btn-group btn-group-flat" style="margin-left:5px;">
									<button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
								</div>
								<div class="btn-group btn-group-flat" style="margin-left:5px;">
									<a  href="<?php echo base_url('admin/voucher/export_to_csv');?>">
									<button type="button" class="btn btn-success waves-effect waves-classic">
									<i class="icon md-upload text" aria-hidden="true"></i><span class="text">Export to CSV</span></button></a>
								</div>
							</div> -->
							<!-- <input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
							<input type="hidden" name="search_width" id="search_width" value="232px">
							<form id="frm_records" name="frm_records" action="" method="post"> -->
								<table id="example" class="table table-hover  table-striped w-full" data-plugin="">
									<thead>
										<tr>
											<!-- <th class="cell-50 dark-background-heading" scope="col">
												<span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
													<input type="checkbox" class="contacts-checkbox selectable-all" id="select_all"/>
													<label for="select_all"></label>
												</span>
											</th> -->
											<th class="cell-10 dark-background-heading" scope="col">Service Name</th>
											<th class="cell-10 dark-background-heading" scope="col">SKU</th>
											<th class="cell-10 dark-background-heading" scope="col">Price</th>
											<th class="cell-10 dark-background-heading" scope="col">Category</th>	
											<th class="cell-10 dark-background-heading" scope="col">Is Online</th>	
											<th class="cell-100 dark-background-heading" scope="col">Actions</th>
										</tr>
									</thead>
									<tbody>
										
										<?php
										foreach($all_services as $key => $value){
											//foreach($value['service_timing'] as $kkey => $vvalue){
											?>
											<tr>
												<td><?php echo $value['service_name'];?> &nbsp;<?=$value['caption']?> </td>
												<td><?php echo $value['sku'];?></td>
												<td><?php echo $value['special_price']?></td>
												<td><?php echo getServiceNameById($value['service_category_id']);?></td>
												<td><?php 
													if($value['is_online']==1){
														echo "Yes";
													}else{
														echo "No";
													}
												?></td>
												<td>
													<div class="btn-group dropdown">
														<button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
														<div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
															<!-- <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-check" aria-hidden="true"></i>Active</a>
															<a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-pause" aria-hidden="true"></i>Inactive</a> -->
															<?php if($admin_session['role']=='owner' or $admin_session['role']=='business_owner'){ ?>
															<a class="dropdown-item" href="<?php echo base_url('admin/service/edit_service/'.$value['id']);?>" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
														<?php } ?>
															<a class="dropdown-item" href="<?php echo base_url('admin/service/view/'.$value['id']);?>" role="menuitem"><i class="icon md-eye" aria-hidden="true"></i>View</a>
														</div>
													</div>
												</td>
												<!-- <td><button type="button" data-target="#exampleNiftySlideFromRight" onclick="getPackage(<?php echo $row['id']; ?>)" data-toggle="modal" class="btn btn-info">Issue to Customer</button></td> -->
											</tr>
										<?php //} 
									} ?>
									</tbody>
								</table>
							<!-- </form> -->
							
						<!--<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- End page -->
	<script language="javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.js');?>"></script>
	<script language="javascript" src="<?php echo base_url('assets/js/jquery.suggestion.js');?>"></script>
	
	<script language="javascript">
		var $jq = jQuery.noConflict();
		function operation_service (id) {
			op_type = "delete";
			swal({
				title: "Are you sure?",
				text: "You will not be able to recover this Product!",
				type: "info",
				showCancelButton: true,
				confirmButtonClass: "btn-info",
				confirmButtonText: 'Yes, delete it!',
				closeOnConfirm: false
				//closeOnCancel: false
				}, function () {
				$.ajax({
					type: 'POST',
					url: site_url + 'admin/Operations/delete_service/' + encodeURIComponent(id),
					data: 'operation='+op_type,
					datatype: 'json',
					success: function(data)
					{
						data = JSON.parse(data);
						if (data.status == 'not_logged_in') {
							location.href= site_url + 'admin'
							}else if (data.status == 'success') {
							if(op_type=="active"){
								$("#active_inactive"+id).html('Active');
								$("#active_inactive"+id).removeClass("badge-danger")
								$("#active_inactive"+id).addClass("badge-primary")
								}else if(op_type=="inactive"){
								$("#active_inactive"+id).html('Inactive');
								$("#active_inactive"+id).removeClass("badge-primary")
								$("#active_inactive"+id).addClass("badge-danger")
							}else if(op_type=="delete")
							$("#row_"+id).hide().remove();
							} else {
							swal("Error!", "Unknown error accured!", "error");
						}
					},
					error: function(){
						swal("Error!", "Unknown error accured!", "error");
					}
				});
				swal("Deleted!", "Product has been deleted!", "success");
			});
		}
		
		
		function delete_selected(){
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
				document.frm_records.submit();
			});
		}
        
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
    order: [[ 1, "asc" ]],
    columnDefs: [ { orderable: false, targets: [0,-1] } ]
  });
});
</script>