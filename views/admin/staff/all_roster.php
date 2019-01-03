


<input type="hidden" value="<?=$current_month?>" id="cmonth" name="">
<div class="row schedule-filters">
	<div class="col-sm-6">
	</div>
	<div class="col-sm-6 text-right">
		<div class="schedule-date-toolbar">
			<div class="btn-group js-date-toolbar">
				<div class="btn btn-primary navigate" onclick="minusDate()" title="Prev">
					<i class="icon md-chevron-left"></i>
				</div>
				<div class="btn btn-primary navigate active" onclick="initcurrentdayRoster()" style="padding-top: 10px;">
					Today
				</div>
				<div class="btn btn-primary select-date" title="Change Date" style="padding-top: 10px;">
					<span class="display-date"><?= $new_date; ?></span>
				</div>
				<div class="btn btn-primary navigate" onclick="plusDate()" title="Next">
					<i class="icon md-chevron-right"></i>
				</div>
			</div>
		</div>
	</div>
<!-- 	<div class="col-sm-2">
                   <label class="form-control-label" for="inputGrid2"> Date</label>
                      <input type="text" class="form-control" name="date" id="date" data-plugin="datepicker" data-date-today-highlight="true" autocomplete="off" data-date-format="dd-mm-yyyy" value="12-11-2018">
                  </div>  -->

</div><br>
<div class="row" style="margin-left:-2.071rem;">
	<div class="col-md-12">
		<table class="table table-condensed table-bordered my-table">
			<thead>
				<tr>
					<th ><b >Staff</b></th>
					<!--<th ><b class="font-11">Time</b></th>-->
					<?php foreach ($date_ranges as $key => $value): ?>
						<th class="text-center"><b><?= date("D j M",strtotime($value)) ?></b></th>
					<?php endforeach ?>
				</tr>
			</thead>
			<tbody>
				<?php 
				$tt = 0;
				$total_hrs = 0;
				foreach ($rosters_array as $key => $value): ?>
					<tr>
						<td ><b class="font-11 margin-leftside"><?= $staff[$key]['first_name']." ".$staff[$key]['last_name']; ?></b>
							<br/>
							<b class="font-11 margin-leftside hour_style hrs_<?=$key?>"></b>
						</td>
						<!--<td><b class="font-11 hrs_<?=$key?>"></b></td>-->
						<?php foreach ($value as $kkey => $vvalue): ?>
							<td class="parent" style="vertical-align: middle;text-align: center;">	
								<?php 
								$dateDiff = 0;	
								if(count((array)$vvalue)>0): 
								foreach ($vvalue as $kkkey => $vvvalue):
									$dateDiff = $dateDiff + abs(intval((strtotime($vvvalue['start_hours'])-strtotime($vvvalue['end_hours']))/60));
									/*echo $hours = intval($dateDiff/60);
									echo $minutes = $dateDiff%60;*/
									//echo $dateDiff;
								?>
									<button  class="btn btn-info btn-sm roaster_btn" onclick="editRoster('<?=$kkey?>','<?=$date_ranges[$kkey]?>','<?=$staff[$key]['id']?>','<?=$vvvalue['is_repeat']?>','<?=$vvvalue['common_number']?>')"><?=date("g:i a", strtotime($vvvalue['start_hours']))."&nbsp;-&nbsp;".date("g:i a", strtotime($vvvalue['end_hours']))?></button>
								<?php
								endforeach;
								else:
								?>
								<button onclick="addRoster('<?=$kkey?>','<?=$date_ranges[$kkey]?>','<?=$staff[$key]['id']?>')" style="background-color: transparent;opacity: 0; width:120px;" type="button" class="btn btn-default plus-btn "><b>+</b></button>
								<?php endif  ?>
								<input type="hidden" value="<?= $dateDiff; ?>" name="">
								<?php $total_hrs = $total_hrs+$dateDiff;  ?>
							</td>
						<?php 
							endforeach ?>	
							<?php 
								$hours = intval($total_hrs/60);
								$minutes = intval($total_hrs%60);
							?>
							<script type="text/javascript">
								var key = "<?= $key; ?>";
								var hours = "<?= $hours; ?>";
								var minutes = "<?= $minutes; ?>";
								$(".hrs_"+key).html(hours+"h "+minutes+"min");
							</script>
					</tr>

				<?php 
				$total_hrs = 0;
			endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<!-- <script type="text/javascript">
	$(document).ready(function() {
  $('#date').on('click',function(){
    alert("hi");
});
});
	
</script> -->

