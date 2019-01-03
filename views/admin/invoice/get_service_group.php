<input type="hidden" name="type" value="service_group">
<input type="hidden" name="package_id" value="<?= $id; ?>">
<input type="hidden" name="unit_price" value="<?=$package['discounted_price']?>">
<input type="hidden" name="title" value="<?=$package['package_name']?>">
<input type="hidden" name="is_gst" value="<?=$package['is_gst_tax']?>">
<div class="row form-group">
	<label class="col-md-3">Service Group : </label>
	<div class="col-md-9">
		<b><?=$package['package_name']?></b>
	</div>
</div>
<div class="row form-group">
	<label class="col-md-3">Cost : </label>
	<div class="col-md-9">
		<b><?=$package['discounted_price']?></b>
	</div>
</div>
<h4>Services Included</h4><hr>
<table class="table">
	<thead>
		<th><b>Name</b></th>
		<th><b>Duration</b></th>
	</thead>
	<tbody>
		<?php foreach ($service_timing_data as $key => $value): ?>
			<tr>
				<td style="text-transform: capitalize;"><?php echo $value['caption'] ?></td>
				<td>
					<?php echo converToDuration($value['duration']); ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>