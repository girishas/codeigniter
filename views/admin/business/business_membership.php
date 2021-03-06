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
            <h1 class="panel-title">Subscriptions List</h1>
           <div class="page-header-actions">
              <a href="<?php echo base_url('admin/business/');?>"><button type="button" class="btn btn-block btn-primary">All Business</button></a>
            </div>
          </div>
          <!-- Contacts Content -->
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
            <?php if(isset($all_business_membership)){?>
            <!-- Actions -->
           
                <input type="hidden" name="redirect_url" id="redirect_url" value="admin/customer">
                <input type="hidden" name="search_width" id="search_width" value="232px">
                
                <!-- Contacts -->
                <form id="frm_customer" name="frm_customer" action="" method="post">
                  <table id="example" class="table table-hover  table-striped w-full" data-plugin="">
                    <thead>
                      <tr>                       
                        <th class="dark-background-heading">Plan Name</th>
                        <th class="dark-background-heading">Plan Price</th>
                        <th class="dark-background-heading">Start Date </th>
                        <th class="dark-background-heading">End Date</th>
                        <th class="dark-background-heading">Status</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                      <?php $counter = 1;foreach($all_business_membership as $business){?>
                      <tr id="row_<?php echo $business['id']; ?>">                        
                         
                          <td><?php echo $business['name'];?></td>
                          
                          <td><?php echo $business['plan_price'];?></td>
                          <td><?php echo date(" D d M Y",strtotime($business['stripe_start_date'])) ;?></td>
                           <td><?php echo date(" D d M Y",strtotime($business['stripe_end_date'])) ;?></td>                        
                         
                          <td>
                            <?php if($business['type']==1){?>
                            <span class="badge badge-primary" id="active_inactive<?php echo $business['id']; ?>">Active</span>
                            <?php }else{?>
                            <span class="badge badge-danger" id="active_inactive<?php echo $business['id']; ?>">Inactive</span>
                            <?php } ?>
                          </td>
                        

                        
                          
                          
                          
                        </tr>
                        <?php $counter++;}?>
                      </tbody>
                    </table>
                  </form>
                  <?php }else{?>
                  <div style="width:100%;float:left;text-align:center;">No business Added</div>
                  <?php }?>
                 
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End page -->
        <script language="javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.js');?>"></script>
        <script language="javascript" src="<?php echo base_url('assets/js/jquery.suggestion.js');?>"></script>
      
        
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

        "order": [[ 4, "asc" ]],
    
    //order: [5,'asc'],
    //"aaSorting": [ [5,'asc'] ],
    //columnDefs: [ { orderable: true, targets: ['des'-1] } ]
  });
});
</script>