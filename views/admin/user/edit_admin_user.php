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
	
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Edit Location Admin</h3>
				<div class="page-header-actions"><a href="<?php echo base_url('admin/user');?>"><button type="button" class="btn btn-block btn-primary">All Location Admins</button></a></div>
              </div>
              <div class="panel-body container-fluid">
                <form autocomplete="off" method="post" action="">                  
                  <input type="hidden" name="action" value="save"> 
				  
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid2">Location</label>
                       <?php $location_id_value = (isset($location_id) && $location_id!='')?$location_id:$admin_detail[0]['location_id'];?>
					   <select class="form-control" name="location_id" id="location_id">
					   	<option value="">Select Location</option>
						<?php if($locations){?>
						<?php foreach($locations as $loc){?>
							<option value="<?php echo $loc['id'];?>" <?php if(isset($location_id_value) && $location_id_value==$loc['id']) echo "selected"; ?>><?php echo $loc['location_name'];?></option>
						<?php } } ?>
					   </select>
					  <div class="admin_content_error"><?php echo form_error('location_id'); ?></div>
                    </div>
                    <div class="col-md-6" id="location_section">
                      <?php $admin_name_value = (isset($admin_name) && $admin_name!='')?$admin_name:$admin_detail[0]['admin_name'];?>
					  <label class="form-control-label" for="inputGrid1">Name</label>
                      <input type="text" class="form-control" id="admin_name" name="admin_name" value="<?php if(isset($admin_name_value)) echo $admin_name_value;?>">
					  <div class="admin_content_error"><?php echo form_error('admin_name'); ?></div>
                    </div>
                  </div>
				 
				  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                       <?php $email_value = (isset($email) && $email!='')?$email:$admin_detail[0]['email'];?>
					  <label class="form-control-label" for="inputGrid2">Email</label>
                      <input type="text" class="form-control" id="email" name="email" value="<?php if(isset($email_value)) echo $email_value;?>" />
					  <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>
                    <div class="col-md-6">
                       <?php $password_value = (isset($password) && $password!='')?$password:"";?>
					   <label class="form-control-label" for="inputGrid1">Password</label>
                      <input type="text" class="form-control" name="password" id="password" value="<?php if(isset($password_value)) echo $password_value;?>">
					  <div style="float:left;">Enter value to change the password</div>
					  <div class="admin_content_error"><?php echo form_error('password'); ?></div>
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
<script language="javascript">
function show_hide_business_location(val)
{
	$("select#business_id").val('');
	$("#location_section").hide();
	$('#content_location_id').html('');
	if(val!=''){
		$("#business_location_id").show();
	}else{
		$("#business_location_id").hide();
	}
}
function show_location(val)
{
	var admin_role = $("#role").val();
	if(val!=""){		
		if(admin_role=="location_owner"){
			$("#location_section").show();
			get_like_sub_category(val);
		}
	}else{
		$("#location_section").hide();
	}
}

function get_like_sub_category(business_id) {
	if(business_id=='')
		return false;
	$.ajax({
		type: 'POST',
		url: site_url + 'admin/Operations/get_business_locations/' + encodeURIComponent(business_id),
		datatype: 'json',
		success: function(data)
		{
		   data = JSON.parse(data);
			if (data.status == 'not_logged_in') {
				location.href= site_url + 'admin'
			}else if(data.status == 'success') {
				$('#content_location_id').html(data.copyright_like_html);
			}else {
				alert('Something went wrong, please refresh page and try again');
			}
		}
	});    
}

</script>

<?php $this->load->view('admin/common/footer'); ?>