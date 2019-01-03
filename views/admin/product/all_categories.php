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
          <div class="page-header">
            <?php $this->load->view('admin/product/inventry_top'); ?>
        <?php if($admin_session['role'] == 'owner'){?>
            <div class="page-header-actions"><a href="javascript:void(0);"><button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalCategory">Add Category</button></a></div>
        <?php } ?>
        <?php if($admin_session['role'] == 'business_owner'){?>
            <div class="page-header-actions"><a href="<?php echo base_url('admin/product/add_category');?>"><button type="button" class="btn btn-block btn-primary">Add Category</button></a></div>
        <?php } ?> 
            
          </div>

          <!-- Contacts Content -->
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
            <?php if(isset($all_records)){?>
            <!-- Actions -->
            
              <?php if($admin_session['role'] == 'business_owner'|| $admin_session['role'] == 'owner'){?>
            <div class="page-content-actions">
              <div class="btn-group btn-group-flat" style="margin-left:5px;">
                <button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
              </div>
            </div>
            <?php } ?>

            <input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
            <input type="hidden" name="search_width" id="search_width" value="232px">
                
            <!-- Contacts -->
            <form id="frm_customer" name="frm_customer" action="" method="post">
            <table id="example" class="table table-hover  table-striped w-full" data-plugin="">
              <thead>
                <tr>
                  <!-- <th class="pre-cell dark-background-heading"></th> -->
                  <th  class="dark-background-heading">
                    <span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
                      <input type="checkbox" class="contacts-checkbox selectable-all" id="select_all"
                      />
                      <label for="select_all"></label>
                    </span>
                  </th>
                  <th class=" dark-background-heading" >Category Name</th>
                  <th class=" dark-background-heading" >Category Code</th>
                  <th class=" dark-background-heading" >Status</th>
                  <th class=" dark-background-heading" >Added date</th>
                    <?php if($admin_session['role'] == 'business_owner'|| $admin_session['role'] == 'owner'){?>
                  <th class=" dark-background-heading" >Actions</th>
                  <?php } ?>
                  <!-- <th class="suf-cell"></th> -->
                </tr>
              </thead>
              <tbody>
                <?php $counter = 1;foreach($all_records as $row){?>
                <tr id="row_<?php echo $row['id']; ?>">
                  <!-- <td class="pre-cell"></td> -->
                  <td>
                    <span class="checkbox-custom checkbox-primary checkbox-lg">
                    <input type="checkbox" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $row['id'];?>"/>
                    <label for="contacts_1"></label>
                    </span>
                  </td>
                  <td ><?php echo $row['category_name'];?></td>
                  <td ><?php echo $row['category_code'];?></td>
                  <td >
                    <?php if($row['status']==1){?>
                    <span class="badge badge-primary" id="active_inactive<?php echo $row['id']; ?>">Active</span>
                    <?php }else{?>
                    <span class="badge badge-danger" id="active_inactive<?php echo $row['id']; ?>">Inactive</span>
                    <?php } ?>
                  </td>
                  <td ><?php echo date('Y-m-d',strtotime($row['date_created']));?></td>
                    <?php if($admin_session['role'] == 'business_owner'|| $admin_session['role'] == 'owner'){?>
                  <td >
                    <div class="btn-group dropdown">
                      <button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
                      <div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
                        <a class="dropdown-item" href="javascript:void(0)" onClick="operation_category('<?php echo $row['id']; ?>','active')"role="menuitem"><i class="icon md-check" aria-hidden="true"></i>Active</a>
                        <a class="dropdown-item" href="javascript:void(0)" onClick="operation_category('<?php echo $row['id']; ?>','inactive')" role="menuitem"><i class="icon md-pause" aria-hidden="true"></i>Inactive</a>
                       
                        <a class="dropdown-item" href="<?php echo base_url('admin/product/edit_category/'.$row['id']);?>"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
                        <!-- <a class="dropdown-item" href="javascript:void(0)" onClick="operation_category('<?php echo $row['id']; ?>')" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a> -->
                        
                      </div>
                    </div>
                  </td>
                  <?php } ?>
                  <!-- <td class="suf-cell"></td> -->
                </tr>
                <?php $counter++;}?>
              </tbody>
            <!-- </table> -->
              <?php }else{?>
              <div style="width:100%;float:left;text-align:center;">No Category Added</div>
              <?php }?> 
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
                  <div id="myModalCategory" class="modal">
                      <div class="modal-dialog modal-simple">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <!-- <h4 class="modal-title">Modal Title</h4> -->
                          </div>

                          <div class="modal-body">
                            <p>Only Owner can create Category.</p>
                          </div>

                          <div class="modal-footer">
                           <!--  <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button> -->
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
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

function operation_category(id,op_type)
{
  if(id!=""){
  swal({
  title: "Are you sure?",
  type: "info",
  showCancelButton: true,
  confirmButtonClass: "btn-info",
  confirmButtonText: 'Yes',
  closeOnConfirm: false
  //closeOnCancel: false
  }, function () {
    $.ajax({
      type: 'POST',
      url: site_url + 'admin/Operations/delete_product_category/' + encodeURIComponent(id),
      data: 'operation='+op_type,
      datatype: 'json',
      beforeSend: function() {
      },
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
      swal("Success!", "Action Performed Successfully!", "success");
  });
  }else{
  return false;
  }
}

function delete_selected(){
    swal({
    title: "Are you sure?",
    text: "You will not be able to recover this category!",
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

<script type="text/javascript">
$(document).ready( function() {
  $('#example').dataTable( {
  order: ['4', 'desc'],
  });
});
</script>