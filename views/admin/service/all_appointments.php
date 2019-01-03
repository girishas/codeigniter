<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <?php $this->load->view('admin/common/left_menubar'); ?>
  <!-- Page -->
  <div class="page">
    
    <!-- Contacts Content -->
    <div class="page-main">
      <div class="page-content">
        <div class="panel">
      <!-- Contacts Content Header -->
      <div class="page-header">
        <h1 class="page-title">All Appointments</h1>
        <div class="page-header-actions"><a href="<?php echo base_url('admin/service/calendar');?>"><button type="button" class="btn btn-block btn-primary">Add New Appointment</button></a></div>
      </div>

     
      <!-- Contacts Content -->
      <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
        <table id="example" class="table table-hover  table-striped w-full" data-plugin="">
          <thead>
            <tr>
             <!--  <th class="pre-cell dark-background-heading"></th>
              <th scope="col" class="dark-background-heading">
                <span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
                  <input type="checkbox" class="contacts-checkbox selectable-all" id="select_all"
                  />
                  <label for="select_all"></label>
                </span>
              </th> -->
              <!-- <th class="cell-100 dark-background-heading" scope="col">Service Name</th> -->
              <th class="dark-background-heading">Booking Number</th>
              <th class="dark-background-heading">Staff Name</th>
              <th class="dark-background-heading"">Customer Name</th>
              <th class="dark-background-heading">Start Time</th>
              <th class="dark-background-heading">Duration</th>
              <th class="dark-background-heading">Start date</th>
             <!--  <th class="cell-30 dark-background-heading" scope="col">Status</th> -->
             
              <!-- <th class="cell-50 dark-background-heading" scope="col">
                <div class="btn-group dropdown">
                  <button type="button" class="btn btn-default dropdown-toggle" id="exampleColorDropdown1" data-toggle="dropdown" aria-expanded="false">Actions</button>
                  <div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">Confirmed All</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">Process All</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">Cancelled All</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">Completed All</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-pause" aria-hidden="true"></i>Inactive All</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete All</a>
                  </div>
                </div>
              </th> -->
             <!--  <th class="suf-cell"></th> -->
            </tr>
          </thead>
          <tbody>
            <?php
             $counter = 1; foreach ($appointment as $key => $val) {?>
               <tr>
             <!--  <td class="pre-cell"></td>
              <td class="cell-30">
                <span class="checkbox-custom checkbox-primary checkbox-lg">
                  <input type="checkbox" class="contacts-checkbox selectable-item" id="contacts_1"
                  />
                  <label for="contacts_1"></label>
                </span>
              </td> -->
               <td><a href="<?= base_url('admin/service/calendar_view/'.$val->id)?>"><?php echo $val->booking_number ?></a></td>
              <td> <?php echo $val->staff_first_name.''.$val->staff_last_name ?></td>
              <td><?php if ($val->customer_first_name!='') {
                echo $val->customer_first_name.''.$val->customer_last_name;
              }
              else{?>
              walk in
              <?php
             }
              
               ?>                

              </td>
            
              <td><?php echo date('h:i:s a', strtotime($val->book_start_time)); ?></td>              
              <td> <?php $timeArr = explode(":", $val->book_duration);echo $timeArr[0].' Hours: '. $timeArr[1].' Minutes';
                              ?></td>
              <td><?php echo date('j M Y', strtotime($val->start_date));  ?></td>             
            </tr>
            <?php $counter++;}?>
          </tbody>
        </table>
    </div>
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
<!-- End page -->
<?php $this->load->view('admin/common/footer'); ?>
<script type="text/javascript">
$(document).ready( function() {
  $('#example').dataTable( {
    order: [],
    columnDefs: [ { orderable: false, targets: [0,-1] } ]
  });
});
</script>