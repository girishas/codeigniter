<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<div class="page">
		<div class="page-content">
			<div class="panel">
		<!-- Alert message part -->
		<?php if($this->session->flashdata('success_msg')) {?>
		<div class="alert dark alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
			<?php echo $this->session->flashdata('success_msg');?>
		</div>
		<?php }else if($this->session->flashdata('error_msg')) { ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
			<?php echo $this->session->flashdata('error_msg');?>
		</div>
		<?php  }?>
		<!-- End alert message part -->
		<!-- Contacts Content -->
		<div class="page-main">
			<!-- Contacts Content Header -->
			<div class="page-header">
				<h1 class="page-title">All Location Admins</h1>
				<div class="page-header-actions"><a href="<?php echo base_url('admin/user/add_admin_user');?>"><button type="button" class="btn btn-block btn-primary">Add Location Admin</button></a></div>
				<div class="page-header-actions">
					<!--<form>
						<div class="input-search input-search-dark">
							<i class="input-search-icon md-search" aria-hidden="true"></i>
							<input type="text" class="form-control" name="" placeholder="Search...">
						</div>
					</form>-->
				</div>
			</div>
			<!-- Contacts Content -->
			<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
				<?php if(isset($all_users)){?>
				<!-- Actions -->
				<div class="page-content-actions">
					<div class="float-right">
						<form>
							<div class="input-search input-search-dark">
								<i class="input-search-icon md-search" aria-hidden="true"></i>
								<input type="text" class="form-control" name="" placeholder="Search...">
							</div>
						</form>
					</div>
					<div class="btn-group btn-group-flat">
						<div class="dropdown">
							Records
							<select class="select-style" style="width:65px;">
								<option>10</option>
								<option>25</option>
								<option>50</option>
								<option>100</option>
								<option>All</option>
							</select> per page
						</div>
						
					</div>
				</div>
				<!-- Contacts -->
				<table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr"data-selectable="selectable">
					<thead>
						<tr>
							<th class="pre-cell dark-background-heading"></th>
							<th scope="col" class="dark-background-heading">
								<span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
									<input type="checkbox" class="contacts-checkbox selectable-all" id="select_all"  />
									<label for="select_all"></label>
								</span>
							</th>
							<th class="cell-100 dark-background-heading" scope="col">Name</th>
							<th class="cell-100 dark-background-heading" scope="col">Email</th>
							<th class="cell-100 dark-background-heading" scope="col">Role</th>
							<th class="cell-30 dark-background-heading" scope="col">Access Control</th>
							<th class="cell-40 dark-background-heading" scope="col">Added date</th>
							<th class="cell-30 dark-background-heading" scope="col">Status</th>
							<th class="cell-50 dark-background-heading" scope="col">Actions</th>
							<th class="suf-cell"></th>
						</tr>
					</thead>
					<tbody>
						<?php $counter =1; foreach($all_users as $user){?>
						<tr id="row_<?php echo $user['id']; ?>">
							<td class="pre-cell"></td>
							<td class="cell-30">
								<span class="checkbox-custom checkbox-primary checkbox-lg">
									<input type="checkbox" class="contacts-checkbox checkbox1" id="contacts_<?php echo $counter;?>"
									/>
									<label for="contacts_1"></label>
								</span>
							</td>
							<td class="cell-50" scope="col"><?php echo ucfirst($user['admin_name']);?></td>
							<td class="cell-100" scope="col"><?php echo $user['email'];?></td>
							<td class="cell-100" scope="col">
								<?php echo ucfirst(str_replace("_"," ",$user['role']));
								$business_str="";
								if($user['name']!=""){
									$business_str .= "(";
									$business_str .= $user['name'];
									if(!empty($user['location_id'])){
										$locations = $this->others->get_all_table_value("location","location_name","business_id='".$user['business_id']."' AND id='".$user['location_id']."' ");
										if($locations){
											$business_str .= " | ".$locations[0]['location_name'];
										}
									}
									$business_str .= ")";
								}
								if(!empty($business_str))
									echo "<br/>".$business_str;
								?>
							</td>
							<td class="cell-30" scope="col">
								<?php if($user['role']!="business_owner" && $user['role']!="location_owner"){?>
								<a href="<?php echo base_url('admin/user/access');?>"><button type="button" class="btn btn-info btn-xs waves-effect waves-classic">Access</button></a>
								<?php } ?>
							</td>
							<td class="cell-40" scope="col"><?php echo $user['date_created'];?></td>
							<td class="cell-30" scope="col">
								<?php if($user['status']==1){?>
								<span class="badge badge-primary" id="active_inactive<?php echo $user['id']; ?>">Active</span>
								<?php }else{?>
								<span class="badge badge-danger" id="active_inactive<?php echo $user['id']; ?>">Inactive</span>
								<?php } ?>
							</td>
							<td class="cell-50" scope="col">
								<div class="btn-group dropdown">
									<button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
									<div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
										<a class="dropdown-item" href="javascript:void(0)" onClick="operation_user('<?php echo $user['id']; ?>','active')"role="menuitem"><i class="icon md-check" aria-hidden="true"></i>Active</a>
										<a class="dropdown-item" href="javascript:void(0)" onClick="operation_user('<?php echo $user['id']; ?>','inactive')" role="menuitem"><i class="icon md-pause" aria-hidden="true"></i>Inactive</a>
										<a class="dropdown-item" href="<?php echo base_url('admin/user/edit_admin_user/'.$user['id']);?>"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
										<a class="dropdown-item" href="javascript:void(0)" onClick="operation_user('<?php echo $user['id']; ?>','delete')" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a>
									</div>
								</div>
							</td>
							<td class="suf-cell"></td>
						</tr>
						<?php $counter++; }?>
						<tr>
							<td colspan="8" style="border-bottom:0!important;"><button type="button" class="btn btn-success waves-effect waves-classic"><i class="icon md-check" aria-hidden="true"></i>Active</button>
								<button type="button" class="btn btn-danger waves-effect waves-classic"><i class="icon md-pause" aria-hidden="true"></i>Inactive</button>
								<button type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete</button>
							</td>
						</tr>
					</tbody>
				</table>
				<?php }else{?>
				<div style="width:100%;float:left;text-align:center;">No User Found</div>
				<?php }?>
				<!--<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
			</div>
		</div>
	</div>
</div>
</div>
	<!-- End page -->
	<script language="javascript">
	function operation_user(id,op_type)
	{
		if(id!="" && op_type!=""){
			if(window.confirm("Sure to "+op_type+" this record?")){
				$.ajax({
					type: 'POST',
					url: site_url + 'admin/Operations/delete_user/' + encodeURIComponent(id),
					data: 'operation='+op_type,
					datatype: 'json',
					beforeSend: function() {
					},
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
							alert('Something went wrong, please refresh page and try again');
						}
					}
				});
				
			}
		}else{
			return false;
		}
	}
	</script>
	<?php $this->load->view('admin/common/footer'); ?>