
<?php
$count=$total_count;

 foreach ($options as $key => $value) {
 	//echo "<pre>"; print_r($value);
  ?>
<tr class="remove_<?=$total_count;?>">
	<td>
		<p> 
			<?=$value['sku']?> - <?=$value['service_name']?>&nbsp;»»&nbsp;<?=$value['caption']?> - $<?=$value['special_price']?>
		</p>
		<input type="hidden" name="service_group[<?=$count?>][services_id]" value="<?=$value['services_id']?>" >
		<input type="hidden" name="service_group[<?=$count?>][package_id]" value="<?=$value['package_id']?>" >
		<input type="hidden" name="service_group[<?=$count?>][service_timing_id]" value="<?=$value['service_timing_id']?>" >
		
	</td>
	<td>
		<select name="service_group[<?=$count?>][staff]" class="form-control select" data-plugin="select2" required="required">
			<option value="">Choose a Staff...</option>
			<?php foreach ($staff_data as $kkey => $vvalue): ?>
			<option value="<?= $vvalue['id']; ?>"><?= $vvalue['first_name']." ".$vvalue['last_name']; ?></option>
			<?php endforeach ?>
		</select>
	</td>
	<td>1.0<input type="hidden" min="1" name="service_group[<?=$count?>][qty]" value="1" class="form-control quantity_<?=$count?>"></td>

    <td>
    	
    	<input type="text" onchange="changeUnitPrice(this.value,<?=$count?>)" class="form-control unit_price_<?=$count?>" min="1"  name="service_group[<?=$count?>][unit_price]" value="<?=$value['special_price']?>" value="<?php echo $value['special_price'];?>" ></td>
    <td>
    	<input type="hidden" class="is_service_tax_<?=$count?>" value="0" name="service_group[<?=$count?>][is_service_tax]">
    	<input type="text" disabled="disabled" name="service_group[<?=$count?>][tax_price]" value="0" class="tax_price_<?=$count?> total_tax_price form-control" style="width: 100px;">
    </td>
    <td><input type="text" onchange="calculateTotalPrice()" name="service_group[<?=$count?>][total_price]" class="form-control total_price_<?=$count?> total_amount" value="<?=$value['special_price']?>" name="total_price"></td>

    <td><button type="button" onclick="removeThis(<?=$total_count?>)" class="btn btn-icon btn-danger waves-effect waves-classic"><i class="icon md-delete"></i></button> </td>
</tr>


<?php 
$count++;
} ?>