<?php $this->load->view('admin/common/header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('global/vendor/summernote/summernote.css') ?>">
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
					<h1 class="page-title">Client Notifications</h1>
					<div class="page-header-actions"> <a href="<?php echo base_url('admin/setup');?>"><button type="button" class="btn btn-block btn-primary">Setup</button></a></div>
				</div>
				<div class="page-content container-fluid">
					<div class="row row-lg">
						<div class="col-xl-12">
							<!-- Example Tabs Line -->
							<div class="example-wrap m-xl-0">
								<div class="nav-tabs-horizontal" data-plugin="tabs">
									<ul class="nav nav-tabs nav-tabs-line" role="tablist">
										<li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#reminder_email" aria-controls="reminder_email" role="tab">Appointment Reminders</a></li>
										<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#widget_booking_email" aria-controls="widget_booking_email" role="tab">Confirmed Widget Booking </a></li>

										<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#pencilled_in_widget_booking_email" aria-controls="pencilled_in_widget_booking_email" role="tab">Pencilled-In Widget Booking </a></li>
										<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#calendar_booking_email" aria-controls="calendar_booking_email" role="tab">Calendar Booking Email</a></li>
										<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#invoice_email" aria-controls="invoice_email" role="tab">Invoice Receipt Email</a></li>
										<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#voucher_email" aria-controls="voucher_email" role="tab">Voucher Email</a></li>
										<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#confirm_email" aria-controls="confirm_email" role="tab">Appointment Confirmation</a></li>
										<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#cancel_email" aria-controls="cancel_email" role="tab">Appointment Cancellations</a></li>
										<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#thankyou" aria-controls="thankyou" role="tab">Thank Yous</a></li>
										<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#email_for_location" aria-controls="email_for_location" role="tab">Email for Location</a></li>

										<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#pre_gst" aria-controls="email_for_location" role="tab">Pre GST</a></li>

										<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#gst_ato" aria-controls="email_for_location" role="tab">GST ATO</a></li>

									</ul>
									<div class="tab-content pt-20">
										<!-- Reminder Email -->
										<div class="tab-pane active" id="reminder_email" role="tabpanel">
											<form method="post">
												<input type="hidden" value="<?=$reminder_email['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$reminder_email['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$reminder_email['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$reminder_email['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>
										<!-- Widget Booking Email -->
										<div class="tab-pane" id="widget_booking_email" role="tabpanel">
											<form method="post">
												<input type="hidden" value="<?=$widget_booking_email['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$widget_booking_email['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$widget_booking_email['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$widget_booking_email['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>

										<!-- Pencilled -In  Widget Booking Email -->
										<div class="tab-pane" id="pencilled_in_widget_booking_email" role="tabpanel">
											<form method="post">
												<input type="text" value="<?=$pencilled_in_widget_booking_email['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$pencilled_in_widget_booking_email['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$pencilled_in_widget_booking_email['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$pencilled_in_widget_booking_email['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>


										<!-- Calendar Booking Email -->
										<div class="tab-pane" id="calendar_booking_email" role="tabpanel">
											<form method="post">
												<input type="hidden" value="<?=$calendar_booking_email['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$calendar_booking_email['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$calendar_booking_email['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$calendar_booking_email['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>

										<!-- Invoice Receipt Email -->
										<div class="tab-pane" id="invoice_email" role="tabpanel">
											<form method="post">
												<input type="hidden" value="<?=$invoice_email['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$invoice_email['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$invoice_email['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$invoice_email['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>

										<!-- Gift Voucher Email -->
										<div class="tab-pane" id="voucher_email" role="tabpanel">
											<form method="post">
												<input type="hidden" value="<?=$voucher_email['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$voucher_email['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$voucher_email['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$voucher_email['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>

										<!-- Appointment confirm Email -->
										<div class="tab-pane" id="confirm_email" role="tabpanel">
											<form method="post">
												<input type="hidden" value="<?=$confirm_email['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$confirm_email['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$confirm_email['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$confirm_email['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>

										<!-- Appointment Cancell Email -->
										<div class="tab-pane" id="cancel_email" role="tabpanel">
											<form method="post">
												<input type="hidden" value="<?=$cancel_email['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$cancel_email['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$cancel_email['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$cancel_email['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>

										<!-- thankyou Email -->
										<div class="tab-pane" id="thankyou" role="tabpanel">
											<form method="post">
												<input type="hidden" value="<?=$thankyou['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$thankyou['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$thankyou['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$thankyou['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>

										<!-- email_for_location Email -->
										<div class="tab-pane" id="email_for_location" role="tabpanel">
											<form method="post">
												<input type="hidden" value="<?=$email_for_location['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$email_for_location['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$email_for_location['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$email_for_location['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>



										<!-- email_for_Pre Gst Email -->
										<div class="tab-pane" id="pre_gst" role="tabpanel">
											<form method="post">
												<input type="hidden" value="<?=$email_pre_gst['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$email_pre_gst['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$email_pre_gst['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$email_pre_gst['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>

										<!-- email_for_Pre Gst Email -->
										<div class="tab-pane" id="gst_ato" role="tabpanel">
											<form method="post">
												<input type="hidden" value="<?=$email_gst_ato['slug']?>" name="slug">
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL SUBJECT*</label>
													<input type="text"  value="<?=$email_gst_ato['subject']?>" class="form-control" required="required" name="subject" id="subject">
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<label class="form-control-label" for="inputGrid1">EMAIL TEMPLATE*</label>
													<textarea class="form-control myEditor" required="required" name="email_html"><?=$email_gst_ato['email_html']?></textarea>
													<span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
												</div>
												<div class="form-group" data-plugin="formMaterial">
													<button type="submit" class="btn btn-primary">Save Changes</button>
													<a href="<?= base_url("/admin/service/reset/".$email_gst_ato['slug']) ?>" class="btn btn-secondary">Reset to Default</a>
												</div>
											</form>
										</div>




									</div>
								</div>
							</div>
							<!-- End Example Tabs Line -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page -->
	<script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
	<script type="text/javascript">
	$(document).ready(function(){
	$('.myEditor').summernote({
	height:200
	});
	});
	</script>
	<?php $this->load->view('admin/common/footer'); ?>