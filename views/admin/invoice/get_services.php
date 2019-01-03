<input type="hidden" name="type" value="service">
<input type="hidden" name="service_id" value="<?= $id; ?>">
<input type="hidden" name="title" value="<?= $service['service_name'] ?>">
<input type="hidden" name="is_gst" value="<?= $service['is_gst_tax'] ?>">
<div class="row form-group">
	<label class="col-md-3">Service Title: </label>
	<div class="col-md-9">
		<b><?= $service['service_name'] ?></b>
	</div>
</div>
<div class="row form-group">
	<label class="col-md-3" style="padding-top: 6px;">Choose Type : </label>
	<div class="col-md-9">
		<select class="form-control" required="required" onchange="getServiceCostTime(this.value)" name="service_timing_id" style="text-transform: capitalize;">
			<option value="">Choose Type</option>
			<?php foreach ($service_timing as $key => $value): ?>
				<option value="<?= $value['id'] ?>"><?= $value['caption'] ?></option>
			<?php endforeach ?>
		</select>
	</div>
</div>