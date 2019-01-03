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
            <form autocomplete="false" method="post" action="<?php echo base_url('admin/reports/finances_summary');?>">
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
                    <input type="text" class="form-control empty" data-date-today-highlight="true" data-plugin="datepicker" id="from_date" data-date-format="dd-mm-yyyy" autocomplete="off" name="from_date" value="<?php echo isset($from_date)?$from_date:date('d-m-Y')  ?>">
                  </div>


                  <div class="col-md-2">
                    <label class="form-control-label" for="inputGrid2">To Date</label>
                    <input type="text" class="form-control empty" data-date-today-highlight="true" data-plugin="datepicker" data-date-format="dd-mm-yyyy" autocomplete="off" id="to_date" name="to_date" value="<?php echo isset($to_date)?$to_date:date('d-m-Y')  ?>">
                  </div>
                

                  <div class="col-sm-2">
                    <div class="mt-25">
                     
                      <button class="btn btn-primary " name="search_filter" value="search_filter" type="submit" id="viewReportBtn">Search</button>
                    </div> 

                  </div>

              </div>
            </form>         

                <form id="frm_customer" name="frm_customer" action="" method="post">
                  <div class="page-header">
                  <table id="example" class="table  table-hover  table-striped w-full" data-plugin="">
                    <thead>
                      <tr>                    
                        <th class="dark-background-heading">Payments</th>
                        <th class="dark-background-heading">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                      <?php
                     // print_r($admin_session);

                      $total_amount=0;
                      $cash_amount=0;
                      $creditcard_amount=0;
                      $voucher_amount=0;
                      $cheque_amount=0;
                      $refund_amount=0;
                      $discount_amount=0;
                      $total_expences=0;
                      $wallet_amount=0;
                       $counter = 1;foreach($payments as $payment){
                       // $total_amount+=$payment['total_amount'];

                        if ($payment['payment_type_id']==5 && $payment['pay_service_type']!=7 && $payment['pay_service_type']!=8 && $payment['pay_process_type']!=4 && $payment['pay_service_type']!=9) {
                           $cash_amount+=$payment['total_amount'];
                        }

                         if ($payment['payment_type_id']==6 && $payment['pay_service_type']!=7 && $payment['pay_service_type']!=8 && $payment['pay_process_type']!=4 && $payment['pay_service_type']!=9) {
                           $creditcard_amount+=$payment['total_amount'];
                        }

                        if ($payment['payment_type_id']==7 && $payment['pay_service_type']!=7 && $payment['pay_service_type']!=8 && $payment['pay_process_type']!=4 && $payment['pay_service_type']!=9) {
                           $voucher_amount+=$payment['total_amount'];
                        }

                         if ($payment['payment_type_id']==8 && $payment['pay_service_type']!=7 && $payment['pay_service_type']!=8 && $payment['pay_process_type']!=4 && $payment['pay_service_type']!=9) {
                           $cheque_amount+=$payment['total_amount'];
                        }

                         if ($payment['pay_service_type']==9 ||$payment['payment_type_id']==9 ) {
                           $wallet_amount+=$payment['total_amount'];
                        }

                        /*if ($payment['pay_process_type']==4) {
                           $refund_amount+=$payment['total_amount'];
                        }*/

                         $to_date= isset($to_date) ?$to_date:date('d-m-Y'); 
                           $from_date= isset($from_date)?$from_date:date('d-m-Y'); 
                          if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
                        $refund_amount= getRefundAmount($admin_session['business_id'],$location_id,$from_date,$to_date);
                         $total_expences= getExpencesAmount($admin_session['business_id'],$location_id,$from_date,$to_date);
                         
                       }

                          if ($admin_session['role']=='location_owner' || $admin_session['role']=='staff') {                  
                        $refund_amount= getRefundAmount($admin_session['business_id'],$admin_session['location_id'],$from_date,$to_date);

                          $total_expences= getExpencesAmount($admin_session['business_id'],$admin_session['location_id'],$from_date,$to_date);
                        
                      }

                        if ($payment['pay_service_type']==7 || $payment['pay_service_type']==8) {
                           $discount_amount+=$payment['total_amount'];
                        }

                        $total_amount=($cash_amount+$creditcard_amount+$voucher_amount+$cheque_amount-$refund_amount-$discount_amount+$wallet_amount-$total_expences);

                     
                       // echo $total_amount;
                        ?>

                        <?php $counter++;} ?>  
                       
                   <tr>
                      <td>Cash </td>
                      <td><?=number_format($cash_amount,2)?> </td>
                    </tr>

                    

                    <tr>
                      <td>Credit Card </td>
                      <td><?=number_format($creditcard_amount,2)?></td>
                    </tr>

                    

                    <tr>
                      <td>Cheque </td>
                      <td><?=number_format($cheque_amount,2)?></td>
                    </tr>

                    <tr>
                      <td>Wallet </td>
                      <td><?=number_format($wallet_amount,2)?></td>
                    </tr>

                    


                     <tr>
                      <td>Voucher </td>
                      <td><?=number_format($voucher_amount,2)?></td>
                    </tr>

                    <tr>
                      <td>Discount </td>
                      <td>-<?=number_format($discount_amount,2)?> </td>
                    </tr>

                    <tr>
                      <td>Refund </td>
                      <td>-<?=number_format($refund_amount,2)?></td>
                    </tr>

                    <tr>
                      <td>Expense </td>
                      <td><?php                      
                    /* $total_expences= isset($expences['total_expences_amount'])?$expences['total_expences_amount']:0;*/
                  // $total_expences=isset($total_expences)?$total_expences:0;
                     echo -number_format($total_expences,2);
                      ?></td>
                    </tr>

                      <tr> 
                        <th> <b> Total  </b> </th>
                        <th> <b> <?=number_format($total_amount,2)?> </b>  </th>                               
                      </tr>
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
       "ordering": false,
        "lengthChange": false

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





