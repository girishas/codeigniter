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
    <div class="page-content">
      <div class="panel">
        <!-- Alert message part -->
        <?php $this->load->view('admin/common/header_messages'); ?>
        <!-- End alert message part -->
        
        <div class="page-header">
          <h1 class="page-title"><?php echo $get_voucher->vouchar_name; ?></h1>
          <div class="page-header-actions">
            <a class="btn btn-info" href="<?php echo base_url('admin/voucher');?>">All Vouchers </a>
            
          </div>
        </div>
       
        <!-- Contacts Content -->
        <div class="page-main">
           <form autocomplete="false" method="post" action="<?php echo base_url('admin/voucher/voucher_customer');?>">
              <div class="row mb-10" style="margin-left:5px;">

                  <div class="col-sm-2">
                    <label class="form-control-label" for="inputGrid2">Vouchers</label>
             <select class="form-control form-control-sm" name="voucher_id" id="voucher_id">
                     <?php foreach($vouchers_list as $voucher){
                     $select=$get_voucher->id==$voucher['id']?'selected':''; 
                      ?>
                       <option <?=$select?> value="<?php echo $voucher['id'] ?>"><?php echo $voucher['vouchar_name'] ?></option>
                       <?php }  ?> 
                    </select> 
                  </div>
                  <div class="col-sm-2">
                    <div class="mt-25">
                     
                      <button class="btn btn-primary " name="search_filter" value="search_filter" type="submit" id="viewReportBtn">Search</button>
                    </div> 

                  </div>

              </div>
            </form>
                
          <!-- Contacts Content Header -->
          <!-- <div class="page-header">
            
          </div> -->
          <!-- Contacts Content -->
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
           
            <div class="page-content-actions">
            
              </div>
              
              <input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
              <input type="hidden" name="search_width" id="search_width" value="232px">
              
              <!-- Contacts -->
                <table id="example" class="table table-hover table-striped w-full" >
                  <thead>
                    <tr>
                      <th class="cell-10 dark-background-heading" scope="col">Voucher number</th>
                      <th class="cell-10 dark-background-heading" scope="col">customer</th>
                      <th class="cell-10 dark-background-heading" scope="col">invoice number</th> 
                      <th class="cell-10 dark-background-heading" scope="col">Total Amount</th>
                      <th class="cell-10 dark-background-heading" scope="col">Available Amount</th>
                      <th class="cell-10 dark-background-heading" scope="col">status</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php                    
                     $counter = 1;foreach($all_vouchers as $row){?>
                    <tr>
                     
                      <td><?php echo $row['voucher_code'];?></td>
                      <td><?php echo getCustomerNameById($row['customer_id']);?></td> 
                       <td><?php echo getVoucherIdByInvoiceNumber($row['id']); ?></td> 

                       


                        <td><?php echo $row['voucher_amount'];?></td>
                         <td><?php echo $row['available_amount'];?></td>

                        <td><?php
                        if ($row['status']==1) {                          
                          ?>
                            <span class="badge badge-primary">Active</span>
                        <?php
                        }
                        elseif ($row['status']==2) {
                          
                          ?>
                          <span class="badge badge-secondary">Deactive</span>

                          <?php
                        }
                        elseif ($row['status']==3) {
                         
                          ?>
                          <span class="badge badge-warning">Assigned to customer</span>
                          
                          <?php
                        }
                        elseif ($row['status']==4) {
                         
                          ?>
                          <span class="badge badge-danger">Used</span>
                          
                          <?php
                        }
                        elseif ($row['status']==5) {
                          ?>
                          <span class="badge badge-success">Available</span>
                          
                          <?php
                        }                        
                         ?></td>
                      
                    </tr>
                    <?php $counter++; } ?>
                  </tbody> 
                </table>
             
              <!--<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End page -->

    <script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
    <script language="javascript">
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

<script type="text/javascript">
$(document).ready( function() {
  $('#example').dataTable( {
    order: [],
    columnDefs: [ { orderable: false, targets: [0,-1] } ]
  });
});
</script>