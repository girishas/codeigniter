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
  color: #00B3F0;
  border:1px solid #00B3F0;
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
  color: #333;
  text-transform: capitalize;
  border-bottom: 2px solid #00B3F0;
}
.extra_time_before{
    margin-bottom: 15px;
    font-size: 18px;
    color: #00B3F0;
}
.create_client{
  color: grey;  
}
.create_client:hover{
  text-decoration: none;
  color: #00B3F0;
}
.total{
  margin-top: 27px;
}
</style>
<?php $get_hours_range = get_hours_range();
?>
<body>
  <div class="container">
    <div class="row"><div class="col-md-12" style="padding: 0px;">
      <h2 class="new_appoint">Edit Appointment</h2>
       <?php $startDate= date("Y/m/d",strtotime($booking['start_date'])); ?>
      <?php $location_id= $booking['location_id']; ?>
      <?php $staff_id= $booking['staff_id']; ?>
       <?php $staff_id= $booking['staff_id']; ?>
       <?php $start_time= $booking['start_time']; ?>
         <input type="hidden" id="startDate" class="startDate" value="<?php echo date("Y-m-d",strtotime($booking['start_date'])); ?>">

      <div class="dialog">
        <a href="<?php echo base_url('admin/service/calendar?startDate='.$startDate.'&startTime='.$start_time.'&staffid='.$staff_id.'&location_id='.$location_id.'') ?>" class="close"></a>
      </div>
    </div>
  </div>
  <div class="row">
    <p style="width: 100%;text-align: center;margin-top: 15px;font-size: 18px;">Use the search to add a client, or keep empty to save as walk-in.</p>
  </div>
  <div class="row">
    <div class="col-md-6">
      <input id="birds" type="text" class="glassicon" name="search" placeholder="Add Client..">
    </div>
    <div class="col-md-2" style="margin-top: 2%;">
      <a href="javascript:void(0);" class="create_client" onclick="client_form();"><strong><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Create new Client</strong></a>
    </div>
    <div class="col-md-4">
      <div class="row ">
        <h4 class="total">Total : $<span class="appointment_total">0</span> <span class="total_hrs"></span></h4>
      </div>
    </div>
  </div>
  <div class="clientform" style="display:none; margin-top:0px;">
    <div class="row">
       <p style="width: 100%;text-align: center;margin-top: 15px;font-size: 18px;">Client Detail</p>
    </div>
    <div class="row" style="margin-left: 100px; margin-right: 100px;">
      <div class="col-md-12" style="background-color: #c9d5da54;box-shadow: 0 0 4px #DEE3E7;padding: 15px 15px 15px 15px;">
        <div class="row" style="float: right;">
          <a href="javascript:void(0);" onclick="closeclientdetail();" style="color: #000;"><i class="fa fa-close" style="font-size:24px;    margin-right: 10px;"></i></a>
        </div>
        <form id="client_form" onsubmit="return addNewClient()">
        <div class="row" style="padding-top: 25px;">
          <div class="col-md-6">
            <div class="form-group" data-plugin="formMaterial">
              <label class="form-control-label" for="inputGrid2">First Name*</label>
              <input type="text" required="required" class="form-control" name="first_name" autocomplete="off">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" data-plugin="formMaterial">
              <label class="form-control-label" for="inputGrid2">Last Name*</label>
              <input type="text" required="required" name="last_name" class="form-control" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group" data-plugin="formMaterial">
              <label class="form-control-label" for="inputGrid2">Email*</label>
              <input type="email" required="required" class="form-control" name="email" autocomplete="off">
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-control-label" for="inputGrid1">Mobile Number*</label>
            <div><input id="demo" type="text" required="required" class="form-control" value="" name="mobile">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="float col-md-12">
          <button class="button" type="submit" style="background-color: #26C6DA; ">Save</button>
          <button class="button" onclick="closeclientdetail()">Cancel</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<form method="post" action="<?= base_url('admin/service/calendar_edit/'.$booking['id'])?>">
  <input type="hidden" name="action" value="action">
  <input type="hidden" name="calendar_staff" value="<?php echo $booking['staff_id'] ?>">
<div class="row client_details" style="margin-left: 100px; margin-right: 100px;margin-top:15px;">
  <?php if($booking['customer_id'] !=""){ ?>
          <input type="hidden" name="customer_id" class="customer_id" value="<?=$personal_information['id']?>">
<div class="col-md-12">
  <div class="example-wrap m-xl-0">
    <div class="nav-tabs-horizontal" data-plugin="tabs">
      <ul class="nav nav-tabs nav-tabs-line" role="tablist">
        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#info"    aria-controls="info" role="tab">Info</a></li>
        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#invoice"    aria-controls="invoice" role="tab">Invoice</a></li>
        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#bookings"    aria-controls="bookings" role="tab">Bookings</a></li>
        <div class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" id="exampleColorDropdown2"
              data-toggle="dropdown" aria-expanded="false">Action</button>
            <div class="dropdown-menu dropdown-menu-primary" aria-labelledby="exampleColorDropdown2"
              role="menu">
              <a class="dropdown-item" onclick="removeFromAppointment()" href="javascript:void(0)" role="menuitem">Remove From Appointment</a>
            </div>
          </div>
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
			  <tr>
                <td class="text-nowrap">
                  Latest Note
                </td>
                <td><?php echo isset($customer_notes['notes'])?$customer_notes['notes']:"---"; ?></td>
              </tr>
            </tbody>
          </table>
		  <table class="table table-bordered table-hover">
            <tbody>
              <tr>
                <td class="text-nowrap">
                  All Booking
                </td>
                <td><span class="badge badge-info text-capitalize"><?php echo $count_all_booking['total_booking']; ?></span></td>
				<td class="text-nowrap">
                  Completed
                </td>
                <td><span class="badge badge-info text-capitalize" style="background-color: green;"><?php echo $count_all_completed['total_booking']; ?></span></td>
				<td class="text-nowrap">
                  Cancelled
                </td>
                <td><span class="badge badge-info text-capitalize" style="background-color: #FFCF00;"><?php echo $count_all_cancelled['total_booking']; ?></span></td>
				<td class="text-nowrap">
                  No Show
                </td>
                <td><span class="badge badge-info text-capitalize" style="background-color: red;"><?php echo $count_all_no_show['total_booking']; ?></span></td>
				
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
      </div>
    </div>
  </div>
</div>
        <?php } ?>
</div>
<hr class="hr">
<div class="row">
  <p style="width: 100%;text-align: center;margin-top: 15px;font-size: 18px;">Choose services </p>
</div>
<div class="row">
  <div class="col-md-1"> 
    
  </div>
  <div class="col-md-10"> 
    <div class="row">
      <div class="col-md-9" style="padding: 15px 0px; font-size: 24px;">
        <a href="javascript:void(0)" class="no-color" id="showcalendar">
          <input type="text" name="date" data-date-today-highlight="true" value="<?php echo date("l,d M Y",strtotime($booking['start_date'])); ?>" id="date_input" style="position: absolute; visibility: hidden">
          <span id="changedate" style="position: relative;"><?php echo date("l,d M Y",strtotime($booking['start_date'])); ?></span>&nbsp;&nbsp;<i class="fa fa-chevron-down" style="font-size: 16px;" aria-hidden="true"></i></a>
      </div> 
    </div>
    <input type="hidden" name="location_id" class="location_id" value="<?=$booking['location_id']?>">
    <input type="hidden" name="total_minuts" class="total_hours" id="total_hours">
    <input type="hidden" name="appointment_total_amount" class="appointment_total_amount" id="appointment_total_amount"> 
    <?php 
    $x = 1;
   // gs($booking_services);  
    foreach ($booking_services as $key => $value): 
      $etime = getExtraTime($value['service_timing_id']);
    ?>   
    <div class="row service_row append_<?=$x?>"><span class="rmrow" onclick="remove_row('<?=$x?>')"><i class="fa fa-times remove_row"></i></span>              
    <input type="hidden" name="price[]" value="<?php echo serviceprice($value['service_timing_id']); ?>" class="price" id="price_<?=$x?>">
    
      <div class="col-md-2">
        <div class="form-group" data-plugin="formMaterial">
          <label class="form-control-label" for="inputGrid2">Start Time*</label>
            <select id="start_time_<?=$x?>" class="form-control all_start_time" name="start_time[]" onChange="check_other('<?=$x?>');">
             <?php
              foreach ($get_hours_range as $kkey => $vvalue): ?>
              <option <?= ($kkey==$value['book_start_time'])?"selected":""; ?> value="<?=$kkey?>"><?= $vvalue; ?> </option>
              <?php endforeach ?>
            </select>
        </div>
      </div>
      <div class="col-md-5">
        <div class="form-group" data-plugin="formMaterial">
          <label class="form-control-label" for="inputGrid2">Service*</label>
            <select required="required" id="service_id_<?=$x?>" class="form-control select" data-plugin="select2" name="service[]" onChange="check(this.value, '<?=$x?>');">
              <option value="">Choose Service</option>
              <?php 
              //echo "<pre>"; print_r($options); exit;
              foreach ($options as $kkey => $vvalue): ?>
                    <option <?= ($vvalue['caption_id']==$value['service_timing_id'])?"selected":""; ?> value="s<?=$vvalue['caption_id']?>"><?=$vvalue['sku']?> - <?=$vvalue['service_name']?>&nbsp;»»&nbsp;<?=$vvalue['caption']?> - $<?=$vvalue['special_price']?></option>
              <?php endforeach ?>
            </select>
          <div class="staff_error_<?=$x?> avl_error"></div>
          <?php if ($value['group_service_id']>0) { ?>
            <input type="hidden" id="group_service_id_<?=$x?>" name="group_service_id[<?php echo $value['service_timing_id'];?>]" class="form-control" value="<?php echo $value['group_service_id']; ?>">
           
         <?php  } ?>


         
            

        </div>    
        <input type="hidden" value="<?php echo $etime['extra_time_mins']; ?>" id="extra_time_<?=$x?>" value="" name="extra_time_before[]" class="all_extra_time">    
      </div>
      <div class="col-md-2">
        <div class="form-group" data-plugin="formMaterial">
          <label class="form-control-label" for="inputGrid2">Duration*</label>
            <select id="duration_<?=$x?>" required="required" class="form-control all_duration" onChange="check_other('<?=$x?>'');" name="duration[]">
                  <?php echo getduration($value['book_duration']); ?>       
            </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group" data-plugin="formMaterial">
          <label class="form-control-label" for="inputGrid2">Staff*</label>
            <select class="form-control" id="staff_id_<?=$x?>" onChange="check_other('<?=$x?>');" name="staff[]">
              <?php foreach ($staff as $kkey => $vvalue): 
                $selected_staff = ($vvalue['id']==$value['staff_id'])?"selected":"";
                ?>
                <option <?=$selected_staff;?> value="<?=$vvalue['id']?>"><?php echo $vvalue['first_name'].' '.$vvalue['last_name']; ?></option>
              <?php endforeach ?>
            </select>
        </div>
      </div>    
      <div class="extra_time_before"><span class="etime_<?=$x?>">
        <?php if($etime['extra_time_after'] !="00:00:00"): 
          $tt = explode(":",$etime['extra_time_after']);
          $h = $tt[0]."h ";
          $m = $tt[1]."min ";
          if($h=="00h "){
            $h = '';
          }
          ?>
          <i class="fa fa-clock-o"></i>&nbsp;<?=$h.$m?>of extra time after
         <?php endif; ?> 
      </span></div>  
    </div>
    <?php $x++; endforeach ?>
    <div class="appendService"></div>
    <div class="row">
      <div class="col-md-12 add-more" onclick="append_row()">
        Add More <i class="fa fa-plus"></i>
       </div>
    </div>
    <div class="form-group  row" data-plugin="formMaterial">
      <div class="col-md-12">
        <label class="form-control-label" for="inputGrid2">Appointments Notes*</label>
        
        <textarea class="form-control" id="description" name="description" rows="3"><?=$booking['staff_notes']?></textarea> 
      </div>
    </div>
  </div>
</div>
<div class="row" style="margin:0 100px;float: right;">
    <button class="button" style="background-color: #00B3F0; ">Save Appontments</button>
</div>
</form>
</div>
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
<script>
$("#demo").intlTelInput();
// Get the extension part of the current number
var extension = $("#demo").intlTelInput("getExtension");
// Get the current number in the given format
var intlNumber = $("#demo").intlTelInput("getNumber");
// Get the type (fixed-line/mobile/toll-free etc) of the current number.
var numberType = $("#demo").intlTelInput("getNumberType");
// Get the country data for the currently selected flag.
var countryData = $("#demo").intlTelInput("getSelectedCountryData");
// Vali<a href="https://www.jqueryscript.net/time-clock/">date</a> the current number
var isValid = $("#demo").intlTelInput("isValidNumber");
// Load the utils.js script (included in the lib directory) to enable formatting/validation etc.
$("#demo").intlTelInput("loadUtils", "<?php echo base_url('assets/selectbox_isd_code/build/js/utils.js');?>");
// Change the country selection
$("#demo").intlTelInput("selectCountry", "AU");
// Insert a number, and update the selected flag accordingly.
$("#demo").intlTelInput("setNumber", "+61 ");
</script>
<script type="text/javascript">


$(document).ready(function() {
    $('.select').select2();
    calculate_total_price();
    calculate_total_duration();
    checkCross();

});
var x = "<?php echo count((array)$booking_services); ?>";
  function check(val, id){
    var start_date = $("#date_input").val();
    var start_time = $("#start_time_"+id).val();
   // var service_id = val;
    var service_type = val.charAt(0);    

    var service_id = val.substr(1);
    var staff_id = $("#staff_id_"+id).val();    
    var duration = $("#duration_"+id).val();
    var location_id = $(".location_id").val();    
    $("#duration_"+id).removeAttr('disabled');
    var select_start_date = $(".startDate").val(); 

// get Service timing
//alert(service_type);
if(service_type=='s'){
  //alert(service_id);
$.ajax({
      type: 'GET',
      url: site_url + 'admin/Operations/getduration/'+encodeURIComponent(service_id),
      success: function(data)
      {
        data = JSON.parse(data);
        $("#duration_"+id).html(data.duration);
        $("#price_"+id).val(data.special_price);
        $("#extra_time_"+id).val(data.extra_time_mins);
        if(data.extra_time_after !="00:00:00"){
          var myarr = data.extra_time_after.split(":");
           var h = myarr[0];         
          var m = myarr[1]; 
          if(h =="00"){
            h='';
          }else{
            h = h+'h ';
          }
          var f = h+m+'min '; 
          $(".etime_"+id).html("<i class='fa fa-clock-o'></i>&nbsp;"+f+"of extra time after");
        }else{
          $(".etime_"+id).html('');
        }
         calculate_total_price();
         calculate_total_duration();
      }
  });
}

else if(service_type=="g")
{
  $(".append_"+x).remove();
  calculate_total_price();
  calculate_total_duration();
  var staff_id = "<?php echo $booking['staff_id']; ?>";
  var location_id = "<?php echo $booking['location_id']; ?>";
  var start_time_arr = [];
  var duration_arr = [];
  var extra_time_arr = [];
   var start_time_array = document.getElementsByClassName('all_start_time');
  
 var start_time_array = document.getElementsByClassName('all_start_time');
 // console.log(start_time_array);
  for (var i = 0; i < start_time_array.length; i++){
    if(start_time_array[i].value==''){
      swal("Error","Please Choose a start Time",'error');
      return false;
    }
    start_time_arr[i] = start_time_array[i].value;

  }
  var duration_array = document.getElementsByClassName('all_duration');
  for (var i = 0; i < duration_array.length; i++){

    if(duration_array[i].value==''){ 
      duration_array[i].value=1;
      
    }
     duration_arr[i] = duration_array[i].value;
   
  }

  var extra_time_array = document.getElementsByClassName('all_extra_time');
  for (var i = 0; i < extra_time_array.length; i++){    
    extra_time_arr[i] = extra_time_array[i].value;
  }

  //alert(duration_arr);
 
$.ajax({
      type: 'POST',
      data:{ service_id:service_id,location_id:location_id,id:id,start_time:start_time,staff_id:staff_id,duration_array:duration_arr,extra_time_arr:extra_time_arr,start_time_array:start_time_arr,select_start_date:select_start_date
      },
      url: site_url + 'admin/Operations/getgroupservices/',
      success: function(data){
          $('.appendService').append(data);
        $('.select').select2();
         calculate_total_price();
         calculate_total_duration();
        /* if (x==1) {
          $("#first_id_1").remove();
         }*/

      }
  });
}


//Check Staff Available or not
if(service_id){
checkStaffAvailablity(start_time,service_id,staff_id,start_date,duration,location_id,id);
} 
}
function checkCross(){
  var total_rows = document.getElementsByClassName('service_row');  
  if(total_rows.length==1){
    $(".rmrow").fadeOut();
  }
}
function append_row(){
  //alert(x);
  var staff_id = "<?php echo $booking['staff_id']; ?>";
  var location_id = "<?php echo $booking['location_id']; ?>";
  var start_time_arr = [];
  var duration_arr = [];
  var extra_time_arr = [];
  var select_start_date = $(".startDate").val();
  Pace.restart();
  x++;
  var start_time_array = document.getElementsByClassName('all_start_time');
 // console.log(start_time_array);
  for (var i = 0; i < start_time_array.length; i++){
    if(start_time_array[i].value==''){
      swal("Error","Please Choose a start Time",'error');
      return false;
    }
    start_time_arr[i] = start_time_array[i].value;

  }
  var duration_array = document.getElementsByClassName('all_duration');
  for (var i = 0; i < duration_array.length; i++){
    if(duration_array[i].value==''){
      swal("Error","Please Choose a duration",'error');
      return false;
    }
    duration_arr[i] = duration_array[i].value;
  }
  var extra_time_array = document.getElementsByClassName('all_extra_time');
  for (var i = 0; i < extra_time_array.length; i++){    
    extra_time_arr[i] = extra_time_array[i].value;
  }



  $.ajax({
      type: 'POST',
      url: site_url + 'admin/service/appointment_row',
      data:{
        start_time_array:start_time_arr,duration_array:duration_arr,x:x,staff_id:staff_id,location_id:location_id,extra_time_arr:extra_time_arr,select_start_date:select_start_date
      },
      success: function(response)
      {
        $('.appendService').append(response);
        $('.select').select2();
        $(".rmrow").fadeIn();
      }
  });
}
function calculate_total_price(){ 
  var total = 0;
  var total_amount_array = document.getElementsByClassName('price');
  for (var i = 0; i < total_amount_array.length; i++){
    total = parseFloat(total) + parseFloat(total_amount_array[i].value);
  } 
  $(".appointment_total_amount").val(total);
  $(".appointment_total").html(total);
}

function calculate_total_duration(){
  var duration = 0;
  var total_duration_array = document.getElementsByClassName('all_duration');
  for (var i = 0; i < total_duration_array.length; i++){
    duration = parseFloat(duration) + parseFloat(total_duration_array[i].value);
  } 
  var hours = Math.floor( duration / 60);          
  var minutes = duration % 60; 
  var fhours = hours+'h '+minutes+'min'; 
  $(".total_hours").val(duration);
  $(".total_hrs").html('('+fhours+')');
}
function remove_row(x){
  var total_rows = document.getElementsByClassName('service_row');
  $(".append_"+x).remove(); 
  if(total_rows.length==1){
    $(".rmrow").fadeOut();
  }
  calculate_total_price();
  calculate_total_duration();
}
function check_other(id){
    var start_date = $("#date_input").val();
    var start_time = $("#start_time_"+id).val();
    var service_id = $("#service_id_"+id).val();
    var staff_id = $("#staff_id_"+id).val();
    var duration = $("#duration_"+id).val();
    var location_id = $(".location_id").val();
    if(service_id){
      checkStaffAvailablity(start_time,service_id,staff_id,start_date,duration,location_id,id);
    } 
    calculate_total_duration();
}
function checkStaffAvailablity(start_time,service_id,staff_id,start_date,duration,location_id,id){
  Pace.restart();
  $.ajax({
      type: 'POST',
      url: site_url + 'admin/Operations/checkStaffAvailablity/',
      data:{
        start_time:start_time,service_id:service_id,staff_id:staff_id,start_date:start_date,duration:duration,location_id:location_id
      },
      success: function(data)
      {
          var data = JSON.parse(data);
          if(data.type=="failed"){
            $(".staff_error_"+id).html(data.message);
          }else{
            $(".staff_error_"+id).html('');
          }
      }
  });
}

function client_form(){
$('.clientform').css('display', 'block');
}
$("#showcalendar").click(function() {
$('#date_input').datepicker().datepicker('show');

})
$('#date_input').datepicker({
format: 'DD, dd M yyyy',
});
$("#date_input").on("change", function () {
var fromdate = $(this).val();
$('#changedate').html(fromdate);
$('#date_input').datepicker().datepicker('hide');
//check_other(1);
});
function closeclientdetail(){
$('.clientform').css('display', 'none');
}

function addNewClient(){
 Pace.restart(); 
 var staff_id = "<?php echo $booking['staff_id']?>"; 
 var formData = {
      'first_name'      : $('input[name=first_name]').val(),
      'last_name'       : $('input[name=last_name]').val(),
      'email'           : $('input[name=email]').val(),
      'mobile'          : $('input[name=mobile]').val()
  };
  $.ajax({
      type: 'POST',
      url: site_url + 'admin/Operations/addNewClient/',
      data:{
        formData:formData,staff_id:staff_id
      },
      success: function(data)
      {
          
          closeclientdetail();
           $('input[name=first_name]').val('');
           $('input[name=last_name]').val('');
           $('input[name=email]').val('');
           $('input[name=mobile]').val('');
           $(".client_details").html(data);
       
      }
  });
  return false;
}

function removeFromAppointment(){
  $(".client_details").html("");
}

function getClientDetails(id){
  Pace.restart();
  $.ajax({
    type: 'POST',
    url: site_url + 'admin/Operations/getClientDetails/'+encodeURIComponent(id),
    success:function(response){
      $(".client_details").html(response);
    }
  });
}

$( function() {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }
 
    $( "#birds" ).autocomplete({
      source: site_url + 'admin/Operations/fetchClients/',
      minLength: 2,
      select: function( event, ui ) {
        //log( "Selected: " + ui.item.value + " aka " + ui.item.id );
        //alert(ui.item.id);        
        getClientDetails(ui.item.id);
      }
    });
  } );
</script>
</body>
</html>