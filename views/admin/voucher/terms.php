<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<style type="text/css">
		.textbox{
		float: left;
		}
	</style>
	<div class="page">
		
		<!-- Alert message part -->
		<?php $this->load->view('admin/common/header_messages'); ?>
		<div class="page-content container-fluid">
			<div class="row">
				<div class="col-md-12">
					<!-- Panel Static Labels -->
					
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Vouchers Terms & Conditions</h3>
							<div class="page-header-actions">
								<a class="btn btn-info" href="<?php echo base_url('admin/voucher');?>"> All Vouchers </a>
								<a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
							</div>
						</div>
						<div class="panel-body container-fluid">
							<div class="form-body">
								<div class="col-md-8">
									<form method="post">
										<input type="hidden" name="action" value="save">
										<?php if(count((array)$terms)>0){
											
											foreach($terms as $key => $value){?>
											
											<div class="row append_<?=$key?>" style="margin-top:15px;">
												
												<?php if($key==0): ?>
												
												<label class="col-md-1" style="margin-top: 6px;"><?php echo $key+1 ?></label>
												
												<?php else: ?>
												
												<label class="col-md-1 sr_no" style="margin-top: 6px;"><?php echo $key+1 ?></label>
												
												<?php endif; ?>
												
												<div class="col-md-9">
													
													<input type="text" class="form-control" name="voucher_terms[]" value="<?=$value['detail'] ?>">
													
												</div>
												
												<?php if($key==0): ?>
												
												<div class="col-md-2">
													
													<a href="javascript:void(0)" onclick="addhighlight()" class="btn btn-primary"><i class="fa fa-plus"> </i></a>
													
												</div>
												
												<?php else: ?>
												
												<div class="col-md-2">
													
													<a href="javascript:void(0)" onclick="removehighlight(<?=$key?>)" class="btn btn-danger"><i class="fa fa-trash"> </i></a>
													
												</div>
												
												<?php endif; ?>
												
											</div>
											
											<?php 
											} }else{ ?>
											
											
											<div class="row">
												
												<label class="col-md-1" style="margin-top: 6px;">1.</label>
												
												<div class="col-md-9">
													
													<input type="text" class="form-control" name="voucher_terms[]">
													
												</div>
												
												<div class="col-md-2">
													
													<a href="javascript:;" onclick="addhighlight()" class="btn btn-primary"><i class="fa fa-plus"> </i></a>
													
												</div>
												
											</div>
											
										<?php } ?>
										
										<div class="more-heighlight"></div>
										
										<input type="hidden" name="action" value="save"> 
										<input type="hidden" name="id" value="<?php echo $setting['id'] ?>">
										
										<div class="form-group  row mt-10" data-plugin="formMaterial">
											<div class="col-md-6">
												<label class="form-control-label" for="inputGrid2">Code Settings</label>                
												<select class="form-control" name="status">                   
													<option value="1" <?php if ($setting['status']==1) {echo "selected";} ?> >Auto</option>
													<option value="2" <?php if ($setting['status']==2) {echo "selected";} ?> >Custom</option>                
												</select>
												<!-- <option value="1" <?php if(isset($setting['status'])) { if($setting->$setting['status'] == '1') { echo "selected"; } } ?> >Auto</option>
												<option value="2" <?php if(isset($setting->$setting['status'])) { if($setting->$setting['status'] == '2') { echo "selected"; } } ?> >Custom</option> -->
											</div>
										</div>
										<div>
											<button type="submit" class="btn btn-primary" style="margin-top: 30px;">Save</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<!-- End Page -->
	<!-- End page -->
	
	<?php $this->load->view('admin/common/footer'); ?>
	<script type="text/javascript">
		var x="<?= count((array)$terms)+1 ?>";
		function addhighlight(){
			
			var content = '<div style="margin-top:15px;" class="row append_'+x+'"><label class="col-md-1 sr_no" style="margin-top: 6px;"></label><div class="col-md-9"><input type="text" required="required" class="form-control" name="voucher_terms[]"></div><div class="col-md-2"><a href="javascript:;" onclick="removehighlight('+x+')" class="btn btn-danger"><i class="fa fa-trash"> </i></a></div></div>';
			
			$(".more-heighlight").append(content);
			
			x++;
			
			srNo();
			
		}
		
		function removehighlight(x){
			
			$(".append_"+x).remove();
			
			x--;
			
			srNo();
			
		}
		
		function srNo(){
			
			var srs = document.getElementsByClassName("sr_no");
			
			for (var i = 0; i < srs.length; i++){
				
				$(srs[i]).html(i+2+'.');
				
			}
			
		}
	</script>	