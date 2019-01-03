<?php $this->load->view('admin/common/header'); 
$admin_session = $this->session->userdata('admin_logged_in');
if($admin_session['role']=='staff' || $admin_session['role']=='location_owner'  ){
	$loggedUserId = $admin_session['staff_id'];
}elseif( $admin_session['role']=='business_owner' || $admin_session['role']=='owner') {
	$loggedUserId = $admin_session['admin_id'] ;
} ?>
<body class="animsition">
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<style type="text/css">
		.navigate i{font-size: 18px;}
		b{color: #67768C;}
		.my-table td{
			padding: 0px ;
			height: 39px;
			width: 100%;
			vertical-align: middle;
		}
		.roaster_btn{
			margin: 1px 0px;
			width: 85%;
			padding: 7px 0px;
			text-align: center;
			font-weight: 500;
			font-size: 11px;
			padding: 7px 20px 7px 3px
		}
		.my-table th{
			width: 100%;
			text-align:center;
			vertical-align: middle;
			font-size: 12px;
		}
		.font-11{
			font-size: 12px;
		}
		.hour_style{
			font-weight: normal;
			font-style:italic;
		}
		.margin-leftside{
			margin-left: 8px;
		}
		.parent:hover .plus-btn{
			opacity: 1!important;
			display: block;
		width: 100%;
		height: 100%;
		border: 0;
		font-size: 16px;
		}
		.close{padding: 8px!important;}
		.modal-header{
			padding: 0px 20px;
		}
		.ui-timepicker-wrapper{
			z-index: 9999999999999999;
		}
		.btn_close{
			font-size: 21px!important;
		position: absolute;
		top: -10px;
		right: 9px;
		padding: 0px!important;
		z-index: 9999;
		}
	</style>
	<div class="page">
		<div class="page-content">
			<div class="panel panel-bordered">
				<div class="panel-heading">
					<h1 class="panel-title" >Roster</h1>					
				</div>

				<div class="panel-body">
					<div class="row"> 
						<?php if($admin_session['business_id'] !="" and ($admin_session['role']=="owner" || $admin_session['role']=="business_owner")){ ?>
					<div class="col-md-2"> 
								<label class="control-label">Choose Location</label>
								<select class="form-control" name="location_id" id="location_id">
							
						 <?php foreach ($getlocation as $key => $value) {?>
						 <option value="<?php echo $value ['id'] ?>"><?php echo $value ['location_name'] ?></option>
						 	

						<?php } ?>
							
							</select>
						</div>
						<?php } ?>

						<?php if ($admin_session['role']=="location_owner" || $admin_session['role']=="staff"  ) { ?>
							<input type="hidden" name="location_id" id="location_id" value="<?php echo $admin_session['location_id'] ?>">
						<?php } ?>

				<div class="col-sm-2">
                   <label class="form-control-label" for="inputGrid2">Select Date</label>
                      <input type="text" class="form-control datepicker" name="select_date" id="select_date" data-plugin="datepicker" data-date-today-highlight="true" autocomplete="off" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>">
                </div>

                <input type="hidden" name="currentday" id="currentday" value="<?php echo date("d-m-Y"); ?>">

                <div class="col-sm-2">
                   <label class="form-control-label" for="inputGrid2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <label class="form-control-label" for="inputGrid2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                     <label class="form-control-label" for="inputGrid2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
					<button class="btn btn-primary waves-effect waves-classic waves-effect waves-classic" id="submit_date" type="button">Go To Date</button>
				</div>

					
                    <div class=" panel-body roster_all">
				</div>
				        </div>
                 
					
				
			</div>
			
			
				
			
					
				
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<form id="myform" class="create-roster-form">
						<div class="model-content">
							
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button aria-hidden="" class="btn btn-default" data-dismiss="modal" type="button">
					Close
					</button>
					<button onclick="submitRoster()" class="btn btn-success js-save-button">Save</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Modal -->
	<!-- Modal -->
	<div class="modal fade modal-fade-in-scale-up" id="userNotSuthorized" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
						<div class="model-content" style="text-align: center;">
						<b> You are not authorized to perform this action </b>	
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Modal -->
	<!-- Modal -->
	<div class="modal fade modal-fade-in-scale-up" id="editModel" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<form id="myformEdit" class="roster-form">
						<div class="model-content-edit">
							
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="deleteRos()" class="btn btn-danger pull-left">Delete</button>
					<button aria-hidden="" class="btn btn-default" data-dismiss="modal" type="button">
					Close
					</button>
					<button onclick="submitEditRoster()" class="btn btn-success js-save-button">Save</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Modal -->
	<!-- Modal -->
	<div class="modal fade modal-fade-in-scale-up" id="repeatingShifts" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<section class="text-center">
						<h4>Repeating Shift</h4>
					</section>
					<p>You have edited a shift that repeats weekly. Updating upcoming shifts will overwrite ongoing schedule.</p>
				</div>
				<div class="modal-footer">
					<div class="pull-left">
						<button data-dismiss="modal" type="button" class="btn btn-default js-cancel-confirmation">
						Close
						</button>
					</div>
					<button onclick="setValue(this.value)" value="" id="sval" type="button" class="btn btn-default">Update upcoming shifts</button>
					<button onclick="setValue(this.value)" value="0" class="btn btn-success">Update this shift only</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade modal-fade-in-scale-up" id="repeatingShiftsAdd" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<section class="text-center">
						<h4>Repeating Shift</h4>
					</section>
					<p>You have edited a shift that repeats weekly. Updating upcoming shifts will overwrite ongoing schedule.</p>
				</div>
				<div class="modal-footer">
					<div class="pull-left">
						<button data-dismiss="modal" type="button" class="btn btn-default js-cancel-confirmation">
						Close
						</button>
					</div>
					<button onclick="setValueAdd(this.value)" value="" id="svaladd" type="button" class="btn btn-default">Update upcoming shifts</button>
					<button onclick="setValueAdd(this.value)" value="0" class="btn btn-success">Update this shift only</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Modal -->
	<div class="modal fade modal-fade-in-scale-up" id="repeatingShiftsDelete" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<section class="text-center">
						<h4>Repeating Shift</h4>
					</section>
					<p>You are deleting a shift that repeats weekly. Deleting upcoming shifts will overwrite ongoing schedule.</p>
				</div>
				<div class="modal-footer">
					<div class="pull-left">
						<button data-dismiss="modal" type="button" class="btn btn-default js-cancel-confirmation">
						Close
						</button>
					</div>
					<button onclick="setValueDelete(this.value)" value="" id="svaldel" type="button" class="btn btn-default">Delete upcoming shifts</button>
					<button onclick="setValueDelete(this.value)" value="0" class="btn btn-danger">Delete this shift only</button>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
	<script type="text/javascript">
	$(document).ready(function(){
			Pace.restart();
			initRoster(0);

		$("#submit_date").click (function(){			
			initgotodateRoster(count_plus);
		});
		
		$("#location_id").change(function(){
			initgotodateRoster(count_plus);
		});

	});

	function initcurrentdayRoster(){
		Pace.restart();		
			count_plus = 0;	
		var select_date = $("#currentday").val();
		var location_id = $("#location_id").val();
		
		$.ajax({
			method:"post",
			url:site_url+"admin/staff/changeRoster",
			data:{select_date:select_date,
				location_id:location_id,
				count_plus:count_plus,
			},
			success: function(response){
				//alert(response);
				$(".roster_all").html(response);
			},error:function(){
				alert("error");
			}
		});

	}
		

	function initgotodateRoster(num=null){
		Pace.restart();		
			count_plus = 0;	
		var select_date = $("#select_date").val();
		var location_id = $("#location_id").val();
		$.ajax({
			method:"post",
			url:site_url+"admin/staff/changeRoster",
			data:{select_date:select_date,
				location_id:location_id,
				count_plus:count_plus,
			},
			success: function(response){
				//alert(response);
				$(".roster_all").html(response);
			},error:function(){
				alert("error");
			}
		});

	}

	function initRoster(num=null){
		Pace.restart();
		if(num !=null){
			count_plus = num;
		}else{
			count_plus = -1;
		}
		//alert(count_plus);
		var location_id = $("#location_id").val();
		var select_date = $("#select_date").val();
		$.ajax({
			method:"post",
			url:site_url+"admin/staff/changeRoster",
			data:{count_plus:count_plus,
				location_id:location_id,
				select_date:select_date,
			},
			success: function(response){
				//alert(response);
				$(".roster_all").html(response);
			},error:function(){
				alert("error");
			}
		});
	}
		var count_plus = 1;
	function plusDate(){
		
		count_plus++;
		Pace.restart();
		if(count_plus == 1){
			count_plus = 1;
		}
		//alert(count_plus);
		var select_date = $("#select_date").val();
		var location_id = $("#location_id").val();
		$.ajax({
			method:"post",
			url:site_url+"admin/staff/changeRoster",
			data:{count_plus:count_plus,
				location_id:location_id,
				select_date:select_date,
			},
			success: function(response){
				//alert(response);
				$(".roster_all").html(response);
			},error:function(){
				alert("error");
			}
		});
	}
	function minusDate(){
		
		//alert(count_plus);
		count_plus--;
		Pace.restart();
		if(count_plus == 1){
			count_plus = 1;
		}
		var location_id = $("#location_id").val();
		var select_date = $("#select_date").val();
		$.ajax({
			method:"post",
			url:site_url+"admin/staff/changeRoster",
			data:{count_plus:count_plus,
				location_id:location_id,				
				select_date:select_date,
			},
			success: function(response){
				$(".roster_all").html(response);
			},error:function(){
				alert("error");
			}
		});		
	}
	function addRoster(day,date,staff_id){
		
		var user_role = '<?php echo is_permissible($loggedUserId,'staff','EditRoster')?>';
		if(user_role ==1){	
			var cmonth = $("#cmonth").val();
			var location_id = $("#location_id").val();
			Pace.restart();
			var dis = [];
			for (var i = 0; i <= 6; i++) {
				if(i==day){
					continue;
				}
				dis.push(i);
			}
			//alert(dis)
			$.ajax({
				method:"post",
				url:site_url+"admin/staff/createRoster",
				data:{day:day,date:date,staff_id:staff_id,location_id:location_id},
				success: function(response){
					$('#exampleNiftyFadeScale').modal('show');
					$(".model-content").html(response);
					$('.datepicker').datepicker({
						daysOfWeekDisabled:dis,
						defaultViewDate :{month:cmonth-1}
					});
				},error:function(){
					alert("error");
				}
			});
		}else{
			$('#userNotSuthorized').modal('show');
		}		
		
	}
	function setSpecificDate(val){
		if(val==2){
			$(".specific_date").show();
		}else{
			$(".specific_date").hide();
		}
	}
	function submitRoster(){
		var user_role = '<?php echo is_permissible($loggedUserId,'staff','EditRoster')?>';
		if(user_role ==1){	
			Pace.restart();
			var myform = document.getElementById("myform");
			var fd = new FormData(myform );
				$.ajax({
					method:"post",
					url:site_url+"admin/staff/saveRoster",
					data:fd,
					cache: false,
					processData: false,
					contentType: false,
					success:function (response){
						var data = JSON.parse(response);
						if(data.type=="success"){
							$('#exampleNiftyFadeScale').modal('hide');
							initRoster(count_plus);
							//count_plus=0;
						}else{
							$('#exampleNiftyFadeScale').modal('hide');
							$("#repeatingShiftsAdd").modal('show');
							$("#svaladd").val(data.repeat);
						}
					},
					error:function (){
						alert("Error");
					}
				});
		}else{
			$('#userNotSuthorized').modal('show');
		}	
	}
	function submitEditRoster(){
		var user_role = '<?php echo is_permissible($loggedUserId,'staff','EditRoster')?>';
		if(user_role ==1){
			Pace.restart();
			var myformEdit = document.getElementById("myformEdit");
			var fd = new FormData(myformEdit);
			$.ajax({
				method:"post",
				url:site_url+"admin/staff/saveEditRoster",
				data:fd,
				cache: false,
				processData: false,
				contentType: false,
				success:function (response){
					//alert(response);
					var data = JSON.parse(response);
					if(data.type=="success"){
						$('#editModel').modal('hide');
						initRoster(count_plus);
					}else{
						$('#editModel').modal('hide');
						$("#repeatingShifts").modal('show');
						$("#sval").val(data.repeat);
					}
				},
				error:function (){
					alert("Error");
				}
			});
		}else{
			$('#userNotSuthorized').modal('show');
		}	
	}
	function editRoster(day,date,staff_id,is_repeat,common_number){
		var user_role = '<?php echo is_permissible($loggedUserId,'staff','EditRoster')?>';
		if(user_role ==1){
			Pace.restart();
			var dis = [];
			var cmonth = $("#cmonth").val();
			$(".model-content-edit").html("");
			$(".loader").css("display","block");
			for (var i = 0; i <= 6; i++) {
				if(i==day){
					continue;
				}
				dis.push(i);
			}
			$.ajax({
				method:"post",
				url:site_url+"admin/staff/EditRoster",
				data:{day:day,date:date,staff_id:staff_id,is_repeat:is_repeat,common_number:common_number},
				success: function(response){
					$('#editModel').modal('show');
					$(".model-content-edit").html(response);
					$('.datepicker').datepicker({
						format:"yyyy-mm-dd",
						daysOfWeekDisabled:dis,
						defaultViewDate :{month:cmonth-1}
					});
				},error:function(){
					alert("error");
				}
			});
		}else{
			$('#userNotSuthorized').modal('show');
		}
			
	}
	function setValue(num){
		//alert(num);
		Pace.restart();
		$(".repeatAction").val(num);
		var myformEdit = document.getElementById("myformEdit");
	var fdd = new FormData(myformEdit);
		$.ajax({
			method:"post",
			url:site_url+"admin/staff/saveEditRosterRepeatingShift",
			data:fdd,
			cache: false,
	processData: false,
	contentType: false,
			success:function (response){
			//	alert(response);
				var data = JSON.parse(response);
				if(data.type=="success"){
					$('#editModel').modal('hide');
					$("#repeatingShifts").modal('hide');
					initRoster(count_plus);
				}else{
					$('#editModel').modal('hide');
					$("#repeatingShifts").modal('hide');
				}
			},
			error:function (){
				alert("Error");
			}
		})
	}
	function setValueAdd(num){
		Pace.restart();
		$(".repeatAction").val(num);
		var myformEdit = document.getElementById("myform");
	var fdd = new FormData(myformEdit);
		$.ajax({
			method:"post",
			url:site_url+"admin/staff/saveAddRosterRepeatingShift",
			data:fdd,
			cache: false,
			processData: false,
			contentType: false,
			success:function (response){
				//alert(response);
				var data = JSON.parse(response);
				if(data.type=="success"){
					$('#editModel').modal('hide');
					$("#repeatingShiftsAdd").modal('hide');
					initRoster(count_plus);
				}else{
					$('#editModel').modal('hide');
					$("#repeatingShiftsAdd").modal('hide');
				}
			},
			error:function (){
				alert("Error");
			}
		})
	}

	function setValueDelete(num){
		//alert(num);
		
		Pace.restart();
		$(".repeatAction").val(num);
		var myformEdit = document.getElementById("myformEdit");
	var fdd = new FormData(myformEdit);
		$.ajax({
			method:"post",
			url:site_url+"admin/staff/deleteRepeatingShift",
			data:fdd,
			cache: false,
			processData: false,
			contentType: false,
			success:function (response){
				//alert(response);
				var data = JSON.parse(response);
				if(data.type=="success"){
					$("#repeatingShiftsDelete").modal('hide');
					initRoster(count_plus);
				}
				else if(data.type=="alreadybooking"){
					   swal({
					title: "Error",
					text: data.message,
					type: "error"
					},
					function() {
						$("#repeatingShiftsDelete").modal('hide');
					//location.reload();
					});

				}

				else{
					$("#repeatingShiftsDelete").modal('hide');
				}
			},
			error:function (){
				alert("Error");
			}
		})
	}
	function deleteRos(){
		var user_role = '<?php echo is_permissible($loggedUserId,'staff','EditRoster')?>';
		if(user_role ==1){
			Pace.restart();
			var myformEdit = document.getElementById("myformEdit");
			var fdd = new FormData(myformEdit);
			$.ajax({
			method:"post",
			url:site_url+"admin/staff/deleteRos",
			data:fdd,
			cache: false,
			processData: false,
			contentType: false,
					success:function (response){
							var data = JSON.parse(response);
							if(data.type=="success"){
								$('#editModel').modal('hide');
								initRoster(count_plus);
							}else{
								$('#editModel').modal('hide');
								$("#repeatingShiftsDelete").modal('show');
								$("#svaldel").val(data.repeat);
							}
					},
					error:function (){
						alert("Error");
					}
				});
		}else{
			$('#userNotSuthorized').modal('show');
		}		
	}
	</script>
	<?php $this->load->view('admin/common/footer'); ?>