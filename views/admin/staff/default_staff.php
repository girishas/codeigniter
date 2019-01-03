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
					<h1 class="page-title">Default staff Processed by</h1>
					<div class="page-header-actions"><a href="<?php echo base_url('admin/setup');?>"><button type="button" class="btn btn-block btn-primary">Setup</button></a></div>
				</div>
				<div class="page-content container-fluid">
					<div class="row">
						<div class="col-md-12">
							<!-- Panel Static Labels --> 
							<form autocomplete="off" method="post" action="">
								<input type="hidden" name="action" value="save">
								<div class="form-group" data-plugin="formMaterial">
									<?php
									$status = array(0=>"No",1=>"Yes");
									 foreach ($locations as $key => $value): ?>
										<div class="row">
											<div class="col-md-4">
											<h4><?= $value['location_name']?></h4></div>
											<div class="col-md-3">
												<select class="form-control" name="status[<?=$value['id']?>]">
													<?php foreach ($status as $kkey => $vvalue): 
														if(isset($default_staff[$value['id']])){
															$selected = ($kkey==$default_staff[$value['id']])?"selected":"";
														}else{
															$selected = "";
														}
														?>
														<option <?=$selected;?> value="<?=$kkey?>"><?=$vvalue?></option>
													<?php endforeach ?>
												</select>
							                </div>
										</div>
									<?php endforeach ?>
								</div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-6">
										<button class="btn btn-primary" type="submit">Save</button>
										<a class="btn btn-secondary" href="<?=base_url('/admin/setup')?>">Cancel</a>
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