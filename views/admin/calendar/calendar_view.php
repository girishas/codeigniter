<?php $this->load->view('admin/common/header'); ?>
<link href="<?php echo base_url('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/jquery-ui/jquery-ui.min.css');?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('global/vendor/bootstrap-sweetalert/sweetalert.min.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/selectbox_isd_code/build/css/intlTelInput.css');?>">
<link rel="stylesheet" href="<?php echo base_url('global/vendor/select2/select2.min.css');?>">
<style>
body {
padding-top: 0px !important;
}
.new_appoint{
font-size: 24px;
text-transform: capitalize;
font-weight: 300;
color: #fff; 
text-align:center;
background-color: #00B3F0;
margin: 0px;
padding: 10px 0px;
} 
.close {
position: absolute;
right: 32px;
color: #fff;
top: 10px;
width: 32px;
height: 32px;
opacity: 0.3;
}
.close:hover {
opacity: 1;
}
.close:before, .close:after {
position: absolute;
left: 15px;
content: ' ';
height: 28px;
width: 2px;
background-color: #333;
}
.close:before {
transform: rotate(45deg);
}
.close:after {
transform: rotate(-45deg);
}
.no-color{
color: inherit;
text-decoration: none;
}
.no-color:hover{
color: inherit;
text-decoration: none;
}
.hr{
padding: 0px;
margin-top: 10px;
margin-bottom: 0px;
}
.full-border{
border:1px solid #000;
border-radius: 50%;
width: 25px;
height: 25px;
display:inline-block;
}
.circle{
text-align: center;
margin: 25px;
}
.form-control-label{
font-family: Roboto,sans-serif;
font-weight: 400;
}
select.form-control:not([size]):not([multiple]) {
height: 3.573rem;
}
input[type=text] {
height: 3.573rem;
}input[type=email] {
height: 3.573rem;
}
.select2-selection__rendered {
line-height: 2.703rem !important;
}
.select2-selection {
height:  3.573rem !important;
}
.glassicon {
box-sizing: border-box;
border: 1px solid #ccc;
border-radius: 4px;
font-size: 16px;
background-color: white;
background-image: url('../../uploads/searchicon.png');
background-position: 10px 10px;
background-repeat: no-repeat;
padding: 12px 20px 12px 40px;
-webkit-transition: width 0.4s ease-in-out;
transition: width 0.4s ease-in-out;
background-size: 30px 30px;
margin-top: 15px;
margin-left: 18%;
width: 80%;
}
.glassicon:focus {
width: 80%;
}
.button {
border: none;
color: white;
padding: 10px 24px;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 14px;
margin: 3px 4px;
cursor: pointer;
border-radius: 25px;
float: right;
}
.button1 {
border: none;
color: white;
padding: 10px 24px;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 14px;
margin: 3px 15px;
cursor: pointer;
border-radius: 25px;
float: right;
}
.intl-tel-input{
display:block;
}
.avl_error{
background-color: #EBF5FD;
color: #2B72BD;
border:1px solid rgba(40, 131, 210, .75);
border-radius: 2px;
padding-left: 10px;
}
.service_row{
border: 1px solid #F7F7F8;
padding: 24px 24px  10px 24px;
border-radius: 3px;
box-shadow: 0 2px 5px 0 #DEE3E7;
margin-bottom: 20px;
}
.remove_row{
position: absolute;
right: 18px;
margin-top: -18px;
color: maroon;
font-size: 17px;
cursor: pointer;
}
.add-more{
padding: 10px;
box-shadow: 0 2px 5px 0 #DEE3E7;
cursor: pointer;
text-align: center;
margin-bottom: 15px;
font-size: 18px;
color: #fff;
background:-webkit-linear-gradient(right, #00dbde, #fc00ff, #00dbde, #fc00ff);
text-transform: uppercase;
}
.left_outer{
  padding:0px 80px;
  border-right: 1px solid #ddd;
  height: -webkit-fill-available;
  margin-bottom: 20px;
}
.right-outer{
  padding-top:20px;
}
.ap-status{
  padding: 30px;
  background-color: #F7F7F8;
}
</style>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12" style="padding: 0px;">
      <h2 class="new_appoint">View Appointment</h2>
      <?php $startDate= date("Y/m/d",strtotime($booking['start_date'])); ?>
      <?php $location_id= $booking['location_id']; ?>
      <?php $staff_id= $booking['staff_id']; ?>
       <?php $staff_id= $booking['staff_id']; ?>
       <?php $start_time= $booking['start_time']; ?>
      <div class="dialog">
        <a href="<?php echo base_url('admin/service/calendar?startDate='.$startDate.'&startTime='.$start_time.'&staffid='.$staff_id.'&location_id='.$location_id.'') ?>" class="close"></a>
      </div>
    </div>
  </div>
  <div class="row">
      <div class="col-md-8">
        <!-- left_outer -->
        <div class="left_outer">
          <h3 style="margin-top:0px;padding-top: 20px;"><?php echo date("l,d M Y",strtotime($booking['start_date'])); ?></h3>
          <table class="table">
            <tbody>
              <?php 
              $total_time = "00:00:00";
              $total_amt = 0;
              foreach ($booking_services as $key => $value): 
                $total_time = sum_the_time($total_time,$value['book_duration']);
                //echo "<pre>"; print_r($value); die;
				$total_amt = $total_amt+serviceprice($value['service_timing_id']);
                ?>
                <tr>
                  <td width="15%"><h4><?php echo date("h:i a",strtotime($value['book_start_time'])) ?></h4></td>
                  <td width="75%">
                    <h4><?php echo getServiceNameByTiming($value['service_timing_id']).' - '.getCaptionName($value['service_timing_id']);?></h4>
                    <p>
                      <?php 
                        $etime = explode(":",$value['book_duration']);
                        $hrs = ($etime[0]!="00")?$etime[0]."hour ":"";
                        $mns = ($etime[1]!="00")?$etime[1]."min ":"";
                        echo $hrs.$mns." with ".getStaffName($value['staff_id']);
                      ?>
                    </p>
                  </td>
                  <td width="10%"><h4>$<?php echo serviceprice($value['service_timing_id']) ?></h4></td>
                </tr>
              <?php endforeach ?>
            </tbody>
            <tfoot>
              <tr>
                <td width="15%"></td>
                <td width="75%"><h4><?php
                       $stime = explode(":",$total_time);
                        $hrs = ($stime[0]!="00")?$stime[0]."hour ":"";
                        $mns = ($stime[1]!="00")?$stime[1]."min ":"";
                        echo $hrs.$mns;
                        ?></h4></td>
                <td width="10%"><h4><?php echo "$".$total_amt ?></h4></td>        
              </tr>
            </tfoot>
          </table>
          <div><br>
            <h4>Appointment History</h4>
            <p><b>Booked by <?php echo getStaffName($booking['staff_id']) ?> with ref #<?= $booking['booking_number']?> at <?php echo date("l,d M Y",strtotime($booking['date_created'])); ?> at <?php echo date("h:ma",strtotime($booking['date_created'])); ?></b></p>
          </div>
          <?php if($booking['customer_id'] !=""){ ?>
          <div class="client_details">
               <div class="example-wrap m-xl-0">
                <div class="nav-tabs-horizontal" data-plugin="tabs">
                  <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                    <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#info"    aria-controls="info" role="tab">Info</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#invoice"    aria-controls="invoice" role="tab">Invoice</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#bookings"    aria-controls="bookings" role="tab">Bookings</a></li>                    
                    <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#history"    aria-controls="history" role="tab">History</a></li>                    
                  </ul>
                  <div class="tab-content pt-20" style="max-height: 300px;overflow-y: scroll;">
                    <div class="tab-pane active" id="info" role="tabpanel">
                      <table class="table table-bordered table-hover">
                        <tbody>
                          <tr>
                            <td class="text-nowrap">
                              Name
                            </td>
                            <td><?php echo $personal_information['first_name'].' '.$personal_information['last_name'] ?></td>
                          </tr>
                          <tr>
                            <td class="text-nowrap">
                              Uniq Number
                            </td>
                            <td><?php echo $personal_information['customer_number']; ?></td>
                          </tr>
                          <tr>
                            <td class="text-nowrap">
                              Email
                            </td>
                            <td><?php echo $personal_information['email']; ?></td>
                          </tr>
                          <tr>
                            <td class="text-nowrap">
                              Mobile
                            </td>
                            <td><?php echo $personal_information['mobile_number']; ?></td>
                          </tr>
                          <tr>
                            <td class="text-nowrap">
                              Type
                            </td>
                            <td><span class="badge badge-info text-capitalize"><?php echo $personal_information['customer_type']; ?></span></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="invoice" role="tabpanel">
                      <table class="table table-bordered table-hover">
                        <thead>
                          <th>#</th>
                          <th>Invoice Number</th>
                          <th>Pay Type</th>
                          <th>Tax Price</th>
                          <th>Total Amount</th>
                          <th>Outstanding Amount</th>
                          <th>Invoice Status</th>
                          <th>Created At</th>
                        </thead>
                        <tbody>
                          <?php
                          if(count((array)$invoices)>0){
                          foreach ($invoices as $key => $value) { ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $value['invoice_number']; ?></td>
                                <td><?php echo ($value['pay_type']==1)?"Manual":"Calendar"; ?></td>
                                <td><?php echo $value['tax_price']; ?></td>
                                <td><?php echo $value['total_price_without_voucher']; ?></td>
                                <td><?php echo $value['outstanding_invoice_amount']; ?></td>
                                <td><span class="badge badge-info text-capitalize"><?php echo getInvoiceStatus($value['invoice_status']); ?></span></td>
                                <td><?php echo date("d M,Y",strtotime($value['date_created'])); ?></td>
                            </tr>
                          <?php } }else{?>
                          <tr>
                            <td colspan="8"><p class="text-center"><i class="fa fa-frown-o" style="font-size: 32px;" aria-hidden="true"></i><br>No Record Found</p></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="bookings" role="tabpanel">
                      <table class="table table-bordered table-hover">
                        <thead>
                          <th>#</th>
                          <th>Booking Number</th>
                          <th>Location</th>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Status</th>
                        </thead>
                        <tbody>
                          <?php
                          if(count((array)$bookings)>0){
                          foreach ($bookings as $key => $value) { ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                 <td><?php echo $value['booking_number'] ?></td>
                                <td><?php echo getLocationNameById($value['location_id']); ?></td>
                                <td><?php echo date("d M,Y",strtotime($value['start_date'])); ?></td>
                                <td><?php echo date("h:i:s a",strtotime($value['start_time'])); ?></td>
                                <td><span class="badge badge-info text-capitalize"><?php echo getBookingStatus($value['booking_status']); ?></span></td>
                            </tr>
                          <?php } }else{?>
                          <tr>
                            <td colspan="8"><p class="text-center"><i class="fa fa-frown-o" style="font-size: 32px;" aria-hidden="true"></i><br>No Record Found</p></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
					<div class="tab-pane" id="history" role="tabpanel">
                      <table class="table table-bordered table-hover">
                        <thead>
                          <th>Description</th>
                          <th>Previous</th>
                          <th>New</th>
                          <th>Time</th>
                        </thead>
                        <tbody>
						 <?php   if(count((array)$booking_logs)>0){
							foreach ($booking_logs as $key => $value) { ?>
							<tr> 
							 <td><?= $value['description']; ?></td>
							  <td><?= $value['old_data']; ?></td>
							  <td><?= $value['new_data']?></td>
							   <td><?=date('D d M Y h:i A',strtotime($value['created_at']))?></td>          
							</tr>         
						  <?php } }else{?>
                          <tr>
                            <td colspan="4"><p class="text-center"><i class="fa fa-frown-o" style="font-size: 32px;" aria-hidden="true"></i><br>No Record Found</p></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>



                </div>


              </div> 
          </div>

        <?php } ?>
     <!--   <TEXTAREA><?php echo $personal_information['first_name'].' '.$personal_information['last_name'] ?></TEXTAREA>> -->

       <div class="form-group  row" data-plugin="formMaterial">
      <div class="col-md-12">
        <label class="form-control-label" for="inputGrid2"><b>Appointments Notes</b></label>        
        <textarea class="form-control" id="description" name="description" rows="3" readonly=""><?php echo $booking['staff_notes'] ?></textarea>
        
      </div>
    </div>
     
  </div>
        </div>

      <div class="col-md-4">

          <div class="right-outer">
              <?php if($booking['customer_id']!=""){ ?>
                  <h4 style="margin-bottom: 0px;"><?php echo $personal_information['first_name'].' '.$personal_information['last_name'] ?></h4>
                  <p><b><?php echo $personal_information['email'] ?></b></p>
                  <hr class="hr">
              <?php } ?>
               <?php if(!isset($booking_invoices)): ?> 
              <div class="ap-status">
                  <?php $status_array = array(1=>"New (Open)",6=>"Confirmed",8=>"Re-Confirmed",5=>"Arrived",7=>"Start Service",3=>"Completed",4=>"No Show",2=>"Cancel");?>
                <select class="select form-control" onchange="updateBookingStatus('<?=$booking['id']?>',this.value)">
                    <?php foreach ($status_array as $key => $value): 
                      $selected = ($key==$booking['booking_status'])?"selected":"";
                      ?>
                      <option <?=$selected?> value="<?=$key?>"><?=$value?></option>
                    <?php endforeach ?>
                  </select>
              </div>
            <?php endif; ?>
              <h3 class="text-center">Total : $<?=$total_amt?>&nbsp;( <?php
                //echo $stime;
                $stime = explode(":",$total_time);
                $hrs = ($stime[0]!="00")?$stime[0]."hour ":"";
                $mns = ($stime[1]!="00")?$stime[1]."min ":"";
                echo $hrs.$mns;?>)
              </h3>
               <?php if(isset($booking_invoices) and $booking_invoices['outstanding_invoice_amount']>0): ?>
              <h4 class="text-center"><span class="badge badge-warning">$<?=$booking_invoices['outstanding_invoice_amount'];?>&nbsp;Unpaid</span></h4>
            <?php endif; ?>
              <hr class="hr">
              <?php
              if(isset($booking_invoices) && $booking_invoices['outstanding_invoice_amount']==0):?>
                <h4 class="text-center">
                  <i class="fa fa-smile-o" aria-hidden="true" style="font-size: 48px;"></i><br>
                  Appointment Completed
                </h4>
                <p class="text-center">Full payment received.</p>
               <?php endif; ?>
              <?php if(isset($booking_invoices)): ?>
                <div class="row">
                    <?php
                     if(!empty($invoice_payments[0]['id'])):
                    ?>
                    <h3 class="black" style="width: 100%;">Payment</h3>
                    <ul>
                        <?php 

                        foreach ($invoice_payments as $key => $value): ?>
                        <li class="black"><b><?=date("d M Y",strtotime($value['paid_date']));?>&nbsp;|&nbsp;$<?=$value['paid_amount']?>&nbsp;|&nbsp;<?=getPayType($value['payment_type_id'])?></b></li>
                        <?php endforeach ?>
                    </ul>
                    <?php endif ?>
                </div>
              <?php endif; ?>  
              <div>
                 <div class="example example-buttons">
                  <div class="row">
                   <?php if(!isset($booking_invoices)): ?>  
                  <div class="col-md-4">
                   <a class="btn btn-danger btn-block" href="<?php echo base_url('admin/service/calendar_edit/'.$booking['id']); ?>" role="menuitem">EDIT </a> 
                  </div>

                   <div class="col-md-4">
                   <a class="btn btn-success btn-block" href="<?php echo base_url('admin/service/calendar?&booking_id='.$booking['id']); ?>" role="menuitem">RE-BOOK</a> 
                  </div>

                  <?php else: ?>
                     <div class="col-md-4">
                    <a class="btn btn-success btn-block" href="<?php echo base_url('admin/invoice/ViewInvoice/'.$booking_invoices['id']); ?>" role="menuitem">View Invoice</a> 
                  </div>
                 <?php endif ?>
                    <?php if(!isset($booking_invoices)): ?>  
                    <div class="col-md-4">
                      <a href="<?php echo base_url('admin/invoice/create/'.$booking['id']); ?>" class="btn btn-info btn-block">CHECKOUT</a>
                    </div>
                    <?php if ($total_reference_booking_id==0) { ?>
                     <div class="col-md-4">
                      <a href="<?php echo base_url('admin/invoice/create/'.$booking['id'].'/'.'1/'.$total_amt); ?>" class="btn btn-primary btn-block">ADVANCE</a>
                      
                    </div>
                   <?php } ?>
                     
                    <?php elseif(isset($booking_invoices) && $booking_invoices['outstanding_invoice_amount']>0): ?>
                      <div class="col-md-6">
                      <a href="<?php echo base_url('admin/invoice/ViewInvoice/'.$booking_invoices['id']); ?>" class="btn btn-info btn-block">CHECKOUT</a>
                    </div>
                  <?php endif; ?>
                  </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready( function() {
  $('#bookingLogs').dataTable({
        "pageLength": 3,
        "paging": true,
        
  });

});
</script>
<script src="<?php echo base_url('global/vendor/babel-external-helpers/babel-external-helpers.js');?>"></script>
<script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
<script src="<?php echo base_url('global/vendor/popper-js/umd/popper.min.js');?>"></script>
<script src="<?php echo base_url('global/vendor/bootstrap/bootstrap.js');?>"></script>
<script src="<?php echo base_url('assets/jquery-ui/jquery-ui.min.js');?>""></script>
<script src="<?php echo base_url('global/vendor/select2/select2.min.js');?>"></script>
<script src="<?php echo base_url('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js');?>"></script>
<script src="<?php echo base_url('assets/selectbox_isd_code/build/js/intlTelInput.js');?>"></script>
<script src="<?php echo base_url('assets/selectbox_isd_code/build/js/intlTelInput.js');?>"></script>
<script src="<?php echo base_url('global/vendor/bootstrap-sweetalert/sweetalert.min.js');?>"></script>
<script data-pace-options='{ "ajax": true }' src="<?php echo base_url('global/js/pace.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/common.js');?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.select').select2();
});

function updateBookingStatus(booking_id,status){
  Pace.restart();
  $.ajax({
      type: 'POST',
      url: site_url + 'admin/service/updateBookingStatus/',
      data:{
        booking_id:booking_id,status:status
      },
      beforeSend:function(){
      swal({
      title: "",
      text: "",
      showCancelButton:false,
      showConfirmButton:false,
      imageUrl: site_url+'global/images/Rolling.gif'
      });
    },
      success: function(data)
      {
        var data =  JSON.parse(data);
        if(data.type=="success"){
          swal("Success","Appoint set to "+data.status,"success");
        }else{
          swal("Error","Status could not be updates, Please try again","error");
        }
      }
    });
}  
</script>


</body>
</html>