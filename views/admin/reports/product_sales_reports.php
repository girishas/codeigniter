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
                    <?php $alllocaton_data = getAllLocationData(); ?>
                 
                   
                    
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
                   <label class="form-control-label" for="inputGrid2"> Date</label>
                      <input type="text" class="form-control" name="sale_date" id="sale_date" data-plugin="datepicker" data-date-today-highlight="true" autocomplete="off" data-date-format="dd-mm-yyyy"  value="<?php echo isset($sale_date)?$sale_date:date('d-m-Y')?>">
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
                        <th class="dark-background-heading">ITEM TYPE </th>
                        <th class="dark-background-heading">SALE QTY</th>
                       <!--  <th class="dark-background-heading">REFUND QTY </th>  -->
                        <th class="dark-background-heading">TOTAl</th>
                      </tr>
                    </thead>
                    <tbody>        <?php  $all_total= 0;
                                      $all_qty=0;
                                      $dis_qty=0;
                                      $dis_total=0;

                                       ?>
                                    <?php foreach ($invoice_services as $key => $value):
                                      //gs($value);
                                        if($value['pay_service_type'] !=8 && $value['pay_service_type'] !=7){
                                     ?>
                                     <?php 
                                    $all_total+=$value['total_service_total_price'];
                                     $all_qty+=$value['total_service_qty'];
                                     ?>
                                    <tr>
                                        
                                        <td><?= payServiceType($value['pay_service_type']); ?>
                                        </td>
                                        <td><?=$value['total_service_qty']?></td>
                                        <td><?=number_format($value['total_service_total_price'],2)?></td>

                                  
                                    </tr>
                                    <?php }

                                     else if ($value['pay_service_type'] ==7 ||$value['pay_service_type'] ==8){
                                           $dis_total+=$value['total_service_total_price'];
                                            $dis_qty+=$value['total_service_qty'];

                                    } ?>

                                    <?php endforeach; ?>   
                                </tbody>

                                <tfoot>
                                  <tr>
                                      <th class="center"><b >Discount </b></th>
                                      <th><b>  </b></th>
                                       <th><b>- <?php echo number_format($dis_total,2); ?> </b></th>
                                    </tr>
                                    <tr>
                                      <th class="center"><b >Total </b></th>
                                      <th><b><?php echo $all_qty ?>  </b></th>
                                       <th><b><?php echo number_format($all_total-$dis_total,2); ?> </b></th>
                                        
                                      
                                    </tr> 
                                </tfoot>
                    </table>
                </form>
                  
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
        div.dataTables_wrapper div.dataTables_info {
    padding: .85em !important;

    }
    .datepicker{z-index: 999999 !important};
    
    .page-header+.page-content {    
    overflow-x: hidden !important;
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
      paging: false,
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



