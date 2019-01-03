<input type="hidden" name="type" value="package">
<input type="hidden" name="id" value="<?= $id; ?>">
<input type="hidden" name="title" value="<?=$package['package_name']?>">
<input type="hidden" name="unit_price" value="<?=$price?>">
<input type="hidden" name="is_gst" value="<?=$package['is_gst_tax']?>">
<input type="hidden" name="tax_price" value="<?=$tax_price?>">
<input type="hidden" name="total_price" value="<?=$total_price?>">
<div class="row form-group">
	<label class="col-md-3">Package Name : </label>
	<div class="col-md-9">
		<b><?=$package['package_name']?></b>
	</div>
</div>
<div class="row form-group">
	<label class="col-md-3">Package Cost : </label>
	<div class="col-md-9">
		<b><?=$package['discounted_price']?></b>
	</div>
</div>
<div class="form-group row">
	<div class="col-md-6">
		<label>Package Start Date</label>
		<input type="text" name="start_date" autocomplete="off" class="form-control datepicker" data-plugin="datepicker" data-date-today-highlight="true" placeholder="Package Start Date">
	</div>
	<div class="col-md-6">
		<label>Package End Date</label>
		<input type="text" name="end_date" autocomplete="off" class="form-control datepicker" placeholder="Package End Date">
	</div>
</div>
<h4>Services Included</h4><hr>
<table class="table">
	<thead>
		<th><b>Service</b></th>
		<th><b>Duration</b></th>
		<th><b>Price</b></th>
	</thead>
	<tbody>
		<?php foreach ($service_timing_data as $key => $value): ?>
			<tr>
				<td style="text-transform: capitalize;"><?php echo getServiceName($value['service_id']) ?>&nbsp;<?php echo $value['caption'] ?></td>
				<td>
					<?php echo converToDuration($value['duration']); ?>
				</td>
				<td><?=$value['special_price'];?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>