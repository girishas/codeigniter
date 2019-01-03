<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>  
 <!-- Page -->
    <div class="page">
      <div class="page-header">
        <h1 class="page-title">Email Templates</h1>
		
      </div>
	 <div class="page-content container-fluid">
        <!-- Panel Tabs -->
        <div class="panel">
          <div class="panel-body container-fluid">
            <div class="row row-lg">
              <div class="col-xl-12">
                <!-- Example Tabs -->
                <div class="example-wrap">
                  <div class="nav-tabs-horizontal" data-plugin="tabs">
                        <!-- Panel Interaction -->
						<div class="panel">
						  <div class="row row-lg">
							  <div class="col-lg-12">
								<!-- Example Basic -->
								<div class="example-wrap">
								  <div class="example table-responsive">
									<table class="table">
									  <thead>
										<tr>
										  <th>#</th>
										  <th>Template Name</th>
										  <th>Subject</th>
										  <th>View Template</th>
										  <th>Edit</th>
										</tr>
									  </thead>
									  <tbody>
										<tr>
										  <td>1</td>
										  <td>Appointment Confirmation</td>
										  <td>Your appointment is confirmed</td>
										  <td><a href="<?php echo base_url('admin/service/email_templates_detail');?>"><button type="button" class="btn btn-info btn-xs waves-effect waves-classic">View Layout</button></a></td>
										  <td><a href="<?php echo base_url('admin/service/edit_template');?>">Edit</a></td>
										</tr>
									  </tbody>
									</table>
								  </div>
								</div>
								<!-- End Example Basic -->
							  </div>
							</div>
						</div>
						<!-- End Panel Interaction -->
					</div>
                  </div>
                <!-- End Example Tabs -->
              </div>
            </div>
          </div>
        </div>
        <!-- End Panel Tabs -->
        </div> 
    </div>
    <!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>