<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
<?php $this->load->view('admin/common/left_menubar'); ?>  
  <!-- Page -->
 <!-- Page -->
    <div class="page">
   <?php $this->load->view('admin/common/header_messages');
  ?>

  <div class="page-main">
      <div class="page-content">
        <div class="panel">
   
   
    <div class="page-header">
           <!--  <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'expense'){echo 'active';}?>" href="<?php echo base_url('admin/expense');?>">Open Register</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/today_sale');?>">Today Position</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/expense/close_register');?>">Close Register</a></li> 
             
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_expenses');?>">Expense</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_pos_category');?>">Pos Category</a></li>
             <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_vendors');?>">Vendor</a></li>
              
            </ul> -->
            <?php $this->load->view('admin/common/expense_menu'); ?>  
      </div>
   
   
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Open Register</h3> 
              </div>
              
              <div class="panel-body container-fluid">
                <form autocomplete="off" action="" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="action" value="save"> 
                   <div class="row">

                    <?php if(isset($open_date)){
                   
                        $readonly = 'readonly';
                        $disabled = 'disabled';
                    }else{
                        $readonly = '';
                        $disabled = '';
                    }?>

           <!-- <?php if($admin_session['role']=="owner"){ ?>


          <div class="col-md-6">
            <div class="form-group" data-plugin="formMaterial">
                      <label class="form-control-label" for="inputGrid1">Business*</label>
            <?php if(isset($pos_expense_details)) { $business_id = (isset($business_id) && $business_id!='')?$business_id:$pos_expense_details[0]['business_id']; } else { $business_id = (isset($business_id) && $business_id!='')?$business_id:''; }?>

            <select class="form-control" name="business_id" id="business_id" onChange="return get_business_locationss(this.value)">
            <option value="">Select Business</option>
               <?php if($all_business){?>
               <?php foreach($all_business as $business){?>
               <option value="<?php echo $business['id'];?>" <?php if(isset($business_id) && $business_id==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
               <?php } } ?>
          </select>
          <div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                    </div>
                </div>
          <?php } ?> -->
          <?php if($admin_session['role']=="business_owner" or $admin_session['role']=="owner"){?>
                    <div class="col-md-6" id="location_section">
                      <div class="form-group" data-plugin="formMaterial">
                      <label class="form-control-label" for="inputGrid2">Location*</label>
                       <?php if(isset($open_date)) {
                         foreach ($open_date as $open_date_id) {
                             $location_id = (isset($location_id) && $location_id!='')?$location_id:$open_date_id['location_id']; 
                          } 
                       } 
                        else { $location_id = (isset($location_id) && $location_id!='')?$location_id:''; }?>
                       <span id="content_location_id">
                         <select class="form-control" name="location_id" id="location_id" onChange="check_pos_daily(this.value)">
                          <option value="">Select Location</option>
                        <?php if(isset($locations)){?>
                        <?php foreach($locations as $loc){?>
                          <option value="<?php echo $loc['id'];?>" <?php if(isset($location_id)){ if($location_id==$loc['id']) { echo "selected"; }  }?>><?php echo $loc['location_name'];?></option>
                        <?php } } ?>
                         </select>
                        </span>
                      <div class="admin_content_error"><?php echo form_error('location_id'); ?></div>
                    </div>
                </div>
          <?php } ?>
        </div>
                  <div class="form-group row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Cash In Hand*</label> 
                      <?php 
                      if(isset($open_date)){

                          if($admin_session['role']=="business_owner" or $admin_session['role']=="owner"){
                             foreach ($open_date as $open_date_id1) {
                               if(isset($location_id) && $location_id==$open_date_id1['location_id']){
                                 $open_cash = $open_date_id1['open_cash']; 
                               }
                              } 
                          } else if($admin_session['role']=="location_owner" || $admin_session['role']=='staff' ){
                              $open_cash = $open_date['open_cash'];
                          } 
                      }else if(isset($open_cash)){
                        $open_cash = $open_cash; 

                      }else{
                         $open_cash = '';
                      }

                     ?>
                    <?php //gs($open_cash); ?>
                      
                      <input type="text" class="form-control" name="open_cash" id="open_cash" value="<?php if(isset($open_cash)){ echo $open_cash; }?>">
                      <div class="admin_content_error"><?php echo form_error('open_cash'); ?></div>
                    </div>
                    
                  </div>
       <?php //gs($open_cash); ?>
         
          <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <button id="btn_disable" style="width:200px" class="btn btn-primary <?php if(isset($open_cash) && $open_cash != null){ echo "disabled"; }?>" data-dismiss="modal" type="submit" >Open Register</button>
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
      </div>
    </div>
  </div>
    <!-- End Page -->
  <!-- End page -->
<style type="text/css">
  .admin_content_error{padding: 0px;}
  
</style>
<script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
  <script type="text/javascript">

    function check_pos_daily(loc_id){
       $.ajax({
        type: 'POST',
        url: site_url + 'admin/Operations/checkLocIdExistInPOS/' + encodeURIComponent(loc_id),
        datatype: 'json',
        beforeSend: function() {
        },
        success: function(data)
        {
          data = JSON.parse(data);
         // alert(data.status.open_cash);
          if(data.status == 'failed'){
             $("#btn_disable").removeClass('disabled');
              $("#open_cash").val(' ');
              
          }else{
            $("#btn_disable").addClass('disabled');
            $("#open_cash").val(data.status.open_cash);
          }
        }
      });
    }
    
</script>
<?php $this->load->view('admin/common/footer'); ?>