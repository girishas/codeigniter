<?php $get_hours_range = get_hours_range(); ?>
<form onsubmit="return addBusyTime()" id="add_busy_time_form">
	<input type="hidden" name="location_id" value="<?=$location_id;?>">
	<input type="hidden" name="id" value="<?=$id;?>">
	<div class="form-group">
		<label>Date</label>
		<input type="text" name="date" class="form-control b_date" value="<?=$date;?>">
	</div>
	<div class="form-group">
		<label>Staff</label>
		<select class="form-control" name="staff_id">
			<?php foreach ($staffs as $key => $value): 
				$selected = ($staff_id==$value['id'])?"selected":"";
				?>
				<option <?=$selected;?> value="<?=$value['id']?>"><?=$value['first_name']." ".$value['last_name']?></option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label>Start Time</label>
				<select class="form-control" name="start_time">
					<?php foreach ($get_hours_range as $key => $value): ?>
		            <option <?= ($key==$start_time)?"selected":""; ?> value="<?=$key?>"><?= $value; ?> </option>
		            <?php endforeach ?>
				</select>
			</div>
			<div class="col-md-6">
				<label>End Time</label>
				<select class="form-control" name="end_time">
					<?php foreach ($get_hours_range as $key => $value): ?>
		            <option <?= ($key==$end_time)?"selected":""; ?> value="<?=$key?>"><?= $value; ?> </option>
		            <?php endforeach ?>
				</select>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label>Description</label>
		<textarea class="form-control" name="description"><?=$description;?></textarea>
	</div>
	<div class="form-group">
		<?php if($id==""): ?>
			<button type="submit" class="btn btn-secondary btn-block">Save</button>
		<?php else: ?>
			<div class="row">
				<div class="col-md-6">
					<button type="button" onclick="deleteBusytime('<?=$id?>')" class="btn btn-danger btn-block">Delete</button>
				</div>
				<div class="col-md-6">
					<button type="submit" class="btn btn-secondary btn-block">Save</button>
				</div>
			</div>
		<?php endif ?>	
	</div>
</form>