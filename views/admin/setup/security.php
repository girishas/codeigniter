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
			<div class="panel">
				<?php $this->load->view('admin/common/header_messages'); ?>
				<div class="page-header">
					<h1 class="page-title">Security</h1>
					<div class="page-header-actions"><a href="<?php echo base_url('admin/setup');?>"><button type="button" class="btn btn-block btn-primary">Setup</button></a></div>
				</div>
				<div class="page-content container-fluid">
					<div class="row">
						<div class="col-md-8">
							<!-- Panel Static Labels --> 
							<form autocomplete="off" method="post" action="">
								<input type="hidden" name="action" value="save"> 
								<?php foreach ($locations as $key => $value): ?>
									<input type="hidden" value="<?=$value['id']?>" name="location_id[]">
									<div class="form-group">
										<div class="row">
											<div class="col-md-4">
												<b><?=$value['location_name']?></b>
											</div>
											<div class="col-md-8">
												<?php
													if(isset($old_array[$value['id']])){
														$selected = $old_array[$value['id']]['ip_address'];
													}else{
														$selected = "";
													}
												?>
												<input type="text" value="<?=$selected;?>" class="form-control" name="ip_address[]">
											</div>
										</div>
									</div>
								<?php endforeach ?>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-12">
										<button class="btn btn-primary" type="submit">Save</button>
									</div>
								</div> 
							</form>
							<!-- End Panel Static Labels -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page -->
	<?php $this->load->view('admin/common/footer'); ?>