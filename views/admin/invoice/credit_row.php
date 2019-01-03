<tr class="remove_<?=$count;?>">
	<td><input type="text" required="required" name="credit[<?=$count?>][title]" class="form-control" placeholder="Credit Note Title"></td>
	<td>
		<select name="credit[<?=$count?>][staff]" class="form-control select" data-plugin="select2" required="required">
			<option value="">Choose a Staff...</option>
			<?php foreach ($staff_data as $kkey => $vvalue): ?>
			<option value="<?= $vvalue['id']; ?>"><?= $vvalue['first_name']." ".$vvalue['last_name']; ?></option>
			<?php endforeach ?>
		</select>
	</td>
	<td>1.0<input type="hidden" min="1" name="credit[<?=$count?>][qty]" value="1" class="form-control quantity_<?=$count?>"></td>
    <td><input type="text" class="form-control unit_price_<?=$count?>" min="1" value="0" name="credit[<?=$count?>][unit_price]" value=""></td>
    <td><!-- <span class="is_service_tax_<?=$count?>">N/A</span> -->
    	<input type="text" disabled="disabled" class="is_service_tax_<?=$count?>" value="0" name="credit[<?=$count?>][is_service_tax] form-control" style="width: 100px;">
    </td>
    <td><input type="text" name="credit[<?=$count?>][total_price]" class="form-control total_price_<?=$count?>" value="0" name="total_price"></td>
    <td><button type="button" onclick="removeThis(<?=$count?>)" class="btn btn-icon btn-danger waves-effect waves-classic"><i class="icon md-delete"></i></button></td>
</tr>