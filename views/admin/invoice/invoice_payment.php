<?php $this->load->view('admin/common/header'); ?>


<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
 
<body class="animsition app-contacts page-aside-left">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <?php $this->load->view('admin/common/left_menubar'); ?>
  <script src="<?php echo base_url('assets/global/js/Plugin/more-button.js');?>"></script>
        <script src="<?php echo base_url('assetsglobal/js/Plugin/loading-button.js');?>"></script>
  <!-- Page -->
  <style type="text/css">
  #radioBtn .notActive{
    color: #3276b1;
    background-color: #fff;
}

.alert-success {
    background-color: #e0f8ea!important;
    border-color: #bcf0d0!important;
    color: #229858!important;
}.alert-warning {
    background-color: #fcf8e3!important;
    border-color: #fbeed5!important;
    color: #c09853!important;
}
.alert {
    padding: 8px 35px 8px 14px;
    margin-bottom: 24px;
    text-shadow: none;
    border: none;
    border-left: 5px solid #fbeed5;
    border-radius: 0;
}
  </style>
  <div class="page">
    
    <!-- Contacts Content -->
    <div class="page-main">
      <div class="page-content">
        <div class="panel">
          <!-- Contacts Content Header -->
          <div class="panel-heading">
            <h1 class="panel-title">All Invoices</h1>
            <div class="page-header-actions"><a href="<?php echo base_url('admin/invoice/create');?>"><button type="button" class="btn btn-block btn-primary">Create Invoice </button></a></div>
          </div>
          <!-- <div class="page-header">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  role="tab">Invoices</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link"  href="<?php echo base_url('admin/report');?>">Reports</a></li>
            </ul>
            <div class="page-header-actions">
              
            </div>
          </div> -->
          <!-- Contacts Content -->
          <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
           <?php //gs($_SESSION['invoice_data']['is_vouchar_purchased']);die; ?>
            <div class="container">
              <div class="alert alert-success">
                <h3 style="margin-top: 0;color: #229858;font-weight: 500;">Invoice #<?=$invoice_data['invoice_number']?> created successfully</h3>
                <!-- <a href="#" class=""><i class="fa fa-external-link">&nbsp;</i>View invoice</a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" class="manual-modal" data-modal-class="modal"><i class="fa fa-envelope">&nbsp;</i>Email invoice</a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" class="manual-modal" data-modal-class="modal"><i class="fa fa-print">&nbsp;</i>Print invoice</a>
                &nbsp;&nbsp;&nbsp; -->
              </div>
              <?php if(isset($invoice_data['is_vouchar_purchased']) && $invoice_data['is_vouchar_purchased']==1): ?>
              <div class="alert alert-warning">
                <h3 style="margin-top: 0;color: #c09853;font-weight: 500;">Your gift voucher is not yet able to be used</h3>
                <p>The gift voucher cannot be used until it is activated. Gift vouchers are activated when the associated invoice is fully paid. Apply a payment using the options below to finish activating this gift voucher.</p>
              </div>
            <?php endif ?>

              <h3>Apply a payment now:</h3>
              <b style="color: #000;font-size: 15px;">The invoice total is <?=$invoice_data['total_price']?> $ and the amount outstanding is <?=$invoice_data['outstanding_invoice_amount']?> $</b><br><br>
              <form method="post" onsubmit="return validateForm()">
                <input type="hidden" name="action" value="save">
                <input type="hidden" value="<?=$invoice_data['id'] ?>" name="invoice_id">
                <input type="hidden" value="<?=$invoice_data['total_price'] ?>" id="total_price" name="total_price">
                <input type="hidden" value="<?=$invoice_data['outstanding_invoice_amount'] ?>" name="outstanding_invoice_amount">
                <input type="hidden" value="<?=$invoice_data['business_id'] ?>" name="business_id">
                <input type="hidden" value="<?=$invoice_data['location_id'] ?>" name="location_id">
                <input type="hidden" value="<?=$invoice_data['customer_id'] ?>" name="customer_id">



                  <div class="form-group">
					 
					<div class="form-group">
            <label><b>Choose payment type</b></label>
					  <div class="input-group">
						<div id="radioBtn" class="btn-group">
              <?php foreach ($payment_types as $key => $value) {
               ?>

                 <a class="btn btn-primary btn-sm notActive" data-toggle="payment_type_id" data-title="<?php echo $value['id'] ?>"><?php echo $value['name'] ?> </a>
            <?php  } ?>
						 
								<!-- 	<a class="btn btn-primary btn-sm notActive" data-toggle="fun" data-title="X">CARD</a>
						  <a class="btn btn-primary btn-sm notActive" data-toggle="fun" data-title="N">VOUCHER</a>
						  <a class="btn btn-primary btn-sm notActive" data-toggle="fun" data-title="C">CREDIT</a> -->
						</div>
						<input type="hidden" name="payment_type_id" id="payment_type_id" readonly>
					  </div>
            <div class="alert alert-danger payment_alert ">
             please Choose payment type
          </div>

           <div class="wallet_alert ">
          <h4>  Your Wallet Amount is <?=getcustomerIdByCustomerWallet($invoice_data['customer_id']); ?> $ </h4>
          </div>

					</div>

				  </div>
              <!-- <div class="form-group row">
                <div class="col-md-4">
                  <label><b>Choose payment type</b></label>
                  <?php $i=1; foreach ($payment_types as $key => $value): 
							if($i==1){
								$checked = "checked";
							}else{
								$checked ="";
							}
							
				  ?>
					<div class="custom-control custom-radio">
					  <input type="radio" class="custom-control-input" id="defaultChecked<?php echo $i;?>" name="payment_type_id" <?php echo $checked; ?> value="<?=$value['id']?>">
					  <label class="custom-control-label" for="defaultChecked<?php echo $i;?>"><?=$value['name']?></label>
					</div>
          <?php $i++; endforeach ?>
            </div>
              </div> --> 
					
                     
                <!--   <select required="required" name="payment_type_id" class="form-control" data-plugin="select2" data-placeholder="Please Select">
                    <option value=""></option>
                    <?php foreach ($payment_types as $key => $value): ?>
                      <option value="<?=$value['id']?>"><?=$value['name']?></option>
                    <?php endforeach ?>
                  </select> -->
                   <input type="hidden" value="<?=$invoice_data['customer_id'] ?>" name="customer_id">


                
                  <?php if($invoice_data['total_price']>0){ ?>
                    <div class="form-group row">
                <div class="col-md-2">    
                    <label><b>Enter Amount</b></label>
                  <input  type="text" class="form-control" value="<?=$invoice_data['total_price'] ?>" id="paid_amount" name="paid_amount" required="required">
                </div>
              </div>
                <?php }else{ ?>
                    <input required="required" type="hidden" class="form-control" value="<?=$invoice_data['total_price'] ?>" name="paid_amount">
                <?php } ?>
              <div class="form-group row">
                <div class="col-md-4">
                  <label><b>Payment processed by</b></label>
                  <select required="required" name="staff_id" id="staff_id" class="form-control" data-plugin="select2" data-placeholder="Payment processed by">
                    <option value=""></option>
                    <?php foreach ($staff_data as $key => $value): 
                      $selected = ($default_staff==$value['id'])?"selected":"";
                      ?>
                      <option <?=$selected;?> value="<?=$value['id']?>"><?= $value['first_name']." ".$value['last_name']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                  <label><b>Referances (Optional)</b></label>
                  <textarea class="form-control" name="notes" rows="3"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <a href="<?=base_url('admin/invoice')?>" class="btn btn-default btn-block">Cancel</a>
                </div>
                <div class="col-md-3">
                      <button class="btn btn-success btn-block" id="submit" type="submit">Save</button>
                </div>
                <div class="col-md-6"></div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
     $('.wallet_alert').hide();
  $('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);

    
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
    if (sel==9) {
      $('.wallet_alert').show();
    }
    else{
      $('.wallet_alert').hide();

    }


    $('#submit').show();
    $('.payment_alert').hide();
  });
  </script>

  <script type='text/javascript'>

    $(function(){
       $('.payment_alert').hide();
        $('#staff_id').change(function() {
            var payment_type_id = $('#payment_type_id').val();
            if (payment_type_id=='') {
              $('#submit').hide();
               $('.payment_alert').show();
              
            }
            else{
              $('.payment_alert').hide();
              $('#submit').show();
            }
        });
    });
function validateForm(){
  var payment_type_id = $('#payment_type_id').val();
  var total_price = $('#total_price').val();  
   var paid_amount = $('#paid_amount').val();
   var wallet_row = <?php echo $wallet_row ?>;
   var wallet_amount= <?=getcustomerIdByCustomerWallet($invoice_data['customer_id'])?>;
   if (wallet_row>0 && paid_amount<total_price ) {
       swal("Error!", "There should be no outstanding while adding amount to wallet. ", "error");
     $('#submit').show();
      return false;
    }
  
    if (payment_type_id=='') {
      $('#submit').hide();
       $('.payment_alert').show();
      return false;
    }
    else{
      $('.payment_alert').hide();
      $('#submit').hide();
    }


    if (payment_type_id==9 && paid_amount>wallet_amount) {
      swal("Error!", "Your amount greater than wallet amount ", "error");
     $('#submit').show();
      return false;

    }
    
   
}
</script>
  <!-- <script type="text/javascript">
     $(function() {
   
    $('#staff_id').change(function(){
      $.each($('input'),function(i,val){
    if($(this).attr("type")=="hidden"){
        var valueOfHidFiled=$(this).val();
        alert(valueOfHidFiled);
    }
});
        
    });
});

  </script> -->
  <!-- End page -->
  <?php $this->load->view('admin/common/footer'); ?>