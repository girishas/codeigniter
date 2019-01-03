<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <?php $this->load->view('admin/common/left_menubar'); ?>
  <!-- Page -->
  <!-- Page -->
  <div class="page">
    
    
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="panel">
          <!-- Panel Static Labels -->
          <div class="panel-heading">
            <h3 class="panel-title">Warehouse</h3>
            <div class="page-header-actions"> <a class="btn btn-info" href="<?php echo base_url('admin/business/all_warehouse');?>"> All Warehouse </a>  <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
          </div>
        </div>
        <div class="panel-body container-fluid">
          <form autocomplete="off" method="post" action="">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?=$warehouse['id']?>">
            
            <div class="form-group  row" data-plugin="formMaterial">
              <div class="col-md-6">
                <?php $warehouse_name=isset($warehouse_name)?$warehouse_name:$warehouse['warehouse_name']; ?>
                <label class="form-control-label" for="inputGrid1">Warehouse Name*</label>
                <input type="text" class="form-control" id="warehouse_name" name="warehouse_name" value="<?=$warehouse_name?>">
                <div class="admin_content_error"><?php echo form_error('warehouse_name'); ?></div>
              </div>
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid2">Phone Number*</label>
                  <?php $phone_number=isset($phone_number)?$phone_number:$warehouse['phone_number']; ?>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?=$phone_number?>"/>
                <div class="admin_content_error"><?php echo form_error('phone_number'); ?></div>
              </div>
            </div>
            
            <div class="form-group  row" data-plugin="formMaterial">
               <div class="col-md-6">
                <label class="form-control-label" for="inputGrid2">Email*</label>
                 <?php $email=isset($email)?$email:$warehouse['email']; ?>
                <input type="email" class="form-control" id="email" name="email" value="<?=$email?>" />
                <div class="admin_content_error"><?php echo form_error('email'); ?></div>
              </div>
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">Address1</label>
                 <?php $address1=isset($address1)?$address1:$warehouse['address1']; ?>
                <input type="text" class="form-control" id="address1" name="address1" value="<?=$address1?>">
              </div>
              
            </div>
            
            <div class="form-group  row" data-plugin="formMaterial">            
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid2">Address2</label>
                <?php $address2=isset($address2)?$address2:$warehouse['address2']; ?>
                <input type="text" class="form-control" id="address2" name="address2" value="<?=$address2?>" />
              </div>
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid2">City*</label>
                 <?php $city=isset($city)?$city:$warehouse['city']; ?>
                <input type="text" class="form-control" id="city" name="city" value="<?=$city?>" />
                <div class="admin_content_error"><?php echo form_error('city'); ?></div>
              </div>
              
            </div>
            
            <div class="form-group  row" data-plugin="formMaterial">
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">State</label>
                 <?php $state=isset($state)?$state:$warehouse['state']; ?>
                <input type="text" class="form-control" id="state" name="state" value="<?=$state?>">
              </div>
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">Post Code</label>
                 <?php $postcode=isset($postcode)?$postcode:$warehouse['postcode']; ?>
                <input type="text" class="form-control" id="postcode" name="postcode" value="<?=$postcode?>">
              </div>
            </div>
            <div class="form-group  row" data-plugin="formMaterial">
              <div class="col-md-6">
                <label class="form-control-label" for="inputGrid1">Timezone</label>
                <select class="form-control select2" data-plugin="select2"   name="timezone_id">
                  <?php foreach ($timezones as $key => $value): ?>
                     <?php $timezone_id=isset($timezone_id)?$timezone_id:$warehouse['timezone_id']; 
                     $select=$timezone_id==$value['id']?'selected':''
                     ?>
                    <option <?=$select?> value="<?=$value['id']?>"><?=$value['name']?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>             
             <div class="form-group row" data-plugin="formMaterial">
              <div class="col-md-6">
                <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
              </div>
            </div>
            </div>
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