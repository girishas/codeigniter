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
                <h3 class="panel-title"> <?php if($this->uri->segment('4') == ''){ echo "Add"; }else{ echo "Edit";} ?> Notifications</h3>
                <div class="page-header-actions">
                  <!-- <a href="<?php echo base_url('admin/resource');?>"><button type="button" class="btn btn-block btn-primary">All Resources</button></a> -->
                  <a class="btn btn-info" href="<?php echo base_url('admin/notification');?>">All Notifications </a>
                  <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>  
                </div>
              </div>
              <div class="panel-body container-fluid">
                
                <form autocomplete="off" method="post" action="<?php echo base_url('admin/notification/edit_notifications/'.$this->uri->segment('4'));?>">
                  
                  <input type="hidden" name="action" value="save"> 
                  
                  <?php  $admin_session = $this->session->userdata('admin_logged_in'); ?>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Notification*</label>
                      <?php $is_all = (isset($all_notifications[0]['is_all']) && $all_notifications[0]['is_all']!='')?$all_notifications[0]['is_all']:'';?>


                     <ul class="list-unstyled list-inline">
                        <li class="list-inline-item">
                          <div class="radio-custom">&nbsp;&nbsp;</div>
                        </li>
                        <li class="list-inline-item">
                          <div class="radio-custom checkbox-primary">
                            <input type="radio" name="is_all" value="0" checked=""   />
                            <label>General</label>
                          </div>
                        </li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <li class="list-inline-item">
                          <div class="radio-custom checkbox-primary">
                            <input type="radio" name="is_all" value="1" <?php if(isset($is_all)){if($is_all == 1){ echo "checked"; } }?>  />
                            <label>Individual</label>
                          </div>
                        </li>
                      </ul>


                      <!-- <input type="radio" name="is_all" class="" value="0"  checked="" > Genral  <input type="radio" name="is_all" class="" value="1" <?php if(isset($is_all)){if($is_all == 1){ echo "checked"; } }?>  > Personal -->
                      <div class="admin_content_error"><?php echo form_error('is_all'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row staff_list" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Staff*</label>
                       <?php $staff_id = (isset($all_notifications[0]['staff_id']) && $all_notifications[0]['staff_id']!='')?$all_notifications[0]['staff_id']:'';?>
                      <div class="form-group">
                        <select class="form-control" name="staff_id" id="staff_id" data-plugin="select2">
                          <option value="">Select Staff</option>
                          <?php if($all_staff){?>
                           <?php foreach($all_staff as $value){?>
                           <option value="<?php echo $value['id'];?>" <?php if(isset($staff_id)){ if($staff_id==$value['id']) { echo "selected"; }  }?>><?php echo $value['first_name']." ".$value['last_name'];?></option>
                           <?php } } ?>
                        </select>
                        <div class="admin_content_error"><?php echo form_error('staff_id'); ?></div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group  row" data-plugin="formMaterial">
                     <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid1">Comments*</label>
                      <?php $comments = (isset($all_notifications[0]['comments']) && $all_notifications[0]['comments']!='')?$all_notifications[0]['comments']:'';?>
                      <textarea class="form-control" name="comments" id="comments" rows="3"><?php if(isset($comments)){ echo $comments; }?></textarea>
                      <div class="admin_content_error"><?php echo form_error('comments'); ?></div>
                    </div>
                  </div>

                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <label class="form-control-label" for="inputGrid2">Status</label>
                      <?php  $status = (isset($all_notifications[0]['status']) && $all_notifications[0]['status']!='')?$all_notifications[0]['status']:'';?>
                      <div class="form-group">
                        <select class="form-control" name="status" id="status">
                          	<option value="">Select Status</option>
                           	<option value="1" <?php if(isset($status)){ if($status==1) { echo "selected"; }  }?>>Active</option>
                           	<option value="0" <?php if(isset($status)){ if($status==0) { echo "selected"; }  }?>>Inactive</option>
                        </select>
                        <div class="admin_content_error"><?php echo form_error('status'); ?></div>
                      </div>
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


<script >
	$(document).ready(function(){
		//staff_list

    var chk = "<?php echo $is_all = (isset($all_notifications[0]['is_all']) && $all_notifications[0]['is_all']!='')?$all_notifications[0]['is_all']:'';?>";
    //alert(chk);
    if(chk == 0){
      $(".staff_list").hide();
    }

		$("input[name=is_all]").click(function() {
	        var test = $(this).val();
	        if(test == '0'){
	        	$(".staff_list").hide();
	        }else{
	        	$(".staff_list").show();
	        }
	    });

	});
</script>

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