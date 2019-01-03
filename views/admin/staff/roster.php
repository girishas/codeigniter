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
				<div class="page-header" style="padding-bottom: 0px;">
					<h1 class="page-title" >Roster</h1><hr>
					<!-- <div class="page-header-actions"><a href="<?= base_url('admin/staff') ?>"><button type="button" class="btn btn-block btn-primary waves-effect waves-classic">View All</button></a></div> -->
				</div>
				<?php
				//echo date("N",strtotime("05-07-2018")) ;
				/*
				if(isset($admin_session['role']) && $admin_session['role']=="owner"){?>
				<div class="btn-group btn-group-flat" style="margin-left:5px;">
						<select class="form-control" style="margin-left: 25px;" onChange="return business_staff(this.value);">
							<option value="">All Business</option>
							<?php if($all_business){?>
							<?php foreach($all_business as $business){?>
							<option value="<?php echo $business['id'];?>" <?php if(isset($business_id) && $business_id==$business['id']) echo "selected";?>><?php echo $business['name'];?></option>
							<?php } } ?>
						</select>
				</div>
				<?php } */?>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<?php
							$weeks = array(0=>"Monday",1=>"Tuesday",2=>"Wednesday",3=>"Thursday",4=>"Friday",5=>"Saturday",6=>"Sunday"); ?>
							<th class="cell-300  text-center"><b>Staff</b></th>
							<?php foreach ($weeks as $key => $value) { ?>
							<th class="cell-100  text-center" scope="col"><b><?= $value; ?></b></th>
							<?php } ?>
						</thead>
						<tbody>
							<?php 
							if($data){
							foreach ($data as $key => $value): ?>
								<tr>
									<td class="text-center"><a href="<?= base_url('admin/staff/working_hours/'.$key)?>"><?=getStaffName($key);?></a></td>
									<?php for ($i=0; $i <7 ; $i++) { ?>
										<td class="text-center">
											<?php 
												if(isset($value[$i])){ ?>
		<button style="padding: 5px 5px;font-size: 11px;" data-target="#inventeryDetail" data-toggle="modal" type="buton" onclick="getWorkDetails(<?= $i;?>,<?= $key; ?>)" class="btn btn-info btn-sm"><?= date('h:i a',strtotime($value[$i]['start_hours']))." - ".date('h:i a',strtotime($value[$i]['end_hours'])) ?></button>
												<?php }else{
													echo "No Work";
												}
											?>
										</td>
									<?php } ?>
								</tr>
							<?php endforeach ?>
							<?php }else{?>
								<tr>
									<td class="text-center" colspan="8"> No Record Found</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				
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
	function business_staff(val){
	if(val!='')
		location.href= site_url + 'admin/staff/roster?business_id='+val;
	else
		location.href= site_url + 'admin/staff/roster';
	}
		</script>
		<?php $this->load->view('admin/common/footer'); ?>