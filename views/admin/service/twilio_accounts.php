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
					<h1 class="page-title">Twilio SMS Accounts Settings</h1>
					<div class="page-header-actions"></div>
				</div>
				<div class="page-content container-fluid">
					
							<!-- Panel Static Labels -->
							<form autocomplete="off" method="post" action="">
								<input type="hidden" name="action" value="save">
								<input type="hidden" name="id" value="<?php echo $twilio_accounts['id']?>">
								

								
								<div class="form-group  row" data-plugin="formMaterial">
									<div class=" form-group col-md-4">
										<label class="form-control-label" for="inputGrid1">Select Business*</label>
										<select  name="business_id" id="business_id" class="form-control">
											<option value="">Select Business  </option>
											<?php foreach ($all_business as $key => $value) {
												$select=isset($business_id)?$business_id:$twilio_accounts['business_id'];
												//$selected=$select==$value['id']?'selected':'';
											 ?>
											<option value="admin/service/twilio_accounts/<?php echo $value['id'] ?>"<?php if ($select==$value['id']){echo 'selected';}?>><?php echo $value['name']; ?></option>
											
												
											<?php } ?>
											
											
										</select>
									</div>
									<div class=" form-group col-md-4">
										<label class="form-control-label" for="inputGrid1">Sub Account Name*</label>
										<input type="text" name="sub_account_name" id="sub_account_name" placeholder="Please Enter Subaccount Name..." class="form-control" value="<?php echo isset($sub_account_name)?$sub_account_name:$twilio_accounts['sub_account_name'] ?>">	
										<div class="admin_content_error"><?php echo form_error('sub_account_name'); ?></div>
									</div>

									<div class=" form-group col-md-4">
										<label class="form-control-label" placeholder="Please Enter Account SID..." for="inputGrid1">Account SID*</label>
										<input type="text" placeholder="Please Enter Account SID..."  class="form-control" name="account_sid" id="account_sid" value="<?php echo isset($account_sid)?$account_sid:$twilio_accounts['account_sid'] ?>">
										<div class="admin_content_error"><?php echo form_error('account_sid'); ?></div>	
									</div>

									<div class=" form-group col-md-4">
										<label class="form-control-label" for="inputGrid1">Auth Token*</label>
										<input type="text" placeholder="Please Enter Auth Token..."  class="form-control" name="auth_token" id="auth_token" value="<?php echo isset($auth_token)?$auth_token:$twilio_accounts['auth_token'] ?>">
										<div class="admin_content_error"><?php echo form_error('auth_token'); ?></div>		
									</div>

									<div class=" form-group col-md-4">
										<label class="form-control-label" for="inputGrid1">Mobile Number*</label>
										<input type="text" placeholder="Please Enter Mobile Number..."  class="form-control" name="mobile_number" id="mobile_number" value="<?php echo isset($mobile_number)?$mobile_number:$twilio_accounts['mobile_number'] ?>">
										<div class="admin_content_error"><?php echo form_error('mobile_number'); ?></div>		
									</div>


								</div>
							 <div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-6">
										
										<button class="btn btn-primary" type="submit">Save</button>
									</div>
								</div> 
								
							</form>
							<!-- End Panel Static Labels -->
						
					
				</div>
			</div>
		</div>
	</div>
	<!-- End Page -->
	<?php $this->load->view('admin/common/footer'); ?>

	<script type="text/javascript">
		  $("#business_id").change(function(){

    if($(this).val() != ''){
      //alert('<?php //echo base_url(); ?>'+$(this).val());
      window.location.replace('<?php echo base_url(); ?>'+$(this).val());
    }
  });
		
	</script>