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
            <ul class="nav nav-tabs" role="tablist">
              
              <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab" >Product</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/reports_customer');?>" >Customer</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/reports_appointment');?>" >Appointment </a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/reports_voucher');?>" >Voucher </a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/reports/reports_invoice');?>" >Invoice </a></li>
            </ul>
            
          </div>
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
            
            <?php ////// if(isset($all_records)){?>
            
            <!-- Actions -->
            <!-- <div class="page-content-actions">
              <div class="btn-group btn-group-flat" style="margin-left:5px;">
                <button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
              </div>
              <div class="btn-group btn-group-flat" style="margin-left:5px;">
                  <a  href="<?php echo base_url('admin/customer/export_to_csv');?>">
                  <button type="button" class="btn btn-success waves-effect waves-classic">
                  <i class="icon md-upload text" aria-hidden="true"></i><span class="text">Export to CSV</span></button></a>
              </div>

            </div> -->
            <form autocomplete="false" method="post" action="">
              <div class="row mb-10" style="margin-left:5px;">
                  
                  <?php 
                   $last = $this->uri->total_segments();
                  $r_select = $this->uri->segment($last);
                  ?>

                  <div class="col-sm-3">
                    <label class="form-control-label" for="inputGrid2">Choose a report</label>
                    <select  data-placeholder="Select Report" class="form-control form-control-sm" data-plugin="select2" name="select_report" id="select_report">
                      <option value="">Select Report</option>
                      <option value="admin/reports" <?php if(!empty($r_select)){ if($r_select == 'reports') { echo "selected"; }} ?> >Product Sales</option>
                      <option value="admin/reports/product_alert" <?php if(!empty($r_select)){ if($r_select == 'product_alert') { echo "selected"; }} ?> >Product Alert</option>
                    </select>
                  </div>

                  <div class="col-sm-1">

                  </div>

                  <?php $admin_session = $this->session->userdata('admin_logged_in'); 
                  if($admin_session['role']=="owner") { ?>

                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Business</label>
                    <select data-placeholder="Select Business" class="form-control form-control-sm" data-plugin="select2" name="business_id" id="business_id">
                      <option value="">Select Business</option>
                      <?php if($all_business){?>
                      <?php foreach($all_business as $row){?>
                      <!-- <?php if(isset($business_id)){ if($business_id==$row['id']) { echo "selected"; }  }?> -->
                       <option value="<?php echo $row['id'];?>" ><?php echo $row['name'];?></option>
                       <?php } } ?>
                    </select>
                  </div>

                  <?php } ?>

                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Location</label>
                    <!-- <select class="form-control form-control-sm" name="location_id" id="location_id">
                      <option value="">Select Location</option>
                      <?php if($all_location){?>
                      <?php foreach($all_location as $row){?>
                       <option value="<?php echo $row['id'];?>" <?php if(isset($location_id)){ if($location_id==$row['id']) { echo "selected"; }  }?>><?php echo $row['location_name'];?></option>
                       <?php } } ?>
                    </select> -->
                    <select data-placeholder="Select Location" class="form-control form-control-sm" data-plugin="select2" name="location_id" id="location_id">
                      <option value="">Select Location</option>
                    </select>
                  </div>

                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Product Name / SKU</label>
                    <!-- <div class="row"> -->
                      <input type="text" placeholder="Product Name / SKU" class="form-control form-control-sm"  name="sku" id="sku">
                      
                    <!-- </div> -->
                  </div>

                  <div class="col-sm-2">
                    <div class="mt-25">
                      <!-- <button class="btn btn-primary submit" name="search_filter" value="search_filter" type="submit" id="viewReportBtn" style="height: 32px !important; ">
                        <i class="fa fa-search-plus"></i></button> -->
                      <button class="btn btn-primary " name="search_filter" value="search_filter" type="submit" id="viewReportBtn">Search</button>
                    </div> 

                  </div>

              </div>
            </form>

                <input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
                <input type="hidden" name="search_width" id="search_width" value="232px">
                
                <!-- Contacts -->
                <form id="frm_customer" name="frm_customer" action="" method="post">
                  <table id="example" class="table  table-hover  table-striped w-full" data-plugin="">
                    <thead>
                      <tr>
                        <!-- <th class="dark-background-heading" >
                          <span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
                            <input type="checkbox" class="contacts-checkbox" id="select_all" />
                            <label for="select_all"></label>
                          </span>
                        </th> -->
                        <th class="dark-background-heading">PRODUCT NAME</th>
                        <th class="dark-background-heading">SKU / HANDLE</th>
                        <th class="dark-background-heading">LOCATION NAME</th>
                        <th class="dark-background-heading">STOCK AVAILABLE</th>
                        <th class="dark-background-heading">ALERT POINT</th>
                        <!-- <th class="dark-background-heading">TAX AMMOUNT</th> -->
                        <th class="dark-background-heading">COST PRICE</th>
                        <th class="dark-background-heading">RETAIL PRICE</th>
                        <!-- <th class="dark-background-heading">TOTAL COST VALUE</th> -->
                        <!-- <th class="dark-background-heading">TOTAL RETAIL VALUE</th> -->
                        <!-- <th class="dark-background-heading">Added Date</th>
                        <th class="dark-background-heading">Actions</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($all_records)){?>
                      <?php $counter = 1;foreach($all_records as $row){?>

                      <?php $old_total = $row['totalstcokqty'];
                      $new_total = getProductTotalStockById($row['pid'],$row['pl_locid']); 
                      $final_total = $old_total-$new_total;
                      if($final_total <= 0 || $final_total == ''){
                        $final_total = 0;
                      }else{
                        $final_total = $old_total-$new_total;
                      }
                      //echo "total - ".$final_total;
                      if($final_total <= $row['p_alrtqty'])  { ?>

                      <tr id="row_<?php echo $row['pid']; ?>">
                        
                        <!-- <td>
                          <span class="checkbox-custom checkbox-primary checkbox-lg">
                          <input type="checkbox" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $row['pid'];?>"/>
                          <label for="contacts_1"></label>
                          </span>
                        </td> -->
                        
                        <td><?php echo $row['pname'];?></td>
                        <td><?php echo $row['psku'];?></td>
                        <td>
                          <?php if(getLocationNameById($row['pl_locid']) == '') { ?>
                            <span class="badge badge-warning" id="active_inactive">NO LOCATION</span>
                          <?php } else {  echo getLocationNameById($row['pl_locid']); } ?>
                        </td>
                        <td>
                          
                          <?php $old_total = $row['totalstcokqty'];
                                $new_total = getProductTotalStockById($row['pid'],$row['pl_locid']); 
                                $final_total = $old_total-$new_total;
                                if($final_total <= 0 || $final_total == ''){
                                  $final_total = 0;
                                }else{
                                  $final_total = $old_total-$new_total;
                                }
                          ?>
                          <!-- <?php if($final_total == ''){ ?>
                              <span class="badge badge-danger" id="active_inactive">0</span>
                          <?php } else if($final_total <= $row['p_alrtqty']) {?> 
                          <span class="badge badge-danger" id="active_inactive">
                            <?php echo $final_total;?></span>
                          <?php  } else { echo $final_total; }?>  -->

                          <?php if($final_total <= 0 || $final_total == '' ){ ?>
                              <span class="badge badge-danger" id="active_inactive">0</span>
                          <?php } else if($final_total <= $row['p_alrtqty']) {?> 
                          <span class="badge badge-danger" id="active_inactive">
                            <?php echo $final_total;?></span>
                          <?php  } else { echo $final_total; }?>
                          

                        </td> 
                        <td><?php echo $row['p_alrtqty'];?></td> 
                        <!-- <td><?php echo getTaxToatlById($row['pid']);?></td> -->
                        <td><?php echo $row['p_pprice'];?></td>
                        <td><?php echo getTaxToatlById($row['pid']) + $row['p_rprice'];?></td>

                      </tr>


                      <?php $counter++;} } }?>

                    </tbody>
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
        <script language="javascript">
        var $jq = jQuery.noConflict();
        $jq(document).ready(function(){
          if($jq('#customer_search').length)
          {
            $jq("#customer_search").suggestion({
              url:base_url + "admin/Operations/suggestion_list?chars=",
              minChars:2,
              width:200,
            });
          }
            
        });
        
        function delete_selected(){
          swal({
          title: "Are you sure?",
          text: "You will not be able to recover this Invocies!",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-info",
          confirmButtonText: 'Yes, delete it!',
          closeOnConfirm: false
          //closeOnCancel: false
          }, function () {
            document.frm_customer.submit();
          });
        }
        </script>
        
        <style type="text/css">
        .dataTables_wrapper .row{
          margin-left:0 !important;
          margin-right:0 !important;
        }
        .page-content-actions {
        padding: 0 10px 10px;
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
  $('#example').dataTable( {
    order: [],
    //columnDefs: [ { orderable: false, targets: [0,-1] } ]
  });
});
</script>



