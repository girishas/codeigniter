<table class="table">
	<thead>
		<th><b>Service</b></th>
		<th><b>Available</b></th>
		<th><b>Redeem</b></th>
	</thead>
	<tbody>
		<?php foreach ($get_purchased_packages as $key => $value): 
			$available_visit = $value['visit_limit']-$value['complited_visits']
			?>
			<input type="hidden" name="invoice_package_services_id" value="<?=$value['id']?>">
			<tr>
				<td class="text-center"><?php echo getCaptionName($value['invoice_service_timing_id']); ?></td>
				<td class="text-center"><?= $available_visit ?></td>
				<td class="text-center"><input type="radio" value="<?=$value['id']?>" name="invoice_package_services_id_<?=$count; ?>"></td>
			</tr>
		<?php endforeach ?>
		<tr>
			<td colspan="3">
				<div class="btn btn-group">
					<button type="button" onclick="closePopover()" class="btn btn-primary">Cancel</button>&nbsp;
					<button type="button" onclick="availPackage(<?= $count; ?>)" name="service_id" value="<?= $value['service_id'] ?>" class="btn btn-primary">Apply</button>
				</div>	
			</td>
		</tr>
	</tbody>
</table>
