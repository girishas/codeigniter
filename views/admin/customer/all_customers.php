<?php $this->load->view('admin/common/header'); ?>

<body class="animsition app-contacts page-aside-left">
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>"> -->
	<?php $this->load->view('admin/common/left_menubar'); ?>
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
						<h1 class="panel-title">All Customers</h1>
						<div class="page-header-actions"><a href="<?php echo base_url('admin/customer/add_customer');?>"><button type="button" class="btn btn-block btn-primary">Add Customer</button></a></div>
					</div>
					<!-- Contacts Content -->
					<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable"> 
						<!-- Actions -->
						<div class="page-content-actions">   
							<div class="btn-group btn-group-flat" style="margin-left:5px;">
								<button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
							</div>
							<div class="btn-group btn-group-flat" style="margin-left:5px;">
								<!-- selected records merge -->
								<form method="post" action="<?php echo base_url('admin/customer/merge_customers'); ?>">
									<input type="hidden" required="required" name="m_id" id="m_id">
									<button type="submit" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Merge Selected</button>
								</form>
								<!-- selected records merge -->
							</div>
							
							<div class="btn-group btn-group-flat" style="margin-left:5px;">
								<a  href="<?php echo base_url('admin/customer/export_to_csv');?>">
									<button type="button" class="btn btn-success waves-effect waves-classic">
									<i class="icon md-upload text" aria-hidden="true"></i><span class="text">Export to CSV</span></button></a>
								</div>
								
								<div class="btn-group btn-group-flat" style="margin-left:5px;">
									<a  href="<?php echo base_url('admin/customer/import_to_csv');?>">
										<button type="button" class="btn btn-success waves-effect waves-classic">
										<i class="icon md-upload text" aria-hidden="true"></i><span class="text">Import to CSV</span></button></a>
									</div>
									 
									
								</div>
								<input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
								<input type="hidden" name="search_width" id="search_width" value="232px">
								<?php  
						if($count>0){?>
								<!-- Contacts -->
								<form id="frm_customer" name="frm_customer" action="" method="post">
									<div class="form-group" style="width:30%;margin-left: 16px;margin-bottom: 0px;">
									    <input autocomplete="off" type="text" name="customer_search" class="form-control" id="email" placeholder="Search Customer" value="<?php echo isset($customer_search)?$customer_search:'';?>">
									</div>
									
									<table id="example" class="table table-hover table-striped w-full">
										<thead>
											<tr>
												<th class="dark-background-heading">
													<span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
						                            <input type="checkbox" class="contacts-checkbox" id="select_all" />
						                            <label for="select_all"></label>
						                          </span>
												</th>
												<th class="dark-background-heading">Image</th>
												<th class="dark-background-heading">Customer Number</th>
												<th class="dark-background-heading">Customer Name</th>
												<th class="dark-background-heading">Mobile Number</th>
												<th class="dark-background-heading">Email</th>
												<th class="dark-background-heading">Created On</th>
												<th class="dark-background-heading">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php $counter = 1;foreach($all_records as $row){?>
											<tr id="row_<?php echo $row['id']; ?>">
												
												<td> <span class="checkbox-custom checkbox-primary checkbox-lg">

													<input type="checkbox" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $row['id'];?>"/>
													<label for="contacts_1"></label> </span>
													<?php //echo $row['id']; ?>
												</td>
												
												<td><?php if(!empty($row['photo'])){ ?>
													<a href="<?php echo base_url('admin/customer/edit_customer/'.$row['id']);?>">
														<img class="img-fluid" src="<?php echo base_url('images/customer/thumb/'.$row['photo']); ?>" width="50" />
														<?php }else{?>
														<!-- <img class="img-fluid" src="<?php echo base_url('global/product/no-product-image.jpg');?>" width="50" > --> N/A
													<?php } ?></a></td>
													
													<td><?php echo ($row['customer_number'])?$row['customer_number']:"---";?></td>
													<td><a href="<?php echo base_url('admin/customer/detail/'.$row['id']);?>"><?php echo $row['first_name'].' '.$row['last_name'];?></a></td>
													
													<td><?php 
													if ($row['country_code'] !='') {
														echo "+".$row['country_code'].' '.$row['mobile_number'];
													}
													else{
														echo $row['mobile_number'];
													}
													
													?></td>
													
													
													
													<td><?php echo $row['email'];?></td>
													<td><?php echo date("D, M d Y",strtotime($row['date_created']));?></td>
													
													<td><div class="btn-group dropdown">
														<button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
														<div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
															<a class="dropdown-item" href="<?php echo base_url('admin/customer/edit_customer/'.$row['id']);?>" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
															<a class="dropdown-item" href="<?php echo base_url('admin/customer/detail/'.$row['id']);?>" role="menuitem"><i class="icon md-eye" aria-hidden="true"></i>View</a>
															<a class="dropdown-item" href="javascript:void(0)" onClick="operation_customer('<?php echo $row['id']; ?>','delete')" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a>
														</div>
													</div></td>
													
												</tr>
												<?php $counter++;}?>
											</tbody>
										</table>
									</form>
									<?php echo $links; ?>
									<?php }else{?>
									<div style="width:100%;float:left;text-align:center;">No Customer Found</div>
									<?php }?>
									<!--<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End page -->
			<!-- 	<script language="javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.js');?>"></script>
				<script language="javascript" src="<?php echo base_url('assets/js/jquery.suggestion.js');?>"></script> -->
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
				function operation_customer(id)
				{
					if(id!=""){
						swal({
				            title: "Are you sure?",
				            text: "You will not be able to recover this customer!",
				            type: "info",
				            showCancelButton: true,
				            confirmButtonClass: "btn-info",
				            confirmButtonText: 'Yes, delete it!',
				            closeOnConfirm: false
				          //closeOnCancel: false
				          }, function () {
							$.ajax({
								type: 'POST',
								url: site_url + 'admin/Operations/delete_customer/' + encodeURIComponent(id),
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
					            swal("Deleted!", "Customer has been deleted!", "success");
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
						}else{
							var id = $(this).val();
							var index = abc.indexOf(id);
							if (index > -1) {
							  abc.splice(index, 1);
							}
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
				
				
<?php $this->load->view('admin/common/footer'); ?>

<script type="text/javascript">

$(document).ready( function() {
	//$('#example').hide();
  $('#example').dataTable( {
    order: [],
   	paging:false,
   	searching:false,
   	info:false
  });
});
</script>