<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <?php $this->load->view('admin/common/left_menubar'); ?>
  <!-- Page -->
  <div class="page">
    <?php $this->load->view('admin/common/header_messages'); ?>
    <!-- Contacts Content -->
    <div class="page-main">
      <div class="page-content">
        <div class="panel">
          
          <!-- Contacts Content Header -->
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
          <div class="page-header">
            <?php $this->load->view('admin/product/inventry_top'); ?>
            <?php if($admin_session['role'] == 'owner'){?>
                
              </div>
            <?php } ?>
             <?php if($admin_session['role'] == 'business_owner'){?>
                    
            <div class="page-header-actions">
            <?php } ?> 
            
              
            </div>
          </div>

          <!-- Contacts Content -->
          
         
            <!-- Actions -->
            <!-- Contacts -->
            <form id="frm_customer" name="frm_customer" action="" method="post">
            <table id="example" class="table table-hover  table-striped w-full" data-plugin="">
                    <thead>
                      <tr>
                       
                        <th class=" dark-background-heading">Bar Code </th>
                        <th class=" dark-background-heading">Product Name </th>
                         <th class=" dark-background-heading">Base Price</th>
                         <th class=" dark-background-heading">Quantity</th>
                         <th class=" dark-background-heading">Total</th>
                         <th class=" dark-background-heading">Open date</th>
                         <th class=" dark-background-heading">Reason </th>                       
                        

                       <!--   <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){ ?>
                        <th class=" dark-background-heading">location</th>
                        <?php } ?>-->
                       <!--  <th class=" dark-background-heading">Action</th> -->
                         
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                    
                      foreach ($getproduct_used as $key => $value) {
                        
                      ?>
                      <tr id="row_<?php echo $value['id']; ?>">
                       
                       <?php $totalquantity=$value['purchase_price']*$value['quantity']; ?>
                        <td> <?php echo $value['bar_code']; ?></td>
                          <td> <?php echo $value['product_name']; ?></td>
                         <td> <?php echo $value['purchase_price']; ?></td>
                          <td> <?php echo $value['quantity']; ?></td>
                         <td> <?php echo $totalquantity; ?></td>
                        
                        <td> <?php echo date("D, d M Y",strtotime($value['date_created'])); ?>
                        </td>
                      
                           <td><?php 
                        if ($value['used_type']==1) {
                          echo "Used in Salon";
                        }
                        else{
                          echo "Use as Tester";
                        }
                        ?></td> 

                        <!--   <td>
            <a class="btn btn-primary" href="javascript:void(0)" onClick="operation_product_close('<?php echo $value['id']; ?>','delete')" role="menuitem">close</a>
                          </td>   

                        <td><?php echo getStaffName($value['staff_id']); ?></td>
                        <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){ ?>
                        <td><?php echo getLocationNameById($value['location_id']); ?></td>
                        <?php } ?> -->   
                 
                      </tr>
                      <?php }
                      ?>
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

<!-- Modal -->
                  <div id="myModalSupplier" class="modal">
                      <div class="modal-dialog modal-simple">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <!-- <h4 class="modal-title">Modal Title</h4> -->
                          </div>

                          <div class="modal-body">
                            <p>Only Owner can create Supplier.</p>
                          </div>

                          <div class="modal-footer">
                           <!--  <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button> -->
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

 

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
    function operation_product_close(id)
        {
          if(id!=""){
            swal({
                    title: "Are you sure?",
                   // text: "You will not be able to recover this customer!",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    confirmButtonText: 'Yes',
                    closeOnConfirm: false
                  //closeOnCancel: false
                  }, function () {
              $.ajax({
                type: 'POST',
                url: site_url + 'admin/Operations/product_close/' + encodeURIComponent(id),
                datatype: 'json',
                beforeSend: function() {
                },
                success: function(data)
                {
                  data = JSON.parse(data);
                  if (data.status == 'not_logged_in') {
                    location.href= site_url + 'admin'
                  }else if (data.status == 'success') {
                    $("#row_"+id).hide().remove();
                  } else {
                  swal("Error!", "Something went wrong, please refresh page and try again", "error");
                            }
                          }
                        });
                      swal("Closed!", "Product has been closed!", "success");
                    });
          }else{
            return false;
          }
        }
    
  </script>

<script type="text/javascript">
$(document).ready( function() {
  $('#example').dataTable( {
   order: ['5', 'desc'],
  });
});
</script>