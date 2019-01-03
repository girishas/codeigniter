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