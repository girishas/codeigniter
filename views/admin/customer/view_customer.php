<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
<?php $this->load->view('admin/common/left_menubar'); ?>  
  <!-- Page -->
 <div class="page bg-white">
     <!-- Alert message part -->
	 <?php $this->load->view('admin/common/header_messages'); ?>
	<!-- End alert message part -->  
	  <!-- Contacts Content -->
      <div class="page-main">

        <!-- Contacts Content Header -->
        <div class="page-header">
          <h1 class="page-title">Customers Detail</h1>
		  <div class="page-header-actions"><a href="<?php echo base_url('admin/customer/add_customer');?>"><button type="button" class="btn btn-block btn-primary">Add Customer</button></a></div> 
        </div>

        <!-- Contacts Content -->
        <div class="container">
        <div id="contactsContent" class="page-content page-content-table">
		  <!-- Actions -->
          <table class="table table-hover dataTable table-striped w-full" >
             <tbody>
             	<tr>
             		<td width="100"><b>Name : </b></td>
             		<td><?php echo $data->first_name." ".$data->last_name; ?></td>
             	</tr>
             	<tr>
             		<td width="100"><b>Email : </b></td>
             		<td><?php echo $data->email; ?></td>
             	</tr>
             	<tr>
             		<td width="100"><b>Mobile : </b></td>
             		<td><?php echo $data->mobile; ?></td>
             	</tr>
             	<tr>
             		<td width="100"><b>Custumer Type : </b></td>
             		<td><?php echo $data->custumer_type; ?></td>
             	</tr>
             </tbody>
           </table>
        </div>
    </div>
      </div>
    </div>
<style type="text/css">
.dataTables_wrapper .row{
	margin-left:0 !important;
	margin-right:0 !important;
}
.page-content-actions {
    padding: 0 10px 10px;
}
</style>
<?php $this->load->view('admin/common/footer'); ?>