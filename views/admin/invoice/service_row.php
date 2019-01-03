<tr class="remove_<?=$count;?>">
	<td>
		<select name="service[<?=$count?>][service_timing_id]" required="required" class="form-control select selectd_item" data-plugin="select2" onchange="getServiceData(this.value,<?=$count?>)">
			<option value="">Choose Service</option>
			<?php foreach ($options as $key => $value): ?>>
					<option value="<?=$value['id']?>">
						<?=$value['sku']?> - <?=$value['service_name']?>&nbsp;»»&nbsp;<?=$value['caption']?> - $<?=$value['special_price']?>
					</option>
			<?php endforeach ?>
		</select>
		<input type="hidden" name="service[<?=$count?>][service_id]" value="" class="service_id_<?=$count?>">
	</td>
	<td>
		<select name="service[<?=$count?>][staff]" class="form-control select selectd_staff" data-plugin="select2" required="required">
			<option value="">Choose a Staff...</option>
			<?php foreach ($staff_data as $kkey => $vvalue): ?>
			<option value="<?= $vvalue['id']; ?>"><?= $vvalue['first_name']." ".$vvalue['last_name']; ?></option>
			<?php endforeach ?>
		</select>
	</td>
	<td>1.0<input type="hidden" min="1" name="service[<?=$count?>][qty]" value="1" class="form-control quantity_<?=$count?>"></td>
    <td>
    	<input type="text" onchange="changeUnitPrice(this.value,<?=$count?>)" class="form-control unit_price_<?=$count?>" min="0" value="0" name="service[<?=$count?>][unit_price]" value="">
    	<input type="hidden" value="" class="original_price_<?=$count?>">
    </td>
    <td><!-- <span class="is_service_tax_<?=$count?>">N/A</span> -->
    	<input type="hidden" class="is_service_tax_<?=$count?>" value="0" name="service[<?=$count?>][is_service_tax]">
    	<input type="text" disabled="disabled" name="service[<?=$count?>][tax_price]" value="0" class="tax_price_<?=$count?> total_tax_price form-control" style="width: 100px;">
    	<input type="hidden" name="service[<?=$count?>][is_freebypackage]" value="0" class="is_freebypackage_<?=$count?>">
    	<input type="hidden" name="service[<?=$count?>][invoice_package_services_id]" value="" class="invoice_package_services_id_<?=$count?>">
    </td>
    <td><input type="text" onchange="calculateTotalPrice()" name="service[<?=$count?>][total_price]" class="form-control total_price_<?=$count?> total_amount" value="0" name="total_price"></td>
    <td><div class="btn-group">
    	<button type="button" onclick="removeThis(<?=$count?>)" class="btn btn-icon btn-danger waves-effect waves-classic"><i class="icon md-delete"></i></button>
    	<button type="button" style="display: none;" title="Available packages" class="btn btn-icon btn-info waves-effect waves-classic avail_package_btn_<?=$count;?>" data-toggle="popover" data-title="Redeem package" data-content=""><i class="icon md-dropbox"></i></button>
    	<button type="button" style="display: none;" title="Avail Free Service" class="btn btn-icon btn-success waves-effect waves-classic free_service_btn_<?=$count;?>" data-toggle="popover" data-title="Avail Free Service" data-content=""><i class="fa fa-flag-checkered"></i></button>
    </div>
    </td>
</tr>