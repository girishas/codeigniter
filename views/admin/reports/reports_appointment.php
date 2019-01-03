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
           <!-- <ul class="nav nav-tabs" role="tablist">
              
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/');?>" >Product </a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/reports_customer');?>" >Customer</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab" >Appointment </a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/reports_voucher');?>" >Voucher </a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/reports_invoice');?>" >Invoice </a></li>
            </ul> -->
            
          </div>
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
                       
            <!-- Actions -->
            <form autocomplete="false" method="post" action="<?php echo base_url('admin/reports/reports_appointment');?>">
              <div class="row mb-10" style="margin-left:5px;">
                <!-- <div class="col-md-2">
                    <label class="form-control-label" for="inputGrid2">Invoice Date</label>
                    <input type="text" class="form-control empty" data-date-today-highlight="true" data-plugin="datepicker" id="booking_date" name="booking_date" value="<?php echo isset($booking_date)?$booking_date:date('m/d/Y')  ?>">
                  </div> -->
                <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" ){?> 
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
            <!--  <select class="form-control form-control-sm" name="location_id" id="location_id">
                      <option value="">All Branch Name</option>
                      <?php 
                      foreach ($locations as $key => $location) { ?>
                         <option value="<?php echo $location->location_id ?>"><?php echo $location->location_name ?> </option>
                     <?php }
                      ?>
                      
                    </select> --> 
                  </div>
                  <?php }
                      ?>


                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Staff Name</label>
             <select class="form-control form-control-sm" name="staff_id" id="staff_id">
                      <option value="">All Staff</option>
                      <?php 
                      foreach ($staffs as $key => $staff) { ?>
                       <?php $staff_id=isset($staff_id)?$staff_id:'';?>
                         <option value="<?php echo $staff->staff_id ?>"<?php if ($staff_id ==$staff->staff_id) {echo 'selected'; } ?>><?php echo $staff->staff_first_name.''.$staff->staff_last_name ?> </option>
                     <?php }
                      ?>
                      
                    </select> 
                  </div>
                   <?php $status=isset($status)?$status:'-1';
                   //echo $status; 
                   ?>
                    <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Status</label>
             <select class="form-control form-control-sm" name="status" id="status">
              <?php $status=isset($status)?$status:'-1';?>
                      <option value="-1" <?php if ($status == '-1' ) {echo 'selected'; } ?>>All Status</option>
                         
                       <option value="0" <?php if ($status == 0) {echo 'selected'; } ?> >new booking on store</option>
                      <option value="1" <?php if ($status ==1) {echo 'selected'; } ?>>booking on online</option>
                      <option value="2" <?php if ($status ==2) {echo 'selected'; } ?> >cancelled</option>
                      <option value="3" <?php if ($status ==3) {echo 'selected'; } ?> >paid or completed</option>
                      <option value="4" <?php if ($status ==4) {echo 'selected'; } ?> >No Show</option>
                      <option value="5" <?php if ($status ==5) {echo 'selected'; } ?> >Arrived</option>
                      <option value="6" <?php if ($status ==6) {echo 'selected'; } ?> >Confirmed</option>
                      <option value="7" <?php if ($status ==7) {echo 'selected'; } ?> >Started</option>
                      <option value="8" <?php if ($status ==8) {echo 'selected'; } ?> >Re-Confirmed</option> 
                      
                    </select> 
                  </div>

                  <div class="col-md-2">
                    <label class="form-control-label" for="inputGrid2">From Date</label>
                    <input type="text" class="form-control empty" data-date-today-highlight="true" data-plugin="datepicker" id="from_date" data-date-format="dd-mm-yyyy" autocomplete="off" name="from_date" value="<?php echo isset($from_date)?$from_date:''  ?>">
                  </div>


                  <div class="col-md-2">
                    <label class="form-control-label" for="inputGrid2">To Date</label>
                    <input type="text" class="form-control empty" data-date-today-highlight="true" data-plugin="datepicker" data-date-format="dd-mm-yyyy" autocomplete="off" id="to_date" name="to_date" value="<?php echo isset($to_date)?$to_date:''  ?>">
                  </div>

                  <div class="col-sm-2">
                    <div class="mt-25">
                     
                      <button class="btn btn-primary " name="search_filter" value="search_filter" type="submit" id="viewReportBtn">Search</button>
                    </div> 

                  </div>

              </div>
            </form>
                
                <!-- Contacts -->

                <form id="frm_customer" name="frm_customer" action="" method="post">
                 
                 <table id="example" class="table  table-hover  table-striped w-full" data-plugin="">
                    <thead>
                      <tr>                    
                        <th class="dark-background-heading">BOOKING NUMBER</th>
                        <th class="dark-background-heading">Customer</th>
                       <!--   <th class="dark-background-heading">Mobile No.</th>                        
                        <th class="dark-background-heading">Email</th> -->
                        <th class="dark-background-heading">Location</th> 
                        <th class="dark-background-heading">Staff</th>
                        <th class="dark-background-heading">Service</th> 
                        <th class="dark-background-heading">Date</th>
                      <!--   <th class="dark-background-heading">Start time</th> 
                        <th class="dark-background-heading">Duration</th> -->
                        <th class="dark-background-heading">Amount</th>
                         <th class="dark-background-heading">status</th>              
                      </tr>
                    </thead>
                    <tbody>
                     
                      <?php $counter = 1;foreach($bookings as $booking){ ?> 
                      <tr>
                      <td>
                         <a href="<?php echo base_url('admin/service/calendar_view/'.$booking->bookings_id);?>"><?php echo $booking->booking_number ?></a></td> 
                      <td><?php
                      if ($booking->customer_id!='') {
                        ?>
                        <a href="<?php echo base_url('admin/customer/detail/'.$booking->customer_id);?>"><?php echo $booking->customer_first_name.''.$booking->customer_last_name;?></a>
                        <?php
                      }
                      else{
                        echo "anonymous";
                      }
                      ?>
                      
                       
                      </td>
                     <!--  <td><?php echo $booking->customer_mobile_number ?></td>
                      <td><?php echo $booking->customer_email ?></td> -->
                      <td><?php echo $booking->location_name ?></td>
                      <td><?php echo $booking->staff_first_name.''.$booking->staff_last_name ?></td>
                      <td><?php echo $booking->service_timing_caption ?></td>
                      <td><?php echo date('d-m-Y',strtotime($booking->start_date)) ?></td>
                     <!--  <td><?php echo $booking->start_time ?></td>
                      <td><?php echo $booking->book_duration ?></td> -->
                       <td><?php                       
                        if ($booking->special_price==0) { 
                          echo $booking->retail_price;
                        }
                        else {
                           echo $booking->special_price;
                        }
                         ?></td>                      
                      <td><?php echo getBookingStatus($booking->booking_status); ?></td>
                       
                      
                        </tr>
                        <?php $counter++;} ?> 

                      </tbody>
                    </table>
                 
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
<script type="text/javascript"> 
    $(document).ready(function() {    
    $('#location_id').change(function() {  
            var location_id = $("#location_id").val(); 
            if (location_id>0) {
              $.ajax({
                url: site_url + 'admin/reports/getStaffbyLocationId',
                type: 'POST',
                data:{location_id:location_id},
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(data) {
                   if (data.status=='success') { 
                     $('#staff_id').html(data.staff_html);
                   }

                }
            });

            }         
            
    });
});
</script>