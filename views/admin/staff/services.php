<?php
$this->load->view('admin/common/header'); ?>
<body class="animsition">
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<div class="page">
		<div class="page-content">
			<?php $this->load->view('admin/common/header_messages'); ?>
			<div class="panel nav-tabs-horizontal" data-plugin="tabs">
				<div class="page-header">
		          <h1 class="page-title">Staff Services</h1>
				  <div class="page-header-actions"><a href="<?= base_url('admin/staff') ?>"><button type="button" class="btn btn-block btn-primary waves-effect waves-classic">View All</button></a></div>
		        </div>
				<ul class="nav nav-tabs nav-tabs-line" role="tablist">
					<li class="nav-item" style=""><a class="nav-link" href="<?php echo base_url('admin/staff/view/'.$id); ?>"><i class="icon md-home" aria-hidden="true"></i>All Information</a></li>
					<li class="nav-item" style=""><a class="nav-link show active" href="<?php echo base_url('admin/staff/services/'.$id); ?>"><i class="icon md-account" aria-hidden="true"></i>Services</a></li>
					<!-- <li class="nav-item" style=""><a class="nav-link" href="<?php echo base_url('admin/staff/working_hours/'.$id); ?>"><i class="icon md-label" aria-hidden="true"></i>Working Hours</a></li> -->
				</ul>
				<div class="panel-body">
					<div class="tab-content">
						<h4>Assign Services : </h4>
						<hr>
					<form method="post">	
						<input type="hidden" name="action" value="action">
					<?php //echo "<pre>",print_r($services),"</pre><br>"; ?>
					<?php
					$i=0;
					if($services){

					foreach ($services as $key => $value) {
						$service_cat_name = getServiceNameById($key);
						if($service_cat_name){
						echo "<h4><b>".$service_cat_name."</b></h4>"; 
					?>
					<div class="row" style="padding-left: 20px;">
							<?php
							foreach ($value as $k1 => $val1) {
								foreach ($val1 as $k => $val) {
									//print_r($val); 
									if(in_array($k, $assigned_services))
									{
										$checked = "checked";
									}else{
										$checked = "";
									}
								 ?>
								<div class="col-md-3">
									<div class="checkbox-custom checkbox-info">
										<input type="checkbox" <?= $checked; ?> class="icheckbox-primary" id="inputUnchecked_<?=$i?>" value="<?= $k ?>" name="service_id[]" data-plugin="iCheck" data-checkbox-class="icheckbox_flat-blue"/>
										<label for="inputUnchecked_<?=$i?>"><?= $val ?></label>
									</div>
								</div>
								<?php $i++;	
								}
							
							}  ?>
					</div>
					<?php }}}else{
						echo "<center>No Services Available to assign<br><br>
								<a href='".base_url('admin/service/add_service')."' class='btn btn-info'>Add New Services</a></center>";
					} ?>
					<hr>
					<div class="form-group form-material">
                        <button type="submit" class="btn btn-primary waves-effect waves-classic">Save</button>
                      </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('admin/common/footer'); ?>