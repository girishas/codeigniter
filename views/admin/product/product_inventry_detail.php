<div class="row">
	<?php if($type=="stockin"){ ?>
	<div class="col-md-12">
		<b>Stockin Detail</b><hr>
		<table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr" data-selectable="selectable" id="table_new_order">
			<thead>
				<tr>
					<th class="cell-150 dark-background-heading" scope="col">Order Type</th>
					<th class="cell-150 dark-background-heading" scope="col">Quantity</th>
					<th class="cell-150 dark-background-heading" scope="col">Reason</th>
					<th class="cell-300 dark-background-heading" scope="col">Message</th>
					<th class="cell-150 dark-background-heading" scope="col">Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($data){
				foreach ($data as $key => $value) { 
					if ($value['quantity']>0) {
						
					
					?>

					<tr>
						<td>
							<?php
							if (!is_null($value['order_id'])) { ?>
							 <a href="<?php echo base_url('admin/product/order_detail/'.$value['order_id']);?>">Order #<?php echo $value['order_id'];?></a>
							<?php } 
							elseif ($value['order_type']==4) {
								echo "Distribution";
							}
							elseif ($value['order_type']==5) { ?>
								 <a href="<?php echo base_url('admin/invoice/ViewInvoice/'.$value['invoice_id']);?>">Refund #<?php echo $value['invoice_id'];?></a>
								
							<?php }
							else{
								echo "Opening Stock";
							}
							?>

							<!-- <?php echo ($value['order_type']==1)?"Opening Stock":"Stock In" ;?>  -->
								
							</td>
						<td><?= $value['quantity']; ?></td>
						<td>
							<?php
							switch ($value['stockin_reason']) {
								case 1:
									echo "Opening balance";
									break;
								case 2:
									echo "Other";
									break;									
								default:
									echo "---";
									break;
							}
							?>
						</td>
						<td><?php echo ($value['stockin_message'])?$value['stockin_message']:"---" ;?></td>
						<td> <?php echo date('F d,Y',strtotime($value['date_created']));  ?></td>
					</tr>
				<?php }
				}
			}else{
						echo "<tr><td colspan='4'><center>No Record Found</center></td></tr>";
					}	?>
			</tbody>
		</table>
	</div>
<?php }else{ ?>
	<div class="col-md-12">
		<b>Stockout Detail</b><hr>
		<table  class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr" data-selectable="selectable" id="table_new_order">
			<thead>
				<tr>
					<th class="cell-100 dark-background-heading" scope="col">Uses Type</th>
					<th class="cell-100 dark-background-heading" scope="col">Invoice</th>
					<th class="cell-150 dark-background-heading" scope="col">Quantity</th>
					<th class="cell-300 dark-background-heading" scope="col">Message</th>
					<th class="cell-150 dark-background-heading" scope="col">Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($data){
					foreach ($data as $key => $value) { ?>
					<tr>
						<td>
							<?php
							if (!is_null($value['order_id'])) { ?>
							 <a href="<?php echo base_url('admin/product/order_detail/'.$value['order_id']);?>">Order #<?php echo $value['order_id'];?></a>
							<?php } 
							else{
								switch ($value['used_type']) {
								case 1:
									echo "Internal Use";
									break;
								case 2:
									echo "Sold";
									break;
								case 3:
									echo "Damaged";
									break;	
								case 4:
									echo "Adjustmen";
									break;
								case 5:
									echo "Out of Date";
									break;
								case 6:
									echo "Other";
									break;
								case 3:
									echo "Used for testing";
									break;	

									case 8:
									echo "Distribution";
									break;	
								default:
									echo "---";
									break;
							}


							}

							
							?>
						</td>
						<td>
							<?php if($value['invoice_id']): ?>
								<a class="btn btn-secondary" href="<?=base_url('/admin/invoice/ViewInvoice/'.$value['invoice_id'])?>">View Invoice</a>
							<?php else: ?>
								---
							<?php endif; ?>
						</td>
						<td><?= $value['quantity']; ?></td>
						<td><?= ($value['message'])?($value['message']):"---"; ?></td>
						<td> <?php echo date('F d,Y',strtotime($value['date_created']));  ?></td>
					</tr>	
					<?php }}else{
						echo "<tr><td colspan='4'><center>No Record Found</center></td></tr>";
					}	?>
			</tbody>
		</table>
	</div>
<?php } ?>
</div>