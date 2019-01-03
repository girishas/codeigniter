
<div class="row service_row append_<?=$x?>"><span class="rmrow" onclick="remove_row('<?=$x?>')"><i class="fa fa-times remove_row"></i></span>
	<input type="hidden" name="price[]" class="price" id="price_<?=$x?>">
    <div class="col-md-2">
        <div class="form-group" data-plugin="formMaterial">
            <label class="form-control-label" for="inputGrid2">Start Time*</label>
            <select id="start_time_<?=$x?>" class="form-control all_start_time" name="start_time[]" onChange="check_other(<?=$x?>);">
                 <?php
              foreach ($get_hours_range as $key => $value): ?>
              <option <?php echo ($key==$next_time)?"selected":""; ?> value="<?=$key?>"><?= $value; ?> </option>
              <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group" data-plugin="formMaterial">
            <label class="form-control-label" for="inputGrid2">Service*</label>
            <select required="required" id="service_id_<?=$x?>" class="form-control select" data-plugin="select2" name="service[]" onChange="check(this.value,<?=$x?>);">
                <option>Choose Service</option>
                <?php foreach ($options as $key => $value): ?>
                 <option value="s<?=$value['caption_id']?>">
                  <?=$value['sku']?> - <?=$value['service_name']?>&nbsp;»»&nbsp;<?=$value['caption']?> - $<?=$value['special_price']?>
                </option>
              <?php endforeach ?>
              <option value="">Choose Service group</option>
              <?php foreach ($options_gs as $key => $value): ?>
                 <option value="g<?=$value['id']?>" my="d">
                  <?=$value['sku']?> - <?=$value['package_name']?>&nbsp;»»&nbsp; $<?=$value['cost_price']?>
                   - discount $<?=$value['discounted_price']?>
                </option>
              <?php endforeach ?>

            </select>
            <div class="staff_error_<?=$x?> avl_error"></div>
        </div>    
        <input type="hidden" id="extra_time_<?=$x?>" name="extra_time_before[]" class="all_extra_time">    
    </div>
    <div class="col-md-2">
        <div class="form-group" data-plugin="formMaterial">
            <label class="form-control-label" for="inputGrid2">Duration*</label>
            <select id="duration_<?=$x?>" class="form-control all_duration" onChange="check_other(<?=$x?>);" name="duration[]" disabled="disabled"></select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group" data-plugin="formMaterial">
            <label class="form-control-label" for="inputGrid2">Staff*</label>
            <select class="form-control" id="staff_id_<?=$x?>" onChange="check_other(<?=$x?>);" name="staff[]">
                <?php foreach ($staff as $key => $value): 
                $selected_staff = ($value['id']==$staff_id)?"selected":"";
                ?>
                <option <?=$selected_staff;?> value="<?=$value['id']?>"><?php echo $value['first_name'].' '.$value['last_name']; ?></option>
              <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="extra_time_before"><span class="etime_<?=$x?>"></span></div>
</div>