<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>  
  <!-- Page -->
 <!-- Page -->
    <div class="page">
   <?php $this->load->view('admin/common/header_messages');
  ?>
   
   
    <div class="page-header"> 
         
    </div>
   
   
      <div class="page-content container-fluid">
        <div class="row">
          <div class="col-md-12">

            <?php //gs($invoice_payments); ?>
            <!-- Panel Static Labels -->
            <div class="panel">
              <div class="panel-heading">
                <h3 class="panel-title">Refund</h3> 
              </div>
        
        
        
              <div class="panel-body container-fluid">
                <div class="row">
                            <div class="col-md-12">
                              <?php //<!--  <?php paid:$invoice_payments[0]['paid_amount']; date("d M",strtotime($invoice_payments[0]['paid_date'])); //getPayType($invoice_payments[0]['payment_type_id'])?> 
                                <h3>Summary (Invoice no:<?=$invoice_data['invoice_number'];?> paid: <?=$invoice_payments[0]['paid_amount'];?> on <?=date("d M",strtotime($invoice_payments[0]['paid_date']));?> by <?=getPayType($invoice_payments[0]['payment_type_id'])?>)</h3>
                            </div>
                </div>

                <br>
                    <br>    
                <form autocomplete="off" action="" method="post" enctype="multipart/form-data" >
                   <input type="hidden" name="action" value="save"> 
                   <!-- <div class="row">
                  <?php if($admin_session['role']=="owner"){?>
                  <div class="col-md-6">
                    <div class="form-group" data-plugin="formMaterial">
                              <label class="form-control-label" for="inputGrid1">Business*</label>                      
                    <select class="form-control" name="business_id" id="business_id" onChange="return get_business_locations(this.value)">
                    <option value="">Select Business</option>
                       <?php if($all_business){?>
                       <?php foreach($all_business as $business){?>
                       <option value="<?php echo $business['id'];?>" <?php if(isset($business_id) && $business_id==$business['id']) echo "selected"; ?>><?php echo $business['name'];?></option>
                       <?php } } ?>
                  </select>
                  <div class="admin_content_error"><?php echo form_error('business_id'); ?></div>
                            </div>
                </div>
          <?php } ?>
          <?php if($admin_session['role']=="business_owner" or $admin_session['role']=="owner"){ ?>
                    <div class="col-md-6" id="location_section">
                      <div class="form-group" data-plugin="formMaterial">
                      <label class="form-control-label" for="inputGrid2">Location*</label>
                       <span id="content_location_id">
             <select class="form-control" name="location_id" id="location_id">
              <option value="">Select Location</option>
            <?php if(isset($locations)){ ?>
            <?php foreach($locations as $loc){?>
              <option value="<?php echo $loc['id'];?>" <?php if(isset($location_id) && $location_id==$loc['id']) echo "selected"; ?>><?php echo $loc['location_name'];?></option>
            <?php } } ?>
             </select>
            </span>
            <div class="admin_content_error"><?php echo form_error('location_id'); ?></div>
                    </div>
                </div>
          <?php } ?>
        </div> -->
        <div class="form-group  row" data-plugin="formMaterial">
         <?php if($admin_session['role']=="business_owner" or $admin_session['role']=="owner" or $admin_session['role']=="location_owner"){ ?>

                    <div class="col-md-6" id="location_section">
                      <div class="form-group" data-plugin="formMaterial">
                      <label class="form-control-label" for="inputGrid2">Staff*</label>
                       <span id="staff_id">
                       <select class="form-control" name="staff_id" id="staff_id">
                        <option value="">Select Staff</option>
                        <?php foreach ($staff_data as $key => $value): ?>
                                <option value="<?=$value['id']?>" <?php if(isset($staff_id) && $staff_id==$value['id']) echo "selected"; ?>><?= $value['first_name']." ".$value['last_name']; ?></option>
                                <?php endforeach ?>
                       </select>
                       <div class="admin_content_error"><?php echo form_error('staff_id'); ?></div>
                      </span>
                     
                              </div>
                          </div>
                    <?php } ?>

        </div>
        <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <div class="form-group">
                            <label><b>Refund Amount</b></label>
                            <input type="text" class="form-control" value="<?php if(isset($refund_amount)){ echo $refund_amount; } ?>" name="refund_amount" id="refund_amount" >
                            <div class="admin_content_error"><?php echo form_error('refund_amount'); ?></div>
                        </div>
                        <div class="admin_content_error" id="amount_error">Refund amount cannot be greater than paid amount</div>
                          <input type="hidden" class="form-control" value="<?php echo $invoice_payments[0]['paid_amount'] ?>" name="paid_amount" id="paid_amount" >

                        
                               
                    </div>
                             
                    
                      <div class="col-md-6" id="location_section">
                      <div class="form-group" data-plugin="formMaterial">
                      <label class="form-control-label" for="inputGrid2">Payment Refund Type*</label>
                       <span id="content_location_id">
                       <select class="form-control" name="payment_type" id="payment_type">
                        <option value="">Select Payment type</option>
                        
                        <?php foreach ($payment_types as $key1 => $value1): ?>
                                <option value="<?=$value1['id']?>"<?php if(isset($payment_type) && $payment_type==$value1['id']) echo "selected"; ?>><?= $value1['name'];?></option>
                                <?php endforeach ?>
                       </select>
                      </span>
                      <div class="admin_content_error"><?php echo form_error('payment_type'); ?></div>

                       <div class="admin_content_error" id="payment_type_alert">
                        <h5>  Your Wallet Amount is <?=getcustomerIdByCustomerWallet($invoice_payments[0]['customer_id']);?> $ </h5>
                         
                         
                       </div>

                              </div>
                         
                  </div>
                </div>

                <div class="form-group  row" data-plugin="formMaterial"> 
                <?php foreach ($invoice_services as $key => $value) { 
                  if ($value['pay_service_type']==4) {
                  
                  ?>
                  <div class="col-md-6">        
              <div class="checkbox-custom checkbox-info">
                          <input type="checkbox" id="product_id" name="product_id[]" value="<?=$value['product_id']?>" autocomplete="off">
                          <label class="form-control-label" > <?php
                          if ($value['pay_service_type'] == 1) {
                            echo $payServiceTypeValue = payServiceType($value['pay_service_type']).' - '.getServiceNameByTiming($value['service_timing_id']).' '.$value['caption'];
                          }

                          elseif ($value['pay_service_type'] == 2 && $value['service_timing_id']>1) {

                             $payServiceTypeValue =  payServiceType($value['pay_service_type']);
                                                $ServiceName = getServiceNameByTiming($value['service_timing_id']).' '.$value['caption'];
                                                echo  $payServiceTypeValue.' - '.$ServiceName;


                          }elseif ($value['pay_service_type'] == 3 ) {
                                                 $payServiceTypeValue =  payServiceType($value['pay_service_type']);
                                                $packageName = getPackageName($value['package_id']);
                                                echo  $payServiceTypeValue.' - '.$packageName;
                                            }elseif ($value['pay_service_type'] == 4 ) {
                                                 $payServiceTypeValue =  payServiceType($value['pay_service_type']);
                                                $ProductName = getProductName($value['product_id']);
                                                echo  $payServiceTypeValue.' - '.$ProductName;
                                            }else{
                        echo $payServiceTypeValue =  payServiceType($value['pay_service_type']);
                      }

                           ?>                         

                         </label>
                        </div>
                      </div>
                      <?php }?>
                      <?php }?>
                    </div>

               
              
       


                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-12">
                      <label class="form-control-label" for="inputGrid1">Reason</label>
                      <textarea class="form-control" name="notes" rows="3"><?php if(isset($notes)){ echo $notes; } ?></textarea>
                      <div class="admin_content_error"><?php echo form_error('notes'); ?></div>
                    </div>
                  </div>
                  <div class="form-group  row" data-plugin="formMaterial">
                    <div class="col-md-6">
                      <button class="btn btn-primary" id="submit" data-dismiss="modal" type="submit">Save</button>
                    </div>
                    
                  </div>
          
                </form>
              </div>
            </div>
            <!-- End Panel Static Labels -->
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

<?php $this->load->view('admin/common/footer'); ?>
<script type="text/javascript">

  $(document).ready(function () {
    $("#amount_error").hide();
     $("#payment_type_alert").hide();

     $("#payment_type").on("change", function () {
       var payment_type = $('#payment_type').val();
       if (payment_type==9) {
         $("#payment_type_alert").show();

       }
       else{
        $("#payment_type_alert").hide();
       }
      
     
     });

    $("#refund_amount").on("blur", function () {
    var refund_amount = parseFloat($('#refund_amount').val()); 
    var paid_amount = parseFloat($('#paid_amount').val()); 
    if (refund_amount > paid_amount) {
        //alert('Refund amount cannot be greater than paid amount');       
        $("#amount_error").show();
        $("#submit").hide();
        
        return false;
    }
    else
    {
      $("#amount_error").hide();
      $("#submit").show();
        return true;
    }
});
  
});


</script>