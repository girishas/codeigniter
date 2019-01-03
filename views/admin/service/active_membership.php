<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<style type="text/css">
		.pricing-list .pricing-price{
		font-size: 1.858rem;
	}
	.pricing-title{
		background-color: #0E7CA0;
			color: #fff;
			font-size: 21px!important;
		}
		

		

	</style>
	<div class="page">
		
		<!-- Alert message part -->
		<?php $this->load->view('admin/common/header_messages'); ?>
		<!-- End alert message part -->
		<!-- Contacts Content -->
		<div class="page-main">
			<div class="page-content">
				<div class="panel">
					<!-- Contacts Content Header -->
					<!-- <div class="page-header">
										<div class="page-header-actions">
							<a class="btn btn-info" href="<?php echo base_url('admin/service/add_service');?>">Add Service </a>
						</div>
					</div> -->
					
					<!-- Contacts Content -->
					<div class="panel-body">
						<div class="row">
							<?php foreach ($allPlans as $key => $Plans) { ?>
							<div class="col-md-3">

						<form action="<?php echo base_url('/admin/service/cancelSubscription') ?>" method="POST">
						<input name="plan" type="hidden" value="<?=$Plans['stripe_plan_id']?>" />
						<input name="plan_name" type="hidden" value="<?=$Plans['name']?>" />
						<input name="plan_price" type="hidden" value="<?=$Plans['plan_price']?>" />
						<input name="plan_staff_limit" type="hidden" value="<?=$Plans['staff_allowed']?>" />

								<?php if ($Plans['stripe_plan_id']==$user_data['stripe_plan_id'] ) {
										?>
									<?php if ($user_data['is_subscription_canceled']==1) { 
									$plan_colour="background-color: #ff9800 !important";
										?>
										<h4 style="text-align:center;">Cancelled Plan</h4><hr>
									<?php }
									else {
										$plan_colour="background-color:green !important";
									 ?>
									<h4 style="text-align:center;">Active Plan</h4><hr>

									<?php } ?>

									
									
									
								<?php }
								else {
									$plan_colour="background-color: #0E7CA0 !important";
								 ?>
								 <h4 style="text-align:center;">Upgrade Plan</h4><hr>
							<?php } ?>
								
								
								<div class="pricing-list">
									<div class="pricing-header">

										<div class="pricing-title" style="<?php echo $plan_colour ?>"><?=$Plans['name']?></div>
										<div class="pricing-price">
											<span class="pricing-currency">$</span>
											<span class="pricing-amount"><?=$Plans['plan_price']?></span>
											<span class="pricing-period">/ mo</span>
										</div>
									</div>
									<?php if ($Plans['stripe_plan_id']==$user_data['stripe_plan_id']) { ?>
									<ul class="pricing-features">
										<li>You have <strong><?=$Plans['staff_allowed']?> Bookable Staff</strong></li>
										<li>Last Payment made on <b><?=date("d F Y",$user_data['stripe_start_date'])?></b></li>
										<?php if ($user_data['stripe_end_date'] !="" and $user_data['is_subscription_canceled'] !=1): ?>
										<li>Next invoice will be billed on <b><?=date("d F Y",$user_data['stripe_end_date'])?></b></li>
										<?php endif ?>
									</ul>
									<?php }
									else{ ?>
									<ul class="pricing-features">
										<li>You have <strong><?=$Plans['staff_allowed']?> Bookable Staff</strong></li>
										<li>You have never upgraded to this plan.</li>

										<li>Pay through below button to activate subscription.</li>
										
									</ul>


									<?php }?>
									<?php if ($Plans['stripe_plan_id']!=$user_data['stripe_plan_id'] ) { ?>

									<ul class="pricing-features">
										<li style="color: red;">
											<strong>Note:-</strong> Plan upgrade will cancel your current subscriptions..
										</li>
										
									</ul>
						
					
									<div class="pricing-footer">
									<script
									src="https://checkout.stripe.com/checkout.js" class="stripe-button"
									data-key="<?=$stripe_keys['publishable_key']?>"
									data-image=""
									data-email="<?=$admin_session['admin_email']?>"
									data-name="<?=$Plans['name']?>"
									data-description="You have <?=$Plans['staff_allowed']?> Bookable Staff"
									data-panel-label="Pay $<?=$Plans['plan_price']?>"
									data-label="Pay $<?=$Plans['plan_price']?>"
									data-locale="auto">
									</script>
									</div>

									<?php } 
									else{ ?>
									<div class="pricing-footer">
										<?php if ($user_data['is_subscription_canceled'] !="" and $user_data['is_subscription_canceled'] !=1): ?>
										<a data-target="#cancelSubscription_<?=$Plans['id']?>" data-toggle="modal" class="btn btn-primary waves-effect waves-classic" role="button" href="javascript:void(0) " style="background-color: green  !important;">Cancel Subscription</a>
										<?php else: ?>


										<div class="alert dark alert-warning" role="alert" style="background-color: white;border-color: white;color: red;">Your Monthly subscription has been cancelled.
										</div>

										<div class="pricing-footer">
									<script
									src="https://checkout.stripe.com/checkout.js" class="stripe-button"
									data-key="<?=$stripe_keys['publishable_key']?>"
									data-image=""
									data-email="<?=$admin_session['admin_email']?>"
									data-name="<?=$Plans['name']?>"
									data-description="You have <?=$Plans['staff_allowed']?> Bookable Staff"
									data-panel-label="Pay $<?=$Plans['plan_price']?>"
									data-label="pay&nbsp;$<?=$Plans['plan_price']?>"
									data-locale="auto">
									</script>
									</div>

										<?php endif ?>
									</div>

									<?php }	?>

									

									<!-- <?php if ( $Plans['stripe_plan_id']==$user_data['stripe_plan_id']  ) { ?>
										<div class="pricing-footer">
										<?php if ($user_data['is_subscription_canceled'] !="" and $user_data['is_subscription_canceled'] !=1): ?>
										<a data-target="#cancelSubscription_<?=$Plans['id']?>" data-toggle="modal" class="btn btn-primary waves-effect waves-classic" role="button" href="javascript:void(0) " style="background-color: red !important;">Cancel Subscription</a>
										<?php else: ?>
										<div class="alert dark alert-warning" role="alert">Your Monthly subscription has been cancelled.
										</div>
										<?php endif ?>
									</div>
									<?php }
									else{ ?>
									<div class="pricing-footer">
										<a data-target="#cancelSubscription_<?=$Plans['id']?>" data-toggle="modal" class="btn btn-primary waves-effect waves-classic" role="button" href="javascript:void(0)">Upgrade Subscription</a>
									</div>

								<?php } ?> -->
								</div>
								 </form>
							</div>
							
						<?php } ?>

							





						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<?php foreach ($allPlans as $key => $Plans) { ?>

	<div class="modal fade modal-slide-in-right" id="cancelSubscription_<?=$Plans['id']?>" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
				
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
						<form action="<?= base_url('admin/service/cancelSubscription') ?>" method="POST">
					<?php if ( $Plans['stripe_plan_id']==$user_data['stripe_plan_id']  ) { ?>
					<h4 class="modal-title">Cancel Subscription</h4>
					<?php }
					else{ ?>
						<h4 class="modal-title">Upgrade Subscription</h4>
						<?php } ?>
				</div>
				<div class="modal-body">
					 <input name="plan" type="hidden" value="<?=$Plans['stripe_plan_id']?>" />
						<input name="plan_name" type="hidden" value="<?=$Plans['name']?>" />
						<input name="plan_price" type="hidden" value="<?=$Plans['plan_price']?>" />
						<input name="plan_staff_limit" type="hidden" value="<?=$Plans['staff_allowed']?>" />

					<div class="alert dark alert-icon alert-info" role="alert">
						<i class="icon md-notifications" aria-hidden="true"></i>
						<?php if ( $Plans['stripe_plan_id']==$user_data['stripe_plan_id']  ) { ?>
						<big>Your account will automatically switch to Hold when your current plan is completed.</big>
						<?php }
					else{ ?>
					<big>Your account will automatically Upgrade and  your current plan is completed.</big>

					<?php } ?>

					</div>
				</div>
				<div class="modal-footer pricing-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Cancel Now</button>					
					<!-- <div class="pricing-footer">
									<script
									src="https://checkout.stripe.com/checkout.js" class="stripe-button"
									data-key="<?=$stripe_keys['publishable_key']?>"
									data-image=""
									data-email="<?=$admin_session['admin_email']?>"
									data-name="<?=$Plans['name']?>"
									data-description="You have <?=$Plans['staff_allowed']?> Bookable Staff"
									data-panel-label="Pay $<?=$Plans['plan_price']?>"
									data-label="Pay $<?=$Plans['plan_price']?>"
									data-locale="auto">
									</script>
									</div> -->

				
					<!-- <a href="<?= base_url('admin/service/cancelSubscription') ?>" class="btn btn-primary">Cancel Now</a> -->
				</div>
			</div>
		</div>
	</div>
	</form>
	<?php } ?> 

	<!-- End Modal -->
	<!-- End page -->
	<?php $this->load->view('admin/common/footer'); ?>
	<script type="text/javascript">
	$(document).ready( function() {
	$('#example').dataTable( {
	order: [[ 2, "asc" ]],
	columnDefs: [ { orderable: false, targets: [0,-1] } ]
	});
	});
	</script>