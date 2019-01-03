<!-- Alert message part -->
	 <?php if($this->session->flashdata('success_msg')) {?>
	   <div class="alert dark alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
		<?php echo $this->session->flashdata('success_msg');?>
	  </div>
	  <?php }else if($this->session->flashdata('error_msg')) { ?>
	  <div class="alert alert-danger alert-dismissible" role="alert">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
	   <?php echo $this->session->flashdata('error_msg');?>
       </div>
	<?php  }?>
	<!-- End alert message part -->