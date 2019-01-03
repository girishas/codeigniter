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
             <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/today_sale');?>">Today Position</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" role="tab" href="<?php echo base_url('admin/expense/close_register');?>">Close Register</a></li> 
              <li class="nav-item" role="presentation"><a class="nav-link " href="<?php echo base_url('admin/expense/all_expenses');?>">Expense</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_pos_category');?>">Pos Category</a></li>
             <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo base_url('admin/expense/all_vendors');?>">Vendor</a></li>
              
            </ul> -->

            <?php $this->load->view('admin/common/expense_menu'); ?>
    </div>
   
   
      <div class="page-content container-fluid">
         <form autocomplete="off" method="post">
                <input type="hidden" name="action" value="save">
              <?php if($admin_session['role']=="business_owner" or $admin_session['role']=="owner"){?>
              
                    <div class="col-md-6" id="location_section">
                      <div class="form-group" data-plugin="formMaterial">
                      <label class="form-control-label" for="inputGrid2">Choose Branch Location*</label>
                       <?php if(isset($open_date)) {
                         foreach ($open_date as $open_date_id) {
                             $location_id = (isset($location_id) && $location_id!='')?$location_id:$open_date_id['location_id']; 
                          } 
                       } 
                        else { $location_id = (isset($location_id) && $location_id!='')?$location_id:''; }?>
                       <span id="content_location_id">
                         <select class="form-control" name="location_id" id="location_id" onChange="close_pos_daily(this.value)">
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
                
        <div class="row">
          <div class="col-md-12">
            <!-- Panel Static Labels -->
            <div class="panel">
  <?php if(isset($today_pos)){ ?>
              <div class="panel-heading">
                <h3 class="panel-title">Close Register (<?php if(isset($today_pos)){echo($today_pos['open_date']); }else{echo 'N/a'; }?> - <?php echo(date('Y-m-d H:i:s')); ?>)</h3> 
              </div>
              
              <?php if(isset($success)){
                       $disabled = 'disabled';
                    }else{
                      
                        $disabled = '';
                    }?>

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
                    <td style="width:20%;"><?php if(isset($credit_card_payment)){echo number_format($credit_card_payment,2); }else{echo 'N/a'; }?></td>
                  </tr>
                  <tr>
                    <td style="width:80%;">Gift Card Payment:</td>
                    <td style="width:20%;"><?php if(isset($gift_card_payment)){echo number_format($gift_card_payment,2); }else{echo 'N/a'; }?></td>
                  </tr>

                   <tr>
                    <td style="width:80%;">Wallet Payment:</td>
                    <td style="width:20%;"><?php if(isset($wallet_payment)){echo number_format($wallet_payment,2); }else{echo 'N/a'; }?></td>
                  </tr>

                  <tr>
                    <td style="width:80%;"><strong>Total Sales:</strong></td>
                    <td style="width:20%;"><?php if(isset($total_sales)){echo number_format($total_sales,2); }else{echo 'N/a'; }?></td>
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
                 



                <!--   <tr>
                    <td style="width:80%; border: 0px;">Other Expenses:</td>
                    <td style="width:20%; border: 0px;"><?php if(isset($today_total_expenses)){echo number_format($today_total_expenses[0]['total'],2); }else{echo 'N/a'; }?></td>
                  </tr> -->
                  <tr>
                    <td style="width:80%;"><strong>Total Cash in Hand:</strong></td>
                    <td style="width:20%;"><?php if(isset($total_cash)){echo number_format($total_cash,2); }else{echo 'N/a'; }?></td>
                  </tr>

                     <tr>
                    <td style="width:80%;border: 0px;"><strong>* Voucher Sale:</strong></td>
                    <td style="width:20%;border: 0px;"><?php if(isset($total_voucher)){echo number_format($total_voucher,2); }else{echo 'N/a'; }?></td>
                  </tr>
				   <tr>
                    <td style="width:80%;border: 0px; color: red;"><strong>* Outstanding:</strong></td>
                    <td style="width:20%;border: 0px;"><?php if(isset($total_outstanding['total_outstanding_invoice_amount'])){echo number_format($total_outstanding['total_outstanding_invoice_amount'],2); }else{echo 'N/a'; }?></td>
                  </tr>
                </tbody>
              </table>
  
            <!-- End Panel Static Labels -->
          </div>
              <div class="form-group  row" data-plugin="formMaterial">
                <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid1"><strong>Total Cash*</strong></label>
                    <input type="text" class="form-control datep" name="total_cash" value="<?php if(isset($total_cash)){echo number_format($total_cash,2); }else{echo 'N/a'; }?>" readonly>
                 </div>

                <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid1"><strong>Total Credit Card Slips*</strong></label>
                    <input type="text" class="form-control datep" name="total_cc_slip" value="<?php if(isset($cc_slip)){echo $cc_slip; }else{echo 'N/a'; }?>" readonly>
                 </div>
              </div>

              <div class="form-group  row" data-plugin="formMaterial">
                <div class="col-md-6">
                    <label class="form-control-label" for="inputGrid1"><strong>Total Cheques*</strong></label>
                    <input type="text" class="form-control datep" name="total_cheque" value="<?php if(isset($cheque_payment_slip)){echo $cheque_payment_slip; }else{echo 'N/a'; }?>" readonly>
                 </div>
              </div>
              <div class="form-group  row" data-plugin="formMaterial">
                <div class="col-md-12">
                    <label class="form-control-label" for="inputGrid1"><strong>Note</strong></label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php if(isset($today_pos['notes'])) echo $today_pos['notes']; ?></textarea>
                 </div>
              </div>
              <div class="form-group row" data-plugin="formMaterial">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                     <?php if(isset($today_pos) and $today_pos['is_closed'] == '1'){ ?>
                     
                      <button class="btn btn-primary disabled" data-dismiss="modal" type="submit" style="float:right">Close Register</button>
                    <?php  }else{ ?>
                       <button class="btn btn-primary" data-dismiss="modal" type="submit" style="float:right">Close Register</button> 
                    <?php } ?>
                    </div>   
                    <?php }else{ ?>
          <div class="panel-heading">
               <div style="width:100%;float:left;text-align:center;">No Record found</div>
           </div> 
  <?php } ?>                 
                  </div>



         
          </div>
        </div>
      </div>
    </form>
    </div>
    </div>
      </div>
    </div>
    <!-- End Page -->
  <!-- End page -->
<style type="text/css">
  .admin_content_error{padding: 0px;}

  .disabled{    color: #060606 !important;
    background-color: #E1E4E5!important;
    border-color: #E1E4E5 !important;
    pointer-events: none;

</style>
<script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
  <script type="text/javascript">
    function close_pos_daily(loc_id){
        window.location.href='<?php echo base_url("admin/expense/close_register/");?>'+ encodeURIComponent(loc_id);
     }
    
</script>
<?php $this->load->view('admin/common/footer'); ?>