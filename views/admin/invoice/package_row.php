<tr class="remove_<?=$count;?>">
	<td>
		<select name="package[<?=$count?>][id]" required="required" class="form-control select selectd_item" data-plugin="select2" onchange="getPackageData(this.value,<?=$count?>)">
			<option value="">Choose Package</option>
			<?php foreach ($packages as $key => $value): ?>
					<option value="<?=$value['id']?>"><?=$value['sku']?> - <?=$value['package_name']?> -$<?=$value['discounted_price']?></option>
			<?php endforeach ?>
		</select>
	</td>
	<td>
		<select name="package[<?=$count?>][staff]" class="form-control select selectd_staff" data-plugin="select2" required="required">
			<option value="">Choose a Staff...</option>
			<?php foreach ($staff_data as $kkey => $vvalue): ?>
			<option value="<?= $vvalue['id']; ?>"><?= $vvalue['first_name']." ".$vvalue['last_name']; ?></option>
			<?php endforeach ?>
		</select>
	</td>
	<td>1.0<input type="hidden" min="1" name="package[<?=$count?>][qty]" value="1" class="form-control quantity_<?=$count?>"></td>
    <td><input type="text" onchange="changeUnitPrice(this.value,<?=$count?>)" class="form-control unit_price_<?=$count?>" min="1" value="0" name="package[<?=$count?>][unit_price]" value=""></td>
    <td><!-- <span class="is_service_tax_<?=$count?>">N/A</span> -->
    	<input type="hidden" class="is_service_tax_<?=$count?>" value="0" name="package[<?=$count?>][is_service_tax]">
    	<input type="text" disabled="disabled" name="package[<?=$count?>][tax_price]" value="0" class="tax_price_<?=$count?> total_tax_price form-control" style="width: 100px;">
    </td>
    <td><input type="text" onchange="calculateTotalPrice()" name="package[<?=$count?>][total_price]" class="form-control total_price_<?=$count?> total_amount" value="0" name="total_price"></td>
    <td><button type="button" onclick="removeThis(<?=$count?>)" class="btn btn-icon btn-danger waves-effect waves-classic"><i class="icon md-delete"></i></button></td>
</tr>