<?php

$this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<div class="page">
		<?php $this->load->view('admin/common/header_messages'); ?>
		<!-- Contacts Content -->
		<div class="page-main">
			<!-- Contacts Content Header -->
			<div class="page-content">
				<!-- Panel Static Labels -->
				<div class="panel panel-bordered">
					<div class="page-header">
						<?php $this->load->view('admin/product/inventry_top'); ?>
						<div class="page-header-actions"><h3 class="panel-title">Order Attachment detail #<?php echo isset($data[0]['order_id'])?$data[0]['order_id']:"";?></h3></div>
					</div>
					<div class="panel-body">
						<div class="row">	
						<?php 
						if($data){
						foreach ($data as $key => $value) { ?>
						<div class="col-md-3">
							<div class="example" style="height: 150px;text-align: center;background-color: #ddd;">
								<figure class="overlay overlay-hover animation-hover">
									<i class="icon md-file" aria-hidden="true" style="font-size: 150px;line-height: 150px;"></i>
									<figcaption class="overlay-panel overlay-background overlay-fade text-center vertical-align">
									<a target="_BLANK" href="<?php echo base_url('images/order-document/'.$value['file_name']) ?>" class="btn btn-outline btn-inverse vertical-align-middle waves-effect waves-classic" style="color: #000;">View</a>
									</figcaption>
								</figure>
								<p>Uploaded On : <?php echo date('d-m-Y',strtotime($value['created_at'])) ?></p>
							</div>
						</div>
					<?php } }else{
						echo "No Record Found...";
					} ?>
				</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade modal-fade-in-scale-up" id="exampleFillIn" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">Add Stock</h4>
				</div>
				<form method="post" action="<?= base_url()?>admin/product/stockin">
					<div class="modal-body">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script language="javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.js');?>"></script>
<?php $this->load->view('admin/common/footer'); ?>