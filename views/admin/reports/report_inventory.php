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
            <?php ////// if(isset($all_records)){?>            
            <!-- Actions -->          
            <form autocomplete="false" method="post" action="">
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
                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">BarCode</label>
                    <!-- <div class="row"> -->
                      <input type="text" placeholder="Product Name/BarCode" class="form-control form-control-sm"  name="sku" id="sku" value="<?php echo isset($bar_code)?$bar_code:''; ?>">
                      
                    <!-- </div> -->
                  </div>

                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Brand</label>
                    
                     <select name="brand_id" id="brand_id" class="form-control form-control-sm" >
                      <option value="">All Brand</option>
                      <?php
                      foreach ($brand as $key => $value) {?>
                      <?php $brand_id=isset($brand_id)?$brand_id:0;?>
                      <option value="<?php echo  $value['id'] ?>"<?php if ($brand_id ==$value['id']) {echo 'selected'; } ?>  ><?php echo $value['brand_name'] ?></option>                       
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Brand Sub Category</label>                    
                     <select name="brand_sub_category_id" id="brand_sub_category_id" class="form-control form-control-sm" >  
                       <option value="">All Brand Sub Category</option>
                       <?php
                      foreach ($brand_sub_category as $key => $value) {?>
                      <?php $brand_sub_category_id=isset($brand_sub_category_id)?$brand_sub_category_id:0;?>
                      <option value="<?php echo  $value['id'] ?>"<?php if ($brand_sub_category_id ==$value['id']) {echo 'selected'; } ?>  ><?php echo $value['brand_name'] ?></option>                       
                      <?php } ?>

                    </select>
                  </div>


                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Product Category</label>
                    
                     <select name="product_category_id" id="product_category_id" class="form-control form-control-sm" >
                       <option value="">All Product Category</option>
                      <?php
                      foreach ($category as $key => $value) {?>
                      <?php $category_id=isset($category_id)?$category_id:0;?>
                      <option value="<?php echo  $value['id'] ?>"<?php if ($category_id ==$value['id']) {echo 'selected'; } ?>  ><?php echo $value['category_name'] ?></option>                       
                      <?php } ?>
                    </select>
                  </div>

               <div class="col-md-2">
                    <label class="form-control-label" for="inputGrid2">Alert Quantity</label>
                    <?php
                    if (isset($is_product_alert)) {
                      $checked="checked";
                    }
                    else{
                       $checked="";
                    }
                     ?>
                    
                    <div class="checkbox-custom checkbox-info" style="padding-left:46px;">
                          <input type="checkbox"  id="is_product_alert" name="is_product_alert" autocomplete="off" <?=$checked?> >
                          <label for="is_product_alert"></label>
                        </div>
                   
                  </div> 



                 <!--  <div class="col-md-2">
                    <label class="form-control-label" for="inputGrid2">From Date</label>
                    <input type="text" class="form-control empty" data-date-today-highlight="true" data-plugin="datepicker" id="from_date" data-date-format="dd-mm-yyyy" autocomplete="off" name="from_date" value="<?php echo isset($from_date)?$from_date:''  ?>">
                  </div> -->


                <!--   <div class="col-md-2">
                    <label class="form-control-label" for="inputGrid2">To Date</label>
                    <input type="text" class="form-control empty" data-date-today-highlight="true" data-plugin="datepicker" data-date-format="dd-mm-yyyy" autocomplete="off" id="to_date" name="to_date" value="<?php echo isset($to_date)?$to_date:''  ?>">
                  </div> -->

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
                   <div class ="table-responsive "> 
                <form id="frm_customer" name="frm_customer" action="" method="post">
                  <table id="example" class="table  table-hover  table-striped w-full" data-plugin="">
                    <thead>
                      <tr>
                       <th class="dark-background-heading">LOCATION </th>
                        <th class="dark-background-heading">PRODUCT</th>
                        <th class="dark-background-heading">BarCode</th>
                        <th class="dark-background-heading">Brand</th>
                        <th class="dark-background-heading">Sub Brand </th>
                        <th class="dark-background-heading">Category</th>

                        <th class="dark-background-heading">STOCK AVAILABLE</th>
                         <th class="dark-background-heading">Alert Quantity</th>
                        
                        <th class="dark-background-heading">COST PRICE</th>
                        <th class="dark-background-heading">RETAIL PRICE</th>
                      
                      </tr>
                    </thead>
                <tbody>
                      <?php if(isset($all_records)){?>
                      <?php $counter = 1;foreach($all_records as $row){?>
                      <?php
                     $avl_qty= getProductStockQtyForLocation($row['pl_locid'],$row['pid']);         

                      if($avl_qty <= $row['p_alrtqty'] && isset($is_product_alert))  { ?>

                      <tr id="row_<?php echo $row['pid']; ?>">
                      <td>
                          <?php if(getLocationNameById($row['pl_locid']) == '') { ?>
                            <span class="badge badge-warning" id="active_inactive">NO LOCATION</span>
                          <?php } else {  echo getLocationNameById($row['pl_locid']); } ?>
                        </td> 
                        <td>
                          <a href="<?php echo base_url('admin/product/view/'.$row['id']);?>"><?php echo $row['pname'] ?></a>
                                                   
                          </td>
                        <td><?php echo $row['bar_code'];?></td>
                         <td><?=getBrandCategory($row['brand_category_id']) ?>  </td>
                        <td><?=getBrandCategory($row['brand_id']) ?> </td>
                       
                        <td> <?=getProductCategory($row['category_id'])?> </td>

                        <td> <?=getProductStockQtyForLocation($row['pl_locid'],$row['pid']);?> </td>                   

                         <td><?php echo $row['p_alrtqty'];?></td>
                        <td><?php echo $row['p_pprice'];?></td>
                        <td><?php echo getTaxToatlById($row['pid']) + $row['p_rprice'];?></td>
                        </tr>
                        <?php $counter++;}


                        elseif(!isset($is_product_alert)){

                          ?>
                           <tr id="row_<?php echo $row['pid']; ?>">
                      <td>
                          <?php if(getLocationNameById($row['pl_locid']) == '') { ?>
                            <span class="badge badge-warning" id="active_inactive">NO LOCATION</span>
                          <?php } else {  echo getLocationNameById($row['pl_locid']); } ?>
                        </td> 
                        <td><?php echo $row['pname'];?></td>
                        <td><?php echo $row['bar_code'];?></td>
                         <td><?=getBrandCategory($row['brand_category_id']) ?>  </td>
                        <td><?=getBrandCategory($row['brand_id']) ?> </td>
                       
                        <td> <?=getProductCategory($row['category_id'])?> </td>

                        <td> <?=getProductStockQtyForLocation($row['pl_locid'],$row['pid']);?> </td>                     

                         <td><?php echo $row['p_alrtqty'];?></td>
                        <td><?php echo $row['p_pprice'];?></td>
                        <td><?php echo getTaxToatlById($row['pid']) + $row['p_rprice'];?></td>
                        </tr>

                       <?php
                       $counter++;
                        }

                      }}?>

                      </tbody>
                    </table>
                  </form>
                </div>
                  
                  <!--<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
                </div>
               </div>
            </div>
          </div>
        </div>
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

.app-contacts table > thead > tr > th, .app-contacts table > tbody > tr > th, .app-contacts table > thead > tr > td, .app-contacts table > tbody > tr > td {
  white-space: unset !important;
  }
        </style>
  
  <?php $this->load->view('admin/common/footer'); ?>




<script>
$(document).ready(function(){
  
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
 <script type="text/javascript"> 
    $(document).ready(function() {    
    $('#brand_id').change(function() {  
            var brand_id = $("#brand_id").val();          
            $.ajax({
                url: site_url + 'admin/reports/getBrandbyBrandCategary',
                type: 'POST',
                data:{brand_id:brand_id},
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(data) {
                   if (data.status=='success') { 
                     $('#brand_sub_category_id').html(data.brand_sub_category);
                   }

                }
            });
    });
});
</script>

<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>

<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>






