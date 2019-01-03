<?php $this->load->view('admin/common/header_calendar'); ?>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<body class="animsition app-contacts page-aside-left">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>
<style type="text/css">
	.popup_header_default{
		background-color: #0096FB;
		text-align: center;
		color: #fff;
		padding: 0 5px;
		font-size: 16px;
	}.popup_header_blocked{
		background-color: #8A8A8A;
		text-align: center;
		color: #fff;
		padding: 0 5px;
		font-size: 16px;
	}
	.popup_header_completed{
		background-color: #35b729;
		text-align: center;
		color: #fff;
		padding: 0 5px;
		font-size: 16px;
	}.popup_header_noshow{
		background-color: #E84C3D;
		text-align: center;
		color: #fff;
		padding: 0 5px;
		font-size: 16px;
	}
	.pop-content{
		padding: 10px;		
	}
	.cname{
		font-size: 17px;
		color: #000;
		font-weight: 600;
	}
	.hr{
		margin: 5px 0px;
	}
	.ptext{
		font-size: 14px;
	}
	.popover-body{padding: 0px!important;}
	.cal-pop{min-width: 210px;}
	.fc-content{
	    color: #fff!important;
	    font-size: 13px;
	}
	.sbox{
		width: 15px;
		height: 15px;
		display: inline-block;
		border-radius: 50%;
	}
	.fc-nonbusiness{
		background-color: #000;
	}
	.fc-highlight{background:#24334A;}
</style>        
	<div class="page">
      <div class="page-main">
      	<div class="container">
      	<div class="row" style="margin-top: 15px;">  			
  			<?php if($admin_session['role']=="business_owner" or $admin_session['role']=="owner"){?>
  				<div class="col-md-3">
  				<select class="form-control location_id"  name="location_id" onChange="return get_staff_by_location(this.value)">
  					<?php if(isset($locations)){?>
  						<?php foreach($locations as $loc){
  							$selected = ($location_id==$loc['id'])?"selected":"";
  						?>
  						<option <?=$selected;?> value="<?php echo $loc['id'];?>"><?php echo $loc['location_name'];?></option>
  					<?php } } ?>
  				</select>
  				</div>
  			<?php }
  			 if($admin_session['role']=="staff"){?>
  				<div class="col-md-3">
  				<select class="form-control location_id"  name="location_id" onChange="return get_staff_by_location(this.value)">
  					<?php if(isset($locations)){?>
  						<?php foreach($locations as $loc){
  							$selected = ($location_id==$loc['id'])?"selected":"";
  						?>
  						<option <?=$selected;?> value="<?php echo $loc['id'];?>"><?php echo $loc['location_name'];?></option>
  					<?php } } ?>
  				</select>
  				</div>
  			<?php }

  			if($admin_session['role']=="location_owner"){ ?>
  				<input type="hidden" class="location_id" value="<?= $admin_session['location_id'] ?>" name="location_id">
  			<?php


  			 } ?>
  			<?php if($admin_session['role']=="business_owner" or $admin_session['role']=="owner" or $admin_session['role']=="location_owner"){?>  			
  			<div class="col-md-3">
  				<div id="content_staff">
  					<select class="form-control staff" id="content_staff_id">
  						<option value="0">Working Staff</option>
  					</select></div>
  			</div>
  			<?php }else{ ?>
  				<input type="hidden" class="staff" value="<?php echo $admin_session['staff_id']; ?>" name="staff_id">



  			<?php } ?>	

  	<input type="hidden" id="selected_staffid" value="<?php echo isset($staffid)?$staffid:'-1'; ?>" name="selected_staffid">

  	<input type="hidden" id="todate" value="<?php echo date('m/d/Y') ?>">

  		<div class="col-md-3">
                      <input type="text" class="form-control" name="calendar_start_date" id="calendar_start_date" data-date-today-highlight="true" data-plugin="datepicker" autocomplete="off"  value="<?php echo isset($startDate)?$startDate:date('m/d/Y'); ?>">
                      <div class="admin_content_error"></div>				   
  			</div>

  			<div class="col-md-3">
  				<button class="btn btn-primary waves-effect waves-classic" id="submit_date" data-dismiss="modal" type="button">Go To Date</button>
  			</div>
      	</div>
      	<div class="row" style="margin-top: 19px;position: absolute;">
      		<div class="col-md-3">
      			<button class="btn btn-primary waves-effect waves-classic" type="button" onclick="getToday()" data-dismiss="modal" type="button">Today ( <?php echo date('l'); ?> )</button>
      		
			</div>
      	</div>
      </div>
        <div class="calendar-container">
          <div id="calendar"></div>
          <div class="not-found" style="display: none; height:-webkit-fill-available">
          	<h1 class="text-center"><i style="font-size: 70px;" class="fa fa-frown-o"></i><br>No Scheduled Staff</h1>
          	<p class="text-center">There are no staff working on this day, switch to the all staff view instead.</p>
          </div>
        </div>
        <div class="container">
        	<div class="text-center">
        		<span class="sbox" style="background-color: #F4F7F8"></span><span class="stext">&nbsp;Available Slots</span>
        		<span class="sbox" style="background-color: #AAACAD"></span><span class="stext">&nbsp;Not Available Slots</span>
        		<span class="sbox" style="background-color:<?=($calendar_setting['new_appointment_color'])?$calendar_setting['new_appointment_color']:"#0096FB";?>"></span><span class="stext">&nbsp;New Appointment&nbsp;</span>
        		<span class="sbox" style="background-color:<?=($calendar_setting['completed_appointment_color'])?$calendar_setting['completed_appointment_color']:"#999895";?>"></span><span class="stext">&nbsp;Completed&nbsp;</span>
        		<span class="sbox" style="background-color:<?=($calendar_setting['noshow_appointment_color'])?$calendar_setting['noshow_appointment_color']:"#E84C3D";?>"></span><span class="stext">&nbsp;No Show</span>
        		<span class="sbox" style="background-color:<?=($calendar_setting['arrived_appointment_color'])?$calendar_setting['arrived_appointment_color']:"#0096FB";?>"></span><span class="stext">&nbsp;Arrived</span>
        		<span class="sbox" style="background-color:<?=($calendar_setting['confirmed_appointment_color'])?$calendar_setting['confirmed_appointment_color']:"#0096FB";?>"></span><span class="stext">&nbsp;Confirmed</span>
        		<span class="sbox" style="background-color:<?=($calendar_setting['reconfirmed_appointment_color'])?$calendar_setting['reconfirmed_appointment_color']:"#0096FB";?>"></span><span class="stext">&nbsp;Re-Confirmed</span>
        		<span class="sbox" style="background-color:<?=($calendar_setting['started_appointment_color'])?$calendar_setting['started_appointment_color']:"#0096FB";?>"></span><span class="stext">&nbsp;Started</span>
        	</div>
        </div>
      </div>
    </div>
<input type="hidden" class="default_view" value="<?php echo ($this->session->userdata('default_view'))?$this->session->userdata('default_view'):"agendaDay"; ?>" name="">    
  <!-- End page -->
<!-- Modal -->
<div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale" aria-hidden="true"
  aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">New Blocked Time</h4>
      </div>
      <div class="modal-body block_time">
        
      </div> 
    </div>
  </div>
</div>
<!-- End Modal -->
<!-- Modal -->
<div class="modal fade modal-fade-in-scale-up" id="rebook_modal" aria-hidden="true"
  aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Re-Booking Notification</h4>
      </div>
      <div class="modal-body" style="text-align:center;">
        <b> Please select required date & staff for re-booking!</b>
      </div> 
    </div>
  </div>
</div>
<!-- End Modal -->
<?php $this->load->view('admin/common/footer_calendar'); ?>
<script language="javascript">

$(document).ready(function(){
	
	var booking_id = getUrlParameter('booking_id');
	if(booking_id){
		$('#rebook_modal').modal('show');
	}else{
		//$('#rebook_modal').modal('hide');
	}
	var location_id = $(".location_id").val();	
	get_staff_by_location(location_id);
	var calendar_start_date = $("#calendar_start_date").val();
	var startDate = moment(calendar_start_date);	
	staff_id = $(".staff").val();
	default_view = $(".default_view").val();
	$('#calendar').fullCalendar('gotoDate', startDate);
	RenderCalendar(location_id,staff_id,default_view);
	//alert(default_view);
	//var location_id = $(".location_id").val();
//	var calendar_start_date = $("#calendar_start_date").val();
	//alert(calendar_start_date);
	//get_staff_by_location(location_id);
	
	//staff_id = $(".staff").val();

	//var startDate = moment(calendar_start_date);	
	//$('#calendar').fullCalendar('gotoDate', startDate);
	//default_view = $(".default_view").val();
	//RenderCalendar(location_id,staff_id,default_view);
	//getToday();
});

/*$('#location_id').Change(function(){
	
	var location_id = $(".location_id").val();	
	get_staff_by_location(location_id);
	
	
});*/

$(".location_id").change(function () {
   var location_id = $(".location_id").val();	
	get_staff_by_location(location_id);
});

$('#submit_date').click(function(){
	var location_id = $(".location_id").val();	
	get_staff_by_location(location_id);
	var calendar_start_date = $("#calendar_start_date").val();
	var startDate = moment(calendar_start_date);	
	$('#calendar').fullCalendar('gotoDate', startDate);
	
});



function getToday(){
	location_id = $(".location_id").val();
	staff_id = $(".staff").val(); 
	default_view = $(".default_view").val();
	if(staff_id==0){
		default_view = "agendaDay";
	}
	$('#calendar').fullCalendar('destroy');
	todate=1;
	RenderCalendar(location_id,staff_id,default_view,todate);
}
//fetching url parameters
function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
//var location_id = $(".location_id").val();   
//var staff_id = $(".staff").val();  
function RenderCalendar(location_id,staff_id=0,default_view,todate=0,allowShow=true) {	
	var calendar_start_date = $("#calendar_start_date").val();
	var startDate = moment(calendar_start_date);
	if (todate>0) {		
		var calendar_start_date = $("#todate").val();
	var startDate = moment(calendar_start_date);
	}

	//alert(startDate);
	var allowEdit = true;
	
	var sduration = "<?php echo ($calendar_setting['time_slot_interval'])?$calendar_setting['time_slot_interval']:'00:15:00'; ?>";
	var split = sduration.split(":");
	Pace.restart();
	 $('#calendar').fullCalendar({
	 	editable: true,
		eventDurationEditable:false,
	 	slotDuration:"<?php echo ($calendar_setting['time_slot_interval'])?$calendar_setting['time_slot_interval']:'00:15:00'; ?>",
	 	minTime:"<?php echo ($calendar_setting['start_time'])?$calendar_setting['start_time']:'09:00:00'; ?>", 
	    header: {
		  //left: 'today',
		  left: null,
		  center: 'prev,title,next',
		  right: 'agendaWeek,agendaDay'
	    },
	     titleFormat: 'dddd - DD MMMM, YYYY',
	     /*titleFormat: {
		  day: 'MMMM YYYY',
	    },*/
		views: {
	        agendaDay: {
	          type: 'agenda',
	          duration: { days: 1 }, 
	        }
	      }, 	  
		  resources: function(callback) {
		  	setTimeout(function() {
		    var view = $('#calendar').fullCalendar('getView'); // TODO: update to your selector
		   // alert(callback);
		   // alert("hi");
		    $.ajax({
		        url: site_url + 'admin/Operations/getStaff',
		        dataType: 'json',
		        type:"POST",
		        cache: false,
		        data: {
		            start: view.start.format(),
		            end: view.end.format(),
		            timezone: view.options.timezone,
		            location_id:location_id,
		        	staff_id:staff_id
		        },
		        success:function(response){ 
		       // alert(response); 

		        	callback(response);
		        	$(".fc-agendaDay-view").show();
		        	$(".not-found").hide();
		        },
		        error:function(){
		        	//swal("Error","No Working Staff found for this date","error");
		        	$(".fc-agendaDay-view").hide();
		        	$(".not-found").show();
		        }
		    });
			},0);
		},


	   // defaultDate: new Date(),
	   defaultDate: startDate,


	    selectable: true,
	    allDayDefault:false,
	    allDaySlot: false,
	    eventSources: [
		    {

		      url: site_url + 'admin/service/all_event_data',
		      type: 'POST',
		      cache: false,
        	  lazyFetching:true,
		      data: {
		        location_id:location_id,
		        staff_id:staff_id
		      },
		        

		      error: function() {
		      	//alert(data);
		        alert('there was an error while fetching events!');
		      }   //color: '#00B3F0',   // a non-ajax option
		      //textColor: '#000000' // a non-ajax option

		    }
		],
		eventRender: function(eventObj, $el) {	
			var amt = "";
			var contentall="";
			if(eventObj.type=="event"){
				if(eventObj.nstatus==1){
					var popup_header = "popup_header_default";
				}else if(eventObj.nstatus==3){
					var popup_header = "popup_header_completed";
				}else if(eventObj.nstatus==4){
					var popup_header = "popup_header_noshow";
				}else{
					var popup_header = "popup_header_default";
				}
				if(eventObj.amount_ouststanding !=null){
					amt = "<br><div><b><span class='badge badge-warning'>$"+eventObj.amount_ouststanding+" UNPAID</span></b></div><br>"
				}
				if(allowShow){
			      $el.popover({
			        //title: eventObj.title,
			         
			        	
			        content:'<div class="cal-pop"><div class="'+popup_header+'">'+eventObj.status+'</div><div class="pop-content"><div class="cname"><b style="margin-bottm:0px;">'+eventObj.customer_name+'</b></div>'+eventObj.customer_number+'<br>'+amt+'<div class="ptext">'+eventObj.title+'</div><hr class="hr"><div class="ptext">'+eventObj.start_time+'&nbsp;-&nbsp;'+eventObj.end_time+'</div><hr class="hr"><div class="ptext">'+eventObj.staff+'</div><hr class="hr"><div class="ptext">$'+eventObj.price+'</div></div></div>',



			        trigger: 'hover',
			        placement: 'right',
			        container: 'body',
			        html:true
			      });
			  	}
			}else{
				var popup_header = "popup_header_blocked";
				if(allowShow){
					$el.popover({
				        //title: eventObj.title,	
				        content: '<div class="cal-pop"><div class="'+popup_header+'">'+eventObj.status+'</div><div class="pop-content"><div class="ptext">'+eventObj.start_time+'&nbsp;-&nbsp;'+eventObj.end_time+'</div><hr class="hr"><p>'+eventObj.description+'</p></div></div>',
				        trigger: 'hover',
				        placement: 'right',
				        container: 'body',
				        html:true
				      });
				}
			}
	    },
	    eventDragStop: function() {
        	allowEdit = true;
        	allowShow = false;
        },
        eventDragStart:function(){
        	allowEdit = false;
        	allowShow = false;
        },
        eventDrop:function(event, delta, revertFunc, jsEvent, ui, view){
        	//console.log(event);
        	if(event.nstatus==3){
        		revertFunc();
        		$('#calendar').fullCalendar('destroy');
				var default_view = $(".default_view").val();
				RenderCalendar(location_id,staff_id,default_view);
				allowShow = true;
        		swal("Error","Completed Appointment could not be rescheduled","error");
        	}else if(event.type=="blocked_time"){
        		revertFunc();
        		$('#calendar').fullCalendar('destroy');
				var default_view = $(".default_view").val();
				RenderCalendar(location_id,staff_id,default_view);
				allowShow = true;
        		swal("Error","Blocked time could not be rescheduled","error");
        	}else{
	        	allowShow = false;
	        	start = event.start.format();
	        	end = event.end.format();
	        	resourceId = event.resourceId;
	        	event_id = event.id;
	        	booking_service_id = event.booking_service_id;
	        	$.ajax({
		        	url: site_url + 'admin/service/updateCalendarBooking',
				    type: 'POST',
				    data:{
				    	start:start,
				        end:end,
				        resourceId:resourceId,
				        event_id:event_id,
				        booking_service_id:booking_service_id
				    },
				    success:function(response){
				    	data = JSON.parse(response);
				    	if(data.type=="success"){
				    		//$('#calendar').fullCalendar('destroy');
							var default_view = $(".default_view").val();
							//RenderCalendar(location_id,staff_id,default_view);
							allowShow = true;
							//swal("Success","Appointment rescheduled","success");						
				    	}
				    }
				});
			} 
        },  			    
	  defaultView: default_view, 
	  nowIndicator:true,
      select: function select(start, end,event, view, resource) {
      	//alert(end);
      	var shh = $.fullCalendar.moment(start).format("HH:mm:ss");

      	var ehh = $.fullCalendar.moment(end).format("HH:mm:ss");
      	var startDate = $.fullCalendar.moment(end).format('YYYY/MM/DD');
      	var startTime = new Date(startDate+' '+shh); 
		var endTime = new Date(startDate+' '+ehh);
		var difference = endTime.getTime() - startTime.getTime(); // This will give difference in milliseconds
		var resultInMinutes = Math.round(difference / 60000);      
      	if(parseInt(split[1])==resultInMinutes){
	      	var location_id = $(".location_id").val();
	      	if(location_id==''){
	      		swal("Error","Choose a location first","error");
	      	}
	      	if(resource !=undefined){
	        	var staff_id =	resource.id;
	        }else{
	        	var staff_id = $(".staff").val();
	        	if(staff_id=="" || staff_id==null || staff_id==0){
	        		swal("Error","Choose a staff first","error");
	        	}
	        }
	        if(staff_id!="" && location_id !='' && staff_id!=null && allowEdit==true && staff_id!=0){
	        	//alert(start);
		      	var startDate = $.fullCalendar.moment(start).format('YYYY/MM/DD');
		      	
		      	//var startTime = $.fullCalendar.moment(end).subtract(10, 'minutes').format('HH:mm:ss');
		      	var startTime = $.fullCalendar.moment(start).format('HH:mm:ss');
		      //	alert(startTime);
			  var booking_id = getUrlParameter('booking_id');
				if(booking_id){
					location.href= base_url+'admin/service/calendar_rebook/'+booking_id+'?startDate='+startDate+'&startTime='+startTime+'&staffid='+staff_id+'&location_id='+location_id;			
				}else{
					location.href= base_url+'admin/service/calendar_set?startDate='+startDate+'&startTime='+startTime+'&staffid='+staff_id+'&location_id='+location_id;			
				}
			}
			return false;
		}else{
			var location_id = $(".location_id").val();
			if(location_id==''){
	      		swal("Error","Choose a location first","error");
	      	}
	      	if(resource !=undefined){
	        	var staff_id =	resource.id;
	        }else{
	        	var staff_id = $(".staff").val();
	        	if(staff_id=="" || staff_id==null || staff_id==0){
	        		swal("Error","Choose a staff first","error");
	        	}
	        }
	        if(staff_id!="" && location_id !='' && staff_id!=null && staff_id!=0){
	        	Pace.restart();
	        	$.ajax({
		        	url: site_url + 'admin/service/add_busy_time',
				    type: 'POST',
				    data:{
				    	start:$.fullCalendar.moment(start).format("HH:mm:ss"),
				        end:$.fullCalendar.moment(end).format("HH:mm:ss"),
				        staff_id:staff_id,
				        date: $.fullCalendar.moment(start).format('YYYY-MM-DD'),
				        location_id:location_id
				    },
				    success:function(response){
				    	data = JSON.parse(response);
				    	$(".block_time").html(data.html);
				    	$("#exampleNiftyFadeScale").modal("show");
				    	$('.b_date').datepicker({
				    		format: 'yyyy-mm-dd'
				    	});
				    }
				});
	        }
	        return false;
      	}	
	  },
	  eventClick: function(calEvent, jsEvent, view) {
	  	if(calEvent.type=="event"){
	  		//console.log(calEvent);
	  		location.href= base_url+'admin/service/calendar_view/'+calEvent.id;	
	  	}else{
	  		$.ajax({
	        	url: site_url + 'admin/service/add_busy_time/'+calEvent.id,
			    type: 'POST',
			    success:function(response){
			    	data = JSON.parse(response);
			    	$(".block_time").html(data.html);
			    	$("#exampleNiftyFadeScale").modal("show");
			    	$('.b_date').datepicker({
			    		format: 'yyyy-mm-dd'
			    	});
			    }
			});
	  	}
	  },
	  	  
	}).on('click', '.fc-month-button', function() {
		setsession("month");
	}).on('click', '.fc-agendaWeek-button', function() {
		setsession("agendaWeek");
	}).on('click', '.fc-agendaDay-button', function() {
		setsession("agendaDay");
	}).on('click','.fc-prev-button',function(){
		//var view = $('#calendar').fullCalendar('getView');
		//var startDate = view.start.format();
		Pace.restart();
		$('#calendar').fullCalendar( 'refetchResources' );
	}).on('click','.fc-next-button',function(){
		//var view = $('#calendar').fullCalendar('getView');
		//var startDate = view.start.format();
		Pace.restart();
		$('#calendar').fullCalendar( 'refetchResources');
	});
	AppCalendar.run();
}	
	//AppCalendar.run();

function get_staff_by_location(location_id) {
	//alert("hi");
	var location_id = location_id;   
	var staff_id = $(".staff").val(); 
	var selected_staffid = $("#selected_staffid").val();
	//alert(staff_id);
	if(location_id=='')
		return false;
	$.ajax({
			type: 'POST',
			url: site_url + 'admin/Operations/getAllStaffByLocation/',
			data:{
				location_id:location_id,
				selected_staffid:selected_staffid,
				staff_id:staff_id,
			},
			datatype: 'json',
			success: function(data)
			{
				//alert(data);
			   data = JSON.parse(data);
				if (data.status == 'not_logged_in') {
					location.href= site_url + 'admin'
				}else if(data.status == 'success') {
					$('#content_staff').html(data.staff_html);
				}
			}
		}); 
	$('#calendar').fullCalendar('destroy');
	var default_view = $(".default_view").val();
	if(staff_id==0){
		default_view = "agendaDay";
	}
	RenderCalendar(location_id,staff_id,default_view);
	$(".fc-agendaDay-view").show();
	$(".not-found").hide();
}

function selectStaff(staff_id){
	var location_id = $(".location_id").val();	
	$('#calendar').fullCalendar('destroy');
	var default_view = $(".default_view").val();
	if(staff_id==0){
		default_view = "agendaDay";
	}
	//alert(default_view);
	RenderCalendar(location_id,staff_id,default_view);
	$(".fc-agendaDay-view").show();
	$(".not-found").hide();
}

function setsession(key){
	//alert(key)
	$.ajax({
		type: 'POST',
		url: site_url + 'admin/service/setsession/' + encodeURIComponent(key),
		datatype: 'json',
		success: function(data)
		{
		}
	}); 
}

function addBusyTime(){
	Pace.restart();
	var formData = $("#add_busy_time_form").serializeArray();
	$.ajax({
		type: 'POST',
		url: site_url + 'admin/service/save_busy_time',
		data:formData,
		success: function(response)
		{
			$("#exampleNiftyFadeScale").modal("hide");
			var location_id = $(".location_id").val();
			var staff_id = $(".staff").val();
			$('#calendar').fullCalendar('destroy');
			var default_view = $(".default_view").val();
			if(staff_id==0){
				default_view = "agendaDay";
			}
			RenderCalendar(location_id,staff_id,default_view);
		}
	})
	return false;
}

function deleteBusytime(id){
	Pace.restart();
	$.ajax({
		type: 'get',
		url: site_url + 'admin/service/delete_busy_time/'+id,
		success: function(response)
		{
			$("#exampleNiftyFadeScale").modal("hide");
			var location_id = $(".location_id").val();
			var staff_id = $(".staff").val();
			$('#calendar').fullCalendar('destroy');
			var default_view = $(".default_view").val();
			if(staff_id==0){
				default_view = "agendaDay";
			}
			RenderCalendar(location_id,staff_id,default_view);
		}
	})
}
</script>

 
 