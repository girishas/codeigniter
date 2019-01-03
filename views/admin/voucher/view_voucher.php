<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>  
  
  
  
 
  <!-- Page -->
  <div class="page">
  
  <!-- Alert message part -->
   <?php $this->load->view('admin/common/header_messages'); ?>
  <!-- End alert message part -->
  
    <div class="page-header">
      <div class="page-header-actions">
        <a class="btn btn-info" href="<?php echo base_url('admin/voucher');?>"> All Vouchers </a>
        <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
      </div>
    </div>

    <div class="page-content container-fluid">

      <div class="row">
        <div class="col-md-12">
          <!-- Panel Static Labels -->
          

          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">View Vouchers</h3>
            </div>

              

            <div class="panel-body container-fluid">
              
              <form autocomplete="off" method="post" action="?php echo  base_url('admin/voucher/edit_voucher'); ?>" enctype="multipart/form-data">
                 
                <input type="hidden" name="action" value="save"> 

                <?php 
                $admin_session = $this->session->userdata('admin_logged_in');
                if($admin_session['role'] == 'owner') { ?>

                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid1">Business*</label>
                    <?php $business_id = (isset($business_id) && $business_id!='')?$business_id:$template_details[0]['business_id'];?>
                    <select class="form-control" name="business_id">
                      <option value="">Select Business</option>
                      <?php if($all_business){?>
                       <?php foreach($all_business as $business){?>
                       <option value="<?php echo $business['id'];?>" <?php if(isset($business_id)){ if($business_id==$business['id']) { echo "selected"; }  }?>><?php echo $business['name'];?></option>
                       <?php } } ?>
                    </select>
                    <div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Vouchar Name*</label>
                    <?php $vouchar_name = (isset($vouchar_name) && $vouchar_name!='')?$vouchar_name:$template_details[0]['vouchar_name'];?>
                    <input type="text" class="form-control" id="vouchar_name" name="vouchar_name" value="<?php if(isset($vouchar_name)) { echo $vouchar_name; }?>" readonly />
                    <div class="admin_content_error"><?php echo form_error('vouchar_name'); ?></div>
                  </div>

                <?php } else { ?>

                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Vouchar Name*</label>
                    <?php $vouchar_name = (isset($vouchar_name) && $vouchar_name!='')?$vouchar_name:$template_details[0]['vouchar_name'];?>
                    <input type="text" class="form-control" id="vouchar_name" name="vouchar_name" value="<?php if(isset($vouchar_name)) { echo $vouchar_name; }?>" readonly />
                    <div class="admin_content_error"><?php echo form_error('vouchar_name'); ?></div>
                  </div>
                 
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Voucher Amount*</label>
                    <?php $voucher_amount = (isset($voucher_amount) && $voucher_amount!='')?$voucher_amount:$template_details[0]['voucher_amount'];?>
					<input type="text" class="form-control" id="voucher_amount" name="voucher_amount" value="<?php if(isset($voucher_amount)) { echo $voucher_amount; }?>" readonly />
                    <div class="admin_content_error"><?php echo form_error('voucher_amount'); ?></div> 
                  </div>
                </div>

                <?php } ?>
				
				<?php
                $admin_session = $this->session->userdata('admin_logged_in');
                if($admin_session['role'] == 'owner') { ?>
				<div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Voucher Amount*</label>
                    <?php $voucher_amount = (isset($voucher_amount) && $voucher_amount!='')?$voucher_amount:$template_details[0]['voucher_amount'];?>
					<input type="text" class="form-control" id="voucher_amount" name="voucher_amount" value="<?php if(isset($voucher_amount)) { echo $voucher_amount; }?>" readonly />
                    <div class="admin_content_error"><?php echo form_error('voucher_amount'); ?></div> 
                  </div>
                  <div class="col-md-6">
                    
                  </div>
                </div>
				<?php } ?>

                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-12">
                    <label class="form-control-label" for="inputGrid2">description*</label>
                    <?php $description = (isset($description) && $description!='')?$description:$template_details[0]['description'];?>
                    <textarea class="form-control" id="description" name="description" rows="3" readonly ><?php if(isset($description)) { echo $description; }?></textarea>
                    <div class="admin_content_error"><?php echo form_error('description'); ?></div>
                  </div>
                </div>

                <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-12">
                    <label class="form-control-label" for="inputGrid2">Vourchar Terms</label>
                    <?php $vourchar_terms = (isset($vourchar_terms) && $vourchar_terms!='')?$vourchar_terms:$template_details[0]['vourchar_terms'];?>
                    <textarea class="form-control" id="vourchar_terms" name="vourchar_terms" readonly rows="3"><?php if(isset($vourchar_terms)) { echo $vourchar_terms; }?></textarea>
                    <!-- <div class="admin_content_error"><?php echo form_error('vourchar_terms'); ?> -->   
                    </div>
                  </div>
                

                <div class="form-group  row" data-plugin="formMaterial">
                 
                  <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Status</label>
                    <?php $status = (isset($status) && $status!='')?$status:$template_details[0]['status'];?>
                    <select class="form-control" name="status" disabled>
                      <option value="">Select Status</option>
                      <option value="1" <?php if(isset($status)) { if($status == '1') { echo "selected"; } } ?> >Active</option>
                      <option value="2" <?php if(isset($status)) { if($status == '2') { echo "selected"; } } ?> >Deactive</option>
                      <!-- <option value="3" <?php if(isset($status)) { if($status == '3') { echo "selected"; } } ?> >Used</option> -->
                    </select>
                  </div>
                </div>

                

               <!--  <div class="form-group  row" data-plugin="formMaterial">
                  <div class="col-md-6">
                    <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
                  </div>
                  <div class="col-md-6">
                    
                  </div>
                </div> -->
                
              </form>
            </div>
          </div>
          <!-- End Panel Static Labels -->
        </div>

         
      </div>
    </div>
  </div>

    <!-- End Page -->
  <!-- End page -->
  

<?php $this->load->view('admin/common/footer'); ?>
<script type="text/javascript">
  
</script>
