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
		<div class="page-content">
			<div class="panel">
		
		
		<div class="page-header">
			<h1 class="page-title">All Templates</h1>
			<div class="page-header-actions">
				<a class="btn btn-info" href="<?php echo base_url('admin/emailtemplate/add_emailtemplate');?>">Add Tempaltes </a>
				<a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
			</div>
		</div>
		
		<!-- Contacts Content -->
		<div class="page-main">
			<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
				<?php if(isset($all_templates)){?>
				<!-- Actions -->
				<div class="page-content-actions">
					<div class="btn-group btn-group-flat" style="margin-left:5px;">
						<button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
					</div>
				</div>
				
				<input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
				<input type="hidden" name="search_width" id="search_width" value="232px">
				
				<!-- Contacts -->
				<form id="frm_customer" name="frm_customer" action="" method="post">
					<table id="example" class="table table-hover  table-striped w-full" data-plugin="">
						<thead>
							<tr>
								<th class=" dark-background-heading">
									<span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
		                            	<input type="checkbox" class="contacts-checkbox" id="select_all" />
		                            	<label for="select_all"></label>
		                          	</span>
								</th>
								<th class="cell-10 dark-background-heading" scope="col">Title</th>
								<th class="cell-10 dark-background-heading" scope="col">Slug</th>
								<th class="cell-10 dark-background-heading" scope="col">Subject</th>
								<th class="cell-10 dark-background-heading" scope="col">Added date</th>
								<th class="cell-10 dark-background-heading" scope="col">Actions</th>
							</tr>
						</thead>
						<tbody>
							
							<?php $counter = 1;foreach($all_templates as $row){?>
							<tr id="row_<?php echo $row['id']; ?>">
								
								<td>
									<span class="checkbox-custom checkbox-primary checkbox-lg">
										<input type="checkbox" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $row['id'];?>"/>
										<label for="contacts_1"></label>
									</span>
								</td>
								
								<td><?php echo $row['title'];?></td>
								<td><?php echo $row['slug'];?></td>
								<td><?php echo $row['subject'];?></td>
								<!-- <td><?php echo $row['shortcodes'];?></td>
								<td><?php echo $row['email_html'];?></td> -->
								<td><?php echo date('Y-m-d',strtotime($row['created_at']));?></td>
								
								<td>
									<div class="btn-group dropdown">
										<button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
										<div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
											<a class="dropdown-item" href="<?php echo base_url('admin/emailtemplate/edit_emailtemplate/'.$row['id']);?>" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
											<a class="dropdown-item" href="javascript:void(0)" onClick="operation_template('<?php echo $row['id']; ?>','delete')" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a>
										</div>
									</div>
								</td>
							</tr>
							<?php $counter++; } ?>
						</tbody>
					</table>
				</form>
				<?php }else{?>
				<div style="width:100%;float:left;text-align:center;">No Customer Added</div>
				<?php }?>
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
	

	function operation_template(id)
	{
		if(id!=""){
			swal({
	            title: "Are you sure?",
	            text: "You will not be able to recover this template!",
	            type: "info",
	            showCancelButton: true,
	            confirmButtonClass: "btn-info",
	            confirmButtonText: 'Yes, delete it!',
	            closeOnConfirm: false
	          //closeOnCancel: false
	          }, function () {
				$.ajax({
					type: 'POST',
					url: site_url + 'admin/Operations/delete_template/' + encodeURIComponent(id),
					datatype: 'json',
					beforeSend: function() {
					},
					success: function(data)
					{
						data = JSON.parse(data);
						if (data.status == 'not_logged_in') {
							location.href= site_url + 'admin'
						}else if (data.status == 'success') {
							$("#row_"+id).hide().remove();
						} else {
						swal("Error!", "Something went wrong, please refresh page and try again", "error");
		                  }
		                }
		              });
		            swal("Deleted!", "Template has been deleted!", "success");
		          });
		}else{
			return false;
		}
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
			document.frm_customer.submit();
		});
	}



	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#m_id").val('');
		var abc = [];
		$('.checkbox1').click(function(){
			if($(this).is(":checked")) {
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
				data:{abc:abc},
				beforeSend: function() {
				},
				success: function(data)
					{
					//alert(data);
					//return false;
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

  // $( ".table thead tr th:first" ).attr( "class","dark-background-heading" );
  // $( ".table thead tr th:last" ).attr( "class","dark-background-heading" );
  //  $( ".table" ).click(function(){
  //    $( ".table thead tr th:first" ).attr( "class","dark-background-heading" );
  //    $( ".table thead tr th:last" ).attr( "class","dark-background-heading" );
  //  });
});
</script>