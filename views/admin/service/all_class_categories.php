
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
							
							<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service');?>" >Services</a></li>
							<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_service_category');?>" >Service Categories</a></li>
							<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_service_group');?>" >Service Group</a></li>
							<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_packages');?>" >Packages</a></li>
							<li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/service/all_class');?>" >Class</a></li>
							<li class="nav-item" role="presentation"><a class="nav-link  active" data-toggle="tab"  role="tab"  >Class Categories</a></li>
						</ul>
						<?php if($admin_session['role']=='owner' or $admin_session['role']=='business_owner'){ ?>
						<div class="page-header-actions">
							<a class="btn btn-info" href="<?php echo base_url('admin/service/add_class_category');?>">Add Class Category</a>
						</div>
						<?php } ?>
					</div>
					
					<!-- Contacts Content -->
					<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
						<?php if(isset($all_class_category)){?>
							<!-- Actions -->
							<!-- <div class="page-content-actions">
								<div class="btn-group btn-group-flat" style="margin-left:5px;">
									<button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
								</div>
							</div> -->
							<input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
							<input type="hidden" name="search_width" id="search_width" value="232px">
							<!-- Contacts -->
							<form id="frm_records" name="frm_records" action="" method="post">
								<table id="example" class="table table-hover  table-striped w-full" data-plugin="">
									<thead>
										<tr>
											<!-- <th class="cell-50 dark-background-heading" scope="col">
												<span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
													<input type="checkbox" class="contacts-checkbox selectable-all" id="select_all"/>
													<label for="select_all"></label>
												</span>
											</th> -->
											<th class="dark-background-heading" width="20">#</th>
											<th class="cell-10 dark-background-heading" scope="col">Name</th>	
											<?php if($admin_session['role']=='owner' or $admin_session['role']=='business_owner'){ ?>	
											<th class="cell-100 dark-background-heading" scope="col">Actions</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										
										<?php $counter = 1;foreach($all_class_category as $row){?>
											<tr id="row_<?php echo $row['id']; ?>">
												
												<!-- <td>
													<span class="checkbox-custom checkbox-primary checkbox-lg">
														<input type="checkbox" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $row['id'];?>"/>
														<label for="contacts_1"></label>
													</span>
												</td> -->
												<td><?=$counter;?></td>
												<td><?php echo $row['name'];?></td>
												<?php if($admin_session['role']=='owner' or $admin_session['role']=='business_owner'){ ?>
												<td>
													<div class="btn-group dropdown">
														<button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
														<div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
															<a class="dropdown-item" href="<?php echo base_url('admin/service/add_class_category/'.$row['id']);?>" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
															<a class="dropdown-item" href="javascript:void(0)" onClick="operation_class_category('<?php echo $row['id']; ?>','delete')" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a>
														</div>
													</div>
												</td>
												<?php } ?>
											</tr>
										<?php $counter++; } ?>
									</tbody>
								</table>
							</form>
							<?php }else{?>
							<div style="width:100%;float:left;text-align:center;">No Service Category Added</div>
						<?php }?>
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
		$jq(document).ready(function(){
			if($jq('#customer_search').length)
			{
				$jq("#customer_search").suggestion({
					url:base_url + "admin/Operations/suggestion_list?chars=",
					minChars:2,
					width:200,
				});
			}
			
		});
		
		function operation_class_category (id) {
			op_type = "delete";
			swal({
				title: "Are you sure?",
				text: "You will not be able to recover this service category!",
				type: "info",
				showCancelButton: true,
				confirmButtonClass: "btn-info",
				confirmButtonText: 'Yes, delete it!',
				closeOnConfirm: false
				//closeOnCancel: false
				}, function () {
				$.ajax({
					type: 'POST',
					url: site_url + 'admin/Operations/delete_class_category/' + encodeURIComponent(id),
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
    order: [],
    columnDefs: [ { orderable: false, targets: [0,-1] } ]
  });
});
</script>