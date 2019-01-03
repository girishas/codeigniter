<table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr" data-selectable="selectable" id="table_new_order">
			<thead>
				<tr>
					<th class="cell-150 dark-background-heading" scope="col">Type</th>
					<th class="cell-300 dark-background-heading" scope="col">Time</th>
					<th class="cell-150 dark-background-heading" scope="col">Location</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($working_details){
				foreach ($working_details as $key => $value) { ?>
					<tr>
						<td><?php echo ($value['is_break']==1)?"<span class='badge badge-danger'>Break</span>":"<span class='badge badge-success'>Service</span>"; ?></td>
						<td><?= date('h:i a',strtotime($value['start_hours']))." - ".date('h:i a',strtotime($value['end_hours'])) ?></td>
						<td><?php echo getLocationNameById($value['location_id']);?></td>
					</tr>
				<?php }}else{
						echo "<tr><td colspan='4'><center>No Record Found</center></td></tr>";
					}	?>
			</tbody>
		</table>