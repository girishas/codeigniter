<style type="text/css">
	
</style>
<?php $this->load->view('admin/common/header'); ?>

<body class="animsition app-contacts page-aside-left">
	<?php $this->load->view('admin/common/navbar'); ?>
	
	<link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
	<?php $this->load->view('admin/common/left_menubar');  ?> 
	<style type="text/css">
		.page-item a{
		position: relative;
    display: block;
    padding: .643rem 1.072rem;
    margin-left: -1px;
    line-height: 1.57142857;
    text-decoration: none;
    color: #757575;
    background-color: transparent;
    border: 1px solid #dee2e6;
    margin-left: 0;
    border-top-left-radius: .215rem;
    border-bottom-left-radius: .215rem;
		}
		.page-item.active a {
	    z-index: 1;
	    color: #fff;
	    background-color: #00a0d7;
	    border-color: #00a0d7;
	}
	.dataTables_wrapper .row{
					margin-left:0 !important;
					margin-right:0 !important;
				}
				.page-content-actions {
				padding: 0 10px 10px;
				}
	</style>
	
	<div class="page">
		<div class="page-content">
			<div class="panel">
				<?php $this->load->view('admin/common/header_messages');  ?>
				
				<div class="page-header">
					<h1 class="page-title">Staff's Audit History</h1>
					<div class="page-header-actions"><a href="<?php echo base_url('admin/audit/history');?>"><button type="button" class="btn btn-block btn-primary">All Staff</button></a></div>
				</div>
				
				<div class="page-main">
					<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
						<div class="page-content-actions"></div>
						<input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
						<input type="hidden" name="search_width" id="search_width" value="232px">
						<form id="frm_customer" name="frm_customer" action="<?php echo base_url('admin/audit/view/'.$user_id);?>" method="post">
				        	<div class="form-group" style="width:30%;margin-left: 16px;margin-bottom: 0px;">
								<input autocomplete="off" type="text" name="audit_search" class="form-control" id="email" placeholder="Search By Action or Table Name" value="<?php echo isset($audit_search)?$audit_search:''; ?>">
							</div>
						</form>
						
						<table id="example" class="table table-hover table-striped w-full" >
							<thead>
								<tr>
									<th class="cell-10 dark-background-heading" scope="col">S.No.</th>
									<th class="cell-10 dark-background-heading" scope="col">Action </th>
									<th class="cell-10 dark-background-heading" scope="col">Table Name </th>
									<th class="cell-10 dark-background-heading" scope="col" >Description </th> 
									<th class="cell-10 dark-background-heading" scope="col">Action Date </th> 
								</tr>
							</thead>
							<tbody>
								
							<?php if($offset){
									$counter = $offset+1;
								}else{
									$counter = 1;
								} 
								  foreach($viewData as $key=>$value){ ?>
									<tr id="row_<?php echo $value['id']; ?>">
										<td><?php echo $counter ;?></td>
										<td><?php echo $value['type'] ;?></td>
										<td><?php echo ucfirst($value['table_name']) ; ?></td>
										<td ><?php echo substr(wordwrap($value['description'], 60, "<br>"),0,120); ?>...</td>
										<td><?php echo date('D d M Y h:i:s',strtotime($value['created_at'])) ; ?></td>
										
									</tr>
								<?php	$counter++; } ?>
								
							</tbody>
						</table>
						<?php echo $links; ?>
						<?php if($count==0){ ?>
						<div style="width:100%;float:left;text-align:center;">No Audit History</div>
						<?php }?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php $this->load->view('admin/common/footer'); ?>
	<script type="text/javascript">
		$(document).ready( function() {
			$('#example').dataTable( {
				paging:false,
				searching:false,
				info:false
				order: [],
				//columnDefs: [ { orderable: true, targets: [0,-1] } ] 
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
