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
			            <h1 class="panel-title">Manage Permissions</h1>
						<div class="page-header-actions">
							<a href="<?= base_url('admin/staff') ?>"><button type="button" class="btn btn-block btn-primary waves-effect waves-classic">All Staff</button></a>
						</div>
					</div>
					
		          	<!-- Contacts Content -->
          			<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
						<?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" ){ ?>					
							<div class="page-content-actions">
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
							<form id="frm_customer" name="frm_customer" action="" method="post">
								<table id="example" class="table table-hover  table-striped w-full" data-plugin="">
									<thead>
										<tr>
											<th class="dark-background-heading">Section</th>
											<th class="dark-background-heading">Permission Name</th>
											<?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" ){ ?>	
												<th class="pre-cell dark-background-heading">
													<span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
														<input type="checkbox" class="contacts-checkbox" id="select_all"  />
														<label for="select_all"></label>
													</span>
												</th>
											<?php }?>
										</tr>
									</thead>
									<tbody>
										<?php $counter = 1;foreach($all_records as $parentrow){
												$ChildPermissions = getChildPermissions($parentrow['id']);
												foreach ($ChildPermissions as  $row) {
											?>
											<tr id="row_<?php echo $row['id']; ?>"><?php
													
													
													if($row['parent_id']==0){
														$newClass = 'parent_'.$row['id'];
														$bold_text_start = "<b>";
														$bold_text_end = "</b>";
													}else{
														$newClass = 'child_'.$row['parent_id'];
														$bold_text_start = "----  ";
														$bold_text_end = "";
													}
													$is_permit = getUserPermission($staff_id,$row['id']);
													//print_r($is_permit);
													if($is_permit==1){
														$checked = 'checked="true"';
													}else{
														$checked = '';
													} ?>
												<td><?php echo $bold_text_start.$row['permission_name'].$bold_text_end;?></td>
												<td><?php echo $bold_text_start.$row['description'].$bold_text_end;?></td>
												<?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" ){ ?>	
													<td >
														<span class="checkbox-custom checkbox-primary checkbox-lg">
															<input type="checkbox" class="contacts-checkbox checkbox1 <?php echo $newClass;?>" name="record[]" id="record_<?php echo $row['id'];?>" <?php echo $checked;?> value="<?php echo $row['id'];?>"  />
															<label for="contacts_1"></label>
														</span>
													</td>
												<?php } ?>
											</tr>
										<?php $counter++; } }  ?>
										
									</tbody>
								</table>
							</form>
							<?php }else{?>
							<div style="width:100%;float:left;text-align:center;">No Permissions Available</div>
						<?php }?>
						
					</div>
				</div>
				<!-- End Panel Interaction -->
				
			</div>
		</div>
	</div>
	
	<style type="text/css">
		.dataTables_wrapper .row{
		margin-left:0 !important;
		margin-right:0 !important;
		text-transform: capitalize;
		}
		.page-content-actions {
		padding: 0 10px 10px;
		}
	</style>
	
	<?php $this->load->view('admin/common/footer'); ?>
	
	<script type="text/javascript">

		$(document).ready(function() {
    $('.contacts-checkbox').change(function() {
      var id = '<?php echo $staff_id;?>';
				var checked_status = this.checked;
				var myClass = $(this).attr("class");
				var relationClass = myClass.split(" ").pop();
				//alert(relationClass);
				var permId = $(this).attr('id');
				var permission_id = permId.split("_").pop();
				//alert(permission_id);
				var perm_id_arr =[];
				var is_permit =1;
				if(permission_id == 'all'){
					$( ".checkbox1").each(function() {
						perm_id_arr.push($(this).attr('id').split("_").pop());
						if(checked_status) {
							$("#"+$(this).attr('id')).prop( "checked", true );
						}else{
							$("#"+$(this).attr('id')).prop( "checked", false );
						}	 
					});
				} else{
					perm_id_arr.push($(this).attr('id').split("_").pop());
					if(relationClass.indexOf("parent") != -1){
						$( ".child_"+permission_id ).each(function() {
							perm_id_arr.push($(this).attr('id').split("_").pop());
							if(checked_status) {
								$("#"+$(this).attr('id')).prop( "checked", true );
								}else{
								$("#"+$(this).attr('id')).prop( "checked", false );
							}	 
						});
					}
				}
				if(checked_status) {
					is_permit =1;
					}else{
					is_permit =0;
				}	 
				$.ajax({
					type: 'POST',
					url: site_url + 'admin/Staff/update_permission/' + encodeURIComponent(id),
					data: {permission_id:perm_id_arr,is_permit:is_permit},
					datatype: 'json',
					beforeSend: function() {
					},
					success: function(data)
					{
						data = JSON.parse(data);
						if (data.type == 'success') {
							swal("success!", data.message, "success");
							} else {
							swal("Error!", data.message, "error");
						} 
					}
				});
    });
});



		$(document).ready( function() {
			$('#example').dataTable( {
				order: [],
				columnDefs: [ { orderable: true, targets: [0,-1] } ],
				"lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]]
			});			
			
		});
		
		
	</script>	