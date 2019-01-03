<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<div class="page">
		<div class="page-content">
			<div class="panel nav-tabs-horizontal" data-plugin="tabs">
				<div class="page-header">
					<h1 class="page-title">Staff Information</h1>
					<div class="page-header-actions"><a href="<?= base_url('admin/staff') ?>"><button type="button" class="btn btn-block btn-primary waves-effect waves-classic">View All</button></a></div>
				</div>
				<ul class="nav nav-tabs nav-tabs-line" role="tablist">
					<li class="nav-item" style=""><a class="nav-link show active" href="<?php echo base_url('admin/staff/view/'.$id); ?>"><i class="icon md-home" aria-hidden="true"></i>All Information</a></li>
					<li class="nav-item" style=""><a class="nav-link" href="<?php echo base_url('admin/staff/services/'.$id); ?>"><i class="icon md-account" aria-hidden="true"></i>Services</a></li>
					<!-- <li class="nav-item" style=""><a class="nav-link" href="<?php echo base_url('admin/staff/working_hours/'.$id); ?>"><i class="icon md-label" aria-hidden="true"></i>Working Hours</a></li> -->
				</ul>
				<div class="panel-body">
					<div class="tab-content">
						<div class="tab-pane active show" id="exampleTopHome" role="tabpanel">
							<div class="row">
								<h4 class="col-md-6">Staff Details : </h4>
								<?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){?>
								<div class="col-md-6 text-right"><a href="<?= base_url('admin/staff/edit_staff/'.$id) ?>" class="btn btn-floating btn-success btn-sm waves-effect waves-classic"><i class="icon md-edit" aria-hidden="true"></i></a>
								</div>
								<?php }?>

							</div><br>
							<div class="row">
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Name : </b></label>
									<?= $staff_detail['first_name']." ".$staff_detail['first_name']; ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Email : </b></label>
									<?= $staff_detail['email']; ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Mobile : </b></label>
									<?= $staff_detail['mobile_number']; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Business : </b></label>
									<?= getBusinessNameById($staff_detail['business_id']); ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Location : </b></label>
									<?= getLocationNameById($staff_detail['location_id']); ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Type : </b></label>
									<?php echo ($staff_detail['staff_type']==0)?"Staff":"Location Owner" ?>
								</div>
							</div>

							   <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){?>
							<div class="row">
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Job Title : </b></label>
									<?= $staff_detail['job_title']; ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Service Comm. : </b></label>
									<?= $staff_detail['service_commission']." %"; ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Product Comm. : </b></label>
									<?= $staff_detail['product_commission']." %"; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Voucher Comm. : </b></label>
									<?= $staff_detail['vouchar_commission']." %"; ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Employee Since : </b></label>
									<?= date('F d,Y',strtotime($staff_detail['employment_start_date'])); ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Address</b></label>
									<?= $staff_detail['address1']; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>City : </b></label>
									<?= $staff_detail['city']; ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>State : </b></label>
									<?= $staff_detail['state']; ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Country</b></label>
									<?= $staff_detail['country_id']; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Post Code : </b></label>
									<?= $staff_detail['post_code']; ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Notes : </b></label>
									<?= $staff_detail['notes']; ?>
								</div>
								<div class="col-md-4">
									<label class="control-label col-md-6"><b>Photo</b></label>
									<img src="<?= base_url('images/staff/thumb/'.$staff_detail['picture']) ?>" width="100">
								</div>
							</div>
							<div class="row">
								<?php $calendor_bookable_staff = (isset($calendor_bookable_staff) && $calendor_bookable_staff!='')?$calendor_bookable_staff:$staff_detail['calendor_bookable_staff'];?>
								 
								  		<div class="col-md-4">											  
											<label class="control-label col-md-6"><strong>Calendor Bookable Staff :</strong></label>
											<?php if(isset($calendor_bookable_staff)) { if($calendor_bookable_staff == 1) {echo "Yes"; }else{ echo "N/A";} } ?>
								  		</div>
								<?php $roaster_staff = (isset($roaster_staff) && $roaster_staff!='')?$roaster_staff:$staff_detail['roaster_staff'];?>
								 
								  		<div class="col-md-4">											  
											<label class="control-label col-md-6"><strong>Roaster Staff :</strong></label>
											<?php if(isset($roaster_staff)) { if($roaster_staff == 1) {echo "Yes"; }else{ echo "N/A";} } ?>
								  		</div>
								<?php $applocation_access = (isset($applocation_access) && $applocation_access!='')?$applocation_access:$staff_detail['applocation_access'];?>
								 
								  		<div class="col-md-4">											  
											<label class="control-label col-md-6"><strong>Applocation Access :</strong></label>
											<?php if(isset($applocation_access)) { if($applocation_access == 1) {echo "Yes"; }else{ echo "N/A";} } ?>
								  		</div>
							</div>
							<br>
							<?php /*
							<div class="row">
								<h4 class="col-md-6">Normal Working Hours : </h4>
								<div class="col-md-6 text-right"><a href="<?= base_url('admin/staff/working_hours/'.$id) ?>" class="btn btn-floating btn-success btn-sm waves-effect waves-classic"><i class="icon md-edit"></i></a></div>
							</div><br>
							<div class="row">
								<?php if($staff_data){ ?>
								<table class="table is-indent table-bordered" data-plugin="animateList" data-animate="fade" data-child="tr" data-selectable="selectable">
									<thead>
										<?php
										$weeks = array(0=>"Monday",1=>"Tuesday",2=>"Wednesday",3=>"Thursday",4=>"Friday",5=>"Saturday",6=>"Sunday"); ?>
										<?php foreach ($weeks as $key => $value) { ?>
										<th class="cell-300  text-center" scope="col"><b><?= $value; ?></b></th>
										<?php } ?>
									</thead>
									<tbody>
										<tr>
											<?php
												foreach ($weeks as $key => $value) {
											if(isset($staff_data[$key]['week_day']) and $staff_data[$key]['week_day']==$key){ ?>
											<td class="text-center">
												<button style="padding: 5px 5px;font-size: 12px;" data-target="#inventeryDetail" data-toggle="modal" type="buton" onclick="getWorkDetails(<?= $staff_data[$key]['week_day'];?>,<?= $id; ?>)" class="btn btn-info btn-md"><?= date('h:i a',strtotime($staff_data[$key]['start_hours']))." - ".date('h:i a',strtotime($staff_data[$key]['end_hours'])) ?></button></td>
											<?php }else{ ?>
											<td style="vertical-align: middle;text-align: center;">Not working on this day</td>
											<?php } ?>
											
											<?php	}?>
										</tr>
									</tbody>
								</table>
							<?php }else{
								echo "<div style='text-align:center;width:100%;'>No Working Hours Assigned<br><br>
											<a href='".base_url('admin/staff/working_hours/'.$id)."' class='btn btn-info'>Assign Now</a></div>";
							} ?>
							</div>
							*/?>
							<?php } ?>
							<div class="row">
								<h4 class="col-md-6">Assigned Services : </h4>
								<div class="col-md-6 text-right"><a href="<?= base_url('admin/staff/services/'.$id) ?>" class="btn btn-floating btn-success btn-sm waves-effect waves-classic"><i class="icon md-edit"></i></a></div>
							</div><br>
							<div class="row">
								<?php
								if(count((array)$assigned_services)>0){
								foreach ($assigned_services as $key => $value) { ?>
								<div class="col-md-3">
									<b><i class="fa fa-check-circle-o"></i>&nbsp;<?= $value['service_name']; ?></b>
								</div>
								<?php }}else{
									echo "<div style='text-align:center;width:100%;'>No Services Assigned<br><br>
											<a href='".base_url('admin/staff/services/'.$id)."' class='btn btn-info'>Assign Services</a></div>";
									} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade modal-fade-in-scale-up" id="inventeryDetail" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
			<div class="modal-dialog modal-simple">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Working Hours</h4>
					</div>
					<div class="modal-body inventeryDetailBody">
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			function getWorkDetails(day,user_id){
				$.ajax({
		              type: 'POST',
		              url: site_url + 'admin/Staff/getWorkDetails/' + encodeURIComponent(day)+'/'+encodeURIComponent(user_id),
		              datatype: 'json',
		              beforeSend: function() {},
		              success: function(data) {
		                $(".inventeryDetailBody").html(data);
		              }
		          });
				
			}
		</script>
		<?php $this->load->view('admin/common/footer'); ?>