<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
<?php $this->load->view('admin/common/left_menubar'); ?>  
  
  <!-- Page -->
  <div class="page bg-white">
    
    <!-- Alert message part -->
    <?php $this->load->view('admin/common/header_messages'); ?>
    <!-- End alert message part -->  

  
      <div class="alert dark alert-success alert-dismissible" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
         Please select main customer entry that you want to save and other unselected rows will be deleted after merging data
      </div>
  
    <!-- Contacts Content -->
    <div class="page-main">

      <!-- Contacts Content Header -->
      <div class="page-header">
        <h1 class="page-title">Merge Customers</h1>
        <div class="page-header-actions"><a href="<?php echo base_url('admin/customer');?>"><button type="button" class="btn btn-block btn-primary">All Customer</button></a></div>
        <div class="page-header-actions">
          <!--<form>
            <div class="input-search input-search-dark">
              <i class="input-search-icon md-search" aria-hidden="true"></i>
              <input type="text" class="form-control" name="" placeholder="Search...">
            </div>
          </form>-->
        </div>
      </div>

      <!-- Contacts Content -->
      <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">

        <?php if(isset($all_records)){?>
        <!-- Actions -->
        <div class="page-content-actions">
          <!-- <div class="btn-group btn-group-flat" style="margin-left:5px;">
            <button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
          </div>
          <div class="btn-group btn-group-flat" style="margin-left:5px;">
            <a  href="<?php echo base_url('admin/customer/marge_customers');?>"><button type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Marge Selected</button></a>
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
          </div> -->
        </div>

        <input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
        <input type="hidden" name="search_width" id="search_width" value="232px"> 

        <!-- Contacts -->
        <form id="frm_customer" name="frm_customer" action="<?php echo base_url('admin/customer/merge_customers'); ?>" method="post">

          <input type="hidden" name="merge_customer" value="merge_customer">
          <input type="hidden" name="m_id" id="m_id" value="" >

          <table class="table table-hover dataTable table-striped w-full" >
            <thead>
              <tr>
                <th class="dark-background-heading"></th>
                <th class="dark-background-heading">Image</th>
                <th class="dark-background-heading">Customer Number</th>
                <th class="dark-background-heading">Customer Name</th>
                <th class="dark-background-heading">Mobile Number</th>
                <th class="dark-background-heading">Gender</th>
                <th class="dark-background-heading">Added date</th>
                <!-- <th class="dark-background-heading">Actions</th> -->
              </tr>
            </thead>
            <tbody>
              <?php $counter = 1;foreach($all_records as $row){?>
              <tr id="row_<?php echo $row['id']; ?>">
              
                <td>
                  
                  <input type="radio" class="contacts-checkbox checkbox1" name="radio"  value="<?php echo $row['id'];?>" />
                  <label for="contacts_1"></label>
                  
                  <span class="checkbox-custom checkbox-primary checkbox-lg" style="display: none;">
                    <input type="hidden" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $row['id'];?>"/>
                    <label for="contacts_1"></label>
                  </span>
                </td>
                
                <td>
                  <?php if(!empty($row['photo'])){ ?>
                  <a href="<?php echo base_url('admin/customer/edit_customer/'.$row['id']);?>">
                  <img class="img-fluid" src="<?php echo base_url('images/customer/thumb/'.$row['photo']); ?>" width="50" />
                  <?php }else{?>
                  <img class="img-fluid" src="<?php echo base_url('global/product/no-product-image.jpg');?>" width="50" >
                  <?php } ?>
                  </a>
                </td>
                
                <td><?php echo $row['customer_number'];?></td>

                <td><a href="<?php echo base_url('admin/customer/detail/'.$row['id']);?>"><?php echo $row['first_name'].' '.$row['last_name'];?></a></td>
                
                <td><?php echo $row['mobile_number'];?></td>

                <td><?php echo $row['gender'];?></td>

                <td><?php echo $row['date_created'];?></td>
                
                <!-- <td>
                  <div class="btn-group dropdown">
                    <button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
                    <div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
                      <a class="dropdown-item" href="<?php echo base_url('admin/customer/edit_customer/'.$row['id']);?>" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
                      <a class="dropdown-item" href="<?php echo base_url('admin/customer/detail/'.$row['id']);?>" role="menuitem"><i class="icon md-eye" aria-hidden="true"></i>View</a>
                      <a class="dropdown-item" href="javascript:void(0)" onClick="operation_customer('<?php echo $row['id']; ?>','delete')" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a>
                    </div>
                  </div>
                </td>  -->
              </tr>
              <?php $counter++; } ?> 
            </tbody>
          </table>
          <div class="btn-group btn-group-flat" style="margin-left:5px;">
            <button type="submit" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Merge Selected</button>
          </div>
        </form>
        <?php }else{?>
        <div style="width:100%;float:left;text-align:center;">Please select more then one customer first.</div>
        <?php }?> 
          <!--<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
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


  
  function operation_customer(id)
  {
  if(id!=""){
    if(window.confirm("Sure to delete this record?")){
       $.ajax({
        type: 'POST',
        url: site_url + 'admin/Operations/delete_customer/' + encodeURIComponent(id),
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
            alert('Something went wrong, please refresh page and try again');
          }
        }
      });
      
    }
  }else{
    return false;
  }
}
function delete_selected(){
  if(window.confirm("Sure to delete all selected record?")){
    document.frm_customer.submit();
  }
}

function merge_selected(){
  if(window.confirm("Sure to delete all selected record?")){
    document.frm_customer.submit();
  }
}

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  
  //var old_mid = $("#m_id").val('');
  $('.checkbox1').click(function()
  {
    if($(this).is(":checked")) 
    {
      var id = $(this).val();     
      //alert(id);
    }
    $("#m_id").val(id);

  })
});
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('input:radio[name=radio]:nth(0)').attr('checked',true);
  });
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