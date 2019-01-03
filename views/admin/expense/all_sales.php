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
          <!-- <div class="panel-heading">
            <h1 class="panel-title">All Expenses</h1>
            <div class="page-header-actions">
              <a href="<?php echo base_url('admin/expense/add_expense');?>">
                <button type="button" class="btn btn-block btn-primary">Add Expenses</button>
              </a>
            </div>
          </div> -->
          <div class="page-header">
            <!-- <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense');?>">Open Register</a></li>
             <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab" href="<?php echo base_url('admin/expense/today_sale');?>">Today Position</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/expense/close_register');?>">Close Register</a></li> 
              
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_expenses');?>">Expense</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_pos_category');?>">Category</a></li>
             <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_vendors');?>">Vendor</a></li>
              
            </ul> -->

            <?php $this->load->view('admin/common/expense_menu'); ?>
          </div>
          <!-- Contacts Content -->
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
           
               <?php if(isset($all_sales)){?>
            <!-- Actions -->
           <div class="page-content-actions">
              <div class="btn-group btn-group-flat" style="margin-left:5px;">
                <button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
              </div>
            </div>
            <!--    <div class="btn-group btn-group-flat" style="margin-left:5px;">
                <form method="post" action="<?php echo base_url('admin/customer/merge_customers'); ?>">
                  <input type="hidden" required="required" name="m_id" id="m_id">
                  <button type="submit" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Marge Selected</button>
                </form>
              </div>
              <div class="btn-group btn-group-flat" style="margin-left:5px;">
                <a  href="<?php echo base_url('admin/customer/export_to_csv');?>">
                  <button type="button" class="btn btn-success waves-effect waves-classic">
                  <i class="icon md-upload text" aria-hidden="true"></i><span class="text">Export to CSV</span></button></a>
                </div>
                
                <div class="btn-group btn-group-flat" style="margin-left:5px;">
                  <a  href="<?php echo base_url('admin/customer/import_to_csv');?>">
                    <button type="button" class="btn btn-success waves-effect waves-classic">
                    <i class="icon md-upload text" aria-hidden="true"></i><span class="text">Import to CSV</span></button></a>
                  </div>
                  
                </div> -->
           
                
                <!-- Contacts -->
                <form id="frm_records" name="frm_records" action="" method="post">
                  <table id="example" class="table table-hover  table-striped w-full" data-plugin="">
                    <thead>
                      <tr>
                        <th class="dark-background-heading">
                          <span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
                                        <input type="checkbox" class="contacts-checkbox" id="select_all" />
                                        <label for="select_all"></label>
                                      </span>
                        </th>
                       
                        <th class="dark-background-heading">Open Date</th>
                        <th class="dark-background-heading">Open Cash</th>
                        <th class="dark-background-heading">Cash Payment</th>
                        <th class="dark-background-heading">Cheque Payment</th>
                        <!-- <th class="dark-background-heading">Credit Card Payment</th>
                        <th class="dark-background-heading">Gift Card Payment</th> -->
                        <th class="dark-background-heading">Total Sale</th>
                        <th class="dark-background-heading">Total Expenses</th>
                        <th class="dark-background-heading">Total Refund</th>
                        <!-- <th class="dark-background-heading">Location Name</th>
                        <th class="dark-background-heading">Notes</th> -->
                      </tr>
                    </thead>
                    <tbody>
                         <?php $counter = 1;foreach($all_sales as $row){ ?>
                         <tr id="row_<?php echo $row['id']; ?>">
                          <td>
                            <span class="checkbox-custom checkbox-primary checkbox-lg">
                            <input type="checkbox" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $row['id'];?>"/>
                            <label for="contacts_1"></label>
                            </span>
                          </td>
                          <td><?php echo date("d/m/Y", strtotime($row['open_date']));?></td>
                          <td><?php echo $row['open_cash'];?></td>
                          <td><?php echo $row['cash_payment'];?></td>
                          <td><?php echo $row['cheque_payment'];?></td>
                          <!-- <td><?php echo $row['cc_payment'];?></td>
                          <td><?php echo $row['gif_payment'];?></td> -->
                          <td><?php echo $row['total_sale'];?></td>
                          <td><?php echo $row['total_expence'];?></td>
                          <td><?php echo $row['total_refund'];?></td>
                         <!--  <td><?php echo getLocationNameById($row['location_id']);?></td>
                          <td><?php echo (substr($row['notes'],0,10));?></td> -->
                          <?php $counter++;}?>
                        </tr>
                        
                      </tbody>
                    </table>
                  </form>
                  <?php }else{?>
                  <div style="width:100%;float:left;text-align:center;">No Sale Closed Yet</div>
                  <?php }?>
                    
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
        text: "Sure to delete all selected record!",
        type: "info",
        showCancelButton: true,
        confirmButtonClass: "btn-info",
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false
        //closeOnCancel: false
        }, function () {
        document.frm_records.submit();
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

<script type="text/javascript">

  $(document).ready( function() {
  $('#example').dataTable( {
    order: [],
    columnDefs: [ { orderable: false, targets: [0,-1] } ]
  });
});

</script>