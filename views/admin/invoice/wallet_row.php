<tr class="remove_<?=$count;?>">
	<td><input type="text"  name="wallet[<?=$count?>][title]" class="form-control" placeholder="Wallet Description" value="Wallet Deposit"></td>
	<td>
		N/A
	</td>
	<td>N/A</td>
    <td>N/A </td>
    <td>N/A</td>
      <td><input type="text" onchange="calculateTotalPrice()" name="wallet[<?=$count?>][total_price]" class="form-control total_price_<?=$count?> total_amount" value="1" name="total_price"></td>

    <td><button type="button" onclick="removeThis(<?=$count?>)" class="btn btn-icon btn-danger waves-effect waves-classic"><i class="icon md-delete"></i></button></td>
</tr>