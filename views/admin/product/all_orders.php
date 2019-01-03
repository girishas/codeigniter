<?php
//gs($data);
$this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <?php $this->load->view('admin/common/left_menubar'); ?>
  <!-- Page -->
  <div class="page">
    
    <!-- Contacts Content -->
    <div class="page-main">
      <div class="page-content">
        <div class="panel">
      <?php $this->load->view('admin/common/header_messages'); ?>
      
      <!-- Contacts Content Header -->
      <div class="page-header">
        <?php $this->load->view('admin/product/inventry_top'); ?>
        <div class="page-header-actions"><a href="<?php echo base_url('admin/product/add_order');?>"><button type="button" class="btn btn-block btn-primary">Add Order</button></a></div>
      </div>


      <!-- Contacts Content -->
      <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
        <?php if(isset($all_records)){?>
        <!-- Actions -->
        
        <!-- <div class="page-content-actions">
          <div class="btn-group btn-group-flat" style="margin-left:5px;">
            <button onClick="return delete_selected()" type="button" class="btn btn-info waves-effect waves-classic"><i class="icon md-delete" aria-hidden="true"></i>Delete Selected</button>
          </div>
        </div>
 -->
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
              <th class=" dark-background-heading" >Order Id</th>
              <th class=" dark-background-heading" >Supplier</th>
              <th class=" dark-background-heading" >Recepient</th>
              
              <th class=" dark-background-heading" >Ordered Quantity</th>
              <th class=" dark-background-heading" >Order date</th>
              <th class=" dark-background-heading" >Status</th>
              <th class=" dark-background-heading" >Actions</th>
              <!-- <th class="suf-cell"></th> -->
            </tr>
          </thead>
          <tbody>

            <?php $counter = 1;foreach($all_records as $row){?>
            <tr id="row_<?php echo $row['id'];?>">
              <!-- <td class="pre-cell"></td> -->
              <td>
                <span class="checkbox-custom checkbox-primary checkbox-lg">
                <input type="checkbox" class="contacts-checkbox checkbox1" name="record[]" id="record_<?php echo $counter;?>" value="<?php echo $row['id'];?>"/>
                <label for="contacts_1"></label>
                </span>
              </td>
              <td ><a href="<?php echo base_url('admin/product/order_detail/'.$row['id']);?>">#<?php echo $row['id'];?></a></td>

              <td ><?php 
              if ($row['supplier_id']>0) {
                 echo $row['first_name'].' '.$row['last_name'].' (S)';                
              }
              elseif ($row['warehouse_id']>0) {
              
                     echo $row['warehouse_name'].' (W)';     
              }
              else{                
                

                 $location= getLocationData($row['location_id']);
              echo $location['location_name'].' (L)';  
              }             
              ?></td>

              <td ><?php
                
               if ($row['supper_location_id']>0) {
              
               $location= getLocationData($row['supper_location_id']);
              echo $location['location_name'].' (L)';             
              }  

              elseif ($row['warehouse_id']>0) {
                echo $row['warehouse_name'].' (W)';
              }
                      

              ?></td>
              
              <td >
                <?php echo $row['total_quantity'];?>
                
              </td>
              <td ><?php echo date('Y-m-d',strtotime($row['date_created']));?></td>
              <td>
                <?php
                if($row['status']==0)
                {
                echo '<span class="badge badge-dark">Draft</span>';
                }elseif($row['status']==1)
                {
                echo '<span class="badge badge-info">Ordered</span>';
                }elseif($row['status']==2){
                echo '<span class="badge" style="background-color:#008DBD">Partially Received</span>';
                }elseif($row['status']==3){
                echo '<span class="badge badge-success">Fully Received</span>';
                }else{
                echo '<span class="badge badge-warning">N/A</span>';
                }
                ?>
             </td>
              <td >
                <div class="btn-group dropdown">
                  <button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
                  <div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
                    
					<?php if($row['status']!=0){ ?>
					<a class="dropdown-item" href="<?php echo base_url('admin/product/order_detail/'.$row['id']);?>" role="menuitem"><i class="icon md-check" aria-hidden="true"></i>Ordered</a>
                    <a class="dropdown-item" href="<?php echo base_url('admin/product/order_received/'.$row['id']);?>" role="menuitem"><i class="icon md-plus" aria-hidden="true"></i>Order Received</a>
                    <a class="dropdown-item" href="<?php echo base_url('admin/product/order_attechments/'.$row['id']);?>" role="menuitem"><i class="icon md-file" aria-hidden="true"></i>View Attechments</a>
                    <?php if($row['status'] != 1){ ?>
                    <a class="dropdown-item" href="<?php echo base_url('admin/product/order_invoice/'.$row['id']);?>" role="menuitem"><i class="icon md-eye" aria-hidden="true"></i>View Invoice</a><?php } ?>
					<?php }else{ ?>
					<a class="dropdown-item" href="<?php echo base_url('admin/product/edit_order/'.$row['id']);?>" role="menuitem"><i class="icon md-check" aria-hidden="true"></i>Edit Order</a>	
					<?php } ?>
					
                  </div>
                </div>
              </td>
              <!-- <td class="suf-cell"></td> -->
            </tr>
            <?php $counter++;}?>
          </tbody>
          <?php }else{?>
          <div style="width:100%;float:left;text-align:center;">No Order Added</div>
          <?php }?>
          <!-- <ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>-->
        </table>
        </form>        
      </div>
    </div>
  </div>
</div>
</div>
  <!-- Site Action -->
  <div class="site-action" data-plugin="actionBtn">
    <!--<button type="button" class="site-action-toggle btn-raised btn btn-success btn-floating">
    <i class="front-icon md-plus animation-scale-up" aria-hidden="true"></i>
    <i class="back-icon md-close animation-scale-up" aria-hidden="true"></i>
    </button>-->
    <div class="site-action-buttons">
      <!--<button type="button" data-action="trash" class="btn-raised btn btn-success btn-floating animation-slide-bottom">
      <i class="icon md-delete" aria-hidden="true"></i>
      </button>-->
      <!--<button type="button" data-action="folder" class="btn-raised btn btn-success btn-floating animation-slide-bottom">
      <i class="icon md-folder" aria-hidden="true"></i>
      </button>-->
    </div>
  </div>
  <!-- End Site Action -->
  
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





  <!-- End page -->
  <?php $this->load->view('admin/common/footer'); ?>


<script type="text/javascript">
$(document).ready( function() {
  $('#example').dataTable( {
    order: [],
    columnDefs: [ { orderable: false, targets: [0,-1] } ]
  });
});
</script>