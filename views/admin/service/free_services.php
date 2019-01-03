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
					<h1 class="page-title">Customer Loyality Program</h1>
					<div class="page-header-actions"><a href="<?php echo base_url('admin/setup');?>"><button type="button" class="btn btn-block btn-primary">Setup</button></a></div>
				</div>
				<div class="page-content container-fluid">
					<div class="row">
						<div class="col-md-12">
							<!-- Panel Static Labels --> 
							<form autocomplete="off" method="post" action="">
								<input type="hidden" name="action" value="save">
								<?php if(count((array)$free_services)==0): ?>
								<div class="form-group row append_0" data-plugin="formMaterial">
									<div class="col-md-2">
										<input placeholder="Number" type="number" required="required" class="form-control" min="1" name="number[]" value="">
									</div>
									<div class="col-md-2">
										<input placeholder="%" type="text" required="required" class="form-control" name="percent[]" value="">
									</div>
									<div class="col-md-5">
										<select name="service[]" required="required" class="form-control selectpicker" data-live-search="true">
											<option value="">Choose Service</option>
											<?php foreach ($options as $key => $value): ?>>
													<option value="<?=$value['id']?>">
														<?=$value['sku']?> - <?=$value['service_name']?>&nbsp;»»&nbsp;<?=$value['caption']?> - $<?=$value['special_price']?>
													</option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="col-md-3">
										<div class="btn-group">
											<button type="button" onclick="addMore()" class="btn btn-primary"><i class="fa fa-plus"></i></button>
										</div>
									</div>
								</div>
								<?php else: ?>
									<?php foreach ($free_services as $key => $value) { ?>
										<div class="form-group row append_<?=$key?>" data-plugin="formMaterial">
										<div class="col-md-2">
											<input placeholder="Number" type="number" required="required" class="form-control" min="1" name="number[]" value="<?=$value['number']?>">
										</div>
										<div class="col-md-2">
											<input placeholder="%" type="text" required="required" class="form-control" name="percent[]" value="<?=$value['percent']?>">
										</div>
										<div class="col-md-5">
											<select name="service[]" required="required" class="form-control selectpicker" data-live-search="true">
												<option value="">Choose Service</option>
												<?php foreach ($options as $kkey => $vvalue): 
													$selected = ($vvalue['id']==$value['services'])?"selected":"";
													?>
														<option <?=$selected;?> value="<?=$vvalue['id']?>">
															<?=$vvalue['sku']?> - <?=$vvalue['service_name']?>&nbsp;»»&nbsp;<?=$vvalue['caption']?> - $<?=$vvalue['special_price']?>
														</option>
												<?php endforeach ?>
											</select>
										</div>
										<div class="col-md-3">
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
										<a class="btn btn-info" href="<?=base_url('/admin/service/remove_loyality_programs')?>">Remove All</a>
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
	<?php
	$dropdown = "";
	foreach ($options as $key => $value): 
		$dropdown .= "<option value='".$value['id']."'>";
			$dropdown .= $value['sku'] ."-". $value['service_name']."&nbsp;»»&nbsp;".$value['caption'] ."-".$value['special_price'];
		$dropdown .= "</option>";
	 endforeach ?>
	?>
	<!-- End Page -->
	<?php $this->load->view('admin/common/footer'); ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
 	<script type="text/javascript">

 		$(document).ready(function(){
 			$('.selectpicker').selectpicker();
 		})
 		x="<?=count((array)$free_services)+1?>";
 		var dropdown = "<?=$dropdown?>";
 		function addMore(){
 			var append = '<div class="form-group row append_'+x+'" data-plugin="formMaterial"><div class="col-md-2"><input placeholder="Number" type="number" required="required" class="form-control" min="1" name="number[]" value=""></div><div class="col-md-2"><input placeholder="%" type="text" required="required" class="form-control" name="percent[]" value=""></div><div class="col-md-5"><select name="service[]" required="required" class="form-control selectpicker" data-live-search="true"><option value="">Choose Service</option>'+dropdown+'</select></div><div class="col-md-3"><div class="btn-group"><button type="button" onclick="removeThis('+x+')" class="btn btn-danger"><i class="fa fa-minus"></i></button></div></div></div>';
 			$(".new_content").append(append);
 			x++;
 			$('.selectpicker').selectpicker();
 		}

 		function removeThis(x){
 			$(".append_"+x).remove();
 		}
 	</script>