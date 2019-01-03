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
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Add Resource</h3>
                <div class="page-header-actions">
                  <!-- <a href="<?php echo base_url('admin/resource');?>"><button type="button" class="btn btn-block btn-primary">All Resources</button></a> -->
                  <a class="btn btn-info" href="<?php echo base_url('admin/resource');?>">All Resources </a>
                  <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
                </div>
              </div>
              <div class="panel-body container-fluid">
                
                <form autocomplete="off" method="post" action="<?php echo base_url('admin/resource/add_resource');?>">
                  
                  <input type="hidden" name="action" value="save"> 
                  
                  <?php 
                  $admin_session = $this->session->userdata('admin_logged_in');
                  if($admin_session['role'] == 'owner') { ?>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Business*</label>
                      <?php //$business_id = (isset($business_id) && $business_id!='')?$business_id:$all_resources[0]['business_id'];?>
                      <div class="form-group">
                        <select class="form-control" name="business_id" id="business_id">
                          <option value="">Select Business</option>
                          <?php if($all_business){?>
                           <?php foreach($all_business as $business){?>
                           <option value="<?php echo $business['business_id'];?>" <?php if(isset($business_id)){ if($business_id==$business['business_id']) { echo "selected"; }  }?>><?php echo $business['admin_name'];?></option>
                           <?php } } ?>
                        </select>
                        <div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if($admin_session['role'] == 'owner' or $admin_session['role'] == 'business_owner') {  ?>
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Location*</label>
                      <?php //$location_id = (isset($location_id) && $location_id!='')?$location_id:$all_resources[0]['location_id'];?>
                      <div class="form-group">
                        <select class="form-control" name="location_id" id="location_id">
                          <option value="">Select Location</option>
                          <!-- <?php if($all_location){?>
                           <?php foreach($all_location as $location){?>
                           <option value="<?php echo $location['id'];?>" <?php if(isset($location_id)){ if($location_id==$location['id']) { echo "selected"; }  }?>><?php echo $location['location_name'];?></option>
                           <?php } } ?> -->
                        </select>
                        <div class="admin_content_error"><?php echo form_error('location_id'); ?></div>
                      </div>
                    </div>
                  </div>
                <?php }else{ ?>
                  <input type="hidden" name="location_id" value="<?=$admin_session['location_id']?>" name="">
                <?php } ?>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Resource Name*</label>
                      <?php //$resource_name = (isset($resource_name) && $resource_name!='')?$resource_name:$all_resources[0]['resource_name'];?>
                      <input type="text" name="resource_name" class="form-control" id="resource_name" value="<?php if(isset($resource_name)){ echo $resource_name; }?>">
                      <div class="admin_content_error"><?php echo form_error('resource_name'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Quantity*</label>
                      <?php //$quantity = (isset($quantity) && $quantity!='')?$quantity:$all_resources[0]['quantity'];?>
                      <input type="text" name="quantity" class="form-control" id="quantity" value="<?php if(isset($quantity)){ echo $quantity; }?>">
                      <div class="admin_content_error"><?php echo form_error('quantity'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                     <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Description</label>
                      <?php //$description = (isset($description) && $description!='')?$description:$all_resources[0]['description'];?>
                      <textarea class="form-control" name="description" id="description" rows="3"><?php if(isset($description)){ echo $description; }?></textarea>
                    </div>
                  </div>
          
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <button class="btn btn-primary" data-dismiss="modal" type="submit">Save</button>
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
    <!-- End Page -->
  <!-- End page -->

<?php $this->load->view('admin/common/footer'); ?>


<script>
$(document).ready(function(){

  var sess = '<?php echo $admin_session['role']; ?>';
  
  if(sess === 'owner'){
    $("#business_id").change(function(){
      var id = this.value;
      //alert(id);
      $("#location_id option").remove();
      $("#location_id").append('<option value="">Select Location</option>'); 

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url("admin/Operations/getAllLocation/"); ?>'+id,
        datatype: 'json',
        success: function(data)
        {
          var arr = [];
          arr = JSON.parse(data);
          //alert(data);
          if(data != 'false'){
            $("#location_id option").remove();
            $.each(arr, function (index, value) {            
              //alert(value['location_name']);
              $("#location_id").append('<option value='+value['id']+'>'+value['location_name']+'</option>');       
            });

          }else{
            
            $("#location_id").append('<option value="">Select Location</option>'); 
          }
        }

      });
      
    });
  } // end of if
  else{
    var id = '<?php echo $admin_session['business_id']; ?>';

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url("admin/Operations/getAllLocation/"); ?>'+id,
        datatype: 'json',
        success: function(data)
        {
          var arr = [];
          arr = JSON.parse(data);
          //alert(data);
          if(data != 'false'){
            
            $.each(arr, function (index, value) {            
              //alert(value['location_name']);
              $("#location_id").append('<option value='+value['id']+'>'+value['location_name']+'</option>');       
            });

          }
        }

      });

  } // end of else

  
});  // end of document.ready
</script>