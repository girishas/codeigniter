<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
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
	    	<div class="page-main">

				<div class="page-content">
				<!-- Panel Tabs -->
				<div class="panel">
					
					<!-- <div class="page-header">
						<h1 class="page-title">Staff Members</h1>
						<div class="page-header-actions"><button type="button" data-target=".example-modal-sm" data-toggle="modal" class="btn btn-block btn-primary">Add New</button></div>
					</div>  -->

					<div class="panel-heading">
			            <h1 class="panel-title">Staff Members</h1>
			            
			            <div class="page-header-actions">
			              <button type="button" data-target=".example-modal-sm" data-toggle="modal" class="btn btn-block btn-primary">Add New</button>
			            </div>
			             
		          	</div>

		          	<!-- Contacts Content -->
          			<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
          			 <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" ){ ?>					
						<div class="page-content-actions">
							<div class="btn-group btn-group-flat" style="margin-left:5px;">
				                <button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
			              	</div>	
							<div class="btn-group btn-group-flat" style="margin-left:5px;">
								<?php if(isset($admin_session['role']) && $admin_session['role']=="owner"){/*?>
									<select class="form-control" style="width:80%;margin-left: 14px;" onChange="return business_staff(this.value);">
										<option value="">All Business</option>
										<?php if($all_business){?>
										<?php foreach($all_business as $business){?>
										<option value="<?php echo $business['id'];?>" <?php if(isset($business_id) && $business_id==$business['id']) echo "selected";?>><?php echo $business['name'];?></option>
										<?php } } ?>
									</select>
								<?php */} ?>
							</div>
												
						</div>
						<?php }?>
						
						<?php if(isset($all_records)){?>
						<form id="frm_customer" name="frm_customer" action="<?php echo base_url('admin/staff/add/0');?>" method="post">
		  					<table id="example" class="table table-hover  table-striped w-full" data-plugin="">
								<thead>
									<tr>
										<!-- <th class="pre-cell dark-background-heading"></th> -->
											 <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" ){ ?>	
										<th class="pre-cell dark-background-heading">
											<span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
											<input type="checkbox" class="contacts-checkbox" id="select_all" />
											<label for="select_all"></label>
											</span>
										</th>
										<?php }?>

										<th class="dark-background-heading">Image</th>
										<th class="dark-background-heading">Name</th>
										<th class="dark-background-heading">Type</th>
										<th class="dark-background-heading">Location</th>
										<th class="dark-background-heading">Email</th>
										<th class="dark-background-heading">Status</th>
										<!-- <th class="dark-background-heading">Added Date</th> -->									
										<th class="dark-background-heading">Action</th>
										
									</tr>
								</thead>
								<tbody>
									<?php $counter = 1;foreach($all_records as $row){?>
									<tr id="row_<?php echo $row['id']; ?>">
										<!-- <td class="pre-cell"></td> -->
											 <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" ){ ?>	
										<td >
											<span class="checkbox-custom checkbox-primary checkbox-lg">
												<input type="checkbox" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $row['id'];?>"  />
												<label for="contacts_1"></label>
											</span>
										</td>
										<?php } ?>

										<td>
											<?php if(!empty($row['picture'])){ ?>
											<img class="img-fluid" src="<?php echo base_url('images/staff/thumb/'.$row['picture']); ?>" width="50" />
											<?php }else{?>
											<img class="img-fluid" src="<?php echo base_url('global/product/no-product-image.jpg');?>" width="50" />
											<?php } ?>
										</td>
										<td><a href="<?php echo base_url('admin/staff/view/'.$row['id']); ?>"><?php echo $row['first_name'].' '.$row['last_name'];?></a></td>
										<td>
											<?php echo ($row['staff_type']==0)?"<span class='badge badge-primary'>Staff</span>":"<span class='badge badge-info'>Location Owner</span>" ?>
										</td>
										
										<td><?php echo getLocationNameById($row['location_id']);?></td>
										<td><?= $row['email']; ?></td>
										<td><?php if($row['status']==1){?>
											<span class="badge badge-primary" id="active_inactive<?php echo $row['id']; ?>">Active</span>
											<?php }else{?>
											<span class="badge badge-danger" id="active_inactive<?php echo $row['id']; ?>">Inactive</span>
										<?php } ?></td>
										<!-- <td><?= date('D, d M Y',strtotime($row['date_created']))?> </td> -->


											
										<td>
											<div class="btn-group dropdown">
													<button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
													<div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
														<a href="javascript:void(0);" onClick="active_staff('<?php echo $row['id']; ?>','active')" class="dropdown-item" title="Active"><i class="icon md-check" aria-hidden="true"></i> Active</a>
														<a href="javascript:void(0);" onClick="inactive_staff('<?php echo $row['id']; ?>','inactive')" class="dropdown-item" title="Active"><i class="icon md-pause" aria-hidden="true"></i> Inactive</a>
														<a href="<?php echo base_url('admin/staff/edit_staff/'.$row['id']);?>"  class="dropdown-item" title="Active"><i class="icon md-edit" aria-hidden="true"></i> Edit</a>
														<a href="<?php echo base_url('admin/staff/manage_permission/'.$row['id']);?>"  class="dropdown-item" title="Active"><i class="icon md-lock" aria-hidden="true"></i>Permissions</a>
														<a href="<?php echo base_url('admin/staff/change_password/'.$row['id']);?>"  class="dropdown-item" title="Active"><i class="icon md-key" aria-hidden="true"></i> Change Password</a>
														<a href="javascript:void(0);" onClick="operation_staff('<?php echo $row['id']; ?>','delete')" class="dropdown-item" title="Delete"><i class="icon md-close" aria-hidden="true"></i> Delete</a>
													</div>
												</div>
											
										</td>

										
									</tr>
									<?php $counter++; } ?>
									
								</tbody>
							</table>
						</form>
						<?php }else{?>
							<div style="width:100%;float:left;text-align:center;">No Staff Added</div>
						<?php }?>
							
					</div>
				</div>
				<!-- End Panel Interaction -->

				<!-- End Page -->
				<div class="modal fade example-modal-sm" aria-hidden="true" aria-labelledby="exampleOptionalSmall"
					role="dialog" tabindex="-1">
					<div class="modal-dialog modal-simple modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
								</button>
								<h4 class="modal-title" id="exampleOptionalSmall">Choose a type</h4>
							</div>
							<div class="modal-body">
								<a href="<?php echo base_url('admin/staff/add/0');?>" class="btn btn-block btn-primary">Staff</a>
								<a href="<?php echo base_url('admin/staff/add/1');?>" class="btn btn-block btn-primary">Location Admin</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<script language="javascript">
function operation_staff(id,op_type)
{
	if(id!="" && op_type!=""){
		 swal({
    title: "Are you sure?",
    //text: "You will not be able to recover this staff!",
    type: "info",
    showCancelButton: true,
    confirmButtonClass: "btn-info",
    confirmButtonText: 'Yes',
    closeOnConfirm: false
  //closeOnCancel: false
  }, function () {
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/Operations/delete_staff/' + encodeURIComponent(id),
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
						swal("Error!", "Something went wrong, please refresh page and try again", "error");
					}
				}
			});
		 swal("Success!", "Action Performed successfully", "success");
  		});
	}else{
		return false;
	}
}

function active_staff(id,op_type)
{
	if(id!="" && op_type!=""){
		 swal({
    title: "Are you sure?",
    //text: "You will not be able to recover this staff!",
    type: "info",
    showCancelButton: true,
    confirmButtonClass: "btn-info",
    confirmButtonText: 'Yes',
    closeOnConfirm: false
  //closeOnCancel: false
  }, function () {
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/Operations/active_staff/' + encodeURIComponent(id),
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
						swal("Error!", "Something went wrong, please refresh page and try again", "error");
					}
				}
			});
		 swal("Success!", "Action Performed successfully", "success");
  		});
	}else{
		return false;
	}
}


function inactive_staff(id,op_type)
{
	if(id!="" && op_type!=""){
		 swal({
    title: "Are you sure?",
    //text: "You will not be able to recover this staff!",
    type: "info",
    showCancelButton: true,
    confirmButtonClass: "btn-info",
    confirmButtonText: 'Yes',
    closeOnConfirm: false
  //closeOnCancel: false
  }, function () {
			$.ajax({
				type: 'POST',
				url: site_url + 'admin/Operations/inactive_staff/' + encodeURIComponent(id),
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
						swal("Error!", "Something went wrong, please refresh page and try again", "error");
					}
				}
			});
		 swal("Success!", "Action Performed successfully", "success");
  		});
	}else{
		return false;
	}
}




function business_staff(val){
	if(val!='')
		location.href= site_url + 'admin/staff?business_id='+val;
	else
		location.href= site_url + 'admin/staff';
}

function delete_selected(){
	swal({
	title: "Are you sure?",
	text: "You will not be able to recover this staff!",
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