<tr class="remove_<?=$count;?>">
	<td><?=$voucher_data['vouchar_name'];?> (Gift voucher redemption)
		<input type="hidden" class="voucher_ids" value="<?=$voucher_data['id']?>" name="gift_voucher[<?=$count?>][voucher_id]">
	</td>
	<td>
		<select name="gift_voucher[<?=$count?>][staff]" class="form-control select" data-plugin="select2" required="required">
			<option value="">Choose a Staff...</option>
			<?php foreach ($staff_data as $kkey => $vvalue): ?>
			<option value="<?= $vvalue['id']; ?>"><?= $vvalue['first_name']." ".$vvalue['last_name']; ?></option>
			<?php endforeach ?>
		</select>
	</td>
	<td colspan="4">
		<div class="alert dark alert-icon alert-info alert-dismissible" role="alert" style="margin-bottom: 0;
    padding: 6px 49px;">
            <i style="top: 10px;" class="icon md-check" aria-hidden="true"></i> Voucher applied successfully, Available amount is <?=$voucher_data['available_amount'];?>.</div>
		<input type="hidden" min="1" name="gift_voucher[<?=$count?>][qty]" value="1" class="form-control quantity_<?=$count?>">
    	<input type="hidden" onchange="changeUnitPrice(this.value,<?=$count?>)" class="form-control unit_price_<?=$count?>" name="gift_voucher[<?=$count?>][unit_price]" value="<?=$voucher_data['calculated_voucher_amount']?>">
    	<!-- <span class="is_service_tax_<?=$count?>">N/A</span> -->
    	<input type="hidden" disabled="disabled" class="is_service_tax_<?=$count?> form-control" style="width: 100px;" value="0" name="gift_voucher[<?=$count?>][is_service_tax]">
    	<input type="hidden" onchange="calculateTotalPrice()" name="gift_voucher[<?=$count?>][total_price]" class="form-control total_price_<?=$count?> total_amount" value="<?=$voucher_data['calculated_voucher_amount']?>" name="total_price">
    </td>
    <td><button type="button" onclick="removeThis(<?=$count?>)" class="btn btn-icon btn-danger waves-effect waves-classic"><i class="icon md-delete"></i></button></td>
</tr>
