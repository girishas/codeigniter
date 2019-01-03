<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
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
          
          <div class="page-header">
            <h1 class="page-title">All Business Categories</h1>
            <div class="page-header-actions">
              <div class="row">
                <a href="<?php echo base_url('admin/business/add_category');?>"><button type="button" class="btn btn-info">Add Category</button></a>
                <a href="<?php echo base_url('admin/setup');?>" class="ml-5"><button type="button" class="btn btn-block btn-primary">Setup</button></a>
              </div>
            </div>
          </div>

          <!-- Contacts Content -->
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
          <?php if(isset($all_categories)){?>
          <!-- Actions -->
          
          <div class="page-content-actions">
            <div class="btn-group btn-group-flat" style="margin-left:5px;">
              <button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
            </div>
          </div>

          <input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
          <input type="hidden" name="search_width" id="search_width" value="232px">
                  
          <!-- Contacts -->
          <form id="frm_customer" name="frm_customer" action="" method="post">
            <table id="example" class="table table-hover  table-striped w-full" data-plugin="">
              <thead>
                  <tr>
                    <th class="dark-background-heading" >
                      <span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
                        <input type="checkbox" class="contacts-checkbox" id="select_all" />
                        <label for="select_all"></label>
                      </span>
                    </th>
                    <th class="dark-background-heading" >Category Name</th>
                    <th class="dark-background-heading" >Added date</th>
                    <th class="dark-background-heading" >Actions</th>
                    
                  </tr>
                </thead>
                <tbody>
                
                <?php $counter = 1;foreach($all_categories as $category){?>
                <tr id="row_<?php echo $category['id']; ?>">
                  
                  <td>
                    <span class="checkbox-custom checkbox-primary checkbox-lg">
                    <input type="checkbox" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $category['id'];?>"/>
                    <label for="contacts_1"></label>
                    </span>
                  </td>
                  <td ><?php echo $category['name'];?></td>
                  <td ><?php echo date('Y-m-d',strtotime($category['date_created']));?></td>
                  <td >
                    <a href="<?php echo base_url('admin/business/edit_category/'.$category['id']);?>">
                      <button type="button" class="btn btn-sm btn-icon btn-pure btn-default waves-effect waves-classic" data-toggle="tooltip" data-original-title="Edit">
                    <i class="icon md-wrench" aria-hidden="true"></i></button></a>
                    <a href="javascript:void(0);" onClick="delete_category('<?php echo $category['id']; ?>')">
                      <button type="button" class="btn btn-sm btn-icon btn-pure btn-default waves-effect waves-classic" data-toggle="tooltip" data-original-title="Delete">
                    <i class="icon md-close" aria-hidden="true"></i></button></a>
                  </td>
                  
                </tr>
                <?php $counter++;}?>
                </tbody>
              </table>
              </form>
              <?php }else{?>
              <div style="width:100%;float:left;text-align:center;">No category Added</div>
              <?php }?>
              <!--<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
            </div>
          </div>
      </div>
    </div>
  </div>
        <!-- End page -->

<script language="javascript">
function delete_category(id)
{
  if(id!=""){
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this Category!",
      type: "info",
      showCancelButton: true,
      confirmButtonClass: "btn-info",
      confirmButtonText: 'Yes, delete it!',
      closeOnConfirm: false
    //closeOnCancel: false
    }, function () {
      $.ajax({
        type: 'POST',
        url: site_url + 'admin/Operations/delete_business_category/' + encodeURIComponent(id),
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
      swal("Deleted!", "Category has been deleted!", "success");
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
    order: [],
    columnDefs: [ { orderable: false, targets: [0,-1] } ]
  });
});
</script>