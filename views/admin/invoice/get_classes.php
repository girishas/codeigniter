<input type="hidden" name="type" value="class">
<input type="hidden" name="class_id" value="<?= $id; ?>">
<input type="hidden" name="title" value="<?=$service['service_name']?>">
<input type="hidden" name="is_gst" value="<?=$service['is_gst_tax']?>">
<input type="hidden" name="unit_price" value="<?=$service_timing_data['special_price']?>">
<div class="row form-group">
	<label class="col-md-3">Class Name : </label>
	<div class="col-md-9">
		<b><?=$service['service_name']?></b>
	</div>
</div>
<div class="row form-group">
	<label class="col-md-3">Class Cost : </label>
	<div class="col-md-9">
		<input type="text" required="" class="form-control" value="<?=$service_timing_data['special_price']?>" name="class_cost">
	</div>
</div>
<div class="row form-group">
	<label class="col-md-3">Class Duration : </label>
	<div class="col-md-9">
		<b><?=converToDuration($service_timing_data['duration'])?></b>
	</div>
</div>
<div class="row form-group">
	<label class="col-md-3">Class Capacity : </label>
	<div class="col-md-9">
		<b><?=$service['class_capacity']?></b>
	</div>
</div>
<div class="row form-group">
	<label class="col-md-3">Description : </label>
	<div class="col-md-9">
		<b><?=$service['description']?></b>
	</div>
</div>
