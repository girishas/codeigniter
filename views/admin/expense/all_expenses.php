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
             <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/today_sale');?>">Today Position</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/expense/close_register');?>">Close Register</a></li> 
              <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab" href="<?php echo base_url('admin/expense/all_expenses');?>">Expense</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_pos_category');?>">Pos Category</a></li>
             <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_vendors');?>">Vendor</a></li>
              
            </ul> -->

            <?php $this->load->view('admin/common/expense_menu'); ?>

          
            <div class="page-header-actions">
              <a class="btn btn-info" href="<?php echo base_url('admin/expense/add_expense');?>"> Add Expense </a>
            </div>
          
          </div>
          <!-- Contacts Content -->
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
           <?php if(isset($all_records)){?>
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
                       
                        <th class="dark-background-heading">Date</th>
                        <th class="dark-background-heading">Medium</th>
                        <th class="dark-background-heading">Description</th>
                        <th class="dark-background-heading">Reference</th>
                        <th class="dark-background-heading">Amount</th>
                        <th class="dark-background-heading">Net</th>
                        <th class="dark-background-heading">GST</th>
                        <th class="dark-background-heading">Vendor Id</th>
                        <th class="dark-background-heading">Exp Catg</th>
                        <th class="dark-background-heading">Loc Id</th>
                       <!--  <th class="dark-background-heading">Notes</th> -->
                        <th class="dark-background-heading">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                         <?php $counter = 1;foreach($all_records as $row){ ?>
                         <tr id="row_<?php echo $row['id']; ?>">
                          <td>
                            <span class="checkbox-custom checkbox-primary checkbox-lg">
                            <input type="checkbox" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $row['id'];?>"/>
                            <label for="contacts_1"></label>
                            </span>
                          </td>
                          <td><?php echo $row['paid_date'];?></td>
                          <td><?php echo getPayType($row['medium']);?></td>
                          <td><?php echo $row['description'];?></td>
                          <td><?php echo $row['reference'];?></td>
                          <td><?php echo $row['amount'];?></td>
                          <td><?php echo $row['net'];?></td>
                          <td><?php echo $row['gst'];?></td>
                          <td><?php echo getVendorNameById($row['vendor_id']);?></td>
                          <td><?php echo getPosExpcategoryNameById($row['pos_expcategory_id']);?></td>
                          <td><?php echo getLocationNameById($row['location_id']);?></td>
                        <!--   <td><?php echo (substr($row['notes'],0,10));?></td> -->
                         
                         
                          
                          <td><div class="btn-group dropdown">
                            <button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
                            <div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
                              <a class="dropdown-item" href="<?php echo base_url('admin/expense/add_expense/').$row['id'];?>" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
                             <!--  <a class="dropdown-item" href="<?php echo base_url('admin/expense/add_expense/');?>" role="menuitem"><i class="icon md-eye" aria-hidden="true"></i>View</a> -->
                             <!--  <a class="dropdown-item" href="javascript:void(0)" onClick="operation_customer('','delete')" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a> -->
                            </div>
                          </div></td>
                          <?php $counter++;}?>
                        </tr>
                        
                      </tbody>
                    </table>
                  </form>
                  <?php }else{?>
                  <div style="width:100%;float:left;text-align:center;">No Expense Added Yet</div>
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
    
    function operation_service_category (id) {
      op_type = "delete";
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this pos category!",
        type: "info",
        showCancelButton: true,
        confirmButtonClass: "btn-info",
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false
        //closeOnCancel: false
        }, function () {
        $.ajax({
          type: 'POST',
          url: site_url + 'admin/Operations/delete_pos_category/' + encodeURIComponent(id),
          data: 'operation='+op_type,
          datatype: 'json',
          success: function(data)
          {
            data = JSON.parse(data);
            if (data.status == 'not_logged_in') {
              location.href= site_url + 'admin'
              }else if (data.status == 'success') {
              if(op_type=="active"){
                $("#active_inactive"+id).html('Active');
                $("#active_inactive"+id).removeClass("badge-danger")
                $("#active_inactive"+id).addClass("badge-primary")
                }else if(op_type=="inactive"){
                $("#active_inactive"+id).html('Inactive');
                $("#active_inactive"+id).removeClass("badge-primary")
                $("#active_inactive"+id).addClass("badge-danger")
              }else if(op_type=="delete")
              $("#row_"+id).hide().remove();
              } else {
              swal("Error!", "Unknown error accured!", "error");
            }
          },
          error: function(){
            swal("Error!", "Unknown error accured!", "error");
          }
        });
        swal("Deleted!", "Pos Category has been deleted!", "success");
      });
    }
    
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

</script>