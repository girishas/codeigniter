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
           
          </div>
          <!-- Contacts Content -->
           <?php $admin_session = $this->session->userdata('admin_logged_in'); ?>

           <div class="page-header">
             <?php $this->load->view('admin/common/report_menu'); ?>
            
          </div>
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
            
             <form autocomplete="false" method="post" action="">
              <div class="row mb-10" style="margin-left:5px;">
                     <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" ){?> 
                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Location</label>
                  
                   <!--  <select data-placeholder="Select Location" class="form-control form-control-sm" data-plugin="select2" name="location_id" id="location_id">
                    </select> -->
                     <?php $alllocaton_data= getAllLocationData(); ?>
                     <select name="location_id" id="location_id" class="form-control form-control-sm" >
                      <option value="">All Location</option>
                      <?php
                      foreach ($alllocaton_data as $key => $value) {?>
                      <?php $location_id=isset($location_id)?$location_id:0;?>

                      <option value="<?php echo  $value['id'] ?>"<?php if ($location_id ==$value['id']) {echo 'selected'; } ?>  ><?php echo $value['location_name'] ?></option>
                       
                      <?php } ?>
                    </select>
                  </div>
                   <?php } ?>

                  
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
               
                <div class ="table-responsive"> 
                <form id="frm_customer" name="frm_customer" action="" method="post">
                   <table id="example" class="table table-hover  table-striped w-full" data-plugin="">

                    <thead>

                      <tr>
                        <th class="dark-background-heading">DAY</th>
                        <th class="dark-background-heading">Location</th>
                        <th class="dark-background-heading">Opening Balance</th>
                        <th class="dark-background-heading">Cash In</th>                     
                        <th class="dark-background-heading">Cash Out </th>
                        <th class="dark-background-heading">Net Cash </th>
                        <th class="dark-background-heading">Closing Balance </th>
                      </tr>
                    </thead>
                    <tbody>        <?php 
                                 $all_cash_total_in= 0;
                                 $all_cash_total_out= 0;
                                  $all_netamount=0;   
                                  $all_final_total=0;
                                  $all_open_cash=0;
                                  $cash_out=0;
                                  $cash_in=0;
                                       ?>
                                    <?php foreach ($todayopening as $key => $value):
                                       
                                     
                                    $cash_in=$value['cash_payment'] ;
                                    $cash_out=$value['cash_total_refund']+$value['cash_total_expence'] ;
                                    $netamount= $cash_in-$cash_out;
                                    $final_total=$netamount+$value['open_cash'];

                                    $all_cash_total_in +=$cash_in;
                                    $all_cash_total_out +=$cash_out;
                                    $all_netamount +=$netamount;
                                    $all_final_total +=$final_total;
                                    $all_open_cash +=$value['open_cash'];
                                   
                                     ?>
                                    <tr>
                                        
                                        <td><?= date("D, d M  Y", strtotime($value['open_date'])) ; ?>
                                        </td>
                                        <td><?= getLocationNameById($value['location_id']) ?>
                                        </td>
                                       
                                        <td><?=number_format($value['open_cash'],2)?></td>

                                        <td><?=number_format($cash_in,2)?></td>
                                        <td>-<?=number_format($cash_out,2)?></td>

                                          <td><?=number_format($netamount,2)?></td>
                                          <td><?=number_format($final_total,2)?></td>
                                    </tr>
                                    <?php endforeach; ?>   
                                </tbody>
							    <tfoot>
                                  <tr>
                                      <th> </th>
                                       <th><b>Total </b></th>
                                       <th><b><?php echo number_format($all_open_cash,2); ?> </b></th>
                                       <th><b><?php echo number_format($all_cash_total_in,2); ?> </b></th>
                                       <th><b>-<?php echo number_format($all_cash_total_out,2); ?> </b></th>
									   <th><b><?php echo number_format($all_netamount,2); ?> </b></th>
                                       <th><b><?php echo number_format($all_final_total,2); ?> </b></th>
                                    </tr> 
                                </tfoot>
                    </table>
                </form>
                  </div>
                <!--<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
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




<script>
$(document).ready(function(){
  // select report
  
  $("#select_report").change(function(){

    if($(this).val() != ''){
      //alert('<?php //echo base_url(); ?>'+$(this).val());
      window.location.replace('<?php echo base_url(); ?>'+$(this).val());
    }
  });
  
});  // end of document.ready
</script>

<script type="text/javascript">
$(document).ready( function() {
  $('#example').dataTable({
     "searching": false,
      "paging": false,
      'iDisplayLength': -1,
      //order: [[0, 'asc']],

      dom: 'Bfrtip',
      /*   buttons: [
            'print', 'csv', 'excel', 'pdf', 
        ],*/

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



