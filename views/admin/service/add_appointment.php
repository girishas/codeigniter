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
				<div class="page-header">
					<h1 class="page-title">Add New Appointment</h1>
					<div class="page-header-actions"><a href="<?php echo base_url('admin/service/appointments');?>"><button type="button" class="btn btn-block btn-primary">All Appointments</button></a></div>
				</div>
				<div class="page-content container-fluid">
					<div class="row">
						<div class="col-md-6">
							<!-- Panel Static Labels -->
							<div class="panel">
								
								<div class="panel-body container-fluid">
									<form autocomplete="off">
										<div class="form-group  row" data-plugin="formMaterial">
											<div class="col-md-12">
												<label class="form-control-label" for="inputGrid1">Service</label>
												<select class="form-control">
													<option>Select</option>
													<optgroup label="Hair">
														<option>Hair Cut ($25)</option>
														<option>Hair Color ($26)</option>
														<option>Hair Textures ($15)</option>
														<option>Hair Blowouts ($5)</option>
														<option>Hair Styling ($25)</option>
													</optgroup>
													<optgroup label="Face">
														<option>Waxing ($50)</option>
														<option>Facial ($35)</option>
													</optgroup>
													<optgroup label="Body">
														<option>Message ($20)</option>
													</optgroup>
												</select>
											</div>
										</div>
										
										<div class="form-group  row" data-plugin="formMaterial">
											<div class="col-md-12">
												<label class="form-control-label" for="inputGrid1">Staff</label>
												<select class="form-control">
													<option>Select</option>
													<option>Oliver</option>
													<option>William</option>
													<option>Amelia</option>
													<option>Jack</option>
												</select>
											</div>
										</div>
										
										<div class="form-group  row" data-plugin="formMaterial">
											<div class="col-md-12">
												<label class="form-control-label" for="inputGrid1">Start Time</label>
												<select class="form-control">
													<option>Select</option>
													<option>12:00am</option>
													<option>12:10am</option>
													<option>12:20am</option>
													<option>12:30am</option>
													<option>12:40am</option>
													<option>12:50am</option>
													<option>12:60am</option>
												</select>
											</div>
										</div>
										
										<div class="form-group  row" data-plugin="formMaterial">
											<div class="col-md-12">
												<label class="form-control-label" for="inputGrid1">Duration</label>
												<input type="text" class="form-control" id="inputPlaceholder"	>
											</div>
										</div>
										<div class="form-group  row" data-plugin="formMaterial">
											<div class="col-md-6">
												<button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
											</div>
										</div>
										
									</form>
								</div>
							</div>
							<!-- End Panel Static Labels -->
						</div>
						<div class="col-md-6">
							<!-- Panel Floating Labels -->
							<div class="panel">
								<div class="panel-body container-fluid">
									<form autocomplete="off">
										<div class="form-group  row" data-plugin="formMaterial">
											<div class="col-md-12">
												<label class="form-control-label" for="inputGrid1">Customer Name</label>
												<select class="form-control">
													<option>Select</option>
													<option>Ronnie Ellis</option>
													<option>Willard Wood</option>
													<option>Heather Harper</option>
													<option>Crystal Bates</option>
												</select>
											</div>
										</div>
										
										<div class="form-group  row" data-plugin="formMaterial">
											<div class="col-md-12">
												<a href="javascript:void(0);" onClick="$('#add_new_customer').toggle();">
													<button type="button" class="btn btn-primary waves-effect waves-classic"><i class="icon md-plus" aria-hidden="true"></i>New Customer</button>
												</a>
											</div>
										</div>
										<span id="add_new_customer" style="display:none;">
											<div class="form-group  row" data-plugin="formMaterial">
												<div class="col-md-12">
													<label class="form-control-label" for="inputGrid1">First Name</label>
													<input type="text" class="form-control" id="inputPlaceholder"	>
												</div>
											</div>
											<div class="form-group  row" data-plugin="formMaterial">
												<div class="col-md-12">
													<label class="form-control-label" for="inputGrid1">Last Name</label>
													<input type="text" class="form-control" id="inputPlaceholder"	>
												</div>
											</div>
											<div class="form-group  row" data-plugin="formMaterial">
												<div class="col-md-12">
													<label class="form-control-label" for="inputGrid1">Mobile Number</label>
													<input type="text" class="form-control" id="inputPlaceholder"	>
												</div>
											</div>
											<div class="form-group  row" data-plugin="formMaterial">
												<div class="col-md-12">
													<label class="form-control-label" for="inputGrid1">Email</label>
													<input type="text" class="form-control" id="inputPlaceholder"	>
												</div>
											</div>
										</span>
									</form>
								</div>
							</div>
							<!-- End Panel Floating Labels -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page -->
	<?php $this->load->view('admin/common/footer'); ?>