<?php $this->load->view('admin/common/header'); ?>
<style>
.hide {
    display:none; 
}
</style>
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
                
                 <div class="col-sm-3">
                   <?php 
                   $last = $this->uri->total_segments();
                  $r_select = $this->uri->segment($last);
                  ?>

                    <label class="form-control-label" for="inputGrid2">Choose a report</label>
                    <select  data-placeholder="Select Report" class="form-control form-control-sm" data-plugin="select2" name="select_report" id="select_report">
                      <option value="">Select Report</option>
                      <option value="admin/reports" <?php if(!empty($r_select)){ if($r_select == 'reports') { echo "selected"; }} ?> >Daily Sales</option>
                      <option value="admin/reports/sale_by_staff" <?php if(!empty($r_select)){ if($r_select == 'sale_by_staff') { echo "selected"; }} ?> >Sale by Staff</option>

                      <option value="admin/reports/sale_by_day" <?php if(!empty($r_select)){ if($r_select == 'sale_by_day') { echo "selected"; }} ?> >Sale by Day</option>
                      <option value="admin/reports/sale_by_month" <?php if(!empty($r_select)){ if($r_select == 'sale_by_month') { echo "selected"; }} ?> >Sale by month</option>
                    </select>
                  </div>
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

                  <div class="col-sm-2">
                   <label class="form-control-label" for="inputGrid2">Date</label>
                      <input type="text" class="form-control" name="from_date" id="from_date" data-plugin="datepicker" data-date-today-highlight="true" autocomplete="off" data-date-format="dd-mm-yyyy" value="<?php echo(isset($from_date)?$from_date:'' ) ?>">
                  </div>

                  <div class="col-sm-2">
                   <label class="form-control-label" for="inputGrid2">To Date</label>
                      <input type="text" class="form-control" name="to_date" id="to_date" data-plugin="datepicker" data-date-today-highlight="true" autocomplete="off" data-date-format="dd-mm-yyyy" value="<?php echo (isset($to_date) ?$to_date:'' ) ?>">
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
                        <th class="dark-background-heading">SALE QTY</th>
                        <th class="dark-background-heading">TOTAl</th>                     
                        <th class="dark-background-heading">DISCOUNT </th>
                        <th class="dark-background-heading">REFUND</th>
                        <th class="dark-background-heading">Expense </th>
                        <th class="dark-background-heading">TOTAL SALES </th>
                        <th class="dark-background-heading">TAX </th>
                        <th class="dark-background-heading">NET SALES </th>
                      </tr>
                    </thead>
                    <tbody>        <?php  $all_total= 0;
                                      $all_qty=0;
                                       $all_discount=0;
                                        $all_net=0;
                                        $all_tax=0;
                                        $all_final_total=0;
                                        $all_ExpencesAmount=0;
                                        $all_refund=0;
                                       ?>
                                    <?php foreach ($invoice_services as $key => $value):
                                       
											if ($admin_session['role']=='business_owner'||$admin_session['role']=='owner' && $admin_session['business_id']!='' ) {
												$location_id = isset($location_id)?$location_id:'';
                          /*$to_date= isset($to_date) ?$to_date:''; 
                           $from_date= isset($from_date)?$from_date:'';*/ 
												$RefundAmount= getRefundAmount($admin_session['business_id'],$location_id,$value['date_created'],$value['date_created']);

                        $ExpencesAmount= getExpencesAmount($admin_session['business_id'],$location_id,$value['date_created'],$value['date_created']);
                       //echo  $admin_session['business_id'].'<br>'.$location_id.'<br>'.$from_date.'<br>'.$to_date;
											}

                     // echo $ExpencesAmount; //exit;

											if ($admin_session['role']=='location_owner'|| $admin_session['role']=='staff') {
												
												$RefundAmount= getRefundAmount($admin_session['business_id'],$admin_session['location_id'],$value['date_created'],$value['date_created']);

                          $ExpencesAmount= getExpencesAmount($admin_session['business_id'],$admin_session['location_id'],$value['date_created'],$value['date_created']);
											}
									    if ($RefundAmount>0) {
											$RefundAmount=$RefundAmount;
                                        }else{
											$RefundAmount=0;
										}  
                    //echo $value['total_service_discount_price'];
                   // echo $value['date_created'].' '. $RefundAmount.'<br>';
										$tax_percent = getBusinessTax($admin_session['business_id']);
										$tax_type = getBusinessTaxType($admin_session['business_id']); 
                    $total_service_total_price=$value['total_service_total_price']-$value['total_voucher_applied'];
										$all_total+=$total_service_total_price;
										$all_qty+=$value['total_service_qty'];
										$total_discount = $value['total_service_discount_price']+ $value['total_voucher_applied'];
									$all_discount+=$total_discount;
									$final_total=$total_service_total_price-$total_discount-$ExpencesAmount-$RefundAmount;
										$total_tax = getServiceTax($final_total,$tax_percent,$tax_type);
										$netamount= $final_total- $total_tax;
										$all_net+= $netamount;
										$all_tax+= $total_tax;
										$all_final_total+= $final_total;
                    $all_ExpencesAmount+=$ExpencesAmount;
                    $all_refund+=$RefundAmount;
                                     ?>
                                    <tr>                                        
                                        <td><span class='hide'><?= date("Y-m-d", strtotime($value['date_created'])) ; ?></span><?= date("D, d  M  Y", strtotime($value['date_created'])) ; ?>
                                        </td>
                                        <td><?=$value['total_service_qty']?></td>
                                        <td><?=number_format($total_service_total_price,2)?></td>
                                        <td>-<?=number_format($total_discount,2)?></td>
                                         <td>-<?=number_format($RefundAmount,2)?></td>
                                        <td>-<?=number_format($ExpencesAmount,2)?></td>
										                    <td><?=number_format($final_total,2)?></td>
                                          <td><?=round($total_tax,2)?></td>
                                         <td><?=number_format($netamount,2)?></td>
                                       </tr>                                  
                                    <?php endforeach; ?>   
                                </tbody>

                                <tfoot>
                                  <tr>
                                      <th><b>Total </b></th>
                                      <th><b><?php echo $all_qty ?>  </b></th>
                                       <th><b><?php echo number_format($all_total,2); ?> </b></th>
                                       <th><b>-<?php echo number_format($all_discount,2); ?> </b></th>
                                        <th><b>-<?php echo number_format($all_refund,2); ?> </b></th>

                                        <th><b>-<?php echo number_format($all_ExpencesAmount,2); ?> </b></th>

                                        <th><b><?php echo number_format($all_final_total,2); ?> </b></th>
									                 <th><b><?php echo number_format($all_tax,2); ?> </b></th>
                                      <th><b><?php echo number_format($all_net,2); ?> </b></th>
                                       
                                       
                                        
                                      
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
    float: right;
}
        </style>
  
  <?php $this->load->view('admin/common/footer'); ?>




<script>
$(document).ready(function(){
  // select report
  select_report
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



