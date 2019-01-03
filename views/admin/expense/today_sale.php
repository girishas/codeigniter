<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
<?php $this->load->view('admin/common/left_menubar'); ?>  
  <!-- Page -->
 <!-- Page -->
    <div class="page">
   <?php $this->load->view('admin/common/header_messages');
  ?>

  <div class="page-main">
      <div class="page-content">
        <div class="panel">
   
   
    <div class="page-header"> 
      <!-- <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense');?>">Open Register</a></li>
               <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'today_sale'){echo 'active';}?>" href="<?php echo base_url('admin/expense/today_sale');?>">Today Position</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/expense/close_register');?>">Close Register</a></li> 
              <li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/expense/all_expenses');?>">Expense</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_pos_category');?>">Pos Category</a></li>
             <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_vendors');?>">Vendor</a></li>
              
            </ul> -->
            <?php $this->load->view('admin/common/expense_menu'); ?>
            <?php if($admin_session['role']=='owner' or $admin_session['role']=='business_owner' or $admin_session['role']=='location_owner'){ ?>
            <div class="page-header-actions">
              <a class="btn btn-info" href="<?php echo base_url('admin/expense/all_sale');?>">All Sale List</a>
            </div>
            <?php } ?>
    </div>
   
   
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <?php //gs($this->uri->segment(4));?>
            <div class="panel">
              <form method="post" action="<?php echo base_url('admin/expense/today_sale');?>">
                <input type="hidden" name="action" value="save">
              <?php if($admin_session['role']=="business_owner" or $admin_session['role']=="owner"){?>
              
                    <div class="col-md-6" id="location_section">
                       <h3 class="panel-title">Today POS</h3>
                      <div class="form-group" data-plugin="formMaterial">
                      <label class="form-control-label" for="inputGrid2">Choose Branch Location*</label>
                       <?php if(isset($open_date)) {
                         foreach ($open_date as $open_date_id) {
                             $location_id = (isset($location_id) && $location_id!='')?$location_id:$open_date_id['location_id']; 
                          } 
                       } 
                        else { $location_id = (isset($location_id) && $location_id!='')?$location_id:''; }?>
                       <span id="content_location_id">
                         <select class="form-control" name="location_id" id="location_id" onChange="check_pos_daily(this.value)">
                          <option value="">Select Location</option>
                        <?php if(isset($locations)){?>
                        <?php foreach($locations as $loc){?>
                          <option value="<?php echo $loc['id'];?>" <?php if(isset($location_id)){ if($location_id==$loc['id'] || $this->uri->segment(4)==$loc['id'] ) { echo "selected"; }  }?>><?php echo $loc['location_name'];?></option>
                        <?php } } ?>
                         </select>
                        </span>
                      <div class="admin_content_error"><?php echo form_error('location_id'); ?></div>
                    </div>
                </div>
          <?php } ?>
                <!-- <div class="btn-group btn-group-flat" style="margin-left:5px;">
                  <label class="form-control-label" for="inputGrid2">Start Date*</label>
                  <input type="text" class="form-control datep" id="start_date" name="start_date"  autocomplete="off">
                </div>
                <div class="admin_content_error"><?php echo form_error('start_date'); ?></div>
                <div class="btn-group btn-group-flat" >
                  <label class="form-control-label" for="inputGrid2">End Date*</label>
                  <input type="text" class="form-control datep" id="end_date" name="end_date" autocomplete="off">
                </div>
                <div class="admin_content_error"><?php echo form_error('end_date'); ?></div>
                <div class="btn-group btn-group-flat" style="margin-left:5px;">
                  <button type="submit" class="btn btn-info waves-effect waves-classic">Export Sale</button>
                </div> -->
                
              <?php if(isset($today_pos)){ ?>
              <div class="panel-heading">
             <strong> Today Summary  (<?php if(isset($today_pos)){echo($today_pos['open_date']); }else{echo 'N/a'; }?> - <?php echo(date('Y-m-d H:i:s')); ?>)  </strong>
              </div> 

              <table class="table table-hover">
                <tbody>
                  <tr>
                    <td style="width:80%;"><strong>Opening Balance (Cash):</strong></td>
                    <td style="width:20%;"><?php if(isset($today_pos)){echo number_format($today_pos['open_cash'],2); }else{echo 'N/a'; }?></td>
                  </tr>
                   <tr>
                    <td style="width:80%;">Cash Payments:</td>
                    <td style="width:20%;"><?php if(isset($total_cash_payment)){echo number_format($total_cash_payment,2); }else{echo 'N/a'; }?></td>
                  </tr>
                  <tr>
                    <td style="width:80%;">Cheque Payment:</td>
                    <td style="width:20%;"><?php if(isset($cheque_payment)){echo number_format($cheque_payment,2); }else{echo 'N/a'; }?></td>
                  </tr>

                  <tr>
                    <td style="width:80%;">Credit Card Payment:</td>
                    <td style="width:20%;"><?php if(isset($total_card_payment)){echo number_format($total_card_payment,2); }else{echo 'N/a'; }?></td>
                  </tr>
                  <tr>
                    <td style="width:80%;">Gift Card Payment:</td>
                    <td style="width:20%;"><?php if(isset($gift_card_payment)){echo round($gift_card_payment, 2); }else{echo 'N/a'; }?></td>
                  </tr>
                   <tr>
                    <td style="width:80%;">Wallet Payment:</td>
                    <td style="width:20%;"><?php if(isset($wallet_payment)){echo number_format($wallet_payment,2); }else{echo 'N/a'; }?></td>
                  </tr>


                  <tr>
                    <td style="width:80%;"><strong>Total Sales:</strong></td>
                    <td style="width:20%;"><?php if(isset($total_sales)){echo  number_format($total_sales, 2); }else{echo 'N/a'; }?></td>
                  </tr>

                  <tr>
                    <td style="width:80%;">Cash Refund:</td>
                    <td style="width:20%;"><?php if(isset($today_total_Cash_refund)){echo number_format($today_total_Cash_refund,2); }else{echo 'N/a'; }?></td>
                  </tr>
                  <tr>
                    <td style="width:80%;">Other Refund:</td>
                    <td style="width:20%;"><?php if(isset($today_total_othere_refund)){echo number_format($today_total_othere_refund,2); }else{echo 'N/a'; }?></td>
                  </tr>
                   <tr>
                    <td style="width:80%;border: 0px;">Cash Expenses:</td>
                    <td style="width:20%;border: 0px;"><?php if(isset($cash_today_total_expenses)){echo number_format($cash_today_total_expenses,2); }else{echo 'N/a'; }?></td>
                  </tr>

                  <tr>
                    <td style="width:80%;border: 0px;">Other Expenses:</td>
                    <td style="width:20%;border: 0px;"><?php if(isset($other_today_total_expenses)+$product_used_amount){echo number_format($other_today_total_expenses+$product_used_amount,2); }else{echo 'N/a'; }?></td>
                  </tr>

                   <tr>
                    <td style="width:80%;border: 0px;">Total Discount:</td>
                    <td style="width:20%;border: 0px;"><?php if(isset($total_discount)){echo number_format($total_discount,2); }else{echo 'N/a'; }?></td>
                  </tr>
                 

                  <tr>
                    <td style="width:80%;"><strong>Total Cash in Hand:</strong></td>
                    <td style="width:20%;"><?php if(isset($total_cash)){ echo number_format($total_cash,2); }else{echo 'N/a'; }?></td>
                  </tr>

                    <tr>
                    <td style="width:80%;border: 0px;"><strong>* Voucher Sale:</strong></td>
                    <td style="width:20%;border: 0px;"><?php if(isset($total_voucher['total'])){echo number_format($total_voucher['total'],2); }else{echo 'N/a'; }?></td>
                  </tr>

                   <tr>
                    <td style="width:80%;border: 0px; color: red;"><strong>* Outstanding:</strong></td>
                    <td style="width:20%;border: 0px;"><?php if(isset($total_outstanding['total_outstanding_invoice_amount'])){echo number_format($total_outstanding['total_outstanding_invoice_amount'],2); }else{echo 'N/a'; }?></td>
                  </tr>

                </tbody>
              </table>
  <?php }else{ ?>
          <div class="panel-heading">
               <div style="width:100%;float:left;text-align:center;">No Record found</div>
           </div> 
  <?php } ?>
 
            <!--  <div class="col-md-12 row">
              <div class="col-md-4">
                        <label class="form-control-label" for="inputGrid1">Export All Sale:</label> 
                    </div>
             </div> -->
 <h3 class="panel-title">Export POS in CSV</h3>
            <div class="col-md-12 row">

                    <div class="col-md-4">
                      <div class="form-group" data-plugin="formMaterial">
                        <label class="form-control-label" for="inputGrid1">Start Date*</label> 
                        <input type="text" class="form-control datep" name="start_date" id="start_date" autocomplete="off" value="<?php if(isset($start_date)){ echo $start_date; }?>">
                        <div class="admin_content_error"><?php echo form_error('start_date'); ?></div>
                      </div>
                    </div> 
                    
                
                    <div class="col-md-4">
                      <div class="form-group" data-plugin="formMaterial">
                        <label class="form-control-label" for="inputGrid1">End Date*</label> 
                        <input type="text" class="form-control datep" name="end_date" id="end_date" autocomplete="off" value="<?php if(isset($end_date)){ echo $end_date; }?>">
                        <div class="admin_content_error"><?php echo form_error('end_date'); ?></div>
                      </div>
                    </div> 
                    <div class="col-md-4">
                      <label class="form-control-label" for="inputGrid1"></label> 
                      <button type="submit" class="btn btn-info waves-effect waves-classic" style="margin-top:8%;">Export history in CSV</button>
                    </div>
                </div>
              </form>
            <!-- End Panel Static Labels -->
          </div>

         
          </div>
        </div>
      </div>
    </div>
    </div>
      </div>
    </div>
    <!-- End Page -->
  <!-- End page -->
<style type="text/css">
  .admin_content_error{padding: 0px;}
</style>
<script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
  <script type="text/javascript">
     $(document).ready(function(){
        $('.datep').datepicker({
            todayHighlight:true
          });
    });

     function check_pos_daily(loc_id){
        window.location.href='<?php echo base_url("admin/expense/today_sale/");?>'+ encodeURIComponent(loc_id);
     }

     


     /* function check_pos_daily(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var data = 'start_date='+ encodeURIComponent(start_date) + '&end_date='+ encodeURIComponent(end_date); 
        
         $.ajax({
          type: 'POST',
          url: site_url + 'admin/Expense/export_sale_csv',
          data:data,
          datatype: 'json',
          beforeSend: function() {
          },
          success: function(data)
          {
            data = JSON.parse(data);
           // alert(data.status.open_cash);
            if(data.status == 'failed'){
               $("#btn_disable").removeClass('disabled');
                $("#open_cash").val(' ');
                
            }else{
              $("#btn_disable").addClass('disabled');
              $("#open_cash").val(data.status.open_cash);
            }
          }
        });
    }*/
    
    
</script>
<?php $this->load->view('admin/common/footer'); ?>