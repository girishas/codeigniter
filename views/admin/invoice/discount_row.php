<tr class="remove_<?=$count;?>">
	<td>
		<select name="discount[<?=$count?>][discount_id]" required="required" class="form-control selectd_item select" data-plugin="select2" data-placeholder="Select Discount" onchange="getDiscountData(this.value,<?=$count?>)">
			<option value="">Select Discount</option>
			<?php foreach ($discounts as $key => $value):
				if($value['discount_type']==1){
					$type = " (Fixed Price)";
				}else{
					$type= "%";
				}
			?>
			<option value="<?=$value['id']?>"><?= $value['discount_name']." (".$value['discount_price'].$type.")"; ?></option>
			<?php endforeach ?>
		</select>
	</td>
	<td>
		<select name="discount[<?=$count?>][staff]" class="form-control selectd_staff select" data-plugin="select2" required="required">
			<option value="">Choose a Staff...</option>
			<?php foreach ($staff_data as $kkey => $vvalue): ?>
			<option value="<?= $vvalue['id']; ?>"><?= $vvalue['first_name']." ".$vvalue['last_name']; ?></option>
			<?php endforeach ?>
		</select>
	</td>
	<td>1.0<input type="hidden" min="1" name="discount[<?=$count?>][qty]" value="1" class="form-control quantity_<?=$count?>"></td>
    <td><input type="text" onchange="changeUnitPrice(this.value,<?=$count?>)" class="form-control unit_price_<?=$count?>" value="0" name="discount[<?=$count?>][unit_price]"></td>
    <td><span class="is_service_tax_<?=$count?>">N/A</span>
    	<input type="hidden" class="is_service_tax_<?=$count?>" value="0" name="discount[<?=$count?>][is_service_tax]">
    </td>
    <td><input type="text" onchange="calculateTotalPrice()" name="discount[<?=$count?>][total_price]" class="form-control total_price_<?=$count?> total_amount" value="0" name="total_price"></td>
    <td><button type="button" onclick="removeThis(<?=$count?>)" class="btn btn-icon btn-danger waves-effect waves-classic"><i class="icon md-delete"></i></button></td>
</tr>
