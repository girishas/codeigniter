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
                <h3 class="panel-title">Edit Membership</h3>
                <div class="page-header-actions">
                  <!-- <a href="<?php echo base_url('admin/resource');?>"><button type="button" class="btn btn-block btn-primary">All Resources</button></a> -->
                  <a class="btn btn-primary" href="<?php echo base_url('admin/membership');?>">All Memberships </a>
                  <!-- <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>  --> 
                </div>
              </div>
              <div class="panel-body container-fluid">
                
                <form autocomplete="off" method="post" action="<?php echo base_url('admin/membership/edit_membership/'.$this->uri->segment('4'));?>">
                  
                  <input type="hidden" name="action" value="save"> 
                  
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Membership Name</label>
                      <?php $name = (isset($name) && $name!='')?$name:$all_memberships[0]['name'];?>
                      <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>">
                      <div class="admin_content_error"><?php echo form_error('name'); ?></div>
                    </div>
                    
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Stripe Plan Id</label>
                      <?php $stripe_plan_id = (isset($stripe_plan_id) && $stripe_plan_id!='')?$stripe_plan_id:$all_memberships[0]['stripe_plan_id'];?>
                      <input type="text" class="form-control" name="stripe_plan_id" id="stripe_plan_id" value="<?php echo $stripe_plan_id; ?>">
                      <div class="admin_content_error"><?php echo form_error('stripe_plan_id'); ?></div>
                    </div>
                    
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Price</label>
                      <?php $plan_price = (isset($plan_price) && $plan_price!='')?$plan_price:$all_memberships[0]['plan_price'];?>
                      <input type="text" class="form-control" id="plan_price" name="plan_price" placeholder="0.00" value="<?php echo $plan_price; ?>"/>
                      <div class="admin_content_error"><?php echo form_error('plan_price'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Number of Staff Allowed</label>
                      <?php $staff_allowed = (isset($staff_allowed) && $staff_allowed!='')?$staff_allowed:$all_memberships[0]['staff_allowed'];?>
                      <input type="text" class="form-control" id="staff_allowed" name="staff_allowed" value="<?php echo $staff_allowed; ?>" >
                      <div class="admin_content_error"><?php echo form_error('staff_allowed'); ?></div>
                    </div>
                    
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <button class="btn btn-primary" data-dismiss="modal" type="submit">Update</button>
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

  // location selected on load
  var res_id = '<?php echo $this->uri->segment("4"); ?>';
  $("#location_id option").remove();
  if(res_id){

    $.ajax({
      type: 'POST',
      url: '<?php echo base_url("admin/Operations/getSelectedLocation/"); ?>'+res_id,
      datatype: 'json',
      success: function(data)
      {
        var arr = [];
        arr = JSON.parse(data);
        //alert(arr['location']);
        //alert(arr['location_id']);
        
        if(data != 'false'){
          $("#location_id option").remove();
          $.each(arr['location'], function (index, value) {            
            //alert(value['location_name']);
            $("#location_id").append('<option value='+value['id']+'>'+value['location_name']+'</option>');       
          });
          
          $("#location_id").val(arr['location_id']).find("option[value=" + arr['location_id'] +"]").attr('selected', true);

        }else{
          
          //$("#location_id").append('<option value="">Select Location</option>'); 
        }
      }

    });
  }
  // location selected om load
  
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

    $("#location_id option").remove();
    //$("#location_id").append('<option value="">Select Location</option>'); 

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