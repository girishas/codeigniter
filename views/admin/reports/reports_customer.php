<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
  <?php $this->load->view('admin/common/left_menubar'); ?>
  <!-- Page -->
  <div class="page">
    <!-- Alert message part -->
    <?php $this->load->view('admin/common/header_messages'); ?>
    <!-- End alert message part -->
    <!-- Contacts Content -->
    <div class="page-main">
      <div class="page-content">
        <div class="panel">
          <!-- Contacts Content Header -->
          <div class="panel-heading">
            <h1 class="panel-title">Reports</h1>
            <div class="page-header-actions">
              <!-- <a href="<?php //echo base_url('admin/invoice/add_invoice');?>"><button type="button" class="btn btn-block btn-primary">Add Invoice</button></a> -->
            </div>
          </div>
          <!-- Contacts Content -->
          <div class="page-header">
             <?php $this->load->view('admin/common/report_menu'); ?>
          <!--  <ul class="nav nav-tabs" role="tablist">
              
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/');?>" >Product</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab" >Customer</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/reports_appointment');?>" >Appointment </a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/reports_voucher');?>" >Voucher </a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/reports_invoice');?>" >Invoice </a></li>
            </ul> -->
            
          </div>
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
                       
            <!-- Actions -->
              <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" ){?> 
            <form autocomplete="false" method="post" action="<?php echo base_url('admin/reports/reports_customer');?>">
              <div class="row mb-10" style="margin-left:5px;">

                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Location</label>
                    <?php $alllocaton_data= getAllLocationData(); ?>
                     <select name="location_id" id="location_id" class="form-control form-control-sm" >
                      <option value="">All Location</option>
                      <?php
                      foreach ($alllocaton_data as $key => $value) {?>
                      <?php $location_id=isset($location_id)?$location_id:0;?>

                      <option value="<?php echo  $value['id'] ?>"<?php if ($location_id ==$value['id']) {echo 'selected'; } ?>  ><?php echo $value['location_name'] ?></option>
                       
                      <?php } ?>
                    </select>
             <!-- <select class="form-control form-control-sm" name="location_id" id="location_id">
                      <option value="">All Branch</option>
                     
                      <?php foreach($locations as $row){?>
                       <option value="<?php echo $row->location_id ?>"><?php echo $row->location_name ?></option>
                       <?php }  ?>
                    </select>  -->
                  </div>
                  <div class="col-sm-2">
                    <div class="mt-25">
                     
                      <button class="btn btn-primary " name="search_filter" value="search_filter" type="submit" id="viewReportBtn">Search</button>
                    </div> 

                  </div>

              </div>
            </form>
             <?php } ?>
                
                <!-- Contacts -->

                <form id="frm_customer" name="frm_customer" action="" method="post">
                  <div class="page-header">
                  <table id="example" class="table  table-hover  table-striped w-full" data-plugin="">
                    <thead>
                      <tr>                    
                        <th class="dark-background-heading">CUSTOMER NUMBER</th>
                        <th class="dark-background-heading">CUSTOMER NAME</th>
                         <th class="dark-background-heading">BRANCH</th>
                        <th class="dark-background-heading">EMAIL</th>
                        <th class="dark-background-heading">MOBILE NUMBER</th>                      
                      </tr>
                    </thead>
                    <tbody>
                     
                      <?php $counter = 1;foreach($customers as $customer){?> 
                      <tr>
                      <td><?php echo $customer->customer_number;?></td> 
                      <td>
                         <a href="<?php echo base_url('admin/customer/detail/'.$customer->id);?>"><?php echo $customer->first_name.' '.$customer->last_name;?></a>
                        <!-- <?php echo $customer->first_name.''.$customer->last_name ?> -->
                          
                        </td>
                      <td><?php echo $customer->location_name ?></td>
                      <td><?php echo $customer->email ?></td>
                       <td><?php echo $customer->mobile_number ?></td>
                        </tr>
                        <?php $counter++;} ?>

                      </tbody>
                    </table>
                  </div>
                  </form>
                </div>
               </div>
            </div>
          </div>
        </div>
        <!-- End page -->
        <script language="javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.js');?>"></script>
        <script language="javascript" src="<?php echo base_url('assets/js/jquery.suggestion.js');?>"></script>        
       <style type="text/css">
        .dataTables_wrapper .row{
          margin-left:0 !important;
          margin-right:0 !important;
        }
        .page-content-actions {
        padding: 0 10px 10px;
        }
        .datepicker{z-index: 999999 !important};

        div.dataTables_wrapper div.dataTables_info {
    padding: .85em !important;

    }
    .page-header+.page-content {    
    overflow-x: hidden !important;
  }
   div.dt-buttons {
        margin: 5px;
    float: right;
}
        </style>  
  <?php $this->load->view('admin/common/footer'); ?>
<script type="text/javascript">
$(document).ready( function() {
  $('#example').dataTable({
     "searching": false,
      "paging": false,
      'iDisplayLength': -1,

      dom: 'Bfrtip',

         buttons: [          
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }
        ],


  });

});
</script>

<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>

<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>





