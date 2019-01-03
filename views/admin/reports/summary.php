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
          </div>
         <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
                       
            <!-- Actions -->
            <form autocomplete="false" method="post" action="<?php echo base_url('admin/reports/summary');?>">
              <div class="row mb-10" style="margin-left:5px;">
                 <?php $admin_session = $this->session->userdata('admin_logged_in'); 
                  ?>
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
                 <div class ="table-responsive"> 
                <form id="frm_customer" name="frm_customer" action="" method="post">
                  <div class="page-header">
                    <table id="example" class="table table-hover  table-striped w-full" data-plugin="">
                    <thead>
                      <tr>                    
                        <th class="dark-background-heading">Month</th>
                        <th class="dark-background-heading">Booking</th>
                        <th class="dark-background-heading">Booking Online</th>
                        <th class="dark-background-heading">Voucher</th>
                        <th class="dark-background-heading">Service</th>
                        <th class="dark-background-heading">Product</th>
                        <th class="dark-background-heading">Discount</th>
                        <th class="dark-background-heading">Refund</th>
                        <th class="dark-background-heading">Amount</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $all_voucher_amount=0;
                        $all_service_amount=0;
                        $product_amount=0;
                        $all_product_amount=0;
                        $all_discount_amount=0;
                        $refund_amount=0;
                        $all_refund_amount=0;
                        $all_total_amount=0;
                        $online_booking=0;
                        $offline_booking=0;
                        $all_online_booking=0;
                        $all_offline_booking=0;

                      foreach ($invoice_services as $key => $value) {                      
                        $month=date('m',strtotime($value['created_at']));
                        $year=date('Y',strtotime($value['created_at']));
                        $to_date= isset($to_date) ?$to_date:'';
                        $from_date= isset($from_date)?$from_date:'';

                        if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
                        $product_amount= getProductAmount($admin_session['business_id'],$location_id,$from_date,$to_date,$month,$year);
                         $refund_amount= getRefundMonthlyAmount($admin_session['business_id'],$location_id,$from_date,$to_date,$month,$year);
                          $offline_booking= getOfflineMonthlyBooking($admin_session['business_id'],$location_id,$from_date,$to_date,$month,$year);

                          $online_booking= getOnlineMonthlyBooking($admin_session['business_id'],$location_id,$from_date,$to_date,$month,$year);
                         
                       }
                      if ($admin_session['role']=='location_owner'||$admin_session['role']=='staff' ) {

                      // echo  $admin_session['business_id'].' '.$admin_session['location_id'].' '.$from_date.' '.$to_date.' '.$month.' '.$year.'<br/>';

                          $product_amount= getProductAmount($admin_session['business_id'],$admin_session['location_id'],$from_date,$to_date,$month,$year);

                       //  $product_amount= getStaffProductAmount($admin_session['business_id'],$location_id,$from_date,$to_date,$month,$year);
                           $refund_amount= getRefundMonthlyAmount($admin_session['business_id'],$admin_session['location_id'],$from_date,$to_date,$month,$year);

                             $offline_booking= getOfflineMonthlyBooking($admin_session['business_id'],$admin_session['location_id'],$from_date,$to_date,$month,$year);
                              $online_booking= getOnlineMonthlyBooking($admin_session['business_id'],$admin_session['location_id'],$from_date,$to_date,$month,$year);
                        }
                          $voucher_amount=  $value['total_voucher_applied'];
                          $total_service_total_price=  $value['total_service_total_price']-$value['total_voucher_applied'];
                          $service_amount=$total_service_total_price-$product_amount;
                         $discount_amount= $value['total_service_discount_price'];
                           $all_voucher_amount+=$voucher_amount;
                           $all_service_amount+=$service_amount;
                           $all_product_amount+= $product_amount;
                           $all_discount_amount+=$discount_amount;
                           $all_refund_amount+=$refund_amount;
                           $total_amount=$service_amount+$product_amount-$discount_amount-$refund_amount-$voucher_amount;
                           $all_total_amount+=$total_amount;
                           $all_online_booking+=$online_booking;
                           $all_offline_booking+=$offline_booking;
                           ?>
                        <tr>  
                        <td><?= $month=date('M Y',strtotime($value['created_at']));?></td>
                        <td><?=number_format($offline_booking,2) ?></td>
                        <td><?=number_format($online_booking,2) ?></td>                    
                        <td>-<?=number_format($voucher_amount,2)?></td>
                        <td><?=number_format($service_amount,2)?>  </td>
                        <td><?=number_format($product_amount,2)?>  </td>
                        <td>-<?=number_format($discount_amount,2)?>  </td>
                        <td>-<?=number_format($refund_amount,2)?>  </td>
                        <td><?=number_format($total_amount,2)?>  </td>
                        </tr>
                      <?php }?> 
                        </tbody>
                        <tfoot>
                          <tr>
                          <th><b>Total </b></th>
                          <th><b><?=number_format($all_offline_booking,2) ?> </b></th>
                          <th><b><?=number_format($all_online_booking,2) ?> </b></th>                         
                          <th><b><?=number_format($all_voucher_amount ,2) ?> </b></th>
                          <th><b><?=number_format($all_service_amount ,2) ?> </b></th>
                          <th><b><?=number_format($all_product_amount ,2) ?> </b></th>
                          <th><b><?=number_format($all_discount_amount ,2) ?> </b></th>
                          <th><b><?=number_format($all_refund_amount ,2) ?> </b></th>
                          <th><b><?=number_format($all_total_amount ,2) ?> </b></th>
                          </tr>
                        </tfoot>


                    </table>
                  </div>
                  </form>\
                </div>
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
     // "bSort": false,
     "order": [[0, 'asc']],
      'iDisplayLength': -1,

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





