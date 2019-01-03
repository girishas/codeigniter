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
            <h1 class="panel-title">All Invoices</h1>
            <div class="page-header-actions">
              <a href="<?php echo base_url('admin/invoice/create');?>"><button type="button" class="btn btn-block btn-primary">Add Invoice</button></a>
            </div>
          </div>
          <!-- Contacts Content -->


          <!-- filter -->
          <form autocomplete="false" method="post" action="<?php echo base_url('admin/invoice/index'); ?>">
            
            <div class="row mb-10" style="margin-left:5px;">
              <div class="col-sm-2">
                <label class="form-control-label" for="inputGrid2">Invoice Number</label>
                <input type="text" placeholder="Invoice Number" class="form-control form-control-sm"  name="f_invoice_number" id="f_invoice_number" value="<?php echo(isset($f_invoice_number)?$f_invoice_number: null) ?>">
              </div> 
              <!-- <div class="col-sm-2">
                <label class="form-control-label" for="inputGrid2">Invoice Number</label>
                <input type="text" placeholder="Customer Name" class="form-control form-control-sm"  name="f_customer_name" id="f_customer_name">
              </div>  -->
              <!-- <div class="col-sm-2">
                <label class="form-control-label" for="inputGrid2">Invoice Date</label>
                <input type="text" placeholder="2018-11-02" class="form-control form-control-sm"  name="f_invoice_date" id="f_invoice_date">
              </div>  -->
              <div class="col-sm-2">
                   <label class="form-control-label" for="inputGrid2"> Date</label>
                      <input type="text" class="form-control" name="f_invoice_date" id="f_invoice_date" data-plugin="datepicker" data-date-today-highlight="true" autocomplete="off" data-date-format="yyyy-mm-dd" value="<?php echo isset($f_invoice_date)?$f_invoice_date:'' ?>">
                  </div>

              <?php $admin_session = $this->session->userdata('admin_logged_in'); 
              if($admin_session['role']=="owner" || $admin_session['role']=="business_owner") { ?>

              <div class="col-sm-2">
                <label class="form-control-label" for="inputGrid2">Location</label>
                <select data-placeholder="Select Location" class="form-control form-control-sm" data-plugin="select2" name="f_location" id="f_location">
                  <option value="">Select Location</option>
                  <?php if($all_location){?>
                  <?php foreach($all_location as $row){ ?>

       
				   <option <?php if($f_location==$row['id']){echo "selected";}?> value="<?php echo $row['id'];?>" ><?php echo $row['location_name'];?></option>
                   <?php } } ?>
                </select>
              </div>

              <?php } ?>

              <div class="col-sm-2">
                <div class="mt-25">
                  <button class="btn btn-primary " name="search_filter" value="search_filter" type="submit" id="viewReportBtn">Search</button>
                </div> 
              </div>

              <div class="col-sm-2">
                <div class="mt-25">
                  <button class="btn btn-primary " name="show_all" value="show_all" type="submit" id="viewReportBtn">Show All</button>
                </div> 
              </div>
            </div>

          
          <!-- filter -->
         

          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
            
            <!-- Actions -->
            <table id="example" class="table table-hover  table-striped w-full" data-plugin="">
              <thead>
                <tr>
                  <th class="dark-background-heading">Invoice Number</th>
                  <th class="dark-background-heading">Customer Name</th>
                  <th class="dark-background-heading">Location</th>
                  <th class="dark-background-heading">Status</th>
                  <th class="dark-background-heading">Invoice Date</th>
                  <th class="dark-background-heading">Total Price</th>
                  <th class="dark-background-heading"></th>
                </tr>
              </thead>
              <tbody>
<?php   if($count>0){  ?>                 
                <?php foreach ($invoices as $key => $value): ?>
                  <?php //gs($value['id']); ?>
                  <tr>
                    <td><a href="<?php echo base_url('admin/invoice/ViewInvoice/'.$value['id']) ?>">#<?=$value['invoice_number'];?></a></td>
                    <td><?=getCustomerNameById($value['customer_id']);?></td>
                    <td><?=getLocationNameById($value['location_id']);?></td>
                    <td>
                        <?php if($value['invoice_status']==3): ?>
                          <span class="badge badge-success">Paid</span>
                        <?php elseif($value['invoice_status']==5): ?>
                          <?php 
                          $ref_amt = getInvoicesbyRefundAmount($value['id']);
                          if ($ref_amt!=$value['total_price_without_voucher']) {?>
                           <span class="badge badge-warning">Partially Refund&nbsp;(<?=number_format($ref_amt,2)?>)</span>
                         <?php }
                         else{?>
                          <span class="badge badge-warning">Full Refund&nbsp;(<?=number_format($ref_amt,2)?>)</span>
                        <?php }
                          ?>
                        <?php else: 
                          if ($value['total_price'] != $value['outstanding_invoice_amount']) {?>
                           <span class="badge badge-warning">Partially Outstanding&nbsp;(<?=number_format($value['outstanding_invoice_amount'],2)?>)</span>
                         <?php }
                         else{?>
                          <span class="badge badge-warning">Full Outstanding&nbsp;(<?=number_format($value['outstanding_invoice_amount'],2)?>)</span>
                        <?php }
                           endif ?>
                    </td>
                    <td>
                      <?php echo date("D, d M Y",strtotime($value['date_created'])); ?>
                    </td>
                    <td>
                      <?php/* if($value['invoice_status']==4) { echo number_format($value['outstanding_invoice_amount'],2); }else{ echo number_format($value['total_price_without_voucher'],2); }*/ ?>
                       <?=number_format($value['total_price_without_voucher'],2);?> 
                      </td>
                     

                    <?php if($value['invoice_status']!=5 && $value['invoice_status']!=0 && $value['invoice_status']!=6 && $value['total_price_without_voucher']>0){ ?>
                       <td><a class="btn btn-dark" href="<?php echo base_url('admin/invoice/refund/'.$value['id']) ?>" style="color: #fff;">Refund</a></td>
                    <?php }


                    else{?>
                        <td>  </td>
                    <?php } ?>
                  </tr>
                <?php endforeach ?>
<?php }else{?>
                  <tr><td style="width:100%;text-align:center;" colspan="7">No Invoice Found</td></tr>
                  <?php }?>                 
              </tbody>
            </table>
            <?php echo $pagination; ?>
 

            </form>          
                  
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End page -->
   
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
  
  <!-- <script type="text/javascript">
  $(document).ready( function() {
  $('#example').dataTable( {
  order: [],
  columnDefs: [ { orderable: false, targets: [0,-1] } ]
  });
  });
  </script> -->