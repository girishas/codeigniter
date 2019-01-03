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
         <!--  <h1 class="page-title"></h1> -->
           <!-- <h1 class="panel-title">All Customers</h1>
 -->          <div class="page-header-actions">
            <a class="btn btn-info" href="<?php echo base_url('admin/service/all_packages');?>">All Packages </a>
            
          </div>
        </div>
       
        <!-- Contacts Content -->
        <div class="page-main">
          
                
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
                      <th class="cell-10 dark-background-heading" scope="col">package INVOICE No.</th>
                      <th class="cell-10 dark-background-heading" scope="col">Customer Name</th>
                      <th class="cell-10 dark-background-heading" scope="col">Service Name</th> 
                      <th class="cell-10 dark-background-heading" scope="col">Total Used Service</th>
                       <th class="cell-10 dark-background-heading" scope="col"> Start Date</th>
                        <th class="cell-10 dark-background-heading" scope="col">Expire Date</th>
                     
                                            
                    </tr>
                  </thead>
                  <tbody>

                    <?php $counter=1; foreach ($get_customber_package as $key => $value) { ?>
                     <tr>
                      <td> <a href="<?php echo base_url('admin/invoice/ViewInvoice/'.$value['invoices_id']);?>">
                        <?php echo $value['invoices_invoice_number'] ?>
                      </a> </td>
                      <td>
                        <a href="<?php echo base_url('admin/customer/detail/'.$value['customer_id']);?>">
                        <?php echo $value['customer_first_name'].' '.$value['customer_last_name']  ?>
                      </a>                         
                      </td>
                     <td><?=getServiceName($value['service_id']); ?>
                      &nbsp;&nbsp;
                           <?=getCaptionName($value['service_timing_id']);?>
                       
                     </td> 

                      <td>
                        <?php if ($value['complited_visits']>0) { ?>
                          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter_<?=$key?>">
  <?php echo $value['complited_visits'] ?>
</button>
                        <?php }

                        else{
                          echo $value['complited_visits'];
                        } 
                        ?>
                          <!-- Button trigger modal -->


                       
                          
                        </td>
                      <td><?php echo date('D d M Y', strtotime($value['packages_start_date']))  ?></td>
                      <td><?php echo date('D d M Y', strtotime($value['packages_expire_date']))  ?>


                        
                      </td>



                   </tr>
              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenter_<?=$key?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Used Service Details </h5>

                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                     <?php 
                     if (!empty($value['used_invoice_id'])) {

                       $packagesdetails=getPackagesDetails($value['used_invoice_id'])?>
                    <div class="modal-body">
                    
                      <div class="row"> 
                    <div class="col-md-4">
                  <label>#</label>
                </div>
                <div class="col-md-4">
                  <label>Invoice Number</label>
                </div>
                <div class="col-md-4">
                  <label>Date</label>
                </div>
                  </div>

                        <?php $counter=1; foreach ($packagesdetails as $key => $pack) { ?>
                <div class="row"> 
                    <div class="col-md-4">
                 <?php echo $counter; ?>
                </div>

                 <div class="col-md-4">
                 <a href="<?php echo base_url('admin/invoice/ViewInvoice/'.$pack['invoice_id']);?>">
                        <?php echo $pack['invoice_number']; ?>
                      </a>
                </div>
               

                <div class="col-md-4">
                   <?php echo date('D d M Y', strtotime($pack['date_created']));  ?>
                </div>
                         </div>
                       <?php
                        $counter++;
                        } 
                        
                     }
                     ?>
                    
                      

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- model End-->


    <?php }



                    $counter++;
                     ?>



                  </tbody> 
                </table>




             
              <!--<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End page -->


    
    


<!-- End page -->
  <script language="javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.js');?>"></script>
  <script language="javascript" src="<?php echo base_url('assets/js/jquery.suggestion.js');?>"></script>
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