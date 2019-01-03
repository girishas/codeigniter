    <style type="text/css">
		.dataTables_wrapper .row{
		margin-left:0 !important;
		margin-right:0 !important;
		}
		.page-content-actions {
		padding: 0 10px 10px;
		}
	</style>
<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
	<?php $this->load->view('admin/common/navbar'); ?>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
	<?php $this->load->view('admin/common/left_menubar');  ?> 
	<div class="page">
		<div class="page-content">
			<div class="panel">
			<?php $this->load->view('admin/common/header_messages'); ?>
				<div class="page-header">
					<h1 class="page-title">All Staff Members</h1>
				</div>
				
				<div class="page-main">
					<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
						<table id="example" class="table table-hover table-striped w-full" >
							<thead>
								<tr>
									<th class="cell-10 dark-background-heading" scope="col">S.No.</th>
									<th class="cell-10 dark-background-heading" scope="col">Staff Name</th>
									<th class="cell-10 dark-background-heading" scope="col">Location</th>
									 
									<th class="cell-10 dark-background-heading" scope="col">Actions</th>
									
								</tr>
							</thead>
							<tbody>
								
								<?php $counter=1; foreach($business_staff as $key=>$value){ ?>
									<tr>
									<td><?php echo $counter; ?></td>
									<td><?php echo $value['admin_name'] ;?></td>
									<td><?php echo $value['location_name'] ;?></td>
									<td><a href="<?php echo base_url('admin/audit/view/'.$value['id']);?>"><i class="icon md-eye" aria-hidden="true"></i> Audit History</a></td>
									</tr>
								<?php $counter++;	} ?>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
		
<?php $this->load->view('admin/common/footer'); ?>
<script type="text/javascript">
		$(document).ready( function() {
			$('#example').dataTable( {
				order: [],
				columnDefs: [ { orderable: false, targets: [-1] } ]
			});
		});
	</script>
