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
            <h1 class="panel-title"> Gst Ato Manager</h1>
           
          </div>
           <?php $admin_session = $this->session->userdata('admin_logged_in'); ?>
          <div id="contactsContent" class="page-content" data-plugin="selectable">
            
             <form autocomplete="false" method="post" action="">
              <div class="row mb-10" style="margin-left:5px;">
                
                   <div class="col-sm-2">
                   <label class="form-control-label" for="inputGrid2">Year</label>
                    <select name="year" id="year" class="form-control form-control-sm" >
                      <?php foreach ($gst_year as $key => $value) { ?>
                       <?php $year=isset($year)?$year:'';?>
                       <option <?php if ($year ==$value['year']) {echo 'selected'; } ?> value="<?=$value['year']?>"><?=$value['year']?></option>
                     <?php } ?>
                                       
                    </select>                    
                  </div>

                    <div class="col-sm-2">                       
                   <label class="form-control-label" for="inputGrid2">Month</label>
                    <select name="month" id="month" class="form-control form-control-sm" >
                     <?php $month=isset($month)?$month:''; ?>

                    <option <?php if ($month == '01') {echo 'selected'; } ?> value="01">January</option>
                    <option <?php if ($month == '02') {echo 'selected'; } ?> value="02">February</option>
                    <option <?php if ($month == '03') {echo 'selected'; } ?> value="03">March</option>
                    <option <?php if ($month == '04') {echo 'selected'; } ?> value="04">April</option>
                    <option <?php if ($month == '05') {echo 'selected'; } ?> value="05">May</option>
                    <option <?php if ($month == '06') {echo 'selected'; } ?> value="06">June</option>
                    <option <?php if ($month == '07') {echo 'selected'; } ?> value="07">July</option>
                    <option <?php if ($month == '08') {echo 'selected'; } ?> value="08">August</option>
                    <option <?php if ($month == '09') {echo 'selected'; } ?> value="09">September</option>
                    <option <?php if ($month == '10') {echo 'selected'; } ?> value="10">October</option>
                    <option <?php if ($month =='11') {echo 'selected'; } ?> value="11">November</option>
                    <option <?php if ($month =='12') {echo 'selected'; } ?> value="12">December</option>    
            </select>
            </div>
                      

                     <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner" ){?> 
                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Location</label>
                     <?php $alllocaton_data= getAllLocationData(); ?>
                     <select name="location_id" id="location_id" class="form-control form-control-sm" >
                    <option value="">Select Location</option> 
                      <?php
                      foreach ($alllocaton_data as $key => $value) {?>
                      <?php $location_id=isset($location_id)?$location_id:'';?>

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
                <form id="frm_customer" name="frm_customer" action="<?php echo base_url('admin/reports/gst_ato_management');?>" method="post">
                   <table id="example" class="table table-hover  table-striped w-full" data-plugin="">
                    <thead>
                      <tr>
                        <th class="dark-background-heading">Year </th>
                        <th class="dark-background-heading">Month </th>
                        <th class="dark-background-heading">Cash</th>
                        <th class="dark-background-heading">Cards</th>                     
                        <th class="dark-background-heading">Gift Voucher </th>
                        <th class="dark-background-heading">Others </th>                       
                        <th class="dark-background-heading">TOTAL  </th>
                        <th class="dark-background-heading">  </th>
                      </tr>
                    </thead>
                    <tbody>        
                   <?php if (isset($month_payments)) { ?>
                    <tr>
                        <?php
                      $gst_cash= isset($gst_settings['cash'])?$gst_settings['cash']:100;
                      $gst_cards= isset($gst_settings['cards'])?$gst_settings['cards']:100;
                      $gst_voucher= isset($gst_settings['gift_voucher'])?$gst_settings['gift_voucher']:100; 
                       $gst_others= isset($gst_settings['others'])?$gst_settings['others']:100; 

                       $totalcash= $gst_cash/100*$month_payments['Cash'];
                       $totalcard=  $gst_cards/100*$month_payments['Card'];
                       $totalvoucher= $gst_voucher/100*$month_payments['Voucher'];
                        $totalothers= $gst_others/100*$month_payments['Other'];
                        $alltotal=$totalcash+ $totalcard+$totalvoucher+$totalvoucher;
                        
                        ?>


                        <td><?php echo $month_payments['YEAR'] ?>
                           <input type="hidden" name="location_id" id="location_id" value="<?=$month_payments['location_id']?>">
                            <input type="hidden" name="business_id" id="business_id" value="<?=$month_payments['business_id']?>">
                       <input type="hidden" name="year" id="year" value="<?=$month_payments['YEAR']?>">
                          
                        </td>
                        <td><?php echo $month_payments['MONTH'] ?>
                          <input type="hidden" name="month" id="month" value="<?=$month_payments['MONTH']?>">
                          
                        </td>
                        <td><?php echo  round($totalcash,2) ?>
                          <input type="hidden" name="cash" id="cash" value="<?=round($totalcash,2)?>">
                          
                        </td>

                        <td><?php echo  round($totalcard,2) ?>
                          <input type="hidden" name="card" id="card" value="<?=round($totalcard,2)?>">
                          
                        </td>

                         


                        <td><?php echo  round($totalvoucher,2) ?>
                           <input type="hidden" name="voucher" id="voucher" value="<?=round($totalvoucher,2)?>">
                          
                        </td>
                        <td><?php echo  round($totalothers,2) ?>
                           <input type="hidden" name="others" id="others" value="<?=round($totalothers,2)?>">
                          
                        </td>
                        <td><?php echo round($alltotal,2) ?>
                           <input type="hidden" name="total" id="total" value="<?=round($alltotal,2)?>">

                         </td>
                         <td>
                            <button class="btn btn-primary " name="action" value="action" type="submit" id="viewReportBtn">Lock</button>
                         </td>                        
                       
                    </tr>     
                  <?php  } ?>
                                                      
                    
                </tbody>
                    </table>
                </form>
                  </div>
                            </br>
                            </br>
                            <hr/>
                   
                          <table id="Manager" class="table  table-hover  table-striped w-full" data-plugin="">
                            <thead>
                              <th class="dark-background-heading">Locked On </th>
                               <th class="dark-background-heading">Year</th>
                               <th class="dark-background-heading">Month</th>
                               <th class="dark-background-heading">Cash</th>
                               <th class="dark-background-heading">Card</th>
                               <th class="dark-background-heading">Voucher</th>
                               <th class="dark-background-heading">Others</th>
                               <th class="dark-background-heading">Total</th>
                               <th class="dark-background-heading">pdf </th>
                               <th class="dark-background-heading"> </th>
                            </thead>
                            <tbody>
                              <?php
                              foreach ($gst_management as $key => $value) { ?>
                              <tr>
                                <td><?=date("d M Y", strtotime($value['created_date']) )?></td>
                              <td><?=$value['year'];?></td>
                              <td><?= date("F", mktime(0, 0, 0, $value['month'], 10)); ?></td>
                              <td><?=$value['cash'];?></td>
                              <td><?=$value['card'];?></td>
                              <td><?=$value['gift_voucher'];?></td>
                              <td><?=$value['others'];?></td>
                              <td><?=$value['total'];?></td>
                              <td>  <a href="<?=(base_url($value['pdf_id']))?>" target="_blank" class="btn btn-primary waves-effect waves-classic" title="Sample File" download>Click here to download</a> </td>
                              <td><button type="button" data-target="#exampleNiftyFadeScale_<?=$value['id']?>" data-toggle="modal" class="btn btn-info">Send To Email</button></td>

                          <div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale_<?=$value['id']?>" aria-hidden="true"aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
                        <div class="modal-dialog modal-simple">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                              <h4 class="modal-title">Email address whom to send report:</h4>
                            </div>
                            <form method="post" action="<?php echo base_url('admin/reports/send_ato_mail_management');?>">
                              <div class="modal-body"> 
                                <div class="form-group row">
                                  <div class="col-md-3 text-right" style="padding-top: 7px;"><b> Email*</b></div>
                                  <div class="col-md-9">
                                  <input type="email" required="required" class="form-control" name="email">
                                   <input type="hidden"  class="form-control" name="management_id" value="<?=$value['id']?>">
                                </div>


                                </div>                                
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button>
                                <button type="submit" id="save_changes" class="btn btn-primary">Save changes</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                            </tr>
                              
                              

                               
                             <?php } ?>
                            
                          </tbody>
                          </table>
                  

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
      "bInfo": false,
      'iDisplayLength': -1,

    //  dom: 'Bfrtip',
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

<!-- <script type="text/javascript">
$(document).ready( function() {
  $('#Manager').dataTable({
     "searching": true,
      "paging": true,
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
</script> -->

<script type="text/javascript">
$(document).ready( function() {
  $('#Manager').dataTable( {
    order: [[ 1, "asc" ]],
    columnDefs: [ { orderable: false, targets: [0,-1] } ]
  });
});
</script>



<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>

<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>




