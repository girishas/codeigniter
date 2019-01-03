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
                  
                   <!--  <select data-placeholder="All Location" class="form-control form-control-sm" data-plugin="select2" name="location_id" id="location_id">
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
                        <th class="dark-background-heading">STAFF</th>
                        <th class="dark-background-heading">ser (%)</th>
                        <th class="dark-background-heading">trgt</th>
                         <th class="dark-background-heading">sale</th>

                         <th class="dark-background-heading">comm. amt</th> 

                        <th class="dark-background-heading">Product (%)  </th>
                        <th class="dark-background-heading">trgt </th>
                        <th class="dark-background-heading">sale</th>
                        <th class="dark-background-heading">comm. amt</th>

                        <th class="dark-background-heading">Vouchar (%) </th>
                        <th class="dark-background-heading">trgt</th>
                        <th class="dark-background-heading">sale</th>
                        <th class="dark-background-heading">comm. amt</th>
                        <th class="dark-background-heading">Total</th>
                      </tr>
                    </thead>
                    <tbody>        
                                    <?php 
                                     $all_service_commission='0';
                                     $all_target_service_value='0';
                                     $all_product_commission='0';
                                     $all_target_product_value='0';
                                     $all_vouchar_commission='0';
                                     $all_target_voucher_value='0';
                                     $all_serviceprice='0';
                                     $all_serviceCommAmt='0';

                                     $all_voucharprice='0';
                                     $all_voucharCommAmt='0';

                                      $all_productprice='0';
                                     $all_productCommAmt='0';
                                     $all_total='0';



                                    foreach ($get_staff as $key => $value):

                                      $all_service_commission+=$value['service_commission'];
                                     $all_target_service_value+=$value['target_service_value'];
                                     $all_product_commission+=$value['product_commission'];
                                     $all_target_product_value+=$value['target_product_value'];
                                     $all_vouchar_commission+= $value['vouchar_commission'];
                                     $all_target_voucher_value+=$value['target_voucher_value'];
                                      ?>
                                    <tr>
                                      <td><?php echo $value['first_name'].' '.$value['last_name'] ?></td>
                                        
                                        <td><?php echo $value['service_commission'] ?></td>
                                         <td><?php echo $value['target_service_value'] ?></td>
                                         <td>  <?php  $serviceprice= getStaffServiceSalePrice($value['id']);
                                          $all_serviceprice+=$serviceprice;
                                         echo number_format($serviceprice,2); 
                                         ?></td>

                                          <td>
                                           <?php
                                            $totalserviceprice=$value['service_commission']/100*$serviceprice;
                                            $serviceCommAmt= $value['target_service_value']>$serviceprice?0:$totalserviceprice;
                                             $all_serviceCommAmt+=$serviceCommAmt;
                                            echo number_format($serviceCommAmt,2);

                                            ?>
                                            
                                          </td>

                                          <td><?php echo $value['product_commission'] ?></td>
                                         <td><?php echo $value['target_product_value'] ?></td>
                                          <td>  <?php $productprice = getStaffProductSalePrice($value['id']);
                                          $all_productprice +=$productprice;
                                          echo number_format($productprice,2);
                                           ?></td>
                                         <td>

                                           <?php
                                            $totalproductprice=$value['product_commission']/100*$productprice;
                                    $productCommAmt= $value['target_product_value']>$productprice?0:$totalproductprice;
                                    $all_productCommAmt+=$productCommAmt;
                                            echo number_format($productCommAmt,2);


                                            ?>
                                           
                                         </td>
                                         <td><?php echo $value['vouchar_commission'] ?></td>
                                         <td><?php echo $value['target_voucher_value'] ?></td>
                                          <td>
                                            <?php $voucharprice= getStaffVoucharSalePrice($value['id']);
                                              $all_voucharprice+=$voucharprice;
                                             echo number_format($voucharprice,2);
                                             ?>
                                            
                                          </td>
                                          <td>
                                             <?php
                                            $totalvoucharprice=$value['vouchar_commission']/100*$voucharprice;
                                            $voucharCommAmt = $value['target_voucher_value']>$voucharprice?0:$totalproductprice;
                                            $all_voucharCommAmt+= $voucharCommAmt;
                                            echo  number_format($voucharCommAmt,2);

                                            ?>
                                            
                                          </td>
                                          <td>
                                            <?php $total= $serviceCommAmt+$productCommAmt+$voucharCommAmt;
                                            $all_total+=$total;
                                          echo   number_format($total,2);
                                             ?>
                                            
                                          </td>

                                          
                                  
                                    </tr>
                                  
                                    <?php endforeach; ?>   
                                </tbody>

                                <tfoot>
                                  <tr>
                                      <th><b>Total </b></th>
                                      <th><b><?=number_format($all_service_commission,2); ?> </b></th>
                                      <th><b><?=number_format($all_target_service_value,2); ?> </b></th>
                                      <th><b><?=number_format($all_serviceprice,2); ?> </b></th>
                                      <th><b><?=number_format($all_serviceCommAmt,2); ?> </b></th>

                                      <th><b><?=number_format( $all_product_commission,2); ?> </b></th>
                                       <th><b><?=number_format( $all_target_product_value,2); ?> </b></th>
                                        <th><b><?=number_format( $all_productprice ,2); ?> </b></th>
                                       <th><b><?=number_format( $all_productCommAmt,2); ?> </b></th>


                                        <th><b><?=number_format( $all_vouchar_commission,2); ?> </b></th>
                                        <th><b><?=number_format( $all_target_voucher_value,2); ?> </b></th>

                                        <th><b><?=number_format( $all_voucharprice,2); ?> </b></th>
                                        <th><b><?=number_format( $all_voucharCommAmt,2); ?> </b></th>
                                        <th><b><?=number_format( $all_total,2); ?> </b></th>
                                      
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



