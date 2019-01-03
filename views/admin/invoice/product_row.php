<tr class="remove_<?=$count;?>">
	<td>
		<select name="product[<?=$count?>][product_id]" required="required" class="form-control select selectd_item" data-plugin="select2" onchange="getProductData(this.value,<?=$count?>)">
			<option value="">Select Product</option>
			<?php foreach ($product_data as $key => $value): ?>
			<option value="<?=$value['id']?>"> <?=$value['sku']?> - <?= $value['product_name']." (".$value['bar_code'].")" ?> -$<?=$value['retail_price']?> </option>
			<?php endforeach ?>
		</select>
	</td>
	<td>
		<select name="product[<?=$count?>][staff]" class="form-control select selectd_staff" data-plugin="select2" required="required">
			<option value="">Choose a Staff...</option>
			<?php foreach ($staff_data as $kkey => $vvalue): ?>
			<option value="<?= $vvalue['id']; ?>"><?= $vvalue['first_name']." ".$vvalue['last_name']; ?></option>
			<?php endforeach ?>
		</select>
	</td>
	<td><input type="number" min="1" onchange="changeProductQty(this.value,<?=$count?>)" name="product[<?=$count?>][qty]" value="1" class="form-control quantity_<?=$count?>"></td>
    <td>
    	<input type="text" onchange="changeUnitPrice(this.value,<?=$count?>)" class="form-control unit_price_<?=$count?>" min="1" value="0"name="product[<?=$count?>][unit_price]" value="">
    	<input type="hidden" class="form-control original_price_<?=$count?>" value="">
    </td>
    <td>
    	<!-- <span class="is_service_tax_<?=$count?>">N/A</span> -->
    	<input type="hidden" class="is_service_tax_<?=$count?>" value="0" name="product[<?=$count?>][is_service_tax]">
    	<input type="text" disabled="disabled" name="product[<?=$count?>][tax_price]" value="0" class="tax_price_<?=$count?> total_tax_price form-control" style="width: 100px;">
    </td>
    <td><input type="text" onchange="calculateTotalPrice()" name="product[<?=$count?>][total_price]" class="form-control total_price_<?=$count?> total_amount" value="0" name="total_price"></td>
    <td><button type="button" onclick="removeThis(<?=$count?>)" class="btn btn-icon btn-danger waves-effect waves-classic"><i class="icon md-delete"></i></button></td>
</tr>
