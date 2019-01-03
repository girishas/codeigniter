<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
	<div class="page">
		<div class="page-content">
			<div class="panel">
				<?php $this->load->view('admin/common/header_messages'); ?>
				<div class="page-header">
					<h1 class="page-title">Product Unit Setting</h1>
					<div class="page-header-actions"><a href="<?php echo base_url('admin/setup');?>"><button type="button" class="btn btn-block btn-primary">Setup</button></a></div>
				</div>
				<div class="page-content container-fluid">
					<div class="row">
						<div class="col-md-12">
							<!-- Panel Static Labels --> 
							<form autocomplete="off" method="post" action="">
								<input type="hidden" name="action" value="save">
								<?php if(count((array)$product_unit)==0): ?>
								<div class="form-group row append_0" data-plugin="formMaterial">
									<div class="col-md-2">
										<label class="form-control-label">Product Scale</label>
										<input placeholder="KG" type="text" required="required" class="form-control" min="1" name="product_scale[]" value="">
									</div>

									<div class="col-md-2">
										<label class="form-control-label">Description</label>
										<input placeholder="kilogram" type="text"  class="form-control"  name="product_scale_description[]" value="">
									</div>								
									
									<div class="col-md-3">
										<br/>
										<div class="btn-group">
											<button type="button" onclick="addMore()" class="btn btn-primary"><i class="fa fa-plus"></i></button>
										</div>
									</div>
								</div>
								<?php else: ?>
									<?php foreach ($product_unit as $key => $value) { ?>
										<div class="form-group row append_<?=$key?>" data-plugin="formMaterial">
											<input  type="hidden"  class="form-control" min="1" name="product_scale_id[]" value="<?=$value['id']?>">

											<div class="col-md-2">
												<?php if ($key==0) { ?>
													<label class="form-control-label">Product Scale</label>
												<?php } ?>
												
										<input placeholder="KG" type="text" required="required" class="form-control" min="1" name="product_scale[]" value="<?=$value['product_scale']?>">
									</div>
									<div class="col-md-2">
										<?php if ($key==0) { ?>
													<label class="form-control-label">Description</label>
												<?php } ?>
										<input placeholder="kilogram" type="text"  class="form-control"  name="product_scale_description[]" value="<?=$value['product_scale_description']?>">
									</div>
										
										<div class="col-md-3">
											<?php 
											if ($key==0) { ?>
												<br/>
											<?php }
											?>
													
										
													<div class="btn-group">
												<?php if($key==0): ?>
													
												<button type="button" onclick="addMore()" class="btn btn-primary"><i class="fa fa-plus"></i></button>
												<?php else: ?>
												<button type="button" onclick="removeThis('<?=$key?>')" class="btn btn-danger"><i class="fa fa-minus"></i></button>	 
												<?php endif; ?>
											</div>
										</div>
									</div>
									<?php  } ?>
								<?php endif; ?>
								<div class="new_content"></div>
								<div class="form-group  row" data-plugin="formMaterial">
									<div class="col-md-6">
										<button class="btn btn-primary" type="submit">Save</button>
										<a class="btn btn-secondary" href="<?=base_url('/admin/setup')?>">Cancel</a>
										<!-- <a class="btn btn-info" href="<?=base_url('/admin/service/remove_loyality_programs')?>">Remove All</a> -->
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
 	<script type="text/javascript">

 		$(document).ready(function(){
 			$('.selectpicker').selectpicker();
 		})
 		x="<?=count((array)$product_unit)+1?>";


 		function addMore(){
 			var append = '<div class="form-group row append_'+x+'" data-plugin="formMaterial"><div class="col-md-2"><input placeholder="KG" type="text" required="required" class="form-control"  name="product_scale[]" value=""></div><div class="col-md-2"><input placeholder="kilogram" type="text"  class="form-control"  name="product_scale_description[]" value=""></div><div class="col-md-3"><div class="btn-group"><button type="button" onclick="removeThis('+x+')" class="btn btn-danger"><i class="fa fa-minus"></i></button></div></div></div>';
 			$(".new_content").append(append);
 			x++;
 			$('.selectpicker').selectpicker();
 		}

 		function removeThis(x){
 			$(".append_"+x).remove();
 		}
 	</script>